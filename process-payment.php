<?php
require_once __DIR__ . '/config/config.php';

if (empty($_SESSION['checkout']['order_id'])) {
    header('Location: checkout.php');
    exit;
}

$checkout = $_SESSION['checkout'];
$sessionId = $checkout['payment_session_id'] ?? '';

if ($sessionId === '') {
    http_response_code(500);
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Error</title>';
    echo '<style>body{background:#0a0a0f;color:#E6EDF3;font-family:sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;text-align:center;}</style>';
    echo '</head><body><div><h2>Payment Session Error</h2><p>No payment session found. Please try checkout again.</p><a href="checkout.php" style="color:#00FF41;">Back to Checkout</a></div></body></html>';
    exit;
}

$redirectUrl = CASHFREE_PAYMENT_URL . '?payment_session_id=' . urlencode($sessionId);
header('Location: ' . $redirectUrl);
exit;
