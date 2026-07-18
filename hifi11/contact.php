<?php
require_once __DIR__ . '/config/config.php';

$submitted = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (mb_strlen($name) < 2) $errors[] = 'Please enter your name.';
    if (!isValidEmail($email)) $errors[] = 'Please enter a valid email address.';
    if (mb_strlen($message) < 5) $errors[] = 'Please write a short message.';

    if (empty($errors)) {
        // ---------------------------------------------------------------
        // Replace this section with your email/notification service.
        // mail(SUPPORT_EMAIL, 'New Contact Form Message', $message);
        // ---------------------------------------------------------------
        $submitted = true;
    }
}

$pageTitle = 'Contact Us — ' . SITE_NAME;
$activeNav = 'contact';
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <span class="breadcrumb-pill mb-3"><i class="bi bi-chat-dots-fill text-primary"></i> Let's Talk</span>
      <h1 class="fw-bold mt-3">Connect With Us</h1>
      <p class="text-secondary">Reach out anytime — we're here to help!</p>
    </div>

    <div class="contact-social-links mb-5" data-aos="fade-up">
      <a href="https://wa.me/<?= e(SUPPORT_WHATSAPP) ?>" target="_blank" class="whatsapp"><i class="bi bi-whatsapp"></i> +91 <?= e(substr(SUPPORT_WHATSAPP, 2)) ?></a>
      <a href="<?= e(SUPPORT_INSTAGRAM) ?>" target="_blank" class="instagram"><i class="bi bi-instagram"></i> @_devil_heart_hacker</a>
      <a href="<?= e(SUPPORT_TELEGRAM) ?>" target="_blank" class="telegram"><i class="bi bi-telegram"></i> @devil_heart_hack</a>
      <a href="mailto:<?= e(SUPPORT_EMAIL) ?>"><i class="bi bi-envelope-fill"></i> <?= e(SUPPORT_EMAIL) ?></a>
    </div>

    <div class="row justify-content-center" data-aos="fade-up">
      <div class="col-lg-6">
        <div class="app-card">
          <h5 class="fw-bold mb-3">Send Us a Message</h5>
          <?php if ($submitted): ?>
            <div class="alert alert-success rounded-4">Thanks for reaching out! We'll respond within 24 hours.</div>
          <?php else: ?>
            <?php if (!empty($errors)): ?>
              <div class="alert alert-danger rounded-4"><ul class="mb-0 ps-3"><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
            <?php endif; ?>
            <form method="post" action="contact.php">
              <?= csrfField() ?>
              <div class="mb-3"><label class="form-label-premium">Your Name</label><input type="text" name="name" class="form-control-premium" required></div>
              <div class="mb-3"><label class="form-label-premium">Email Address</label><input type="email" name="email" class="form-control-premium" required></div>
              <div class="mb-3"><label class="form-label-premium">Message</label><textarea name="message" rows="5" class="form-control-premium" required></textarea></div>
              <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 gradient-btn">Send Message</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
