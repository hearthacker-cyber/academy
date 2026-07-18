<?php

require_once __DIR__ . '/config/config.php';

function respond(int $httpCode, array $body): void
{
    http_response_code($httpCode);
    header('Content-Type: application/json');
    echo json_encode($body);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    respond(405, ['success' => false, 'message' => 'Method not allowed.']);
}

$cashfreeOrderId = trim($_GET['order_id'] ?? '');

if ($cashfreeOrderId === '') {
    respond(400, ['success' => false, 'message' => 'Missing order reference from the payment gateway.']);
}

if (empty($_SESSION['checkout']['order_id'])) {
    respond(400, ['success' => false, 'message' => 'No pending checkout found. Please start again.']);
}

$checkout = $_SESSION['checkout'];

if (!hash_equals($checkout['order_id'], $cashfreeOrderId)) {
    error_log('verify_payment.php: order id mismatch. session=' . $checkout['order_id'] . ' received=' . $cashfreeOrderId);
    respond(400, ['success' => false, 'message' => 'Order mismatch. Please start checkout again.']);
}

$verified = verifyPayment($cashfreeOrderId);

if (!$verified) {
    error_log('verify_payment.php: payment verification FAILED for order ' . $cashfreeOrderId);
    $htmlError = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Payment Failed</title>';
    $htmlError .= '<meta http-equiv="refresh" content="3;url=checkout.php?failed=1">';
    $htmlError .= '<style>body{background:#0a0a0f;color:#E6EDF3;font-family:sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;text-align:center;}</style>';
    $htmlError .= '</head><body><div>';
    $htmlError .= '<h2>Payment Not Completed</h2>';
    $htmlError .= '<p>Your payment could not be verified. If any amount was deducted, it will be refunded automatically.</p>';
    $htmlError .= '<p>Redirecting to checkout…</p>';
    $htmlError .= '</div></body></html>';
    echo $htmlError;
    exit;
}

try {
    $result = paymentSuccess(
        [
            'name'   => $checkout['full_name'],
            'email'  => $checkout['email'],
            'mobile' => $checkout['mobile'],
        ],
        [
            'order_id'   => $cashfreeOrderId,
            'payment_id' => $cashfreeOrderId,
            'amount'     => PRODUCT_PRICE,
        ]
    );
} catch (Throwable $e) {
    error_log('verify_payment.php: paymentSuccess() failed: ' . $e->getMessage());
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Processing Error</title>';
    echo '<meta http-equiv="refresh" content="5;url=support.php">';
    echo '<style>body{background:#0a0a0f;color:#E6EDF3;font-family:sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;text-align:center;}</style>';
    echo '</head><body><div>';
    echo '<h2>Order Processing Issue</h2>';
    echo '<p>Your payment was verified but we could not save your order. Please contact support with your order ID: ' . e($cashfreeOrderId) . '</p>';
    echo '<p>Redirecting to support…</p>';
    echo '</div></body></html>';
    exit;
}

$downloadToken = issueDownloadToken($result['customer_id'], $result['order_id'], DOWNLOAD_MAX_COUNT);

$_SESSION['payment_result'] = [
    'order_id'       => $result['order_id'],
    'customer_id'    => $result['customer_id'],
    'full_name'      => $checkout['full_name'],
    'email'          => $checkout['email'],
    'payment_id'     => $cashfreeOrderId,
    'download_token' => $downloadToken,
];

unset($_SESSION['checkout']);

header('Location: payment-success.php');
exit;
