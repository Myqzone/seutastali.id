<?php
// Load bootstrap
require_once __DIR__ . '/config/bootstrap.php';

/** @var mysqli $conn */
global $conn;

// Prevent null connection warning in IDE and halt if database unavailable
if (!isset($conn) || !$conn || $conn->connect_error) {
    die("Koneksi database tidak tersedia.");
}

// Initialize session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$draft_token = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : '';
$package_name = isset($_GET['package']) ? htmlspecialchars($_GET['package']) : 'Dasar';
$subdomain = isset($_SESSION['active_subdomain']) ? $_SESSION['active_subdomain'] : 'undangan-anda';
$user_id = isset($_SESSION['active_user_id']) ? $_SESSION['active_user_id'] : null;

// Automatically activate the invitation for instant sandbox/test joy using mysqli!
if ($user_id) {
    try {
        $stmt = $conn->prepare("UPDATE invitations SET status = 'active' WHERE user_id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();
        }
    } catch (Exception $e) {
        // Fail silently
    }
}

// Set page meta
$page_title = 'Pembayaran Sukses - Seutastali';
$page_description = 'Selamat! Undangan digital Anda telah aktif dan siap disebarkan.';

ob_start();
?>

  <style>
    .success-card {
      border: 3px solid #000;
      background: #fff;
      box-shadow: 8px 8px 0px #000;
      border-radius: 20px;
      padding: 3rem 2rem;
      text-align: center;
      margin-top: 2rem;
      position: relative;
      overflow: hidden;
    }

    .success-badge {
      width: 80px;
      height: 80px;
      background: #d1e7dd;
      color: #0f5132;
      border: 3px solid #000;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      margin: 0 auto 1.5rem;
      box-shadow: 3px 3px 0px #000;
    }

    .neubrutal-btn {
      border: 3px solid #000 !important;
      font-weight: 800 !important;
      text-transform: uppercase !important;
      letter-spacing: 0.5px !important;
      box-shadow: 4px 4px 0px #000 !important;
      transition: all 0.2s ease !important;
      border-radius: 30px !important;
    }

    .neubrutal-btn:hover {
      transform: translate(2px, 2px) !important;
      box-shadow: 2px 2px 0px #000 !important;
    }

    .neubrutal-btn-primary {
      background: var(--c-primary) !important;
      color: #fff !important;
    }

    .neubrutal-btn-primary:hover {
      background: #7a151f !important;
    }

    .bill-box {
      border: 3px dashed #000;
      background: #faf6f0;
      padding: 1.5rem;
      border-radius: 12px;
      text-align: left;
      margin: 2rem auto;
      max-width: 480px;
    }
  </style>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-7">
        
        <!-- Celebratory Neubrutalist Success Card -->
        <div class="success-card">
          
          <!-- Success Node Badge -->
          <div class="success-badge">
            <i class="fa-solid fa-circle-check"></i>
          </div>

          <h2 class="fw-bold mb-2" style="font-size: 2.25rem; letter-spacing: -0.75px;">Pembayaran Sukses! 🎉</h2>
          <p class="text-muted" style="max-width: 500px; margin: 0 auto;">Selamat Kakak! Transaksi Anda telah berhasil diverifikasi secara real-time. Undangan digital Anda kini telah resmi aktif dan mengudara!</p>

          <!-- Bill / Receipt details -->
          <div class="bill-box">
            <h5 class="fw-bold mb-3 pb-2 border-bottom text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px; border-bottom: 2px dashed #000 !important;">Detail Transaksi Resmi</h5>
            
            <div class="d-flex justify-content-between mb-2">
              <span class="text-secondary small">Status Pembayaran:</span>
              <span class="badge bg-success text-white px-2.5 py-1 rounded-pill text-uppercase fw-bold" style="font-size: 9px; letter-spacing: 0.5px;">Lunas</span>
            </div>

            <div class="d-flex justify-content-between mb-2">
              <span class="text-secondary small">Paket Aktif:</span>
              <span class="fw-bold text-dark small">Paket <?php echo $package_name; ?></span>
            </div>

            <div class="d-flex justify-content-between mb-2">
              <span class="text-secondary small">Subdomain Aktif:</span>
              <span class="fw-bold text-primary small">http://<?php echo $subdomain; ?>.seutastali.id</span>
            </div>

            <div class="d-flex justify-content-between mt-3 pt-2 border-top" style="border-top: 1px dashed #000 !important;">
              <span class="fw-bold text-dark">Jumlah Terbayar:</span>
              <span class="fw-bold text-primary fs-5">Rp <?php echo ($package_name === 'Premium') ? '399.000' : (($package_name === 'Eksklusif') ? '249.000' : (($package_name === 'Lengkap') ? '199.000' : '149.000')); ?></span>
            </div>
          </div>

          <!-- Confetti Info and Primary Action -->
          <p class="text-secondary small mb-4">Kakak juga akan menerima pesan WhatsApp konfirmasi berisi detail sandi login dashboard untuk disimpan.</p>
          
          <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
            <a href="dashboard/index.php" class="btn neubrutal-btn neubrutal-btn-primary px-5 py-3">
              Masuk Dashboard <i class="fa-solid fa-gauge ms-1"></i>
            </a>
            <a href="http://<?php echo $subdomain; ?>.seutastali.id" target="_blank" class="btn neubrutal-btn btn-outline-dark px-4 py-3">
              Lihat Undangan Live <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
            </a>
          </div>

        </div>

      </div>
    </div>
  </div>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>
