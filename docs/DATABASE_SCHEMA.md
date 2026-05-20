# Database Schema (SaaS Seutastali)

Dokumen ini menjelaskan struktur basis data MySQL untuk platform **Seutastali** yang telah dirapikan menggunakan pengelompokan awalan (*prefixes*) sesuai kategori sistem dan mengadopsi standar terpadu dari proyek E-RSA.

---

## 1. Kategori: DEV / PLATFORM SYSTEM SETTINGS (`dev_`)
Tabel-tabel ini menyimpan konfigurasi global platform Seutastali untuk kebutuhan operasional admin serta fitur bio-link sistem.

### Tabel: `dev_banners`
* **id**: `int(11)` (Auto Increment, Primary Key) - ID unik banner.
* **image**: `varchar(255)` - Nama berkas gambar banner.
* **name**: `varchar(100)` - Judul banner.
* **category**: `varchar(50)` - Kategori banner (*populer, adat, minimalist, nature, flora*).
* **sort_order**: `int(11)` - Urutan sorting.
* **is_active**: `tinyint(1)` - Status aktif.

### Tabel: `dev_bio_links`
* **id**: `bigint(20)` (Auto Increment, Primary Key) - ID unik berkas link.
* **user_id**: `bigint(20)` (Foreign Key -> `users.id` ON DELETE CASCADE) - ID pemilik akun.
* **title**: `varchar(100)` - Judul/nama tautan (contoh: *Kunjungi Toko Kami*).
* **url**: `varchar(255)` - URL tujuan tautan.
* **icon**: `varchar(50)` - Icon FontAwesome (contoh: *fa-instagram*).
* **sort_order**: `int(11)` - Urutan tampilan tautan.
* **clicks**: `int(11)` - Penghitung statistik klik link.
* **created_at**: `timestamp` - Waktu pembuatan link.

### Tabel: `dev_faqs`
* **id**: `int(11)` (Auto Increment, Primary Key) - ID unik pertanyaan.
* **question**: `text` - Pertanyaan FAQ.
* **answer**: `text` - Jawaban FAQ.
* **sort_order**: `int(11)` - Urutan sorting FAQ.

### Tabel: `dev_system_settings`
* **id**: `int(11)` (Auto Increment, Primary Key) - ID unik setting.
* **config_key**: `varchar(100)` (Unique) - Kunci konfigurasi global (contoh: *maintenance_mode*, *site_name*).
* **config_value**: `text` - Nilai konfigurasi.
* **updated_at**: `timestamp` - Waktu pembaruan.

---

## 2. Kategori: USER / ACCOUNT SYSTEM (`user_` & `users`)
Tabel-tabel ini mengatur otentikasi, login, tokens terpadu, ulasan klien, dan sesi aktif dari pelanggan.

### Tabel: `users`
* **id**: `bigint(20)` (Auto Increment, Primary Key) - ID unik user.
* **name**: `varchar(255)` - Nama lengkap user.
* **email**: `varchar(255)` (Unique) - Email untuk login.
* **password**: `varchar(255)` - Password ter-hash.
* **google_id**: `varchar(255)` - ID login Google (opsional).
* **created_at**: `timestamp` - Tanggal mendaftar.

### Tabel: `user_sessions`
* **id**: `varchar(255)` (Primary Key) - ID sesi.
* **user_id**: `bigint(20)` (Foreign Key -> `users.id` ON DELETE SET NULL) - User pemilik sesi.
* **ip_address**: `varchar(45)` - IP address pengguna.
* **user_agent**: `text` - Browser user agent.
* **payload**: `longtext` - Data sesi ter-serialize.
* **last_activity**: `int(11)` - Aktivitas terakhir pengguna.

### Tabel: `user_testimonials`
* **id**: `bigint(20)` (Auto Increment, Primary Key) - ID unik testimoni.
* **user_id**: `bigint(20)` (Foreign Key -> `users.id` ON DELETE CASCADE) - ID user pemberi ulasan.
* **message**: `text` - Isi pesan testimoni.
* **rating**: `tinyint(4)` - Rating bintang (1 s.d. 5).
* **is_featured**: `tinyint(1)` - Ditampilkan sebagai testimoni unggulan di landing page (`0` atau `1`).
* **created_at**: `timestamp` - Tanggal pembuatan testimoni.

### Tabel: `user_tokens`
* **id**: `bigint(20)` (Auto Increment, Primary Key) - ID unik token.
* **user_id**: `bigint(20)` (Foreign Key -> `users.id` ON DELETE CASCADE) - ID user pemilik token.
* **token**: `varchar(255)` - Kode token unik ter-hash.
* **type**: `enum('remember_me', 'api', 'session', 'verification', 'reactivation')` - Jenis kegunaan token (Mengadopsi pola E-RSA untuk multi-kebutuhan).
* **expires_at**: `datetime` - Batas kedaluwarsa token.
* **created_at**: `timestamp` - Waktu penerbitan token.

---

## 3. Kategori: INVITATION SYSTEM (`invitation_` & `invitations`)
Tabel-tabel ini mengatur domain, subdomain, tema terpilih, konten pernikahan, RSVP, dan amplop digital milik pengantin.

### Tabel: `invitations`
* **id**: `bigint(20)` (Auto Increment, Primary Key) - ID unik undangan.
* **user_id**: `bigint(20)` (Foreign Key -> `users.id` ON DELETE CASCADE) - ID pelanggan pemilik.
* **subdomain**: `varchar(100)` (Unique) - Subdomain unik undangan (contoh: *miqdad-shafa*).
* **theme_folder**: `varchar(100)` - Nama folder tema undangan (contoh: *rustic*).
* **bride_name**: `varchar(100)` - Nama mempelai wanita.
* **groom_name**: `varchar(100)` - Nama mempelai pria.
* **event_date**: `date` - Tanggal pernikahan.
* **event_location**: `text` - Tempat / lokasi pernikahan.
* **music_url**: `varchar(255)` - Lokasi file audio latar.
* **cover_image**: `varchar(255)` - Gambar sampul utama undangan.
* **status**: `enum('active', 'inactive')` - Status aktif undangan.

### Tabel: `invitation_digital_envelopes`
* **id**: `bigint(20)` (Auto Increment, Primary Key) - ID unik kado.
* **invitation_id**: `bigint(20)` (Foreign Key -> `invitations.id` ON DELETE CASCADE) - ID undangan pemilik.
* **bank_name**: `varchar(50)` - Nama Bank / E-Wallet (contoh: *BCA*, *Mandiri*, *GoPay*).
* **account_number**: `varchar(50)` - Nomor rekening.
* **account_name**: `varchar(100)` - Nama pemilik rekening.

### Tabel: `invitation_gallery_images`
* **id**: `bigint(20)` (Auto Increment, Primary Key) - ID unik foto.
* **invitation_id**: `bigint(20)` (Foreign Key -> `invitations.id` ON DELETE CASCADE) - ID undangan pemilik.
* **image_path**: `varchar(255)` - Alamat berkas foto prewedding.

### Tabel: `invitation_rsvps`
* **id**: `bigint(20)` (Auto Increment, Primary Key) - ID unik RSVP.
* **invitation_id**: `bigint(20)` (Foreign Key -> `invitations.id` ON DELETE CASCADE) - ID undangan pemilik.
* **guest_name**: `varchar(100)` - Nama tamu undangan.
* **attendance**: `enum('yes', 'no', 'maybe')` - Status kehadiran tamu.
* **guest_count**: `int(11)` - Jumlah tamu yang akan dibawa.
* **message**: `text` - Ucapan selamat / doa dari tamu.
