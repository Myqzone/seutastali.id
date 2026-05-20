<?php
// Remove any existing X-Frame-Options header from server
header_remove("X-Frame-Options");
header_remove("Content-Security-Policy");
// Set headers for iframe embedding
header("X-Frame-Options: ALLOWALL");
header("Content-Security-Policy: frame-ancestors *;");
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Bio.php - Bio Links Page dengan Data dari Database (Rebranded for SeutasTali)
 */

// Load bootstrap if available
if (!defined('SKIP_BOOTSTRAP') && !defined('DASHBOARD_BRIDGE')) {
  require_once __DIR__ . '/config/bootstrap.php';
}

// Global Path Fallbacks (Critical for Preview and Subfolder Stability)
if (!defined('ROOT_PATH')) {
  define('ROOT_PATH', __DIR__ . '/');
}
if (!defined('ASSETS_URL')) {
  $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
  if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) $protocol = $_SERVER['HTTP_X_FORWARDED_PROTO'];
  $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
  $script = $_SERVER['SCRIPT_NAME'] ?? '';
  $currentPath = dirname($script);
  if ($currentPath === '/' || $currentPath === '\\') {
    $currentPath = '';
  }
  define('ASSETS_URL', $protocol . '://' . $host . $currentPath . '/assets/');
}
if (!defined('BASE_URL')) {
  $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
  if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) $protocol = $_SERVER['HTTP_X_FORWARDED_PROTO'];
  $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
  $script = $_SERVER['SCRIPT_NAME'] ?? '';
  $currentPath = dirname($script);
  if ($currentPath === '/' || $currentPath === '\\') {
    $currentPath = '';
  }
  define('BASE_URL', $protocol . '://' . $host . $currentPath . '/');
}

// Set page meta for SeutasTali
$page_title = 'Official Links - SeutasTali';
$page_description = 'Kumpulan link resmi, katalog undangan pernikahan premium, dan kontak admin SeutasTali.';

// Fetch bio links from database
$bio_links = [];
$db_error = '';

// Database table name
$t_bio = 'seutastali_bio_links';

if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
  try {
    // Check if table exists
    $checkTable = $conn->query("SHOW TABLES LIKE '$t_bio'");
    if (!$checkTable || $checkTable->num_rows === 0) {
      $db_error = "Table '$t_bio' does not exist in database. Please run the SQL command provided below to create the table.";
    } else {
      // Table exists, fetch data
      $bio_query = "SELECT * FROM $t_bio WHERE is_active = 1 ORDER BY order_index ASC, id ASC";
      $bio_result = $conn->query($bio_query);

      if ($bio_result) {
        while ($row = $bio_result->fetch_assoc()) {
          $bio_links[] = $row;
        }

        if (empty($bio_links)) {
          $db_error = "Table exists but no active links found in the database. Add some entries to '{$t_bio}' to see them here!";
        }
      } else {
        $db_error = "Query failed: " . $conn->error;
      }
    }
  } catch (Throwable $e) {
    $db_error = "Exception: " . $e->getMessage();
    error_log('bio.php: Failed to load bio_links: ' . $e->getMessage());
  }
} else {
  $db_error = "Database connection not available or failed.";
  if (isset($conn) && $conn->connect_error) {
    $db_error .= " Connection Error: " . $conn->connect_error;
  }
}

if (!function_exists('bio_escape')) {
  function bio_escape($value)
  {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
  }
}

if (!function_exists('bio_is_icon_url')) {
  function bio_is_icon_url($value)
  {
    if ($value === null) {
      return false;
    }
    $value = trim($value);
    if ($value === '') {
      return false;
    }
    return preg_match('#^(https?:)?//#', $value) === 1 || strpos($value, '/') === 0;
  }
}

if (!function_exists('bio_icon_token_is_class')) {
  function bio_icon_token_is_class($token)
  {
    if ($token === '') {
      return false;
    }
    if (preg_match('#^(https?:)?//#', $token) === 1 || strpos($token, '/') === 0) {
      return true;
    }
    if (strpos($token, '-') !== false) {
      return true;
    }
    if (strlen($token) <= 3) {
      return true;
    }
    return false;
  }
}

