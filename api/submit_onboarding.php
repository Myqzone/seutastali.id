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

// Initialize session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Hanya menerima request POST.'
    ]);
    exit;
}

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
$draft_token = isset($input_data['token']) ? trim($input_data['token']) : '';
$client_password = isset($input_data['client_password']) ? $input_data['client_password'] : '';
$details = isset($input_data['details']) ? $input_data['details'] : null;
$package_name = isset($input_data['package_name']) ? $input_data['package_name'] : 'Dasar';
$package_price = isset($input_data['package_price']) ? $input_data['package_price'] : 149000;

if (empty($draft_token) || empty($client_password) || !$details) {
    echo json_encode([
        'success' => false,
        'message' => 'Kelengkapan informasi onboarding tidak valid.'
    ]);
    exit;
}

try {
    // 1. Fetch draft information using mysqli
    $draft_payload = null;
    $stmt = $conn->prepare("SELECT draft_data FROM invitation_drafts WHERE draft_token = ?");
    if ($stmt) {
        $stmt->bind_param("s", $draft_token);
        $stmt->execute();
        $result = $stmt->get_result();
        $draft_row = $result->fetch_assoc();
        $stmt->close();
        
        if ($draft_row) {
            $draft_payload = json_decode($draft_row['draft_data'], true);
        }
    }

    if (!$draft_payload) {
        echo json_encode([
            'success' => false,
            'message' => 'Data draf draf pernikahan tidak ditemukan.'
        ]);
        exit;
    }
    
    // Retrieve guest information from session (or fallback parameters)
    $guest_name = isset($_SESSION['guest_name']) ? $_SESSION['guest_name'] : 'Klien Seutastali';
    $guest_email = isset($_SESSION['guest_email']) ? $_SESSION['guest_email'] : 'klien@seutastali.id';

    // 2. Check if user already exists using mysqli
    $user_id = null;
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $guest_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_row = $result->fetch_assoc();
        $stmt->close();
        if ($user_row) {
            $user_id = $user_row['id'];
        }
    }

    if (!$user_id) {
        // Create new user record
        $hashed_password = password_hash($client_password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $guest_name, $guest_email, $hashed_password);
            $stmt->execute();
            $user_id = $conn->insert_id;
            $stmt->close();
        } else {
            throw new Exception("Gagal membuat akun user.");
        }
    }

    // 3. Create unique subdomain slug using bride and groom name
    $groom_slug = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($draft_payload['groom']));
    $bride_slug = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($draft_payload['bride']));
    $base_subdomain = $groom_slug . '-' . $bride_slug;
    
    // Append random number to avoid duplicates
    $subdomain = $base_subdomain;
    $stmt = $conn->prepare("SELECT id FROM invitations WHERE subdomain = ?");
    if ($stmt) {
        $stmt->bind_param("s", $subdomain);
        $stmt->execute();
        $result = $stmt->get_result();
        $exist = $result->fetch_assoc();
        $stmt->close();
        
        if ($exist) {
            $subdomain = $base_subdomain . rand(10, 99);
        }
    }

    // 4. Create Invitation outline record using mysqli
    $event_location = isset($details['event_address']) ? $details['event_address'] : 'Jakarta';
    $wedding_date = isset($draft_payload['date']) ? $draft_payload['date'] : date('Y-m-d');
    $template_theme = isset($draft_payload['template']) ? $draft_payload['template'] : 'floral';

    $stmt = $conn->prepare("INSERT INTO invitations 
        (user_id, subdomain, theme_folder, bride_name, groom_name, event_date, event_location, status) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, 'inactive')");
    
    if ($stmt) {
        $stmt->bind_param("issssss", 
            $user_id, 
            $subdomain, 
            $template_theme, 
            $draft_payload['bride'], 
            $draft_payload['groom'], 
            $wedding_date, 
            $event_location
        );
        $stmt->execute();
        $stmt->close();
    } else {
        throw new Exception("Gagal membuat data undangan: " . $conn->error);
    }

    // 5. Update draft mapping inside database using mysqli
    $stmt = $conn->prepare("UPDATE invitation_drafts SET user_id = ? WHERE draft_token = ?");
    if ($stmt) {
        $stmt->bind_param("is", $user_id, $draft_token);
        $stmt->execute();
        $stmt->close();
    }

    // Save final state parameters in session
    $_SESSION['active_user_id'] = $user_id;
    $_SESSION['active_subdomain'] = $subdomain;

    echo json_encode([
        'success' => true,
        'message' => 'Onboarding berhasil diproses.',
        'token' => $draft_token
    ]);
    exit;

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal memproses pendaftaran: ' . $e->getMessage()
    ]);
    exit;
}
