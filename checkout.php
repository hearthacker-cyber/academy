<?php
require_once __DIR__ . '/config/config.php';

$errors = [];
$fullName = $email = $mobile = $coupon = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();

    $fullName = trim($_POST['full_name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $mobile   = trim($_POST['mobile'] ?? '');
    $coupon   = trim($_POST['coupon'] ?? '');

    if ($fullName === '' || mb_strlen($fullName) < 2) {
        $errors[] = 'Please enter your full name.';
    }
    if (!isValidEmail($email)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (!isValidMobile($mobile)) {
        $errors[] = 'Please enter a valid 10-digit mobile number.';
    }

    if (empty($errors)) {
        $amountInPaise = PRODUCT_PRICE * 100;
        $receiptId = 'HIFI11-' . time() . '-' . bin2hex(random_bytes(3));

        try {
            $order = createOrder($amountInPaise, $receiptId, [
                'name'   => $fullName,
                'email'  => $email,
                'mobile' => $mobile,
            ]);

            $_SESSION['checkout'] = [
                'full_name'          => $fullName,
                'email'              => $email,
                'mobile'             => $mobile,
                'coupon'             => $coupon,
                'order_id'           => $order['id'],
                'payment_session_id' => $order['payment_session_id'],
                'amount_paise'       => $order['amount'],
            ];

            $redirectUrl = CASHFREE_PAYMENT_URL . '?payment_session_id=' . urlencode($order['payment_session_id']);
            header('Location: ' . $redirectUrl);
            exit;
        } catch (CashfreeException $e) {
            error_log('checkout.php: Cashfree order creation failed: ' . $e->getMessage());
            $errors[] = 'We could not start the payment: ' . e($e->getMessage());
        }
    }
}

$cancelled = isset($_GET['cancelled']);
$failed = isset($_GET['failed']);

$pageTitle = 'Checkout — ' . SITE_NAME;
$pageDescription = 'Complete your purchase of the ' . PRODUCT_NAME . ' for just ' . formatRupees(PRODUCT_PRICE) . '.';
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero" style="position:relative;">
  <div class="glow-sphere" style="width:300px;height:300px;background:#00FF41;top:-10%;left:-5%;"></div>
  <div class="grid-overlay"></div>
  <div class="container position-relative" style="z-index:1;">
    <div class="text-center mb-4" data-aos="fade-up">
      <span class="breadcrumb-pill mb-3"><i class="bi bi-lock-fill text-primary"></i> Secure Checkout</span>
      <h1 class="fw-bold mt-3">Complete Your Purchase</h1>
      <p class="text-secondary">One-time payment. Instant download. No subscriptions.</p>
    </div>

    <?php if (!empty($errors)): ?>
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="alert alert-danger rounded-4" data-aos="fade-up">
            <ul class="mb-0 ps-3">
              <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($cancelled): ?>
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="alert alert-warning rounded-4 d-flex align-items-center gap-2" data-aos="fade-up">
            <i class="bi bi-x-circle-fill fs-5"></i>
            <div><strong>Payment Cancelled.</strong> You closed the payment window before completing checkout. No amount was charged — please try again.</div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($failed): ?>
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="alert alert-danger rounded-4 d-flex align-items-center gap-2" data-aos="fade-up">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <div><strong>Payment Failed.</strong> Your bank or card issuer declined the transaction. No amount was charged — please try again or use a different payment method.</div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="row g-4 justify-content-center">
      <!-- CUSTOMER DETAILS FORM -->
      <div class="col-lg-7" data-aos="fade-right">
        <div class="app-card">
          <h5 class="fw-bold mb-4"><i class="bi bi-person-fill text-primary me-2"></i>Your Details</h5>
          <form method="post" action="checkout.php" novalidate>
            <?= csrfField() ?>
            <div class="mb-3">
              <label class="form-label-premium">Full Name</label>
              <div class="input-group-premium">
                <i class="bi bi-person field-icon"></i>
                <input type="text" name="full_name" class="form-control-premium has-icon" placeholder="Your full name" value="<?= e($fullName) ?>" required>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label-premium">Email Address</label>
              <div class="input-group-premium">
                <i class="bi bi-envelope field-icon"></i>
                <input type="email" name="email" class="form-control-premium has-icon" placeholder="you@example.com" value="<?= e($email) ?>" required>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label-premium">Mobile Number</label>
              <div class="input-group-premium">
                <i class="bi bi-phone field-icon"></i>
                <input type="tel" name="mobile" class="form-control-premium has-icon" placeholder="10-digit mobile number" value="<?= e($mobile) ?>" required maxlength="10">
              </div>
            </div>

            <!-- COUPON SECTION (future ready) -->
            <div class="mb-4">
              <label class="form-label-premium">Coupon Code <span class="text-muted fw-normal">(optional)</span></label>
              <div class="d-flex gap-2">
                <input type="text" name="coupon" class="form-control-premium" placeholder="Enter coupon code" value="<?= e($coupon) ?>">
                <button type="button" class="btn btn-outline-primary-soft px-4" onclick="alert('Coupon system coming soon!')">Apply</button>
              </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill py-3 gradient-btn">
              Proceed to Payment <i class="bi bi-arrow-right ms-2"></i>
            </button>

            <div class="d-flex flex-wrap gap-2 justify-content-center mt-4">
              <span class="trust-badge"><i class="bi bi-shield-check"></i> Secure Checkout</span>
              <span class="trust-badge"><i class="bi bi-lightning-charge-fill"></i> Instant Download</span>
              <span class="trust-badge"><i class="bi bi-arrow-repeat"></i> One-Time Purchase</span>
            </div>
          </form>
        </div>
      </div>

      <!-- ORDER SUMMARY -->
      <div class="col-lg-4" data-aos="fade-left">
        <div class="app-card app-card-soft">
          <h5 class="fw-bold mb-3">Order Summary</h5>
          <div class="value-table mb-3">
            <div class="row-item"><span><?= e(PRODUCT_NAME) ?></span><span class="strike"><?= formatRupees(PRODUCT_VALUE) ?>+</span></div>
            <div class="row-item highlight"><span class="fw-bold">Today's Price</span><span class="fw-bold text-primary"><?= formatRupees(PRODUCT_PRICE) ?></span></div>
            <div class="row-item total"><span>You Pay</span><span><?= formatRupees(PRODUCT_PRICE) ?></span></div>
          </div>
          <span class="badge-save d-inline-block mb-3">🔥 98% OFF — Save <?= formatRupees(PRODUCT_VALUE - PRODUCT_PRICE) ?></span>
          <ul class="list-unstyled small text-secondary">
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>2 Complete Premium Courses</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Instant Download After Payment</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Own the Files Forever</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Free Future Updates</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
