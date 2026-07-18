<?php
require_once __DIR__ . '/config/config.php';
$pageTitle = 'Privacy Policy — ' . SITE_NAME;
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9" data-aos="fade-up">
        <span class="breadcrumb-pill mb-3"><i class="bi bi-shield-lock-fill text-primary"></i> Legal</span>
        <h1 class="fw-bold mt-3 mb-2">Privacy Policy</h1>
        <p class="text-muted mb-4">Last updated: <?= date('d F Y') ?></p>

        <div class="app-card">
          <h5 class="fw-bold">1. Introduction</h5>
          <p class="text-secondary">HIFI11 Academy ("we", "us", "our") operates as a digital product seller offering a one-time, downloadable bundle pack. This Privacy Policy explains what information we collect when you purchase our digital bundle and how we use it.</p>

          <h5 class="fw-bold mt-4">2. Information We Collect</h5>
          <ul class="text-secondary">
            <li>Full name, email address, and mobile number provided at checkout.</li>
            <li>Payment confirmation details (payment ID, order ID) received from our payment processor (Cashfree). We do not store your card, UPI, or bank details — these are handled entirely by Cashfree.</li>
            <li>Download activity logs (IP address, timestamp) used to prevent unauthorized access and abuse of download links.</li>
          </ul>

          <h5 class="fw-bold mt-4">3. How We Use Your Information</h5>
          <ul class="text-secondary">
            <li>To create your customer account automatically after a successful purchase.</li>
            <li>To deliver your download link, invoice, and confirmation email.</li>
            <li>To provide customer support for payment or download-related issues.</li>
            <li>To notify you of future bundle updates included with your purchase.</li>
          </ul>

          <h5 class="fw-bold mt-4">4. Data Sharing</h5>
          <p class="text-secondary">We do not sell or rent your personal information to third parties. Your payment is processed securely by Cashfree under their own privacy and security standards.</p>

          <h5 class="fw-bold mt-4">5. Data Security</h5>
          <p class="text-secondary">We use industry-standard practices including hashed session tokens, prepared SQL statements, and time-limited signed download links to protect your account and purchase data.</p>

          <h5 class="fw-bold mt-4">6. Your Rights</h5>
          <p class="text-secondary">You may request access to, correction of, or deletion of your personal data at any time by contacting us at <?= e(SUPPORT_EMAIL) ?>.</p>

          <h5 class="fw-bold mt-4">7. Contact Us</h5>
          <p class="text-secondary mb-0">For any privacy-related questions, reach us at <?= e(SUPPORT_EMAIL) ?> or via <a href="contact.php">our contact page</a>.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
