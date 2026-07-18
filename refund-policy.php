<?php
require_once __DIR__ . '/config/config.php';
$pageTitle = 'Refund Policy — ' . SITE_NAME;
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9" data-aos="fade-up">
        <span class="breadcrumb-pill mb-3"><i class="bi bi-arrow-counterclockwise text-primary"></i> Legal</span>
        <h1 class="fw-bold mt-3 mb-2">Refund Policy</h1>
        <p class="text-muted mb-4">Last updated: <?= date('d F Y') ?></p>

        <div class="app-card">
          <h5 class="fw-bold">1. Nature of the Product</h5>
          <p class="text-secondary">The <?= e(PRODUCT_NAME) ?> is a downloadable digital product. Because the bundle becomes instantly accessible after payment, all sales are generally considered final once the download link has been accessed.</p>

          <h5 class="fw-bold mt-4">2. Eligibility for Refund</h5>
          <p class="text-secondary">We may issue a refund in the following limited circumstances:</p>
          <ul class="text-secondary">
            <li>A duplicate/accidental payment was made for the same order.</li>
            <li>Payment was deducted from your account but the order was not successfully created in our system.</li>
            <li>The download files are proven to be corrupted or inaccessible and our support team is unable to resolve the issue after reasonable attempts.</li>
          </ul>

          <h5 class="fw-bold mt-4">3. Non-Refundable Situations</h5>
          <ul class="text-secondary">
            <li>Change of mind after the bundle has already been downloaded.</li>
            <li>Lack of suitable device/storage space to use the downloaded files.</li>
            <li>Requests made after 7 days from the date of purchase.</li>
          </ul>

          <h5 class="fw-bold mt-4">4. How to Request a Refund</h5>
          <p class="text-secondary">Email <?= e(SUPPORT_EMAIL) ?> or message us on <a href="https://wa.me/<?= e(SUPPORT_WHATSAPP) ?>" target="_blank">WhatsApp</a> with your payment ID and reason for the request within 7 days of purchase. Approved refunds are processed to the original payment method within 5-7 business days.</p>

          <h5 class="fw-bold mt-4">5. Contact</h5>
          <p class="text-secondary mb-0">Questions about this policy? Reach out via our <a href="contact.php">contact page</a>.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
