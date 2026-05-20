<?php
/**
 * WebP Image Helper with Fallback
 * Generates <picture> tag with WebP and fallback to original format
 */

function webp_img($src, $alt = '', $class = '', $loading = 'lazy') {
    $assets_url = defined('ASSETS_URL') ? ASSETS_URL : '/assets/';
    $full_path = ROOT_PATH . 'assets/media/' . ltrim($src, '/');
    
    // Check if original file exists
    if (!file_exists($full_path)) {
        return '<!-- Image not found: ' . htmlspecialchars($src) . ' -->';
    }
    
    $path_info = pathinfo($full_path);
    $extension = strtolower($path_info['extension']);
    $webp_path = $path_info['dirname'] . '/' . $path_info['filename'] . '.webp';
    $webp_src = str_replace($extension, 'webp', $src);
    
    // Get dimensions for aspect ratio
    $dimensions = '';
    if (function_exists('getimagesize')) {
        $size = @getimagesize($full_path);
        if ($size) {
            $dimensions = ' width="' . $size[0] . '" height="' . $size[1] . '"';
        }
    }
    
    $class_attr = $class ? ' class="' . htmlspecialchars($class) . '"' : '';
    $loading_attr = $loading ? ' loading="' . htmlspecialchars($loading) . '"' : '';
    
    // Generate picture tag with WebP support
    $html = '<picture>' . "\n";
    
    // WebP source (if exists)
    if (file_exists($webp_path)) {
        $html .= '  <source type="image/webp" srcset="' . $assets_url . 'media/' . $webp_src . '">' . "\n";
    }
    
    // Fallback to original
    $html .= '  <img src="' . $assets_url . 'media/' . $src . '" alt="' . htmlspecialchars($alt) . '"' . $class_attr . $dimensions . $loading_attr . '>' . "\n";
    $html .= '</picture>';
    
    return $html;
}

/**
 * Simple WebP img tag (for when picture tag is overkill)
 */
function webp_img_simple($src, $alt = '', $class = '', $loading = 'lazy') {
    $assets_url = defined('ASSETS_URL') ? ASSETS_URL : '/assets/';
    $webp_src = str_replace(['.jpg', '.png'], '.webp', $src);
    
    $class_attr = $class ? ' class="' . htmlspecialchars($class) . '"' : '';
    $loading_attr = $loading ? ' loading="' . htmlspecialchars($loading) . '"' : '';
    
    // Use WebP if available, otherwise fallback
    $img_src = file_exists(ROOT_PATH . 'assets/media/' . $webp_src) ? $webp_src : $src;
    
    return '<img src="' . $assets_url . 'media/' . $img_src . '" alt="' . htmlspecialchars($alt) . '"' . $class_attr . $loading_attr . '>';
}
?>
