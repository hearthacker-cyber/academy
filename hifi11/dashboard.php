<?php
require_once __DIR__ . '/config/config.php';
requireLogin();

$customer = currentCustomer();
$bundles = getPurchasedBundles((int) $_SESSION['customer_id']);

$pageTitle = 'Dashboard — ' . SITE_NAME;
$activeNav = 'dashboard';
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero">
  <div class="container">
    <div class="row g-4">
      <!-- SIDEBAR -->
      <div class="col-lg-3" data-aos="fade-right">
        <div class="dash-sidebar">
          <div class="d-flex align-items-center gap-2 mb-3 px-2">
            <div class="bundle-icon"><i class="bi bi-person-fill"></i></div>
            <div>
              <div class="fw-bold small"><?= e($customer['full_name'] ?? 'Customer') ?></div>
              <div class="text-muted" style="font-size:0.75rem;"><?= e($customer['email'] ?? '') ?></div>
            </div>
          </div>
          <a href="dashboard.php" class="dash-link active mb-1"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
          <a href="my-downloads.php" class="dash-link mb-1"><i class="bi bi-download"></i> My Downloads</a>
          <a href="invoice.php" class="dash-link mb-1"><i class="bi bi-receipt"></i> Invoices</a>
          <a href="profile.php" class="dash-link mb-1"><i class="bi bi-person-gear"></i> Profile</a>
          <a href="support.php" class="dash-link mb-1"><i class="bi bi-life-preserver"></i> Support</a>
          <a href="logout.php" class="dash-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
      </div>

      <!-- MAIN -->
      <div class="col-lg-9" data-aos="fade-up">
        <h2 class="fw-bold mb-1">Welcome back, <?= e(explode(' ', $customer['full_name'] ?? 'there')[0]) ?> 👋</h2>
        <p class="text-secondary mb-4">Here's an overview of your HIFI11 Academy account.</p>

        <div class="row g-3 mb-4">
          <div class="col-6 col-md-3"><div class="stat-tile"><div class="stat-value"><?= count($bundles) ?></div><div class="stat-label">Bundles Owned</div></div></div>
          <div class="col-6 col-md-3"><div class="stat-tile"><div class="stat-value"><?= !empty($bundles) ? e($bundles[0]['version'] ?? PRODUCT_VERSION) : '—' ?></div><div class="stat-label">Latest Version</div></div></div>
          <div class="col-6 col-md-3"><div class="stat-tile"><div class="stat-value">∞</div><div class="stat-label">Access Duration</div></div></div>
          <div class="col-6 col-md-3"><div class="stat-tile"><div class="stat-value">Free</div><div class="stat-label">Future Updates</div></div></div>
        </div>

        <div class="app-card mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0"><i class="bi bi-box-seam-fill text-primary me-2"></i>My Bundles</h5>
            <a href="my-downloads.php" class="small text-decoration-none">View all &rarr;</a>
          </div>

          <?php if (empty($bundles)): ?>
            <p class="text-secondary">You haven't purchased a bundle yet.</p>
            <a href="checkout.php" class="btn btn-primary rounded-pill px-4 py-2 gradient-btn">Get the Bundle</a>
          <?php else: ?>
            <div class="d-flex flex-column gap-3">
              <?php foreach ($bundles as $bundle): ?>
                <div class="bundle-row">
                  <div class="d-flex align-items-center gap-3">
                    <div class="bundle-icon"><i class="bi bi-collection-play-fill"></i></div>
                    <div>
                      <div class="fw-semibold"><?= e(PRODUCT_NAME) ?></div>
                      <div class="text-muted small">Purchased <?= formatDate($bundle['purchased_at']) ?> • Version <?= e($bundle['version'] ?? PRODUCT_VERSION) ?></div>
                    </div>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <span class="status-pill paid"><i class="bi bi-check-circle-fill"></i> Active</span>
                    <a href="download.php" class="btn btn-outline-primary-soft rounded-pill px-3 py-2"><i class="bi bi-download me-1"></i> Download</a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>

        <div class="row g-4">
          <div class="col-md-6">
            <div class="app-card app-card-soft h-100">
              <h6 class="fw-bold mb-2"><i class="bi bi-receipt text-primary me-1"></i> Invoices</h6>
              <p class="text-secondary small">Download professional invoices for every purchase.</p>
              <a href="invoice.php" class="small text-decoration-none">View invoices &rarr;</a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="app-card app-card-soft h-100">
              <h6 class="fw-bold mb-2"><i class="bi bi-life-preserver text-primary me-1"></i> Need Help?</h6>
              <p class="text-secondary small">Our support team is here for payment or download issues.</p>
              <a href="support.php" class="small text-decoration-none">Get support &rarr;</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
