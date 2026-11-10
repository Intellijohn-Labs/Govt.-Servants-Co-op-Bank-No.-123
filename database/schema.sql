-- Services Co-operative Bank / Society Multi-Client Database Schema
-- Compatible with MySQL 8.0+ and MariaDB 10.6+

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Roles & Permissions (RBAC)
DROP TABLE IF EXISTS `role_permissions`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `roles` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `slug` VARCHAR(50) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL,
    `description` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `permissions` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `name` VARCHAR(150) NOT NULL,
    `group_name` VARCHAR(50) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `role_permissions` (
    `role_id` INT UNSIGNED NOT NULL,
    `permission_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Branches & Offices
DROP TABLE IF EXISTS `branch_services`;
DROP TABLE IF EXISTS `branches`;

CREATE TABLE `branches` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `code` VARCHAR(20) NOT NULL,
    `name_en` VARCHAR(150) NOT NULL,
    `name_ml` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150) NOT NULL,
    `is_head_office` TINYINT(1) DEFAULT 0,
    `address_en` TEXT NOT NULL,
    `address_ml` TEXT NOT NULL,
    `district` VARCHAR(60) NOT NULL,
    `pincode` VARCHAR(10) NOT NULL,
    `phone` VARCHAR(50) NOT NULL,
    `alternate_phone` VARCHAR(50) NULL,
    `email` VARCHAR(120) NULL,
    `manager_name` VARCHAR(120) NULL,
    `manager_phone` VARCHAR(50) NULL,
    `working_hours_en` VARCHAR(255) DEFAULT 'Mon - Sat: 9:30 AM - 4:30 PM',
    `working_hours_ml` VARCHAR(255) DEFAULT 'തിങ്കൾ - ശനി: 9:30 AM - 4:30 PM',
    `has_locker` TINYINT(1) DEFAULT 0,
    `has_365_days` TINYINT(1) DEFAULT 0,
    `has_gold_loan` TINYINT(1) DEFAULT 1,
    `has_atm` TINYINT(1) DEFAULT 0,
    `latitude` DECIMAL(10, 8) NULL,
    `longitude` DECIMAL(11, 8) NULL,
    `directions_url` VARCHAR(255) NULL,
    `sort_order` INT DEFAULT 0,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_branch_client` (`client_slug`),
    INDEX `idx_branch_district` (`district`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `branch_services` (
    `branch_id` INT UNSIGNED NOT NULL,
    `service_name` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`branch_id`, `service_name`),
    FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Users & Auth
CREATE TABLE `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `role_id` INT UNSIGNED NOT NULL,
    `branch_id` INT UNSIGNED NULL,
    `name` VARCHAR(120) NOT NULL,
    `username` VARCHAR(60) NOT NULL UNIQUE,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(20) NULL,
    `two_factor_secret` VARCHAR(100) NULL,
    `two_factor_enabled` TINYINT(1) DEFAULT 0,
    `status` ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    `last_login_at` DATETIME NULL,
    `last_login_ip` VARCHAR(45) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`),
    FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE SET NULL,
    INDEX `idx_users_client` (`client_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Settings & White-Label Theming
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `themes`;

CREATE TABLE `settings` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NULL,
    `key` VARCHAR(100) NOT NULL,
    `value` LONGTEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_client_key` (`client_slug`, `key`),
    INDEX `idx_settings_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `themes` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `preset_key` VARCHAR(50) NOT NULL,
    `tokens_json` LONGTEXT NOT NULL,
    `layout_json` LONGTEXT NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_themes_client` (`client_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Product Categories, Products, Rates & Scheme Variants
DROP TABLE IF EXISTS `product_faqs`;
DROP TABLE IF EXISTS `product_documents`;
DROP TABLE IF EXISTS `product_variants`;
DROP TABLE IF EXISTS `product_rates`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `product_categories`;

CREATE TABLE `product_categories` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `slug` VARCHAR(50) NOT NULL,
    `type` ENUM('loan', 'deposit', 'facility', 'welfare') NOT NULL,
    `name_en` VARCHAR(100) NOT NULL,
    `name_ml` VARCHAR(100) NOT NULL,
    `description_en` TEXT NULL,
    `description_ml` TEXT NULL,
    `icon` VARCHAR(50) NULL,
    `sort_order` INT DEFAULT 0,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_cat_slug` (`client_slug`, `slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `products` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    `slug` VARCHAR(120) NOT NULL,
    `code` VARCHAR(30) NULL,
    `name_en` VARCHAR(150) NOT NULL,
    `name_ml` VARCHAR(150) NOT NULL,
    `tagline_en` VARCHAR(255) NULL,
    `tagline_ml` VARCHAR(255) NULL,
    `overview_en` LONGTEXT NOT NULL,
    `overview_ml` LONGTEXT NOT NULL,
    `target_audience` ENUM('members_only', 'open_to_public') DEFAULT 'members_only',
    `interest_rate_display` VARCHAR(50) NULL,
    `tenure_display_en` VARCHAR(100) NULL,
    `tenure_display_ml` VARCHAR(100) NULL,
    `max_amount_display_en` VARCHAR(100) NULL,
    `max_amount_display_ml` VARCHAR(100) NULL,
    `processing_fee_en` VARCHAR(150) NULL,
    `processing_fee_ml` VARCHAR(150) NULL,
    `security_required_en` TEXT NULL,
    `security_required_ml` TEXT NULL,
    `repayment_terms_en` TEXT NULL,
    `repayment_terms_ml` TEXT NULL,
    `badge_text_en` VARCHAR(50) NULL,
    `badge_text_ml` VARCHAR(50) NULL,
    `icon` VARCHAR(60) NULL,
    `featured_image` VARCHAR(255) NULL,
    `is_featured` TINYINT(1) DEFAULT 0,
    `show_on_rates_panel` TINYINT(1) DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    `status` ENUM('published', 'draft', 'archived') DEFAULT 'published',
    `meta_title_en` VARCHAR(200) NULL,
    `meta_title_ml` VARCHAR(200) NULL,
    `meta_desc_en` VARCHAR(300) NULL,
    `meta_desc_ml` VARCHAR(300) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES `product_categories`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `uk_product_slug` (`client_slug`, `slug`),
    INDEX `idx_product_type` (`client_slug`, `is_featured`, `status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_rates` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `product_id` INT UNSIGNED NULL,
    `category_type` ENUM('deposit', 'loan') NOT NULL,
    `tenure_label_en` VARCHAR(100) NOT NULL,
    `tenure_label_ml` VARCHAR(100) NOT NULL,
    `general_rate` DECIMAL(5, 2) NOT NULL,
    `senior_rate` DECIMAL(5, 2) NULL,
    `effective_from` DATE NOT NULL,
    `effective_to` DATE NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    `notes_en` VARCHAR(255) NULL,
    `notes_ml` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE SET NULL,
    INDEX `idx_rates_lookup` (`client_slug`, `category_type`, `is_active`, `effective_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_variants` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT UNSIGNED NOT NULL,
    `name_en` VARCHAR(150) NOT NULL,
    `name_ml` VARCHAR(150) NOT NULL,
    `ceiling_amount` DECIMAL(12, 2) NULL,
    `rate_display` VARCHAR(50) NOT NULL,
    `tenure` VARCHAR(100) NULL,
    `details_en` TEXT NULL,
    `details_ml` TEXT NULL,
    `sort_order` INT DEFAULT 0,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_documents` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT UNSIGNED NOT NULL,
    `title_en` VARCHAR(150) NOT NULL,
    `title_ml` VARCHAR(150) NOT NULL,
    `is_mandatory` TINYINT(1) DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_faqs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT UNSIGNED NOT NULL,
    `question_en` TEXT NOT NULL,
    `question_ml` TEXT NOT NULL,
    `answer_en` LONGTEXT NOT NULL,
    `answer_ml` LONGTEXT NOT NULL,
    `sort_order` INT DEFAULT 0,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Calculators Configuration
DROP TABLE IF EXISTS `calculators_config`;

CREATE TABLE `calculators_config` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `calculator_type` VARCHAR(50) NOT NULL,
    `config_json` LONGTEXT NOT NULL,
    `disclaimer_en` TEXT NOT NULL,
    `disclaimer_ml` TEXT NOT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_calc_client` (`client_slug`, `calculator_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Governance, Board of Directors & Chairperson
DROP TABLE IF EXISTS `board_members`;

CREATE TABLE `board_members` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `name_en` VARCHAR(120) NOT NULL,
    `name_ml` VARCHAR(120) NOT NULL,
    `designation_en` VARCHAR(100) NOT NULL,
    `designation_ml` VARCHAR(100) NOT NULL,
    `role_type` ENUM('chairperson', 'vice_chairperson', 'secretary', 'managing_director', 'director', 'patron') NOT NULL,
    `phone` VARCHAR(50) NULL,
    `email` VARCHAR(100) NULL,
    `message_en` LONGTEXT NULL,
    `message_ml` LONGTEXT NULL,
    `photo` VARCHAR(255) NULL,
    `sort_order` INT DEFAULT 0,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_board_client` (`client_slug`, `role_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Content: Pages, Menus, Banners, Announcements
DROP TABLE IF EXISTS `menu_items`;
DROP TABLE IF EXISTS `menus`;
DROP TABLE IF EXISTS `banners`;
DROP TABLE IF EXISTS `announcements`;
DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `slug` VARCHAR(120) NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `content_en` LONGTEXT NOT NULL,
    `content_ml` LONGTEXT NOT NULL,
    `template` VARCHAR(60) DEFAULT 'standard',
    `meta_title_en` VARCHAR(200) NULL,
    `meta_title_ml` VARCHAR(200) NULL,
    `meta_desc_en` VARCHAR(300) NULL,
    `meta_desc_ml` VARCHAR(300) NULL,
    `status` ENUM('published', 'draft') DEFAULT 'published',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_page_slug` (`client_slug`, `slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `menus` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `location` VARCHAR(50) NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_menu_loc` (`client_slug`, `location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `menu_items` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `menu_id` INT UNSIGNED NOT NULL,
    `parent_id` INT UNSIGNED NULL,
    `title_en` VARCHAR(120) NOT NULL,
    `title_ml` VARCHAR(120) NOT NULL,
    `url` VARCHAR(255) NOT NULL,
    `icon` VARCHAR(50) NULL,
    `target` VARCHAR(20) DEFAULT '_self',
    `sort_order` INT DEFAULT 0,
    FOREIGN KEY (`menu_id`) REFERENCES `menus`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`parent_id`) REFERENCES `menu_items`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `banners` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `subtitle_en` VARCHAR(255) NULL,
    `subtitle_ml` VARCHAR(255) NULL,
    `image_path` VARCHAR(255) NOT NULL,
    `link_url` VARCHAR(255) NULL,
    `button_text_en` VARCHAR(60) NULL,
    `button_text_ml` VARCHAR(60) NULL,
    `sort_order` INT DEFAULT 0,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `announcements` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `type` ENUM('ticker', 'popup_modal', 'top_bar') NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `message_en` TEXT NOT NULL,
    `message_ml` TEXT NOT NULL,
    `link_url` VARCHAR(255) NULL,
    `priority` ENUM('low', 'normal', 'urgent') DEFAULT 'normal',
    `start_date` DATETIME NOT NULL,
    `end_date` DATETIME NOT NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_announcement_active` (`client_slug`, `type`, `is_active`, `start_date`, `end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. News, Events, Offers, Achievements & Welfare Projects
DROP TABLE IF EXISTS `news`;
DROP TABLE IF EXISTS `events`;
DROP TABLE IF EXISTS `offers`;
DROP TABLE IF EXISTS `achievements`;
DROP TABLE IF EXISTS `gallery`;

CREATE TABLE `news` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `slug` VARCHAR(150) NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `excerpt_en` VARCHAR(300) NULL,
    `excerpt_ml` VARCHAR(300) NULL,
    `body_en` LONGTEXT NOT NULL,
    `body_ml` LONGTEXT NOT NULL,
    `image` VARCHAR(255) NULL,
    `publish_date` DATE NOT NULL,
    `status` ENUM('published', 'draft') DEFAULT 'published',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_news_slug` (`client_slug`, `slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `events` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `slug` VARCHAR(150) NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `venue_en` VARCHAR(200) NOT NULL,
    `venue_ml` VARCHAR(200) NOT NULL,
    `event_date` DATE NOT NULL,
    `event_time` VARCHAR(50) NULL,
    `description_en` LONGTEXT NOT NULL,
    `description_ml` LONGTEXT NOT NULL,
    `image` VARCHAR(255) NULL,
    `status` ENUM('upcoming', 'completed', 'cancelled') DEFAULT 'upcoming',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `offers` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `slug` VARCHAR(150) NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `description_en` TEXT NOT NULL,
    `description_ml` TEXT NOT NULL,
    `banner_image` VARCHAR(255) NULL,
    `valid_from` DATE NOT NULL,
    `valid_to` DATE NOT NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `achievements` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `title_en` VARCHAR(150) NOT NULL,
    `title_ml` VARCHAR(150) NOT NULL,
    `count_value` VARCHAR(50) NOT NULL,
    `suffix` VARCHAR(20) DEFAULT '+',
    `icon` VARCHAR(50) NULL,
    `sort_order` INT DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `gallery` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `title_en` VARCHAR(150) NOT NULL,
    `title_ml` VARCHAR(150) NOT NULL,
    `image_path` VARCHAR(255) NOT NULL,
    `category` VARCHAR(50) DEFAULT 'general',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Downloads, Careers, Tenders
DROP TABLE IF EXISTS `career_applications`;
DROP TABLE IF EXISTS `careers`;
DROP TABLE IF EXISTS `tenders`;
DROP TABLE IF EXISTS `downloads`;

CREATE TABLE `downloads` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `title_en` VARCHAR(150) NOT NULL,
    `title_ml` VARCHAR(150) NOT NULL,
    `category` VARCHAR(60) NOT NULL,
    `file_path` VARCHAR(255) NOT NULL,
    `file_size_kb` INT UNSIGNED DEFAULT 0,
    `file_type` VARCHAR(10) DEFAULT 'PDF',
    `download_count` INT UNSIGNED DEFAULT 0,
    `status` ENUM('active', 'archived') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tenders` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `tender_ref_no` VARCHAR(60) NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `description_en` TEXT NULL,
    `description_ml` TEXT NULL,
    `closing_date` DATETIME NOT NULL,
    `file_path` VARCHAR(255) NULL,
    `status` ENUM('active', 'closed', 'cancelled') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `careers` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `job_code` VARCHAR(50) NOT NULL,
    `title_en` VARCHAR(150) NOT NULL,
    `title_ml` VARCHAR(150) NOT NULL,
    `department_en` VARCHAR(100) NOT NULL,
    `department_ml` VARCHAR(100) NOT NULL,
    `location` VARCHAR(100) NOT NULL,
    `qualification_en` TEXT NOT NULL,
    `qualification_ml` TEXT NOT NULL,
    `experience_en` VARCHAR(100) NULL,
    `experience_ml` VARCHAR(100) NULL,
    `description_en` LONGTEXT NOT NULL,
    `description_ml` LONGTEXT NOT NULL,
    `last_date_to_apply` DATE NOT NULL,
    `status` ENUM('open', 'closed') DEFAULT 'open',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `career_applications` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `career_id` INT UNSIGNED NOT NULL,
    `applicant_name` VARCHAR(120) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `address` TEXT NULL,
    `resume_file` VARCHAR(255) NOT NULL,
    `cover_letter` TEXT NULL,
    `status` ENUM('new', 'shortlisted', 'rejected', 'hired') DEFAULT 'new',
    `internal_notes` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`career_id`) REFERENCES `careers`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Inboxes: Enquiries, Service Requests, Feedback, Callbacks
DROP TABLE IF EXISTS `enquiries`;
DROP TABLE IF EXISTS `service_requests`;
DROP TABLE IF EXISTS `feedback`;
DROP TABLE IF EXISTS `callback_requests`;

CREATE TABLE `enquiries` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `branch_id` INT UNSIGNED NULL,
    `tracking_code` VARCHAR(30) NOT NULL UNIQUE,
    `name` VARCHAR(120) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `subject` VARCHAR(150) NOT NULL,
    `category` VARCHAR(50) DEFAULT 'general',
    `message` TEXT NOT NULL,
    `status` ENUM('new', 'in_progress', 'resolved', 'closed') DEFAULT 'new',
    `assigned_to` INT UNSIGNED NULL,
    `internal_notes` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`assigned_to`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    INDEX `idx_enq_branch` (`branch_id`, `status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `service_requests` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `branch_id` INT UNSIGNED NOT NULL,
    `tracking_code` VARCHAR(30) NOT NULL UNIQUE,
    `request_type` ENUM('new_account', 'loan_enquiry', 'locker_request', 'statement_request', 'complaint', 'other') NOT NULL,
    `full_name` VARCHAR(120) NOT NULL,
    `member_number` VARCHAR(50) NULL,
    `email` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `message` TEXT NOT NULL,
    `attachment_path` VARCHAR(255) NULL,
    `status` ENUM('new', 'in_progress', 'resolved', 'closed') DEFAULT 'new',
    `assigned_to` INT UNSIGNED NULL,
    `resolution_notes` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`assigned_to`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    INDEX `idx_sr_branch_status` (`branch_id`, `status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `feedback` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `branch_id` INT UNSIGNED NULL,
    `name` VARCHAR(120) NOT NULL,
    `email` VARCHAR(150) NULL,
    `phone` VARCHAR(20) NULL,
    `rating` TINYINT UNSIGNED NOT NULL DEFAULT 5,
    `category` VARCHAR(50) DEFAULT 'service',
    `comments` TEXT NOT NULL,
    `status` ENUM('new', 'reviewed', 'archived') DEFAULT 'new',
    `ip_address` VARCHAR(45) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `callback_requests` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `branch_id` INT UNSIGNED NULL,
    `name` VARCHAR(120) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `interested_in` VARCHAR(100) NULL,
    `preferred_time` VARCHAR(50) NULL,
    `status` ENUM('pending', 'called', 'completed') DEFAULT 'pending',
    `notes` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Security Audit Log & Media Library
DROP TABLE IF EXISTS `audit_log`;
DROP TABLE IF EXISTS `media`;

CREATE TABLE `audit_log` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NULL,
    `action` VARCHAR(100) NOT NULL,
    `details` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    INDEX `idx_audit_user` (`user_id`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `media` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `filename` VARCHAR(255) NOT NULL,
    `original_name` VARCHAR(255) NOT NULL,
    `mime_type` VARCHAR(100) NOT NULL,
    `file_size_kb` INT UNSIGNED NOT NULL,
    `dimensions` VARCHAR(50) NULL,
    `alt_text_en` VARCHAR(200) NOT NULL,
    `alt_text_ml` VARCHAR(200) NOT NULL,
    `file_path` VARCHAR(255) NOT NULL,
    `thumbnail_path` VARCHAR(255) NULL,
    `created_by` INT UNSIGNED NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_media_client` (`client_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. Optional Modules: Unclaimed Deposits & Member Area (Phase 5)
DROP TABLE IF EXISTS `unclaimed_accounts`;
DROP TABLE IF EXISTS `members`;

CREATE TABLE `unclaimed_accounts` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `account_number_masked` VARCHAR(50) NOT NULL,
    `holder_name` VARCHAR(150) NOT NULL,
    `holder_address` TEXT NOT NULL,
    `branch_id` INT UNSIGNED NOT NULL,
    `unclaimed_amount` DECIMAL(12, 2) NOT NULL,
    `transferred_date` DATE NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE CASCADE,
    INDEX `idx_unclaimed_search` (`client_slug`, `holder_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `members` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_slug` VARCHAR(60) NOT NULL,
    `member_number` VARCHAR(50) NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `email` VARCHAR(150) NULL,
    `branch_id` INT UNSIGNED NOT NULL,
    `otp_hash` VARCHAR(255) NULL,
    `otp_expires_at` DATETIME NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_member_num` (`client_slug`, `member_number`),
    FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
