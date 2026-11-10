# Services Co-operative Bank & Society Website Template (PHP)

A production-ready, white-label website template built for **Services Co-operative Banks** and **Service Co-operative Societies** in Kerala. Designed to serve multiple clients from a single, robust codebase with zero hardcoded visual assets, strict statutory compliance, native bilingual support (English and Malayalam), and zero build-step cPanel shared hosting compatibility.

---

## Key Highlights

- **Lightweight Custom MVC**: Front controller, fast regex parameter router, native PHP view engine with layouts and partials, PDO with prepared statements only.
- **True White-Label Architecture**: Change branding, legal profile, theme tokens, and feature modules per client without touching a single line of application code.
- **Strict Legal & Regulatory Compliance**:
  - **Statutory Word "Bank" Protection**: Enforces compliance with the Banking Regulation Act. Non-bank societies (`credit_society`, `agri_society`) strictly never auto-insert the word "Bank" into headings, titles, meta tags, or Schema markup.
  - **Conditional DICGC Badging**: The DICGC deposit insurance statement appears **only** when the client is a licensed bank with DICGC enabled.
  - **Privacy & DPDP Compliance**: Web forms never collect Aadhaar numbers or bank card details. PAN numbers are automatically masked in views and stored securely.
- **Dynamic Theming Engine**:
  - CSS Custom Properties generated from client config and database overrides.
  - **5 Built-in Light Theme Presets**: Royal Blue, Emerald Green, Maroon & Gold, Teal & Orange, Charcoal & Amber.
  - Real-time WCAG 2.1 AA Contrast Ratio verification ($4.5:1$ standard).
- **Native Bilingual Support (English & Malayalam)**:
  - Complete English and Malayalam dictionaries from day one.
  - Language prefix routing (`/ml/...` vs `/...`), automatic hreflang tags for SEO, and web font fallbacks (Noto Sans Malayalam, Manjari).
- **Lead Reference Feature Set**:
  - 365 Days Evening Banking callouts
  - Top utility bar (phones, email, WhatsApp, search, language switcher)
  - Accessible Mega Menu for Services (Loans, Deposits, Facilities)
  - Centralized Interest Rate Panel (Deposits & Loans) with effective dates and legal disclaimers
  - Quick reducing-balance EMI Calculator
  - Branch locator with 365-day badges and manager details
  - Chairperson / Presidential insight message
  - Emergency Announcement Ticker and AGM Popup Notice Modal

---

## Directory Structure

```
/app
  /Controllers    HomeController, PageController, ContactController, AuthController, Admin\...
  /Models         Data models
  /Views          layouts (main, admin), partials (header, footer, ticker, modal), pages, errors, auth
  /Services       Business logic, mail dispatchers
  /Middleware     AuthMiddleware, RoleMiddleware, CsrfMiddleware
  /Helpers        Global view and utility functions
/core             Router, Request, Response, Database, View, Auth, Csrf, I18n, ThemeEngine, Settings, Session, Validator
/modules          Optional pluggable feature packs
/clients
  /kalliaseri-scb Sample Client 1: Licensed Co-operative Bank profile (Royal Blue theme, DICGC enabled)
  /periyar-scs    Sample Client 2: Service Co-operative Society profile (Emerald Green theme, strict society wording)
/public           Front controller (index.php), assets (css, js, img), uploads (write-protected)
/database         schema.sql (MySQL 8+), schema_sqlite.sql (SQLite dev), seeds, ERD.md
/storage          logs, cache, sessions, backups
/docs             README, INSTALL, ONBOARDING, ADMIN-GUIDE
```

---

## Two Included Client Profiles

| Attribute | Client 1: `kalliaseri-scb` | Client 2: `periyar-scs` |
| :--- | :--- | :--- |
| **Legal Entity** | `licensed_bank` | `credit_society` |
| **Approved Name** | Kalliaseri Co-operative Urban Bank | Periyar Service Co-operative Society |
| **Use of "Bank"** | Permitted under RBI License | **Strictly Prohibited** (Society wording used) |
| **DICGC Insurance** | **Enabled** (Insured up to ₹5 Lakhs) | **Disabled** (Not applicable to societies) |
| **Theme Preset** | Royal Blue & Gold (`#0A4D92`) | Emerald Green & Warm Amber (`#0F766E`) |
| **Header Style** | Left logo alignment | Centered logo alignment |
| **Target Audience** | General Public & Members | Enrolled Society Members |

---

## Quick Start (Local Development)

1. Clone or download the repository:
   ```bash
   git clone <repo-url>
   cd "Services Co-operative Bank"
   ```

2. Generate autoloader:
   ```bash
   composer dump-autoload
   ```

3. Setup environment:
   ```bash
   cp .env.example .env
   ```
   *(By default, `.env` is configured for portable development with SQLite, or connect to MySQL 8.0+)*.

4. Apply migrations and seed sample clients:
   ```bash
   php cli.php migrate
   php cli.php seed kalliaseri-scb
   php cli.php seed periyar-scs
   ```

5. Launch local development server:
   ```bash
   php -S 127.0.0.1:8000 -t public public/index.php
   ```

6. Open in browser:
   - English: `http://127.0.0.1:8000/`
   - Malayalam: `http://127.0.0.1:8000/ml`
   - Admin CMS: `http://127.0.0.1:8000/admin/login` (`admin` / `Admin@12345`)

7. Run test verification suite:
   ```bash
   php storage/test_phase1.php
   ```

---

## Documentation

- [Client Onboarding Checklist](docs/ONBOARDING.md)
- [Installation Guide (cPanel & VPS)](INSTALL.md)
- [Admin CMS User Guide](docs/ADMIN-GUIDE.md)
- [Entity-Relationship Diagram (ERD)](database/ERD.md)
