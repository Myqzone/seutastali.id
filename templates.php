<?php
// Load bootstrap (centralized config loading)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Set page meta
$page_title = 'Pilih Desain Undangan - Seutastali';
$page_description = 'Pilih dari berbagai desain template undangan pernikahan digital eksklusif dan editorial untuk hari bahagia Anda.';

// Load dynamic template dataset
require_once ROOT_PATH . 'config/templates.php';
$template_cards = get_templates();

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
          Katalog <span class="text-primary fw-bold">Template</span>
        </h1>
        <p class="ms-0 text-start mb-0" style="margin-left: 0 !important; max-width: 620px;">
          Desain premium yang dikurasi secara editorial untuk momen istimewa Anda
        </p>
      </div>

      <!-- Right-aligned Breadcrumb Navigation -->
      <nav aria-label="breadcrumb" class="mb-0 order-1 order-md-2 align-self-start align-self-md-start pt-md-2">
        <ol class="breadcrumb mb-0 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">
          <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
          <li class="breadcrumb-item active text-primary" aria-current="page">Templates</li>
        </ol>
      </nav>
    </div>
  </div>
</section>

<!-- Dynamic Templates Grid Section with Load More -->
<section class="pt-3 pb-5">
  <div class="container">

    <!-- Self-contained stylesheet link for absolute modularity -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>css/pages/template-slider.css?v=<?= filemtime(ROOT_PATH . 'assets/css/pages/template-slider.css') ?>">

    <!-- Category Nav Tabs (Bootstrap Buttons) with Label Header -->
    <div class="category-tabs-section mb-5" data-aos="fade-up" data-aos-delay="100">
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

    <!-- Grid Container -->
    <div class="row g-4 mb-5" id="templateGrid">
      <?php
      $index = 0;
      foreach ($template_cards as $key => $card):
        // Show first 4 templates (index 0, 1, 2, 3), hide the rest
        $display_style = ($index < 4) ? '' : 'style="display: none;"';

        // Construct template preview URL (always path-based as requested)
        $template_url = STATIC_URL . 'templates/' . urlencode($key) . '/';
      ?>
        <div class="col-6 col-md-6 col-lg-3 template-grid-card" data-index="<?= $index ?>" data-category="<?= $card['category'] ?>" data-popular="<?= isset($card['popular']) && $card['popular'] ? 'true' : 'false' ?>" <?= $display_style ?> data-aos="fade-up" data-aos-delay="<?= 200 + (($index % 4) * 100) ?>">
          <div class="card bg-primary border-0 rounded-4 overflow-hidden h-100 shadow-none template-card p-0">
            <div class="position-relative overflow-hidden w-100 template-card-mockup">
              <!-- Click image to open Live Demo directly -->
              <a href="<?= $template_url ?>" target="_blank">
                <img src="<?= ASSETS_URL ?>media/template/<?= $card['image'] ?>" class="w-100 h-100 object-fit-cover template-card-image" alt="<?= $card['alt'] ?>" loading="lazy">
              </a>

              <!-- Category Badge -->
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
              <!-- Click title to open Live Demo directly -->
              <a href="<?= $template_url ?>" target="_blank" class="text-decoration-none">
                <h5 class="card-title fw-bold mb-0 text-white text-capitalize template-card-title"><?= $card['title'] ?></h5>
              </a>
            </div>
          </div>
        </div>
      <?php
        $index++;
      endforeach;
      ?>
    </div>

    <!-- Load More Button -->
    <?php if (count($template_cards) > 4): ?>
      <div class="text-center mt-4">
        <button id="loadMoreBtn" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold">
          Lihat Lebih Banyak <i class="fa-solid fa-chevron-down ms-2"></i>
        </button>
      </div>
    <?php endif; ?>

  </div>
</section>

<!-- Vanilla JS for SPA Category Filtering & Dynamic Load-More Integration -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const cards = document.querySelectorAll('.template-grid-card');
    const tabButtons = document.querySelectorAll('.category-tabs-section .category-tab-btn');
    const itemsPerRow = 4;
    
    let activeCategory = 'all';
    let visibleCount = 4;

    // Main dynamic filter function
    function applyFilter(category) {
      activeCategory = category;
      visibleCount = 4; // Reset grid to first row (4 items)
      let matchCount = 0;

      cards.forEach(card => {
        const cardCategory = card.getAttribute('data-category').toLowerCase();
        const isPopular = card.getAttribute('data-popular') === 'true';

        let isMatch = false;
        if (category === 'all') {
          isMatch = true;
        } else if (category === 'populer') {
          isMatch = isPopular;
        } else {
          isMatch = cardCategory === category;
        }

        if (isMatch) {
          card.classList.add('is-filtered-match');
          
          if (matchCount < visibleCount) {
            card.style.display = 'block';
            card.style.opacity = '1';
          } else {
            card.style.display = 'none';
          }
          
          matchCount++;
        } else {
          card.style.display = 'none';
          card.classList.remove('is-filtered-match');
        }
      });

      // Handle visibility of load more button
      if (loadMoreBtn) {
        if (matchCount > visibleCount) {
          loadMoreBtn.style.display = 'inline-block';
        } else {
          loadMoreBtn.style.display = 'none';
        }
      }
    }

    // Category button click listener
    tabButtons.forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Skip if already active
        if (btn.classList.contains('btn-primary')) return;

        // Toggle active styling
        tabButtons.forEach(b => {
          b.classList.remove('btn-primary');
          b.classList.add('btn-outline-primary');
        });
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-primary');

        // Apply filtering instantly
        const category = btn.getAttribute('data-category').toLowerCase();
        applyFilter(category);
      });
    });

    // Load more button action listener
    if (loadMoreBtn) {
      loadMoreBtn.addEventListener('click', function() {
        const matchedCards = document.querySelectorAll('.template-grid-card.is-filtered-match');
        let newlyShown = 0;

        for (let i = visibleCount; i < matchedCards.length; i++) {
          if (newlyShown < itemsPerRow) {
            matchedCards[i].style.display = 'block';
            matchedCards[i].style.opacity = '0';
            matchedCards[i].style.transition = 'opacity 0.4s ease';
            
            // Trigger beautiful CSS fade-in
            (function(el) {
              setTimeout(() => {
                el.style.opacity = '1';
              }, 50);
            })(matchedCards[i]);

            newlyShown++;
          } else {
            break;
          }
        }

        visibleCount += newlyShown;

        // Hide load more if we reached the end of the filtered set
        if (visibleCount >= matchedCards.length) {
          loadMoreBtn.style.display = 'none';
        }
      });
    }

    // Proactively initialize matches classes for default 'all' view
    cards.forEach(card => {
      card.classList.add('is-filtered-match');
    });
  });
</script>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>