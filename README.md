<div align="center">
  <img src="assets/media/logo/pp-seutastali.png" alt="SeutasTali Logo" width="120" height="120" style="border-radius: 50%;">
  
  # SeutasTali Web Ecosystem
  
  [![PHP 8.3.7](https://img.shields.io/badge/PHP-8.3.7-blue?logo=php&logoColor=white)](https://www.php.net/)
  [![Bootstrap 5.3](https://img.shields.io/badge/Bootstrap-5.3-purple?logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
  [![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange?logo=mysql&logoColor=white)](https://www.mysql.com/)
  [![License MIT](https://img.shields.io/badge/License-MIT-green)](LICENSE)
  
  **[Website](https://seutastali.id) • [App](https://app.seutastali.id) • [Docs](DOCUMENTATION.md)**
</div>

**SeutasTali** is a premium digital wedding and event invitation platform designed with a modern, high-contrast **Neubrutalist** aesthetic. It enables couples and hosts to build highly interactive, beautiful, and completely custom web invitations in minutes.

---

## Architecture Overview

### 1. Public Landing Page - [seutastali.id](https://seutastali.id)

A modern, highly performant landing page showcasing SeutasTali's premium templates, features, packages, and FAQ.

**Key Features:**
- **Hero Slider Section:** Seamless gesture-based horizontal marquee slider demonstrating active premium layouts with WebP-optimized mockups.
- **Bento Grid Features Showcase:** Clean grid organization highlighting RSVP management, custom music, story galleries, maps navigation, and registry systems.
- **Dynamic Template Gallery:** Integrated template slider and separate templates explorer with easy filtering.
- **Custom Spacing & Layout:** Carefully balanced Neubrutalist container layouts and responsive headers.
- **Standardized FAQ:** Premium borderless accordion panel style matching the homepage design with rotating indicator icons.
- **Bio Links System:** Fully integrated link-in-bio page custom-built for couples' social media profiles.
- **Editorial Layout Subpages:** Expanded clean canvas typography on About, Terms, and Privacy subpages.

**Technical Implementation:**
- **Frontend Framework:** Bootstrap 5.3.3 paired with modular Vanilla CSS design tokens.
- **Image Optimization:** High-density WebP images with lazy-loading and strict aspect ratios (9:16 portrait ratios for template card mockups).
- **SEO & Access Optimization:** Meta tags, standard header schema, and browser pinch-to-zoom block protection.

---

### 2. Customizer & Client Dashboard - [app.seutastali.id](https://app.seutastali.id)

The comprehensive DIY Invitation Editor for couples to customize their designs, track RSVPs, manage gift registries, and coordinate guest lists.

#### **Core Features:**
- **Visual Builder:** Real-time font selection, theme color customizers, music uploads, and layout toggles.
- **Guest List Manager:** Custom URL generator for individual guest names (personalized *"Kepada Yth. Nama Tamu"* invitation paths).
- **RSVP Tracker:** Real-time RSVP analytics, attendance numbers, and direct guest wishes board.
- **Cashless Gift & Registry:** Integrated bank account details, digital wallet QR codes, and delivery addresses for physical gifts.
- **Notifications Hub:** Automated guest registration alerts and WhatsApp RSVP confirmations.

---

## Technical Stack

### Core Engine
- **PHP 8.3.7:** Clean, modern procedural framework structured with secure components.
- **MySQL 5.7+:** Relational database for invitation configurations, user credentials, guest lists, and logs.
- **Custom Routing:** Subdomain separation routing between landing pages and the customization dashboard.

### Frontend & Libraries
- **Bootstrap 5.3.3:** Responsive, mobile-first CSS core.
- **Owl Carousel / Swiper:** Touch-enabled premium sliders for template showcase.
- **Boxicons & FontAwesome 6:** Consolidated premium SVG-based modern icon libraries.
- **Manrope:** Global unified typography engine.

---

## Installation & Setup

### 1. Prerequisites
- Apache / Nginx Web Server
- PHP >= 8.1 (8.3.7 recommended)
- MySQL / MariaDB
- Composer (for dependency management)
- Node.js (optional, for asset compilations)

### 2. Quick Start
```bash
# Clone the repository
git clone https://github.com/seutastali/seutastali.id.git
cd seutastali.id

# Install PHP dependencies
composer install

# Environment setup
cp .env.example .env
# Configure .env with your specific MySQL credentials
```

### 3. Database Initialization
Import the provided SQL dump to create the necessary invitation tables and admin schemes:
```bash
mysql -u [username] -p [database_name] < database_schema.sql
```

### 4. Dual Domain Configuration (.env)

#### Public Landing Page (`seutastali.id`):
```env
APP_URL=https://seutastali.id/
STATIC_URL=https://seutastali.id/
MAIN_SITE_URL=https://seutastali.id/
IS_APP_SUBDOMAIN=false
```

#### Customizer Dashboard (`app.seutastali.id`):
```env
APP_URL=https://app.seutastali.id/
STATIC_URL=https://seutastali.id/
MAIN_SITE_URL=https://seutastali.id/
IS_APP_SUBDOMAIN=true
```

---

## Roadmap

### Current (v2.0.0)
- ✅ **Premium Neubrutalist Redesign:** Sand/cream color system, flat cards, thick high-contrast borders, and tactile custom buttons.
- ✅ **Mathematically Seamless Marquee:** CSS looping template slider with pixel-perfect margin-right alignments.
- ✅ **Global Zoom Protection:** Pinch-to-zoom block on mobile and desktop web viewports.
- ✅ **Unified Typography:** 100% project-wide consolidation under the unified `Manrope` font.
- ✅ **Clean Subpages:** Direct cream canvas editorial reading flow on Privacy, Terms, and About sections.
- ✅ **Fixed Mobile Navigation:** Refactored touch listeners for bottom-sheet drawer drag indicators and static nav-link clicks.

### Upcoming (v2.1.0+)
- 🏗️ **AI Story Generator:** Automatic love-story copywriter tool in user dashboard.
- 🏗️ **WhatsApp API Automation:** Direct broadcast system for invitations.
- 🏗️ **PWA Offline Support:** Guest access to digital invitation parameters without cellular connection.

---

## Support & Contact

- **Website:** [https://seutastali.id](https://seutastali.id)
- **Email:** info@seutastali.id
- **WhatsApp:** +62 822 2777 3904

---

© 2026 SeutasTali. All Rights Reserved.
