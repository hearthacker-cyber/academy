<?php
require_once __DIR__ . '/config/config.php';

/**
 * download.php
 * =============
 * The "here's your bundle, click to download" landing page.
 * This page NEVER serves the file itself — it only decides whether to
 * show a valid download link (pointing at download-file.php, which
 * re-checks everything independently) or a 403 / login redirect.
 *
 * Access rules:
 *  - Not logged in                       -> redirect to login.php
 *  - Logged in, no ?token= given          -> look up the customer's own
 *                                            most recent PAID order and
 *                                            mint a fresh token for it
 *  - Logged in, ?token= given             -> must pass authorizeDownload()
 *                                            (belongs to THIS customer,
 *                                            not expired/revoked, order
 *                                            paid, limit not reached)
 *    otherwise -> 403 Forbidden (never a silent redirect to success)
 */

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$customerId = (int) $_SESSION['customer_id'];
$token = trim($_GET['token'] ?? '');

function renderForbidden(string $message): void
{
    http_response_code(403);
    $pageTitle = 'Access Denied — ' . SITE_NAME;
    require __DIR__ . '/includes/header.php';
    ?>
    <section class="premium-bg page-hero text-center" style="min-height:60vh; display:flex; align-items:center;">
      <div class="container">
        <i class="bi bi-shield-exclamation text-danger" style="font-size:3rem;"></i>
        <h2 class="fw-bold mt-3">403 — Access Denied</h2>
        <p class="text-secondary"><?= e($message) ?></p>
        <a href="my-downloads.php" class="btn btn-primary rounded-pill px-4 py-3 gradient-btn mt-2">Go to My Downloads</a>
      </div>
    </section>
    <?php
    require __DIR__ . '/includes/footer.php';
    exit;
}

if ($token !== '') {
    // A specific token was supplied (e.g. straight after checkout) —
    // validate it strictly. Any failure here is a 403, never a redirect
    // to a success/download state.
    $auth = authorizeDownload($token, $customerId);
    if (!$auth['ok']) {
        renderForbidden('This download link is invalid, expired, or does not belong to your account.');
    }
    $order = $auth['order'];
    $version = $auth['version'];
    $downloadToken = $token;
} else {
    // No token in the URL — fall back to the customer's own purchase
    // history (never someone else's) and mint a fresh token for it.
    $bundles = getPurchasedBundles($customerId);
    if (empty($bundles)) {
        renderForbidden('No paid purchase was found on your account for this bundle.');
    }

    $db = getDB();
    $orderStmt = $db->prepare('SELECT * FROM orders WHERE id = ? AND customer_id = ? AND status = "paid" LIMIT 1');
    $orderStmt->execute([(int) $bundles[0]['order_id'], $customerId]);
    $order = $orderStmt->fetch();

    if (!$order) {
        renderForbidden('No paid purchase was found on your account for this bundle.');
    }

    $verStmt = $db->prepare('SELECT * FROM bundle_versions WHERE is_current = 1 ORDER BY released_at DESC LIMIT 1');
    $verStmt->execute();
    $version = $verStmt->fetch() ?: [
        'version'       => PRODUCT_VERSION,
        'file_size_mb'  => 4200,
        'released_at'   => date('Y-m-d'),
        'release_notes' => 'Initial release.',
    ];

    $downloadToken = issueDownloadToken($customerId, (int) $order['id'], DOWNLOAD_MAX_COUNT);
}

$customer = currentCustomer();

$pageTitle = 'Download Your Bundle — ' . SITE_NAME;
require __DIR__ . '/includes/header.php';
?>

