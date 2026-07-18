<?php
require_once __DIR__ . '/config/config.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$step = $_SESSION['login_flow']['step'] ?? 'email';
$email = $_SESSION['login_flow']['email'] ?? '';
$error = '';
$info = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $action = $_POST['action'] ?? '';

    if ($action === 'send_otp') {
        $email = trim($_POST['email'] ?? '');
        if (!isValidEmail($email)) {
            $error = 'Please enter a valid email address.';
        } else {
            $stmt = getDB()->prepare('SELECT id FROM customers WHERE email = ? LIMIT 1');
            $stmt->execute([$email]);
            if (!$stmt->fetch()) {
                $error = 'No account found for this email. Please purchase the bundle first.';
            } else {
                sendOtpPlaceholder($email);
                $_SESSION['login_flow'] = ['step' => 'otp', 'email' => $email];
                $step = 'otp';
                $info = 'An OTP has been sent to ' . e($email) . '.';
            }
        }
    }

    if ($action === 'verify_otp') {
        $otp = trim($_POST['otp'] ?? '');
        $email = $_SESSION['login_flow']['email'] ?? '';

        if (verifyOtpPlaceholder($email, $otp)) {
            $stmt = getDB()->prepare('SELECT id FROM customers WHERE email = ? LIMIT 1');
            $stmt->execute([$email]);
            $customer = $stmt->fetch();
            if ($customer) {
                $_SESSION['customer_id'] = $customer['id'];
                $_SESSION['customer_email'] = $email;
                unset($_SESSION['login_flow']);
                header('Location: dashboard.php');
                exit;
            }
        }
        $error = 'Invalid or expired OTP. Please try again.';
    }

    if ($action === 'resend_otp') {
        $email = $_SESSION['login_flow']['email'] ?? '';
        if ($email) {
            sendOtpPlaceholder($email);
            $info = 'A new OTP has been sent to ' . e($email) . '.';
        }
    }

    if ($action === 'change_email') {
        unset($_SESSION['login_flow']);
        $step = 'email';
        $email = '';
    }
}

function sendOtpPlaceholder(string $email): void
{
    $_SESSION['login_flow']['otp_debug'] = '123456';
}

function verifyOtpPlaceholder(string $email, string $otp): bool
{
    return $otp === ($_SESSION['login_flow']['otp_debug'] ?? '123456');
}

$pageTitle = 'Login — ' . SITE_NAME;
$activeNav = 'login';
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero" style="position:relative; min-height:70vh; display:flex; align-items:center;">
  <div class="glow-sphere" style="width:320px;height:320px;background:#00FF41;top:-10%;left:-8%;"></div>
  <div class="grid-overlay"></div>
  <div class="container position-relative" style="z-index:1;">
    <div class="row justify-content-center">
      <div class="col-lg-5" data-aos="fade-up">
        <div class="app-card text-center">
          <i class="bi bi-shield-lock-fill text-primary" style="font-size:2.4rem;"></i>
          <h3 class="fw-bold mt-2 mb-1">Welcome Back</h3>
          <p class="text-secondary small mb-4">Login with your email — no password needed.</p>

          <?php if ($error): ?><div class="alert alert-danger rounded-4 small"><?= e($error) ?></div><?php endif; ?>
          <?php if ($info): ?><div class="alert alert-success rounded-4 small"><?= $info ?></div><?php endif; ?>

          <?php if ($step === 'email'): ?>
            <form method="post" action="login.php" class="text-start">
              <?= csrfField() ?>
              <input type="hidden" name="action" value="send_otp">
              <label class="form-label-premium">Email Address</label>
              <div class="input-group-premium mb-3">
                <i class="bi bi-envelope field-icon"></i>
                <input type="email" name="email" class="form-control-premium has-icon" placeholder="you@example.com" value="<?= e($email) ?>" required>
              </div>
              <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill py-3 gradient-btn">
                Send OTP <i class="bi bi-arrow-right ms-2"></i>
              </button>
            </form>
          <?php else: ?>
            <form method="post" action="login.php" class="text-start">
              <?= csrfField() ?>
              <input type="hidden" name="action" value="verify_otp">
              <label class="form-label-premium text-center d-block">Enter the 6-digit OTP sent to</label>
              <p class="text-center fw-semibold mb-3"><?= e($email) ?></p>
              <div class="otp-input-group mb-4">
                <?php for ($i = 0; $i < 6; $i++): ?>
                  <input type="text" maxlength="1" inputmode="numeric" class="otp-box" data-idx="<?= $i ?>">
                <?php endfor; ?>
              </div>
              <input type="hidden" name="otp" id="otpHidden">
              <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill py-3 gradient-btn mb-2">
                Verify &amp; Login <i class="bi bi-check2 ms-2"></i>
              </button>
            </form>
            <div class="d-flex justify-content-between mt-2">
              <form method="post" action="login.php"><?= csrfField() ?><input type="hidden" name="action" value="resend_otp">
                <button type="submit" class="btn btn-link btn-sm text-decoration-none">Resend OTP</button>
              </form>
              <form method="post" action="login.php"><?= csrfField() ?><input type="hidden" name="action" value="change_email">
                <button type="submit" class="btn btn-link btn-sm text-decoration-none">Change Email</button>
              </form>
            </div>
          <?php endif; ?>

          <p class="text-muted small mt-4 mb-0">Don't have the bundle yet? <a href="checkout.php">Get it here</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.querySelectorAll('.otp-box').forEach(function (box, idx, all) {
    box.addEventListener('input', function () {
      this.value = this.value.replace(/[^0-9]/g, '');
      if (this.value && idx < all.length - 1) all[idx + 1].focus();
      syncOtp();
    });
    box.addEventListener('keydown', function (e) {
      if (e.key === 'Backspace' && !this.value && idx > 0) all[idx - 1].focus();
    });
  });
  function syncOtp() {
    var otp = Array.from(document.querySelectorAll('.otp-box')).map(function (b) { return b.value; }).join('');
    var hidden = document.getElementById('otpHidden');
    if (hidden) hidden.value = otp;
  }
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
