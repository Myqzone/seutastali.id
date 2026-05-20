<?php

/**
 * Centralized Security Headers Helper
 * Location: config/helpers/content/head.php
 * Usage: require_once ROOT_PATH . 'config/helpers/content/head.php';
 *        apply_security_headers(parse_url(STATIC_URL, PHP_URL_HOST));
 */

if (!function_exists('apply_security_headers')) {
    function apply_security_headers(?string $mainDomain = null, array $opts = []): void
    {
        if ($mainDomain === null && defined('STATIC_URL')) {
            $mainDomain = parse_url(STATIC_URL, PHP_URL_HOST);
        }

        // Allow page-specific overrides (e.g., preview embeds)
        $overrideOpts = [];
        if (defined('SECURITY_HEADER_OPTIONS') && is_array(SECURITY_HEADER_OPTIONS)) {
            $overrideOpts = SECURITY_HEADER_OPTIONS;
        }
        $opts = array_merge($opts, $overrideOpts);

        // CORS Configuration - Trusted domains only
        $allowedOrigins = $opts['cors_allowed_origins'] ?? [
            // Production domains
            'http://kliniksamiaji.id',
            'https://kliniksamiaji.id',
            'http://www.kliniksamiaji.id',
            'https://www.kliniksamiaji.id',
            'http://app.kliniksamiaji.id',
            'https://app.kliniksamiaji.id',
            'http://www.app.kliniksamiaji.id',
            'https://www.app.kliniksamiaji.id',

            // Development domains
            'http://websamiaji.me',
            'https://websamiaji.me',
            'http://www.websamiaji.me',
            'https://www.websamiaji.me',
            'http://appsamiaji.me',
            'https://appsamiaji.me',
            'http://www.appsamiaji.me',
            'https://www.appsamiaji.me',
        ];

        // Check if current request origin is allowed
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        if ($origin && in_array($origin, $allowedOrigins, true)) {
            header("Access-Control-Allow-Origin: $origin");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
            header("Access-Control-Allow-Credentials: true");
            header("Vary: Origin");
        }

        $cookiePath = $opts['cookie_path'] ?? '/';
        $sameSite   = $opts['cookie_samesite'] ?? 'Strict';
        $httpOnly   = $opts['cookie_httponly'] ?? true;
        $secureFlag = $opts['cookie_secure'] ?? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on');
        $referrer   = $opts['referrer_policy'] ?? 'no-referrer';
        // Allow same-origin iframes so internal previews (e.g., error/email preview) can render.
        $xfo        = $opts['x_frame_options'] ?? 'SAMEORIGIN';
        $xss        = $opts['x_xss_protection'] ?? '1; mode=block';
        $uaCompat   = $opts['x_ua_compatible'] ?? 'IE=edge';

        header("X-UA-Compatible: $uaCompat");
        if ($xfo !== null && $xfo !== '') {
            header("X-Frame-Options: $xfo");
        }
        header("X-XSS-Protection: $xss");
        header('X-Content-Type-Options: nosniff');
        header("Referrer-Policy: $referrer");

        // Don't set empty Set-Cookie header - only set if we have actual cookie data
        // This was causing browser confusion leading to redirect loops
        // Individual cookie handling should be done by specific functions, not here

        $allowInline = $opts['csp_allow_inline'] ?? true;
        $allowEval   = $opts['csp_allow_eval'] ?? true;
        $extraScript = $opts['csp_extra_script_src'] ?? [
            'https://accounts.google.com',
            'https://www.gstatic.com',
            'https://*.google.com',
            'https://cdn.jsdelivr.net',
            'https://unpkg.com',
            'https://cdn.quilljs.com',
            'https://code.iconify.design',
            'blob:' // Allow blob: protocol for dynamic scripts
        ];
        $extraStyle  = $opts['csp_extra_style_src'] ?? [
            'https://fonts.googleapis.com',
            'https://cdnjs.cloudflare.com',
            'https://cdn.jsdelivr.net',
            'https://unpkg.com',
            'https://cdn.quilljs.com'
        ];
        $extraFont   = $opts['csp_extra_font_src'] ?? [
            'https://fonts.gstatic.com',
            'https://cdnjs.cloudflare.com',
            'https://cdn.jsdelivr.net',
            'https://unpkg.com',
            'https://fonts.static.com',
            'data:'
        ];
        $extraImg    = $opts['csp_extra_img_src'] ?? [
            'https://www.gstatic.com',
            'https://*.google.com',
            'https://*.googleusercontent.com',
            'https://cdn.jsdelivr.net',
            'https://unpkg.com',
            'data:'
        ];
        $extraConnect = $opts['csp_extra_connect_src'] ?? [
            'https://accounts.google.com',
            'https://www.googleapis.com',
            'https://docs.google.com',
            'https://*.google.com',
            'https://*.googleusercontent.com',
            'https://cdn.jsdelivr.net',
            'https://unpkg.com',
            'https://cdn.quilljs.com',
            'https://www.googletagmanager.com',
            'https://code.iconify.design',
            'https://api.iconify.design',
            'https://api.simpler.io',
            'https://api.unisvg.com'
        ];
        $extraFrame = $opts['csp_extra_frame_src'] ?? [
            'http://*',
            'https://*',
            'gap:' // for mobile/cordova if needed
        ];

        $self = "'self'";
        $schemeHosts = [];
        if ($mainDomain) {
            // WHat is the actual root domain? (e.g., kliniksamiaji.id)
            $parts = explode('.', $mainDomain);
            $rootDomain = (count($parts) >= 2) ? implode('.', array_slice($parts, -2)) : $mainDomain;

            $schemeHosts[] = "http://$mainDomain";
            $schemeHosts[] = "https://$mainDomain";
            $schemeHosts[] = "http://*.$mainDomain";
            $schemeHosts[] = "https://*.$mainDomain";

            // PENTING: Jika kita di subdomain (app.kliniksamiaji.id), 
            // kita HARUS mengizinkan root domain (kliniksamiaji.id) karena assets ada di sana
            if ($rootDomain !== $mainDomain) {
                $schemeHosts[] = "http://$rootDomain";
                $schemeHosts[] = "https://$rootDomain";
                $schemeHosts[] = "http://*.$rootDomain";
                $schemeHosts[] = "https://*.$rootDomain";
            }

            // For development domains, allow all sources
            $isDevDomain = (strpos($mainDomain, 'localhost') !== false ||
                strpos($mainDomain, '127.0.0.1') !== false ||
                strpos($mainDomain, 'appsamiaji.me') !== false ||
                strpos($mainDomain, 'websamiaji.me') !== false);

            if ($isDevDomain) {
                // Biar schemeHosts lebih permisif di development
                $schemeHosts[] = "http://*";
                $schemeHosts[] = "https://*";
            }
        }
        $srcBase = implode(' ', array_merge([$self], $schemeHosts));

        $scriptDirectives = [$srcBase];
        if ($allowInline) $scriptDirectives[] = "'unsafe-inline'";
        if ($allowEval)   $scriptDirectives[] = "'unsafe-eval'";
        $scriptDirectives[] = "blob:"; // Allow blob URLs for dynamic scripts (no quotes needed)
        $scriptDirectives = array_merge($scriptDirectives, $extraScript);

        $styleDirectives = [$srcBase];
        if ($allowInline) $styleDirectives[] = "'unsafe-inline'";
        $styleDirectives = array_merge($styleDirectives, $extraStyle);

        $imgDirectives = array_merge([$srcBase, 'data:', 'blob:'], $extraImg);
        $fontDirectives = array_merge([$srcBase, 'data:'], $extraFont);
        $connectDirectives = array_merge([$srcBase], $extraConnect);
        $frameDirectives = array_merge([$self], $extraFrame);
        $frameAncestors = $opts['csp_extra_frame_ancestors'] ?? [$self];

        $cspArr = [
            "default-src $srcBase",
            "script-src " . implode(' ', $scriptDirectives),
            "style-src " . implode(' ', $styleDirectives),
            "img-src " . implode(' ', $imgDirectives),
            "font-src " . implode(' ', $fontDirectives),
            "connect-src " . implode(' ', $connectDirectives),
            "frame-src " . implode(' ', $frameDirectives),
            "frame-ancestors " . implode(' ', $frameAncestors)
        ];

        $csp = implode('; ', $cspArr) . ';';

        header("Content-Security-Policy: $csp");
        header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
    }
}
