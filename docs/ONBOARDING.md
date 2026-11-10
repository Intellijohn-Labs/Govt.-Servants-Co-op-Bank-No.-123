# Client Onboarding Guide & Production Launch Checklist

This guide outlines the exact, zero-code procedure to onboard a new Co-operative Bank or Service Co-operative Society onto the template.

---

## Pre-Onboarding Information Collection Checklist

Before onboarding a new client, collect the following statutory details:

- [ ] **Entity Type**:
  - `licensed_bank` (holds RBI Banking License)
  - `credit_society` (Service Co-operative Bank/Society under Kerala Co-operative Societies Act)
  - `agri_society` (Farmers Co-operative Society)
  - `employee_society` (Employees Co-operative Society)
- [ ] **Legal Name**: Exact registered name in bylaws (e.g. *The XYZ Service Co-operative Society Ltd. No. 1234*).
- [ ] **Approved Public Name**: Display name on signboard (e.g. *XYZ Service Co-operative Society*).
  > **Statutory Notice**: Societies without an RBI license may **not** use the words "Bank", "Banker", or "Banking" in their approved public name or page titles.
- [ ] **Registration Number & Year of Registration**
- [ ] **PAN & GSTIN** (PAN will be automatically masked in customer-facing views).
- [ ] **Head Office Physical Address, Primary Landline, Mobile/WhatsApp Number & Support Email**
- [ ] **DICGC Coverage**: Enabled only if the client is a licensed bank.
- [ ] **Co-operative Ombudsman Details**
- [ ] **Brand Colours / Palette**: Choose from the 5 built-in presets or provide hex values.
- [ ] **Branch Directory**: Branch names, addresses, timings, locker availability, and 365-day evening banking status.
- [ ] **Current Interest Rate Schedule**: Term deposit slabs and loan schemes with effective-from dates.

---

## Step-by-Step Onboarding Workflow

### Step 1: Scaffold the New Client Folder
Run the automated CLI scaffolding tool:
```bash
php cli.php create-client [client-slug] "[Approved Public Name]"
```
*Example:*
```bash
php cli.php create-client malabar-scb "Malabar Urban Co-operative Bank"
```
This generates:
```
/clients/malabar-scb/
  ├── config.php
  ├── theme.json
  ├── /assets/
  ├── /lang/
  │    ├── en.php
  │    └── ml.php
  └── /seed/
```

### Step 2: Configure Legal Profile & Contact Details
Edit `clients/{client-slug}/config.php`:
1. Verify `entity_type` (`licensed_bank` or `credit_society`).
2. Set `verified_legal_name` and `approved_public_name`.
3. Set `dicgc_enabled` to `true` (licensed banks only) or `false` (societies).
4. Update phone, email, and WhatsApp numbers (`whatsapp_number` format: 91XXXXXXXXXX).
5. Review `enabled_modules` to toggle features on or off.

### Step 3: Choose Visual Theme & Brand Tokens
Edit `clients/{client-slug}/theme.json` or pick one of the 5 presets:
- `royal-blue` (Navy Blue & Gold)
- `emerald-green` (Emerald Green & Warm Amber)
- `maroon-gold` (Heritage Maroon & Gold)
- `teal-orange` (Teal & Sunset Orange)
- `charcoal-amber` (Charcoal & Amber Gold)

Verify that the text and contrast ratio pass the WCAG AA threshold ($4.5:1$ for standard text).

### Step 4: Add Visual Assets
Place client logo and branding files in `clients/{client-slug}/assets/`:
- `logo.png` (Recommended: Transparent PNG, height 60px)
- `favicon.ico`
- `hero_slide_1.jpg` (Recommended: 1920x600 WebP or compressed JPG)

### Step 5: Seed Sample Content & Rates
Run the seeder to populate the initial product catalogue, rates, board members, and branch directory:
```bash
php cli.php seed {client-slug}
```

### Step 6: Set Active Client in Environment
In `.env`, set:
```ini
CLIENT={client-slug}
```
Clear the settings cache:
```bash
php cli.php clear-cache
```

### Step 7: Testing & Verification Checklist
- [ ] Language switcher: Test English and Malayalam (`/ml`) modes.
- [ ] Legal compliance: Ensure no prohibited use of "Bank" for societies.
- [ ] Forms: Submit a test enquiry on `/contact` and verify email dispatch and database tracking code.
- [ ] Rates panel: Check homepage and `/interest-rates` match the client's current schedule.
- [ ] Mobile responsive check: Test on mobile viewports; verify sticky phone and WhatsApp bar.
- [ ] WCAG AA compliance: Verify visible focus rings and skip navigation link.

### Step 8: Go Live
Point the domain to `/public`, configure SSL certificate (HTTPS), and verify SPF/DKIM records for transactional emails.
