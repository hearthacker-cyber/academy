<?php
/**
 * download-file.php
 * ===================
 * The ONLY place in the application that reads bundle bytes off disk
 * and sends them to a browser. It re-runs the full authorization
 * checklist itself — it does not trust that the request "came from"
 * download.php, because an attacker can hit this URL directly.
 *
 * Checklist enforced (via authorizeDownload(), see includes/downloads.php):
 *   1. Customer session exists            -> else redirect to login
 *   2. Customer is authenticated          -> else redirect to login
 *   3. Token belongs to this customer     -> else 403
 *   4. Token is valid (exists, not revoked) -> else 403
 *   5. Token has not expired               -> else 403
 *   6. Download limit not exceeded         -> else 403
 *   7. Customer owns this purchase         -> else 403
 *   8. Payment status is "paid"            -> else 403
 *   9. Resolved file exists safely inside SECURE_STORAGE_PATH -> else 404
 *
 * The real filesystem path is never sent to the browser or put in any
 * URL — only Content-Disposition's filename (just a name, not a path).
 */

require_once __DIR__ . '/config/config.php';

// Rule: anyone hitting this page without being logged in is sent to
// login — never shown a 403 (403 would confirm the token format is
// even being looked at; a login redirect is the standard, uninformative response).
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$customerId = (int) $_SESSION['customer_id'];
$token = trim($_GET['token'] ?? '');

$auth = authorizeDownload($token, $customerId);

if (!$auth['ok']) {
    http_response_code($auth['http_code']);
    header('Content-Type: text/plain; charset=UTF-8');
    // Deliberately generic message — don't reveal *why* (wrong owner vs
    // expired vs not paid) to avoid helping someone probe for valid tokens.
    echo $auth['http_code'] === 404
        ? "404 Not Found\nThe requested file could not be located."
        : "403 Forbidden\nYou are not authorized to download this file.";
    exit;
}

$filePath = $auth['file_path'];
$order = $auth['order'];
$version = $auth['version'];

// Log the download and consume one unit of the token's allowance
// BEFORE streaming, so a connection drop mid-transfer still counts
// (matches how most paid-download platforms behave).
recordDownload($auth['token_id'], $customerId, (int) $order['id'], (string) $version['version']);

// ---- Stream the file ----
while (ob_get_level() > 0) {
    ob_end_clean();
}

$downloadName = 'HIFI11-Bundle-' . preg_replace('/[^A-Za-z0-9_.-]/', '', (string) $version['version']) . '.zip';

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $downloadName . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($filePath));
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');
header('X-Content-Type-Options: nosniff');

// readfile() streams the file directly to output without loading the
// whole thing into PHP's memory — safe for large ZIPs.
readfile($filePath);
exit;
