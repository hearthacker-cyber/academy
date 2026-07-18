<!-- ====== FOOTER ====== -->
<footer class="footer py-5" style="background:#050508;color:#8B949E;">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <h5 class="fw-bold" style="color:#E6EDF3;"><i class="bi bi-shield-fill-check" style="color:#00FF41;"></i> HIFI11 ACADEMY</h5>
        <p class="small">🔥 Premium Digital Bundle Pack — Instant Download, Own Forever.</p>
        <p class="small"><i class="bi bi-phone me-2"></i> +91 <?= e(substr(SUPPORT_WHATSAPP, 2)) ?></p>
        <p class="small"><i class="bi bi-instagram me-2"></i> <a href="<?= e(SUPPORT_INSTAGRAM) ?>" target="_blank" style="color:#E6EDF3;text-decoration:none;">@_devil_heart_hacker</a></p>
        <p class="small"><i class="bi bi-telegram me-2"></i> <a href="<?= e(SUPPORT_TELEGRAM) ?>" target="_blank" style="color:#E6EDF3;text-decoration:none;">@devil_heart_hack</a></p>
      </div>
      <div class="col-md-2">
        <h6 style="color:#E6EDF3;">Quick Links</h6>
        <ul class="list-unstyled small">
          <li><a href="index.php" style="color:#8B949E;text-decoration:none;">Home</a></li>
          <li><a href="checkout.php" style="color:#8B949E;text-decoration:none;">Buy Bundle</a></li>
          <li><a href="login.php" style="color:#8B949E;text-decoration:none;">Login</a></li>
          <li><a href="dashboard.php" style="color:#8B949E;text-decoration:none;">Dashboard</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <h6 style="color:#E6EDF3;">Legal</h6>
        <ul class="list-unstyled small">
          <li><a href="privacy-policy.php" style="color:#8B949E;text-decoration:none;">Privacy Policy</a></li>
          <li><a href="refund-policy.php" style="color:#8B949E;text-decoration:none;">Refund Policy</a></li>
          <li><a href="terms.php" style="color:#8B949E;text-decoration:none;">Terms &amp; Conditions</a></li>
          <li><a href="support.php" style="color:#8B949E;text-decoration:none;">Support</a></li>
        </ul>
      </div>
      <div class="col-md-4 text-md-end">
        <h6 style="color:#E6EDF3;">Founder</h6>
        <p class="small mb-0">SURYA PRAKASH E</p>
        <p class="small" style="color:#484F58;">CEO, HIFI11 Technologies</p>
        <p class="small mt-3 mb-0">&copy; <?= date('Y') ?> HIFI11 Academy. All Rights Reserved.</p>
        <p class="small" style="color:#484F58;">Made with care in Tamil Nadu, India.</p>
      </div>
    </div>
  </div>
</footer>

<!-- ====== FLOATING SOCIAL BUTTONS ====== -->
<a href="https://wa.me/<?= e(SUPPORT_WHATSAPP) ?>" target="_blank" class="social-float whatsapp" aria-label="WhatsApp">
  <i class="bi bi-whatsapp"></i><span class="tooltip-text">WhatsApp</span>
</a>
<a href="<?= e(SUPPORT_INSTAGRAM) ?>" target="_blank" class="social-float instagram" aria-label="Instagram">
  <i class="bi bi-instagram"></i><span class="tooltip-text">Instagram</span>
</a>
<a href="<?= e(SUPPORT_TELEGRAM) ?>" target="_blank" class="social-float telegram" aria-label="Telegram">
  <i class="bi bi-telegram"></i><span class="tooltip-text">Telegram</span>
</a>
<a href="#" class="social-float top" id="scrollTop" aria-label="Scroll to top">
  <i class="bi bi-chevron-up"></i><span class="tooltip-text">Back to top</span>
</a>

<!-- ====== SCRIPTS ====== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  (function () {
    if (window.AOS) AOS.init({ once: false, duration: 800 });

    var scrollTop = document.getElementById('scrollTop');
    if (scrollTop) {
      scrollTop.addEventListener('click', function (e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    }

    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
      a.addEventListener('click', function (e) {
        var href = this.getAttribute('href');
        if (href === '#') return;
        var target = document.querySelector(href);
        if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
      });
    });
  })();
</script>
</body>
</html>
