# Data Flow: The SaaS Engine

## 1. Authentication Flow
- User Register -> Setup Slug (Subdomain) -> Select Theme -> Payment.

## 2. Multi-Tier Data Fetching
- `Public Data`: Nama pengantin, lokasi, tanggal (Loaded via Redis for speed).
- `Private Data`: Daftar tamu, nominal angpao digital (Loaded via secure API session).

## 3. Subdomain Mapping
- Request ke `budi-ani.seutastali.id` dipetakan oleh server ke ID Event `12345`.
- Data ditarik berdasarkan ID tersebut dan di-inject ke framework Antigravity.
