<?php

/**
 * Newsletter Subscribe API
 * Handles AJAX newsletter subscription requests
 * Endpoint: /api/newsletter.php
 */

require_once __DIR__ . '/../config/bootstrap.php';

header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed', 'type' => 'danger']);
    exit;
}

global $conn;

$response = ['success' => false, 'message' => '', 'type' => ''];

$email = filter_var(trim($_POST['newsletter_email'] ?? ''), FILTER_VALIDATE_EMAIL);
$subTable = 'newsletter_subscribers';

if (!$email) {
    $response['message'] = 'Email tidak valid';
    $response['type'] = 'danger';
} else {
    try {
        // Check if email already exists
        $checkStmt = $conn->prepare("SELECT id, status FROM $subTable WHERE email = ?");
        $checkStmt->bind_param('s', $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $emailExists = $checkResult->num_rows > 0;

        if ($emailExists) {
            $subscriber = $checkResult->fetch_assoc();
            if ($subscriber['status'] === 'active') {
                $response['message'] = 'Email ini sudah terdaftar di newsletter kami';
                $response['type'] = 'info';
                $response['success'] = true;
            } else {
                // Reactivate
                $reactivateStmt = $conn->prepare("UPDATE $subTable SET status = 'active', subscribed_at = NOW() WHERE email = ?");
                $reactivateStmt->bind_param('s', $email);
                $reactivateStmt->execute();
                $response['success'] = true;
                $response['message'] = 'Thank you! You\'re subscribed.';
                $response['type'] = 'success';
            }
        } else {
            // New subscription
            $token = bin2hex(random_bytes(32));
            $ip = $_SERVER['REMOTE_ADDR'] ?? null;
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;

            $stmt = $conn->prepare("INSERT INTO $subTable (email, token, ip_address, user_agent, source) VALUES (?, ?, ?, ?, 'website')");
            $stmt->bind_param('ssss', $email, $token, $ip, $userAgent);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Thank you! You\'re subscribed.';
                $response['type'] = 'success';
            } else {
                throw new Exception('Gagal menyimpan subscription');
            }
        }
        $checkStmt->close();
    } catch (Exception $e) {
        $response['message'] = 'Maaf, terjadi kesalahan. Coba lagi nanti.';
        $response['type'] = 'danger';
    }
}

echo json_encode($response);
