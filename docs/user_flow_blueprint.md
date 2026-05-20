# Seutastali.id: Ringkasan Alur Pengguna & Validasi (User Flow Blueprint)

## 🏛️ Pembagian Domain

| Domain | Fungsi Utama | Sesi & Auth |
| :--- | :--- | :--- |
| **`seutastali.id`** (Utama) | Katalog, Pricing, Checkout, Invoice (`payment.php`) | Baca token draf dari URL. |
| **`app.seutastali.id`** (SaaS) | Sandbox Editor, `onboarding.php`, Dashboard | JWT Cookie `.seutastali.id` (HTTP-Only). |
| **`[nama].seutastali.id`** (Klien) | Undangan aktif milik klien (tamu pembaca) | Tanpa session / Tanpa login. |

### Aturan Auth Middleware (`app.seutastali.id`):
*   **Belum login/dikenal / akses root subdomain tanpa path** $\rightarrow$ Otomatis di-redirect ke `app.seutastali.id/login` (Halaman login berisi link daftar yang mengarah ke `seutastali.id/templates.php`).
*   **Sudah bayar, belum melengkapi data** $\rightarrow$ Redirect ke `onboarding.php?token=[token]`.
*   **Sudah login & melengkapi data** $\rightarrow$ Redirect ke Dashboard Klien.

---

## 🗺️ Peta Alur Perjalanan Pengguna (User Journey)

`Templates.php` ➔ `Sandbox Editor` ➔ `Simpan Draf (Nama + Email)` ➔ `Pricing.php` ➔ `Checkout.php` ➔ `Payment.php (Midtrans)` ➔ `Onboarding.php` ➔ `Dashboard`

### 🔄 Mekanisme Pendeteksian & Pergantian Paket (State Retention)

Untuk meminimalisir gesekan (*friction*) dan memastikan pilihan paket pengguna tidak hilang di tengah jalan:

1. **Alur Deteksi Paket dari Awal (Pricing ➔ Templates ➔ Sandbox):**
   * Pengguna memilih paket (misal: **Eksklusif**) pada `pricing.php` saat belum memiliki draf $\rightarrow$ Dialihkan ke `templates.php?package=Eksklusif`.
   * Pada halaman katalog (`templates.php`):
     * Klik gambar/judul membuka demo biasa: `/design/[slug]/?preview=1&package=Eksklusif` (hanya melihat-lihat, editor tertutup).
     * Klik tombol **"Coba Template"** membuka mode sandbox: `/design/[slug]/?edit=1&package=Eksklusif` (editor langsung terbuka/aktif).
   * Ketika tombol *"Simpan"* diklik di Sandbox Editor, formulir pendaftaran nama & email akan memicu penyimpanan draf ke database.
   * **Pengalihan Otomatis:**
     * **Jika ada pilihan paket sebelumnya:** Setelah sukses simpan draf, pengguna langsung dilempar ke `checkout.php?token=[token]&package=Eksklusif` (tidak perlu memilih paket ulang).
     * **Jika tidak ada pilihan paket sebelumnya:** Pengguna dilempar ke halaman pemilihan paket `pricing.php?token=[token]`.

2. **Pergantian Paket Pasca Masuk Template / Halaman Checkout:**
   * Di Sandbox Editor, pengguna fokus mencoba desain (akses sandbox bersifat gratis dan memiliki fitur yang sama untuk uji coba). Pilihan paket tidak perlu dikunci di dalam editor.
   * Pada halaman **`checkout.php`**, ditampilkan ringkasan pembelian beserta tombol **"Ganti Paket"**.
   * Jika pengguna ingin mengubah paket $\rightarrow$ Klik **"Ganti Paket"** $\rightarrow$ Dialihkan ke `pricing.php?token=[token]`.
   * Setelah memilih paket baru di halaman pricing, pengguna dikembalikan langsung ke `checkout.php?token=[token]&package=[paket_baru]`.
    * **Keamanan Data:** Seluruh perubahan pilihan paket di atas tidak akan menghapus data mempelai yang telah diinput di editor, karena data terikat aman pada `token` draf yang tersimpan di database.

3. **Siklus Hidup & Pembersihan Draf (Draft Lifecycle):**
   * **Masa Simpan Draf:** Draf undangan yang belum dibayar (tidak dilanjutkan ke tahap aktif) akan disimpan di database selama **30 hari** sejak pembuatan (`created_at`). Ini memberikan kesempatan jika pengguna ingin kembali melengkapi data di lain hari.
   * **Pembersihan Otomatis (Auto-Delete):** Sistem menjalankan tugas terjadwal harian (*cron job*) untuk menghapus draf usang yang berusia lebih dari 30 hari guna mencegah membengkaknya ukuran database.
    * **Pasca Pembayaran:** Draf yang berhasil dibayar akan didelete dari tabel `invitation_drafts` setelah datanya sukses diimpor menjadi data undangan aktif di tabel `invitations`.

### 🏷️ Neubrutalist Floating Journey Tracker (Balon Penunjuk Alur)

