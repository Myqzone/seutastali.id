<?php
/**
 * Seutastali Consolidated Journey Tracker & Draft Editor (Seutasbox)
 * This widget combines the neubrutalist progress tracker and template customization forms
 * into a single unified UI module.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('ASSETS_URL')) {
    define('ASSETS_URL', (defined('STATIC_URL') ? STATIC_URL : '/') . 'assets/');
}

$server_package = isset($_GET['package']) ? htmlspecialchars($_GET['package']) : (isset($_SESSION['selected_package']) ? $_SESSION['selected_package'] : '');
$server_token = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : (isset($_SESSION['active_draft_token']) ? $_SESSION['active_draft_token'] : '');

$current_page = basename($_SERVER['PHP_SELF']);
$is_template_subfolder = strpos($_SERVER['REQUEST_URI'], '/design/') !== false && $current_page !== 'templates.php';

// Determine if editor mode is active on load via URL parameter
$initial_edit_mode = isset($_GET['edit']) || isset($_GET['preview']);

// Fallbacks for the integrated editor inputs
$groom_val = $groom_name ?? 'Bobby';
$bride_val = $bride_name ?? 'Gendis';

// Parse raw date to conform to required format "YYYY-MM-DD"
$date_val_raw = $wedding_date ?? date('Y-m-d', strtotime('+30 days'));
$date_val = date('Y-m-d', strtotime($date_val_raw));

$color_val = $theme_color ?? '#f4eae1';
$music_val = $bg_music ?? 'romantic-piano.mp3';

// Only allow on templates.php, pricing.php, and template preview pages (subfolder /design/)
$allowed_pages = ['templates.php', 'pricing.php'];
if (!in_array($current_page, $allowed_pages) && !$is_template_subfolder) {
    return;
}
?>

<!-- Link to external stylesheet and inject configuration variables into DocumentElement attributes -->
<link rel="stylesheet" href="<?= ASSETS_URL ?>css/pages/seutasbox.css?v=<?= filemtime(ROOT_PATH . 'assets/css/pages/seutasbox.css') ?>">
<script>
  document.documentElement.setAttribute('data-static-url', '<?= STATIC_URL ?>');
  document.documentElement.setAttribute('data-server-package', '<?= $server_package ?>');
  document.documentElement.setAttribute('data-server-token', '<?= $server_token ?>');
  document.documentElement.setAttribute('data-initial-edit-mode', '<?= $initial_edit_mode ? '1' : '0' ?>');
  document.documentElement.setAttribute('data-color-val', '<?= htmlspecialchars($color_val) ?>');
</script>

<!-- Small Watermark Indicator -->
<div class="editor-watermark d-none" id="dreamboardIndicator">Mode Editor Draf</div>

<!-- NEUBRUTALIST FLOATING JOURNEY TRACKER UI (SEUTASBOX) -->
<div class="floating-tracker-container collapsed" id="floatingJourneyTracker" style="display: none;">
  
  <!-- 1. Collapsed State: Tiny Neubrutalist Pill Trigger -->
  <button class="tracker-pill-trigger" id="trackerPillTrigger">
    <span class="pulse-dot"></span>
    <span class="pill-text">Langkah Pembuatan Undangan</span>
    <span class="pill-icon-wrapper">
      <i class="fa-solid fa-chevron-up arrow-icon"></i>
    </span>
  </button>

  <!-- 2. Expanded State: Sleek Neubrutalist Progress Card with Slide Transition -->
  <div class="tracker-expanded-card">
    <div class="tracker-slides-container" id="trackerSlidesContainer">
      
      <!-- SLIDE 1: PROGRESS CHECKS -->
      <div class="tracker-slide" id="slide-progress">
        <div class="tracker-header">
          <div class="d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-uppercase tracking-wider">🎯 Progres Anda</h6>
            <button class="btn-minimize-tracker" id="btnMinimizeTracker" title="Sembunyikan Panel">
              <i class="fa-solid fa-chevron-down"></i>
            </button>
          </div>
        </div>
        
        <div class="tracker-body">
          <ul class="tracker-steps-list">
            <!-- Step 1: Pilih Paket -->
            <li class="tracker-step-item" id="step-paket">
              <div class="step-checkbox">
                <i class="fa-regular fa-circle uncheck-icon"></i>
                <i class="fa-solid fa-circle-check check-icon text-success"></i>
              </div>
              <div class="step-details">
                <span class="step-title">Pilih Paket</span>
                <span class="step-desc" id="step-paket-desc">Pilih paket harga premium</span>
              </div>
            </li>

            <!-- Step 2: Pilih Desain -->
            <li class="tracker-step-item" id="step-desain">
              <div class="step-checkbox">
                <i class="fa-regular fa-circle uncheck-icon"></i>
                <i class="fa-solid fa-circle-check check-icon text-success"></i>
              </div>
              <div class="step-details">
                <span class="step-title">Pilih Desain</span>
                <span class="step-desc" id="step-desain-desc">Pilih template katalog</span>
              </div>
            </li>

            <!-- Step 3: Desain & Simpan -->
            <li class="tracker-step-item" id="step-draf">
              <div class="step-checkbox">
                <i class="fa-regular fa-circle uncheck-icon"></i>
                <i class="fa-solid fa-circle-check check-icon text-success"></i>
              </div>
              <div class="step-details">
                <span class="step-title">Simpan Draf</span>
                <span class="step-desc" id="step-draf-desc">Simpan data mempelai</span>
              </div>
            </li>
          </ul>

          <div class="tracker-suggestion-box mt-3" id="trackerSuggestion">
            <i class="fa-solid fa-circle-info text-primary me-2"></i>
            <span class="suggestion-text" id="trackerSuggestionText">Memuat langkah selanjutnya...</span>
          </div>

          <!-- Neubrutalist Edit Button inside Tracker (Only shown on template page) -->
          <div class="mt-3 d-none" id="trackerEditButtonWrapper">
            <button class="btn btn-seutasbox-secondary w-100 py-2" id="btnOpenDreamboardFromTracker">
              ✨ Coba Edit Template
            </button>
          </div>
        </div>
      </div>

      <!-- SLIDE 2: DREAMBOARD EDITOR (WITH BOOTSTRAP TABS & INTEGRATED SUBMIT) -->
      <div class="tracker-slide" id="slide-editor">
        <div class="tracker-header">
          <div class="d-flex justify-content-between align-items-center">
            <button class="btn-back-to-steps" id="btnBackToSteps" title="Kembali ke Progres">
              <i class="fa-solid fa-arrow-left"></i>
            </button>
            <h6 class="fw-bold mb-0 text-uppercase tracking-wider">✍️ Edit Undangan</h6>
            <button class="btn-minimize-tracker" id="btnMinimizeTrackerEditor" title="Sembunyikan Panel">
              <i class="fa-solid fa-chevron-down"></i>
            </button>
          </div>
        </div>
        
        <div class="tracker-body">
          <!-- Bootstrap Nav Tabs -->
          <ul class="nav nav-tabs seutasbox-nav-tabs" id="editorTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="tab-mempelai-tab" data-bs-toggle="tab" data-bs-target="#tab-mempelai" type="button" role="tab" aria-controls="tab-mempelai" aria-selected="true">Mempelai</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-tampilan-tab" data-bs-toggle="tab" data-bs-target="#tab-tampilan" type="button" role="tab" aria-controls="tab-tampilan" aria-selected="false">Tampilan</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-media-tab" data-bs-toggle="tab" data-bs-target="#tab-media" type="button" role="tab" aria-controls="tab-media" aria-selected="false">Media</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab-save-tab" data-bs-toggle="tab" data-bs-target="#tab-save" type="button" role="tab" aria-controls="tab-save" aria-selected="false">Simpan</button>
            </li>
          </ul>

          <div class="tab-content" id="editorTabsContent">
            <!-- TAB 1: MEMPELAI -->
            <div class="tab-pane fade show active" id="tab-mempelai" role="tabpanel" aria-labelledby="tab-mempelai-tab">
              <div class="d-flex flex-column gap-3">
                <!-- Groom Name -->
                <div>
                  <label class="seutasbox-label">Mempelai Pria</label>
                  <input type="text" class="form-control seutasbox-input" id="dbInputGroom" value="<?= htmlspecialchars($groom_val) ?>" placeholder="Nama Pria">
                </div>

                <!-- Bride Name -->
                <div>
                  <label class="seutasbox-label">Mempelai Wanita</label>
                  <input type="text" class="form-control seutasbox-input" id="dbInputBride" value="<?= htmlspecialchars($bride_val) ?>" placeholder="Nama Wanita">
                </div>

                <!-- Wedding Date -->
                <div>
                  <label class="seutasbox-label">Tanggal Acara</label>
                  <input type="date" class="form-control seutasbox-input" id="dbInputDate" value="<?= htmlspecialchars($date_val) ?>">
                </div>
              </div>
            </div>

            <!-- TAB 2: TAMPILAN -->
            <div class="tab-pane fade" id="tab-tampilan" role="tabpanel" aria-labelledby="tab-tampilan-tab">
              <div class="d-flex flex-column gap-3">
                <!-- Color Palette selector -->
                <div>
                  <label class="seutasbox-label">Pilih Warna Latar</label>
                  <div class="d-flex flex-wrap gap-2 mt-1">
                    <span class="db-color-dot active" style="background-color: #f4eae1;" data-color="#f4eae1" title="Cream Canvas"></span>
                    <span class="db-color-dot" style="background-color: #8c1e2b;" data-color="#8c1e2b" title="Classic Red"></span>
                    <span class="db-color-dot" style="background-color: #2c5e43;" data-color="#2c5e43" title="Emerald Green"></span>
                    <span class="db-color-dot" style="background-color: #d1b894;" data-color="#d1b894" title="Minimalist Beige"></span>
                    <span class="db-color-dot" style="background-color: #e0dcd3;" data-color="#e0dcd3" title="Modern Grey"></span>
                  </div>
                </div>

                <!-- Font Selector -->
                <div>
                  <label class="seutasbox-label">Gaya Tulisan (Font)</label>
                  <select class="form-select seutasbox-input" id="dbInputFont">
                    <option value="classic">Classic Elegant (Default)</option>
                    <option value="romantic">Romantic Script (Calligraphy)</option>
                    <option value="modern">Modern Clean (Sleek)</option>
                    <option value="playful">Playful Serif (Friendly)</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- TAB 3: MEDIA -->
            <div class="tab-pane fade" id="tab-media" role="tabpanel" aria-labelledby="tab-media-tab">
              <div class="d-flex flex-column gap-3">
                <!-- Background Music -->
                <div>
                  <label class="seutasbox-label">Musik Pengiring</label>
                  <select class="form-select seutasbox-input" id="dbInputMusic">
                    <option value="romantic-piano.mp3" <?= $music_val === 'romantic-piano.mp3' ? 'selected' : '' ?>>Beautiful In White (Piano)</option>
                    <option value="wedding-orchestra.mp3" <?= $music_val === 'wedding-orchestra.mp3' ? 'selected' : '' ?>>A Thousand Years (Orchestra)</option>
                    <option value="nature-ambient.mp3" <?= $music_val === 'nature-ambient.mp3' ? 'selected' : '' ?>>Nature Acoustic Guitar</option>
                  </select>
                </div>

                <!-- Photo Selector -->
                <div>
                  <label class="seutasbox-label">Ganti Foto Galeri</label>
                  <input type="file" class="form-control seutasbox-input" id="dbInputPhoto" accept="image/*" style="padding: 6px 12px !important;">
                </div>
              </div>
            </div>

            <!-- TAB 4: SIMPAN -->
            <div class="tab-pane fade" id="tab-save" role="tabpanel" aria-labelledby="tab-save-tab">
              <div class="d-flex flex-column gap-3">
                <!-- Direct Onboarding Inputs -->
                <div>
                  <label class="seutasbox-label">Nama Lengkap Anda</label>
                  <input type="text" class="form-control seutasbox-input" id="dbClientName" placeholder="Contoh: Budi Santoso">
                </div>

                <div>
                  <label class="seutasbox-label">Alamat Email Anda</label>
                  <input type="email" class="form-control seutasbox-input" id="dbClientEmail" placeholder="Contoh: budi@gmail.com">
                  <div class="small mt-1 text-muted" style="font-size: 0.68rem; line-height: 1.3;">Password masuk dashboard akan otomatis dikirimkan ke email ini.</div>
                </div>

                <!-- Save Button inside editor slide -->
                <div class="mt-2">
                  <button class="btn btn-seutasbox-primary w-100 py-2" id="dbBtnSubmitDraft">
                    💾 Simpan Draf Undangan
                  </button>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      
    </div>
  </div>
</div>

<!-- Defer load our external script module -->
<script src="<?= ASSETS_URL ?>js/pages/seutasbox.js?v=<?= filemtime(ROOT_PATH . 'assets/js/pages/seutasbox.js') ?>" defer></script>
