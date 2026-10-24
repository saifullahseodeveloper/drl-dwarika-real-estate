<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    private static ?PDO $instance = null;
    private static string $activeDriver = 'mysql';

    public static function getConnection(): PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $config = require dirname(__DIR__, 2) . '/config/database.php';

        // Attempt primary MySQL connection
        if ($config['driver'] === 'mysql') {
            try {
                $dsn = sprintf(
                    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                    $config['host'],
                    $config['port'],
                    $config['database'],
                    $config['charset']
                );
                self::$instance = new PDO($dsn, $config['username'], $config['password'], $config['options']);
                self::$activeDriver = 'mysql';

                // Ensure MySQL tables exist (auto-install schema & seed if fresh DB)
                try {
                    $tableCheck = self::$instance->query("SHOW TABLES LIKE 'locations'")->fetch();
                    if (!$tableCheck) {
                        $schemaFile = dirname(__DIR__, 2) . '/database/schema.sql';
                        $seedFile = dirname(__DIR__, 2) . '/database/seed.sql';
                        if (file_exists($schemaFile)) {
                            self::$instance->exec(file_get_contents($schemaFile));
                        }
                        if (file_exists($seedFile)) {
                            self::$instance->exec(file_get_contents($seedFile));
                        }
                    }

                    // Auto-sync agents & Nitin Saxena founder updates into production MySQL database
                    $agentCheck = self::$instance->query("SELECT id FROM agents WHERE slug = 'jeet-chande' LIMIT 1")->fetch();
                    if (!$agentCheck) {
                        self::$instance->exec("UPDATE agents SET sort_order = sort_order + 3 WHERE sort_order > 0");
                        self::$instance->exec("INSERT INTO agents (id, name, slug, designation, rera_brn, experience, photo_url, email, phone, whatsapp, short_bio, full_bio, languages, specializations, locations, testimonial_quote, testimonial_client, status, sort_order) VALUES
                        (7, 'Jeet Chande', 'jeet-chande', 'Portfolio Manager, Dubai Real Estate', '58214', 'Close to 3 Years', '/assets/images/agents/jeet-chande.jpg', 'jeet.chande@dwarikarealestate.ae', '+971 54 220 2920', '971542202920', 'With close to three years in Dubai real estate, Jeet specialises in luxury and prime properties. He works with high-value clients to identify investments in sought-after communities, combining sharp market knowledge with a strategic eye for capital appreciation and long-term wealth creation.', 'With close to three years in Dubai real estate, Jeet specialises in luxury and prime properties. He works with high-value clients to identify investments in sought-after communities, combining sharp market knowledge with a strategic eye for capital appreciation and long-term wealth creation.\n\nJeet focuses on high-yield opportunities, off-plan portfolio allocations, and secondary market prime residences across Dubai\'s most desirable master-planned developments. His analytical approach and client-first commitment ensure tailored investment strategies aligned with long-term financial prosperity.', '[\"English\", \"Hindi\"]', '[\"luxury\", \"residential\", \"off-plan\"]', '[\"Downtown Dubai\", \"Dubai Hills Estate\", \"Palm Jumeirah\"]', 'Jeet understood our investment goals from day one and secured a prime luxury unit with strong capital growth potential.', 'Hassan Al-Nuaimi, Private Investor', 'active', 1),
                        (8, 'Pragati Pandey', 'pragati-pandey', 'Portfolio Manager, Dubai Real Estate', '59432', '2.5 Years Experience', '/assets/images/agents/pragati-pandey.jpg', 'pragati.pandey@dwarikarealestate.ae', '+971 54 220 2920', '971542202920', 'Pragati brings two and a half years of sales experience and a client-first approach to Dubai\'s evolving property market. She focuses on emerging communities with strong growth potential, guiding investors with clear, tailored advice so they can make confident decisions and build lasting value.', 'Pragati brings two and a half years of sales experience and a client-first approach to Dubai\'s evolving property market. She focuses on emerging communities with strong growth potential, guiding investors with clear, tailored advice so they can make confident decisions and build lasting value.\n\nHer advisory practice centers on end-user families and first-time investors looking for emerging growth corridors, strong rental yields, and seamless transaction management under Dubai Land Department frameworks.', '[\"English\", \"Hindi\"]', '[\"residential\", \"off-plan\", \"rental\"]', '[\"Jumeirah Village Circle (JVC)\", \"Dubai Hills Estate\", \"Dubai Creek Harbour\"]', 'Pragati\'s tailored advice gave us the confidence to invest in Dubai. She guided us transparently through every single step.', 'Rohan & Ananya Verma, Investors', 'active', 2),
                        (9, 'Dheera Saxena', 'dheera-saxena', 'Portfolio Manager, Dubai Real Estate', '57891', 'Nearly 3 Years Experience', '/assets/images/agents/dheera-saxena.jpg', 'dheera.saxena@dwarikarealestate.ae', '+971 54 220 2920', '971542202920', 'With nearly three years in the industry, Dheera builds every investment strategy around the client\'s goals. She is known for her personalised approach, matching investors with properties that fit their budget, timeline and vision, and supporting them at every step from shortlisting to purchase.', 'With nearly three years in the industry, Dheera builds every investment strategy around the client\'s goals. She is known for her personalised approach, matching investors with properties that fit their budget, timeline and vision, and supporting them at every step from shortlisting to purchase.\n\nFrom initial shortlisting and developer comparative analysis to conveyancing and post-handover property asset management, Dheera provides dedicated guidance ensuring every investment delivers maximum peace of mind and enduring value.', '[\"English\", \"Hindi\"]', '[\"residential\", \"luxury\", \"off-plan\"]', '[\"Business Bay\", \"Downtown Dubai\", \"Dubai Hills Estate\"]', 'Dheera matched us with a property that perfectly matched our budget and vision. Truly exceptional and personalized service.', 'Kavita Mehrotra, Homebuyer', 'active', 3)");
                    }

                    $founderCheck = self::$instance->query("SELECT name FROM founders WHERE id = 1")->fetch();
                    if ($founderCheck && $founderCheck['name'] !== 'Nitin Saxena') {
                        $updateFounder = self::$instance->prepare("UPDATE founders SET
                            name = 'Nitin Saxena',
                            slug = 'nitin-saxena',
                            designation = 'Founder',
                            photo_url = '/assets/images/founders/founder-nitin-saxena.jpg',
                            short_bio = :short_bio,
                            full_bio = :full_bio,
                            background = 'Real Estate Leadership, Client Advisory, Strategic Investment Governance',
                            leadership_areas = 'Corporate Vision, Client Trust & Integrity, Strategic Growth, Value Creation',
                            quote = 'Together, let us build opportunities, create value, and turn aspirations into reality.',
                            email = 'nitin.saxena@dwarikarealestate.ae',
                            phone = '+971 54 220 2920',
                            status = 'published',
                            missing_fields = ''
                            WHERE id = 1");
                        $updateFounder->execute([
                            'short_bio' => 'At DRL – Dwarika Real Estate LLC, our vision goes beyond property transactions. We strive to create lasting relationships, build trust, and open doors to opportunities that help our clients achieve their dreams.',
                            'full_bio'  => "At DRL – Dwarika Real Estate LLC, our vision goes beyond property transactions. We strive to create lasting relationships, build trust, and open doors to opportunities that help our clients achieve their dreams.\n\nWe believe that real estate is not just about buying or selling properties; it is about finding the right place to build a future, make investments with confidence, and create lasting value. Every client deserves transparency, professionalism, and a personalized approach, and these principles remain at the heart of everything we do.\n\nAs we continue to grow, our commitment remains the same: to deliver excellence, uphold integrity, and provide real estate solutions that inspire confidence and peace of mind.\n\nThank you to our clients, partners, and team for being an integral part of our journey. Your trust motivates us to aim higher and achieve more every day.\n\nTogether, let us build opportunities, create value, and turn aspirations into reality.\n\nWarm Regards,\nNitin Saxena, Founder\nDRL – Dwarika Real Estate LLC\nOpening Doors to Prosperity."
                        ]);
                        self::$instance->exec("DELETE FROM founders WHERE id != 1");
                    }
                } catch (\Throwable $initErr) {
                    error_log("Database auto-sync notice: " . $initErr->getMessage());
                }

                return self::$instance;
            } catch (PDOException $e) {
                // If MySQL is not reachable, fallback to SQLite for local development resilience
                error_log("Database: Primary MySQL connection failed (" . $e->getMessage() . "). Falling back to SQLite.");
            }
        }

        // SQLite Fallback
        try {
            $sqliteFile = $config['sqlite_path'];
            $dir = dirname($sqliteFile);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $isNew = !file_exists($sqliteFile);
            self::$instance = new PDO("sqlite:" . $sqliteFile, null, null, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            self::$activeDriver = 'sqlite';

            if ($isNew || filesize($sqliteFile) === 0) {
                self::initializeSqliteSchema(self::$instance);
            }

            return self::$instance;
        } catch (PDOException $e) {
            throw new RuntimeException("Database connection error: " . $e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    public static function getDriver(): string
    {
        return self::$activeDriver;
    }

    private static function initializeSqliteSchema(PDO $pdo): void
    {
        // Execute minimal sqlite schema and seed for local testing
        $schema = <<<SQL
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            role TEXT NOT NULL DEFAULT 'admin',
            status TEXT NOT NULL DEFAULT 'active',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS locations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            city TEXT NOT NULL DEFAULT 'Dubai',
            emirate TEXT NOT NULL DEFAULT 'Dubai',
            description TEXT,
            is_featured INTEGER DEFAULT 0,
            image_url TEXT,
            meta_title TEXT,
            meta_description TEXT
        );
        CREATE TABLE IF NOT EXISTS property_types (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            description TEXT,
            icon TEXT DEFAULT 'fa-building',
            is_featured INTEGER DEFAULT 1,
            sort_order INTEGER DEFAULT 0
        );
        CREATE TABLE IF NOT EXISTS properties (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            reference_code TEXT NOT NULL UNIQUE,
            description TEXT NOT NULL,
            price REAL NOT NULL DEFAULT 0,
            currency TEXT NOT NULL DEFAULT 'AED',
            price_prefix TEXT,
            bedrooms INTEGER DEFAULT 0,
            bathrooms INTEGER DEFAULT 0,
            area_sqft REAL DEFAULT 0,
            listing_type TEXT NOT NULL DEFAULT 'sale',
            property_type_id INTEGER NOT NULL,
            location_id INTEGER NOT NULL,
            address TEXT,
            status TEXT NOT NULL DEFAULT 'published',
            is_featured INTEGER DEFAULT 0,
            featured_image TEXT NOT NULL,
            virtual_tour_url TEXT,
            rera_permit TEXT,
            completion_year TEXT,
            furnished_status TEXT DEFAULT 'unfurnished',
            meta_title TEXT,
            meta_description TEXT,
            views_count INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS services (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            short_desc TEXT NOT NULL,
            full_desc TEXT NOT NULL,
            icon TEXT DEFAULT 'fa-briefcase',
            benefits TEXT,
            process TEXT,
            sort_order INTEGER DEFAULT 0,
            is_active INTEGER DEFAULT 1,
            meta_title TEXT,
            meta_description TEXT
        );
        CREATE TABLE IF NOT EXISTS testimonials (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            client_name TEXT NOT NULL,
            client_title TEXT,
            location TEXT DEFAULT 'Dubai',
            quote TEXT NOT NULL,
            avatar_initial TEXT DEFAULT 'A',
            rating INTEGER DEFAULT 5,
            is_featured INTEGER DEFAULT 1,
            sort_order INTEGER DEFAULT 0
        );
        CREATE TABLE IF NOT EXISTS enquiries (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            property_id INTEGER,
            service_id INTEGER,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT NOT NULL,
            subject TEXT,
            message TEXT NOT NULL,
            status TEXT NOT NULL DEFAULT 'new',
            admin_notes TEXT,
            ip_address TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS site_settings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            setting_key TEXT NOT NULL UNIQUE,
            setting_value TEXT,
            setting_group TEXT DEFAULT 'general'
        );
        CREATE TABLE IF NOT EXISTS agents (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            designation TEXT NOT NULL,
            rera_brn TEXT,
            experience TEXT,
            photo_url TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT NOT NULL,
            whatsapp TEXT NOT NULL,
            short_bio TEXT NOT NULL,
            full_bio TEXT NOT NULL,
            languages TEXT,
            specializations TEXT,
            locations TEXT,
            testimonial_quote TEXT,
            testimonial_client TEXT,
            status TEXT NOT NULL DEFAULT 'active',
            sort_order INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS founders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            designation TEXT NOT NULL,
            photo_url TEXT,
            short_bio TEXT,
            full_bio TEXT,
            background TEXT,
            leadership_areas TEXT,
            quote TEXT,
            email TEXT,
            phone TEXT,
            linkedin_url TEXT,
            status TEXT NOT NULL DEFAULT 'published',
            missing_fields TEXT,
            sort_order INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
SQL;
        $pdo->exec($schema);
    }
}
