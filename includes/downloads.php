<?php
/**
 * includes/downloads.php
 * =========================================================
 * Everything related to secure, DB-backed download tokens and the
 * authorization middleware that gates access to the actual bundle
 * file. This is intentionally separate from the payment gateway module —
 * it has nothing to do with payments, only with "who is allowed to
 * download the file right now".
 *
 * Design:
 *  - Tokens are 64 random bytes (128 hex chars), generated with
 *    random_bytes() — cryptographically secure, not guessable.
 *  - Only the SHA-256 hash of the token is ever stored in the DB.
 *    The raw token exists only in the URL / session, briefly.
 *  - A token is permanently bound to one customer_id + one order_id.
 *  - Every check runs on EVERY request to the file-streaming
 *    endpoint (download-file.php) — never trust that a request
 *    arrived "the right way" just because it came from download.php.
 */

/**
 * issueDownloadToken()
 * Mints a brand-new random download token for a customer's paid
 * order and stores its hash in the database.
 *
 * @param int $customerId
 * @param int $orderId
 * @param int $maxDownloads 0 = unlimited
 * @return string the RAW token (put this in the URL — never store it)
 */
function issueDownloadToken(int $customerId, int $orderId, int $maxDownloads = 0): string
{
    $rawToken = bin2hex(random_bytes(64)); // 128 hex chars of real entropy
    $tokenHash = hash('sha256', $rawToken);
    $expiresAt = date('Y-m-d H:i:s', time() + DOWNLOAD_TOKEN_TTL);

    $stmt = getDB()->prepare(
        'INSERT INTO download_tokens (customer_id, order_id, token_hash, max_downloads, expires_at, created_at)
         VALUES (?, ?, ?, ?, ?, NOW())'
    );
    $stmt->execute([$customerId, $orderId, $tokenHash, $maxDownloads, $expiresAt]);

    return $rawToken;
}

/**
 * authorizeDownload()
 * The single authorization checkpoint for every download request.
 * Runs ALL required checks and returns a structured result — it never
 * serves the file itself, so both download.php (info page) and
 * download-file.php (byte stream) can share the exact same logic.
 *
 * Checks performed (in order):
 *   1. A customer is logged in (session)               -> caller's job via requireLogin(), re-checked here
 *   2. Token is syntactically present
 *   3. Token exists, is not revoked, is not expired
 *   4. Token belongs to the logged-in customer          -> 403 if not
 *   5. Download limit not exceeded                      -> 403 if reached
 *   6. The linked order belongs to this customer         -> 403 if not
 *   7. The linked order's payment status is "paid"        -> 403 if not
 *   8. The bundle version file exists on disk and resolves
 *      safely inside SECURE_STORAGE_PATH (no path traversal)
 *
 * @return array{
 *   ok: bool, http_code: int, reason: string,
 *   token_id?: int, customer_id?: int, order?: array, version?: array, file_path?: string
 * }
 */
