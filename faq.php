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
$page_title = 'FAQ - SeutasTali';
$page_description = 'Kumpulan pertanyaan yang sering diajukan mengenai layanan undangan digital SeutasTali.';

ob_start();
?>

<div class="mt-3">
    <?php
    $faq_limit = 15;
    $faq_accordion_id = 'faqPageAccordion';
    $faq_id_prefix = 'faq-page-';
    $faq_subtitle = 'Temukan jawaban atas berbagai pertanyaan umum tentang pembuatan undangan digital di SeutasTali';
    include ROOT_PATH . 'includes/sections/faq.php';
    ?>
</div>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>