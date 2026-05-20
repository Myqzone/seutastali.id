<?php

/**
 * Application Bootstrap
 * Initializes ROOT_PATH and loads core configuration files
 * 
 * Include this file at the beginning of every entry point:
 * require_once __DIR__ . '/../config/bootstrap.php';
 */

// ROOT project (folder yang berisi index.php, app/, config/, assets/, dll)
if (!defined('ROOT_PATH')) {
    $root = realpath(__DIR__ . '/..');
    if ($root === false) {
        $root = dirname(__DIR__);
    }
    define('ROOT_PATH', rtrim($root, '/\\') . DIRECTORY_SEPARATOR);
}

// -------------------------------------------------------------------------
// INLINE ENV LOADER (Simplified)
// -------------------------------------------------------------------------
if (!defined('ENV_LOADED')) {
    $envPath = ROOT_PATH . '.env';
    if (file_exists($envPath)) {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0 || strpos($line, '=') === false) continue;
            [$k, $v] = explode('=', $line, 2);
            $k = trim(str_replace('export ', '', $k));
            $v = trim($v, " \t\n\r\0\x0B\"'");
            if (!isset($_ENV[$k]) && !isset($_SERVER[$k]) && getenv($k) === false) {
                putenv("$k=$v");
                $_ENV[$k] = $v;
                $_SERVER[$k] = $v;
            }
        }
    }
    define('ENV_LOADED', true);
}

// Always log errors (Hostinger shows 500 without details when display_errors=0)
ini_set('log_errors', 1);

// Prefer writing PHP errors to a project log file (if writable)
// IMPORTANT: Must use reliable path - don't create in parent directories
$logDir = ROOT_PATH . 'storage' . DIRECTORY_SEPARATOR . 'logs';
if (!is_dir($logDir) && is_writable(dirname($logDir))) {
    @mkdir($logDir, 0755, true);
}
if (is_dir($logDir) && is_writable($logDir)) {
    ini_set('error_log', $logDir . DIRECTORY_SEPARATOR . 'php-error.log');
} else {
    // Log error if storage folder not writable - but don't create elsewhere
    error_log('[APP] Storage logs directory not writable');
}

// Optional hard overrides from .env (recommended for hosting stability)
$envBaseUrl = isset($_ENV['BASE_URL']) ? trim((string)$_ENV['BASE_URL']) : '';
$envStaticUrl = isset($_ENV['STATIC_URL']) ? trim((string)$_ENV['STATIC_URL']) : '';
$envAppEnv = isset($_ENV['APP_ENV']) ? strtolower(trim((string)$_ENV['APP_ENV'])) : '';
$envIsAppSubdomainRaw = isset($_ENV['IS_APP_SUBDOMAIN']) ? trim((string)$_ENV['IS_APP_SUBDOMAIN']) : '';
$envIsAppSubdomain = in_array(strtolower($envIsAppSubdomainRaw), ['1', 'true', 'yes', 'on'], true);
$envMainSiteUrl = isset($_ENV['MAIN_SITE_URL']) ? trim((string)$_ENV['MAIN_SITE_URL']) : '';

