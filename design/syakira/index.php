<?php
define('ROOT_PATH', '../../');
require_once ROOT_PATH . 'config/bootstrap.php';

// Fetch sample data for the preview
$groom_name = "Miqdad";
$bride_name = "Shafa";
$wedding_date = "2026-06-16 09:00:00";
$bg_music = "aesthetic-wedding.mp3";
$theme_color = "#f5ede4";

$date_timestamp = strtotime($wedding_date);
$days_id = [
  'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
  'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
];
$months_id = [
  'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
  'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
  'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
  'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
];

$formatted_date = ($days_id[date('l',$date_timestamp)] ?? date('l',$date_timestamp)) . ', ' . date('j',$date_timestamp) . ' ' . ($months_id[date('F',$date_timestamp)] ?? date('F',$date_timestamp)) . ' ' . date('Y',$date_timestamp);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Undangan Pernikahan: <?= $groom_name ?> & <?= $bride_name ?> - Seutastali</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Manrope:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>:root { --theme-bg: <?= $theme_color ?>; }</style>
  <link rel="stylesheet" href="assets/global.css">
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>

  <!-- Background Music & Floating Control Button Partial -->
  <?php include 'partials/music.php'; ?>

  <!-- Desktop Split Layout Wrapper -->
  <div class="container-fluid p-0">
    <div class="row g-0 min-vh-100">

      <!-- LEFT: Cover Art Background (visible only on desktop/tablet lg and up) -->
      <div class="d-none d-lg-flex desktop-left-panel">
        <img src="assets/ornament/846822_44710-O4E2ZR_1.png" class="desktop-bg-art" alt="Background Art">
        <div class="desktop-left-overlay">
          <p class="dl-label">The Wedding of</p>
          <h2 class="dl-names"><span id="desktop-groom-display"><?= $groom_name ?></span> <span class="dl-amp">&amp;</span> <span id="desktop-bride-display"><?= $bride_name ?></span></h2>
          <p class="dl-date" id="desktop-date-display"><?= $formatted_date ?></p>
        </div>
      </div>

      <!-- RIGHT: Invitation Panel (Fixed-width viewport of exactly 480px) -->
      <div class="col-12 p-0 d-flex align-items-stretch desktop-right-panel">
        <div class="invitation-shell">

          <!-- Dynamic Invitation Content Modular Include -->
          <?php include 'partials/content.php'; ?>

        </div><!-- /invitation-shell -->
      </div><!-- /col-lg-5 -->
    </div><!-- /row -->
  </div><!-- /container-fluid -->

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/main.js"></script>
  <script>initCountdown("<?= $wedding_date ?>");</script>

  <?php include ROOT_PATH . 'includes/sections/seutasbox.php'; ?>
  <?php include ROOT_PATH . 'includes/sections/security.php'; ?>


</body>
</html>