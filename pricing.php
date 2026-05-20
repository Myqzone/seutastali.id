<?php
// Load bootstrap (centralized config loading)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Set page meta
$page_title = 'Pricing Tiers - SeutasTali';
$page_description = 'Pilih paket harga undangan digital terbaik yang sesuai dengan kebutuhan pernikahan impian Anda.';

ob_start();
?>

  <section class="position-relative py-5 mt-3">
    <div class="container position-relative z-3">

      <!-- Page Header -->
      <div class="text-center mb-5">
        <h2 class="fw-bold"><span class="text-primary">Pricing</span> Packages</h2>
        <p class="text-muted">Pilih paket harga yang paling sesuai untuk hari bahagia Anda</p>
      </div>

      <!-- Pricing Cards Grid -->
      <div class="row g-4 justify-content-center mb-5">
        <!-- Bronze Package -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 rounded-4 border-0 shadow-sm p-4 bg-white d-flex flex-column">
            <div class="mb-4">
              <span class="badge bg-light text-dark mb-2 px-3 py-2 rounded-pill">Bronze</span>
              <h3 class="fw-bold mb-1">Rp 99.000</h3>
              <p class="text-muted small">Paket Hemat Standard</p>
            </div>
            <ul class="list-unstyled mb-4 flex-grow-1">
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Masa Aktif 3 Bulan</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Desain Template Pilihan</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Hingga 200 Nama Tamu</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>RSVP & Buku Tamu</li>
              <li class="mb-2"><i class="bx bx-x text-danger me-2"></i>Bebas Pilih Musik Latar</li>
            </ul>
            <a href="templates" class="btn btn-outline-primary rounded-pill w-100 mt-auto">Mulai Buat</a>
          </div>
        </div>

        <!-- Silver Package -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 rounded-4 border-0 shadow-sm p-4 bg-white d-flex flex-column position-relative overflow-hidden" style="border: 2px solid var(--c-primary) !important;">
            <div class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 small rounded-bottom-start">Terpopuler</div>
            <div class="mb-4">
              <span class="badge bg-primary text-white mb-2 px-3 py-2 rounded-pill">Silver</span>
              <h3 class="fw-bold mb-1">Rp 149.000</h3>
              <p class="text-muted small">Paket Lengkap Favorit</p>
            </div>
            <ul class="list-unstyled mb-4 flex-grow-1">
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Masa Aktif 1 Tahun</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Bebas Akses Semua Template</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Nama Tamu Tanpa Batas</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>RSVP & Buku Tamu</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Custom Background Music</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Galeri Foto & Video</li>
            </ul>
            <a href="templates" class="btn btn-primary rounded-pill w-100 mt-auto">Mulai Buat</a>
          </div>
        </div>

        <!-- Gold/Editorial Package -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 rounded-4 border-0 shadow-sm p-4 bg-white d-flex flex-column">
            <div class="mb-4">
              <span class="badge bg-dark text-white mb-2 px-3 py-2 rounded-pill">Gold / Editorial</span>
              <h3 class="fw-bold mb-1">Rp 299.000</h3>
              <p class="text-muted small">Desain Kustom Eksklusif</p>
            </div>
            <ul class="list-unstyled mb-4 flex-grow-1">
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Masa Aktif Selamanya</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Desain Kustom Sesuai Request</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Nama Tamu Tanpa Batas</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>RSVP & Buku Tamu</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Custom Background Music</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Bebas Iklan Platform</li>
              <li class="mb-2"><i class="bx bx-check text-success me-2"></i>Kisah Cinta (Love Story)</li>
            </ul>
            <a href="templates" class="btn btn-outline-primary rounded-pill w-100 mt-auto">Mulai Buat</a>
          </div>
        </div>
      </div>

    </div>
  </section>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>