if ($envBaseUrl !== '' && $envStaticUrl !== '') {
    // Normalize trailing slash
    if (substr($envBaseUrl, -1) !== '/') $envBaseUrl .= '/';
    if (substr($envStaticUrl, -1) !== '/') $envStaticUrl .= '/';

    if (!defined('BASE_URL')) define('BASE_URL', $envBaseUrl);
    if (!defined('STATIC_URL')) define('STATIC_URL', $envStaticUrl);

    // Mode hosting: subdomain app.* atau subfolder /app
    if (!defined('IS_APP_SUBDOMAIN')) define('IS_APP_SUBDOMAIN', $envIsAppSubdomain);

    // Define MAIN_SITE_URL for asset loading (from .env or auto-detect)
    if (!defined('MAIN_SITE_URL')) {
        if ($envMainSiteUrl !== '') {
            define('MAIN_SITE_URL', $envMainSiteUrl);
        } elseif ($envIsAppSubdomain) {
            // Auto-detect MAIN_SITE_URL from BASE_URL when IS_APP_SUBDOMAIN is true
            // e.g., https://app.kliniksamiaji.id/ -> https://kliniksamiaji.id/
            $baseUrlParsed = parse_url($envBaseUrl);
            if ($baseUrlParsed && isset($baseUrlParsed['host'])) {
                $mainHost = $baseUrlParsed['host'];
                // Remove 'app.' prefix if present
                if (strpos($mainHost, 'app.') === 0) {
                    $mainHost = substr($mainHost, 4);
                }
                $mainScheme = $baseUrlParsed['scheme'] ?? 'https';
                $mainPath = $baseUrlParsed['path'] ?? '/';
                define('MAIN_SITE_URL', $mainScheme . '://' . $mainHost . $mainPath);
            } else {
                define('MAIN_SITE_URL', $envStaticUrl);
            }
        } else {
            define('MAIN_SITE_URL', $envStaticUrl);
        }
    }

    if (!defined('APP_ENV')) define('APP_ENV', ($envAppEnv === 'production') ? 'production' : 'development');
    if (APP_ENV === 'development') {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    } else {
        error_reporting(0);
        ini_set('display_errors', 0);
    }
} else {

    // -------------------------------------------------------------------------
    // CLEAN AUTO-DETECTION (No .env found)
    // -------------------------------------------------------------------------

    // 1. Basic Scheme/Host
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'];

    $host = strtolower($_SERVER['HTTP_HOST'] ?? 'localhost');
    $isLocalHost = (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false || strpos($host, '.me') !== false || strpos($host, 'apprsa.me') !== false);

    // Force HTTPS for production domains (disabled for development)
    // if (!$isLocalHost && $scheme === 'http') $scheme = 'https';

    $origin = $scheme . '://' . $host;
    $uri    = $_SERVER['REQUEST_URI'] ?? '';
    $script = $_SERVER['SCRIPT_NAME'] ?? '';

    // 2. Auto-detect subdomain mode
    $isAppSubdomain = (strpos($host, 'app.') === 0);

    // Check for wildcard template subdomain (e.g., syakira.seutastali.id)
    $isTemplateSubdomain = false;
    $templateSubdomainName = '';
    $parts = explode('.', $host);
    if (count($parts) > 2 && !filter_var($host, FILTER_VALIDATE_IP) && $parts[0] !== 'www' && $parts[0] !== 'app') {
        if (in_array('seutastali', $parts)) {
            $isTemplateSubdomain = true;
            $templateSubdomainName = $parts[0];
        }
    }

    $mainHost = $host;
    if ($isAppSubdomain) {
        $mainHost = substr($host, 4);
    } elseif ($isTemplateSubdomain) {
        $mainHost = substr($host, strlen($templateSubdomainName) + 1);
    }

    // 3. Define BASE_URL (current URL with trailing slash)
    $currentPath = dirname($script);
    if ($currentPath === '/' || $currentPath === '\\') {
        $currentPath = '';
    }
    define('BASE_URL', $origin . $currentPath . '/');

    // 4. Define STATIC_URL (main domain for shared assets)
    if ($isAppSubdomain || $isTemplateSubdomain) {
        define('STATIC_URL', $scheme . '://' . $mainHost . '/');
    } else {
        define('STATIC_URL', BASE_URL);
    }

    // 5. Define MAIN_SITE_URL (for asset loading)
    define('MAIN_SITE_URL', STATIC_URL);

    // 6. Define IS_APP_SUBDOMAIN
    define('IS_APP_SUBDOMAIN', $isAppSubdomain);

    // 7. Define APP_ENV based on host
    define('APP_ENV', $isLocalHost ? 'development' : 'production');

    // 8. Error reporting based on environment
    if (APP_ENV === 'development') {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    } else {
        error_reporting(0);
        ini_set('display_errors', 0);
    }
}

// -------------------------------------------------------------------------
// LOAD CORE CONFIGURATION FILES
// -------------------------------------------------------------------------

// Load app configuration
require_once __DIR__ . '/app.php';

// Load database configuration
require_once __DIR__ . '/db.php';

// -------------------------------------------------------------------------
// SESSION CONFIGURATION
// -------------------------------------------------------------------------

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    // Session configuration (only before session starts)
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
    ini_set('session.cookie_samesite', 'Lax');
    ini_set('session.use_strict_mode', 1);

    session_start();
}

// -------------------------------------------------------------------------
// LOAD HELPERS (with error handling)
// -------------------------------------------------------------------------

// Load landing page helpers with error handling
try {
    require_once ROOT_PATH . 'config/helpers/content/page-loader.php';
} catch (Error $e) {
    error_log('Helper Error: Cannot load page-loader helper - ' . $e->getMessage());
}

try {
    require_once ROOT_PATH . 'config/helpers/system/maintenance.php';
} catch (Error $e) {
    error_log('Helper Error: Cannot load maintenance helper - ' . $e->getMessage());
}

try {
    require_once ROOT_PATH . 'config/helpers/content/web-config.php';
} catch (Error $e) {
    error_log('Helper Error: Cannot load web-config helper - ' . $e->getMessage());
}

// -------------------------------------------------------------------------
// GLOBAL VARIABLES
// -------------------------------------------------------------------------

// Make database connection available globally
global $conn;
