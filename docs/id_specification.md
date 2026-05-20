# Standar Spesifikasi Format ID SeutasTali
Dokumen ini menetapkan standar format pengidentifikasi (ID) di seluruh ekosistem aplikasi **SeutasTali** (Landing Page, SaaS Dashboard, dan Client Invitation). Standar ini memisahkan kebutuhan antara keamanan API, kemudahan komunikasi operasional pelanggan, pemasaran, dan pelacakan log sistem.

---

## 🏛️ Ringkasan Klasifikasi ID

Secara umum, ID di SeutasTali dikelompokkan menjadi empat tipe utama:
1. **Security & API (Internal)**: ID acak tingkat tinggi (entropi tinggi) untuk mencegah akses data ilegal (*ID Enumeration/Direct Object Reference*).
2. **Operational & Support (User-Facing)**: ID yang mudah dieja dan dibaca oleh manusia untuk kebutuhan layanan pelanggan dan administrasi.
3. **Marketing & Growth**: ID atau kode yang estetik, mudah diingat, dan menarik saat dibagikan.
4. **Diagnostic & Logging**: ID pelacakan cepat untuk mempermudah pencarian masalah (troubleshooting) saat integrasi gagal.

---

## 🔑 1. Security & API (Tingkat Keamanan Tinggi)

| Nama ID | Format / Pola | Contoh Output | Alasan & Kasus Penggunaan |
| :--- | :--- | :--- | :--- |
| **`user_id`** | UUID v4 (36 karakter) | `f81d4fae-7dec-11d0-a765-00a0c91e6bf6` | Menyembunyikan jumlah total pengguna terdaftar dari kompetitor serta mengamankan endpoint API profil. |
| **`invitation_id`** | UUID v4 atau ULID (26 karakter) | `01ARZ3NDEKTSV4RRFFQ69G5FAV` | Menjadi penanda unik undangan klien. Mencegah tebakan halaman undangan jika diakses melalui API edit atau preview. |
| **`draft_token`** | `draft_` + Alphanumeric (24 char) | `draft_a7f9c2d8b4e10293d8b2e1a4` | Token akses draf sementara saat memproses pembuatan undangan sebelum pembayaran dilakukan. Sangat aman di URL. |
| **`guest_hash` / `guest_id`** | `g_` + Alphanumeric (6-8 char) | `g_x7R9K2` | Digunakan untuk URL undangan personal tamu, contoh: `miqdad-shafa.seutastali.id/to/miqdad?id=g_x7R9K2`. Estetik & pendek. |
| **`rsvp_id`** | Integer (Auto Increment) | `482` | Cukup menggunakan ID numerik standar karena data ini hanya dibaca dan diolah di internal database admin. |

---

## 📞 2. Operational & Support (Ramah Pengguna)

| Nama ID | Format / Pola | Contoh Output | Alasan & Kasus Penggunaan |
| :--- | :--- | :--- | :--- |
| **`order_id` / `invoice_id`** | `INV` + YYMMDD + Random (5-6 Digit) | `INV-260520-64679` | Digunakan sebagai nomor invoice transaksi Midtrans. Profesional, mudah dicari oleh pembeli, dan memudahkan pencocokan manual. |
| **`customer_id`** | `CST` + YYYY + Random (5 Digit) | `CST-2026-08492` | Nomor keanggotaan pelanggan. Jika klien mengajukan pertanyaan ke CS via WA, mereka cukup menyebutkan nomor pelanggan ini. |
| **`ticket_id`** | `TK` + YYMMDD + Random (5 Digit) | `TK-260520-04821` | ID laporan tiket bantuan jika terjadi kendala teknis atau permintaan penyesuaian khusus oleh klien. |
| **`refund_id`** | `REF` + YYMMDD + Random (5 Digit) | `REF-260520-01928` | Kode referensi pembukuan pengembalian dana (*refund*) jika terjadi transaksi batal. |
| **`payout_id`** | `PAY` + YYMMDD + Random (5 Digit) | `PAY-260520-02849` | Kode pencairan dana komisi afiliasi atau pembayaran ke vendor eksternal. |

---

## 📈 3. Marketing & Referrals (Estetik & Shareable)

| Nama ID / Kode | Format / Pola | Contoh Output | Alasan & Kasus Penggunaan |
| :--- | :--- | :--- | :--- |
| **`referral_code`** | `ST-REF-` + Alphanumeric (5 char) | `ST-REF-M5B9X` | Kode afiliasi dinamis yang dibagikan pengguna ke orang lain untuk mendapatkan komisi. |
| **`coupon_code`** | Custom Uppercase String | `SEUTASTALI50`, `WELCOME10` | Kode promosi statis/dinamis yang diinput pengguna saat melakukan checkout untuk memotong total harga pesanan. |

---

## 🛠️ 4. Diagnostic & Logging (Penanganan Masalah)

| Nama ID | Format / Pola | Contoh Output | Alasan & Kasus Penggunaan |
| :--- | :--- | :--- | :--- |
| **`log_id`** | `LOG` + YYMMDD + Random (5 Digit) | `LOG-260520-74910` | ID pelacakan internal ketika terjadi error pada sistem (misal: gagal kirim email konfirmasi atau webhook error). |
| **`message_id`** | `MSG` + YYMMDD + Random (6 Digit) | `MSG-260520-092810` | ID pelacakan status pengiriman WhatsApp Gateway (Fonnte/Waba/dll) untuk memastikan undangan telah terkirim ke tamu. |

---

## 💡 Panduan Implementasi Teknis (PHP & MySQL)

### A. Generator Format ID di PHP
Berikut adalah fungsi pembantu (*helper*) untuk menghasilkan ID kustom di aplikasi SeutasTali:

```php
<?php
/**
 * Generator ID Kustom SeutasTali
 */

// 1. Generator Invoice ID (INV-YYMMDD-XXXXX)
function generateInvoiceId() {
    $datePart = date('ymd');
    $randomPart = str_pad(random_int(10000, 99999), 5, '0', STR_PAD_LEFT);
    return "INV-{$datePart}-{$randomPart}";
}

// 2. Generator Customer ID (CST-YYYY-XXXXX)
function generateCustomerId() {
    $yearPart = date('Y');
    $randomPart = str_pad(random_int(10000, 99999), 5, '0', STR_PAD_LEFT);
    return "CST-{$yearPart}-{$randomPart}";
}

// 3. Generator Draft Token (draft_[24 char alphanumeric])
function generateDraftToken() {
    $entropy = bin2hex(random_bytes(12)); // 24 karakter hex
    return "draft_{$entropy}";
}

// 4. Generator Guest Hash (g_[6 char alphanumeric])
function generateGuestHash() {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $hash = '';
    for ($i = 0; $i < 6; $i++) {
        $hash .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return "g_{$hash}";
}
?>
```

### B. Validasi Keamanan Database
1. Kolom ID internal seperti `user_id` dan `invitation_id` sebaiknya menggunakan tipe data `VARCHAR(36)` (untuk UUID) atau `VARCHAR(26)` (untuk ULID).
2. Hindari mengekspos ID numerik auto-increment (`id bigint`) pada URL atau parameter API publik untuk meminimalkan celah keamanan manipulasi URL.
