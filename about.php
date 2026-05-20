<?php
// Load bootstrap (centralized config loading)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Set page meta
$page_title = 'About Us - Seutastali';
$page_description = 'Pelajari lebih lanjut tentang Seutastali dan visi misi kami sebagai platform undangan digital premium.';

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
            Tentang <span class="text-primary fw-bold">Kami</span>
          </h1>
          <p class="ms-0 text-start mb-0" style="margin-left: 0 !important; max-width: 620px;">
            Pelajari lebih lanjut tentang Seutastali dan visi misi kami
          </p>
        </div>

        <!-- Right-aligned Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-0 order-1 order-md-2 align-self-start align-self-md-start pt-md-2">
          <ol class="breadcrumb mb-0 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item active text-primary" aria-current="page">About Us</li>
          </ol>
        </nav>
      </div>
    </div>
  </section>

  <!-- About Content Section -->
  <section class="pt-3 pb-5">
    <div class="container">

      <!-- Content Content -->
      <div class="mb-5">
        <h4 class="fw-bold mb-3">Teman Terpercaya Momen Bahagiamu</h4>
        <p class="mb-4 lh-lg">
          Seutastali hadir sebagai platform pembuatan undangan digital profesional yang elegan, praktis, dan berkesan untuk momen istimewa Anda. Kami percaya bahwa setiap kisah cinta memiliki untaian cerita unik yang layak dibagikan dengan indah.
        </p>
        <p class="mb-0 lh-lg">
          Dengan teknologi modern dan desain editorial eksklusif, kami memastikan kabar bahagia Anda tersampaikan dengan sempurna kepada keluarga, sahabat, dan kerabat tercinta di mana pun mereka berada.
        </p>
      </div>

    </div>
  </section>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>
