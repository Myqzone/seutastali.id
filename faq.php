<?php
/**
 * FAQ Page
 * Location: /faq.php
 */

// Load bootstrap (centralized config loading)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Set page meta
$page_title = 'FAQ - Seutastali';
$page_description = 'Kumpulan pertanyaan yang sering diajukan mengenai layanan undangan digital Seutastali.';

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
                    Frequently Asked <span class="text-primary fw-bold">Questions</span>
                </h1>
                <p class="ms-0 text-start mb-0" style="margin-left: 0 !important; max-width: 620px;">
                    Temukan jawaban atas berbagai pertanyaan umum tentang pembuatan undangan digital di Seutastali
                </p>
            </div>

            <!-- Right-aligned Breadcrumb Navigation -->
            <nav aria-label="breadcrumb" class="mb-0 order-1 order-md-2 align-self-start align-self-md-start pt-md-2">
                <ol class="breadcrumb mb-0 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">
                    <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">FAQ</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- FAQ Content Section -->
<div class="pt-3 pb-5">
    <?php
    $faq_limit = 100; // Set limit high to display all available FAQs
    $faq_accordion_id = 'faqPageAccordion';
    $faq_id_prefix = 'faq-page-';
    $hide_header = true;
    include ROOT_PATH . 'includes/sections/faq.php';
    ?>
</div>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>