<?php

/**
 * Seutastali Reusable Premium Editor Partial (includes/sections/btn-editor.php)
 * Inspired by Katsudoto's "Dreamboard" UI/UX
 * Modular, Self-Contained, and High-Performance
 */

// Determine if editor mode is active on load via URL parameter
$initial_edit_mode = isset($_GET['edit']) || isset($_GET['preview']);

// Default dynamic fallback variables if not defined in invitation scope
$groom_val = $groom_name ?? 'Bobby';
$bride_val = $bride_name ?? 'Gendis';
$date_val = $wedding_date ?? date('Y-m-d', strtotime('+30 days'));
$color_val = $theme_color ?? '#f4eae1';
$music_val = $bg_music ?? 'romantic-piano.mp3';
?>

<!-- ==========================================================================
     KATSUDOTO-INSPIRED PREMIUM NEUBRUTALIST FLOATING CONTROLS
     ========================================================================== -->

<!-- 1. Bottom-Center Floating Trigger Button -->
<div class="floating-editor-trigger-wrapper <?= $initial_edit_mode ? 'd-none' : '' ?>" id="floatingEditorTrigger">
  <button class="floating-editor-pill-btn">
    Coba Edit Desain
  </button>
</div>

<!-- 2. Integrated Sleek Bottom Drawer (Dreamboard Style) -->
<div class="dreamboard-drawer <?= $initial_edit_mode ? '' : 'collapsed' ?>" id="dreamboardDrawer">

  <!-- Drawer Header -->
  <div class="dreamboard-header">
    <div class="d-flex justify-content-between align-items-center w-100">
      <h5 class="fw-bold mb-0 d-flex align-items-center">
        Dreamboard
      </h5>
      <button class="btn-close-dreamboard" id="btnCloseDreamboard" title="Tutup Panel" style="font-size: 1.6rem; font-weight: 300; line-height: 1;">
        &times;
      </button>
    </div>
  </div>

  <!-- Drawer Body containing dynamic Tab Contents -->
  <div class="dreamboard-body">

    <!-- ==========================================
         TAB 1: KONTEN (TEXT INPUTS)
         ========================================== -->
    <div class="dreamboard-tab-content active" id="tabContent-konten">
      <h6 class="fw-bold mb-1">Ubah Data Undangan</h6>
      <p class="text-muted small mb-4">Edit nama panggilan mempelai dan tanggal pernikahan Anda.</p>

      <div class="d-flex flex-column gap-3">
        <!-- Groom Name -->
        <div>
          <label class="form-label small fw-bold text-uppercase text-muted">Mempelai Pria</label>
          <input type="text" class="form-control dreamboard-input" id="dbInputGroom" value="<?= htmlspecialchars($groom_val) ?>" placeholder="Nama panggilan mempelai pria">
        </div>

        <!-- Bride Name -->
        <div>
          <label class="form-label small fw-bold text-uppercase text-muted">Mempelai Wanita</label>
          <input type="text" class="form-control dreamboard-input" id="dbInputBride" value="<?= htmlspecialchars($bride_val) ?>" placeholder="Nama panggilan mempelai wanita">
        </div>

        <!-- Wedding Date -->
        <div>
          <label class="form-label small fw-bold text-uppercase text-muted">Tanggal Acara</label>
          <input type="date" class="form-control dreamboard-input" id="dbInputDate" value="<?= htmlspecialchars($date_val) ?>">
        </div>
      </div>
    </div>

    <!-- ==========================================
         TAB 2: WARNA (THEME PALETTE)
         ========================================== -->
    <div class="dreamboard-tab-content" id="tabContent-warna">
      <h6 class="fw-bold mb-1">Demo Pilihan Warna</h6>
      <p class="text-muted small mb-4">Ganti palet warna latar belakang tema undangan Anda secara instan.</p>

      <div class="d-flex flex-column gap-3">
        <div>
          <label class="form-label small fw-bold text-uppercase text-muted d-block mb-3">Pilih Warna Latar Belakang</label>
          <div class="d-flex flex-wrap gap-3">
            <span class="db-color-dot active" style="background-color: #f4eae1;" data-color="#f4eae1" title="Cream Canvas"></span>
            <span class="db-color-dot" style="background-color: #8c1e2b;" data-color="#8c1e2b" title="Classic Red"></span>
            <span class="db-color-dot" style="background-color: #2c5e43;" data-color="#2c5e43" title="Emerald Green"></span>
            <span class="db-color-dot" style="background-color: #d1b894;" data-color="#d1b894" title="Minimalist Beige"></span>
            <span class="db-color-dot" style="background-color: #e0dcd3;" data-color="#e0dcd3" title="Modern Grey"></span>
          </div>
        </div>
      </div>
    </div>

    <!-- ==========================================
         TAB 3: MUSIK (BACKGROUND MUSIC)
         ========================================== -->
    <div class="dreamboard-tab-content" id="tabContent-musik">
      <h6 class="fw-bold mb-1">Musik Latar Belakang</h6>
      <p class="text-muted small mb-4">Uji coba instan musik romantis pengiring undangan Anda.</p>

      <div class="d-flex flex-column gap-3">
        <div>
          <label class="form-label small fw-bold text-uppercase text-muted">Daftar Putar Musik</label>
          <select class="form-select dreamboard-input" id="dbInputMusic">
            <option value="romantic-piano.mp3" <?= $music_val === 'romantic-piano.mp3' ? 'selected' : '' ?>>Beautiful In White (Piano)</option>
            <option value="wedding-orchestra.mp3" <?= $music_val === 'wedding-orchestra.mp3' ? 'selected' : '' ?>>A Thousand Years (Orchestra)</option>
            <option value="nature-ambient.mp3" <?= $music_val === 'nature-ambient.mp3' ? 'selected' : '' ?>>Nature Acoustic Guitar</option>
          </select>
        </div>
      </div>
    </div>

  </div>

  <!-- Drawer Footer (Categorized Premium Navigation Tabs Bar) -->
  <div class="dreamboard-footer">
    <div class="dreamboard-nav-tabs">
      <button class="dreamboard-nav-item active" data-target="konten" title="Edit Konten">
        <span>Konten</span>
      </button>
      <button class="dreamboard-nav-item" data-target="warna" title="Edit Warna">
        <span>Warna</span>
      </button>
      <button class="dreamboard-nav-item" data-target="musik" title="Edit Musik">
        <span>Musik</span>
      </button>
      <button class="dreamboard-nav-item save-btn" id="dbBtnSave" title="Simpan Undangan">
        <span>Simpan</span>
      </button>
    </div>
  </div>

