<?php
require_once __DIR__ . '/config/config.php';

if (empty($_SESSION['checkout']['order_id'])) {
    header('Location: checkout.php');
    exit;
}

$checkout = $_SESSION['checkout'];
$sessionId = $checkout['payment_session_id'] ?? '';

$pageTitle = 'Processing Payment — ' . SITE_NAME;
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero" style="position:relative; min-height:70vh; display:flex; align-items:center;">
  <div class="glow-sphere" style="width:300px;height:300px;background:#00FF41;top:-10%;left:-5%;"></div>
  <div class="grid-overlay"></div>
  <div class="container position-relative text-center" style="z-index:1;">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="app-card" id="payment-status-card">
          <div id="payment-loading">
            <div class="spinner-border text-primary mb-3" role="status" style="width:3rem;height:3rem;">
              <span class="visually-hidden">Loading...</span>
            </div>
            <h5 class="fw-bold mb-2">Secure Checkout</h5>
            <p class="text-secondary small mb-3">Click the button below to proceed to the secure payment page.</p>
            <button type="button" id="open-checkout-btn" class="btn btn-primary rounded-pill px-5 py-3 gradient-btn btn-lg">
              <i class="bi bi-shield-lock-fill me-2"></i> Proceed to Pay ₹199
            </button>
            <p class="text-muted small mt-2">Opens a secure Cashfree payment page in this window.</p>
          </div>

          <div id="payment-error" class="d-none">
            <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size:2.5rem;"></i>
            <h5 class="fw-bold mt-3 mb-2">Something went wrong</h5>
            <p class="text-secondary small" id="payment-error-message">We couldn't initiate the payment.</p>
            <a href="checkout.php" class="btn btn-outline-primary-soft rounded-pill px-4 py-2 mt-2">Back to Checkout</a>
          </div>

          <div id="payment-fallback" class="d-none">
            <i class="bi bi-link-45deg text-warning" style="font-size:2.5rem;"></i>
            <h5 class="fw-bold mt-3 mb-2">Click to Pay</h5>
            <p class="text-secondary small">If the payment page doesn't open, click the link below:</p>
            <a id="fallback-link" href="#" target="_blank" class="btn btn-primary rounded-pill px-4 py-2 gradient-btn">
              <i class="bi bi-box-arrow-up-right me-2"></i> Open Payment Page
            </a>
            <p class="text-muted small mt-2">After payment, you'll be redirected back automatically.</p>
          </div>
        </div>
        <p class="text-muted small mt-3"><i class="bi bi-lock-fill me-1"></i> Payments are processed securely by Cashfree. HIFI11 Academy never sees or stores your card details.</p>
      </div>
    </div>
  </div>
</section>

<script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
<script>
(function () {
  var btn = document.getElementById('open-checkout-btn');
  var loading = document.getElementById('payment-loading');
  var errorBox = document.getElementById('payment-error');
  var errorMsg = document.getElementById('payment-error-message');
  var fallbackBox = document.getElementById('payment-fallback');
  var fallbackLink = document.getElementById('fallback-link');
  var sessionId = <?= json_encode($sessionId) ?>;

  function showError(msg) {
    loading.classList.add('d-none');
    errorBox.classList.remove('d-none');
    errorMsg.textContent = msg || 'We could not initiate the payment. Please try again.';
  }

  function showFallback(url) {
    loading.classList.add('d-none');
    fallbackBox.classList.remove('d-none');
    fallbackLink.href = url;
  }

  var directCheckoutUrl = <?= json_encode(CASHFREE_PAYMENT_URL . '?payment_session_id=' . urlencode($sessionId)) ?>;

  function openCheckout() {
    if (!sessionId) {
      showError('Payment session not found. Please start checkout again.');
      return;
    }
    if (typeof Cashfree === 'undefined') {
      showFallback(directCheckoutUrl);
      return;
    }
    try {
      var cf = new Cashfree({ paymentSessionId: sessionId });
      cf.redirect();
    } catch (e) {
      showFallback(directCheckoutUrl);
    }
  }

  btn.addEventListener('click', openCheckout);

  if (sessionId) {
    console.log('Cashfree session ID is set');
  } else {
    console.error('Cashfree session ID is empty');
  }
})();
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