<section class="premium-bg page-hero" style="position:relative; min-height:85vh; display:flex; align-items:center;">
  <div class="glow-sphere" style="width:400px;height:400px;background:#00FF41;top:-15%;left:-8%;"></div>
  <div class="glow-sphere" style="width:300px;height:300px;background:#00D4FF;bottom:-10%;right:-5%;"></div>
  <div class="grid-overlay"></div>

  <!-- Floating particles -->
  <div class="dl-particle dl-p1"><i class="bi bi-shield-fill-check"></i></div>
  <div class="dl-particle dl-p2"><i class="bi bi-lock-fill"></i></div>
  <div class="dl-particle dl-p3"><i class="bi bi-file-earmark-zip-fill"></i></div>
  <div class="dl-particle dl-p4"><i class="bi bi-cloud-arrow-down-fill"></i></div>
  <div class="dl-particle dl-p5"><i class="bi bi-patch-check-fill"></i></div>

  <div class="container position-relative" style="z-index:1;">
    <div class="row justify-content-center">
      <div class="col-lg-7">

        <!-- Success check animation -->
        <div class="dl-check-wrap" data-aos="zoom-in">
          <div class="dl-check-circle">
            <i class="bi bi-check-lg"></i>
          </div>
          <div class="dl-check-ring dl-check-ring1"></div>
          <div class="dl-check-ring dl-check-ring2"></div>
          <div class="dl-check-ring dl-check-ring3"></div>
        </div>

        <div class="app-card text-center dl-main-card" data-aos="fade-up" data-aos-delay="200">
          <h2 class="fw-bold mt-3"><?= e(PRODUCT_NAME) ?></h2>
          <p class="text-secondary">Your secure download is ready, <?= e(explode(' ', $customer['full_name'] ?? 'there')[0]) ?>.</p>

          <!-- Stat tiles with staggered animation -->
          <div class="row g-3 my-4">
            <div class="col-4" data-aos="zoom-in" data-aos-delay="300">
              <div class="stat-tile dl-stat-tile">
                <div class="stat-value"><?= e($version['version']) ?></div>
                <div class="stat-label">Version</div>
              </div>
            </div>
            <div class="col-4" data-aos="zoom-in" data-aos-delay="400">
              <div class="stat-tile dl-stat-tile">
                <div class="stat-value"><?= e(formatDate($version['released_at'])) ?></div>
                <div class="stat-label">Released</div>
              </div>
            </div>
            <div class="col-4" data-aos="zoom-in" data-aos-delay="500">
              <div class="stat-tile dl-stat-tile">
                <div class="stat-value"><?= number_format(($version['file_size_mb'] ?? 4200)) ?> MB</div>
                <div class="stat-label">File Size</div>
              </div>
            </div>
          </div>

          <!-- Glowing download button -->
          <div class="dl-btn-wrap" data-aos="zoom-in" data-aos-delay="600">
            <a href="download-file.php?token=<?= urlencode($downloadToken) ?>" id="dlBtn" class="btn btn-primary btn-lg rounded-pill px-5 py-3 gradient-btn dl-download-btn">
              <i class="bi bi-download me-2"></i> Download Now
            </a>
            <div class="dl-btn-glow"></div>
          </div>

          <p class="text-muted small mt-3">Order placed on <?= formatDate($order['created_at']) ?> • Purchased under <?= e($customer['email'] ?? '') ?></p>

          <div class="app-card-soft text-start mt-4" data-aos="fade-up" data-aos-delay="700">
            <h6 class="fw-bold mb-2"><i class="bi bi-info-circle text-primary me-1"></i> Instructions</h6>
            <ul class="small text-secondary mb-0">
              <li>Extract the ZIP file using WinRAR / 7-Zip / built-in extractor.</li>
              <li>Videos and PDFs are organized by module inside the folder.</li>
              <li>This download link is valid for 24 hours and can be reused up to <?= (int) DOWNLOAD_MAX_COUNT ?> times.</li>
              <li>Need a fresh link later? Just visit <a href="my-downloads.php">My Downloads</a> from your dashboard.</li>
            </ul>
          </div>

          <?php if (!empty($version['release_notes'])): ?>
            <p class="text-muted small mt-3 mb-0" data-aos="fade-up" data-aos-delay="800"><i class="bi bi-megaphone me-1"></i> <?= e($version['release_notes']) ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
