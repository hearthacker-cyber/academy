<?php
/**
 * HIFI11 Academy - Global Configuration
 * =======================================
 * Central place for site-wide constants.
 * Do NOT put database credentials here — see config/database.php
 */

// ---- Environment ----
error_reporting(E_ALL);
ini_set('display_errors', '0'); // set to '1' only while debugging locally
date_default_timezone_set('Asia/Kolkata');

// ---- Site Info ----
define('SITE_NAME', 'HIFI11 Academy');
define('SITE_TAGLINE', 'Premium Digital Bundle Pack');
define('SITE_URL', 'https://academy.hifi11.in');
define('SUPPORT_EMAIL', 'academy@hifi11.in');
define('SUPPORT_WHATSAPP', '919380386500');
define('SUPPORT_TELEGRAM', 'https://t.me/devil_heart_hack');
define('SUPPORT_INSTAGRAM', 'https://instagram.com/_devil_heart_hacker');

// ---- Fast2SMS ----
define('FAST2SMS_API_KEY', 'zPDa2j0X7VvRlTsn6IMUOcWJ49tHBpreQGfCiSbyuLFg5q8KwmaQ4wB8MzWAK3Smt5sRTVvfhULycFXH');

// ---- Product Info ----
define('PRODUCT_NAME', 'Ethical Hacking Bundle Pack');
define('PRODUCT_PRICE', 1);       // INR — offer price (set to 1 for testing)
define('PRODUCT_VALUE', 15000);     // INR — "worth" value shown to customer
define('PRODUCT_CURRENCY', 'INR');
define('PRODUCT_VERSION', 'v1.0');

// ---- Security ----
define('CSRF_TOKEN_NAME', 'hifi11_csrf_token');
define('SESSION_NAME', 'hifi11_session');
define('DOWNLOAD_TOKEN_TTL', 60 * 60 * 24); // 24 hours validity per generated download link
define('DOWNLOAD_MAX_COUNT', 10); // 0 = unlimited downloads per token; 10 matches the "10 downloads" option

// ---- Secure file storage ----
// This directory MUST live outside the public web root so nothing
// under it is ever reachable by a direct URL, regardless of server
// config. __DIR__ is config/, so dirname(__DIR__) is the document root.
define('SECURE_STORAGE_PATH', dirname(__DIR__) . '/hifi11-secure-storage');

// ---- Session bootstrap ----
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'cookie_secure' => true,
    ]);
}

// ---- Autoload core includes ----
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/cashfree.php';
require_once __DIR__ . '/../includes/downloads.php';
