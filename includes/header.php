<?php
/**
 * includes/header.php
 * Include AFTER setting an optional $pageTitle / $pageDescription variable.
 * Requires config/config.php to already be loaded by the calling page.
 */
$pageTitle = $pageTitle ?? SITE_NAME;
$pageDescription = $pageDescription ?? SITE_TAGLINE;
$activeNav = $activeNav ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5" />
  <title><?= e($pageTitle) ?></title>
  <meta name="description" content="<?= e($pageDescription) ?>" />
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <!-- Bootstrap 5 + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <!-- Shared Design System -->
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

<div class="scanlines"></div>

<!-- ====== ANNOUNCEMENT BAR ====== -->
<div class="announcement-bar">
  <div class="scroll-text">
    🔥 PREMIUM BUNDLE PACK | 2 Complete Ethical Hacking Courses | Worth <?= formatRupees(PRODUCT_VALUE) ?>+ | Today Only <?= formatRupees(PRODUCT_PRICE) ?> | Save 98% | One-Time Purchase • Instant Download 🔥
  </div>
</div>

<!-- ====== NAVBAR ====== -->
<nav class="navbar navbar-expand-lg sticky-top py-2">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="bi bi-shield-fill-check"></i> HIFI11 ACADEMY</a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" style="color:#00FF41;font-size:1.8rem;padding:4px 8px;">
      <i class="bi bi-list"></i>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-2">
        <li class="nav-item"><a class="nav-link <?= $activeNav === 'home' ? 'fw-bold text-primary' : '' ?>" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link <?= $activeNav === 'support' ? 'fw-bold text-primary' : '' ?>" href="support.php">Support</a></li>
        <li class="nav-item"><a class="nav-link <?= $activeNav === 'contact' ? 'fw-bold text-primary' : '' ?>" href="contact.php">Contact</a></li>
        <?php if (isLoggedIn()): ?>
          <li class="nav-item"><a class="nav-link <?= $activeNav === 'dashboard' ? 'fw-bold text-primary' : '' ?>" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item ms-lg-2"><a href="logout.php" class="btn btn-outline-primary-soft rounded-pill px-4 py-2">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link <?= $activeNav === 'login' ? 'fw-bold text-primary' : '' ?>" href="login.php">Login</a></li>
          <li class="nav-item ms-lg-2"><a href="checkout.php" class="btn btn-primary rounded-pill px-4 py-2 gradient-btn">Get the Bundle</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
