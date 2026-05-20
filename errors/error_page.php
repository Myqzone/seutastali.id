<?php

/**
 * Error Page Renderer - Klinik Samiaji
 * Location: errors/error_page.php
 * Usage:
 *   $error_code = 404; $error_title = 'Not Found'; $error_message = '...';
 *   require ROOT_PATH . 'errors/error_page.php';
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

if (!function_exists('ks_error_defaults')) {
    function ks_error_defaults(int $code): array
    {
        switch ($code) {
            case 401:
                return ['Unauthorized', 'You need to login to access this page.'];
            case 403:
                return ['Forbidden', 'You do not have access to this page.'];
            case 404:
                return ['Not Found', 'The page you are looking for was not found.'];
            case 503:
                return ['Service Unavailable', 'Service is under maintenance. Please try again later.'];
            case 500:
            default:
                return ['Server Error', 'An error occurred on the server. Please try again.'];
        }
    }
}

$error_code = isset($error_code) ? (int)$error_code : (int)(http_response_code() ?: 500);
if ($error_code < 100) $error_code = 500;

http_response_code($error_code);

if (!isset($error_title) || trim((string)$error_title) === '') {
    [$t] = ks_error_defaults($error_code);
    $error_title = $t;
}
if (!isset($error_message) || trim((string)$error_message) === '') {
    [, $m] = ks_error_defaults($error_code);
    $error_message = $m;
}

$page_title = $error_code . ' - ' . (string)$error_title;

$dashboardUrl = null;
if (!empty($_SESSION['user_id'])) {
    $role = $_SESSION['role'] ?? ($_SESSION['user_role'] ?? '');
    $role = is_string($role) ? strtolower($role) : '';

    switch ($role) {
        case 'admin':
            $dashboardUrl = BASE_URL . 'admin/';
            break;
        case 'developer':
            $dashboardUrl = BASE_URL . 'developer/';
            break;
        case 'parent':
            $dashboardUrl = BASE_URL . 'parent/';
            break;
        case 'finance':
            $dashboardUrl = BASE_URL . 'finance/';
            break;
        case 'marcom':
            $dashboardUrl = BASE_URL . 'marcom/';
            break;
        case 'staff':
        case 'doctor':
        case 'therapist':
            $dashboardUrl = BASE_URL . 'staff/';
            break;
    }
}

// Ensure ASSETS_URL is defined for CSS loading
if (!defined('ASSETS_URL')) {
    define('ASSETS_URL', rtrim(STATIC_URL, '/') . '/assets/');
}

$homeUrl = defined('STATIC_URL') ? STATIC_URL : (defined('BASE_URL') ? BASE_URL : '/');
$loginUrl = defined('BASE_URL') ? (BASE_URL . 'auth/login.php') : '/auth/login.php';

// Disable page loader for error pages
$disable_page_loader = true;
$extraHead = '<link rel="stylesheet" href="' . rtrim(ASSETS_URL, '/') . '/css/static/pages/state-static.css">';

include ROOT_PATH . 'includes/head.php';
?>

<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 mx-auto text-center">
                <h1 class="display-1 fw-bold text-primary mb-0" style="font-size: 8rem;"><?= (int)$error_code ?></h1>
                <h2 class="fw-bold mb-2" style="font-size: 2.5rem;"><?= htmlspecialchars((string)$error_title) ?></h2>
                <p class="mb-5"><?= htmlspecialchars((string)$error_message) ?></p>

                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <button type="button" class="btn btn-outline-primary rounded-pill px-4" onclick="history.back();">Go Back</button>
                    <a class="btn btn-primary rounded-pill px-4" href="<?= htmlspecialchars($homeUrl) ?>">Go to Homepage</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . 'includes/script.php'; ?>
</body>

</html>