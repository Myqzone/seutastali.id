<?php
// Load bootstrap (centralized config loading)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Set page meta
$page_title = 'Features - SeutasTali';
$page_description = 'Jelajahi fitur lengkap platform pembuatan undangan digital SeutasTali.';

ob_start();
?>

  <section class="position-relative py-5 mt-3">
    <div class="container position-relative z-3">

      <!-- Page Header -->
      <div class="text-center mb-5">
        <h2 class="fw-bold">Platform <span class="text-primary">Features</span></h2>
        <p class="text-muted">Semua fitur hebat yang kami sediakan untuk melengkapi kebahagiaan Anda</p>
      </div>

      <!-- Features Bento Grid -->
      <div class="row g-4 mb-5">
        <!-- Feature 1 -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 rounded-4 border-0 shadow-sm p-4 bg-white">
            <div class="bg-primary bg-opacity-10 p-3 rounded-4 text-primary d-inline-block mb-3">
              <i class="bx bx-music fs-3"></i>
            </div>
            <h5 class="fw-bold mb-2">Musik Latar Kustom</h5>
            <p class="text-muted mb-0">Pilih musik romantis favorit Anda sebagai lagu pengiring saat tamu membuka undangan digital Anda.</p>
          </div>
        </div>

        <!-- Feature 2 -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 rounded-4 border-0 shadow-sm p-4 bg-white">
            <div class="bg-success bg-opacity-10 p-3 rounded-4 text-success d-inline-block mb-3">
              <i class="bx bx-check-double fs-3"></i>
            </div>
            <h5 class="fw-bold mb-2">Konfirmasi RSVP Instan</h5>
            <p class="text-muted mb-0">Terima konfirmasi kehadiran tamu secara otomatis dan real-time langsung melalui dashboard admin Anda.</p>
          </div>
        </div>

        <!-- Feature 3 -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 rounded-4 border-0 shadow-sm p-4 bg-white">
            <div class="bg-info bg-opacity-10 p-3 rounded-4 text-info d-inline-block mb-3">
              <i class="bx bx-map-alt fs-3"></i>
            </div>
            <h5 class="fw-bold mb-2">Integrasi Navigasi Peta</h5>
            <p class="text-muted mb-0">Bantu para tamu menemukan lokasi resepsi dengan mudah berkat integrasi Google Maps & Waze.</p>
          </div>
        </div>

        <!-- Feature 4 -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 rounded-4 border-0 shadow-sm p-4 bg-white">
            <div class="bg-warning bg-opacity-10 p-3 rounded-4 text-warning d-inline-block mb-3">
              <i class="bx bx-images fs-3"></i>
            </div>
            <h5 class="fw-bold mb-2">Galeri Foto & Video</h5>
            <p class="text-muted mb-0">Bagikan keindahan foto prewedding Anda dalam galeri grid yang interaktif dan responsif.</p>
          </div>
        </div>

        <!-- Feature 5 -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 rounded-4 border-0 shadow-sm p-4 bg-white">
            <div class="bg-danger bg-opacity-10 p-3 rounded-4 text-danger d-inline-block mb-3">
              <i class="bx bx-heart fs-3"></i>
            </div>
            <h5 class="fw-bold mb-2">Kisah Cinta (Love Story)</h5>
            <p class="text-muted mb-0">Tampilkan lini masa cerita perjalanan cinta Anda dari awal bertemu hingga pelaminan dengan indah.</p>
          </div>
        </div>

        <!-- Feature 6 -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 rounded-4 border-0 shadow-sm p-4 bg-white">
            <div class="bg-dark bg-opacity-10 p-3 rounded-4 text-dark d-inline-block mb-3">
              <i class="bx bx-gift fs-3"></i>
            </div>
            <h5 class="fw-bold mb-2">Amplop Digital (Kado Online)</h5>
            <p class="text-muted mb-0">Memudahkan tamu mengirimkan tanda kasih secara digital melalui transfer bank atau e-wallet resmi.</p>
          </div>
        </div>
      </div>

    </div>
  </section>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>
