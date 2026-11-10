# Administrator & CMS User Guide

This guide describes how to operate the administrative control center of the Services Co-operative Bank & Society template.

---

## 1. Access & Security

- **Login URL**: `/admin/login`
- **Default Super Admin**: `admin` / `Admin@12345`
- **Brute-Force Protection**: 5 failed login attempts will automatically trigger a 5-minute IP and account lockout.
- **Session Security**: Sessions are regenerated upon login with strict `HttpOnly` and `SameSite=Lax` cookies.

---

## 2. Role-Based Access Control (RBAC)

The system supports four distinct roles:

| Role | Capabilities | Scope |
| :--- | :--- | :--- |
| **Super Admin** | Full platform control, themes, site settings, audit log, user management | Global |
| **Administrator** | Manage products, update interest rates, manage branches, handle enquiries | Global |
| **Editor** | Publish news, upload forms/downloads, update announcements and banners | Global |
| **Branch Manager** | View and resolve enquiries and service requests directed to their branch | Branch-Specific |

---

## 3. Centralized Rate Engine Management

Interest rates across the entire site are managed from one centralized place:
- Navigate to: **Control Center > Unified Rate Engine** (`/admin/rates`).
- When a rate row is updated with an **Effective From** date:
  1. The **Homepage Tabbed Rate Panel** updates immediately.
  2. The **Interest Rates Page** updates with the new schedule.
  3. The **Product Catalogue** reflects the new rate.
  4. The **Calculators** automatically pick up the new rate slab.
- Past rates are archived to maintain rate history for compliance.

---

## 4. Bilingual Publishing (English & Malayalam)

Every content entry (products, news, announcements, board members) contains side-by-side bilingual fields:
- `Field (English)`: Displayed on default URLs (e.g. `/`, `/about`, `/contact`).
- `Field (Malayalam)`: Displayed on `/ml/...` URLs.
- Always provide both languages to ensure seamless visitor switching.

---

## 5. Announcements & Emergency Tickers

Under **Control Center > Announcements**:
1. **Ticker**: Appears as a high-visibility scrolling bar below the main navigation (ideal for rate changes, holiday notices, and 365-day banking alerts).
2. **Popup Modal**: Displays as an interactive dialog on the visitor's first visit within a 24-hour period (ideal for Annual General Body Meeting notices or emergency alerts).
3. Set **Start Date** and **End Date** to automatically schedule campaign lifecycles.

---

## 6. Enquiries & Service Requests Inbox

Under **Control Center > Enquiries & Requests**:
- Incoming form submissions from `/contact`, `/service-request`, and `/feedback` arrive in the unified inbox.
- Each submission is tagged with a unique tracking code (e.g. `ENQ-202610-8A3F`).
- **Status Lifecycle**: `New` &rarr; `In Progress` &rarr; `Resolved` &rarr; `Closed`.
- Internal staff notes can be recorded without exposing them to the applicant.
- Branch Managers see only the enquiries submitted for their assigned branch.

---

## 7. Security Audit Log

Under **Control Center > Audit Log**:
- Every critical administrative action (login, rate changes, branch updates, settings modifications) is cryptographically stamped with:
  - Timestamp
  - User ID and username
  - Action key (e.g. `auth.login`, `rate.update`)
  - Client IP Address
  - Action details
- Audit logs cannot be modified or deleted through the interface.
