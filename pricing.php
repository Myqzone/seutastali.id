<?php
// Load bootstrap (centralized config loading)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Set page meta
$page_title = 'Pricing Tiers - Seutastali';
$page_description = 'Pilih paket harga undangan digital terbaik yang sesuai dengan kebutuhan pernikahan impian Anda.';

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
          Paket <span class="text-primary fw-bold">Harga</span>
        </h1>
        <p class="ms-0 text-start mb-0" style="margin-left: 0 !important; max-width: 620px;">
          Pilih paket harga yang paling sesuai untuk hari bahagia Anda
        </p>
      </div>

      <!-- Right-aligned Breadcrumb Navigation -->
      <nav aria-label="breadcrumb" class="mb-0 order-1 order-md-2 align-self-start align-self-md-start pt-md-2">
        <ol class="breadcrumb mb-0 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">
          <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
          <li class="breadcrumb-item active text-primary" aria-current="page">Pricing</li>
        </ol>
      </nav>
    </div>
  </div>
</section>

<!-- Pricing Content Section -->
<section class="pt-3 pb-5">
  <div class="container">

    <style>
      @media (min-width: 992px) {
        .pricing-divider {
          border-right: 1px solid rgba(61, 12, 17, 0.08);
        }
      }

      .pricing-feature-list li {
        display: flex;
        align-items: start;
        font-size: 0.9rem;
        color: #4a4035;
        margin-bottom: 0.75rem;
      }

      .pricing-feature-list li i {
        margin-top: 3px;
      }
    </style>

    <!-- Paket Dasar (Full Width 1-Grid Row) -->
    <div class="row mb-5">
      <div class="col-12" data-aos="fade-up" data-aos-delay="100">
        <div class="card rounded-4 border-0 shadow-sm p-4 bg-white">
          <div class="row g-4 align-items-center">
            <!-- Left side: Pricing details -->
            <div class="col-lg-4 text-center text-lg-start pricing-divider pe-lg-4 pb-3 pb-lg-0">
              <span class="badge bg-primary text-white mb-2 px-3 py-2 rounded-pill text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">Dasar</span>
              <h2 class="fw-bold mb-1" style="font-size: 2.25rem;">Rp 149.000</h2>
              <p class="text-muted small mb-4">Masa Aktif 30 Hari</p>
              <a href="templates.php" class="btn btn-outline-primary rounded-pill px-5 py-2 fw-bold w-100 w-lg-auto">Mulai Buat</a>
            </div>
            <!-- Right side: Grid of features -->
            <div class="col-lg-8 ps-lg-4">
              <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">Fitur yang Didapatkan:</h6>
              <div class="row g-2">
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Semua Pilihan Desain
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Subdomain
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Smart Dashboard
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Fitur RSVP
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> 15 Galeri Foto
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Crop Foto & GIF
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Unlimited Edit
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Maps Lokasi
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Countdown Timer
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Add to Calendar
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Autoplay Lagu
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Instagram Mempelai
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Amplop Digital
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Wedding Wish
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="d-flex align-items-center small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i> Protokol Kesehatan
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
    <!-- Pricing Cards Grid -->
    <div class="row g-4 justify-content-center mb-5">
      <!-- Lengkap Package -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="150">
        <div class="card h-100 rounded-4 border-0 shadow-sm p-4 bg-white d-flex flex-column">
          <div class="mb-4">
            <span class="badge bg-light text-dark mb-2 px-3 py-2 rounded-pill text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">Lengkap</span>
            <h3 class="fw-bold mb-1">Rp 199.000</h3>
            <p class="text-muted small mb-4">Masa Aktif 60 Hari</p>
          </div>
          <ul class="list-unstyled mb-4 flex-grow-1 pricing-feature-list">
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Semua Fitur Paket Dasar</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>25 Galeri Foto</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Galeri Video</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Wedding Gift / Angpao</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Custom Musik Latar</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Kisah Cinta (Love Story)</li>
          </ul>
          <a href="templates.php" class="btn btn-outline-primary rounded-pill w-100 mt-auto fw-bold">Mulai Buat</a>
        </div>
      </div>
 
      <!-- Eksklusif Package -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card h-100 rounded-4 border-0 shadow-sm p-4 bg-white d-flex flex-column position-relative overflow-hidden" style="border: 2px solid var(--c-primary) !important;">
          <div class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 text-uppercase fw-bold" style="font-size: 9px; letter-spacing: 1px; border-bottom-left-radius: 12px;">Terpopuler</div>
          <div class="mb-4">
            <span class="badge bg-primary text-white mb-2 px-3 py-2 rounded-pill text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">Eksklusif</span>
            <h3 class="fw-bold mb-1">Rp 249.000</h3>
            <p class="text-muted small mb-4">Masa Aktif 90 Hari</p>
          </div>
          <ul class="list-unstyled mb-4 flex-grow-1 pricing-feature-list">
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Semua Fitur Paket Lengkap</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>35 Galeri Foto</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Bebas Atur Urutan Section</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Bebas Ganti Warna & Font</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Informasi Dresscode Acara</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Daftar Turut Mengundang</li>
          </ul>
          <a href="templates.php" class="btn btn-primary rounded-pill w-100 mt-auto fw-bold">Mulai Buat</a>
        </div>
      </div>
 
      <!-- Premium Package -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="250">
        <div class="card h-100 rounded-4 border-0 shadow-sm p-4 bg-white d-flex flex-column">
          <div class="mb-4">
            <span class="badge bg-dark text-white mb-2 px-3 py-2 rounded-pill text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">Premium</span>
            <h3 class="fw-bold mb-1">Rp 399.000</h3>
            <p class="text-muted small mb-4">Masa Aktif 1 Tahun</p>
          </div>
          <ul class="list-unstyled mb-4 flex-grow-1 pricing-feature-list">
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Semua Fitur Paket Eksklusif</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Unlimited Galeri Foto</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Personalized Name Link</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Check-in QR Code Tamu</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Link Filter Instagram</li>
            <li><i class="fa-solid fa-circle-check text-primary me-2"></i>Link Live Streaming</li>
          </ul>
          <a href="templates.php" class="btn btn-outline-primary rounded-pill w-100 mt-auto fw-bold">Mulai Buat</a>
        </div>
      </div>
    </div>

  </div>
</section>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>