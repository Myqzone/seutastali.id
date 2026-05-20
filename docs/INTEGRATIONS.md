# Integration Details (3rd Party)

## 1. Payment Gateway (Midtrans)
- **Mode:** Snap (Popup).
- **Workflow:** 
  1. Frontend hit `/api/v1/payments/create`.
  2. Backend return `snap_token`.
  3. Frontend open Midtrans Popup.
  4. Webhook `/api/v1/payments/webhook` update status `invitation` menjadi `active`.

## 2. WhatsApp Gateway
- **Method:** `Direct Link` (via `wa.me`) untuk pengiriman manual.
- **Automation:** Script Node.js untuk generate pesan template:
  ```text
  Halo [Nama Tamu],
  Kami mengundang Anda ke acara kami...
  Link: [Subdomain]/to=[NamaTamu]
  ```

## 3. Storage (Local/Rumahweb)
- **Path:** `/public/uploads/[user_id]/[invitation_id]/`.
- **Optimization:** AI harus melakukan kompresi gambar (WebP) sebelum upload untuk menjaga ukuran bundle.

## 4. Redis Cache
- **Keys:** `invitation:[slug]`
- **Usage:** Simpan data publik (Cover, Detail Acara) agar tidak hit database di setiap request visitor.
