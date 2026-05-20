<?php
// Fallback definitions to prevent static analysis warnings in standalone modular include files
$groom_name = $groom_name ?? 'Miqdad';
$bride_name = $bride_name ?? 'Shafa';
$formatted_date = $formatted_date ?? 'Selasa, 16 Juni 2026';
?>
<!-- ============================================================
     COVER SCENE - Parallax Zoom-In-To-Out Layered Composition
     ============================================================ -->
<div class="cover-scene" id="coverScene">

  <!-- LAYER 0: Background landscape (forest + mountains) -->
  <div class="layer-bg">
    <img src="assets/ornament/846822_44710-O4E2ZR_1.png" alt="Background">
  </div>

  <!-- LAYER 1: Watercolor blue sky -->
  <div class="layer-sky">
    <img src="assets/ornament/5177354_3.png" alt="Sky">
  </div>

  <!-- LAYER 2: Mist/fog rows -->
  <div class="layer-mist mist-top">
    <img src="assets/ornament/5488_1.png" alt="Mist">
  </div>
  <div class="layer-mist mist-mid">
    <img src="assets/ornament/5488_2.png" alt="Mist">
  </div>
  <div class="layer-mist mist-bottom">
    <img src="assets/ornament/5488_3.png" alt="Mist">
  </div>

  <!-- LAYER 3: Stone Arch Frame -->
  <div class="layer-arch">
    <img src="assets/ornament/5472_1.png" alt="Stone Arch">
  </div>

  <!-- LAYER 4: Altar with cypresses -->
  <div class="layer-altar">
    <img src="assets/ornament/4576_1.png" alt="Altar">
  </div>

  <!-- LAYER 5: Staircase -->
  <div class="layer-stairs">
    <img src="assets/ornament/5471_1.png" alt="Staircase">
  </div>

  <!-- LAYER 6: Bride & Groom -->
  <div class="layer-couple">
    <div class="couple-wrap">
      <img class="orn-bride-img" src="assets/ornament/5448_1.png" alt="Bride">
      <img class="orn-groom-img" src="assets/ornament/5447_1.png" alt="Groom">
    </div>
  </div>

  <!-- LAYER 7: Seagulls flying -->
  <div class="layer-seagulls">
    <div class="seagull sg1"><img src="assets/ornament/many-seagulls-isolated_1.png" alt=""></div>
    <div class="seagull sg2"><img src="assets/ornament/many-seagulls-isolated_2.png" alt=""></div>
    <div class="seagull sg3"><img src="assets/ornament/many-seagulls-isolated_3.png" alt=""></div>
    <div class="seagull sg4"><img src="assets/ornament/many-seagulls-isolated_4.png" alt=""></div>
    <div class="seagull sg5"><img src="assets/ornament/many-seagulls-isolated_5.png" alt=""></div>
    <div class="seagull sg6"><img src="assets/ornament/many-seagulls-isolated_6.png" alt=""></div>
  </div>

  <!-- LAYER 8: Hanging leaves at top of arch -->
  <div class="layer-leaves-top leaves-tl">
    <img src="assets/ornament/5458_1.png" alt="Leaves">
  </div>
  <div class="layer-leaves-top leaves-tr">
    <img src="assets/ornament/5458_2.png" alt="Leaves">
  </div>
  <div class="layer-leaves-top leaves-ml">
    <img src="assets/ornament/5459_1.png" alt="Vine">
  </div>
  <div class="layer-leaves-top leaves-mr">
    <img src="assets/ornament/5459_2.png" alt="Vine">
  </div>

  <!-- LAYER 9: Bottom Foreground -->
  <div class="layer-foreground">
    <!-- Tree foliage -->
    <div class="fg-tree fg-tree-l">
      <img src="assets/ornament/5467_3.png" alt="Tree">
    </div>
    <div class="fg-tree fg-tree-r">
      <img src="assets/ornament/5467_4.png" alt="Tree">
    </div>

    <!-- White flower bouquets -->
    <div class="fg-flower fg-flower-l">
      <img src="assets/ornament/5457_2.png" alt="Flowers">
    </div>
    <div class="fg-flower fg-flower-r">
      <img src="assets/ornament/5457_3.png" alt="Flowers">
    </div>

    <!-- Aloe/grass -->
    <div class="fg-grass fg-grass-l">
      <img src="assets/ornament/5418_1.png" alt="Grass">
    </div>
    <div class="fg-grass fg-grass-r">
      <img src="assets/ornament/5418_2.png" alt="Grass">
    </div>

    <!-- Pink butterflies -->
    <div class="fg-butterfly fg-butterfly-l">
      <img src="assets/ornament/Asset_1_300x_1.png" alt="Butterfly">
    </div>
    <div class="fg-butterfly fg-butterfly-r">
      <img src="assets/ornament/Asset_1_300x_2.png" alt="Butterfly">
    </div>
  </div>

  <!-- LAYER 10: Cover Text Content -->
  <div class="cover-text">
    <p class="cover-label">The Wedding of</p>
    <h1 class="cover-names">
      <span id="groom-display"><?= $groom_name ?></span>
      <span class="cover-amp">&amp;</span>
      <span id="bride-display"><?= $bride_name ?></span>
    </h1>
    <button class="btn-open" id="btnOpenInvitation">Open Invitation</button>
  </div>

