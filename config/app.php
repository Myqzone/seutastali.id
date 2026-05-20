<?php

/**
 * Configuration File (app.php)
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
            // e.g., https://app.kliniksamiaji.id/ → https://kliniksamiaji.id/
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
    $isLocalHost = (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false || strpos($host, '.me') !== false);

    // Force HTTPS for production domains
    if (!$isLocalHost && $scheme === 'http') $scheme = 'https';

    $origin = $scheme . '://' . $host;
    $uri    = $_SERVER['REQUEST_URI'] ?? '';
    $script = $_SERVER['SCRIPT_NAME'] ?? '';

    // 2. Detection (Subdomain vs Subfolder)
    $isAppSubdomain = (strpos($host, 'app.') === 0);
    $isAppRequest   = (strpos($uri, '/app') !== false) || (strpos($script, '/app/') !== false);

    // 3. Project Path
    $projectPath = '/';
    if (strpos($script, '/app/') !== false) {
        $projectPath = rtrim(substr($script, 0, strpos($script, '/app/')), '/') . '/';
    }

    // 4. Define Core URLs
    if (!defined('BASE_URL')) {
        // ALWAYS use the project root for clean URLs to avoid .htaccess direct /app blocking
        define('BASE_URL', $origin . $projectPath);
    }

    if (!defined('STATIC_URL')) define('STATIC_URL', $origin . $projectPath);

    if (!defined('MAIN_SITE_URL')) {
        $mainHost = $isAppSubdomain ? substr($host, 4) : $host;
        if (strpos($mainHost, 'www.') === 0) $mainHost = substr($mainHost, 4);
        define('MAIN_SITE_URL', ($isLocalHost ? $scheme : 'https') . '://' . $mainHost . $projectPath);
    }

    if (!defined('IS_APP_SUBDOMAIN')) define('IS_APP_SUBDOMAIN', $isAppSubdomain);
    if (!defined('APP_URL')) define('APP_URL', $isAppSubdomain ? BASE_URL : (STATIC_URL . 'app/'));
    if (!defined('API_URL')) define('API_URL', APP_URL . 'api/');

    if (!defined('APP_ENV')) define('APP_ENV', $isLocalHost ? 'development' : 'production');

    // 5. Assets URL (Point to main domain if on subdomain with CORS support)
    if (!defined('ASSETS_URL')) {
        define('ASSETS_URL', rtrim($isAppSubdomain ? MAIN_SITE_URL : STATIC_URL, '/') . '/assets/');
    }
    if (!defined('ASSET_URL')) define('ASSET_URL', ASSETS_URL); // Alias for compatibility

    if (APP_ENV === 'development') {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    } else {
        error_reporting(0);
        ini_set('display_errors', 0);
    }
}

// Paths untuk Assets (shared between static and app)
if (!defined('ASSETS_PATH')) define('ASSETS_PATH', '/assets/');
// Global asset version for cache-busting across environments
if (!defined('ASSETS_VERSION')) {
    $envAssetsVer = isset($_ENV['ASSETS_VERSION']) ? trim((string)$_ENV['ASSETS_VERSION']) : '';
    if ($envAssetsVer !== '') {
        define('ASSETS_VERSION', $envAssetsVer);
    } else {
        // Fallback: use file mtime in production if available, or time() in development
        $defaultVer = (APP_ENV === 'development') ? (string)time() : '';
        $candidate = ROOT_PATH . 'assets' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'app.css';
        if ($defaultVer === '' && is_file($candidate)) {
            $mt = @filemtime($candidate);
            $defaultVer = $mt ? (string)$mt : (string)time();
        } elseif ($defaultVer === '') {
            $defaultVer = (string)time();
        }
        define('ASSETS_VERSION', $defaultVer);
    }
}

// 2. Jalur Folder di Harddisk (Anti-Bentrok)
if (!defined('BASE_PATH')) {
    $basePath = realpath(__DIR__ . '/..');
    if ($basePath === false) {
        $basePath = dirname(__DIR__);
    }
    define('BASE_PATH', $basePath);
}

// Path untuk App folder (subdirectory atau virtual host)
if (!defined('APP_PATH')) {
    define('APP_PATH', BASE_PATH . '/app');
}


// Nama Aplikasi
if (!defined('APP_NAME')) define('APP_NAME', 'Seutastali');
if (!ini_get('date.timezone')) date_default_timezone_set('Asia/Jakarta');

// ===== SESSION CONFIGURATION (MUST BE BEFORE session_start()) =====
// Configure session BEFORE starting the session
if (session_status() === PHP_SESSION_NONE) {
    // If a session was started earlier in the request (even if later closed),
    // PHP will refuse changing session ini settings and emit warnings.
    // In that case we only (re)start the session without touching ini settings.
    $sessionWasStartedEarlier = (session_id() !== '');

    $isHttps = false;
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        $proto = strtolower(trim(explode(',', (string)$_SERVER['HTTP_X_FORWARDED_PROTO'], 2)[0]));
        $isHttps = ($proto === 'https');
    } elseif (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        $isHttps = true;
    } elseif (!empty($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443) {
        $isHttps = true;
    }

    if (!$sessionWasStartedEarlier) {
        // Set cookie params BEFORE session_start()
        // PHP >= 7.3 supports array options, older versions require legacy signature.
        if (defined('PHP_VERSION_ID') && PHP_VERSION_ID >= 70300) {
            session_set_cookie_params([
                'lifetime' => 0,  // Session expires when browser closes
                'path' => '/',
                'domain' => null, // Use null instead of empty string for better browser compatibility
                'secure' => $isHttps,
                'httponly' => true,
                'samesite' => 'Lax'  // Lax allows cookies on redirects (not Strict)
            ]);
        } else {
            // Best-effort for old PHP: no SameSite support here.
            // (If your hosting supports it, you can still set it in php.ini / .user.ini.)
            session_set_cookie_params(0, '/', null, $isHttps, true);
        }

        // Set strict cookie flags
        ini_set('session.cookie_lifetime', 0);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_strict_mode', 1);

        // Enable garbage collection for sessions
        // OPTIMIZATION: Set to 0% probability (disable automatic GC)
        // Garbage collection happens too frequently and slows down requests
        // Use scheduled cron job (storage/cleanup.php) instead for manual cleanup
        ini_set('session.gc_probability', 0);
        ini_set('session.gc_divisor', 100);
        ini_set('session.gc_maxlifetime', 86400); // 24 hours

        // Session managed via database (user_sessions table).
        // File-based session storage (session.save_path) is NOT used.
    }

    // Prevent bots from creating session files
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    if (
        empty($userAgent) ||
        strlen($userAgent) < 5 ||
        preg_match('/bot|crawl|spider|slurp|curl|wget|python|php|java|go|ruby|perl|bash|scanner|probe|integrity|headless|phantomjs/i', $userAgent)
    ) {
        // Skip session_start for bots, CLI tools, and empty/suspicious UAs
        return;
    }

    // NOW start the session
    session_start();
}

// -------------------------------------------------------------------------
// DYNAMIC BROWSER PAGE CACHING OPTIMIZATION
// -------------------------------------------------------------------------
// Check if the current page is a private/authenticated page
$isAppPage = (defined('IS_APP_SUBDOMAIN') && IS_APP_SUBDOMAIN);
if (!$isAppPage) {
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $isAppPage = (strpos($scriptName, '/app/') !== false || strpos($scriptName, '/admin/') !== false || strpos($scriptName, '/dashboard/') !== false);
}

if (!headers_sent()) {
    // Remove default session cache headers to avoid browser confusion
    header_remove('Pragma');
    header_remove('Cache-Control');
    header_remove('Expires');

    if ($isAppPage) {
        // Disable browser caching for private app/dashboard pages to protect sensitive user sessions
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0, private');
        header('Pragma: no-cache');
        header('Expires: 0');
    } else {
        // Enable browser caching for public landing/marketing pages for 1 hour
        // This allows instant loading (0ms) when navigating back and forth!
        header('Cache-Control: public, max-age=3600, must-revalidate');
        header('Pragma: cache');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
    }
}

// Load landing page helpers
require_once ROOT_PATH . 'config/helpers/content/page-loader.php';

// Skip checkSessionTimeout() in app.php - call it in pages that need it
// to avoid database connection during config load
// checkSessionTimeout();
