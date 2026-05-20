<?php
// PHP Template Array for Responsive Grid (Ultra Dry and Clean)
if (!isset($template_cards)) {
    require_once ROOT_PATH . 'config/templates.php';
    $template_cards = get_templates();
}
?>

<!-- Self-contained stylesheet link for absolute modularity -->
<link rel="stylesheet" href="<?= ASSETS_URL ?>css/pages/template-slider.css?v=<?= filemtime(ROOT_PATH . 'assets/css/pages/template-slider.css') ?>">

<!-- High-Performance Premium Template Slider Wrapper -->
<div class="template-slider-container" data-aos="fade-up" data-aos-delay="100" data-aos-duration="500">
    <!-- Slider Navigation Buttons -->
    <button class="template-slider-nav-btn prev-btn" id="templateSliderPrev" aria-label="Previous Template">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button class="template-slider-nav-btn next-btn" id="templateSliderNext" aria-label="Next Template">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    <!-- Slider Track -->
    <div class="splide" id="templateSliderTrack">
        <div class="splide__track">
            <div class="splide__list">
                <?php foreach ($template_cards as $key => $card): ?>
                    <div class="splide__slide template-slider-item template-grid-item" data-category="<?= $card['category'] ?>" data-popular="<?= isset($card['popular']) && $card['popular'] ? 'true' : 'false' ?>">
                        <div class="card bg-primary border-0 rounded-4 overflow-hidden h-100 shadow-none template-card p-0">
                            <div class="position-relative overflow-hidden w-100 template-card-mockup">
                                <img src="<?= ASSETS_URL ?>media/template/<?= $card['image'] ?>" class="w-100 h-100 object-fit-cover template-card-image" alt="<?= $card['alt'] ?>" loading="lazy">
                                <span class="badge bg-primary text-white position-absolute top-0 end-0 m-2 text-uppercase rounded-pill fw-bold template-card-badge"><?= ucfirst($card['category']) ?></span>
                                <div class="template-hover-btn-wrapper position-absolute bottom-0 start-0 end-0 text-center pb-3">
                                    <a href="template-detail.php?id=<?= urlencode($key) ?>" class="btn btn-light text-primary fw-bold rounded-pill px-4 py-2 template-card-btn">Coba Template</a>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 text-center py-2">
                                <h5 class="card-title fw-bold mb-0 text-white text-capitalize template-card-title"><?= $card['title'] ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>