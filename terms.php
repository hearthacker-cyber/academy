<?php
require_once __DIR__ . '/config/config.php';
$pageTitle = 'Terms & Conditions — ' . SITE_NAME;
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9" data-aos="fade-up">
        <span class="breadcrumb-pill mb-3"><i class="bi bi-file-earmark-text-fill text-primary"></i> Legal</span>
        <h1 class="fw-bold mt-3 mb-2">Terms &amp; Conditions</h1>
        <p class="text-muted mb-4">Last updated: <?= date('d F Y') ?></p>

        <div class="app-card">
          <h5 class="fw-bold">1. About This Product</h5>
          <p class="text-secondary">HIFI11 Academy sells the <?= e(PRODUCT_NAME) ?> as a one-time, downloadable digital bundle. This is NOT a subscription, membership, or online learning management system (LMS). Once purchased, you receive downloadable files to keep and use offline.</p>

          <h5 class="fw-bold mt-4">2. License to Use</h5>
          <p class="text-secondary">Upon successful payment, you are granted a personal, non-transferable license to download and use the bundle for your own learning purposes. You may not resell, redistribute, share, or publicly upload any part of the bundle.</p>

          <h5 class="fw-bold mt-4">3. Account Creation</h5>
          <p class="text-secondary">A customer account is automatically created using the email address provided at checkout. You are responsible for keeping access to that email address secure, since our login uses email + OTP verification rather than a password.</p>

          <h5 class="fw-bold mt-4">4. Payments</h5>
          <p class="text-secondary">All payments are processed securely via Cashfree. Prices are listed in Indian Rupees (INR) and are inclusive of applicable taxes unless stated otherwise.</p>

          <h5 class="fw-bold mt-4">5. Download Access</h5>
          <p class="text-secondary">Download links are time-limited for security purposes but can be regenerated anytime by logging into your account. We reserve the right to update file delivery infrastructure without prior notice.</p>

          <h5 class="fw-bold mt-4">6. Future Updates</h5>
          <p class="text-secondary">Free future updates to the bundle, where released, are included with your original purchase at no extra cost.</p>

          <h5 class="fw-bold mt-4">7. Limitation of Liability</h5>
          <p class="text-secondary">The bundle is provided for educational purposes. HIFI11 Academy is not liable for any misuse of the knowledge or tools contained within the bundle. Users are expected to comply with all applicable laws in their jurisdiction.</p>

          <h5 class="fw-bold mt-4">8. Changes to These Terms</h5>
          <p class="text-secondary mb-0">We may update these Terms from time to time. Continued use of our services after changes constitutes acceptance of the revised Terms.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
