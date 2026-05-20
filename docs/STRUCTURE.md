# Project Structure: SeutasTali Core

## 1. Directory Hierarchy
```text
/
├── .antigravity/          # AI Rules & Project Config
├── public/                # Static Assets (Logos, Icons, etc.)
│   └── uploads/           # User Uploaded Photos (Prewedding)
├── src/
│   ├── components/        # Atomic Components
│   │   ├── admin/         # Dashboard Specific (ThemePicker, LiveEditor)
│   │   ├── viewer/        # Invitation Specific (Cover, Gallery, RSVP)
│   │   └── shared/        # Common UI (Buttons, Modals, Cards)
│   ├── hooks/             # Reactive Logic (useAuth, useInvitation, useRSVP)
│   ├── layouts/           # Page Wrappers (AdminLayout, ViewerLayout)
│   ├── pages/             # Route Entries
│   │   ├── admin/         # /admin/* (Dashboard, Settings, Guests)
│   │   └── viewer/        # /view/* (The dynamic invitation page)
│   ├── services/          # API & External Integrations (Redis, Midtrans)
│   ├── store/             # Global State (EventContext, UIState)
│   ├── styles/            # Global CSS & Design Tokens
│   └── utils/             # Helper Functions (Formatter, Validator)
├── server.js              # Entry Point (Node.js)
├── .htaccess              # Wildcard & HTTPS Config
└── package.json           # Dependencies
```

## 2. Coding Convention
- **Components:** Gunakan ekstensi `.antigrav`.
- **Logic:** Pisahkan logic (hooks) dari UI (components).
- **Routes:** Viewer route harus menangani slug dinamis dari subdomain.
