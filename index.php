<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load bootstrap (includes app.php, db.php, helpers, dll)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Handle Short Link Redirection (via API)
if (isset($_GET['c']) && !empty($_GET['c'])) {
    require_once ROOT_PATH . 'api/shortener.php';
    exit;
}

// Set page meta
$page_title = 'SeutasTali - Template Undangan Digital Premium';
$page_description = 'Buat undangan digital premium, elegan, dan praktis untuk pernikahan, ulang tahun, dan setiap momen spesial Anda secara instan di SeutasTali.';

// Load separate lightweight slider CSS
$extra_css = '<link rel="stylesheet" href="' . ASSETS_URL . 'css/pages/hero-slider.css?v=' . filemtime(ROOT_PATH . 'assets/css/pages/hero-slider.css') . '">';

ob_start();
?>

<!-- Alert Messages (reusable section) -->
<?php include(ROOT_PATH . 'includes/sections/alerts.php'); ?>

<section class="position-relative py-5 mt-3" id="home">
    <div class="container position-relative z-3 text-center">

        <div class="section-header" data-aos="fade-up" data-aos-delay="100">
            <span class="badge bg-label-primary mb-3">Memperkenalkan</span>
            <h1 class="hero-title">
                Didesain untuk Hari Besarmu. <br> Mudah Diedit. <span class="text-primary fw-bold">Praktis Dibagikan.</span>
            </h1>
            <p class="mx-auto mb-4">
                Pilih gaya template. Tambahkan ceritamu. Bagikan dalam hitungan menit.
            </p>
            <div class="section-footer">
                <a href="#templates" class="btn btn-primary">Pilih Template</a>
            </div>
        </div>

    </div>

    <!-- Infinite Running Marquee Section (Full Bleed - Edge to Edge) -->
    <div class="hero-slider-wrapper overflow-hidden position-relative" data-aos="fade-up" data-aos-delay="200">
        <!-- Smooth fade overlays for elegant borders -->
        <div class="marquee-fade-left position-absolute start-0 top-0 bottom-0 z-3 d-none d-md-block" style="width: 15%; background: linear-gradient(to right, var(--c-sand), transparent); pointer-events: none;"></div>
        <div class="marquee-fade-right position-absolute end-0 top-0 bottom-0 z-3 d-none d-md-block" style="width: 15%; background: linear-gradient(to left, var(--c-sand), transparent); pointer-events: none;"></div>

        <div class="hero-slider-track">
            <!-- Group 1 -->
            <div class="hero-slider-group">
                <?php
                $marquee_templates = ['syakira' => '3.webp', 'kamila' => '7.webp', 'annisa' => '1.webp', 'adinda' => '2.webp', 'katsudoto' => '1.webp', 'mondrian' => '4.webp', 'bauhaus' => '5.webp', 'brutal-chic' => '2.webp', 'minimalis' => '5.webp', 'zen' => '1.webp'];
                foreach ($marquee_templates as $name => $img):
                ?>
                    <div class="hero-slider-card">
                        <img src="<?= ASSETS_URL ?>media/template/<?= $img ?>" alt="SeutasTali Template Preview">
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Group 2 (Duplicate for infinite seamless loop) -->
            <div class="hero-slider-group" aria-hidden="true">
                <?php foreach ($marquee_templates as $name => $img): ?>
                    <div class="hero-slider-card">
                        <img src="<?= ASSETS_URL ?>media/template/<?= $img ?>" alt="SeutasTali Template Preview">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<hr class="my-4">

<!-- Dedicated Template Gallery Section -->
<section class="py-5" id="templates">
    <div class="container text-center">

        <!-- New Premium Section Header -->
        <div class="section-header mb-5" data-aos="fade-up" data-aos-delay="100">
            <h1 class="hero-title">
                Didesain untuk Hari <span class="text-primary">Bahagiamu</span>. <br> Mudah Diedit. <span class="text-primary">Praktis Dibagikan.</span>
            </h1>
            <p class="mx-auto mb-4">
                Pilih gaya. Tambahkan ceritamu. Bagikan dalam hitungan menit.
            </p>
        </div>

        <!-- Category Nav Tabs (Bootstrap Buttons) with Label Header -->
        <div class="category-tabs-section mb-4" data-aos="fade-up" data-aos-delay="150">
            <div class="d-flex justify-content-center flex-wrap gap-2">
                <button class="btn btn-primary category-tab-btn" data-category="all">Semua</button>
                <button class="btn btn-outline-primary category-tab-btn" data-category="populer">Populer</button>
                <button class="btn btn-outline-primary category-tab-btn" data-category="adat">Adat</button>
                <button class="btn btn-outline-primary category-tab-btn" data-category="floral">Floral</button>
                <button class="btn btn-outline-primary category-tab-btn" data-category="fairytale">Fairytale</button>
                <button class="btn btn-outline-primary category-tab-btn" data-category="minimalis">Minimalis</button>
                <button class="btn btn-outline-primary category-tab-btn" data-category="nature">Nature</button>
            </div>
        </div>

        <!-- Reusable Premium Template Slider Component -->
        <?php include ROOT_PATH . 'includes/sections/template-slider.php'; ?>

    </div>
