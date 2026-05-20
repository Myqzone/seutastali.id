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
$page_title = 'Kebijakan Pengembalian Dana - SeutasTali';
$page_description = 'Kebijakan pembatalan dan pengembalian dana untuk produk digital SeutasTali.';

ob_start();
?>

<section class="position-relative py-5 mt-3">
    <div class="container position-relative z-3">

        <!-- Page Header -->
        <div class="mb-5">
            <h2 class="fw-bold mb-2"><span class="text-primary">Kebijakan Pengembalian Dana</span></h2>
            <p class="text-muted">Ketentuan Pembatalan Transaksi dan Pengembalian Dana di SeutasTali</p>
        </div>

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

            <p class="text-muted small">Kebijakan Pengembalian Dana ini terakhir diperbarui pada 17 Mei 2026 dan berlaku mutlak untuk seluruh transaksi di platform SeutasTali.</p>
        </div>

    </div>
</section>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>
