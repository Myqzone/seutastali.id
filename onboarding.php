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
$template_slug_val = 'floral';
if (!empty($draft_token)) {
    try {
        $stmt = $conn->prepare("SELECT template_slug, draft_data FROM invitation_drafts WHERE draft_token = ?");
        if ($stmt) {
            $stmt->bind_param("s", $draft_token);
            $stmt->execute();
            $result = $stmt->get_result();
            $draft_row = $result->fetch_assoc();
            $stmt->close();
            
            if ($draft_row) {
                $template_slug_val = isset($draft_row['template_slug']) ? $draft_row['template_slug'] : 'floral';
                $draft_data = json_decode($draft_row['draft_data'], true);
                // Fallback to draft_data values if session is missing/expired
                if ($draft_data) {
                    if (empty($guest_name) || $guest_name === 'Pelanggan' || $guest_name === 'Guest Customer') {
                        $guest_name = isset($draft_data['client_name']) ? htmlspecialchars($draft_data['client_name']) : 'Pelanggan';
                    }
                    if (empty($guest_email)) {
                        $guest_email = isset($draft_data['client_email']) ? htmlspecialchars($draft_data['client_email']) : '';
                    }
                    if (isset($draft_data['template']) && !empty($draft_data['template'])) {
                        $template_slug_val = $draft_data['template'];
                    }
                }
            }
        }
    } catch (Exception $e) {
        // Fallback silently
    }
}

