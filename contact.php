<?php
// Load bootstrap (centralized config loading)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Set page meta
$page_title = 'Contact Us - SeutasTali';
$page_description = 'Hubungi tim SeutasTali untuk pertanyaan atau konsultasi seputar layanan pembuatan undangan digital.';

ob_start();
?>

  <section class="position-relative py-5 mt-3">
    <div class="container position-relative z-3">

      <!-- Page Header -->
      <div class="text-center mb-5">
        <h2 class="fw-bold"><span class="text-primary">Contact</span> Us</h2>
        <p class="text-muted">Kami siap membantu menyukseskan persiapan hari bahagia Anda</p>
      </div>

      <div class="row g-4 mb-5">
        <!-- Info Column -->
        <div class="col-lg-5">
          <div class="card rounded-4 border-0 shadow-sm h-100 bg-light p-4 p-md-5">
            <h4 class="mb-4 fw-bold">Informasi Kontak</h4>

            <div class="d-flex flex-column gap-4">
              <!-- Address -->
              <div class="d-flex align-items-start gap-3">
                <div class="flex-shrink-0 bg-white p-3 rounded-4 shadow-sm text-primary">
                  <i class="bx bx-map fs-3"></i>
                </div>
                <div>
                  <h6 class="mb-1 fw-bold">Alamat</h6>
                  <p class="mb-0 text-muted">Bandung, Jawa Barat, Indonesia</p>
                </div>
              </div>

              <!-- WhatsApp -->
              <div class="d-flex align-items-start gap-3">
                <div class="flex-shrink-0 bg-white p-3 rounded-4 shadow-sm text-success">
                  <i class="bx bxl-whatsapp fs-3"></i>
                </div>
                <div>
                  <h6 class="mb-1 fw-bold">WhatsApp</h6>
                  <a href="https://wa.me/6282227773904" target="_blank" class="mb-0 text-decoration-none text-muted">+62 822 2777 3904</a>
                </div>
              </div>

              <!-- Email -->
              <div class="d-flex align-items-start gap-3">
                <div class="flex-shrink-0 bg-white p-3 rounded-4 shadow-sm text-info">
                  <i class="bx bx-envelope fs-3"></i>
                </div>
                <div>
                  <h6 class="mb-1 fw-bold">Email</h6>
                  <a href="mailto:hello@seutastali.id" class="mb-0 text-decoration-none text-muted">hello@seutastali.id</a>
                </div>
              </div>
            </div>

            <div class="mt-5">
              <h6 class="fw-bold mb-3">Ikuti Kami</h6>
              <div class="hstack gap-3">
                <a href="https://www.instagram.com/seutastali.id/" target="_blank" class="btn btn-outline-primary rounded-pill px-4 py-2">
                  <i class="bx bxl-instagram me-2"></i>Instagram
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Form Column -->
        <div class="col-lg-7">
          <div class="card rounded-4 border-0 shadow-sm h-100 p-4 p-md-5 bg-white">
            <h4 class="mb-4 fw-bold">Kirim Pesan</h4>
            <form action="#" method="POST" class="row g-3">
              <div class="col-md-6">
                <label class="form-label small fw-bold">Nama Lengkap</label>
                <input type="text" class="form-control rounded-pill px-3 py-2" placeholder="Nama Anda">
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold">Alamat Email</label>
                <input type="email" class="form-control rounded-pill px-3 py-2" placeholder="email@example.com">
              </div>
              <div class="col-12">
                <label class="form-label small fw-bold">Subjek</label>
                <input type="text" class="form-control rounded-pill px-3 py-2" placeholder="Subjek Pesan">
              </div>
              <div class="col-12">
                <label class="form-label small fw-bold">Isi Pesan</label>
                <textarea class="form-control rounded-4 px-3 py-2" rows="4" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."></textarea>
              </div>
              <div class="col-12 mt-4 text-end">
                <button type="button" onclick="alert('Fitur pengiriman pesan sedang dikembangkan.')" class="btn btn-primary rounded-pill px-5 py-3">
                  Kirim Pesan <i class="bx bx-send ms-2"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </section>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>
