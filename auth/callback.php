<?php
/**
 * Seutastali Centralized Google OAuth 2.0 Callback Processor
 * Location: auth/callback.php
 */

// Load bootstrap for database connection and configurations
require_once __DIR__ . '/../config/bootstrap.php';

/** @var mysqli $conn */
global $conn;

// Prevent null connection warning in IDE and halt if database unavailable
if (!isset($conn) || !$conn || $conn->connect_error) {
    die("Koneksi database tidak tersedia.");
}

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error_msg = '';

// Check if authorization code exists
if (isset($_GET['code'])) {
    
    // Retrieve OAuth Credentials from Environment
    $google_client_id = $_ENV['GOOGLE_ID'] ?? getenv('GOOGLE_ID');
    $google_client_secret = $_ENV['GOOGLE_SECRET'] ?? getenv('GOOGLE_SECRET');

    // Dynamically reconstruct same Redirect URI registered in Google Console
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $redirect_uri = $protocol . '://' . $host . '/auth/callback';

    try {
        // 1. Exchange authorization code for access token via Google API using native PHP cURL
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'code' => $_GET['code'],
            'client_id' => $google_client_id,
            'client_secret' => $google_client_secret,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code'
        ]));
        $token_response = curl_exec($ch);
        curl_close($ch);

        $token_data = json_decode($token_response, true);

        if (isset($token_data['access_token'])) {
            $access_token = $token_data['access_token'];

            // 2. Fetch User Profile information from Google UserInfo endpoint
            $ch = curl_init('https://www.googleapis.com/oauth2/v3/userinfo');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $access_token
            ]);
            $profile_response = curl_exec($ch);
            curl_close($ch);

            $user_profile = json_decode($profile_response, true);

            if (isset($user_profile['sub'])) {
                $google_id = $user_profile['sub'];
                $email = $user_profile['email'];
                $name = $user_profile['name'];

                // 3. Search for existing user in database by google_id OR email using native mysqli
                $user = null;
                $stmt = $conn->prepare("SELECT * FROM users WHERE google_id = ? OR email = ? LIMIT 1");
                if ($stmt) {
                    $stmt->bind_param("ss", $google_id, $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc();
                    $stmt->close();
                }

                if ($user) {
                    // User already exists! Link Google ID if not set yet
                    if (empty($user['google_id'])) {
                        $stmt = $conn->prepare("UPDATE users SET google_id = ? WHERE id = ?");
                        if ($stmt) {
                            $stmt->bind_param("si", $google_id, $user['id']);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }

                    // Save active session parameters
                    $_SESSION['active_user_id'] = $user['id'];
                    $_SESSION['guest_name'] = $user['name'];

                    // Check for active invitation subdomain mapping
                    $stmt = $conn->prepare("SELECT subdomain FROM invitations WHERE user_id = ? LIMIT 1");
                    if ($stmt) {
                        $stmt->bind_param("i", $user['id']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $inv = $result->fetch_assoc();
                        $stmt->close();
                        
                        if ($inv) {
                            $_SESSION['active_subdomain'] = $inv['subdomain'];
                        }
                    }

                    // Successful login! Redirect to dashboard home
                    header("Location: ../dashboard/index.php");
                    exit;

                } else {
                    // New Signup Flow via Google Auth! Create secure user account
                    $random_pass = bin2hex(random_bytes(8)); // Random fallback secure password
                    $hashed_password = password_hash($random_pass, PASSWORD_BCRYPT);

                    $stmt = $conn->prepare("INSERT INTO users (name, email, password, google_id) VALUES (?, ?, ?, ?)");
                    if ($stmt) {
                        $stmt->bind_param("ssss", $name, $email, $hashed_password, $google_id);
                        $stmt->execute();
                        $new_user_id = $conn->insert_id;
                        $stmt->close();

                        // Establish session login
                        $_SESSION['active_user_id'] = $new_user_id;
                        $_SESSION['guest_name'] = $name;

                        // Check if they were currently editing a sandbox draft
                        if (isset($_SESSION['active_draft_token'])) {
                            $draft_token = $_SESSION['active_draft_token'];
                            
                            // Map draft to new user account
                            $stmt = $conn->prepare("UPDATE invitation_drafts SET user_id = ? WHERE draft_token = ?");
                            if ($stmt) {
                                $stmt->bind_param("is", $new_user_id, $draft_token);
                                $stmt->execute();
                                $stmt->close();
                            }

                            // Proceed to onboarding to configure package and complete details
                            header("Location: ../onboarding.php?token=" . urlencode($draft_token));
                            exit;
                        }

                        // No active draft in session. Redirect to templates selection catalog!
                        header("Location: ../templates.php");
                        exit;
                    } else {
                        throw new Exception("Gagal mendaftarkan akun baru menggunakan Google.");
                    }
                }

            } else {
                throw new Exception("Profil Google tidak lengkap.");
            }
        } else {
            throw new Exception("Gagal menukarkan token akses Google.");
        }

    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
} else {
    $error_msg = 'Kode otorisasi Google tidak ditemukan.';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Authentication - Seutastali</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #faf6f0;
            color: #000;
            font-family: 'Outfit', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 1.5rem;
        }
        .error-card {
            background-color: #fff;
            border: 3px solid #000;
            border-radius: 20px;
            padding: 3rem 2rem;
            box-shadow: 8px 8px 0px #000;
            max-width: 480px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <h3 class="fw-black mb-3 text-danger">Gagal Masuk Google! ❌</h3>
        <p class="text-muted small mb-4"><?php echo htmlspecialchars($error_msg); ?></p>
        <a href="../login.php" class="btn btn-dark border-2 border-dark rounded-pill px-4 fw-bold">
            Kembali ke Login
        </a>
    </div>
</body>
</html>
