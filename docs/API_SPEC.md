# API Specification (Internal)

## 1. Authentication
- `POST /api/v1/auth/register`: Register klien baru.
- `POST /api/v1/auth/login`: Login ke dashboard admin.

## 2. Invitation Management
- `GET /api/v1/invitation`: Mengambil data undangan milik user (Admin).
- `GET /api/v1/invitation/:slug`: Mengambil data publik undangan (Viewer).
- `PATCH /api/v1/invitation/:id`: Update konten undangan (content_json).

## 3. Guest Management
- `GET /api/v1/guests`: List semua tamu.
- `POST /api/v1/guests/import`: Import tamu via CSV/Excel.
- `POST /api/v1/rsvp`: Submit data RSVP dari tamu (Public).

## 4. Payments
- `POST /api/v1/payments/create`: Generate Snap Token (Midtrans).
- `POST /api/v1/payments/webhook`: Callback notification dari Payment Gateway.

## 5. Data Schema Example (content_json)
```json
{
  "theme": "premium-editorial",
  "colors": { "primary": "#800000", "accent": "#C5A059" },
  "sections": [
    { "type": "cover", "title": "Clara & Adit", "date": "2024-12-12" },
    { "type": "gallery", "images": ["url1", "url2"] }
  ]
}
```
