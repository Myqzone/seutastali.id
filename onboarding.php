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

// Fetch token from GET or SESSION
$draft_token = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : (isset($_SESSION['active_draft_token']) ? $_SESSION['active_draft_token'] : '');
$guest_name = isset($_SESSION['guest_name']) ? $_SESSION['guest_name'] : (isset($_GET['guest_name']) ? htmlspecialchars($_GET['guest_name']) : 'Pelanggan');
$guest_email = isset($_SESSION['guest_email']) ? $_SESSION['guest_email'] : (isset($_GET['guest_email']) ? htmlspecialchars($_GET['guest_email']) : '');

// Fetch draft data if token exists using native mysqli
$draft_data = null;
if (!empty($draft_token)) {
    try {
        $stmt = $conn->prepare("SELECT draft_data FROM invitation_drafts WHERE draft_token = ?");
        if ($stmt) {
            $stmt->bind_param("s", $draft_token);
            $stmt->execute();
            $result = $stmt->get_result();
            $draft_row = $result->fetch_assoc();
            $stmt->close();
            
            if ($draft_row) {
                $draft_data = json_decode($draft_row['draft_data'], true);
            }
        }
    } catch (Exception $e) {
        // Fallback silently
    }
}

// Set page meta
$page_title = 'Lengkapi Undanganmu - Seutastali';
$page_description = 'Langkah terakhir untuk mengaktifkan dan mempublikasikan undangan pernikahan digital Anda.';

