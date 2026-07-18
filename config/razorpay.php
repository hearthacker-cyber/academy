<?php

define('CASHFREE_CLIENT_ID', '');
define('CASHFREE_CLIENT_SECRET', '');
define('CASHFREE_API_URL', 'https://sandbox.cashfree.com/pg');
define('CASHFREE_PAYMENT_URL', 'https://payments-sandbox.cashfree.com/checkout/postPayment');
define('CASHFREE_API_VERSION', '2023-08-01');

class CashfreeException extends RuntimeException {}

function cashfreeApiRequest(string $method, string $path, array $payload = []): array
{
    $ch = curl_init(CASHFREE_API_URL . $path);

    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => strtoupper($method),
        CURLOPT_HTTPHEADER     => [
            'x-client-id: ' . CASHFREE_CLIENT_ID,
            'x-client-secret: ' . CASHFREE_CLIENT_SECRET,
            'x-api-version: ' . CASHFREE_API_VERSION,
            'Content-Type: application/json',
        ],
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_CONNECTTIMEOUT => 10,
    ];

    if (!empty($payload)) {
        $options[CURLOPT_POSTFIELDS] = json_encode($payload);
    }

    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    $curlErrno = curl_errno($ch);
    $curlError = curl_error($ch);
    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($curlErrno !== 0) {
        error_log('Cashfree API cURL error: ' . $curlError);
        throw new CashfreeException('Could not reach the payment gateway. Please try again.');
    }

    $decoded = json_decode((string) $response, true);

    if ($httpCode < 200 || $httpCode >= 300) {
        $message = $decoded['message'] ?? 'Payment gateway returned an error.';
        error_log('Cashfree API error (' . $httpCode . '): ' . (string) $response);
        throw new CashfreeException($message);
    }

    if (!is_array($decoded)) {
        error_log('Cashfree API returned invalid JSON: ' . (string) $response);
        throw new CashfreeException('Unexpected response from the payment gateway.');
    }

    return $decoded;
}

function createOrder(int $amountInPaise, string $receiptId, array $customer = []): array
{
    $amountRupees = $amountInPaise / 100;

    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
    $basePath = '';
    if ($requestUri !== '') {
        $uriNoQuery = explode('?', $requestUri)[0];
        $basePath = substr($uriNoQuery, 0, (int) strrpos($uriNoQuery, '/'));
    }
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
        . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost')
        . $basePath;

    $order = cashfreeApiRequest('POST', '/orders', [
        'order_id'         => $receiptId,
        'order_amount'     => $amountRupees,
        'order_currency'   => PRODUCT_CURRENCY,
        'customer_details' => [
            'customer_id'    => $receiptId,
            'customer_name'  => $customer['name'] ?? 'Customer',
            'customer_email' => $customer['email'] ?? 'customer@example.com',
            'customer_phone' => $customer['mobile'] ?? '9999999999',
        ],
        'order_meta' => [
            'return_url' => $baseUrl . '/verify_payment.php?order_id={order_id}',
        ],
    ]);

    if (empty($order['payment_session_id'])) {
        throw new CashfreeException('Payment gateway did not return a session id.');
    }

    return [
        'id'                 => $order['order_id'],
        'cf_order_id'        => $order['cf_order_id'],
        'amount'             => $order['order_amount'] * 100,
        'currency'           => $order['order_currency'],
        'payment_session_id' => $order['payment_session_id'],
        'order_status'       => $order['order_status'],
    ];
}

function verifyPayment(string $orderId): bool
{
    try {
        $order = cashfreeApiRequest('GET', '/orders/' . urlencode($orderId));
        return ($order['order_status'] ?? '') === 'PAID';
    } catch (CashfreeException $e) {
        error_log('verifyPayment: Cashfree order verification failed for ' . $orderId . ': ' . $e->getMessage());
        return false;
    }
}

function paymentSuccess(array $customer, array $paymentData): array
{
    $db = getDB();
    $db->beginTransaction();

    try {
        $stmt = $db->prepare('SELECT id FROM customers WHERE email = ? LIMIT 1');
        $stmt->execute([$customer['email']]);
        $existing = $stmt->fetch();

        if ($existing) {
            $customerId = (int) $existing['id'];
            $upd = $db->prepare('UPDATE customers SET full_name = ?, mobile = ? WHERE id = ?');
            $upd->execute([$customer['name'], $customer['mobile'], $customerId]);
        } else {
            $ins = $db->prepare('INSERT INTO customers (full_name, email, mobile, created_at) VALUES (?, ?, ?, NOW())');
            $ins->execute([$customer['name'], $customer['email'], $customer['mobile']]);
            $customerId = (int) $db->lastInsertId();
        }

        $dupe = $db->prepare('SELECT id FROM orders WHERE razorpay_payment_id = ? LIMIT 1');
        $dupe->execute([$paymentData['payment_id']]);
        $dupeRow = $dupe->fetch();

        if ($dupeRow) {
            $orderId = (int) $dupeRow['id'];
        } else {
            $orderStmt = $db->prepare(
                'INSERT INTO orders (customer_id, razorpay_order_id, razorpay_payment_id, amount, currency, status, created_at)
                 VALUES (?, ?, ?, ?, ?, "paid", NOW())'
            );
            $orderStmt->execute([
                $customerId,
                $paymentData['order_id'],
                $paymentData['payment_id'],
                $paymentData['amount'],
                PRODUCT_CURRENCY,
            ]);
            $orderId = (int) $db->lastInsertId();
        }

        $db->commit();
    } catch (Throwable $e) {
        $db->rollBack();
        error_log('paymentSuccess() DB error: ' . $e->getMessage());
        throw $e;
    }

    $_SESSION['customer_id'] = $customerId;
    $_SESSION['customer_email'] = $customer['email'];

    return ['order_id' => $orderId, 'customer_id' => $customerId];
}

function getPurchasedBundles(int $customerId): array
{
    $db = getDB();
    $stmt = $db->prepare(
        'SELECT o.id AS order_id, o.razorpay_payment_id, o.amount, o.created_at AS purchased_at,
                bv.version, bv.release_notes, bv.released_at
         FROM orders o
         LEFT JOIN bundle_versions bv ON bv.is_current = 1
         WHERE o.customer_id = ? AND o.status = "paid"
         ORDER BY o.created_at DESC'
    );
    $stmt->execute([$customerId]);
    return $stmt->fetchAll();
}
