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
<div class="template-slider-container" data-aos="fade-up" data-aos-delay="200" data-aos-duration="500">
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
                <?php foreach ($template_cards as $key => $card):
                    // Construct template preview URL (always path-based as requested)
                    $template_url = STATIC_URL . 'templates/' . urlencode($key) . '/';
                ?>
                    <div class="splide__slide template-slider-item template-grid-item" data-category="<?= $card['category'] ?>" data-popular="<?= isset($card['popular']) && $card['popular'] ? 'true' : 'false' ?>">
                        <div class="card bg-primary border-0 rounded-4 overflow-hidden h-100 shadow-none template-card p-0">
                            <div class="position-relative overflow-hidden w-100 template-card-mockup">
                                <!-- Link image to Live Demo directly -->
                                <a href="<?= $template_url ?>" target="_blank">
                                    <img src="<?= ASSETS_URL ?>media/template/<?= $card['image'] ?>" class="w-100 h-100 object-fit-cover template-card-image" alt="<?= $card['alt'] ?>" loading="eager">
                                </a>
                                <span class="badge bg-primary text-white position-absolute top-0 end-0 m-2 text-uppercase rounded-pill fw-bold template-card-badge"><?= ucfirst($card['category']) ?></span>
                                
                                <!-- Popular Badge if set -->
                                <?php if (isset($card['popular']) && $card['popular']): ?>
                                    <span class="badge bg-danger text-white position-absolute top-0 start-0 m-2 text-uppercase rounded-pill fw-bold template-card-badge">Terpopuler</span>
                                <?php endif; ?>

                                <!-- Open Live Preview first under Option A Flow -->
                                <div class="template-hover-btn-wrapper position-absolute bottom-0 start-0 end-0 text-center pb-2 pb-md-3">
                                    <a href="<?= $template_url ?>" class="btn btn-light text-primary fw-bold rounded-pill px-4 py-2 template-card-btn">Buka Undangan</a>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 text-center py-2">
                                <!-- Link title to Live Demo directly -->
                                <a href="<?= $template_url ?>" target="_blank" class="text-decoration-none">
                                    <h5 class="card-title fw-bold mb-0 text-white text-capitalize template-card-title"><?= $card['title'] ?></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>