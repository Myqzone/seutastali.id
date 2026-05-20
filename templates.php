<?php
// Load bootstrap (centralized config loading)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Set page meta
$page_title = 'Pilih Desain Undangan - SeutasTali';
$page_description = 'Pilih dari berbagai desain template undangan pernikahan digital eksklusif dan editorial untuk hari bahagia Anda.';

ob_start();
?>

  <section class="position-relative py-5 mt-3">
    <div class="container position-relative z-3">

      <!-- Page Header -->
      <div class="text-center mb-5">
        <h2 class="fw-bold">Pilih <span class="text-primary">Template</span> Undangan</h2>
        <p class="text-muted">Desain premium yang dikurasi secara editorial untuk momen istimewa Anda</p>
      </div>

      <!-- Templates Grid -->
      <div class="row g-4 mb-5">
        <!-- Template 1: Classic Editorial -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 rounded-4 border-0 shadow-sm overflow-hidden bg-white d-flex flex-column">
            <div class="position-relative bg-light text-center p-4 border-bottom" style="height: 250px; display: flex; align-items: center; justify-content: center;">
              <!-- Beautiful Stylized Icon/Mockup for Template -->
              <div class="d-flex flex-column align-items-center">
                <i class="bx bx-book-open fs-1 text-primary mb-3"></i>
                <span class="badge bg-primary px-3 py-2 rounded-pill">Classic Editorial</span>
              </div>
            </div>
            <div class="card-body p-4 flex-grow-1 d-flex flex-column">
              <h5 class="fw-bold mb-2">The Heritage</h5>
              <p class="text-muted small mb-4">Desain bertema klasik editorial dengan tipografi serif yang elegan, berkelas, dan abadi. Sangat cocok untuk pernikahan bertema tradisional maupun formal.</p>
              <div class="mt-auto d-flex gap-2">
                <a href="#" onclick="alert('Pratinjau desain sedang dimuat...')" class="btn btn-outline-primary rounded-pill flex-grow-1">Preview</a>
                <a href="#" onclick="alert('Selamat! Anda telah memilih desain: The Heritage.')" class="btn btn-primary rounded-pill flex-grow-1">Pilih</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Template 2: Modern Neubrutalist -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 rounded-4 border-0 shadow-sm overflow-hidden bg-white d-flex flex-column" style="border: 2px solid var(--c-primary) !important;">
            <div class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 small rounded-bottom-start">Terpopuler</div>
            <div class="position-relative bg-light text-center p-4 border-bottom" style="height: 250px; display: flex; align-items: center; justify-content: center;">
              <div class="d-flex flex-column align-items-center">
                <i class="bx bx-palette fs-1 text-primary mb-3"></i>
                <span class="badge bg-success px-3 py-2 rounded-pill">Modern Neubrutalist</span>
              </div>
            </div>
            <div class="card-body p-4 flex-grow-1 d-flex flex-column">
              <h5 class="fw-bold mb-2">Katsudoto Style</h5>
              <p class="text-muted small mb-4">Gaya modern berani dengan stroke tebal, tata letak bento grid yang dinamis, perpaduan warna pastel yang cerah, serta tipografi kontemporer bernuansa estetika tinggi.</p>
              <div class="mt-auto d-flex gap-2">
                <a href="#" onclick="alert('Pratinjau desain sedang dimuat...')" class="btn btn-outline-primary rounded-pill flex-grow-1">Preview</a>
                <a href="#" onclick="alert('Selamat! Anda telah memilih desain: Katsudoto Style.')" class="btn btn-primary rounded-pill flex-grow-1">Pilih</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Template 3: Minimalist Chic -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 rounded-4 border-0 shadow-sm overflow-hidden bg-white d-flex flex-column">
            <div class="position-relative bg-light text-center p-4 border-bottom" style="height: 250px; display: flex; align-items: center; justify-content: center;">
              <div class="d-flex flex-column align-items-center">
                <i class="bx bx-shape-polygon fs-1 text-primary mb-3"></i>
                <span class="badge bg-dark text-white px-3 py-2 rounded-pill">Minimalist Chic</span>
              </div>
            </div>
            <div class="card-body p-4 flex-grow-1 d-flex flex-column">
              <h5 class="fw-bold mb-2">The Clean Space</h5>
              <p class="text-muted small mb-4">Desain super bersih dengan pemanfaatan ruang kosong yang anggun, garis tipis modern, serta tipografi sans-serif minimalis. Pilihan sempurna untuk pasangan modern.</p>
              <div class="mt-auto d-flex gap-2">
                <a href="#" onclick="alert('Pratinjau desain sedang dimuat...')" class="btn btn-outline-primary rounded-pill flex-grow-1">Preview</a>
                <a href="#" onclick="alert('Selamat! Anda telah memilih desain: The Clean Space.')" class="btn btn-primary rounded-pill flex-grow-1">Pilih</a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>
