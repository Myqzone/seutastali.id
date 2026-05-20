<?php

/**
 * System Down / Maintenance Page (503 Service Unavailable)
 * Location: errors/system-down.php
 * Standalone fail-safe page (no layout dependencies)
 */

if (!defined('ROOT_PATH')) {
    $rootPath = realpath(__DIR__);
    while ($rootPath && !file_exists($rootPath . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'app.php')) {
        $parent = dirname($rootPath);
        if ($parent === $rootPath) {
            break;
        }
        $rootPath = $parent;
    }
    define('ROOT_PATH', rtrim($rootPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR);
}

require_once ROOT_PATH . 'config/app.php';

// Ensure HTTP 503 status
http_response_code(503);

$page_title = 'Maintenance - Klinik Samiaji';

// Ensure ASSETS_URL is defined for CSS loading
if (!defined('ASSETS_URL')) {
    define('ASSETS_URL', rtrim(STATIC_URL, '/') . '/assets/');
}

$homeUrl = defined('STATIC_URL') ? STATIC_URL : '/';

$extraHead = '<link rel="stylesheet" href="' . rtrim(ASSETS_URL, '/') . '/css/static/pages/state-static.css">';

include ROOT_PATH . 'includes/head.php';
?>



<div class="d-flex align-items-center justify-content-center min-vh-100 py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 mx-auto text-center">
                <h1 class="display-3 lh-1 fw-bold text-primary mb-2">Site Under Maintenance</h1>
                <p class="mb-4">We are currently performing scheduled maintenance. We will be back online shortly. Thank you for your patience.</p>

                <div class="d-flex gap-3 justify-content-center flex-wrap" style="margin: 2.5rem 0;">
                    <button type="button" class="btn btn-outline-primary rounded-pill px-4" onclick="window.close();">Close Window</button>
                </div>

                <div class="text-center">
                    <p class="fs-6 mb-3">Follow us on social media for updates</p>
                    <div class="d-flex gap-4 justify-content-center">
                        <a href="https://www.linkedin.com/company/kliniksamiaji" target="_blank" rel="noopener" class="text-primary fs-3" title="LinkedIn">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <a href="https://www.instagram.com/kliniksamiaji/" target="_blank" rel="noopener" class="text-primary fs-3" title="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/kliniksamiaji" target="_blank" rel="noopener" class="text-primary fs-3" title="YouTube">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . 'includes/script.php'; ?>
</body>

</html>