if (!function_exists('bio_render_icon')) {
  function bio_render_icon($value)
  {
    $icon = trim((string)$value);
    if ($icon === '') {
      return '<i class="bio-link-icon fa-solid fa-link" aria-hidden="true"></i>';
    }

    if (bio_is_icon_url($icon)) {
      return '<span class="bio-link-icon" role="presentation" style="background-image:url(' . bio_escape($icon) . '); background-size:60%; background-repeat:no-repeat; background-position:center;"></span>';
    }

    $tokens = preg_split('/\s+/', $icon, -1, PREG_SPLIT_NO_EMPTY);
    $classTokens = [];
    $textTokens = [];
    foreach ($tokens as $token) {
      if (bio_icon_token_is_class($token)) {
        $classTokens[] = $token;
      } else {
        $textTokens[] = $token;
      }
    }

    if (empty($classTokens)) {
      $classTokens = ['fa-solid', 'fa-link'];
    }

    $classAttr = implode(' ', $classTokens);
    $label = trim(implode(' ', $textTokens));
    $labelHtml = $label ? bio_escape($label) : '';

    return '<i class="bio-link-icon ' . bio_escape($classAttr) . '" aria-hidden="true">' . $labelHtml . '</i>';
  }
}

if (!function_exists('bio_render_link')) {
  function bio_render_link(array $link)
  {
    $url = trim($link['url'] ?? '');
    // Prevents scroll to top if URL is empty or '#'
    $href = ($url !== '' && $url !== '#') ? $url : 'javascript:void(0)';
    $hasTarget = ($href !== 'javascript:void(0)');
    $targetAttr = $hasTarget ? ' target="_blank" rel="noreferrer noopener"' : '';
    $badgeText = trim($link['badge_text'] ?? '');
    $title = bio_escape($link['title'] ?? '');
    $iconHtml = bio_render_icon($link['icon_class'] ?? '');

    // Only render badge if badge text is not empty (prevents Neubrutalist border bugs)
    $badgeHtml = '';
    if ($badgeText !== '') {
      $badgeHtml = '<span class="badge">' . bio_escape($badgeText) . '</span>';
    }

    $classes = 'bio-link bio-link-grid';
    $linkId = (int)($link['id'] ?? 0);
    $clickCount = (int)($link['click_count'] ?? 0);

    return '<a href="' . bio_escape($href) . '" class="' . $classes . '" data-link-id="' . $linkId . '" data-click-count="' . $clickCount . '"' . $targetAttr . '>'
      . $iconHtml
      . '<span class="bio-link-text">' . $title . '</span>'
      . $badgeHtml
      . '</a>';
  }
}

// Set body class and extra head styles BEFORE including header
$bodyClass = 'mobile';
$extraHead = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Boxicons for icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
  <!-- Splide.js CDN CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
  <!-- Bio Page Specific Styles -->
  <link rel="stylesheet" href="' . rtrim(ASSETS_URL, '/') . '/css/pages/bio.css">';

if (!empty($_GET['preview']) && !defined('SECURITY_HEADER_OPTIONS')) {
  define('SECURITY_HEADER_OPTIONS', [
    'x_frame_options' => null, // Allow framing for preview
    'csp_extra_frame_ancestors' => ["'self'", "http://*", "https://*"]
  ]);
}

// Load security headers if helper exists
if (file_exists(ROOT_PATH . 'config/helpers/content/head.php')) {
  require_once ROOT_PATH . 'config/helpers/content/head.php';
  apply_security_headers();
}

include(ROOT_PATH . 'includes/head.php');
?>

