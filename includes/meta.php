<?php
// Primary Meta Tags
$meta_title = isset($page_title) ? $page_title . ' - ' . $site_title : $site_title;
$meta_desc = isset($page_description) ? $page_description : $site_description;
?>
<meta name="title" content="<?= htmlspecialchars($meta_title, ENT_QUOTES, 'UTF-8') ?>">
<meta name="description" content="<?= htmlspecialchars($meta_desc, ENT_QUOTES, 'UTF-8') ?>">
<meta name="keywords" content="<?= htmlspecialchars($site_keywords, ENT_QUOTES, 'UTF-8') ?>">
<meta name="theme-color" content="#500701">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?= STATIC_URL ?>">
<meta property="og:title" content="<?= htmlspecialchars($meta_title, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:description" content="<?= htmlspecialchars($meta_desc, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:image" content="<?= ASSETS_URL ?>media/utility/metatag.png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="1200">
<meta property="og:site_name" content="<?= htmlspecialchars($site_title, ENT_QUOTES, 'UTF-8') ?>">

<!-- Twitter -->
<meta property="twitter:url" content="<?= STATIC_URL ?>">
<meta property="twitter:title" content="<?= htmlspecialchars($meta_title, ENT_QUOTES, 'UTF-8') ?>">
<meta property="twitter:description" content="<?= htmlspecialchars($meta_desc, ENT_QUOTES, 'UTF-8') ?>">