</section>

<hr class="my-4">

<!-- Dedicated Comparison Grid Section -->
<section class="py-5" id="comparison">
    <div class="container text-center">
        <div class="d-flex flex-column gap-4 gap-md-4">
            <!-- 1. Centered Section Header -->
            <div class="section-header" data-aos="fade-up" data-aos-delay="100">
                <span class="badge bg-label-primary mb-3">Perbandingan</span>
                <h2>
                    Yang Undangan Cetak & Video <span class="text-primary">Tidak Bisa</span> <br class="d-none d-md-block"> (Tapi Kami <span class="text-primary">Bisa!</span>)
                </h2>
                <p class="mb-0 text-muted">
                    Ubah undangan sekali sebar menjadi kenangan abadi tanpa biaya tambahan.
                </p>
            </div>

            <!-- 2. Section Content -->
            <div class="section-content mx-auto w-100" data-aos="fade-up" data-aos-delay="150" style="max-width: 650px;">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless align-middle mb-0 small brand-comparison-table">
                        <thead>
                            <tr>
                                <th class="text-start bg-transparent" style="width: 25%;"></th>
                                <th class="text-center bg-transparent fw-semibold" style="width: 22%;">Printed</th>
                                <th class="text-center bg-transparent fw-semibold" style="width: 22%;">Whatsapp</th>
                                <th class="text-center bg-transparent" style="width: 22%;">
                                    <img src="<?= ASSETS_URL ?>media/logos/logo-seutastali.webp" alt="Seutas Tali Logo" class="brand-table-logo">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Cost Row -->
                            <tr class="border-top border-secondary-subtle">
                                <td class="text-start fw-bold">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa-solid fa-wallet me-2"></i> Biaya
                                    </span>
                                </td>
                                <td class="text-center">Mahal</td>
                                <td class="text-center">Sedang</td>
                                <td class="text-center fw-bold">Hemat</td>
                            </tr>
                            <!-- Customization Row -->
                            <tr class="border-top border-secondary-subtle">
                                <td class="text-start fw-bold">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa-solid fa-pencil me-2"></i> Edit Data
                                    </span>
                                </td>
                                <td class="text-center">Terbatas</td>
                                <td class="text-center">Sulit</td>
                                <td class="text-center fw-bold">Mudah</td>
                            </tr>
                            <!-- Interactivity Row -->
                            <tr class="border-top border-secondary-subtle">
                                <td class="text-start fw-bold">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa-solid fa-fingerprint me-2"></i> Interaksi
                                    </span>
                                </td>
                                <td class="text-center">Statis</td>
                                <td class="text-center">Hanya Lihat</td>
                                <td class="text-center fw-bold">Interaktif</td>
                            </tr>
                            <!-- Updating Row -->
                            <tr class="border-top border-bottom border-secondary-subtle">
                                <td class="text-start fw-bold">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fa-solid fa-arrows-rotate me-2"></i> Update Info
                                    </span>
                                </td>
                                <td class="text-center">Mustahil</td>
                                <td class="text-center">Rumit</td>
                                <td class="text-center fw-bold">Instan</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Section Footer -->
            <div class="section-footer text-center" data-aos="fade-up" data-aos-delay="200">
                <a href="#templates" class="btn btn-primary rounded-pill fw-semibold">
                    Pilih Template
                </a>
            </div>
        </div>
    </div>
</section>

<hr class="my-4">

