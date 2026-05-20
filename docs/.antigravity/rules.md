# Antigravity Rules: SeutasTali SaaS Logic

## 1. Multi-Tenant Architecture
- Pisahkan logic antara `/admin` (Dashboard Klien) dan `/view` (Undangan Tamu).
- Gunakan 'Shared Components' yang bisa merender data statis (view) maupun data reaktif (editor).

## 2. Live Preview Engine
- Setiap perubahan di Dashboard harus langsung ter-update di komponen preview secara real-time tanpa reload halaman (Hot-State).

## 3. Performance
- Pastikan script editor tidak ikut ter-load saat tamu membuka undangan (Code Splitting).
