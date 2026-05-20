<?php

/**
 * Template Detail Page - SeutasTali (Single File for All Templates)
 * Location: template-detail.php
 */

// Initialize bootstrap configuration
require_once __DIR__ . '/config/bootstrap.php';
require_once ROOT_PATH . 'config/templates.php';

// Fetch templates data
$templates = get_templates();

// Get the requested template ID from the query string
$template_id = isset($_GET['id']) ? strtolower(trim($_GET['id'])) : '';

// Redirect to homepage if no ID is specified or template is not found
if (empty($template_id) || !array_key_exists($template_id, $templates)) {
    header("Location: index.php");
    exit;
}

// Extract template data
$template = $templates[$template_id];
$title = $template['title'];
$category = $template['category'];
$image = $template['image'];
$alt = $template['alt'];
$price = $template['price'];
$discount_price = $template['discount_price'];
$description = $template['description'];
$demo_url = $template['demo_url'];
$features = $template['features'];

// WhatsApp Order Link Configuration
$whatsapp_number = '6282227773904';
$whatsapp_message = "Halo SeutasTali, saya sangat tertarik dan ingin memesan template undangan digital premium tipe *{$title}*! Bagaimana langkah selanjutnya?";
$whatsapp_url = "https://wa.me/{$whatsapp_number}?text=" . urlencode($whatsapp_message);

// Set page meta for layouts/app.php
$page_title = "Template Undangan Digital {$title}";
$page_description = $description;
$site_keywords = "template {$template_id}, undangan digital {$template_id}, seutastali, undangan pernikahan {$category}";

ob_start();
?>

<!-- Main Container - Adjusted Spacing and Cohesive styling -->
<div class="container pt-5 mt-5 pb-5">

    <!-- Back to Gallery Button (Rounded Pill Style) -->
    <div class="mb-4 pt-3">
        <a href="index.php" class="btn btn-outline-primary rounded-pill fw-bold px-4 py-2 border-2">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Galeri
        </a>
    </div>

    <!-- Product Detail Layout - Rounded Premium Container -->
    <div class="bg-white p-4 p-md-5 mb-5 border border-2 border-secondary-subtle rounded-4 shadow-sm">
        <div class="row g-4 g-lg-5">

            <!-- Left Side: Product Image Mockup in Rounded Brand-colored Frame -->
            <div class="col-lg-5 d-flex align-items-center justify-content-center">
                <div class="overflow-hidden position-relative w-100 border border-3 border-primary rounded-4 shadow-sm" style="max-width: 340px; aspect-ratio: 9 / 16;">
                    <span class="badge bg-primary text-white position-absolute top-0 end-0 m-3 text-uppercase px-3 py-2 rounded-pill fw-bold z-3 border border-white border-opacity-10" style="font-size: 0.8rem;">
                        <?= $category ?>
                    </span>
                    <img src="<?= ASSETS_URL ?>media/template/<?= $image ?>" class="w-100 h-100 img-fluid" style="object-fit: cover; border-radius: 13px !important;" alt="<?= $alt ?>">
                </div>
            </div>

            <!-- Right Side: Product Information -->
            <div class="col-lg-7">
                <div class="d-flex flex-column h-100 justify-content-center">

                    <!-- Title & Category Info -->
                    <h1 class="fw-bold text-uppercase mb-1" style="font-size: 2.8rem; font-weight: 800; letter-spacing: -1px; color: var(--c-primary-darker, #2a060a);">
                        <?= $title ?>
                    </h1>
                    <span class="text-primary text-uppercase fw-bold mb-4 d-block" style="letter-spacing: 2px; font-size: 0.95rem;">
                        Kategori: <?= $category ?>
                    </span>

                    <!-- Price Box Neubrutalist - Styled with Cohesive rounded corners -->
                    <div class="bg-light p-4 mb-4 border border-2 border-secondary-subtle rounded-4">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-7 mb-3 mb-md-0">
                                <span class="text-muted text-decoration-line-through d-block fw-semibold mb-1" style="font-size: 1.1rem;">
                                    Harga Normal: <?= $price ?>
                                </span>
                                <span class="text-primary d-block fw-bold lh-1" style="font-size: 2.2rem; font-weight: 800;">
                                    <?= $discount_price ?>
                                </span>
                            </div>
                            <div class="col-12 col-md-5 text-md-end">
                                <span class="badge bg-primary text-white text-uppercase py-2 px-3 fw-bold rounded-pill" style="font-size: 0.85rem;">
                                    Diskon Hemat 50%
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <p class="lead mb-4" style="font-size: 1.05rem; line-height: 1.7; color: rgba(30, 30, 30, 0.85);">
                        <?= $description ?>
                    </p>

                    <!-- Features Checklist Grid -->
                    <h4 class="fw-bold text-uppercase mb-3" style="font-size: 1.25rem; letter-spacing: 0.5px; color: var(--c-primary-darker, #2a060a);">
                        Fitur Premium Termasuk:
                    </h4>
                    <div class="row g-2 mb-4">
                        <?php foreach ($features as $feature): ?>
                            <div class="col-12 col-md-6">
                                <div class="bg-white p-3 d-flex align-items-center gap-3 border border-2 border-secondary-subtle rounded-4 shadow-sm">
                                    <i class="fa-solid fa-circle-check text-primary" style="font-size: 1.2rem;"></i>
                                    <span class="fw-semibold text-dark" style="font-size: 0.95rem;"><?= $feature ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Action Buttons Bento - Rounded Pill Style -->
                    <div class="row g-3 pt-3">
                        <div class="col-12 col-md-6">
                            <a href="<?= $whatsapp_url ?>" class="btn btn-primary rounded-pill py-3 d-flex align-items-center justify-content-center gap-2 w-100 fw-bold shadow-sm" style="font-size: 1.05rem; letter-spacing: 0.5px;">
                                <i class="fa-brands fa-whatsapp style-icon me-1"></i> Pesan Sekarang
                            </a>
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="<?= $demo_url ?>" target="_blank" class="btn btn-outline-primary rounded-pill py-3 d-flex align-items-center justify-content-center gap-2 w-100 fw-bold border-2 shadow-sm" style="background-color: #FFFFFF; font-size: 1.05rem; letter-spacing: 0.5px;">
                                <i class="fa-solid fa-eye style-icon me-1"></i> Demo Tampilan
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Related Templates Recommendations Section (Full Dynamic Owl Carousel Slider) -->
    <div class="pt-5 mt-4">
        <h2 class="text-center fw-bold text-uppercase mb-4" style="font-size: 2.2rem; font-weight: 800; letter-spacing: -0.5px; color: var(--c-primary-darker, #2a060a);">
            Rekomendasi Template Lainnya
        </h2>

        <div class="pt-3">
            <?php include ROOT_PATH . 'includes/sections/template-slider.php'; ?>
        </div>
    </div>

</div>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>