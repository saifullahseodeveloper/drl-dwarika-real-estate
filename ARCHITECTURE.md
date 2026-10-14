# SYSTEM ARCHITECTURE & TECHNICAL SPECIFICATION
## DRL Dwarika Real Estate LLC — Enterprise Real Estate Web Platform

**Target Environment:** Hostinger Shared Hosting (PHP 8.2+, MySQL 8/MariaDB, Apache/LiteSpeed) & Zero-Daemon Local Development Runner  
**Design Reference:** Master Homepage Design Reference (`public/assets/images/design-reference.jpg`)  
**Brand Identity:** Primary Blue `#1689CC` · Deep Blue `#0F73AC` · Navy `#0F1E2E` · Light Blue Surface `#F0F7FC`

---

## 1. Architectural Philosophy
The platform is built as a multi-page, server-side rendered (SSR) application engineered specifically for technical SEO performance, mobile responsiveness, and zero-daemon hosting compatibility.

```
                           [ CLIENT BROWSER ]
                                  │
                  ┌───────────────┴───────────────┐
                  ▼                               ▼
       [ Apache / LiteSpeed ]          [ Node.js Dev Runner ]
        (Hostinger Production)             (Local Preview)
                  │                               │
                  ▼                               ▼
        [ public/index.php ]               [ dev-server.js ]
                  │                               │
       ┌──────────┴──────────┐            ┌───────┴───────┐
       ▼                     ▼            ▼               ▼
[ Public Controller ] [ Admin Ctrl ]  [ Public Routes ] [ Admin CRUD ]
       │                     │            │               │
       └──────────┬──────────┘            └───────┬───────┘
                  ▼                               ▼
       [ Database (MySQL PDO) ]         [ JSON Engine / SQLite ]
```

---

## 2. Relational Database Schema
Normalized tables in `database/schema.sql`:

1. **`users`**: Administrative authentication with bcrypt cost-10 password hashing and role-based permissions (`super_admin`, `admin`, `agent`).
2. **`locations`**: Freehold Dubai communities and neighbourhoods (`slug`, `city`, `emirate`, `description`, `is_featured`, `image_url`).
3. **`property_types`**: Residential and commercial taxonomy (`villa`, `apartment`, `townhouse`, `penthouse`, `commercial`).
4. **`properties`**: Core listings with structured attributes (`title`, `slug`, `reference_code`, `description`, `price`, `currency`, `bedrooms`, `bathrooms`, `area_sqft`, `listing_type`, `location_id`, `property_type_id`, `status`, `is_featured`, `featured_image`, `rera_permit`).
5. **`property_images`**: Multi-image galleries per property with `sort_order` and `alt_text`.
6. **`amenities` & `property_amenities`**: M:N relational pivot table linking listings to property amenities.
7. **`services`**: Commercial and residential real estate service offerings (`buy-property`, `sell-property`, `property-consultancy`, `investment-advisory`).
8. **`testimonials`**: Client reviews with client name, location, initial avatar badge, and star rating.
9. **`enquiries`**: CRM lead pipeline capturing prospective buyer/tenant submissions with status stages (`new`, `contacted`, `qualified`, `closed`).
10. **`site_settings`**: Key-value dynamic brand settings, business phone/email, address, RERA credentials, and homepage stat counters.

---

## 3. Complete Routing Matrix

| Route | Handler / Controller | Purpose |
|---|---|---|
| `/` | `Frontend\HomeController@index` | Master Homepage matching reference design |
| `/about-us` | `Frontend\PageController@about` | Company background, Dubai presence, and stats |
| `/contact-us` | `Frontend\PageController@contact` | Office details, interactive enquiry form |
| `/testimonials` | `Frontend\PageController@testimonials` | Complete client testimonials and reviews |
| `/properties` | `Frontend\PropertyController@index` | Property catalog with search and multi-filtering |
| `/properties/buy` | `Frontend\PropertyController@buy` | Properties for sale |
| `/properties/rent` | `Frontend\PropertyController@rent` | Properties for rent |
| `/properties/off-plan` | `Frontend\PropertyController@offPlan` | Off-plan launch projects |
| `/properties/commercial`| `Frontend\PropertyController@commercial`| Commercial offices & retail spaces |
| `/property/{slug}` | `Frontend\PropertyController@show` | Single property detail, gallery, specs, lead form |
| `/services` | `Frontend\ServiceController@index` | Services overview hub |
| `/services/{slug}` | `Frontend\ServiceController@show` | Dedicated individual service landing pages |
| `/locations/{slug}` | `Frontend\LocationController@show` | Dubai community landing pages |
| `/property-types/{slug}`| `Frontend\PropertyTypeController@show`| Property type category landing pages |
| `POST /enquiry/submit`| `Frontend\LeadController@submit` | Lead capture with honeypot & CSRF protection |
| `/sitemap.xml` | `Frontend\SeoController@sitemap` | Dynamic XML sitemap indexing all valid canonical URLs |
| `/robots.txt` | `Frontend\SeoController@robots` | Crawler directives protecting admin routes |
| `/admin/login` | `Admin\AuthController@showLogin` | Secure administrative authentication |
| `/admin/dashboard`| `Admin\DashboardController@index` | KPI metrics, recent leads, catalog summary |
| `/admin/properties` | `Admin\PropertyController@index` | Property listings manager with status tabs |
| `/admin/properties/create`| `Admin\PropertyController@create` | Add property form with gallery and specs |
| `/admin/properties/edit/{id}`| `Admin\PropertyController@edit` | Edit property form |
| `/admin/leads` | `Admin\LeadController@index` | Customer inquiries CRM with status updating |
| `/admin/settings` | `Admin\SettingsController@index` | Global company info, phone, stats, licenses |

---

## 4. Technical SEO Architecture
- **Canonical URLs:** Configured dynamically on every page.
- **Structured Data:** JSON-LD `RealEstateAgent` on homepage and contact, `SingleFamilyResidence` on property detail pages, `BreadcrumbList` on all subpages.
- **Semantic Hierarchy:** Single `<h1>` per page, descriptive `<h2>`/`<h3>` tags, meaningful image `alt` attributes.
- **Dynamic XML Sitemap:** Automatically incorporates newly published properties and taxonomy routes with `lastmod` and `changefreq`.
- **Crawl Efficiency:** Disallows administrative control routes in `robots.txt` while exposing public real estate inventory.