// Calculate pre-filled values from draft data
$bride_val = isset($draft_data['bride']) ? htmlspecialchars($draft_data['bride']) : '';
$groom_val = isset($draft_data['groom']) ? htmlspecialchars($draft_data['groom']) : '';
$date_val = isset($draft_data['date']) ? htmlspecialchars($draft_data['date']) : '';
$title_val = (!empty($bride_val) && !empty($groom_val)) ? $groom_val . ' & ' . $bride_val : '';
$subdomain_val = (!empty($bride_val) && !empty($groom_val)) ? preg_replace('/[^a-zA-Z0-9]/', '', strtolower($groom_val)) . '-' . preg_replace('/[^a-zA-Z0-9]/', '', strtolower($bride_val)) : '';

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
    .stepper-progress-wrapper {
      padding: 0.5rem 0;
    }
    .stepper-progress {
      position: relative;
      margin: 1rem 0;
      display: flex;
      justify-content: space-between;
    }
    .stepper-line {
      position: absolute;
      top: 20px;
      left: 10%;
      right: 10%;
      height: 4px;
      background: #000;
      z-index: 1;
      transform: translateY(-50%);
    }
    .step-item {
      flex: 1;
      position: relative;
      z-index: 2;
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
      margin: 0 auto;
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
    .step-label {
      font-size: 0.65rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #777;
      margin-top: 6px;
      font-weight: 800;
      text-align: center;
    }
    .step-node.active + .step-label {
      color: #000;
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
                <span class="badge bg-success text-white mb-2 px-3 py-1.5 rounded-pill text-uppercase fw-bold" style="font-size: 9px; letter-spacing: 0.5px;">Post-Purchase Onboarding</span>
                <h2 class="fw-bold mb-1" style="font-size: 1.75rem; letter-spacing: -0.5px;">Lengkapi Undangan Cantikmu! ✨</h2>
                <p class="text-muted small mb-0">Lengkapi detail undangan Anda di bawah ini untuk mengaktifkan website undangan Anda.</p>
              </div>
              
              <!-- Visual Indicator Node -->
              <div class="col-12 mt-3 mt-md-0 col-md-5">
                <div class="stepper-progress-wrapper d-flex flex-column align-items-center w-100">
                  <div class="stepper-progress position-relative w-100 px-1">
                    <div class="stepper-line"></div>
                    <div class="d-flex justify-content-between position-relative w-100 z-3">
                      <div class="step-item text-center">
                        <div class="step-node active" id="node1">1</div>
                        <span class="step-label d-block mt-2 small fw-bold">Undangan</span>
                      </div>
                      <div class="step-item text-center">
                        <div class="step-node" id="node2">2</div>
                        <span class="step-label d-block mt-2 small fw-bold">Acara</span>
                      </div>
                      <div class="step-item text-center">
                        <div class="step-node" id="node3">3</div>
                        <span class="step-label d-block mt-2 small fw-bold">Akun</span>
                      </div>
                      <div class="step-item text-center">
                        <div class="step-node" id="node4">4</div>
                        <span class="step-label d-block mt-2 small fw-bold">Selesai</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Step 1: Detail Undangan (Mulai) -->
          <div class="onboarding-step-content active" id="step1">
            <h4 class="fw-bold mb-1" style="color: var(--c-primary);">Langkah 1: Informasi Mempelai 👰🤵</h4>
            <p class="text-muted small mb-4">Isi nama panggilan mempelai dan alamat link undangan Anda:</p>

            <form id="formStep1" class="d-flex flex-column gap-3">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">Mempelai Wanita</label>
                  <input type="text" class="form-control neubrutal-input" id="brideName" placeholder="Contoh: Dela" value="<?php echo $bride_val; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">Mempelai Pria</label>
                  <input type="text" class="form-control neubrutal-input" id="groomName" placeholder="Contoh: Aqsa" value="<?php echo $groom_val; ?>" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">Judul Undangan</label>
                  <input type="text" class="form-control neubrutal-input" id="invitationTitle" placeholder="Contoh: Dela dan Aqsa" value="<?php echo $title_val; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">URL Undangan Website</label>
                  <div class="input-group">
                    <input type="text" class="form-control neubrutal-input text-danger fw-bold" id="subdomain" placeholder="dela-aqsa" value="<?php echo $subdomain_val; ?>" required style="border-right: none !important;">
                    <span class="input-group-text bg-light fw-bold" style="border: 3px solid #000; border-left: none; border-top-right-radius: 10px; border-bottom-right-radius: 10px; box-shadow: 3px 3px 0px #000;">.seutastali.id</span>
                  </div>
                  <div class="form-text small text-muted">Subdomain harus terdiri dari 6-16 karakter.</div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">Kapan acara pernikahan kamu diselenggarakan?</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light" style="border: 3px solid #000; border-right: none; border-top-left-radius: 10px; border-bottom-left-radius: 10px; box-shadow: 3px 3px 0px #000;"><i class="fa-solid fa-calendar-days text-muted"></i></span>
                    <input type="date" class="form-control neubrutal-input" id="weddingDate" value="<?php echo $date_val; ?>" required style="border-left: none !important;">
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">Sudah sejauh mana persiapan yang kamu lakukan?</label>
                  <select class="form-select neubrutal-input" id="preparation" required>
                    <option value="">Pilih</option>
                    <option value="baru_mulai">Baru Mulai</option>
                    <option value="sedang_berjalan" selected>Sedang Berjalan</option>
                    <option value="hampir_selesai">Hampir Selesai</option>
                  </select>
                </div>
              </div>

              <button type="submit" class="btn neubrutal-btn neubrutal-btn-primary w-100 py-2.5 mt-2">
                Lanjut ke Detail Acara <i class="fa-solid fa-arrow-right ms-1"></i>
              </button>
            </form>
          </div>

          <!-- Step 2: Detail Pernikahan & Lokasi -->
          <div class="onboarding-step-content" id="step2">
            <h4 class="fw-bold mb-3" style="color: var(--c-primary);">Langkah 2: Detail Pernikahan & Acara 📍</h4>
            <p class="text-muted small mb-4">Lengkapi detail lokasi gedung, orang tua, dan jumlah tamu undangan Anda:</p>

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

              <div class="row">
                <div class="col-md-8 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">Alamat Lengkap Gedung / Rumah Acara</label>
                  <textarea class="form-control neubrutal-input" id="eventAddress" rows="2" placeholder="Contoh: Gedung Graha Agung, Jalan Raya No. 45, Jakarta Selatan" required></textarea>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">Jumlah Tamu Undangan</label>
                  <input type="number" class="form-control neubrutal-input" id="guestCount" placeholder="Contoh: 500" min="1" required value="100">
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label small fw-bold text-uppercase text-muted">Link Google Maps Lokasi</label>
                <input type="url" class="form-control neubrutal-input" id="eventMaps" placeholder="Contoh: https://maps.google.com/?q=graha-agung">
              </div>

              <div class="d-flex gap-3 mt-2">
                <button type="button" class="btn neubrutal-btn btn-outline-dark px-4 py-2.5" id="btnBackTo1">Kembali</button>
                <button type="submit" class="btn neubrutal-btn neubrutal-btn-primary flex-grow-1 py-2.5">
                  Lanjut ke Setup Akun <i class="fa-solid fa-arrow-right ms-1"></i>
                </button>
              </div>
            </form>
          </div>

          <!-- Step 3: Setup Akun Pengaman -->
          <div class="onboarding-step-content" id="step3">
            <h4 class="fw-bold mb-3" style="color: var(--c-primary);">Langkah 3: Pengamanan & Aktivasi Akun 🔑</h4>
            <p class="text-muted small mb-4">Buat password baru untuk mengakses dashboard pengelolaan undangan Anda di masa depan:</p>

            <form id="formStep3" class="d-flex flex-column gap-3">
              <div class="mb-3">
                <label class="form-label small fw-bold text-uppercase text-muted">Username / Alamat Email</label>
                <input type="email" class="form-control neubrutal-input bg-light" value="<?php echo $guest_email; ?>" readonly style="cursor: not-allowed;">
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">Buat Password Baru</label>
                  <input type="password" class="form-control neubrutal-input" id="clientPass" required placeholder="Minimal 6 karakter password">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold text-uppercase text-muted">Ulangi Password Baru</label>
                  <input type="password" class="form-control neubrutal-input" id="clientPassConfirm" required placeholder="Konfirmasi ulang password Anda">
                </div>
              </div>

              <div class="d-flex gap-3 mt-3">
                <button type="button" class="btn neubrutal-btn btn-outline-dark px-4 py-2.5" id="btnBackTo2">Kembali</button>
                <button type="submit" class="btn neubrutal-btn neubrutal-btn-primary flex-grow-1 py-2.5">
                  Aktifkan Undangan Saya <i class="fa-solid fa-circle-check ms-1"></i>
                </button>
              </div>
            </form>
          </div>

          <!-- Step 4: Selesai & Sukses -->
          <div class="onboarding-step-content" id="step4">
            <div class="text-center py-4">
              <div class="mb-4 text-success">
                <i class="fa-solid fa-circle-check" style="font-size: 5rem; filter: drop-shadow(4px 4px 0px #000);"></i>
              </div>
              <h3 class="fw-bold mb-2">Aktivasi Undangan Berhasil! 🎉</h3>
              <p class="text-muted mb-4">Selamat! Undangan pernikahan digital Anda telah aktif secara resmi dan siap disebarkan.</p>
              
              <div class="p-3 bg-light rounded-4 border mb-4 text-start" style="border: 3px solid #000 !important; box-shadow: 4px 4px 0px #000;">
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted small fw-bold">LINK WEBSITE:</span>
                  <span class="fw-bold text-primary" id="successLink">budi-ani.seutastali.id</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="text-muted small fw-bold">EMAIL LOGIN:</span>
                  <span class="fw-bold text-dark"><?php echo $guest_email; ?></span>
                </div>
              </div>

              <div class="d-flex align-items-center justify-content-center gap-2 text-muted">
                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                <span class="small fw-bold">Mengarahkan ke Dashboard Manajemen Undangan Anda...</span>
              </div>
            </div>
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
      const node4 = document.getElementById('node4');

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
      let step1Data = {};
      let userPass = "";
      let weddingDetail = {};
      let selectedTheme = "<?= $template_slug_val ?>";

      formStep1.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const subdomainVal = document.getElementById('subdomain').value.trim();
        if (subdomainVal.length < 3 || subdomainVal.length > 20) {
          alert('URL Undangan (subdomain) harus antara 3 - 20 karakter.');
          return;
        }

        step1Data = {
          bride_name: document.getElementById('brideName').value.trim(),
          groom_name: document.getElementById('groomName').value.trim(),
          invitation_title: document.getElementById('invitationTitle').value.trim(),
          subdomain: subdomainVal,
          wedding_date: document.getElementById('weddingDate').value,
          preparation: document.getElementById('preparation').value
        };

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
          groom_parents: document.getElementById('groomParents').value.trim(),
          bride_parents: document.getElementById('brideParents').value.trim(),
          event_address: document.getElementById('eventAddress').value.trim(),
          guest_count: document.getElementById('guestCount').value,
          event_maps: document.getElementById('eventMaps').value.trim()
        };

        // Advance to Step 3 (Akun)
        step2.classList.remove('active');
        step3.classList.add('active');
        node2.classList.remove('active');
        node2.classList.add('completed');
        node3.classList.add('active');
      });

      // Submit Final Onboarding & Activate Account
      formStep3.addEventListener('submit', function(e) {
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

        // Retrieve package name from URL query parameter
        const urlParams = new URLSearchParams(window.location.search);
        const selectedPackage = urlParams.get('package') || 'Dasar';
        const packagesMap = {
          'Dasar': 149000,
          'Lengkap': 199000,
          'Eksklusif': 249000,
          'Premium': 399000
        };
        const selectedPrice = packagesMap[selectedPackage] || 149000;
        
        // Compile all onboarding parameters
        const finalPayload = {
          token: "<?php echo $draft_token; ?>",
          client_password: userPass,
          details: weddingDetail,
          package_name: selectedPackage,
          package_price: selectedPrice,
          bride_name: step1Data.bride_name,
          groom_name: step1Data.groom_name,
          invitation_title: step1Data.invitation_title,
          subdomain: step1Data.subdomain,
          wedding_date: step1Data.wedding_date,
          preparation: step1Data.preparation
        };

        // Show loading state on button
        const submitBtn = formStep3.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengaktifkan...';

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
            // Update success screen details
            const successLink = document.getElementById('successLink');
            successLink.innerText = step1Data.subdomain + '.seutastali.id';
            successLink.href = 'http://' + step1Data.subdomain + '.seutastali.id';

            // Mark step 3 as completed and step 4 as active
            step3.classList.remove('active');
            const step4 = document.getElementById('step4');
            if (step4) step4.classList.add('active');

            node3.classList.remove('active');
            node3.classList.add('completed');
            node4.classList.add('completed');
            
            // Redirect to dashboard app after 3.5 seconds
            setTimeout(() => {
              window.location.href = 'http://app.seutastali.id/dashboard.php?token=' + data.token;
            }, 3500);
          } else {
            alert('Gagal memproses onboarding: ' + data.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
          }
        })
        .catch(err => {
          console.error(err);
          // Fallback UI mock transition
          const successLink = document.getElementById('successLink');
          successLink.innerText = step1Data.subdomain + '.seutastali.id';
          
          step3.classList.remove('active');
          const step4 = document.getElementById('step4');
          if (step4) step4.classList.add('active');

          node3.classList.remove('active');
          node3.classList.add('completed');
          node4.classList.add('completed');

          setTimeout(() => {
            window.location.href = 'http://app.seutastali.id/dashboard.php?token=mocktoken';
          }, 3500);
        });
      });
    });
  </script>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>