<section class="py-5" id="aboutus">
    <div class="container" data-aos="fade-up" data-aos-delay="100" data-aos-duration="500">
        <div class="d-flex flex-column">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-xl-9">
                    <!-- Premium Section Header (styled entirely in style.css) -->
                    <div class="section-header" data-aos="fade-up" data-aos-delay="100" data-aos-duration="500">
                        <span class="badge bg-label-primary mb-3">Tentang Kami</span>
                        <h2>
                            <span class="text-primary d-block d-md-inline">SeutasTali hadir</span>
                            sebagai jembatan kebahagiaan momen berhargamu.
                        </h2>
                        <p class="mb-0">
                            Kami menciptakan platform undangan digital yang penuh kehangatan, keindahan, dan kemudahan—menghubungkan setiap untaian cerita cinta Anda dengan keluarga serta kerabat tercinta.
                        </p>
                    </div>
                </div>
            </div>
            <div class="gap-4">
                <div class="gap-4 d-flex flex-column flex-lg-row justify-content-center align-items-center text-center">
                    <div class="d-flex flex-column align-items-center px-3">
                        <h1 class="count-number mb-3 fw-semibold text-nowrap d-inline-flex align-items-center lh-1">
                            <span class="me-1">+</span>
                            <span class="counter-value" data-target="2.5" data-decimals="1">0</span>
                            <span class="ms-1">Jt</span>
                        </h1>
                        <p class="mb-0 fs-6">Tamu Undangan Terhubung</p>
                    </div>

                    <div class="d-none d-lg-block border-start border-1 border-purple mx-3 counter-divider"></div>

                    <div class="d-flex flex-column align-items-center px-3">
                        <h1 class="count-number mb-3 fw-semibold text-nowrap d-inline-flex align-items-center lh-1">
                            <span class="counter-value" data-target="99" data-decimals="0">0</span>
                            <span class="ms-1">%</span>
                        </h1>
                        <p class="mb-0 fs-6">Tingkat Kepuasan Pelanggan</p>
                    </div>

                    <div class="d-none d-lg-block border-start border-1 border-purple mx-3 counter-divider"></div>

                    <div class="d-flex flex-column align-items-center px-3">
                        <h1 class="count-number mb-3 fw-semibold text-nowrap d-inline-flex align-items-center lh-1">
                            <span class="me-1">+</span>
                            <span class="counter-value" data-target="15" data-decimals="0">0</span>
                            <span class="ms-1">K</span>
                        </h1>
                        <p class="mb-0 fs-6">Desain Undangan Aktif</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<hr class="my-4">

<section class="py-5" id="features">
    <div class="container">
        <div class="row g-4">

            <div class="col-12 col-lg-6" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                <div class="card h-100 border-0 rounded-4 overflow-hidden p-0">
                    <img
                        src="<?= ASSETS_URL ?>media/stock/1.webp"
                        class="w-100 h-100 object-fit-cover img-feature"
                        alt="Customer Image">
                </div>
            </div>
            <div class="col-12 col-lg-6" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1100">
                <div class="card p-4 h-100 border-0 rounded-4 bg-success-subtle d-flex flex-column justify-content-center">
                    <div class="card-body d-flex flex-column justify-content-between gap-14 gap-lg-18">
                        <p class="mb-0 fw-medium">Kualitas Layanan</p>
                        <div class="d-flex flex-column gap-1">
                            <h2 class="mt-3 mt-lg-0 mb-0 mb-lg-auto fs-11 fw-bold">Terpercaya</h2>
                            <h3 class="mb-0 fs-6">Penyedia undangan digital premium dengan performa server cepat dan andal.</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1200">
                <div class="card p-0 h-100 border-0 rounded-4 text-white overflow-hidden bg-primary">
                    <div class="p-4">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <p class="mb-0 fw-bold">Personal</p>
                                <p class="mb-0 text-white lh-sm">
                                    Desain undangan premium yang dikustomisasi secara unik sesuai cerita Anda.
                                </p>
                            </div>
                        </div>
                    </div>

                    <img src="<?= ASSETS_URL ?>media/stock/5.webp" alt="SeutasTali" class="img-fluid w-100 d-block img-object-cover">
                </div>
            </div>

            <div class="col-12 col-lg-8" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1300">
                <div class="card h-100 rounded-4 p-4 d-flex flex-column">
                    <div class="card-body d-flex flex-column gap-2">
                        <small class="fw-bold tracking-wider d-block">Fitur Interaktif</small>
                        <h2 class="fs-2 fw-bold mb-0">Fitur lengkap untuk kenyamanan tamu Anda.</h2>
                        <div class="mt-auto">
                            <p class="fs-6 lh-base">Dilengkapi RSVP otomatis, integrasi Google Maps, galeri foto editorial, background musik, hingga kolom ucapan doa terintegrasi.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<hr class="my-4">

<?php
$faq_limit = 10;
$faq_accordion_id = 'faqAccordion';
$faq_id_prefix = 'faq-';
$faq_subtitle = 'Segala hal yang perlu Anda ketahui tentang SeutasTali.';
include ROOT_PATH . 'includes/sections/faq.php';
?>

<hr class="my-4">

<!-- Subscribe Newsletter (reusable section) -->
<div>
    <?php include(ROOT_PATH . 'includes/sections/newsletter-form.php'); ?>
</div>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>