</div>

<!-- Premium Sleek Save Modal (Register Pop-up) -->
<div class="modal fade" id="saveDraftModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content save-draft-modal-content">
      <div class="modal-header save-draft-modal-header">
        <h5 class="modal-title" id="saveDraftModalLabel">Simpan Undangan Cantikmu!</h5>
        <button type="button" class="btn-close btn-close-maroon" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body save-draft-modal-body">
        <p class="save-draft-subtitle">Undangan rancangan Kakak sudah tersusun indah. Simpan sekarang secara gratis menggunakan alamat email Anda agar draf tidak hilang.</p>

        <form id="onboardingSubmitForm">
          <!-- Input Nama Lengkap -->
          <div class="mb-4">
            <label class="save-draft-label">Nama Lengkap Anda</label>
            <input type="text" class="form-control save-draft-input" id="clientName" required placeholder="Contoh: Budi Santoso">
          </div>

          <!-- Input Alamat Email -->
          <div class="mb-4">
            <label class="save-draft-label">Alamat Email Anda</label>
            <input type="email" class="form-control save-draft-input" id="clientEmail" required placeholder="Contoh: budi@gmail.com">
            <div class="save-draft-form-text">Password masuk dashboard akan otomatis dikirimkan ke email ini.</div>
          </div>

          <!-- Tombol Submit -->
          <button type="submit" class="btn save-draft-submit-btn">
            Lanjut ke Langkah Terakhir
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Small Watermark Indicator -->
<div class="editor-watermark d-none" id="dreamboardIndicator">Mode Editor Draf</div>


<!-- ==========================================================================
     STYLES FOR KATSUDOTO-INSPIRED DREAMBOARD DRAWER & FLOATING WIDGET
     ========================================================================== -->
