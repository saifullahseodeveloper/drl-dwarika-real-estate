# DRL Dwarika Real Estate LLC — Complete Dynamic Web Platform

A production-oriented, dynamic real estate web platform built for **DRL Dwarika Real Estate LLC**, designed from the master homepage illustration and engineered for high conversion, technical SEO, and mobile-first responsiveness.

---

## 🌟 Key Highlights

1. **Master Design Faithfulness**:
   - Pixel-accurate match to the attached homepage reference illustration.
   - Elegant typography: Serif luxury headings (`Playfair Display`) + modern clean body (`Plus Jakarta Sans`).
   - Official brand color palette: Primary Blue `#1689CC`, Deep Blue `#0F73AC`, Surface Blue `#F0F7FC`, Dark Navy `#0F1E2E`.
   - Sharp vector SVG & PNG logo replicas matching the exact 3-skyscraper icon and DRL typography.

2. **Mobile-First Responsive Experience**:
   - Verified across mobile viewports: **320px**, **375px**, **430px**, **768px**, **1024px**, and **1440px**.
   - Zero horizontal overflow.
   - Smooth slide-out mobile drawer menu, touch-friendly tap targets, and responsive cards.

3. **Multi-Page Architecture (No Single-Page Anchors)**:
   - Dedicated URLs and tailored page layouts for every section.
   - `/` — Homepage with all 6 master sections.
   - `/about-us` — Company story, values, Dubai presence, and verified stats.
   - `/contact-us` — Business Bay office details, direct WhatsApp concierge, and inquiry desk.
   - `/properties` — Full catalog with live server-side search, multi-filters (location, type, beds, budget, keyword), sorting, and pagination.
   - `/properties/buy`, `/properties/rent`, `/properties/off-plan`, `/properties/commercial`.
   - `/property/{slug}` — Individual property detail page with photo gallery, specs grid, verified RERA badge, amenities checklist, similar listings, and lead inquiry form.
   - `/services` & individual service pages: `/services/buy-property`, `/services/sell-property`, `/services/property-consultancy`, `/services/investment-advisory`.
   - `/locations/{slug}` — Community discovery pages (Dubai Hills, Downtown, JVC, Palm Jumeirah, Business Bay, Creek Harbour).
   - `/property-types/{slug}` — Property categories (Villas, Apartments, Townhouses, Penthouses, Commercial).
   - `/testimonials` — Client reviews and ratings.
   - `/sitemap.xml` & `/robots.txt` — Dynamic technical SEO engines.

4. **Secure Admin Control Panel (`/admin`)**:
   - Session authentication with secure password verification and CSRF token protection.
   - **Executive Dashboard:** Total properties, active published listings, drafts, sold properties, and total lead count.
   - **Property Manager:** Add, edit, preview, publish, and delete listings with full specification and image management.
   - **Leads & Inquiries CRM:** Review inquiries, filter by pipeline stages (*New*, *Contacted*, *Qualified*, *Closed*), and update lead statuses.
   - **Services & Content Manager:** Configure services, client testimonials, and Dubai locations.
   - **Site Settings:** Edit company phone, WhatsApp, email, address, RERA ORN, DLD licenses, and homepage statistics.
   - **Technical SEO Inspector:** Dynamic sitemap inspection and robots.txt manager.

5. **Hostinger Shared Hosting & Zero-Daemon Local Runner**:
   - Production PHP 8.2+ MVC architecture (`app/`, `config/`, `database/schema.sql`, `.htaccess`) ready for instant deployment on Hostinger shared / LiteSpeed hosting without VPS requirements.
   - Zero-dependency standalone local development server (`dev-server.js`) ready to run on any machine with `node dev-server.js` or `npm run dev`.

---

## 🚀 Quick Start (Local Development)

```bash
cd C:\Users\lenovo\.gemini\antigravity-ide\scratch\drl-dwarika-real-estate
npm run dev
```

The application will launch immediately at:
- **Public Portal:** [http://localhost:4173](http://localhost:4173)
- **Admin Panel:** [http://localhost:4173/admin](http://localhost:4173/admin)
- **Dynamic XML Sitemap:** [http://localhost:4173/sitemap.xml](http://localhost:4173/sitemap.xml)

### Default Admin Credentials
- **Email:** `admin@dwarikarealestate.ae`
- **Password:** `AdminPassword2025!`

---

## 🗄️ Database Setup & Migrations (Hostinger Production)

Import into phpMyAdmin or run via MySQL CLI:
1. `database/schema.sql` — Creates normalized tables, indexes, and foreign keys.
2. `database/seed.sql` — Inserts Dubai properties matching the design reference, services, testimonials, and default admin user.

See [DEPLOYMENT_HOSTINGER.md](file:///C:/Users/lenovo/.gemini/antigravity-ide/scratch/drl-dwarika-real-estate/DEPLOYMENT_HOSTINGER.md) for step-by-step instructions.
