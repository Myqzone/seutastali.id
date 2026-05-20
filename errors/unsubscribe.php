<?php
require_once __DIR__ . '/../config/bootstrap.php';

// Get token from URL
$token = $_GET['token'] ?? '';
$status = $_GET['status'] ?? '';
$subtitle = $_GET['message'] ?? ($_GET['subtitle'] ?? '');

// If token provided, process unsubscribe
if ($token && !$status) {
    try {
        // Check database connection
        if (!isset($conn) || $conn->connect_error) {
            $status = 'error';
            $subtitle = 'Database connection failed';
        } else {
            // Find subscriber by token
            $table = 'newsletter_subscribers';
            $stmt = $conn->prepare("SELECT id, email, status FROM $table WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            $subscriber = $result->fetch_assoc();

            if (!$subscriber) {
                $status = 'error';
                $subtitle = 'Invalid or expired token';
            } elseif ($subscriber['status'] === 'unsubscribed') {
                $status = 'info';
                $subtitle = 'You have already unsubscribed from our newsletter';
            } else {
                // Unsubscribe the email
                $updateStmt = $conn->prepare("UPDATE $table SET status = 'unsubscribed', unsubscribed_at = NOW() WHERE id = ?");
                $updateStmt->bind_param("i", $subscriber['id']);
                if ($updateStmt->execute()) {
                    $status = 'success';
                    $subtitle = 'Your email has been removed from our newsletter list';
                } else {
                    $status = 'error';
                    $subtitle = 'An error occurred while unsubscribing';
                }
            }
        }
    } catch (Exception $e) {
        $status = 'error';
        $subtitle = 'System error occurred';
    }
}

// Default if no status
if (!$status) {
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
    } else {
        $status = 'error';
        if (empty($subtitle)) {
            $subtitle = 'Token not found';
        }
    }
}

$page_title = 'Unsubscribe - Klinik Samiaji';

// Set generic subtitle if not already set by processing logic or GET
if (empty($subtitle)) {
    $subtitle = match ($status) {
        'success' => "You've been successfully unsubscribed",
        'error' => 'Unsubscribe Failed',
        'info' => "You've already unsubscribed",
        default => 'Unsubscribe Request'
    };
}

// Fallback if MAIN_SITE_URL or ASSETS_URL not defined (should be in app.php)
$homeUrl = defined('MAIN_SITE_URL') ? MAIN_SITE_URL : 'https://kliniksamiaji.id/';

$extraHead = '<link rel="stylesheet" href="' . rtrim(ASSETS_URL, '/') . '/css/static/pages/state-static.css">';

include ROOT_PATH . 'includes/head.php';
?>


<div class="d-flex align-items-center justify-content-center min-vh-100 py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 mx-auto text-center">
                <h1 class="display-2 fw-bold text-primary mb-2">Unsubscribe</h1>
                <p class="mb-4"><?= htmlspecialchars((string)$subtitle) ?></p>

                <div class="d-flex gap-3 justify-content-center flex-wrap" style="margin: 2.5rem 0;">
                    <button type="button" class="btn btn-outline-primary rounded-pill px-4" onclick="window.close();">Close Window</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4" onclick="window.location.href='<?= htmlspecialchars($homeUrl) ?>'">Homepage</button>
                </div>

                <div class="text-center">
                    <p class="fs-6 mb-3">Follow us on social media for updates</p>
                    <div class="d-flex gap-4 justify-content-center">
                        <a href="https://www.linkedin.com/company/kliniksamiaji" target="_blank" rel="noopener" class="text-primary fs-3" title="LinkedIn">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <a href="https://www.instagram.com/kliniksamiaji/" target="_blank" rel="noopener" class="text-primary fs-3" title="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/kliniksamiaji" target="_blank" rel="noopener" class="text-primary fs-3" title="YouTube">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . 'includes/script.php'; ?>
</body>

</html>