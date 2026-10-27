<?php
declare(strict_types=1);

/**
 * Database Configuration
 * Supports MySQL/MariaDB for Hostinger Shared Hosting & PDO SQLite fallback
 */
return [
    'driver'    => getenv('DB_DRIVER') ?: 'mysql',
    'host'      => getenv('DB_HOST') ?: 'localhost',
    'port'      => (int)(getenv('DB_PORT') ?: 3306),
    'database'  => getenv('DB_NAME') ?: 'u178516069_drl_estate',
    'username'  => getenv('DB_USER') ?: 'u178516069_drl_admin',
    'password'  => getenv('DB_PASS') ?: 'APNA_PASSWORD_YAHAN_LIKHO',  // ← Hostinger DB password
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    
    // Fallback SQLite file for zero-config portable setups
    'sqlite_path' => dirname(__DIR__) . '/storage/database.sqlite',

    'options'   => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]
];
