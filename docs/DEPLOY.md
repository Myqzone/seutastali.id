# Deployment Guide: SaaS Infrastructure

## 1. Wildcard DNS
- CNAME `*` diarahkan ke IP server Rumahweb.
- Apache/Litespeed dikonfigurasi agar tidak mencari folder folder `clara-adit`, melainkan menjalankan `index.js`.

## 2. Automation
- Gunakan skrip Node.js untuk otomatisasi generate link WhatsApp tamu (`api.whatsapp.com/send?text=...`).

## 3. Storage
- Gunakan folder terpisah `/uploads/user_id/` untuk menyimpan foto prewedding klien.
