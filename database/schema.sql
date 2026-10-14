-- ====================================================================
-- DRL DWARIKA REAL ESTATE LLC — COMPLETE RELATIONAL DATABASE SCHEMA
-- Target Environment: MySQL 8.0+ / MariaDB 10.4+ (Hostinger / cPanel Compatible)
-- Engine: InnoDB | Character Set: utf8mb4 | Collation: utf8mb4_unicode_ci
-- ====================================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `activity_logs`;
DROP TABLE IF EXISTS `enquiries`;
DROP TABLE IF EXISTS `testimonials`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `property_amenities`;
DROP TABLE IF EXISTS `amenities`;
DROP TABLE IF EXISTS `property_images`;
DROP TABLE IF EXISTS `properties`;
DROP TABLE IF EXISTS `property_types`;
DROP TABLE IF EXISTS `locations`;
DROP TABLE IF EXISTS `founders`;
DROP TABLE IF EXISTS `agents`;
DROP TABLE IF EXISTS `site_settings`;
DROP TABLE IF EXISTS `users`;

SET FOREIGN_KEY_CHECKS = 1;

-- 1. Administrative Users
CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(120) NOT NULL,
  `email` VARCHAR(191) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('super_admin', 'admin', 'agent') NOT NULL DEFAULT 'admin',
  `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
  `remember_token` VARCHAR(100) NULL,
  `last_login_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_users_role` (`role`),
  INDEX `idx_users_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Geographic Locations / Communities
CREATE TABLE `locations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(191) NOT NULL UNIQUE,
  `city` VARCHAR(100) NOT NULL DEFAULT 'Dubai',
  `emirate` VARCHAR(100) NOT NULL DEFAULT 'Dubai',
  `description` TEXT NULL,
  `highlights` TEXT NULL,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `image_url` VARCHAR(255) NULL,
  `meta_title` VARCHAR(255) NULL,
  `meta_description` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_locations_featured` (`is_featured`),
  INDEX `idx_locations_city` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Property Types (Villa, Apartment, Townhouse, Penthouse, Commercial)
CREATE TABLE `property_types` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(191) NOT NULL UNIQUE,
  `description` TEXT NULL,
  `icon` VARCHAR(60) NOT NULL DEFAULT 'fa-building',
  `is_featured` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Licensed Real Estate Agents
CREATE TABLE `agents` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(191) NOT NULL UNIQUE,
  `designation` VARCHAR(150) NOT NULL,
  `rera_brn` VARCHAR(50) NULL,
  `experience` VARCHAR(100) NULL,
  `photo_url` VARCHAR(255) NOT NULL,
  `email` VARCHAR(191) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `whatsapp` VARCHAR(50) NOT NULL,
  `short_bio` TEXT NOT NULL,
  `full_bio` LONGTEXT NOT NULL,
  `languages` JSON NULL,
  `specializations` JSON NULL,
  `locations` JSON NULL,
  `testimonial_quote` TEXT NULL,
  `testimonial_client` VARCHAR(150) NULL,
  `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_agents_status` (`status`),
  INDEX `idx_agents_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Company Founders & Executive Leadership
CREATE TABLE `founders` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(191) NOT NULL UNIQUE,
  `designation` VARCHAR(150) NOT NULL,
  `photo_url` VARCHAR(255) NULL,
  `short_bio` TEXT NULL,
  `full_bio` LONGTEXT NULL,
  `background` TEXT NULL,
  `leadership_areas` TEXT NULL,
  `quote` TEXT NULL,
  `email` VARCHAR(191) NULL,
  `phone` VARCHAR(50) NULL,
  `linkedin_url` VARCHAR(255) NULL,
  `status` ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
  `missing_fields` TEXT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_founders_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Properties Main Entity
CREATE TABLE `properties` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(191) NOT NULL UNIQUE,
  `reference_code` VARCHAR(50) NOT NULL UNIQUE,
  `description` LONGTEXT NOT NULL,
  `price` DECIMAL(15, 2) NOT NULL DEFAULT 0.00,
  `currency` VARCHAR(10) NOT NULL DEFAULT 'AED',
  `price_prefix` VARCHAR(50) NULL COMMENT 'e.g. Starting from, Call for Price',
  `bedrooms` INT NOT NULL DEFAULT 0,
  `bathrooms` INT NOT NULL DEFAULT 0,
  `area_sqft` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  `listing_type` ENUM('sale', 'rent', 'off-plan', 'commercial') NOT NULL DEFAULT 'sale',
  `property_type_id` INT UNSIGNED NOT NULL,
  `location_id` INT UNSIGNED NOT NULL,
  `agent_id` INT UNSIGNED NULL,
  `address` VARCHAR(255) NULL,
  `status` ENUM('published', 'draft', 'sold', 'rented', 'archived') NOT NULL DEFAULT 'published',
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `featured_image` VARCHAR(255) NOT NULL,
  `virtual_tour_url` VARCHAR(255) NULL,
  `rera_permit` VARCHAR(100) NULL,
  `completion_year` VARCHAR(30) NULL,
  `furnished_status` ENUM('furnished', 'semi-furnished', 'unfurnished') NOT NULL DEFAULT 'unfurnished',
  `meta_title` VARCHAR(255) NULL,
  `meta_description` TEXT NULL,
  `views_count` INT UNSIGNED NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_properties_type` FOREIGN KEY (`property_type_id`) REFERENCES `property_types` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_properties_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_properties_agent` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE SET NULL,
  INDEX `idx_properties_status` (`status`),
  INDEX `idx_properties_listing_type` (`listing_type`),
  INDEX `idx_properties_featured` (`is_featured`),
  INDEX `idx_properties_agent` (`agent_id`),
  INDEX `idx_properties_price` (`price`),
  INDEX `idx_properties_bedrooms` (`bedrooms`),
  INDEX `idx_properties_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Property Images / Media Gallery
