<?php
if (!defined('ROOT_PATH')) {
    $root = realpath(__DIR__ . '/..');
    define('ROOT_PATH', rtrim($root, '/\\') . DIRECTORY_SEPARATOR);
}

// Ensure ASSETS_URL is defined
if (!defined('ASSETS_URL')) {
    define('ASSETS_URL', '/assets/');
}
?>
<!-- Core Vendor JS (Landing Page Only) -->
<script src="<?= ASSETS_URL ?>vendor/jquery/jquery.js" defer></script>
<script src="<?= ASSETS_URL ?>vendor/popper/popper.js" defer></script>
<script src="<?= ASSETS_URL ?>vendor/bootstrap/bootstrap.bundle.min.js" defer></script>
<script src="<?= ASSETS_URL ?>vendor/animate-on-scroll/animate-on-scroll.js" defer></script>
<!-- Splide.js Core Library -->
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js" defer></script>

<!-- Custom JS -->
<script src="<?= ASSETS_URL ?>js/static.js?v=<?= filemtime(ROOT_PATH . 'assets/js/static.js') ?>" defer></script>
<script src="<?= ASSETS_URL ?>js/pages/hero-slider.js?v=<?= filemtime(ROOT_PATH . 'assets/js/pages/hero-slider.js') ?>" defer></script>
<script src="<?= ASSETS_URL ?>js/pages/template-slider.js?v=<?= filemtime(ROOT_PATH . 'assets/js/pages/template-slider.js') ?>" defer></script>