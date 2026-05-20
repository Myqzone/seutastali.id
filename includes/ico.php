<?php
// Define STATIC_URL if not already defined
if (!defined('STATIC_URL')) {
  if (!defined('ROOT_PATH')) {
    $root = realpath(__DIR__ . '/../..');
    define('ROOT_PATH', rtrim($root, '/\\') . DIRECTORY_SEPARATOR);
  }
  require_once ROOT_PATH . 'config/app.php';
}
?>
<link rel="icon" type="image/webp" href="/assets/media/logos/logo-mark.webp">
<link rel="apple-touch-icon" href="/assets/media/logos/logo-mark.webp">
<link rel="manifest" href="/assets/media/ico/manifest.json">
<meta name="msapplication-TileColor" content="#4d0c12">
<meta name="msapplication-TileImage" content="/assets/media/logos/logo-mark.webp">
<meta name="theme-color" content="#4d0c12">