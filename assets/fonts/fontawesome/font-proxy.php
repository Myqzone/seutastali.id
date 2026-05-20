<?php
// Font proxy with CORS headers
$fontFile = $_GET['font'] ?? '';
$allowedFonts = [
    'fa-brands-400.woff2',
    'fa-brands-400.ttf',
    'fa-solid-900.woff2',
    'fa-solid-900.ttf',
    'fa-regular-400.woff2',
    'fa-regular-400.ttf',
    'fa-v4compatibility.woff2',
    'fa-v4compatibility.ttf'
];

if (!in_array($fontFile, $allowedFonts)) {
    http_response_code(404);
    exit;
}

$fontPath = __DIR__ . '/' . $fontFile;
if (!file_exists($fontPath)) {
    http_response_code(404);
    exit;
}

// Set CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, HEAD, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Max-Age: 86400');

// Set proper content type
$ext = pathinfo($fontFile, PATHINFO_EXTENSION);
switch ($ext) {
    case 'woff2':
        header('Content-Type: application/font-woff2');
        break;
    case 'woff':
        header('Content-Type: application/font-woff');
        break;
    case 'ttf':
        header('Content-Type: font/ttf');
        break;
    case 'eot':
        header('Content-Type: application/vnd.ms-fontobject');
        break;
}

// Cache headers
header('Cache-Control: public, max-age=31536000, immutable');
header('ETag: "' . md5_file($fontPath) . '"');

// Handle pre-flight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Output font file
readfile($fontPath);
?>
