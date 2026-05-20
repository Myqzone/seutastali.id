<?php
// Set headers for JSON response
header('Content-Type: application/json');

// Load bootstrap config to get database connection
require_once __DIR__ . '/../config/bootstrap.php';

/** @var mysqli $conn */
global $conn;

// Prevent null connection warning in IDE and halt if database unavailable
if (!isset($conn) || !$conn || $conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Koneksi database tidak tersedia.'
    ]);
    exit;
}

// Check if it is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Hanya menerima request POST.'
    ]);
    exit;
}

// Get the raw input
$raw_input = file_get_contents('php://input');
$input_data = json_decode($raw_input, true);

if (!$input_data) {
    echo json_encode([
        'success' => false,
        'message' => 'Format input tidak valid.'
    ]);
    exit;
}

// Extract parameters
$client_name = isset($input_data['client_name']) ? trim($input_data['client_name']) : '';
$client_email = isset($input_data['client_email']) ? trim($input_data['client_email']) : '';
$draft_payload = isset($input_data['draft_payload']) ? $input_data['draft_payload'] : null;

// Simple validation
if (empty($client_name) || empty($client_email) || !$draft_payload) {
    echo json_encode([
        'success' => false,
        'message' => 'Nama lengkap dan alamat email wajib diisi.'
    ]);
    exit;
}

try {
    // Generate a secure random token
    $draft_token = bin2hex(random_bytes(16)); // 32-character hex string
    
    // Convert draft payload to JSON string
    $json_draft_data = json_encode($draft_payload);
    $template_slug = isset($draft_payload['template']) ? $draft_payload['template'] : 'floral';

    // Insert draft record into the database using native mysqli
    $stmt = $conn->prepare("INSERT INTO invitation_drafts (draft_token, template_slug, draft_data) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sss", $draft_token, $template_slug, $json_draft_data);
        $stmt->execute();
        $stmt->close();
    } else {
        throw new Exception("Gagal menyiapkan query database: " . $conn->error);
    }

    // Store in session for quick access
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['active_draft_token'] = $draft_token;
    $_SESSION['guest_name'] = $client_name;
    $_SESSION['guest_email'] = $client_email;

    echo json_encode([
        'success' => true,
        'message' => 'Draf berhasil disimpan.',
        'token' => $draft_token
    ]);
    exit;

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error database: ' . $e->getMessage()
    ]);
    exit;
}
