<?php
require_once __DIR__ . '/config/config.php';

$submitted = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $issueType = trim($_POST['issue_type'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (mb_strlen($name) < 2) $errors[] = 'Please enter your name.';
    if (!isValidEmail($email)) $errors[] = 'Please enter a valid email address.';
    if (mb_strlen($message) < 10) $errors[] = 'Please describe your issue in a bit more detail.';

    if (empty($errors)) {
        // ---------------------------------------------------------------
        // Replace this section with your ticketing/email service.
        // mail(SUPPORT_EMAIL, 'Support Request: ' . $issueType, $message);
        // ---------------------------------------------------------------
        $submitted = true;
    }
}

$pageTitle = 'Support — ' . SITE_NAME;
$activeNav = 'support';
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <span class="breadcrumb-pill mb-3"><i class="bi bi-life-preserver text-primary"></i> We're Here to Help</span>
      <h1 class="fw-bold mt-3">Support Center</h1>
      <p class="text-secondary">Payment issues, download problems, or general questions — get help fast.</p>
    </div>

    <div class="row g-3 justify-content-center mb-5" data-aos="fade-up">
      <div class="col-6 col-md-3">
        <a href="https://wa.me/<?= e(SUPPORT_WHATSAPP) ?>" target="_blank" class="text-decoration-none">
          <div class="icon-feature glass-card"><i class="bi bi-whatsapp"></i><p class="small fw-semibold mt-2 mb-0 style="color:#E6EDF3;"">WhatsApp</p></div>
        </a>
      </div>
      <div class="col-6 col-md-3">
        <a href="mailto:<?= e(SUPPORT_EMAIL) ?>" class="text-decoration-none">
          <div class="icon-feature glass-card"><i class="bi bi-envelope-fill"></i><p class="small fw-semibold mt-2 mb-0 style="color:#E6EDF3;"">Email Us</p></div>
        </a>
      </div>
      <div class="col-6 col-md-3">
        <div class="icon-feature glass-card"><i class="bi bi-credit-card-fill"></i><p class="small fw-semibold mt-2 mb-0 style="color:#E6EDF3;"">Payment Issues</p></div>
      </div>
      <div class="col-6 col-md-3">
        <div class="icon-feature glass-card"><i class="bi bi-cloud-arrow-down-fill"></i><p class="small fw-semibold mt-2 mb-0 style="color:#E6EDF3;"">Download Issues</p></div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-6" data-aos="fade-right">
        <h4 class="fw-bold mb-3">Frequently Asked Questions</h4>
        <div class="accordion accordion-flush" id="supportFaq">
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#s1">I paid but didn't get the download link. What do I do?</button></h2>
            <div id="s1" class="accordion-collapse collapse" data-bs-parent="#supportFaq"><div class="accordion-body">Check your email inbox (and spam folder) for the confirmation email. You can also log in with your purchase email on the <a href="login.php">login page</a> to access your download directly.</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#s2">My download link has expired. How do I get a new one?</button></h2>
            <div id="s2" class="accordion-collapse collapse" data-bs-parent="#supportFaq"><div class="accordion-body">Simply log in to your dashboard and click "My Downloads" to generate a fresh download link anytime.</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#s3">Can I get a refund?</button></h2>
            <div id="s3" class="accordion-collapse collapse" data-bs-parent="#supportFaq"><div class="accordion-body">Please see our <a href="refund-policy.php">Refund Policy</a> for eligibility and process details.</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#s4">The payment failed but money was deducted. What now?</button></h2>
            <div id="s4" class="accordion-collapse collapse" data-bs-parent="#supportFaq"><div class="accordion-body">Failed payments are usually auto-refunded by your bank within 5-7 business days. If not, contact us with your payment reference and we'll help resolve it.</div></div>
          </div>
        </div>
      </div>

      <div class="col-lg-6" data-aos="fade-left">
        <div class="app-card">
          <h5 class="fw-bold mb-3">Contact Support</h5>
          <?php if ($submitted): ?>
            <div class="alert alert-success rounded-4">Thanks! Your request has been received — we'll get back to you shortly.</div>
          <?php else: ?>
            <?php if (!empty($errors)): ?>
              <div class="alert alert-danger rounded-4"><ul class="mb-0 ps-3"><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
            <?php endif; ?>
            <form method="post" action="support.php">
              <?= csrfField() ?>
              <div class="mb-3"><label class="form-label-premium">Your Name</label><input type="text" name="name" class="form-control-premium" required></div>
              <div class="mb-3"><label class="form-label-premium">Email Address</label><input type="email" name="email" class="form-control-premium" required></div>
              <div class="mb-3">
                <label class="form-label-premium">Issue Type</label>
                <select name="issue_type" class="form-select-premium">
                  <option>Payment Issue</option>
                  <option>Download Issue</option>
                  <option>Account / Login Issue</option>
                  <option>Other</option>
                </select>
              </div>
              <div class="mb-3"><label class="form-label-premium">Message</label><textarea name="message" rows="4" class="form-control-premium" required></textarea></div>
              <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 gradient-btn">Submit Request</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
