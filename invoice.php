<?php
require_once __DIR__ . '/config/config.php';
requireLogin();

$db = getDB();
$orderId = isset($_GET['order_id']) ? (int) $_GET['order_id'] : 0;

if ($orderId) {
    $stmt = $db->prepare('SELECT * FROM orders WHERE id = ? AND customer_id = ? LIMIT 1');
    $stmt->execute([$orderId, $_SESSION['customer_id']]);
    $order = $stmt->fetch();
} else {
    // Default to most recent order
    $stmt = $db->prepare('SELECT * FROM orders WHERE customer_id = ? ORDER BY created_at DESC LIMIT 1');
    $stmt->execute([$_SESSION['customer_id']]);
    $order = $stmt->fetch();
}

if (!$order) {
    header('Location: my-downloads.php');
    exit;
}

$customer = currentCustomer();
$gstRate = 0; // TODO: set your applicable GST rate here, e.g. 18 for 18%
$gstAmount = round($order['amount'] * $gstRate / 100, 2);
$totalAmount = $order['amount']; // amount already inclusive; adjust if GST is added on top

$pageTitle = 'Invoice #' . $order['id'] . ' — ' . SITE_NAME;
$activeNav = 'dashboard';
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8" data-aos="fade-up">
        <div class="d-flex justify-content-between align-items-center mb-3 no-print">
          <h2 class="fw-bold mb-0">Invoice</h2>
          <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 py-2 gradient-btn"><i class="bi bi-download me-2"></i>Download PDF</button>
        </div>

        <div class="app-card">
          <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
            <div>
              <h4 class="fw-bold mb-0"><i class="bi bi-shield-fill-check text-primary"></i> HIFI11 ACADEMY</h4>
              <p class="text-muted small mb-0">HIFI11 Technologies<br>Tamil Nadu, India</p>
              <p class="text-muted small mb-0"><?= e(SUPPORT_EMAIL) ?></p>
            </div>
            <div class="text-end">
              <h5 class="fw-bold mb-0">INVOICE</h5>
              <p class="text-muted small mb-0">Invoice #: INV-<?= str_pad((string) $order['id'], 6, '0', STR_PAD_LEFT) ?></p>
              <p class="text-muted small mb-0">Date: <?= formatDate($order['created_at']) ?></p>
            </div>
          </div>

          <hr>

          <div class="row mb-4">
            <div class="col-md-6">
              <h6 class="fw-bold small text-uppercase text-muted">Billed To</h6>
              <p class="mb-0 fw-semibold"><?= e($customer['full_name']) ?></p>
              <p class="mb-0 text-secondary small"><?= e($customer['email']) ?></p>
              <p class="mb-0 text-secondary small"><?= e($customer['mobile']) ?></p>
            </div>
            <div class="col-md-6 text-md-end">
              <h6 class="fw-bold small text-uppercase text-muted">Payment Details</h6>
              <p class="mb-0 text-secondary small">Payment Ref: <?= e($order['razorpay_payment_id']) ?></p>
              <p class="mb-0 text-secondary small">Order Ref: <?= e($order['razorpay_order_id']) ?></p>
              <p class="mb-0"><span class="status-pill <?= e($order['status']) ?>"><?= e(ucfirst($order['status'])) ?></span></p>
            </div>
          </div>

          <table class="premium-table mb-3">
            <thead><tr><th>Description</th><th class="text-end">Amount</th></tr></thead>
            <tbody>
              <tr>
                <td><?= e(PRODUCT_NAME) ?> — One-Time Purchase</td>
                <td class="text-end"><?= formatRupees($order['amount']) ?></td>
              </tr>
              <?php if ($gstRate > 0): ?>
                <tr><td>GST (<?= $gstRate ?>%) <span class="text-muted small">— TODO: confirm applicable GST</span></td><td class="text-end"><?= formatRupees($gstAmount) ?></td></tr>
              <?php endif; ?>
            </tbody>
          </table>

          <div class="d-flex justify-content-end">
            <div class="app-card-soft" style="min-width:240px;">
              <div class="d-flex justify-content-between"><span class="text-muted small">Subtotal</span><span class="small"><?= formatRupees($order['amount']) ?></span></div>
              <?php if ($gstRate > 0): ?><div class="d-flex justify-content-between"><span class="text-muted small">GST</span><span class="small"><?= formatRupees($gstAmount) ?></span></div><?php endif; ?>
              <hr class="my-2">
              <div class="d-flex justify-content-between"><span class="fw-bold">Total Paid</span><span class="fw-bold text-primary"><?= formatRupees($totalAmount) ?></span></div>
            </div>
          </div>

          <p class="text-muted small mt-4 mb-0">This is a computer-generated invoice for a downloadable digital product and does not require a physical signature.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
