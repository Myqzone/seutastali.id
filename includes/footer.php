<?php
if (!defined('ROOT_PATH')) {
  $root = realpath(__DIR__ . '/../..');
  define('ROOT_PATH', rtrim($root, '/\\') . DIRECTORY_SEPARATOR);
}
?>
<footer class="footer">
  <div class="container">
    <div class="py-5 pb-0 pb-lg-5">
      <div class="row">
        <div class="col-12 col-lg-5 mb-4 mb-lg-0">
          <div class="d-flex flex-column gap-4 me-xl-5">
            <a href="<?= MAIN_SITE_URL ?>" class="d-block">
              <img src="<?= ASSETS_URL ?>media/logo/logo-full.webp" width="120" height="auto" alt="Seutastali" class="img-fluid">
            </a>
            <p class="mb-0">
              Platform pembuatan undangan digital profesional yang elegan, praktis, dan berkesan untuk momen istimewa Anda.
            </p>
            <div class="hstack gap-3 py-3 py-lg-0">
              <a href="https://www.instagram.com/seutastali.id/" target="_blank" class="fs-4"><i class="fa-brands fa-instagram"></i></a>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-lg-4 mb-5 mb-lg-0">
          <div class="d-flex flex-column gap-3">
            <h6 class="mb-0 fw-semibold">Menu Utama</h6>
            <ul class="footer-menu list-unstyled mb-0 d-flex flex-column gap-2">
              <li><a href="<?= rtrim(MAIN_SITE_URL, '/') ?>/about">About Us</a></li>
              <li><a href="<?= rtrim(MAIN_SITE_URL, '/') ?>/contact">Contact Us</a></li>
            </ul>
          </div>
        </div>

        <div class="col-md-4 col-lg-2 mb-5 mb-lg-0 d-lg-none">
          <div class="d-flex flex-column gap-3">
            <h6 class="mb-0 fw-semibold">Legal</h6>
            <ul class="footer-menu list-unstyled mb-0 d-flex flex-column gap-2">
              <li><a href="<?= MAIN_SITE_URL ?>privacy-policy">Privacy Policy</a></li>
              <li><a href="<?= MAIN_SITE_URL ?>refund-policy">Refund Policy</a></li>
              <li><a href="<?= MAIN_SITE_URL ?>terms">Terms of Service</a></li>
            </ul>
          </div>
        </div>

        <div class="col-md-4 col-lg-3 mb-5 mb-lg-0">
          <div class="d-flex flex-column gap-2">
            <h6 class="mb-0 fw-semibold">Find Us</h6>
            <p class="mb-0">Jakarta, Indonesia</p>
            <a class="text-decoration-underline" href="mailto:hello@seutastali.id">hello@seutastali.id</a>
            <a class="text-decoration-underline" href="https://wa.me/6285195501712">+62 851 9550 1712</a>
          </div>
        </div>
      </div>

    </div>
    <div class="text-left copyright d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-2">
      <div class="small">
        <p class="mb-0">
          © <script>
            document.write(new Date().getFullYear())
          </script> <a href="<?= MAIN_SITE_URL ?>" class="fw-semibold">Seutas Tali</a> by <a href="https://sensedegrees.com" target="_blank" class="fw-semibold">Sense Degrees</a>.
          <span class="d-block d-lg-inline-block ms-lg-2">All Rights Reserved</span>
        </p>
      </div>
      <div class="d-none d-lg-flex gap-3 small">
        <a href="<?= MAIN_SITE_URL ?>privacy-policy">Privacy Policy</a>
        <span class="text-muted opacity-25">|</span>
        <a href="<?= MAIN_SITE_URL ?>refund-policy">Refund Policy</a>
        <span class="text-muted opacity-25">|</span>
        <a href="<?= MAIN_SITE_URL ?>terms">Terms of Service</a>
      </div>
    </div>
  </div>
</footer>