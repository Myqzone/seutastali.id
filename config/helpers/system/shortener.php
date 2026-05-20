<?php

/**
 * Shortener Helper
 * Location: /config/helpers/system/shortener.php
 */

// List of reserved root PHP filenames (cannot be used as shortcodes)
define('RESERVED_SHORTCODES', [
    'index',
    'about',
    'bio',
    'contact',
    'services',
    'news',
    'team',
    'careers',
    'privacy-policy',
    'terms',
    'cookies'
]);

if (!function_exists('isReservedShortCode')) {
    function isReservedShortCode($code)
    {
        $code = strtolower(trim($code ?? ''));
        return in_array($code, RESERVED_SHORTCODES, true);
    }
}

if (!function_exists('generateShortLink')) {
    function generateShortLink($original_url, $custom_code = null, $title = null)
    {
        global $conn;

        $original_url = trim($original_url);
        $title = $title ? trim($title) : null;

        // 1. Cek jika URL asal sudah punya shortcode (kecuali jika minta custom atau ada title baru)
        if (!$custom_code && !$title) {
            $stmt = $conn->prepare("SELECT code FROM short_links WHERE original_url = ? LIMIT 1");
            $stmt->bind_param("s", $original_url);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return $row['code'];
            }
        }

        // 2. Jika ada custom_code, cek apakah sudah dipakai orang lain atau reserved
        if ($custom_code) {
            $code = preg_replace('/[^a-zA-Z0-9_-]/', '', $custom_code);

            // Check if reserved
            if (isReservedShortCode($code)) {
                return false; // Code is reserved
            }

            $stmt = $conn->prepare("SELECT id FROM short_links WHERE code = ? LIMIT 1");
            $stmt->bind_param("s", $code);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                return false; // Code sudah ada
            }
        } else {
            // Generate random 6 characters (avoid reserved codes)
            $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            do {
                $code = "";
                for ($i = 0; $i < 6; $i++) {
                    $code .= $chars[rand(0, strlen($chars) - 1)];
                }
                // Check if it's reserved
                if (isReservedShortCode($code)) {
                    continue;
                }
                // Pastikan tidak tabrakan di DB
                $stmt = $conn->prepare("SELECT id FROM short_links WHERE code = ? LIMIT 1");
                $stmt->bind_param("s", $code);
                $stmt->execute();
            } while ($stmt->get_result()->num_rows > 0);
        }

        // 3. Save to DB
        $stmt = $conn->prepare("INSERT INTO short_links (code, original_url, title) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $code, $original_url, $title);

        if ($stmt->execute()) {
            return $code;
        }
        return false;
    }
}

if (!function_exists('getShortUrl')) {
    function getShortUrl($code, $full = true)
    {
        $url = MAIN_SITE_URL . $code;
        if (!$full) {
            $url = str_replace(['https://', 'http://'], '', $url);
        }
        return $url;
    }
}
