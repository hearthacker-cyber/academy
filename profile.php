<?php
require_once __DIR__ . '/config/config.php';
requireLogin();

$customer = currentCustomer();
$success = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $fullName = trim($_POST['full_name'] ?? '');
    $mobile   = trim($_POST['mobile'] ?? '');

    if (mb_strlen($fullName) < 2) $errors[] = 'Please enter a valid full name.';
    if (!isValidMobile($mobile)) $errors[] = 'Please enter a valid mobile number.';

    if (empty($errors)) {
        $stmt = getDB()->prepare('UPDATE customers SET full_name = ?, mobile = ? WHERE id = ?');
        $stmt->execute([$fullName, $mobile, $customer['id']]);
        $customer = currentCustomer();
        $success = 'Your profile has been updated.';
    }
}

$db = getDB();
$histStmt = $db->prepare('SELECT * FROM orders WHERE customer_id = ? ORDER BY created_at DESC');
$histStmt->execute([$customer['id']]);
$history = $histStmt->fetchAll();

$pageTitle = 'My Profile — ' . SITE_NAME;
$activeNav = 'dashboard';
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3" data-aos="fade-right">
        <div class="dash-sidebar">
          <a href="dashboard.php" class="dash-link mb-1"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
          <a href="my-downloads.php" class="dash-link mb-1"><i class="bi bi-download"></i> My Downloads</a>
          <a href="invoice.php" class="dash-link mb-1"><i class="bi bi-receipt"></i> Invoices</a>
          <a href="profile.php" class="dash-link active mb-1"><i class="bi bi-person-gear"></i> Profile</a>
          <a href="support.php" class="dash-link mb-1"><i class="bi bi-life-preserver"></i> Support</a>
          <a href="logout.php" class="dash-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
      </div>

      <div class="col-lg-9" data-aos="fade-up">
        <h2 class="fw-bold mb-1">My Profile</h2>
        <p class="text-secondary mb-4">Manage your account details.</p>

        <?php if ($success): ?><div class="alert alert-success rounded-4"><?= e($success) ?></div><?php endif; ?>
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger rounded-4"><ul class="mb-0 ps-3"><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
        <?php endif; ?>

        <div class="app-card mb-4">
          <h5 class="fw-bold mb-3">Account Details</h5>
          <form method="post" action="profile.php">
            <?= csrfField() ?>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label-premium">Full Name</label>
                <input type="text" name="full_name" class="form-control-premium" value="<?= e($customer['full_name']) ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label-premium">Email Address</label>
                <input type="email" class="form-control-premium" value="<?= e($customer['email']) ?>" disabled>
              </div>
              <div class="col-md-6">
                <label class="form-label-premium">Mobile Number</label>
                <input type="tel" name="mobile" class="form-control-premium" value="<?= e($customer['mobile']) ?>" maxlength="10" required>
              </div>
              <div class="col-md-6">
                <label class="form-label-premium">Customer Since</label>
                <input type="text" class="form-control-premium" value="<?= e(formatDate($customer['created_at'])) ?>" disabled>
              </div>
            </div>
            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 gradient-btn mt-3">Save Changes</button>
          </form>
        </div>

        <div class="app-card">
          <h5 class="fw-bold mb-3">Purchase History</h5>
          <?php if (empty($history)): ?>
            <p class="text-secondary">No purchases yet.</p>
          <?php else: ?>
            <div class="table-responsive">
              <table class="premium-table">
                <thead><tr><th>Order</th><th>Date</th><th>Amount</th><th>Status</th><th></th></tr></thead>
                <tbody>
                  <?php foreach ($history as $order): ?>
                    <tr>
                      <td>#<?= (int) $order['id'] ?></td>
                      <td><?= formatDate($order['created_at']) ?></td>
                      <td><?= formatRupees($order['amount']) ?></td>
                      <td><span class="status-pill <?= e($order['status']) ?>"><?= e(ucfirst($order['status'])) ?></span></td>
                      <td><a href="invoice.php?order_id=<?= (int) $order['id'] ?>" class="small text-decoration-none">Invoice</a></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