CREATE TABLE `property_images` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `property_id` INT UNSIGNED NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `alt_text` VARCHAR(255) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_images_property` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  INDEX `idx_images_prop_order` (`property_id`, `sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Amenities Taxonomy
CREATE TABLE `amenities` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `icon` VARCHAR(60) NOT NULL DEFAULT 'fa-check-circle',
  `category` VARCHAR(60) NOT NULL DEFAULT 'General'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Property-Amenity Pivot Table
CREATE TABLE `property_amenities` (
  `property_id` INT UNSIGNED NOT NULL,
  `amenity_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`property_id`, `amenity_id`),
  CONSTRAINT `fk_pa_property` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pa_amenity` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Services Offered
CREATE TABLE `services` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(191) NOT NULL UNIQUE,
  `short_desc` TEXT NOT NULL,
  `full_desc` LONGTEXT NOT NULL,
  `icon` VARCHAR(60) NOT NULL DEFAULT 'fa-briefcase',
  `benefits` TEXT NULL,
  `process` TEXT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `meta_title` VARCHAR(255) NULL,
  `meta_description` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_services_active` (`is_active`, `sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Testimonials & Client Reviews
CREATE TABLE `testimonials` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_name` VARCHAR(120) NOT NULL,
  `client_title` VARCHAR(120) NULL,
  `location` VARCHAR(100) NOT NULL DEFAULT 'Dubai',
  `quote` TEXT NOT NULL,
  `avatar_initial` VARCHAR(5) NOT NULL DEFAULT 'A',
  `rating` TINYINT UNSIGNED NOT NULL DEFAULT 5,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Customer Inquiries & CRM Leads
CREATE TABLE `enquiries` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `property_id` INT UNSIGNED NULL,
  `service_id` INT UNSIGNED NULL,
  `name` VARCHAR(120) NOT NULL,
  `email` VARCHAR(191) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `subject` VARCHAR(255) NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('new', 'contacted', 'qualified', 'closed') NOT NULL DEFAULT 'new',
  `admin_notes` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_enquiries_property` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_enquiries_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  INDEX `idx_enquiries_status` (`status`),
  INDEX `idx_enquiries_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Dynamic Site Settings & Brand Configuration
CREATE TABLE `site_settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` LONGTEXT NULL,
  `setting_group` VARCHAR(50) NOT NULL DEFAULT 'general',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_settings_group` (`setting_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Audit Activity Trail
CREATE TABLE `activity_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NULL,
  `action` VARCHAR(100) NOT NULL,
  `entity_type` VARCHAR(60) NOT NULL,
  `entity_id` INT UNSIGNED NULL,
  `details` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  INDEX `idx_logs_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
