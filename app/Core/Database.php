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
                } catch (\Throwable $initErr) {
                    error_log("Database auto-init notice: " . $initErr->getMessage());
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