/* ---------- DOWNLOAD PAGE ANIMATIONS ---------- */
.dl-check-wrap {
  width: 110px; height: 110px; margin: 0 auto 1.5rem; position: relative;
  display: flex; align-items: center; justify-content: center;
}
.dl-check-circle {
  width: 90px; height: 90px; border-radius: 50%;
  background: linear-gradient(135deg, #00FF41, #00D4FF);
  display: flex; align-items: center; justify-content: center;
  animation: dlPopIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
  box-shadow: 0 16px 48px -8px rgba(0,255,65,0.4);
  position: relative; z-index: 2;
}
.dl-check-circle i { font-size: 2.8rem; color: #0a0a0f; animation: dlCheckDraw 0.4s 0.4s both; }
@keyframes dlPopIn { 0% { transform: scale(0) rotate(-20deg); opacity: 0; } 100% { transform: scale(1) rotate(0); opacity: 1; } }
@keyframes dlCheckDraw { 0% { opacity: 0; transform: scale(0.4); } 100% { opacity: 1; transform: scale(1); } }

.dl-check-ring {
  position: absolute; border-radius: 50%;
  border: 2px solid #00FF4140;
  animation: dlRingPulse 2.2s ease-out infinite;
}
.dl-check-ring1 { inset: -10px; animation-delay: 0s; }
.dl-check-ring2 { inset: -22px; animation-delay: 0.5s; }
.dl-check-ring3 { inset: -34px; animation-delay: 1s; }
@keyframes dlRingPulse {
  0% { transform: scale(0.85); opacity: 0.7; }
  100% { transform: scale(1.35); opacity: 0; }
}

/* Floating particles */
.dl-particle {
  position: absolute; font-size: 1.5rem; color: #00FF4118;
  pointer-events: none; z-index: 0;
  animation: dlFloat 8s ease-in-out infinite;
}
.dl-p1 { top: 12%; left: 8%; animation-delay: 0s; font-size: 2rem; color: #00FF4115; }
.dl-p2 { top: 30%; right: 6%; animation-delay: 1.5s; color: #10B98115; }
.dl-p3 { bottom: 25%; left: 5%; animation-delay: 3s; color: #00D4FF15; }
.dl-p4 { top: 50%; right: 12%; animation-delay: 2s; color: #00FF4112; font-size: 1.8rem; }
.dl-p5 { bottom: 15%; right: 8%; animation-delay: 4s; color: #10B98112; }
@keyframes dlFloat {
  0% { transform: translateY(0) rotate(0deg) scale(1); }
  33% { transform: translateY(-20px) rotate(8deg) scale(1.05); }
  66% { transform: translateY(8px) rotate(-5deg) scale(0.97); }
  100% { transform: translateY(0) rotate(0deg) scale(1); }
}

/* Main card */
.dl-main-card {
  box-shadow: 0 24px 64px -16px rgba(0,255,65,0.06);
  border: 1px solid rgba(0,255,65,0.12);
  transition: all 0.3s;
}
.dl-main-card:hover { box-shadow: 0 32px 80px -16px rgba(0,255,65,0.12); }

/* Stat tiles */
.dl-stat-tile {
  transition: all 0.3s;
  position: relative;
  overflow: hidden;
}
.dl-stat-tile::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg, #00FF41, #00D4FF);
  transform: scaleX(0); transform-origin: left;
  transition: transform 0.4s;
}
.dl-stat-tile:hover::before { transform: scaleX(1); }
.dl-stat-tile:hover { border-color: #00FF4140; transform: translateY(-4px); box-shadow: 0 12px 28px -8px rgba(0,255,65,0.1); }

/* Download button wrap */
.dl-btn-wrap { position: relative; display: inline-block; }
.dl-download-btn {
  position: relative; z-index: 2;
  animation: dlBtnPulse 2.5s ease-in-out infinite;
}
@keyframes dlBtnPulse {
  0% { box-shadow: 0 8px 28px rgba(0,255,65,0.2); }
  50% { box-shadow: 0 8px 48px rgba(0,255,65,0.4), 0 0 0 8px rgba(0,255,65,0.06); }
  100% { box-shadow: 0 8px 28px rgba(0,255,65,0.2); }
}
.dl-download-btn:hover { animation: none; transform: translateY(-3px) scale(1.03); }
.dl-btn-glow {
  position: absolute; top: 50%; left: 50%;
  width: 110%; height: 140%; transform: translate(-50%, -50%);
  background: radial-gradient(ellipse, rgba(0,255,65,0.12) 0%, transparent 70%);
  pointer-events: none; z-index: 1;
  animation: dlGlowPulse 2.5s ease-in-out infinite;
}
@keyframes dlGlowPulse {
  0%, 100% { opacity: 0.5; transform: translate(-50%, -50%) scale(1); }
  50% { opacity: 1; transform: translate(-50%, -50%) scale(1.15); }
}

@media (max-width: 768px) {
  .dl-particle { display: none; }
  .dl-check-circle { width: 70px; height: 70px; }
  .dl-check-circle i { font-size: 2rem; }
  .dl-check-ring1 { inset: -8px; }
  .dl-check-ring2 { inset: -16px; }
  .dl-check-ring3 { inset: -24px; }
}
</style>

<!-- Downloading Overlay -->
<div class="dl-overlay" id="dlOverlay">
  <div class="dl-overlay-content">
    <div class="dl-spinner-ring">
      <svg viewBox="0 0 120 120">
        <defs><linearGradient id="dlGrad" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#00CC33"/><stop offset="50%" stop-color="#00FF41"/><stop offset="100%" stop-color="#00D4FF"/></linearGradient></defs>
        <circle class="dl-spinner-bg" cx="60" cy="60" r="52" />
        <circle class="dl-spinner-track" cx="60" cy="60" r="52" />
      </svg>
      <div class="dl-spinner-icon"><i class="bi bi-cloud-arrow-down-fill"></i></div>
    </div>
    <h3 class="dl-overlay-title">Preparing Your Download</h3>
    <p class="dl-overlay-sub" id="dlStatus">Verifying your purchase...</p>
    <div class="dl-progress-bar">
      <div class="dl-progress-fill" id="dlProgress"></div>
    </div>
    <p class="dl-overlay-note">Your file will start downloading shortly</p>
  </div>
</div>

<style>
/* ---------- DOWNLOADING OVERLAY ---------- */
.dl-overlay {
  position: fixed; inset: 0; z-index: 9999;
  background: rgba(15, 23, 42, 0.92);
  backdrop-filter: blur(20px);
  display: flex; align-items: center; justify-content: center;
  opacity: 0; visibility: hidden;
  transition: opacity 0.4s, visibility 0.4s;
}
.dl-overlay.active { opacity: 1; visibility: visible; }
.dl-overlay-content { text-align: center; color: #fff; padding: 2rem; }

/* Spinning ring */
.dl-spinner-ring {
  width: 140px; height: 140px; margin: 0 auto 2rem; position: relative;
}
.dl-spinner-ring svg {
  width: 100%; height: 100%; transform: rotate(0deg);
  animation: dlSpinSvg 1.6s linear infinite;
}
@keyframes dlSpinSvg { 100% { transform: rotate(360deg); } }
.dl-spinner-bg { fill: none; stroke: rgba(255,255,255,0.1); stroke-width: 6; }
.dl-spinner-track {
  fill: none; stroke: url(#dlGrad); stroke-width: 6;
  stroke-linecap: round;
  stroke-dasharray: 327; stroke-dashoffset: 200;
  animation: dlDash 1.6s ease-in-out infinite;
}
.dl-spinner-icon {
  position: absolute; top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  font-size: 2.8rem; color: #00FF41;
  animation: dlIconBounce 1.6s ease-in-out infinite;
}
@keyframes dlDash {
  0% { stroke-dashoffset: 327; }
  50% { stroke-dashoffset: 100; }
  100% { stroke-dashoffset: 327; }
}
@keyframes dlIconBounce {
  0%, 100% { transform: translate(-50%, -50%) translateY(0); }
  50% { transform: translate(-50%, -50%) translateY(-10px); }
}

.dl-overlay-title {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 1.6rem; font-weight: 700; margin-bottom: 0.5rem;
}
.dl-overlay-sub {
  color: rgba(255,255,255,0.6); font-size: 0.95rem; margin-bottom: 1.5rem;
  min-height: 24px;
}

/* Progress bar */
.dl-progress-bar {
  width: 260px; height: 6px; margin: 0 auto 1rem;
  background: rgba(255,255,255,0.1); border-radius: 20px; overflow: hidden;
}
.dl-progress-fill {
  height: 100%; width: 0%;
  background: linear-gradient(90deg, #00CC33, #00FF41, #00D4FF);
  background-size: 200% 100%;
  border-radius: 20px;
  transition: width 0.5s ease;
  animation: dlShimmer 1.5s ease-in-out infinite;
}
@keyframes dlShimmer {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}
.dl-overlay-note {
  color: rgba(255,255,255,0.4); font-size: 0.8rem;
}
</style>

<script>
(function() {
  var btn = document.getElementById('dlBtn');
  var overlay = document.getElementById('dlOverlay');
  var progress = document.getElementById('dlProgress');
  var status = document.getElementById('dlStatus');
  var href = btn.href;

  var stages = [
    { pct: 20,  text: 'Verifying your purchase...' },
    { pct: 50,  text: 'Preparing secure file...' },
    { pct: 80,  text: 'Starting download...' },
    { pct: 100, text: 'Download started!' }
  ];

  function hideOverlay() {
    overlay.classList.remove('active');
  }

  btn.addEventListener('click', function(e) {
    e.preventDefault();
    overlay.classList.add('active');
    progress.style.width = '0%';

    var i = 0;
    var timer = setInterval(function() {
      if (i < stages.length) {
        progress.style.width = stages[i].pct + '%';
        status.textContent = stages[i].text;
        i++;
      } else {
        clearInterval(timer);
        var iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = href;
        document.body.appendChild(iframe);
        setTimeout(hideOverlay, 2000);
      }
    }, 700);
  });
})();
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