<style>
  /* Ensure save modal is always at the absolute top, above any cover page */
  #saveDraftModal {
    z-index: 9999999 !important;
  }

  body.modal-open .modal-backdrop {
    z-index: 9999998 !important;
  }

  /* Sleek Save Draft Modal Styles */
  .save-draft-modal-content {
    background: var(--c-sand, #FDF9F0) !important;
    border: 1px solid var(--c-border, #e2d8c3) !important;
    box-shadow: 0 15px 50px rgba(80, 7, 1, 0.15) !important;
    border-radius: 24px !important;
    font-family: "Manrope", sans-serif !important;
    overflow: hidden;
  }

  .save-draft-modal-header {
    border-bottom: none !important;
    padding: 24px 24px 0 24px !important;
  }

  .save-draft-modal-header .modal-title {
    color: var(--c-primary, #500701) !important;
    font-weight: 800 !important;
    font-size: 1.35rem !important;
  }

  .btn-close-maroon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23500701'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") !important;
    opacity: 0.7 !important;
    transition: opacity 0.2s ease !important;
  }

  .btn-close-maroon:hover {
    opacity: 1 !important;
  }

  .save-draft-modal-body {
    padding: 20px 24px 28px 24px !important;
  }

  .save-draft-subtitle {
    color: var(--c-text-dark, #1a1a1a) !important;
    opacity: 0.7 !important;
    font-size: 0.85rem !important;
    line-height: 1.6 !important;
    margin-bottom: 24px !important;
  }

  .save-draft-label {
    color: var(--c-primary, #500701) !important;
    font-weight: 700 !important;
    font-size: 0.75rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    margin-bottom: 6px !important;
    display: block !important;
  }

  .save-draft-input {
    background: #ffffff !important;
    color: var(--c-text-dark, #1a1a1a) !important;
    border: 1px solid var(--c-border, #e2d8c3) !important;
    border-radius: 10px !important;
    padding: 10px 14px !important;
    font-weight: 600 !important;
    font-size: 0.9rem !important;
    box-shadow: none !important;
    transition: all 0.3s ease !important;
  }

  .save-draft-input:focus {
    border-color: var(--c-primary, #500701) !important;
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(80, 7, 1, 0.08) !important;
  }

  .save-draft-form-text {
    color: var(--c-text-dark, #1a1a1a) !important;
    opacity: 0.6 !important;
    font-size: 0.75rem !important;
    margin-top: 6px !important;
  }

  .save-draft-submit-btn {
    background: var(--c-primary, #500701) !important;
    color: var(--c-sand, #FDF9F0) !important;
    border: none !important;
    padding: 12px 24px !important;
    font-weight: 700 !important;
    font-size: 0.95rem !important;
    border-radius: 30px !important;
    box-shadow: 0 4px 15px rgba(80, 7, 1, 0.15) !important;
    width: 100% !important;
    transition: all 0.3s ease !important;
  }

  .save-draft-submit-btn:hover {
    background: var(--c-primary-light, #a02020) !important;
    box-shadow: 0 6px 20px rgba(80, 7, 1, 0.25) !important;
    transform: translateY(-2px) !important;
  }

  .save-draft-submit-btn:active {
    transform: translateY(1px) !important;
  }

  /* Base editor encapsulation */
  .floating-editor-trigger-wrapper,
  .dreamboard-drawer,
  .editor-watermark {
    font-family: "Manrope", sans-serif !important;
  }

  /* Floating Pill Trigger wrapper */
  .floating-editor-trigger-wrapper {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;
    pointer-events: auto;
  }

  .floating-editor-pill-btn {
    background: var(--c-primary, #500701);
    /* Elegant Brand Maroon */
    color: var(--c-sand, #FDF9F0);
    /* Elegant Brand Sand */
    border: none;
    box-shadow: 0 4px 15px rgba(80, 7, 1, 0.15);
    border-radius: 30px;
    font-weight: 800;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 12px 28px;
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    cursor: pointer;
    white-space: nowrap;
    outline: none;
  }

  .floating-editor-pill-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(80, 7, 1, 0.25);
    background: var(--c-primary-light, #a02020);
    /* Lighter Maroon */
    color: var(--c-sand, #FDF9F0);
  }

  .floating-editor-pill-btn:active {
    transform: translateY(1px);
    box-shadow: 0 2px 10px rgba(80, 7, 1, 0.15);
  }

  /* Dreamboard Elegant Sand Bottom Drawer */
  .dreamboard-drawer {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 440px;
    max-width: 95%;
    max-height: 85vh;
    /* Keep strictly within shrunken viewports when keyboard is active */
    background: var(--c-sand, #FDF9F0);
    /* Premium Brand Sand Background */
    border: 1px solid var(--c-border, #e2d8c3);
    box-shadow: 0 15px 40px rgba(80, 7, 1, 0.08);
    /* Sophisticated Soft Drop Shadow */
    border-radius: 24px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.15), opacity 0.3s ease;
    opacity: 1;
  }

  .dreamboard-drawer.collapsed {
    transform: translate(-50%, calc(100% + 40px));
    opacity: 0;
    pointer-events: none;
  }

  /* Drawer Header */
  .dreamboard-header {
    background: var(--c-sand-dark, #f3efe3);
    padding: 15px 20px;
    border-bottom: 1px solid var(--c-border, #e2d8c3);
    flex-shrink: 0;
    /* Keep header size constant */
  }

  .dreamboard-header h5 {
    color: var(--c-primary, #500701) !important;
  }

  .btn-close-dreamboard {
    background: none;
    border: none;
    color: var(--c-primary, #500701);
    opacity: 0.6;
    font-size: 1.2rem;
    cursor: pointer;
    transition: opacity 0.2s ease;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .btn-close-dreamboard:hover {
    opacity: 1;
    color: var(--c-primary, #500701);
  }

  /* Drawer Body containing tab contents */
  .dreamboard-body {
    padding: 20px;
    max-height: 280px;
    overflow-y: auto !important;
    -webkit-overflow-scrolling: touch !important;
    /* Smooth momentum scroll on iOS */
    background: var(--c-sand, #FDF9F0);
    flex-grow: 1;
  }

  /* Contrast Labels & Subtitles */
  .dreamboard-drawer h6 {
    color: var(--c-primary, #500701) !important;
    font-weight: 700 !important;
  }

  .dreamboard-drawer label {
    color: var(--c-primary, #500701) !important;
    font-weight: 700 !important;
    font-size: 0.75rem !important;
    letter-spacing: 0.5px !important;
    margin-bottom: 6px !important;
  }

  .dreamboard-drawer .text-muted,
  .dreamboard-drawer .form-text {
    color: var(--c-text-dark, #1a1a1a) !important;
    opacity: 0.7 !important;
    font-size: 0.8rem !important;
  }

  .dreamboard-tab-content {
    display: none;
  }

  .dreamboard-tab-content.active {
    display: block;
    animation: fadeInTab 0.25s ease-out;
  }

  @keyframes fadeInTab {
    from {
      opacity: 0;
      transform: translateY(8px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Bottom Menu Navbar */
  .dreamboard-footer {
    background: var(--c-sand-dark, #f3efe3);
    border-top: 1px solid var(--c-border, #e2d8c3);
    padding: 10px 15px;
  }

  .dreamboard-nav-tabs {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
  }

  .dreamboard-nav-item {
    background: none;
    border: none;
    color: var(--c-primary, #500701) !important;
    opacity: 0.5;
    padding: 8px 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    cursor: pointer;
    border-radius: 12px;
    transition: all 0.2s ease;
  }

  .dreamboard-nav-item i {
    font-size: 1.2rem;
  }

  .dreamboard-nav-item span {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .dreamboard-nav-item:hover {
    color: var(--c-primary, #500701) !important;
    opacity: 1;
    background: rgba(80, 7, 1, 0.04) !important;
  }

  .dreamboard-nav-item.active {
    color: var(--c-primary, #500701) !important;
    opacity: 1 !important;
    background: #ffffff !important;
    border: 1px solid var(--c-border, #e2d8c3) !important;
    box-shadow: 0 2px 8px rgba(80, 7, 1, 0.05) !important;
  }

  /* Golden/Maroon Highlight for Save Button */
  .dreamboard-nav-item.save-btn {
    color: var(--c-primary, #500701) !important;
    opacity: 0.7;
  }

  .dreamboard-nav-item.save-btn i,
  .dreamboard-nav-item.save-btn span {
    color: var(--c-primary, #500701) !important;
  }

  .dreamboard-nav-item.save-btn:hover {
    opacity: 1;
    background: rgba(80, 7, 1, 0.04) !important;
  }

  .dreamboard-nav-item.save-btn.active {
    background: var(--c-primary, #500701) !important;
    color: var(--c-sand, #FDF9F0) !important;
    opacity: 1 !important;
    border: 1px solid var(--c-primary, #500701) !important;
    box-shadow: 0 2px 8px rgba(80, 7, 1, 0.1) !important;
  }

  .dreamboard-nav-item.save-btn.active i,
  .dreamboard-nav-item.save-btn.active span {
    color: var(--c-sand, #FDF9F0) !important;
  }

  /* Sleek Minimalist Inputs */
  .dreamboard-input {
    background: #ffffff !important;
    color: var(--c-text-dark, #1a1a1a) !important;
    border: 1px solid var(--c-border, #e2d8c3) !important;
    border-radius: 10px !important;
    padding: 8px 12px !important;
    font-weight: 600 !important;
    box-shadow: none !important;
    transition: all 0.2s ease !important;
  }

  .dreamboard-input:focus {
    border-color: var(--c-primary, #500701) !important;
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(80, 7, 1, 0.08) !important;
  }

  .db-color-dot {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid #000000;
    cursor: pointer;
    display: inline-block;
    transition: transform 0.2s ease;
    box-shadow: 2px 2px 0px #000000;
  }

  .db-color-dot.active,
  .db-color-dot:hover {
    transform: scale(1.15);
    border-color: #ffffff;
  }

  /* Micro-animation sparkle */
  .animate-sparkle {
    animation: sparkle 1.5s infinite alternate;
  }

  @keyframes sparkle {
    from {
      filter: drop-shadow(0 0 1px var(--c-primary, #500701));
    }

    to {
      filter: drop-shadow(0 0 4px var(--c-primary, #500701));
    }
  }

  /* Sleek Watermark style badge */
  .editor-watermark {
    position: fixed;
    top: 15px;
    right: 15px;
    background: var(--c-primary, #500701);
    color: var(--c-sand, #FDF9F0);
    border: none;
    box-shadow: 0 4px 15px rgba(80, 7, 1, 0.12);
    font-weight: 800;
    font-size: 10px;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 20px;
    z-index: 999999 !important; /* Set above the fullscreen cover page */
    pointer-events: none;
  }

  @media (max-width: 576px) {
    .dreamboard-drawer {
      bottom: 10px;
      width: calc(100% - 20px);
    }
  }

  /* Shrunken height responsive layouts (e.g. mobile landscape or virtual keyboard overlay active) */
  @media (max-height: 580px) {
    .dreamboard-drawer {
      bottom: 5px;
      border-radius: 16px;
    }

    .dreamboard-body {
      max-height: 180px !important;
      /* Force shrink body so scrollbar triggers */
    }
  }

  @media (max-height: 480px) {
    .dreamboard-drawer {
      bottom: 0;
      border-radius: 12px 12px 0 0;
      width: 100%;
      max-width: 100%;
    }

    .dreamboard-body {
      max-height: 130px !important;
    }
  }
</style>



<!-- ==========================================================================
     VANILLA JAVASCRIPT SYSTEM BINDINGS & SPA CONTROLLER
     ========================================================================== -->
<script>
  document.addEventListener('DOMContentLoaded', function() {

    // Core Elements
    const triggerWrapper = document.getElementById('floatingEditorTrigger');
    const drawer = document.getElementById('dreamboardDrawer');
    const btnClose = document.getElementById('btnCloseDreamboard');
    const watermark = document.getElementById('dreamboardIndicator');

    // DOM Display nodes (targets inside templates)
    const groomDisplay = document.getElementById('groom-display');
    const brideDisplay = document.getElementById('bride-display');
    const dateDisplay = document.getElementById('date-display');

    // Inputs inside Drawer
    const inputGroom = document.getElementById('dbInputGroom');
    const inputBride = document.getElementById('dbInputBride');
    const inputDate = document.getElementById('dbInputDate');
    const inputMusic = document.getElementById('dbInputMusic');
    const colorDots = document.querySelectorAll('.db-color-dot');

    let activeColor = '<?= htmlspecialchars($color_val) ?>';

    // ----------------------------------------------------
    // 1. LIVE SYNCHRONIZATION BINDINGS (DIRECT DOM UPDATES)
    // ----------------------------------------------------

    inputGroom.addEventListener('input', function() {
      const val = this.value || 'Pria';
      if (groomDisplay) groomDisplay.innerText = val;
      const g2 = document.getElementById('groom-display-2');
      if (g2) g2.innerText = val;
      const dg = document.getElementById('desktop-groom-display');
      if (dg) dg.innerText = val;
    });

    inputBride.addEventListener('input', function() {
      const val = this.value || 'Wanita';
      if (brideDisplay) brideDisplay.innerText = val;
      const b2 = document.getElementById('bride-display-2');
      if (b2) b2.innerText = val;
      const db = document.getElementById('desktop-bride-display');
      if (db) db.innerText = val;
    });

    inputDate.addEventListener('change', function() {
      if (!this.value) return;
      const weddingDate = new Date(this.value);
      if (!isNaN(weddingDate.getTime())) {
        const options = {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        };
        const formatter = new Intl.DateTimeFormat('id-ID', options);
        if (dateDisplay) {
          dateDisplay.innerText = formatter.format(weddingDate);
        }
        // If countdown timer function exists in scope, trigger it
        if (typeof initCountdown === 'function') {
          initCountdown(this.value);
        }
      }
    });

    // Color picker binding
    colorDots.forEach(dot => {
      dot.addEventListener('click', function() {
        colorDots.forEach(d => d.classList.remove('active'));
        this.classList.add('active');
        activeColor = this.getAttribute('data-color');
        document.documentElement.style.setProperty('--theme-bg', activeColor);
      });
    });

    // ----------------------------------------------------
    // 2. KATSUDOTO TABS NAVIGATION SYSTEM
    // ----------------------------------------------------
    const navItems = document.querySelectorAll('.dreamboard-nav-item:not(.save-btn)');
    const tabContents = document.querySelectorAll('.dreamboard-tab-content');

    navItems.forEach(item => {
      item.addEventListener('click', function() {
        const targetTab = this.getAttribute('data-target');

        // Remove active class from all items and contents
        navItems.forEach(n => n.classList.remove('active'));
        tabContents.forEach(c => c.classList.remove('active'));

        // Set active on clicked
        this.classList.add('active');
        document.getElementById('tabContent-' + targetTab).classList.add('active');
      });
    });

    // ----------------------------------------------------
    // 3. SPA OPEN / CLOSE & HISTORY API ROUTING
    // ----------------------------------------------------

    function openDreamboard() {
      drawer.classList.remove('collapsed');
      triggerWrapper.classList.add('d-none');
      watermark.classList.remove('d-none');

      // Gracefully push state to URL to support sharing/saving
      const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?edit=1';
      window.history.pushState({
        path: newUrl
      }, '', newUrl);
    }

    function closeDreamboard() {
      drawer.classList.add('collapsed');
      triggerWrapper.classList.remove('d-none');
      watermark.classList.add('d-none');

      // Remove edit query from URL
      const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
      window.history.pushState({
        path: cleanUrl
      }, '', cleanUrl);
    }

    // Bindings
    triggerWrapper.querySelector('button').addEventListener('click', openDreamboard);
    btnClose.addEventListener('click', closeDreamboard);

    // If edit mode active initially on load, show indicator
    if (<?= $initial_edit_mode ? 'true' : 'false' ?>) {
      watermark.classList.remove('d-none');
    }

    // ----------------------------------------------------
    // 4. SUBMIT DRAFT REGISTRATION MODAL
    // ----------------------------------------------------
    const saveModal = new bootstrap.Modal(document.getElementById('saveDraftModal'));
    const btnSaveTab = document.getElementById('dbBtnSave');

    btnSaveTab.addEventListener('click', function() {
      saveModal.show();
    });

    const submitForm = document.getElementById('onboardingSubmitForm');
    submitForm.addEventListener('submit', function(e) {
      e.preventDefault();

      const name = document.getElementById('clientName').value;
      const email = document.getElementById('clientEmail').value;

      const draftPayload = {
        groom: inputGroom.value,
        bride: inputBride.value,
        date: inputDate.value,
        color: activeColor,
        music: inputMusic.value,
        template: 'syakira'
      };

      // Save draft using Fetch API posting to our central endpoint
      fetch('../../api/save_draft.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            client_name: name,
            client_email: email,
            draft_payload: draftPayload
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            // Redirect to onboarding checkout with active token
            window.location.href = '../../onboarding.php?token=' + data.token;
          } else {
            alert('Gagal menyimpan draf: ' + data.message);
          }
        })
        .catch(err => {
          console.error('Error saving draft:', err);
          // Redirection fallback
          window.location.href = `../../onboarding.php?guest_name=${encodeURIComponent(name)}&guest_email=${encodeURIComponent(email)}`;
        });
    });

  });
</script>