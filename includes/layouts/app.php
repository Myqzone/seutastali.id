<?php
/**
 * ============================================================
 * SEUTASTALI GLOBAL MASTER LAYOUT
 * ============================================================
 */

// Ensure ROOT_PATH and dynamic helper paths are set
if (!defined('ROOT_PATH')) {
    $root = realpath(__DIR__ . '/../../');
    define('ROOT_PATH', rtrim($root, '/\\') . DIRECTORY_SEPARATOR);
}

// Prevent undefined variable lint warnings in IDE static analysis
if (!isset($content)) {
    $content = '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Include Global Head -->
    <?php include ROOT_PATH . 'includes/head.php'; ?>
    
    <!-- Render page-specific custom CSS if injected -->
    <?php if (isset($extra_css)) echo $extra_css; ?>
</head>
<body>

    <!-- Include Global Navbar -->
    <?php include ROOT_PATH . 'includes/navbar.php'; ?>

    <!-- Render Dynamic Page Content -->
    <div class="page-wrapper overflow-hidden">
        <?= $content ?>
    </div>

    <!-- Include Global Footer -->
    <?php include ROOT_PATH . 'includes/footer.php'; ?>

    <!-- Include Global Action Floating Button if exists -->
    <?php 
    if (file_exists(ROOT_PATH . 'includes/btn-action.php')) {
        include ROOT_PATH . 'includes/btn-action.php';
    }
    ?>

    <!-- Include Global Scripts -->
    <?php include ROOT_PATH . 'includes/script.php'; ?>

    <!-- Render page-specific custom JS if injected -->
    <?php if (isset($extra_js)) echo $extra_js; ?>

</body>
</html>
<?php 
// Safely auto-close database connection if it exists and is active
if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
    @$conn->close();
}
?>
