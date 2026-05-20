<?php

/**
 * URL Shortener API
 * Handles short link redirection (e.g., ?c=abc123)
 * Endpoint: /api/shortener.php?c=CODE
 */

require_once __DIR__ . '/../config/bootstrap.php';

global $conn;

$code = preg_replace('/[^a-zA-Z0-9-]/', '', $_GET['c'] ?? '');

if (empty($code)) {
    http_response_code(400);
    $error_code = 400;
    require_once ROOT_PATH . 'errors/error_page.php';
    exit;
}

try {
    $stmt = $conn->prepare("SELECT original_url FROM short_links WHERE code = ?");
    if ($stmt) {
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Count click
            $conn->query("UPDATE short_links SET clicks = clicks + 1 WHERE code = '" . $conn->real_escape_string($code) . "'");
            header("Location: " . $row['original_url']);
            exit;
        } else {
            http_response_code(404);
            $error_code = 404;
            require_once ROOT_PATH . 'errors/error_page.php';
            exit;
        }
    }
} catch (Exception $e) {
    // Fail gracefully
    http_response_code(500);
    $error_code = 500;
    require_once ROOT_PATH . 'errors/error_page.php';
    exit;
}
