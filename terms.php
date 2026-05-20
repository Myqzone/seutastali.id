<?php
/**
 * Terms & Conditions Page
 * Location: /terms.php
 */

// Load bootstrap (centralized config loading)
require_once __DIR__ . '/config/bootstrap.php';

// Make $conn available globally
global $conn;

// Set page meta
$page_title = 'Syarat & Ketentuan - SeutasTali';
$page_description = 'Syarat dan ketentuan penggunaan layanan digital di SeutasTali.';

ob_start();
?>

<section class="position-relative py-5 mt-3">
    <div class="container position-relative z-3">

        <!-- Page Header -->
        <div class="mb-5">
            <h2 class="fw-bold mb-2"><span class="text-primary">Syarat & Ketentuan</span> Layanan</h2>
            <p class="text-muted">Syarat dan Ketentuan Penggunaan Layanan Pembuatan Undangan Digital SeutasTali</p>
        </div>

        <!-- Content Text -->
        <div class="content-text lh-lg text-dark mb-5">
            <p class="fw-medium mb-4">Selamat datang di SeutasTali. Syarat dan Ketentuan Layanan ini mengatur seluruh hak, kewajiban, dan ketentuan penggunaan platform pembuatan undangan digital premium kami. Dengan membeli atau menggunakan template kami, Anda menyatakan setuju secara sadar untuk terikat oleh seluruh poin di bawah ini.</p>

            <hr class="my-4 opacity-10">

            <h4 class="fw-bold mt-4 mb-3 text-primary">1. Batasan Hak Cipta & Penggunaan (Copyright & Usage Restrictions)</h4>
            <ul class="ps-3 mb-4">
                <li class="mb-2">Semua template undangan digital dilisensikan secara ketat hanya untuk <strong>penggunaan pribadi akhir (personal, end-use only)</strong>.</li>
                <li class="mb-2">Tindakan berikut <strong>sangat dilarang keras</strong>, bahkan setelah Anda melakukan pembelian sukses:
                    <ul class="ps-3 mt-2">
                        <li>Mengubah, merekayasa, atau mengerjakan ulang ilustrasi grafis dalam template.</li>
                        <li>Menghapus identitas merek (branding) atau tanda hak cipta (copyright marks) SeutasTali.</li>
                        <li>Mendistribusikan kembali, membagikan gratis, atau menjual kembali template.</li>
                        <li>Melakukan pelabelan putih (white-labeling) atau menjualnya kembali dengan nama brand Anda sendiri.</li>
                        <li>Menggunakan template untuk proyek pihak ketiga, klien agensi, atau tujuan komersial lainnya tanpa izin tertulis dari kami.</li>
                    </ul>
                </li>
                <li class="mb-2">Semua template dan desain di platform ini dilindungi secara hukum di bawah <strong>Undang-Undang Republik Indonesia No. 28 Tahun 2014 tentang Hak Cipta</strong> serta perlindungan perjanjian hak cipta internasional.</li>
                <li class="mb-2">Setiap penggunaan, perubahan, reproduksi, atau redistribusi tanpa izin tertulis yang sah akan diproses melalui tindakan hukum perdata maupun pidana.</li>
                <li class="mb-2">Pembelian template <strong>tidak memberikan hak kepemilikan intelektual</strong> atas desain tersebut, melainkan hanya memberikan izin hak pakai (lisensi penggunaan pribadi).</li>
            </ul>

            <h4 class="fw-bold mt-4 mb-3 text-primary">2. Fungsi Musik Latar Belakang (Background Music Functionality)</h4>
            <ul class="ps-3 mb-4">
                <li class="mb-2">Setiap musik latar belakang (background music) yang ditambahkan oleh pengguna <strong>tidak akan terputar secara otomatis (auto-play)</strong> secara default pada semua perangkat.</li>
                <li class="mb-2">Hal ini disebabkan oleh pembatasan keamanan dan kenyamanan pengguna dari sebagian besar browser modern (seperti Safari, Chrome, iOS Safari, dll.) yang memblokir audio otomatis tanpa interaksi pengguna.</li>
                <li class="mb-2">Musik baru akan diputar secara lancar <strong>hanya setelah tamu undangan melakukan interaksi fisik manual</strong> (mengklik tombol putar/buka undangan) yang disediakan pada template.</li>
                <li class="mb-2">SeutasTali tidak bertanggung jawab atau berkewajiban atas pembatasan teknis tingkat browser web yang membatasi pemutaran otomatis audio ini.</li>
                <li class="mb-2"><strong>Ketentuan Hukum Musik:</strong> Pengguna disarankan dan diwajibkan untuk hanya menambahkan musik yang bebas hak cipta (copyright-free) atau telah memiliki lisensi resmi. SeutasTali tidak memikul tanggung jawab hukum apa pun jika pengguna mengunggah karya musik tanpa hak cipta atau izin resmi dari pemilik hak cipta lagu bersangkutan.</li>
            </ul>

            <h4 class="fw-bold mt-4 mb-3 text-primary">3. Kustomisasi Struktural, Ketergantungan Platform & Lingkup Dukungan</h4>
            <p class="mb-3">Template SeutasTali beroperasi menggunakan teknologi web modern dan infrastruktur server pihak ketiga. Oleh karena itu, Anda memahami dan menyetujui bahwa:</p>
            <ul class="ps-3 mb-4">
                <li class="mb-2">Setiap kesalahan/glitch teknis yang bersumber dari kegagalan sistem pihak ketiga, penyedia server hosting, jaringan internet, maupun batasan perangkat keras pengguna berada di luar kendali dan tanggung jawab hukum SeutasTali.</li>
                <li class="mb-2">SeutasTali tidak bertanggung jawab atas masalah kegagalan tampilan undangan yang timbul akibat:
                    <ul class="ps-3 mt-2">
                        <li>Modifikasi struktural kode atau layout dasar yang dilakukan secara mandiri oleh klien.</li>
                        <li>Perubahan aspek teknis di luar batas kerangka kerja (framework) template default kami.</li>
                        <li>Pengeditan desain ekstrem di luar batas kontrol pengaturan yang telah disediakan.</li>
                        <li>Modifikasi yang melenceng dari petunjuk panduan penggunaan (tutorial) resmi kami.</li>
                    </ul>
                </li>
            </ul>

            <h5 class="fw-bold text-dark mb-2">Ruang Lingkup Dukungan Pelanggan (Support Scope)</h5>
            <p class="mb-3">Kami sangat berkomitmen penuh dalam membantu seluruh pelanggan kami. Namun, bantuan teknis diberikan dengan batasan yang wajar (best-effort basis):</p>
            <ul class="ps-3 mb-4">
                <li class="mb-2">Permintaan bantuan teknis yang berada di luar lingkup standar template kami (seperti modifikasi struktur khusus, integrasi sistem luar, atau perbaikan glitch platform eksternal) mungkin memerlukan waktu pengerjaan lebih lama, tidak selalu dapat diwujudkan, atau ditawarkan sebagai layanan kustom berbayar tambahan.</li>
                <li class="mb-2"><strong>Lingkungan Komunikasi yang Sehat:</strong> Klien diwajibkan berkomunikasi dengan sopan dan saling menghormati kepada tim dukungan SeutasTali. Jika terjadi komunikasi yang mengandung kekerasan verbal, kata-kata kasar/kasar, merendahkan, atau tidak pantas, SeutasTali berhak membatasi, menangguhkan, atau menghentikan dukungan layanan pelanggan Anda seketika. Pada tingkat pelanggaran ekstrem, kami berhak memblokir komunikasi Anda demi melindungi kenyamanan kerja tim kami.</li>
            </ul>

            <h5 class="fw-bold text-dark mb-2">Permintaan Kustomisasi Khusus (Custom Structural Requests)</h5>
            <ul class="ps-3 mb-4">
                <li class="mb-2">Setiap permintaan perubahan layout struktural template di luar contoh panduan akan diperlakukan sebagai permintaan khusus (Custom Request).</li>
                <li class="mb-2">Permintaan khusus ini akan dikenakan biaya tambahan jasa desain yang disepakati bersama, yang dibayarkan melalui tautan pembayaran khusus terpisah dari pembelian awal.</li>
                <li class="mb-2">Biaya tambahan tersebut <strong>hanya meliputi</strong> koreksi struktural dasar dan penyesuaian jarak tata letak (spacing). Biaya ini <strong>tidak mencakup</strong> pembuatan ulang grafis baru, pembuatan ilustrasi kustom, penambahan konten teks/gambar massal oleh tim kami, maupun pengerjaan desain kustom radikal lainnya.</li>
            </ul>

            <h5 class="fw-bold text-dark mb-2">Batasan Perbaikan Akibat Kesalahan Edit (Repair Limitations)</h5>
            <p class="mb-3">Jika pembeli mengubah atau mengedit template undangan hingga ke tahap rusak/kacau yang tidak dapat diperbaiki (broken layout), SeutasTali berhak untuk menolak perbaikan manual lebih lanjut dan menyarankan pembeli untuk melakukan reset/memulai kembali pengeditan dari versi template default awal.</p>

            <h4 class="fw-bold mt-4 mb-3 text-primary">4. Tidak Menyediakan Layanan Pengeditan Manual (No Editing Service)</h4>
            <ul class="ps-3 mb-4">
                <li class="mb-2">SeutasTali adalah platform berbasis <strong>Do-It-Yourself (DIY)</strong>. Kami <strong>tidak mengedit atau mengisi data template undangan</strong> atas nama pembeli dalam keadaan apa pun kecuali disetujui dalam paket kustom khusus.</li>
                <li class="mb-2">Seluruh proses penginputan data, penggantian teks, pengunggahan foto, dan pengaturan undangan sepenuhnya dilakukan sendiri oleh pembeli menggunakan tutorial video berdurasi singkat yang sangat praktis dan mudah dipahami.</li>
            </ul>

            <h4 class="fw-bold mt-4 mb-3 text-primary">5. Fitur & Pembaruan Sistem (Features & Updates)</h4>
            <ul class="ps-3 mb-4">
                <li class="mb-2">Template undangan digital kami mungkin mengalami sedikit variasi penempatan tombol atau tata letak fitur dibandingkan dengan apa yang terlihat pada video tutorial.</li>
                <li class="mb-2">Variasi ini terjadi karena adanya <strong>pembaruan sistem rutin dan peningkatan kualitas visual</strong> yang kami lakukan demi kepuasan pengguna.</li>
                <li class="mb-2">Adanya perubahan minor dari peningkatan kualitas ini tidak dapat dikategorikan sebagai cacat produk, kesalahan sistem, maupun dijadikan alasan hukum untuk sengketa atau pengembalian dana (refund).</li>
            </ul>

            <h4 class="fw-bold mt-4 mb-3 text-primary">6. Ketentuan Domain, Bandwidth & Watermark Merek</h4>
            <ul class="ps-3 mb-4">
                <li class="mb-2">Setiap peningkatan kapasitas penyimpanan (storage), biaya kelebihan batas kunjungan tamu (overage bandwidth), atau peningkatan fitur web hosting tambahan eksternal di luar paket standar merupakan tanggung jawab finansial Klien sepenuhnya.</li>
                <li class="mb-2">SeutasTali tidak bertanggung jawab atas pembatasan sepihak, kegagalan akses sementara, penangguhan sistem, atau pemeliharaan berkala (downtime) yang dipicu dari sisi infrastruktur jaringan cloud atau hosting pihak ketiga.</li>
                <li class="mb-2">Biaya untuk pembelian, konfigurasi, integrasi, maupun perpanjangan nama domain kustom (custom domain seperti: *namakamu.com*) tidak termasuk dalam biaya pembelian template dasar SeutasTali dan menjadi tanggung jawab finansial Klien masing-masing.</li>
                <li class="mb-2">Adanya <strong>Watermark / Tanda Pengenal merek SeutasTali</strong> di bagian footer halaman undangan merupakan bagian dari perlindungan hak cipta kekayaan intelektual kami. Klien sangat dilarang keras untuk menghapus, memodifikasi, menyamarkan, atau menyembunyikan identitas watermark ini dengan metode apa pun (termasuk manipulasi kode CSS/JS). Tindakan penghapusan watermark secara ilegal merupakan pelanggaran serius atas Syarat Ketentuan ini.</li>
            </ul>

            <hr class="my-4 opacity-10">

            <p class="text-muted small">Syarat & Ketentuan Layanan ini terakhir diperbarui pada 17 Mei 2026 dan berlaku seketika bagi seluruh pembeli dan pengguna aktif SeutasTali.</p>
        </div>

    </div>
</section>

<?php
$content = ob_get_clean();
include ROOT_PATH . 'includes/layouts/app.php';
?>