<?php
// Load bootstrap (centralized config loading)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Set page meta
$page_title = 'Features - Seutastali';
$page_description = 'Jelajahi fitur lengkap platform pembuatan undangan digital Seutastali.';

ob_start();
?>

  <!-- Page Header Section -->
  <section class="position-relative mt-5 mt-lg-4">
    <div class="container position-relative z-3">

      <!-- Standardized Premium Section Header with Inline Breadcrumb on Right -->
      <div class="d-flex flex-column flex-md-row align-items-md-start justify-content-md-between gap-3 mb-3">

        <!-- Left-aligned Header Title -->
        <div class="section-header text-start mb-0 order-2 order-md-1">
          <h1 class="hero-title text-start ms-0" style="margin-left: 0 !important; margin-bottom: 0.5rem !important;">
            Fitur <span class="text-primary fw-bold">Platform</span>
          </h1>
          <p class="ms-0 text-start mb-0" style="margin-left: 0 !important; max-width: 620px;">
            Semua fitur hebat yang kami sediakan untuk melengkapi kebahagiaan Anda
          </p>
        </div>

        <!-- Right-aligned Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-0 order-1 order-md-2 align-self-start align-self-md-start pt-md-2">
          <ol class="breadcrumb mb-0 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item active text-primary" aria-current="page">Features</li>
          </ol>
        </nav>
      </div>
    </div>
  </section>

  <!-- Features Content Section -->
  <section class="pt-3 pb-5">
    <div class="container">

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
