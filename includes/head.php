<?php
// Config should already be loaded by main page file
// Ensure ROOT_PATH is defined
if (!defined('ROOT_PATH')) {
    $root = realpath(__DIR__ . '/..');
    define('ROOT_PATH', rtrim($root, '/\\') . DIRECTORY_SEPARATOR);
}

// Ensure critical constants are defined (with safe defaults if not)
if (!defined('STATIC_URL')) {
    define('STATIC_URL', '/');
}
if (!defined('ASSETS_URL')) {
    define('ASSETS_URL', STATIC_URL . 'assets/');
}

// Load configurations from database if connection is available
require_once ROOT_PATH . 'config/helpers/content/web-config.php';
$site_title = 'Seutastali';
$site_description = 'Seutastali adalah platform pembuatan undangan digital profesional yang memungkinkan Anda membuat undangan pernikahan atau acara lainnya dengan cepat, elegan, dan praktis.';
$site_keywords = 'undangan digital, seutastali, undangan pernikahan online, buat undangan digital, rsvp online, digital invitation indonesia';

if (isset($conn) && function_exists('get_config')) {
    $site_title = get_config($conn, 'site_title', $site_title);
    $site_description = get_config($conn, 'site_description', $site_description);
    $site_keywords = get_config($conn, 'site_keywords', $site_keywords);
}

// Determine theme from data-bs-theme attribute if set (for preview/iframe)
$theme = 'light'; // default
if (isset($data_bs_theme)) {
    $theme = $data_bs_theme;
}
?>
<!DOCTYPE html>
<html
    lang="en"
    data-bs-theme="<?= $theme ?>"
    data-assets-path="<?= ASSETS_URL ?>"
    data-template="vertical-menu-template-starter">

<head>
    <meta charset=" utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">

    <script>
        // Prevent pinch-to-zoom on touch devices
        document.addEventListener('gesturestart', function(e) {
            e.preventDefault();
        });
        document.addEventListener('touchstart', function(e) {
            if (e.touches.length > 1) {
                e.preventDefault();
            }
        }, { passive: false });
        // Prevent Ctrl + wheel zoom on desktop
        document.addEventListener('wheel', function(e) {
            if (e.ctrlKey) {
                e.preventDefault();
            }
        }, { passive: false });
        // Prevent Ctrl + +/-/0 zoom on desktop
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && (e.key === '=' || e.key === '-' || e.key === '+' || e.key === '0')) {
                e.preventDefault();
            }
        });

        // Apply theme ASAP (sinkron dengan Helpers.js).
        (function() {
            try {
                var templateName = document.documentElement.getAttribute('data-template') || 'vertical-menu-template-starter';
                var key = 'templateCustomizer-' + templateName + '--Theme';
                var storedTheme = localStorage.getItem(key) || 'light';
                var applied = storedTheme;
                if (storedTheme === 'system') {
                    applied = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                }
                document.documentElement.setAttribute('data-bs-theme', applied);
            } catch (e) {}
        })();
    </script>

    <title><?= isset($page_title) ? $page_title . ' - ' . $site_title : $site_title ?></title>

    <link rel="canonical" href="<?= STATIC_URL ?>">

    <!-- Core Vendor Styles (Landing Page Only) -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ASSETS_URL ?>vendor/animate-on-scroll/animate-on-scroll.css">
    <!-- Splide.js Core Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap">

    <link rel="stylesheet" href="<?= ASSETS_URL ?>css/style.css">



    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap">

    <?php include(__DIR__ . '/ico.php'); ?>

    <!-- Primary & Social Meta Tags -->
    <?php include(__DIR__ . '/meta.php'); ?>

    <?php if (isset($extraHead)) {
        echo $extraHead;
    } ?>

</head>

<body data-aos-easing="ease" data-aos-duration="400" data-aos-delay="0" tabindex="0">
    <?php if (empty($disable_page_loader)): ?>
        <div class="page-loader" id="pageLoader">
            <div class="loader"></div>
        </div>
        <script>
            // Emergency Fail-Safe: Force hide loader if static.js fails to load
            setTimeout(function() {
                var loader = document.getElementById('pageLoader');
                if (loader && !loader.dataset.hidden) {
                    loader.style.opacity = '0';
                    loader.style.transition = 'opacity 0.5s ease';
                    setTimeout(function() {
                        loader.remove();
                        document.documentElement.classList.remove('loading');
                        document.body.classList.remove('loading');
                    }, 500);
                }
            }, 4000); // 4 seconds timeout
        </script>
    <?php endif; ?>