Untuk membimbing pengguna selama proses persiapan sebelum pembayaran, sebuah komponen penunjuk langkah melayang (*floating progress guide*) diaktifkan di halaman `pricing.php`, `templates.php`, dan di dalam Sandbox Editor:

*   **Tampilan Visual:** Balon melayang neubrutalist di kanan bawah (atau atas tengah mobile) berisi indikator 3 langkah:
    `[ ] Paket` ➔ `[ ] Desain` ➔ `[ ] Simpan Draf`
*   **Logika Centang Otomatis:**
    *   **Pilih Paket:** Centang `[✓] Paket: [Nama Paket]` menyala jika URL/Session mendeteksi parameter `?package=`.
    *   **Pilih Desain:** Centang `[✓] Desain: [Nama Desain]` menyala jika pengguna sudah masuk ke dalam halaman contoh/sandbox `/design/[slug]/`.
    *   **Simpan Draf:** Centang `[✓] Draf Tersimpan` menyala sesaat setelah mengisi formulir nama & email dan berhasil disimpan ke database.
*   **Mekanisme Sembunyi (Hidden) & Transisi Checkout:**
    *   Begitu draf sukses disimpan dan pengguna berpindah ke halaman **`checkout.php`** dan **`payment.php`**, balon pelacak melayang ini **disembunyikan sepenuhnya (hidden)** agar tidak mengganggu fokus pembayaran.
    *   Informasi pilihan pengguna beralih seutuhnya secara transparan ke dalam antarmuka ringkasan pembayaran asli di halaman checkout.

---

## 🎯 Validasi Input & Tombol Aksi

### 1. Modal "Amankan Hasil Rancangan" (Sandbox Editor)
*   **Kolom Input:**
    *   `Nama`: Wajib diisi (min. 3 huruf).
    *   `Email`: Wajib (Format email valid, tanpa verifikasi OTP untuk mencegah drop-off).
*   **Validasi & Error:**
    *   *Email duplikat:* Munculkan pesan error *"Email sudah terdaftar. Silakan login."*
    *   *Koneksi gagal:* Tampilkan status loading spinner + tombol *"Coba Lagi"* (Retry).

### 2. Halaman Checkout (`checkout.php`)
*   **Informasi Pembelian (Darat dari Draf):**
    *   `Paket Utama`: Nama paket dan harga dasar (Contoh: Eksklusif - Rp 249.000).
    *   `Pilihan Desain`: Thumbnail/Nama template yang digunakan (Contoh: Syakira).
    *   `Data Mempelai`: Ringkasan nama pengantin dan tanggal pernikahan.
    *   *Aksi Ganti:* Terdapat tautan/tombol **"Ganti Paket"** yang mengembalikan ke `pricing.php?token=[token]`.
*   **Pilihan Add-on (Fitur Tambahan):**
    *   Checkbox opsi tambahan (Contoh: *Custom Domain pribadi* +Rp 99.000, *Kuota Galeri Tambahan* +Rp 29.000) yang dinamis menambahkan total tagihan.
*   **Kolom Input:**
    *   `Kupon Diskon`: Opsional (Contoh: `SEUTASTALI50` diskon 50%).
    *   `Metode Pembayaran`: Wajib pilih salah satu (QRIS / Bank VA / Kartu).
*   **Tombol Aksi:**
    *   **"Buat Pesanan"** $\rightarrow$ Menyimpan transaksi ke database $\rightarrow$ Mengalihkan pengguna ke halaman `payment.php?order_id=INV-XXXXXX`.

### 3. Halaman Invoice & Pembayaran (`payment.php`)
*   **Tampilan Visual:**
    *   Informasi pilihan paket, add-on yang dipilih, serta ringkasan total bayar.
    *   Badge status warna oranye: **"Menunggu Pembayaran"**.
    *   Nomor Invoice: `Invoice #[6 Digit Kode]` (Contoh: `#064679`).
    *   Countdown Timer (Batas waktu pembayaran 24 jam).
*   **Mekanisme Pembayaran (Midtrans SNAP):**
    *   Tombol **"Lanjut Bayar"** (atau **"Bayar Sekarang"**) $\rightarrow$ Membuka pop-up **Midtrans SNAP** langsung di atas halaman `payment.php` (tanpa redirect keluar website).
    *   *Sukses Bayar:* Setelah pembayaran terkonfirmasi oleh Midtrans, halaman otomatis dialihkan ke langkah onboarding `onboarding.php?token=[token]`.
    *   *Pending / Tertunda:* Sediakan tombol manual *"Cek Status Pembayaran"* untuk verifikasi instan.

### 4. Langkah Onboarding (`onboarding.php`)
*   **Step 1: Undangan (Wajib)**
    *   `Subdomain URL`: Wajib. Cek ketersediaan real-time via AJAX (Error jika terpakai $\rightarrow$ matikan tombol + rekomendasi nama alternatif).
    *   `Tanggal Acara`: Wajib (Format tanggal di masa depan).
    *   `Progress Persiapan`: Dropdown $\rightarrow$ Mengubah opsi memicu **Pop-up Motivasi Dinamis** (Neubrutalism modal).
    *   **Tombol**: **"Lanjut ke Detail Acara"** (Aktif jika semua input valid).
