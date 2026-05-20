<?php
/**
 * Privacy Policy Page
 * Location: /privacy-policy.php
 */

// Load bootstrap (centralized config loading)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Set page meta
$page_title = 'Kebijakan Privasi - Seutastali';
$page_description = 'Kebijakan privasi dan perlindungan data pribadi bagi pelanggan di Seutastali.';

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
                    Kebijakan <span class="text-primary fw-bold">Privasi</span>
                </h1>
                <p class="ms-0 text-start mb-0" style="margin-left: 0 !important; max-width: 620px;">
                    Kebijakan Perlindungan Data Pribadi dan Hak Kekayaan Intelektual Seutastali
                </p>
            </div>

            <!-- Right-aligned Breadcrumb Navigation -->
            <nav aria-label="breadcrumb" class="mb-0 order-1 order-md-2 align-self-start align-self-md-start pt-md-2">
                <ol class="breadcrumb mb-0 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">
                    <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">Privacy Policy</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Privacy Policy Content Section -->
<section class="pt-3 pb-5">
    <div class="container">

        <!-- Content Text -->
        <div class="content-text lh-lg text-dark mb-5">
            <p class="fw-medium mb-4">Seutastali berkomitmen penuh untuk melindungi privasi pelanggan dan menjaga keamanan data pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi Anda, serta hak cipta atas produk digital kami sesuai dengan regulasi hukum yang berlaku di Republik Indonesia.</p>

            <hr class="my-4 opacity-10">

            <h4 class="fw-bold mt-4 mb-3 text-primary">1. Perlindungan Hak Kekayaan Intelektual</h4>
            <p class="mb-3">Semua template, desain visual, layout, ilustrasi seni, dan aset digital lainnya yang ada di situs web Seutastali merupakan hak kekayaan intelektual eksklusif yang dilindungi secara ketat di bawah undang-undang berikut:</p>
            <ul class="ps-3 mb-4">
                <li class="mb-2"><strong>Undang-Undang Hak Cipta No. 28 Tahun 2014</strong> Republik Indonesia.</li>
                <li class="mb-2"><strong>Undang-Undang Informasi dan Transaksi Elektronik (UU ITE) No. 1 Tahun 2024</strong> (Perubahan atas UU No. 11 Tahun 2008).</li>
                <li class="mb-2"><strong>Undang-Undang Merek dan Indikasi Geografis No. 20 Tahun 2016</strong>.</li>
                <li class="mb-2">Traktat dan konvensi hak cipta internasional yang berlaku secara global.</li>
            </ul>
            <p class="mb-4">Setiap tindakan pembajakan, penyalinan tanpa izin, penjualan kembali, modifikasi tidak sah, pendistribusian ulang, rekayasa balik (reverse engineering), atau pembagian lisensi template secara ilegal baik di dalam negeri maupun internasional akan langsung ditindak secara hukum perdata (tuntutan ganti rugi materiil) dan pidana penjara serta penyitaan aset melalui aparat penegak hukum.</p>

            <h4 class="fw-bold mt-4 mb-3 text-primary">2. Informasi yang Kami Kumpulkan (Data Collection)</h4>
            <p class="mb-3">Kami hanya mengumpulkan data penting dan relevan yang mutlak diperlukan untuk keperluan transaksi, aktivasi akun, dan pemrosesan pesanan Anda:</p>
            <ul class="ps-3 mb-4">
                <li class="mb-2">Nama Lengkap</li>
                <li class="mb-2">Alamat Email Aktif</li>
                <li class="mb-2">Nomor WhatsApp Aktif (untuk keperluan notifikasi transaksi dan pengiriman data link)</li>
                <li class="mb-2">Data Informasi Pembayaran (diproses secara terenkripsi penuh oleh sistem payment gateway eksternal)</li>
                <li class="mb-2">Informasi Wilayah (untuk validasi mata uang, pembukuan pajak, dan kepatuhan transaksi)</li>
            </ul>

            <h4 class="fw-bold mt-4 mb-3 text-primary">3. Penggunaan Data Anda (Data Usage)</h4>
            <p class="mb-3">Data pribadi Anda digunakan secara ketat dan profesional hanya untuk keperluan:</p>
            <ul class="ps-3 mb-4">
                <li class="mb-2">Memproses transaksi pembayaran undangan digital Anda secara aman melalui payment gateway terverifikasi.</li>
                <li class="mb-2">Mengirimkan tautan template undangan digital yang telah Anda beli melalui email otomatis.</li>
                <li class="mb-2">Menyediakan layanan bantuan pelanggan (customer support) untuk menyelesaikan kendala teknis.</li>
                <li class="mb-2">Memenuhi kewajiban hukum perpajakan nasional, pelaporan keuangan, serta audit anti-penipuan (anti-fraud).</li>
            </ul>

            <h4 class="fw-bold mt-4 mb-3 text-primary">4. Keamanan Pembayaran (Payment Security)</h4>
            <ul class="ps-3 mb-4">
                <li class="mb-2">Semua transaksi pembayaran diproses secara aman menggunakan payment gateway resmi <strong>Midtrans</strong>.</li>
                <li class="mb-2">Midtrans mematuhi standar keamanan ketat berskala internasional seperti PCI-DSS, lisensi resmi Bank Indonesia (BI), dan regulasi keamanan transaksi elektronik nasional.</li>
                <li class="mb-2">Seutastali <strong>tidak pernah menyimpan atau melihat data kartu kredit, PIN, atau detail akun perbankan Anda</strong> pada server kami. Seluruh proses pembayaran dilakukan secara enkripsi SSL/TLS langsung ke server Midtrans.</li>
            </ul>

            <h4 class="fw-bold mt-4 mb-3 text-primary">5. Lisensi Penggunaan Template (Usage License)</h4>
            <ul class="ps-3 mb-4">
                <li class="mb-2">Setiap pembelian template memberikan Anda <strong>lisensi tunggal (single-use license)</strong> yang bersifat non-eksklusif dan tidak dapat dialihkan kepada orang lain.</li>
                <li class="mb-2">Template hanya diizinkan untuk digunakan pada <strong>satu (1) acara pernikahan pribadi atau acara privat satu kali pakai</strong>.</li>
                <li class="mb-2">Anda dilarang keras menjual kembali, mendistribusikan ulang, mensublisensikan, atau menggunakannya untuk tujuan komersial agensi atau untuk banyak acara/pasangan yang berbeda tanpa membeli lisensi baru.</li>
                <li class="mb-2">Segala bentuk pelanggaran pembagian lisensi secara ilegal (gratis maupun berbayar) akan langsung dibatalkan hak aksesnya tanpa pengembalian dana, dan diikuti dengan langkah hukum.</li>
            </ul>

            <h4 class="fw-bold mt-4 mb-3 text-primary">6. Ketentuan Pengiriman & Batasan Tanggung Jawab</h4>
            <ul class="ps-3 mb-4">
                <li class="mb-2"><strong>Sifat Produk Digital:</strong> Seluruh produk kami berupa barang digital tak berwujud (digital assets) yang dikirimkan secara instan melalui sistem online. Kami tidak pernah mengirimkan paket fisik ke alamat rumah Anda.</li>
                <li class="mb-2"><strong>Aktivasi Akses:</strong> Akses pengeditan template akan langsung diberikan secara instan setelah sistem pembayaran Midtrans menyatakan transaksi Anda berhasil secara lunas. Tautan akses dikirimkan langsung ke email atau WhatsApp Anda.</li>
                <li class="mb-2"><strong>Tanggung Jawab Pembeli:</strong> Pembeli bertanggung jawab memberikan alamat email dan nomor WhatsApp yang valid saat proses pembayaran. Kami tidak bertanggung jawab atas kegagalan pengiriman akibat salah ketik oleh pembeli. Pembeli juga wajib menjaga kerahasiaan link edit undangan pribadi mereka agar tidak disalahgunakan orang lain.</li>
                <li class="mb-2"><strong>Aktivitas Terlarang:</strong> Pembeli dilarang keras menyalin aset ilustrasi untuk keperluan di luar template Seutastali, menjual lisensi template kepada pihak lain, atau mengunggah ulang file desain ke platform publik manapun.</li>
                <li class="mb-2"><strong>Ketersediaan Layanan:</strong> Seutastali tidak bertanggung jawab atas gangguan operasional atau downtime sistem yang disebabkan oleh pihak ketiga (seperti pemeliharaan server cloud, pemadaman server database hosting pihak ketiga, atau gangguan jaringan ISP lokal).</li>
            </ul>

            <h4 class="fw-bold mt-4 mb-3 text-primary">7. Kebijakan Pengembalian Dana (Refund Policy Summary)</h4>
            <ul class="ps-3 mb-4">
                <li class="mb-2">Karena produk yang kami sediakan berupa aset digital yang langsung aktif dan dapat diunduh/diedit seketika, <strong>seluruh penjualan bersifat final dan tidak dapat dibatalkan atau dikembalikan (non-refundable)</strong>.</li>
                <li class="mb-2">Pembatalan pesanan, pengembalian dana, atau penukaran template tidak berlaku setelah tautan akses dikirimkan ke email Anda. Kebijakan lengkap dapat dibaca pada halaman <a href="refund-policy" class="text-decoration-underline fw-semibold">Kebijakan Pengembalian Dana</a> kami.</li>
            </ul>

            <h4 class="fw-bold mt-4 mb-3 text-primary">8. Hak Perlindungan Data Pribadi Anda (Data Privacy Rights)</h4>
            <p class="mb-3">Di bawah kepatuhan <strong>Undang-Undang Republik Indonesia No. 27 Tahun 2022 tentang Pelindungan Data Pribadi (UU PDP)</strong>, Anda memiliki hak penuh sebagai subjek data untuk:</p>
            <ul class="ps-3 mb-4">
                <li class="mb-2">Mendapatkan akses dan meminta salinan data pribadi Anda yang kami simpan.</li>
                <li class="mb-2">Meminta pembaruan atau koreksi jika terdapat kekeliruan data pribadi Anda.</li>
                <li class="mb-2">Meminta penghapusan atau pemusnahan data pribadi Anda dari sistem kami (Right to be Forgotten) dengan tetap tunduk pada aturan penyimpanan berkas transaksi wajib dari hukum perpajakan nasional.</li>
                <li class="mb-2">Membatasi atau mengajukan keberatan atas pemrosesan data tertentu yang dinilai tidak sesuai.</li>
            </ul>

            <hr class="my-4 opacity-10">

            <p class="text-muted small">Kebijakan Privasi ini terakhir diperbarui pada 17 Mei 2026 dan mengikat seluruh pengguna aktif situs Seutastali secara hukum.</p>
        </div>

    </div>
</section>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>