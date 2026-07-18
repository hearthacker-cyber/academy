<?php
require_once __DIR__ . '/config/config.php';
requireLogin();

$customer = currentCustomer();
$bundles = getPurchasedBundles((int) $_SESSION['customer_id']);

$db = getDB();
$versionsStmt = $db->prepare('SELECT * FROM bundle_versions ORDER BY released_at DESC');
$versionsStmt->execute();
$allVersions = $versionsStmt->fetchAll();
$currentVersion = null;
foreach ($allVersions as $v) {
    if (!empty($v['is_current'])) { $currentVersion = $v; break; }
}

$pageTitle = 'My Downloads — ' . SITE_NAME;
$activeNav = 'dashboard';
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3" data-aos="fade-right">
        <div class="dash-sidebar">
          <a href="dashboard.php" class="dash-link mb-1"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
          <a href="my-downloads.php" class="dash-link active mb-1"><i class="bi bi-download"></i> My Downloads</a>
          <a href="invoice.php" class="dash-link mb-1"><i class="bi bi-receipt"></i> Invoices</a>
          <a href="profile.php" class="dash-link mb-1"><i class="bi bi-person-gear"></i> Profile</a>
          <a href="support.php" class="dash-link mb-1"><i class="bi bi-life-preserver"></i> Support</a>
          <a href="logout.php" class="dash-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
      </div>

      <div class="col-lg-9" data-aos="fade-up">
        <h2 class="fw-bold mb-1">My Downloads</h2>
        <p class="text-secondary mb-4">Re-download your bundles anytime and check for updates.</p>

        <?php if (empty($bundles)): ?>
          <div class="app-card text-center">
            <i class="bi bi-inbox text-muted" style="font-size:2.5rem;"></i>
            <p class="text-secondary mt-3">No purchases found on this account yet.</p>
            <a href="checkout.php" class="btn btn-primary rounded-pill px-4 py-2 gradient-btn">Get the Bundle</a>
          </div>
        <?php else: ?>
          <?php foreach ($bundles as $bundle):
            $ownedVersion = $bundle['version'] ?? PRODUCT_VERSION;
            $hasUpdate = $currentVersion && $ownedVersion !== $currentVersion['version'];
          ?>
            <div class="app-card mb-3">
              <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div class="d-flex gap-3">
                  <div class="bundle-icon"><i class="bi bi-collection-play-fill"></i></div>
                  <div>
                    <h5 class="fw-bold mb-1"><?= e(PRODUCT_NAME) ?></h5>
                    <p class="text-muted small mb-1">Order #<?= (int) $bundle['order_id'] ?> • Purchased <?= formatDate($bundle['purchased_at']) ?></p>
                    <span class="status-pill paid"><i class="bi bi-check-circle-fill"></i> Lifetime Access</span>
                    <?php if ($hasUpdate): ?>
                      <span class="status-pill pending ms-1"><i class="bi bi-arrow-repeat"></i> Update Available: <?= e($currentVersion['version']) ?></span>
                    <?php endif; ?>
                  </div>
                </div>
                <a href="download.php" class="btn btn-primary rounded-pill px-4 py-2 gradient-btn"><i class="bi bi-download me-1"></i> Download</a>
              </div>

              <?php if (!empty($allVersions)): ?>
                <hr class="my-3">
                <h6 class="small fw-bold text-muted text-uppercase">Version History</h6>
                <ul class="list-unstyled small mb-0">
                  <?php foreach ($allVersions as $v): ?>
                    <li class="d-flex justify-content-between py-1 border-bottom">
                      <span><?= e($v['version']) ?><?= !empty($v['is_current']) ? ' <span class="text-success">(Current)</span>' : '' ?></span>
                      <span class="text-muted"><?= formatDate($v['released_at']) ?></span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