*   **Step 2: Acara (Opsional)**
    *   `Gedung`, `Alamat`, `Kota`, `Tamu`: Opsional (Boleh kosong).
    *   `Leaflet Map`: Otomatis render peta jika alamat terisi. Jika kosong, peta disembunyikan.
    *   **Tombol Dinamis**:
        *   *Jika semua kolom kosong:* Tombol berlabel **"Lewati & Lanjut"** (Outline/Secondary).
        *   *Jika ada minimal 1 terisi:* Tombol otomatis berubah jadi **"Lanjut ke Setup Akun"** (Solid/Primary).
*   **Step 3: Setup Akun (Pengamanan)**
    *   `Email`: Terkunci (*Readonly/Disabled*).
    *   `Password` & `Konfirmasi`: Wajib (Min. 8 karakter kombinasi huruf & angka). Validasi kecocokan kedua kolom.
    *   **Tombol**: **"Aktifkan Undangan Saya"**.
*   **Step 4: Selesai**
    *   Centang sukses besar + redirect otomatis dalam 3 detik ke Dashboard.

---

## 📋 Tabel Skenario & Edge Cases

| Kondisi / Skenario | Hasil (Outcome) | Penanganan Sistem (Handling) |
| :--- | :--- | :--- |
| **Akses templates via Iklan/Navbar** | Cari desain | Diarahkan ke `templates.php`. |
| **Keluar sandbox tanpa save** | Peringatan hilang | Modal konfirmasi: *"Simpan draf sekarang?"* (Ya/Tidak). |
| **Email sudah terdaftar** | Gagal simpan | Tampilkan link *"Login di sini"* di form modal. |
| **Subdomain bentrok/terpakai** | Gagal lanjut | Beri saran nama (Contoh: `ahmad-wedding` / `ahmad-2026`). |
| **Bayar gagal / pending** | Bantuan transaksi | Sediakan tombol ganti metode & cek status pembayaran manual. |
| **Sesi onboarding terputus** | Data tersimpan | Auto-save per field. Klik link email $\rightarrow$ resume di langkah terakhir. |
| **Step 2 dikosongkan** | Lewati halaman | Klik tombol *"Lewati & Lanjut"* $\rightarrow$ simpan alamat kosong $\rightarrow$ Step 3. |
| **Password terlalu lemah** | Error validasi | Strength meter merah, tombol submit dinonaktifkan. |
| **Koneksi putus saat submit** | Retry otomatis | Tampilkan spinner *"Mencoba menyambungkan kembali (1/3)..."*. |
| **Akses via Handphone** | Tampilan mobile | Layout satu kolom vertikal, tombol menu tetap melayang di bawah screen. |
| **Akses pricing tanpa token** | Coba template dulu | Tombol "Pilih Paket" di `pricing.php` otomatis mengarahkan ke `templates.php`. |
| **Akses checkout langsung (tanpa token)** | Blokir akses | Guard check di `checkout.php` otomatis mengalihkan pengguna ke `templates.php`. |
| **Akses root subdomain `app.seutastali.id` (tanpa path)** | Proteksi halaman | Middleware mendeteksi status auth $\rightarrow$ otomatis redirect ke `app.seutastali.id/login`. |

---

## 🔑 Standar Format ID Sistem

Untuk menghubungkan seluruh data secara aman, efisien, dan mencegah penjelajahan ilegal, berikut standar format ID yang digunakan:

| Nama ID | Rekomendasi Format | Contoh Hasil | Alasan / Keunggulan |
| :--- | :--- | :--- | :--- |
| **`user_id`** | UUID v4 (36 karakter) | `f81d4fae-7dec-11d0-a765-00a0c91e6bf6` | Menyembunyikan total jumlah user dari kompetitor. |
| **`invitation_id`** | UUID v4 atau ULID | `01ARZ3NDEKTSV4RRFFQ69G5FAV` | Aman dan tidak bisa ditebak jika diakses via API. |
| **`draft_token`** | Prefix + Token Alphanumeric (24 karakter) | `draft_a7f9c2d8b4e10293` | Token acak panjang (bukan urutan) untuk keamanan URL draf. |
| **`order_id` / `invoice_id`** | `INV` + YYMMDD + Random (5-6 Digit) | `INV-260520-64679` | Format invoice profesional, mudah dicari oleh pembeli & admin. |
| **`template_slug`** | Slug String (Huruf kecil & strip) | `rustic-brown`, `floral-classic` | Sinkron dengan nama folder template di server (`design/rustic-brown`). |
| **`guest_id`** | Short Hash (6-8 karakter acak) | `g_x7R9K2` | Menjaga parameter URL undangan tamu tetap pendek dan estetik. |
| **`rsvp_id`** | Integer Auto Increment | `1`, `2`, `3` ... | Hanya dibaca internal di database. |
