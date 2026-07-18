<?php
/**
 * HIFI11 Academy - Database Connection (PDO)
 * =============================================
 * TODO: Replace the placeholder credentials below with your real
 * hosting/database credentials before going live.
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'u329947844_academy');
define('DB_USER', 'u329947844_academy');
define('DB_PASS', 'Academy123@@');
define('DB_CHARSET', 'utf8mb4');

/**
 * getDB() - returns a shared PDO instance (singleton pattern)
 */
function getDB(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Never leak DB details to the customer-facing screen
            error_log('DB Connection Error: ' . $e->getMessage());
            http_response_code(500);
            die('We are experiencing a temporary issue. Please try again shortly.');
        }
    }

    return $pdo;
}
