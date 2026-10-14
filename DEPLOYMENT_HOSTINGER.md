# HOSTINGER SHARED HOSTING DEPLOYMENT GUIDE — DRL DWARIKA REAL ESTATE LLC

This guide provides step-by-step instructions for deploying **DRL Dwarika Real Estate LLC** to **Hostinger Shared Web Hosting / LiteSpeed / Apache** without requiring a VPS, root SSH access, or continuously running Node.js daemon processes.

---

## 1. Hosting Prerequisites
- **Hosting Plan:** Hostinger Single, Premium, Business, or Cloud Web Hosting.
- **PHP Version:** PHP 8.2 or 8.3 (configured via hPanel -> Advanced -> PHP Configuration).
- **PHP Extensions:** `pdo_mysql`, `curl`, `mbstring`, `openssl`, `gd` (or `imagick`), `json`.
- **Database:** MySQL 8.0+ or MariaDB 10.4+.
- **Web Server:** LiteSpeed / Apache with `mod_rewrite` enabled.

---

## 2. Database Setup via hPanel
1. Log into your **Hostinger hPanel**.
2. Navigate to **Databases** -> **Management**.
3. Create a new MySQL database:
   - **Database Name:** e.g. `u123456789_dwarika`
   - **Username:** e.g. `u123456789_admin`
   - **Password:** Strong generated password (e.g. `Dwarika#Secured2025!`)
4. Open **phpMyAdmin** for your new database.
5. In phpMyAdmin, click **Import** and select:
   - `database/schema.sql` (Creates normalized tables, foreign keys, and B-tree indexes)
   - Then select `database/seed.sql` (Inserts initial seed listings, services, testimonials, settings, and super admin account)

---

## 3. Uploading Project Files via File Manager or FTP
1. In Hostinger hPanel, open **File Manager** (or connect via FileZilla SFTP).
2. Navigate to `public_html/`.
3. You have two deployment layout options:

### Recommended Directory Structure (Highest Security):
```
/home/u123456789/
├── dwarika_app/           <-- Upload: app/, config/, database/, storage/, etc.
│   ├── app/
│   ├── config/
│   ├── database/
│   └── storage/
└── public_html/           <-- Upload the contents of public/ here
    ├── .htaccess
    ├── index.php
    ├── assets/
    │   ├── css/
    │   ├── js/
    │   └── images/
    ├── sitemap.xml
    └── robots.txt
```
*Note:* If using this split layout, adjust line 8 in `public_html/index.php`:
```php
define('APP_ROOT', dirname(__DIR__) . '/dwarika_app');
```

### Direct Upload Structure (Quick & Zero-Modification):
Upload the entire repository directly into `public_html/`. The root `.htaccess` will automatically rewrite and protect all internal app directories, routing requests seamlessly into `/public`.

---

## 4. Environment Configuration
Create or edit `config/database.php` (or set environment variables in Hostinger hPanel):
```php
return [
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'port'      => 3306,
    'database'  => 'u123456789_dwarika',
    'username'  => 'u123456789_admin',
    'password'  => 'Dwarika#Secured2025!',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    ...
];
```

---

## 5. File Permissions
Ensure the following directories have write permissions:
- `storage/` -> `0755`
- `public/assets/images/` -> `0755`

---

## 6. Verifying Deployment
1. Visit your live domain: `https://yourdomain.com`
2. Check that the homepage renders matching the master design.
3. Access the Admin Control Panel: `https://yourdomain.com/admin/login`
   - **Default Admin Email:** `admin@dwarikarealestate.ae`
   - **Default Password:** `AdminPassword2025!`
4. Change your password immediately upon first login under Site Settings.
5. Inspect the dynamic XML sitemap: `https://yourdomain.com/sitemap.xml`
