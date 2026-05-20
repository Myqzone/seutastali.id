<?php

/**
 * Web Routes (routes/web.php)
 * Centralized page metadata for all landing page routes
 * 
 * Usage:
 *   $page = require ROOT_PATH . 'config/routes/web.php';
 *   $meta = $page['about'] ?? $page['home'];
 */

return [
    'home' => [
        'title' => 'Klinik Samiaji - Tumbuh Kembang Anak Bandung',
        'description' => 'Klinik Samiaji hadir sebagai pusat tumbuh kembang anak di bandung yang menjadi teman tumbuh bagi setiap anak.',
        'bodyClass' => 'desktop',
    ],
    'about' => [
        'title' => 'About Us - Klinik Samiaji',
        'description' => 'Klinik Samiaji hadir sebagai pusat tumbuh kembang anak di bandung yang menjadi teman tumbuh bagi setiap anak.',
    ],
    'contact' => [
        'title' => 'Contact Us - Klinik Samiaji',
        'description' => 'Hubungi Klinik Samiaji untuk pertanyaan seputar layanan tumbuh kembang anak di bandung.',
    ],
    'services' => [
        'title' => 'Services - Klinik Samiaji',
        'description' => 'Layanan kesehatan dan tumbuh kembang anak di Klinik Samiaji Bandung.',
    ],
    'team' => [
        'title' => 'Our Team - Klinik Samiaji',
        'description' => 'Tim profesional Klinik Samiaji yang berdedikasi untuk tumbuh kembang anak.',
    ],
    'news' => [
        'title' => 'News - Klinik Samiaji',
        'description' => 'Berita dan informasi terbaru dari Klinik Samiaji.',
    ],
    'careers' => [
        'title' => 'Careers - Klinik Samiaji',
        'description' => 'Bergabunglah dengan tim Klinik Samiaji dan wujudkan misi kami bersama.',
    ],
    'cookies' => [
        'title' => 'Cookie Policy - Klinik Samiaji',
        'description' => 'Kebijakan penggunaan cookie di website Klinik Samiaji - Pusat tumbuh kembang anak di bandung.',
    ],
    'privacy-policy' => [
        'title' => 'Privacy Policy - Klinik Samiaji',
        'description' => 'Kebijakan privasi dan perlindungan data bagi pasien dan keluarga di Klinik Samiaji - Pusat tumbuh kembang anak di bandung.',
    ],
    'terms' => [
        'title' => 'Terms & Conditions - Klinik Samiaji',
        'description' => 'Syarat dan ketentuan penggunaan layanan di Klinik Samiaji - Pusat tumbuh kembang anak di bandung.',
    ],
];