function authorizeDownload(string $rawToken, int $sessionCustomerId): array
{
    if (!isLoggedIn() || $sessionCustomerId <= 0) {
        return ['ok' => false, 'http_code' => 401, 'reason' => 'not_authenticated'];
    }

    if ($rawToken === '') {
        return ['ok' => false, 'http_code' => 403, 'reason' => 'missing_token'];
    }

    $db = getDB();
    $tokenHash = hash('sha256', $rawToken);

    $stmt = $db->prepare('SELECT * FROM download_tokens WHERE token_hash = ? LIMIT 1');
    $stmt->execute([$tokenHash]);
    $tokenRow = $stmt->fetch();

    if (!$tokenRow) {
        error_log("authorizeDownload: unknown token presented by customer #$sessionCustomerId");
        return ['ok' => false, 'http_code' => 403, 'reason' => 'invalid_token'];
    }

    if ($tokenRow['revoked_at'] !== null) {
        return ['ok' => false, 'http_code' => 403, 'reason' => 'token_revoked'];
    }

    if (strtotime($tokenRow['expires_at']) < time()) {
        return ['ok' => false, 'http_code' => 403, 'reason' => 'token_expired'];
    }

    // Token must belong to the customer making the request — this is
    // what stops "I have someone else's link" attacks even though the
    // token itself is otherwise valid and unexpired.
    if ((int) $tokenRow['customer_id'] !== $sessionCustomerId) {
        error_log("authorizeDownload: token owned by customer #{$tokenRow['customer_id']} presented by customer #$sessionCustomerId");
        return ['ok' => false, 'http_code' => 403, 'reason' => 'token_wrong_customer'];
    }

    if ((int) $tokenRow['max_downloads'] > 0 && (int) $tokenRow['download_count'] >= (int) $tokenRow['max_downloads']) {
        return ['ok' => false, 'http_code' => 403, 'reason' => 'download_limit_reached'];
    }

    // Re-verify the order itself: belongs to this customer AND is paid.
    // (Defense in depth — even if the token row were somehow wrong,
    // this independently re-derives authorization from the orders table.)
    $orderStmt = $db->prepare('SELECT * FROM orders WHERE id = ? AND customer_id = ? LIMIT 1');
    $orderStmt->execute([$tokenRow['order_id'], $sessionCustomerId]);
    $order = $orderStmt->fetch();

    if (!$order) {
        return ['ok' => false, 'http_code' => 403, 'reason' => 'order_not_owned'];
    }

    if ($order['status'] !== 'paid') {
        return ['ok' => false, 'http_code' => 403, 'reason' => 'order_not_paid'];
    }

    // Resolve the bundle file (current version) and make sure it
    // actually exists inside the secure storage directory.
    $verStmt = $db->prepare('SELECT * FROM bundle_versions WHERE is_current = 1 ORDER BY released_at DESC LIMIT 1');
    $verStmt->execute();
    $version = $verStmt->fetch();

    if (!$version || empty($version['file_path'])) {
        error_log('authorizeDownload: no current bundle_versions row with a file_path');
        return ['ok' => false, 'http_code' => 404, 'reason' => 'bundle_not_configured'];
    }

    $resolved = resolveSecureFilePath($version['file_path']);
    if ($resolved === false) {
        error_log('authorizeDownload: file_path failed to resolve safely: ' . $version['file_path']);
        return ['ok' => false, 'http_code' => 404, 'reason' => 'file_missing'];
    }

    return [
        'ok'          => true,
        'http_code'   => 200,
        'reason'      => 'ok',
        'token_id'    => (int) $tokenRow['id'],
        'customer_id' => $sessionCustomerId,
        'order'       => $order,
        'version'     => $version,
        'file_path'   => $resolved,
    ];
}

/**
 * resolveSecureFilePath()
 * Resolves a bundle_versions.file_path value to a real, on-disk path
 * inside SECURE_STORAGE_PATH, rejecting anything that would escape
 * that directory (path traversal via "../", absolute paths, symlinks
 * pointing outside, etc). Returns false if the file doesn't safely
 * resolve inside the storage root or doesn't exist.
 */
function resolveSecureFilePath(string $relativePath)
{
    $base = realpath(SECURE_STORAGE_PATH);
    if ($base === false) {
        error_log('resolveSecureFilePath: SECURE_STORAGE_PATH does not exist: ' . SECURE_STORAGE_PATH);
        return false;
    }

    $candidate = realpath($base . DIRECTORY_SEPARATOR . ltrim($relativePath, '/\\'));
    if ($candidate === false || !is_file($candidate)) {
        return false;
    }

    // Ensure the resolved real path is still inside $base (blocks "../../etc/passwd" style traversal)
    if (strpos($candidate, $base . DIRECTORY_SEPARATOR) !== 0 && $candidate !== $base) {
        return false;
    }

    return $candidate;
}

/**
 * recordDownload()
 * Logs a completed, authorized download and increments the token's
 * usage counter. Call this ONLY after authorizeDownload() succeeded
 * and right before streaming the file.
 */
function recordDownload(int $tokenId, int $customerId, int $orderId, string $bundleVersion): void
{
    $db = getDB();

    $log = $db->prepare(
        'INSERT INTO download_logs (customer_id, order_id, token_id, bundle_version, ip_address, user_agent, created_at)
         VALUES (?, ?, ?, ?, ?, ?, NOW())'
    );
    $log->execute([
        $customerId,
        $orderId,
        $tokenId,
        $bundleVersion,
        $_SERVER['REMOTE_ADDR'] ?? '',
        substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
    ]);

    $upd = $db->prepare('UPDATE download_tokens SET download_count = download_count + 1 WHERE id = ?');
    $upd->execute([$tokenId]);
}
