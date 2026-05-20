<?php
/**
 * Refund Policy Page
 * Location: /refund-policy.php
 */

// Load bootstrap (centralized config loading)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Set page meta
$page_title = 'Kebijakan Pengembalian Dana - Seutastali';
$page_description = 'Kebijakan pembatalan dan pengembalian dana untuk produk digital Seutastali.';

ob_start();
?>

<!-- Page Header Section -->
<section class="position-relative mt-5 mt-lg-4">
    <div class="container position-relative z-3">

        <!-- Standardized Premium Section Header with Inline Breadcrumb on Right -->
        <div class="d-flex flex-column flex-md-row align-items-md-start justify-content-md-between gap-3 mb-3">

            <!-- Left-aligned Header Title -->
            <div class="section-header text-start mb-0 order-2 order-md-1">
                <h1 class="hero-title text-start ms-0" style="margin-left: 0 !important; margin-bottom: 0.5rem !important;">
                    Kebijakan <span class="text-primary fw-bold">Refund</span>
                </h1>
                <p class="ms-0 text-start mb-0" style="margin-left: 0 !important; max-width: 620px;">
                    Ketentuan Pembatalan Transaksi dan Pengembalian Dana di Seutastali
                </p>
            </div>

            <!-- Right-aligned Breadcrumb Navigation -->
            <nav aria-label="breadcrumb" class="mb-0 order-1 order-md-2 align-self-start align-self-md-start pt-md-2">
                <ol class="breadcrumb mb-0 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">
                    <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">Refund Policy</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Refund Content Section -->
<section class="pt-3 pb-5">
    <div class="container">

        <!-- Content Text -->
        <div class="content-text lh-lg text-dark mb-5">
            <h4 class="fw-bold text-primary mb-3">1. Kebijakan Pembatalan & Pengembalian Dana</h4>
            <p class="mb-4">Karena seluruh produk template undangan digital kami dikirimkan secara instan dan langsung aktif setelah transaksi berhasil, <strong>semua penjualan bersifat final</strong>. Ketentuan ini berlaku untuk seluruh jenis transaksi menggunakan Rupiah (IDR) maupun mata uang lainnya.</p>
            <p class="mb-4">Setelah akses edit template undangan telah dikirimkan ke email atau akun Anda, kami <strong>tidak menawarkan pengembalian dana (refund), pembatalan transaksi, atau penukaran produk dengan alasan apa pun</strong>. Hal ini dikarenakan sifat produk digital yang tidak dapat ditarik kembali setelah dikirimkan ke pelanggan.</p>

            <hr class="my-4 opacity-10">

            <h4 class="fw-bold text-primary mb-3">2. "Bagaimana jika saya tidak sengaja membeli template yang salah?"</h4>
            <p class="mb-4">Kami sangat memahami bahwa kesalahan pemilihan desain dapat terjadi saat proses pembelian cepat. Namun, karena template kami dikirimkan secara instan dan bersifat produk digital utuh, <strong>kami tidak dapat melayani penukaran desain atau penggantian template setelah transaksi diselesaikan secara lunas</strong>.</p>
            <p class="mb-4">Kami sangat menyarankan dan mengimbau Anda untuk meninjau secara saksama detail template, tampilan demo, dan fitur yang disertakan pada deskripsi produk sebelum Anda melakukan checkout pembayaran. Jika Anda memiliki keraguan atau pertanyaan seputar template sebelum membeli, silakan hubungi tim layanan pelanggan kami terlebih dahulu—kami dengan senang hati siap membantu menjawab segala pertanyaan Anda.</p>

            <hr class="my-4 opacity-10">

            <h4 class="fw-bold text-primary mb-3">3. Layanan Dukungan Teknis (Support)</h4>
            <p class="mb-4">Jika Anda mengalami kendala teknis dalam mengakses tautan template, kegagalan loading halaman edit, atau kendala otorisasi sistem setelah transaksi berhasil, mohon untuk segera menghubungi kami melalui email resmi di <a href="mailto:hello@seutastali.id" class="text-decoration-underline fw-semibold">hello@seutastali.id</a> atau melalui kontak WhatsApp dukungan pelanggan kami.</p>
            <p class="mb-4">Kami berkomitmen penuh untuk mendampingi Anda hingga berhasil mengakses pembelian Anda dan akan melakukan segala upaya teknis terbaik yang wajar untuk menyelesaikan masalah operasional tersebut secepat mungkin.</p>

            <hr class="my-4 opacity-10">

            <p class="text-muted small">Kebijakan Pengembalian Dana ini terakhir diperbarui pada 17 Mei 2026 dan berlaku mutlak untuk seluruh transaksi di platform Seutastali.</p>
        </div>

    </div>
</section>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>
