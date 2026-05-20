<?php
if (!defined('BASE_PATH')) {
  define('BASE_PATH', realpath(__DIR__ . '/../..'));
}

$logoUrlBase = defined('ASSETS_URL')
  ? rtrim(ASSETS_URL, '/')
  : ((defined('BASE_URL') ? rtrim(BASE_URL, '/') : '') . '/assets');

$current_page = basename($_SERVER['PHP_SELF'], '.php');
$menu_items = [
  'index' => 'Home',
  'about' => 'About',
  'pricing' => 'Pricing',
  'features' => 'Features',
  'faq' => 'FAQ'
];
$nav_base_url = defined('MAIN_SITE_URL') ? MAIN_SITE_URL : (defined('BASE_URL') ? BASE_URL : '/');
?>
<header class="header position-fixed start-0 top-0 w-100 fixed-header">
  <div class="container">
    <nav class="navbar navbar-expand-xl rounded-pill">
      <div class="d-flex align-items-center justify-content-between w-100">

        <a href="<?= defined('MAIN_SITE_URL') ? MAIN_SITE_URL : (defined('BASE_URL') ? BASE_URL : '/') ?>" class="logo">
          <img src="<?= htmlspecialchars($logoUrlBase . '/media/logo/logo-full.webp', ENT_QUOTES, 'UTF-8'); ?>"
            width="120" class="img-fluid" alt="Logo">
        </a>

        <button
          class="navbar-toggler custom-hamburger d-xl-none" type="button" data-bs-toggle="modal" data-bs-target="#mobileMenuModal">
          <span class="line line-1"></span>
          <span class="line line-2"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarlink">
          <ul class="navbar-nav mx-auto gap-2 p-1 rounded-pill">
            <?php foreach ($menu_items as $page => $label):
              $href = ($page === 'index') ? $nav_base_url : rtrim($nav_base_url, '/') . '/' . $page;
            ?>
              <li class="nav-item">
                <a class="nav-link <?= ($current_page == $page) ? 'active' : '' ?>" href="<?= $href ?>">
                  <?= $label ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
          <div class="d-flex align-items-center">
            <a href="<?= rtrim($nav_base_url, '/') ?>/templates" class="btn btn-primary">Pilih Template</a>
          </div>
        </div>

      </div>
    </nav>
  </div>
</header>

<!-- Mobile Menu Modal -->
<div class="modal fade bottom-sheet-modal" id="mobileMenuModal" tabindex="-1" aria-labelledby="mobileMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0 py-4">
        <div class="modal-handle"></div>
      </div>
      <div class="modal-body text-center p-4">
        <h3 class="modal-title-custom fw-bold mb-4">Main Menu</h3>
        <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
          <?php foreach ($menu_items as $page => $label):
            $href = ($page === 'index') ? $nav_base_url : rtrim($nav_base_url, '/') . '/' . $page;
          ?>
            <li>
              <a href="<?= $href ?>" class="nav-link <?= ($current_page == $page) ? 'active' : '' ?> text-decoration-none text-dark d-block py-2"><?= $label ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
        <hr class="modal-separator my-4 mx-auto">
        <div class="mb-2">
          <a href="https://www.instagram.com/seutastali.id/" target="_blank" class="text-dark fs-3">
            <i class="fa-brands fa-instagram"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('mobileMenuModal');
    if (!modalElement) return;

    const modalDialog = modalElement.querySelector('.modal-dialog');
    let startY = 0;
    let currentY = 0;
    let isDragging = false;
    let hasMoved = false;

    modalElement.addEventListener('touchstart', (e) => {
      // Allow dragging from anywhere in the modal if it's not scrolled
      if (modalDialog.scrollTop <= 0) {
        startY = e.touches[0].clientY;
        currentY = startY; // Initialize currentY
        isDragging = true;
        hasMoved = false;
        modalDialog.style.transition = 'none';
      }
    }, {
      passive: true
    });

    modalElement.addEventListener('touchmove', (e) => {
      if (!isDragging) return;

      currentY = e.touches[0].clientY;
      const diffY = currentY - startY;

      if (diffY > 10) { // Only count as drag if they move at least 10px down
        hasMoved = true;
        modalDialog.style.transform = `translateY(${diffY}px)`;
      }
    }, {
      passive: true
    });

    modalElement.addEventListener('touchend', () => {
      if (!isDragging) return;

      isDragging = false;

      // If user just tapped without dragging, do NOT mutate style
      // This ensures the tap propagates cleanly as a standard click event!
      if (!hasMoved) {
        modalDialog.style.transition = '';
        return;
      }

      const diffY = currentY - startY;
      const threshold = 100;

      modalDialog.style.transition = 'transform 0.3s ease-out';

      if (diffY > threshold) {
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) {
          modal.hide();
        } else {
          // Fallback if bootstrap instance is not found
          modalElement.classList.remove('show');
          document.body.classList.remove('modal-open');
          const backdrop = document.querySelector('.modal-backdrop');
          if (backdrop) backdrop.remove();
        }

        setTimeout(() => {
          modalDialog.style.transform = '';
        }, 300);
      } else {
        modalDialog.style.transform = '';
      }

      startY = 0;
      currentY = 0;
      hasMoved = false;
    });

    modalElement.addEventListener('hidden.bs.modal', () => {
      modalDialog.style.transform = '';
      modalDialog.style.transition = '';
    });
  });
</script>