<?php
/**
 * HIFI11 Academy - Shared Helper Functions
 */

/** Escape output for safe HTML rendering */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/** Generate (or reuse) a CSRF token for the current session */
function csrfToken(): string
{
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/** Output a hidden CSRF input field */
function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrfToken()) . '">';
}

/** Validate a submitted CSRF token, halting the request if invalid */
function verifyCsrf(): void
{
    $submitted = $_POST['csrf_token'] ?? '';
    if (empty($_SESSION[CSRF_TOKEN_NAME]) || !hash_equals($_SESSION[CSRF_TOKEN_NAME], $submitted)) {
        http_response_code(419);
        die('Your session has expired. Please refresh the page and try again.');
    }
}

/** Basic email validation */
function isValidEmail(string $email): bool
{
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

/** Basic Indian mobile number validation (10 digits, optionally +91) */
function isValidMobile(string $mobile): bool
{
    $mobile = preg_replace('/[^0-9]/', '', $mobile);
    return (bool) preg_match('/^([6-9][0-9]{9})$/', substr($mobile, -10)) && strlen($mobile) >= 10;
}

/** Is a customer currently logged in? */
function isLoggedIn(): bool
{
    return !empty($_SESSION['customer_id']);
}

/** Force login — redirect to login.php if not authenticated */
function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

/** Fetch the logged-in customer's row, or null */
function currentCustomer(): ?array
{
    if (!isLoggedIn()) {
        return null;
    }
    $stmt = getDB()->prepare('SELECT * FROM customers WHERE id = ? LIMIT 1');
    $stmt->execute([$_SESSION['customer_id']]);
    $row = $stmt->fetch();
    return $row ?: null;
}

/** Format a rupee amount, e.g. 199 -> ₹199 */
function formatRupees($amount): string
{
    return '₹' . number_format((float) $amount, 0);
}

/** Format a date nicely, e.g. 15 Jul 2026 */
function formatDate(string $datetime): string
{
    $ts = strtotime($datetime);
    return $ts ? date('d M Y', $ts) : '';
}
