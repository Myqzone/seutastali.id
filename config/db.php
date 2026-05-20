<?php

/**
 * Database Configuration - Klinik Samiaji
 * Location: config/db.php
 * Final Clean Version: Single Database with Prefixed Tables
 */

// Load app environment settings
require_once __DIR__ . '/app.php';

// Detect local server
$serverAddr = $_SERVER['SERVER_ADDR'] ?? '';
$isLocalServer = in_array($serverAddr, ['127.0.0.1', '::1'], true);

// Detect environment
$env = $_ENV['APP_ENV'] ?? getenv('APP_ENV') ?: 'development';

if ($env === 'production') {
    // Production (Rumahweb)
    $db_host = trim((string)($_ENV['PROD_DB_HOST'] ?? getenv('PROD_DB_HOST') ?: 'localhost'));
    $db_user = trim((string)($_ENV['PROD_DB_USER'] ?? getenv('PROD_DB_USER') ?: ''));
    $db_pass = trim((string)($_ENV['PROD_DB_PASSWORD'] ?? getenv('PROD_DB_PASSWORD') ?: ''));
    $db_name = trim((string)($_ENV['PROD_DB_NAME'] ?? getenv('PROD_DB_NAME') ?: ''));
} else {
    // Local (Localhost)
    $db_host = trim((string)($_ENV['LOCAL_DB_HOST'] ?? getenv('LOCAL_DB_HOST') ?: 'localhost'));
    $db_user = trim((string)($_ENV['LOCAL_DB_USER'] ?? getenv('LOCAL_DB_USER') ?: 'root'));
    $db_pass = trim((string)($_ENV['LOCAL_DB_PASSWORD'] ?? getenv('LOCAL_DB_PASSWORD') ?: ''));
    $db_name = trim((string)($_ENV['LOCAL_DB_NAME'] ?? getenv('LOCAL_DB_NAME') ?: ''));
}

$db_port_raw = trim((string)($_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: ''));
$db_port = ($db_port_raw !== '' && ctype_digit($db_port_raw)) ? (int)$db_port_raw : 3306;

// Check if mysqli extension is available
if (!extension_loaded('mysqli')) {
    if ($isLocalServer) {
        die("MySQLi extension is not loaded. Please install PHP MySQLi extension or use XAMPP/WAMP.");
    } else {
        error_log('[DB] MySQLi extension not loaded');
        $conn = null; // Fail-safe fallback
    }
} else {
    // Global Connection Instance with connection timeout
    try {
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port, null);
    } catch (mysqli_sql_exception $e) {
        if ($isLocalServer) {
            die("Database Connection Failed: " . $e->getMessage());
        } else {
            error_log('[DB] Connection error: ' . $e->getMessage());
            $conn = null; // Fail-safe fallback
        }
    }

    // Set connection timeout for mobile networks (10 seconds should be enough)
    if ($conn && ini_get('mysqli.connect_timeout') === false) {
        ini_set('mysqli.connect_timeout', 10);
    }

    // Set Charset
    if ($conn && !$conn->connect_error) {
        $conn->set_charset("utf8mb4");
        $conn->query("SET NAMES utf8mb4");
    }
}

/**
 * Check if table exists (Global Helper)
 */
if (!function_exists('table_exists')) {
    function table_exists(mysqli $conn, string $table)
    {
        $result = $conn->query("SHOW TABLES LIKE '" . $conn->real_escape_string($table) . "'");
        return $result && $result->num_rows > 0;
    }
}

// Connection Validation
if ($conn && $conn->connect_error) {
    if ($isLocalServer) {
        die("Koneksi Database Gagal: " . $conn->connect_error);
    } else {
        error_log('[DB] Connection error: ' . $conn->connect_error);
        $conn = null; // Fail-safe fallback
    }
}

/**
 * Helper function for cross-compatibility
 */
if (!function_exists('getDBConnection')) {
    function getDBConnection($type = 'core')
    {
        global $conn;
        return $conn;
    }
}