ob_start();
?>

  <style>
    /* Stepper Container & Header */
    .onboarding-card {
      border: 3px solid #000;
      background: #fff;
      box-shadow: 8px 8px 0px #000;
      border-radius: 20px;
      overflow: hidden;
      margin-top: 1.5rem;
    }

    .onboarding-header {
      background: #faf6f0;
      border-bottom: 3px solid #000;
      padding: 2rem;
    }

    /* Modern Stepper Indicator */
    .stepper-progress {
      display: flex;
      justify-content: space-between;
      position: relative;
      margin: 1.5rem 0;
    }

    .stepper-progress::before {
      content: "";
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 4px;
      background: #000;
      transform: translateY(-50%);
      z-index: 1;
    }

    .step-node {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #fff;
      border: 3px solid #000;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      font-size: 16px;
      z-index: 2;
      box-shadow: 2px 2px 0px #000;
      transition: all 0.3s ease;
    }

    .step-node.active {
      background: var(--c-primary);
      color: #fff;
      transform: scale(1.1);
      box-shadow: 3px 3px 0px #000;
    }

    .step-node.completed {
      background: #198754;
      color: #fff;
    }

    /* Form Fields Neubrutalism */
    .neubrutal-input {
      border: 3px solid #000 !important;
      border-radius: 10px !important;
      padding: 12px 18px !important;
      font-weight: 600 !important;
      box-shadow: 3px 3px 0px #000 !important;
      transition: all 0.2s ease !important;
    }

    .neubrutal-input:focus {
      outline: none !important;
      box-shadow: 1px 1px 0px #000 !important;
      transform: translate(2px, 2px) !important;
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

    .onboarding-step-content {
      display: none;
      padding: 2.5rem;
    }

    .onboarding-step-content.active {
      display: block;
    }

    /* Standard Card Price Layout for Onboarding */
    .onboarding-pricing-card {
      border: 3px solid #000;
      border-radius: 16px;
      padding: 1.5rem;
      background: #fff;
      box-shadow: 4px 4px 0px #000;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .onboarding-pricing-card.selected, .onboarding-pricing-card:hover {
      background: #fffcf8;
      border-color: var(--c-primary);
      box-shadow: 6px 6px 0px #000;
      transform: translate(-2px, -2px);
    }
  </style>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-9 col-xl-8">
        
        <!-- Onboarding Unified Stepper Box -->
        <div class="onboarding-card">
          
          <!-- Stepper Header -->
          <div class="onboarding-header">
            <div class="row align-items-center">
              <div class="col-md-7 text-center text-md-start">
                <span class="badge bg-danger text-white mb-2 px-3 py-1.5 rounded-pill text-uppercase fw-bold" style="font-size: 9px; letter-spacing: 0.5px;">Onboarding Stepper</span>
                <h2 class="fw-bold mb-1" style="font-size: 1.75rem; letter-spacing: -0.5px;">Lengkapi Undangan Cantikmu! ✨</h2>
                <p class="text-muted small mb-0">Hanya 3 langkah lagi untuk mempublikasikan undangan pernikahan resmi Anda.</p>
              </div>
              
              <!-- Visual Indicator Node -->
              <div class="col-md-5">
                <div class="stepper-progress">
                  <div class="step-node active" id="node1">1</div>
                  <div class="step-node" id="node2">2</div>
                  <div class="step-node" id="node3">3</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Step 1: Account Password Setup -->
          <div class="onboarding-step-content active" id="step1">
            <h4 class="fw-bold mb-3">Langkah 1: Atur Akun Pengaman 🔑</h4>
            <p class="text-muted small mb-4">Alamat Email Anda digunakan sebagai ID login di kemudian hari. Silakan buat password baru Anda di bawah ini:</p>

            <form id="formStep1" class="d-flex flex-column gap-3">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">Nama Lengkap</label>
                  <input type="text" class="form-control neubrutal-input bg-light" value="<?php echo $guest_name; ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">Alamat Email</label>
                  <input type="text" class="form-control neubrutal-input bg-light" value="<?php echo $guest_email; ?>" readonly>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label small fw-bold text-uppercase text-muted">Buat Password Baru</label>
                <input type="password" class="form-control neubrutal-input" id="clientPass" required placeholder="Masukkan minimal 6 karakter password">
              </div>

              <div class="mb-4">
                <label class="form-label small fw-bold text-uppercase text-muted">Ulangi Password Baru</label>
                <input type="password" class="form-control neubrutal-input" id="clientPassConfirm" required placeholder="Konfirmasi ulang password Anda">
              </div>

              <button type="submit" class="btn neubrutal-btn neubrutal-btn-primary w-100 py-2.5 mt-2">
                Simpan & Lanjut Isi Data <i class="fa-solid fa-arrow-right ms-1"></i>
              </button>
            </form>
          </div>

          <!-- Step 2: Complete Wedding Details -->
          <div class="onboarding-step-content" id="step2">
            <h4 class="fw-bold mb-3">Langkah 2: Kelengkapan Detail Pernikahan 👰🤵</h4>
            <p class="text-muted small mb-4">Lengkapi detail pendukung undangan untuk disematkan di halaman undangan pernikahan digital resmi Anda:</p>

            <form id="formStep2" class="d-flex flex-column gap-3">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">Nama Orang Tua Pengantin Pria</label>
                  <input type="text" class="form-control neubrutal-input" id="groomParents" placeholder="Contoh: Putra dari Bapak X & Ibu Y">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">Nama Orang Tua Pengantin Wanita</label>
                  <input type="text" class="form-control neubrutal-input" id="brideParents" placeholder="Contoh: Putri dari Bapak Z & Ibu W">
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label small fw-bold text-uppercase text-muted">Alamat Lengkap Gedung / Rumah Acara</label>
                <textarea class="form-control neubrutal-input" id="eventAddress" rows="3" placeholder="Contoh: Gedung Graha Agung, Jalan Raya No. 45, Jakarta Selatan"></textarea>
              </div>

              <div class="mb-4">
                <label class="form-label small fw-bold text-uppercase text-muted">Link Google Maps Lokasi</label>
                <input type="url" class="form-control neubrutal-input" id="eventMaps" placeholder="Contoh: https://maps.google.com/?q=graha-agung">
                <div class="form-text small text-muted">Salin link share dari Google Maps agar tamu bisa mengakses navigasi rute jalan secara otomatis.</div>
              </div>

              <div class="d-flex gap-3 mt-2">
                <button type="button" class="btn neubrutal-btn btn-outline-dark px-4 py-2.5" id="btnBackTo1">Kembali</button>
                <button type="submit" class="btn neubrutal-btn neubrutal-btn-primary flex-grow-1 py-2.5">
                  Lanjut ke Pembayaran <i class="fa-solid fa-arrow-right ms-1"></i>
                </button>
              </div>
            </form>
          </div>

          <!-- Step 3: Transaction & Packages -->
          <div class="onboarding-step-content" id="step3">
            <h4 class="fw-bold mb-3">Langkah 3: Pilih Paket & Aktifkan! 💰</h4>
            <p class="text-muted small mb-4">Pilih paket harga yang paling sesuai untuk undangan digital Anda:</p>

            <form id="formStep3" class="d-flex flex-column gap-3">
              
              <!-- 4 Pricing Cards Grid (Clean, distraction free) -->
              <div class="row g-3 mb-4">
                <!-- Paket Dasar -->
                <div class="col-md-6 col-lg-3">
                  <div class="onboarding-pricing-card h-100 d-flex flex-column text-center selected" data-package="Dasar" data-price="149000">
                    <span class="badge bg-primary text-white mx-auto mb-2 px-2.5 py-1 rounded-pill text-uppercase fw-bold" style="font-size: 8px;">Dasar</span>
                    <h5 class="fw-bold mb-1">Rp 149.000</h5>
                    <p class="text-muted small mb-3">Masa Aktif 30 Hari</p>
                    <ul class="list-unstyled text-start small text-secondary mb-0 mt-auto" style="font-size: 11px;">
                      <li><i class="fa-solid fa-circle-check text-primary me-1"></i> Semua Pilihan Tema</li>
                      <li><i class="fa-solid fa-circle-check text-primary me-1"></i> 15 Galeri Foto</li>
                      <li><i class="fa-solid fa-circle-check text-primary me-1"></i> Fitur RSVP & Maps</li>
                    </ul>
                  </div>
                </div>

                <!-- Paket Lengkap -->
                <div class="col-md-6 col-lg-3">
                  <div class="onboarding-pricing-card h-100 d-flex flex-column text-center" data-package="Lengkap" data-price="199000">
                    <span class="badge bg-secondary text-white mx-auto mb-2 px-2.5 py-1 rounded-pill text-uppercase fw-bold" style="font-size: 8px;">Lengkap</span>
                    <h5 class="fw-bold mb-1">Rp 199.000</h5>
                    <p class="text-muted small mb-3">Masa Aktif 60 Hari</p>
                    <ul class="list-unstyled text-start small text-secondary mb-0 mt-auto" style="font-size: 11px;">
                      <li><i class="fa-solid fa-circle-check text-primary me-1"></i> Fitur Paket Dasar</li>
                      <li><i class="fa-solid fa-circle-check text-primary me-1"></i> 25 Galeri & Video</li>
                      <li><i class="fa-solid fa-circle-check text-primary me-1"></i> Amplop / Gift Digital</li>
                    </ul>
                  </div>
                </div>

                <!-- Paket Eksklusif -->
                <div class="col-md-6 col-lg-3">
                  <div class="onboarding-pricing-card h-100 d-flex flex-column text-center" data-package="Eksklusif" data-price="249000">
                    <span class="badge bg-danger text-white mx-auto mb-2 px-2.5 py-1 rounded-pill text-uppercase fw-bold" style="font-size: 8px;">Eksklusif</span>
                    <h5 class="fw-bold mb-1">Rp 249.000</h5>
                    <p class="text-muted small mb-3">Masa Aktif 90 Hari</p>
                    <ul class="list-unstyled text-start small text-secondary mb-0 mt-auto" style="font-size: 11px;">
                      <li><i class="fa-solid fa-circle-check text-primary me-1"></i> Fitur Paket Lengkap</li>
                      <li><i class="fa-solid fa-circle-check text-primary me-1"></i> 35 Galeri Foto</li>
                      <li><i class="fa-solid fa-circle-check text-primary me-1"></i> Bebas Ganti Warna & Font</li>
                    </ul>
                  </div>
                </div>

                <!-- Paket Premium -->
                <div class="col-md-6 col-lg-3">
                  <div class="onboarding-pricing-card h-100 d-flex flex-column text-center" data-package="Premium" data-price="399000">
                    <span class="badge bg-dark text-white mx-auto mb-2 px-2.5 py-1 rounded-pill text-uppercase fw-bold" style="font-size: 8px;">Premium</span>
                    <h5 class="fw-bold mb-1">Rp 399.000</h5>
                    <p class="text-muted small mb-3">Masa Aktif 1 Tahun</p>
                    <ul class="list-unstyled text-start small text-secondary mb-0 mt-auto" style="font-size: 11px;">
                      <li><i class="fa-solid fa-circle-check text-primary me-1"></i> Fitur Eksklusif</li>
                      <li><i class="fa-solid fa-circle-check text-primary me-1"></i> Unlimited Foto & Video</li>
                      <li><i class="fa-solid fa-circle-check text-primary me-1"></i> QR Code Tamu Checkin</li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Input Kupon Diskon -->
              <div class="row align-items-center mb-4">
                <div class="col-md-8 mb-3 mb-md-0">
                  <label class="form-label small fw-bold text-uppercase text-muted">Kupon Diskon (Opsional)</label>
                  <input type="text" class="form-control neubrutal-input" id="couponCode" placeholder="Masukkan kode kupon diskon Anda">
                </div>
                <div class="col-md-4 align-self-end">
                  <button type="button" class="btn neubrutal-btn btn-dark w-100 py-2.5" id="btnApplyCoupon">Terapkan</button>
                </div>
              </div>

              <!-- Ringkasan Tagihan & Selesaikan Transaksi -->
              <div class="p-3 bg-light rounded-4 border-0 mb-4" style="border: 2px solid #000 !important; box-shadow: 3px 3px 0px #000 !important;">
                <div class="d-flex justify-content-between mb-2">
                  <span class="fw-bold">Paket yang Dipilih:</span>
                  <span class="fw-bold text-primary" id="txtPackageName">Dasar</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted">Harga Paket:</span>
                  <span class="text-muted" id="txtPackagePrice">Rp 149.000</span>
                </div>
                <div class="d-flex justify-content-between border-top pt-2 mt-2">
                  <span class="fw-bold fs-5">Total Pembayaran:</span>
                  <span class="fw-bold fs-5 text-primary" id="txtTotalPayment">Rp 149.000</span>
                </div>
              </div>

              <div class="d-flex gap-3">
                <button type="button" class="btn neubrutal-btn btn-outline-dark px-4 py-2.5" id="btnBackTo2">Kembali</button>
                <button type="submit" class="btn neubrutal-btn neubrutal-btn-primary flex-grow-1 py-2.5">
                  Bayar Sekarang <i class="fa-solid fa-credit-card ms-1"></i>
                </button>
              </div>
            </form>
          </div>

        </div>

      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // 1. Navigation Setup
      const step1 = document.getElementById('step1');
      const step2 = document.getElementById('step2');
      const step3 = document.getElementById('step3');

      const node1 = document.getElementById('node1');
      const node2 = document.getElementById('node2');
      const node3 = document.getElementById('node3');

      // Forms
      const formStep1 = document.getElementById('formStep1');
      const formStep2 = document.getElementById('formStep2');
      const formStep3 = document.getElementById('formStep3');

      // Back Buttons
      document.getElementById('btnBackTo1').addEventListener('click', function() {
        step2.classList.remove('active');
        step1.classList.add('active');
        node2.classList.remove('active');
        node1.classList.add('active');
      });

      document.getElementById('btnBackTo2').addEventListener('click', function() {
        step3.classList.remove('active');
        step2.classList.add('active');
        node3.classList.remove('active');
        node2.classList.add('active');
      });

      // 2. Stepper Submits
      let userPass = "";
      let weddingDetail = {};

      formStep1.addEventListener('submit', function(e) {
        e.preventDefault();
        const pass = document.getElementById('clientPass').value;
        const confirm = document.getElementById('clientPassConfirm').value;

        if (pass.length < 6) {
          alert('Password harus minimal 6 karakter.');
          return;
        }

        if (pass !== confirm) {
          alert('Konfirmasi password tidak cocok.');
          return;
        }

        userPass = pass;
        
        // Advance to Step 2
        step1.classList.remove('active');
        step2.classList.add('active');
        node1.classList.remove('active');
        node1.classList.add('completed');
        node2.classList.add('active');
      });

      formStep2.addEventListener('submit', function(e) {
        e.preventDefault();
        
        weddingDetail = {
          groom_parents: document.getElementById('groomParents').value,
          bride_parents: document.getElementById('brideParents').value,
          event_address: document.getElementById('eventAddress').value,
          event_maps: document.getElementById('eventMaps').value
        };

        // Advance to Step 3
        step2.classList.remove('active');
        step3.classList.add('active');
        node2.classList.remove('active');
        node2.classList.add('completed');
        node3.classList.add('active');
      });

      // 3. Pricing Selection Logic
      const pricingCards = document.querySelectorAll('.onboarding-pricing-card');
      const txtPackageName = document.getElementById('txtPackageName');
      const txtPackagePrice = document.getElementById('txtPackagePrice');
      const txtTotalPayment = document.getElementById('txtTotalPayment');
      
      let selectedPackage = "Dasar";
      let selectedPrice = 149000;

      pricingCards.forEach(card => {
        card.addEventListener('click', function() {
          pricingCards.forEach(c => c.classList.remove('selected'));
          this.classList.add('selected');
          
          selectedPackage = this.getAttribute('data-package');
          selectedPrice = parseInt(this.getAttribute('data-price'));

          // Update Summary UI
          txtPackageName.innerText = selectedPackage;
          
          const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(selectedPrice);
          txtPackagePrice.innerText = formattedPrice;
          txtTotalPayment.innerText = formattedPrice;
        });
      });

      // 4. Submit Final (Midtrans Redirect simulated)
      formStep3.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Compile all onboarding parameters
        const finalPayload = {
          token: "<?php echo $draft_token; ?>",
          client_password: userPass,
          details: weddingDetail,
          package_name: selectedPackage,
          package_price: selectedPrice
        };

        // Call final API endpoint to complete register + transaction snap
        fetch('api/submit_onboarding.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(finalPayload)
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            // Success redirect to simulated payment-success page
            window.location.href = 'payment-success.php?token=' + data.token + '&package=' + selectedPackage;
          } else {
            alert('Gagal memproses onboarding: ' + data.message);
          }
        })
        .catch(err => {
          console.error(err);
          // Fallback redirect for mockup demo purposes
          window.location.href = 'payment-success.php?token=mocktoken&package=' + selectedPackage;
        });
      });
    });
  </script>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>
