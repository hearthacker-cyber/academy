<?php
require_once __DIR__ . '/config/config.php';

// This page ONLY renders once verify_payment.php has:
//   1. Verified the Cashfree payment server-side
//   2. Saved the customer + order to the database (status = paid)
//   3. Generated a download token
// and placed the result in $_SESSION['payment_result']. There is no
// path to this page that bypasses those steps.
if (empty($_SESSION['payment_result'])) {
    header('Location: checkout.php');
    exit;
}

$result = $_SESSION['payment_result'];
$downloadToken = $result['download_token'];

<<<<<<< HEAD
if (empty($_SESSION['payment_email_sent'])) {
    $downloadLink = SITE_URL . '/download.php?token=' . urlencode($downloadToken);
    $subject = 'Your Purchase Confirmation - ' . SITE_NAME;
    $body = '<p>Thank you for your purchase, <strong>' . e($result['full_name']) . '</strong>!</p>'
          . '<p>Your <strong>' . PRODUCT_NAME . '</strong> is ready to download.</p>'
          . '<p style="text-align:center;"><a href="' . $downloadLink . '" style="display:inline-block;background:#00FF41;color:#0a0a0f;padding:14px 36px;border-radius:40px;font-weight:700;font-size:18px;text-decoration:none;">Download Now</a></p>'
          . '<p>Payment Ref: ' . e($result['payment_id']) . '<br>Amount: ' . formatRupees(PRODUCT_PRICE) . '</p>'
          . '<p>You can also log in anytime at <a href="' . SITE_URL . '/login.php">' . SITE_NAME . '</a> to re-download.</p>'
          . '<p>— ' . SITE_NAME . '</p>';
    sendMail($result['email'], $subject, $body);
    $_SESSION['payment_email_sent'] = true;
}

=======
>>>>>>> 8179ce192d08535196c5e138542df972d599d1ac
$pageTitle = 'Payment Successful — ' . SITE_NAME;
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero" style="position:relative; min-height: 70vh; display:flex; align-items:center;">
  <div class="glow-sphere" style="width:400px;height:400px;background:#10B981;top:-10%;left:-5%;"></div>
  <div class="grid-overlay"></div>
  <div class="container position-relative text-center" style="z-index:1;">
    <div data-aos="zoom-in">
      <div class="success-check-wrap mb-4">
        <div class="success-ring"></div>
        <div class="success-circle"><i class="bi bi-check-lg"></i></div>
      </div>
      <h1 class="fw-bold mb-2">Payment Successful! 🎉</h1>
      <p class="text-secondary lead">Thank you, <?= e($result['full_name']) ?> — your bundle is ready to download.</p>
    </div>

    <div class="row justify-content-center mt-4" data-aos="fade-up">
      <div class="col-lg-6">
        <div class="app-card app-card-soft text-start">
          <div class="d-flex justify-content-between py-2 border-bottom">
            <span class="text-muted small">Payment ID</span>
            <span class="fw-semibold small"><?= e($result['payment_id']) ?></span>
          </div>
          <div class="d-flex justify-content-between py-2 border-bottom">
            <span class="text-muted small">Customer</span>
            <span class="fw-semibold small"><?= e($result['full_name']) ?></span>
          </div>
          <div class="d-flex justify-content-between py-2 border-bottom">
            <span class="text-muted small">Email</span>
            <span class="fw-semibold small"><?= e($result['email']) ?></span>
          </div>
          <div class="d-flex justify-content-between py-2">
            <span class="text-muted small">Amount Paid</span>
            <span class="fw-bold text-primary"><?= formatRupees(PRODUCT_PRICE) ?></span>
          </div>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-3 mt-4 justify-content-center">
          <a href="download.php?token=<?= urlencode($downloadToken) ?>" class="btn btn-primary btn-lg rounded-pill px-4 py-3 gradient-btn flex-fill">
            <i class="bi bi-download me-2"></i> Download Bundle
          </a>
          <a href="invoice.php?order_id=<?= (int) $result['order_id'] ?>" class="btn btn-outline-primary-soft btn-lg rounded-pill px-4 py-3 flex-fill">
            <i class="bi bi-receipt me-2"></i> View Invoice
          </a>
        </div>

        <p class="text-muted small mt-4"><i class="bi bi-envelope-check me-1"></i> A confirmation email has been sent to <?= e($result['email']) ?>.</p>
        <p class="text-muted small">Your account has been created automatically — use your email to <a href="login.php">log in</a> anytime and re-download.</p>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