</div><!-- /cover-scene -->


<!-- ============================================================
     MAIN INVITATION CONTENT (visible after cover fades out)
     ============================================================ -->
<main class="main-content">

  <!-- Hero Section -->
  <section class="main-hero">
    <div class="container px-3 px-sm-4">
      <span class="badge-adat">Undangan Pernikahan</span>
      <div class="decorative-leaf"><i class="fa-solid fa-leaf"></i></div>
      <p class="text-uppercase small text-muted mb-1" style="letter-spacing: 2px;">The Wedding of</p>
      <h2 class="main-couple-name"><span id="groom-display-2"><?= $groom_name ?></span> &amp; <span id="bride-display-2"><?= $bride_name ?></span></h2>

      <div class="date-box my-3">
        <p class="mb-1 text-uppercase small text-muted" style="letter-spacing: 1px; font-size: 11px;">Akan Berlangsung Pada</p>
        <h5 class="fw-bold mb-0" id="date-display"><?= $formatted_date ?></h5>
      </div>

      <div class="countdown-container" id="countdown">
        <div class="countdown-box">
          <span class="countdown-val" id="days">00</span>
          <span class="countdown-label">Hari</span>
        </div>
        <div class="countdown-box">
          <span class="countdown-val" id="hours">00</span>
          <span class="countdown-label">Jam</span>
        </div>
        <div class="countdown-box">
          <span class="countdown-val" id="minutes">00</span>
          <span class="countdown-label">Menit</span>
        </div>
        <div class="countdown-box">
          <span class="countdown-val" id="seconds">00</span>
          <span class="countdown-label">Detik</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Detail Acara Section -->
  <section class="py-5 bg-white" id="acara">
    <div class="container px-3 px-sm-4">
      <h2 class="section-title">Detail Acara Spesial</h2>
      <div class="row g-3">
        <div class="col-md-6">
          <div class="neubrutal-card h-100">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-ring me-2 text-danger"></i>Akad Nikah</h5>
            <p class="mb-1"><strong>Waktu:</strong> 09.00 WIB - Selesai</p>
            <p class="mb-1"><strong>Tempat:</strong> Masjid Agung Baiturrahman</p>
            <p class="small text-muted">Kawasan Candi Syakira, Jakarta Selatan</p>
            <a href="https://maps.google.com" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill fw-bold mt-2">Lihat Rute Maps</a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="neubrutal-card h-100">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-champagne-glasses me-2 text-warning"></i>Resepsi</h5>
            <p class="mb-1"><strong>Waktu:</strong> 11.00 - 15.00 WIB</p>
            <p class="mb-1"><strong>Tempat:</strong> Grand Ballroom Syakira</p>
            <p class="small text-muted">Jl. Jenderal Sudirman Kav. 23, Jakarta Selatan</p>
            <a href="https://maps.google.com" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill fw-bold mt-2">Lihat Rute Maps</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Cerita Cinta (Love Story) Section -->
  <section class="py-5" id="cerita">
    <div class="container px-3 px-sm-4">
      <h2 class="section-title">Kisah Cinta Kami</h2>
      <div class="d-flex flex-column gap-4">
        
        <!-- Timeline Item 1 -->
        <div class="neubrutal-card">
          <span class="badge-adat mb-2">2023 - Awal Pertemuan</span>
          <h5 class="fw-bold text-dark">Pertemuan Pertama</h5>
          <p class="small text-muted mb-0">Tuhan mempertemukan kami dalam sebuah acara seminar. Dari senyuman pertama, kami tahu ada sesuatu yang istimewa yang sedang dimulai.</p>
        </div>

        <!-- Timeline Item 2 -->
        <div class="neubrutal-card">
          <span class="badge-adat mb-2">2024 - Menjalin Komitmen</span>
          <h5 class="fw-bold text-dark">Mengikat Janji</h5>
          <p class="small text-muted mb-0">Setelah satu tahun berbagi cerita, tawa, dan impian, kami memutuskan untuk melangkah lebih serius dan berkomitmen untuk saling mendukung selamanya.</p>
        </div>

        <!-- Timeline Item 3 -->
        <div class="neubrutal-card">
          <span class="badge-adat mb-2">2026 - Melangkah ke Pelaminan</span>
          <h5 class="fw-bold text-dark">Hari Bahagia</h5>
          <p class="small text-muted mb-0">Hari ini, di hadapan keluarga dan sahabat tercinta, kami mengucapkan janji suci pernikahan untuk memulai babak baru sebagai suami istri.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- Galeri Foto (Photo Gallery) Section -->
  <section class="py-5 bg-white" id="galeri">
    <div class="container px-3 px-sm-4">
      <h2 class="section-title">Galeri Foto Kebahagiaan</h2>
      <div class="row g-3">
        <div class="col-8">
          <div class="gallery-card">
            <img src="assets/img/couple_1.png" alt="Couple 1" class="img-fluid gallery-img">
          </div>
        </div>
        <div class="col-4">
          <div class="gallery-card h-100">
            <img src="assets/img/couple_2.png" alt="Couple 2" class="img-fluid gallery-img h-100">
          </div>
        </div>
        <div class="col-4">
          <div class="gallery-card">
            <img src="assets/img/couple_3.png" alt="Couple 3" class="img-fluid gallery-img">
          </div>
        </div>
        <div class="col-8">
          <div class="gallery-card">
            <img src="assets/img/couple_4.png" alt="Couple 4" class="img-fluid gallery-img">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- RSVP Section -->
  <section class="py-5" id="rsvp">
    <div class="container px-3 px-sm-4">
      <div class="neubrutal-card text-center">
        <h3 class="fw-bold mb-2">Konfirmasi Kehadiran</h3>
        <p class="text-muted small mb-4">Mohon konfirmasi kehadiran Anda untuk menyambut kebahagiaan kami.</p>
        <form onsubmit="event.preventDefault(); alert('Terima kasih atas konfirmasi kehadiran Anda!');">
          <div class="mb-3 text-start">
            <label class="form-label small fw-bold text-uppercase">Nama Anda</label>
            <input type="text" class="form-control" style="border: 2px solid var(--theme-accent-dark); border-radius: 8px;" placeholder="Masukkan nama tamu" required>
          </div>
          <div class="mb-3 text-start">
            <label class="form-label small fw-bold text-uppercase">Status Kehadiran</label>
            <select class="form-select" style="border: 2px solid var(--theme-accent-dark); border-radius: 8px;">
              <option>Ya, Saya Akan Hadir</option>
              <option>Maaf, Saya Tidak Bisa Hadir</option>
              <option>Masih Ragu-ragu</option>
            </select>
          </div>
          <button type="submit" class="neubrutal-btn w-100 mt-2">Kirim Konfirmasi</button>
        </form>
      </div>
    </div>
  </section>

  <!-- Reusable Modular Watermark Bar -->
  <?php include 'watermark.php'; ?>

</main>