<div class="container bio">
  <div class="mx-auto d-flex flex-column gap-3">

    <!-- Accordion Profile Info -->
    <div class="accordion" id="bioAccordion">
      <div class="accordion-item">
        <h2 class="accordion-header" id="bioHeadingOne">
          <button class="accordion-button collapsed d-flex align-items-center mb-0" type="button" data-bs-toggle="collapse" data-bs-target="#bioCollapseOne" aria-expanded="false" aria-controls="bioCollapseOne">
            <img class="logo" src="<?= ASSETS_URL ?>media/logos/logo-seutastali.webp" alt="SeutasTali Profile">
          </button>
        </h2>

        <div id="bioCollapseOne" class="accordion-collapse collapse" aria-labelledby="bioHeadingOne">
          <div class="accordion-body">
            <hr class="border-1 mb-3 mt-0">
            SeutasTali adalah platform pembuatan undangan digital pernikahan premium terkemuka di Indonesia. Kami menghadirkan desain minimalis, elegan, dan premium (Neubrutalism) yang dirancang khusus untuk mewujudkan undangan pernikahan impian Anda secara modern dan berkesan.
          </div>
        </div>
      </div>
    </div>

    <!-- Featured Banner (Neubrutalist Card Style with Splide.js Slider) -->
    <div class="bio-page-main-container splide bio-main-card-carousel">
      <div class="splide__track">
        <div class="splide__list">
          <div class="splide__slide item">
            <div class="bio-card-wrapper text-center">
              <a href="template-detail.php?id=syakira" class="bio-banner-link">
                <img src="<?= ASSETS_URL ?>media/template/3.webp" alt="Template Syakira" class="img-fluid bio-media-element" style="border: 2px solid var(--c-dark-charcoal); border-radius: 0;">
              </a>
            </div>
          </div>
          <div class="splide__slide item">
            <div class="bio-card-wrapper text-center">
              <a href="template-detail.php?id=katsudoto" class="bio-banner-link">
                <img src="<?= ASSETS_URL ?>media/template/1.webp" alt="Template Katsudoto" class="img-fluid bio-media-element" style="border: 2px solid var(--c-dark-charcoal); border-radius: 0;">
              </a>
            </div>
          </div>
          <div class="splide__slide item">
            <div class="bio-card-wrapper text-center">
              <a href="template-detail.php?id=minimalis" class="bio-banner-link">
                <img src="<?= ASSETS_URL ?>media/template/5.webp" alt="Template Minimalis" class="img-fluid bio-media-element" style="border: 2px solid var(--c-dark-charcoal); border-radius: 0;">
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Links List -->
    <div class="d-grid gap-3">
      <?php if (!empty($bio_links)): ?>
        <?php foreach ($bio_links as $link): ?>
          <?php if (isset($link['link_type']) && $link['link_type'] === 'header'): ?>
            <p class="bio-header-text">
              <?= bio_escape($link['title'] ?? '') ?>
            </p>
            <?php continue; ?>
          <?php endif; ?>
          <?= bio_render_link($link) ?>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Database Error or Fallback Warning Box -->
        <?php if (!empty($db_error)): ?>
          <div style="background: #FFF5F5; color: #D32F2F; padding: 20px; border: 2px solid var(--c-dark-charcoal); box-shadow: 0 6px 0 var(--c-dark-charcoal); font-size: 14px; margin-bottom: 20px; border-radius: 20px;">
            <strong style="text-transform: uppercase; font-size: 1.05rem; letter-spacing: 0.5px; display: block; margin-bottom: 5px; color: var(--c-primary);">⚠️ Hubungkan Database Bio</strong>
            <p class="mb-0"><?= bio_escape($db_error) ?></p>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>

    <!-- Rebranded Footer -->
    <footer class="text-center">
      &copy; <script>
        document.write(new Date().getFullYear())
      </script>
      SeutasTali.
      <p class="d-block mt-1">All rights reserved.</p>
    </footer>

  </div>
</div>

<?php include(ROOT_PATH . 'includes/script.php'); ?>

<!-- Splide.js CDN JS -->
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var splide = new Splide('.bio-main-card-carousel', {
      type: 'loop',
      arrows: false,
      pagination: true,
      autoplay: true,
      interval: 3500,
      pauseOnHover: true,
      gap: '10px'
    });
    splide.mount();
  });
</script>

<script>
  // Click tracking for bio links
  document.addEventListener('click', function(e) {
    const link = e.target.closest('.bio-link');
    if (link && link.dataset.linkId) {
      const linkId = link.dataset.linkId;

      // Update UI immediately (optional)
      const countEl = link.querySelector('.click-count-display');
      if (countEl) {
        let count = parseInt(countEl.textContent) || 0;
        countEl.textContent = count + 1;
      }

      // Send tracking hit to API
      fetch('<?= ASSETS_URL ?>../app/api/utils/tracker.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          id: linkId
        })
      }).catch(err => console.error('Click tracking error:', err));
    }
  });
</script>

</body>

</html>

<?php
if (isset($conn) && is_object($conn)) {
  $conn->close();
}
?>