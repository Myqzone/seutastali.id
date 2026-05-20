<?php
// Load bootstrap (centralized config loading)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Set page meta
$page_title = 'About Us - SeutasTali';
$page_description = 'Pelajari lebih lanjut tentang SeutasTali dan visi misi kami sebagai platform undangan digital premium.';

ob_start();
?>

  <section class="position-relative py-5 mt-3">
    <div class="container position-relative z-3">

      <!-- Page Header -->
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="fw-bold"><span class="text-primary">About</span> Us</h2>
          <p class="text-muted">Pelajari lebih lanjut tentang SeutasTali dan visi misi kami</p>
        </div>
      </div>

      <!-- Content Content -->
      <div class="mb-5">
        <h4 class="fw-bold mb-3">Teman Terpercaya Momen Bahagiamu</h4>
        <p class="mb-4 lh-lg">
          SeutasTali hadir sebagai platform pembuatan undangan digital profesional yang elegan, praktis, dan berkesan untuk momen istimewa Anda. Kami percaya bahwa setiap kisah cinta memiliki untaian cerita unik yang layak dibagikan dengan indah.
        </p>
        <p class="mb-0 lh-lg">
          Dengan teknologi modern dan desain editorial eksklusif, kami memastikan kabar bahagia Anda tersampaikan dengan sempurna kepada keluarga, sahabat, dan kerabat tercinta di mana pun mereka berada.
        </p>
      </div>

    </div>
  </section>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>
