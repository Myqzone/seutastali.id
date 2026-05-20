# Database Schema (SaaS Ready)

## Table: users (Klien)
- id, email, password, whatsapp_number.

## Table: invitations (Data Undangan)
- id, user_id, slug, theme_id, status (draft/active/expired).
- content_json: Menyimpan semua teks, foto, dan urutan section.

## Table: guests (Manajemen Tamu ala Katsudoto)
- id, invitation_id, guest_name, unique_code, status_wa (sent/pending), attendance.

## Table: payments
- id, invitation_id, transaction_id, amount, status (pending/success).
