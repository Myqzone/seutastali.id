<?php

/**
 * Page-Specific JS/CSS Loader Helper
 * 
 * Usage:
 * - Load single page: $extraScript = loadPageJS('dashboard-analytics');
 * - Load multiple pages: $extraScript = loadPageJS(['dashboard-analytics', 'charts-chartjs']);
 * - Load with callback: $extraScript = loadPageJS('dashboard-analytics', true);
 */

if (!function_exists('loadPageJS')) {
    /**
     * Generate script tags for lazy-loading page-specific JS files
     * 
     * @param string|array $pageNames Page script name(s) without .js extension
     * @param bool $withCallback Add callback function for page initialization
     * @return string HTML script tags
     */
    function loadPageJS($pageNames, $withCallback = false)
    {
        if (!is_array($pageNames)) {
            $pageNames = [$pageNames];
        }

        $assetBase = defined('ASSETS_URL') ? ASSETS_URL : '/assets';
        $html = '';

        foreach ($pageNames as $pageName) {
            $pageName = basename($pageName, '.js'); // Sanitize input
            $html .= sprintf(
                '<script src="%s/js/app/pages/%s.js" async></script>',
                rtrim($assetBase, '/'),
                $pageName
            );
        }

        if ($withCallback) {
            $html .= '<script>
  // Call page initialization if function exists
  document.addEventListener("DOMContentLoaded", function() {
    if (typeof pageInitialize === "function") {
      pageInitialize();
    }
  });
</script>';
        }

        return $html;
    }
}

if (!function_exists('loadPageCSS')) {
    /**
     * Generate link tags for page-specific CSS files
     * 
     * @param string|array $pageNames Page CSS name(s) without .css extension
     * @return string HTML link tags
     */
    function loadPageCSS($pageNames)
    {
        if (!is_array($pageNames)) {
            $pageNames = [$pageNames];
        }

        $assetBase = defined('ASSETS_URL') ? ASSETS_URL : '/assets';
        $html = '';

        foreach ($pageNames as $pageName) {
            $pageName = basename($pageName, '.css'); // Sanitize input
            $html .= sprintf(
                '<link rel="stylesheet" href="%s/css/app/pages/%s.css">',
                rtrim($assetBase, '/'),
                $pageName
            );
        }

        return $html;
    }
}

if (!function_exists('loadPageAssets')) {
    /**
     * Load both JS and CSS for a page
     * 
     * @param string|array $pageNames Page name(s)
     * @param string $type 'js', 'css', or 'both' (default: 'both')
     * @return string HTML tags
     */
    function loadPageAssets($pageNames, $type = 'both')
    {
        $html = '';

        if (in_array($type, ['js', 'both'])) {
            $html .= loadPageJS($pageNames);
        }

        if (in_array($type, ['css', 'both'])) {
            $html .= loadPageCSS($pageNames);
        }

        return $html;
    }
}
