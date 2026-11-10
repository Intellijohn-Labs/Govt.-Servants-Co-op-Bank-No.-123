-- SQLite schema for local development and testing
-- Mirroring schema.sql

DROP TABLE IF EXISTS `role_permissions`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `slug` VARCHAR(50) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL,
    `description` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `permissions` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `name` VARCHAR(150) NOT NULL,
    `group_name` VARCHAR(50) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `role_permissions` (
    `role_id` INTEGER NOT NULL,
    `permission_id` INTEGER NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `branch_services`;
DROP TABLE IF EXISTS `branches`;

CREATE TABLE `branches` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `code` VARCHAR(20) NOT NULL,
    `name_en` VARCHAR(150) NOT NULL,
    `name_ml` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150) NOT NULL,
    `is_head_office` INTEGER DEFAULT 0,
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
    `has_locker` INTEGER DEFAULT 0,
    `has_365_days` INTEGER DEFAULT 0,
    `has_gold_loan` INTEGER DEFAULT 1,
    `has_atm` INTEGER DEFAULT 0,
    `latitude` DECIMAL(10, 8) NULL,
    `longitude` DECIMAL(11, 8) NULL,
    `directions_url` VARCHAR(255) NULL,
    `sort_order` INTEGER DEFAULT 0,
    `status` VARCHAR(20) DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `branch_services` (
    `branch_id` INTEGER NOT NULL,
    `service_name` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`branch_id`, `service_name`),
    FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE CASCADE
);

CREATE TABLE `users` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `role_id` INTEGER NOT NULL,
    `branch_id` INTEGER NULL,
    `name` VARCHAR(120) NOT NULL,
    `username` VARCHAR(60) NOT NULL UNIQUE,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(20) NULL,
    `two_factor_secret` VARCHAR(100) NULL,
    `two_factor_enabled` INTEGER DEFAULT 0,
    `status` VARCHAR(20) DEFAULT 'active',
    `last_login_at` DATETIME NULL,
    `last_login_ip` VARCHAR(45) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`),
    FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE SET NULL
);

DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `themes`;

CREATE TABLE `settings` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NULL,
    `key` VARCHAR(100) NOT NULL,
    `value` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (`client_slug`, `key`)
);

CREATE TABLE `themes` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `preset_key` VARCHAR(50) NOT NULL,
    `tokens_json` TEXT NOT NULL,
    `layout_json` TEXT NULL,
    `is_active` INTEGER DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `product_faqs`;
DROP TABLE IF EXISTS `product_documents`;
DROP TABLE IF EXISTS `product_variants`;
DROP TABLE IF EXISTS `product_rates`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `product_categories`;

CREATE TABLE `product_categories` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `slug` VARCHAR(50) NOT NULL,
    `type` VARCHAR(30) NOT NULL,
    `name_en` VARCHAR(100) NOT NULL,
    `name_ml` VARCHAR(100) NOT NULL,
    `description_en` TEXT NULL,
    `description_ml` TEXT NULL,
    `icon` VARCHAR(50) NULL,
    `sort_order` INTEGER DEFAULT 0,
    `status` VARCHAR(20) DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (`client_slug`, `slug`)
);

CREATE TABLE `products` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `category_id` INTEGER NOT NULL,
    `slug` VARCHAR(120) NOT NULL,
    `code` VARCHAR(30) NULL,
    `name_en` VARCHAR(150) NOT NULL,
    `name_ml` VARCHAR(150) NOT NULL,
    `tagline_en` VARCHAR(255) NULL,
    `tagline_ml` VARCHAR(255) NULL,
    `overview_en` TEXT NOT NULL,
    `overview_ml` TEXT NOT NULL,
    `target_audience` VARCHAR(50) DEFAULT 'members_only',
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
    `is_featured` INTEGER DEFAULT 0,
    `show_on_rates_panel` INTEGER DEFAULT 1,
    `sort_order` INTEGER DEFAULT 0,
    `status` VARCHAR(20) DEFAULT 'published',
    `meta_title_en` VARCHAR(200) NULL,
    `meta_title_ml` VARCHAR(200) NULL,
    `meta_desc_en` VARCHAR(300) NULL,
    `meta_desc_ml` VARCHAR(300) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (`client_slug`, `slug`),
    FOREIGN KEY (`category_id`) REFERENCES `product_categories`(`id`) ON DELETE CASCADE
);

CREATE TABLE `product_rates` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `product_id` INTEGER NULL,
    `category_type` VARCHAR(30) NOT NULL,
    `tenure_label_en` VARCHAR(100) NOT NULL,
    `tenure_label_ml` VARCHAR(100) NOT NULL,
    `general_rate` DECIMAL(5, 2) NOT NULL,
    `senior_rate` DECIMAL(5, 2) NULL,
    `effective_from` DATE NOT NULL,
    `effective_to` DATE NULL,
    `is_active` INTEGER DEFAULT 1,
    `sort_order` INTEGER DEFAULT 0,
    `notes_en` VARCHAR(255) NULL,
    `notes_ml` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE SET NULL
);

CREATE TABLE `product_variants` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `product_id` INTEGER NOT NULL,
    `name_en` VARCHAR(150) NOT NULL,
    `name_ml` VARCHAR(150) NOT NULL,
    `ceiling_amount` DECIMAL(12, 2) NULL,
    `rate_display` VARCHAR(50) NOT NULL,
    `tenure` VARCHAR(100) NULL,
    `details_en` TEXT NULL,
    `details_ml` TEXT NULL,
    `sort_order` INTEGER DEFAULT 0,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
);

CREATE TABLE `product_documents` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `product_id` INTEGER NOT NULL,
    `title_en` VARCHAR(150) NOT NULL,
    `title_ml` VARCHAR(150) NOT NULL,
    `is_mandatory` INTEGER DEFAULT 1,
    `sort_order` INTEGER DEFAULT 0,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
);

CREATE TABLE `product_faqs` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `product_id` INTEGER NOT NULL,
    `question_en` TEXT NOT NULL,
    `question_ml` TEXT NOT NULL,
    `answer_en` TEXT NOT NULL,
    `answer_ml` TEXT NOT NULL,
    `sort_order` INTEGER DEFAULT 0,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
);

CREATE TABLE `calculators_config` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `calculator_type` VARCHAR(50) NOT NULL,
    `config_json` TEXT NOT NULL,
    `disclaimer_en` TEXT NOT NULL,
    `disclaimer_ml` TEXT NOT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (`client_slug`, `calculator_type`)
);

CREATE TABLE `board_members` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `name_en` VARCHAR(120) NOT NULL,
    `name_ml` VARCHAR(120) NOT NULL,
    `designation_en` VARCHAR(100) NOT NULL,
    `designation_ml` VARCHAR(100) NOT NULL,
    `role_type` VARCHAR(50) NOT NULL,
    `phone` VARCHAR(50) NULL,
    `email` VARCHAR(100) NULL,
    `message_en` TEXT NULL,
    `message_ml` TEXT NULL,
    `photo` VARCHAR(255) NULL,
    `sort_order` INTEGER DEFAULT 0,
    `status` VARCHAR(20) DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `pages` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `slug` VARCHAR(120) NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `content_en` TEXT NOT NULL,
    `content_ml` TEXT NOT NULL,
    `template` VARCHAR(60) DEFAULT 'standard',
    `meta_title_en` VARCHAR(200) NULL,
    `meta_title_ml` VARCHAR(200) NULL,
    `meta_desc_en` VARCHAR(300) NULL,
    `meta_desc_ml` VARCHAR(300) NULL,
    `status` VARCHAR(20) DEFAULT 'published',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (`client_slug`, `slug`)
);

CREATE TABLE `menus` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `location` VARCHAR(50) NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (`client_slug`, `location`)
);

CREATE TABLE `menu_items` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `menu_id` INTEGER NOT NULL,
    `parent_id` INTEGER NULL,
    `title_en` VARCHAR(120) NOT NULL,
    `title_ml` VARCHAR(120) NOT NULL,
    `url` VARCHAR(255) NOT NULL,
    `icon` VARCHAR(50) NULL,
    `target` VARCHAR(20) DEFAULT '_self',
    `sort_order` INTEGER DEFAULT 0,
    FOREIGN KEY (`menu_id`) REFERENCES `menus`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`parent_id`) REFERENCES `menu_items`(`id`) ON DELETE CASCADE
);

CREATE TABLE `banners` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `subtitle_en` VARCHAR(255) NULL,
    `subtitle_ml` VARCHAR(255) NULL,
    `image_path` VARCHAR(255) NOT NULL,
    `link_url` VARCHAR(255) NULL,
    `button_text_en` VARCHAR(60) NULL,
    `button_text_ml` VARCHAR(60) NULL,
    `sort_order` INTEGER DEFAULT 0,
    `status` VARCHAR(20) DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `announcements` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `type` VARCHAR(50) NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `message_en` TEXT NOT NULL,
    `message_ml` TEXT NOT NULL,
    `link_url` VARCHAR(255) NULL,
    `priority` VARCHAR(20) DEFAULT 'normal',
    `start_date` DATETIME NOT NULL,
    `end_date` DATETIME NOT NULL,
    `is_active` INTEGER DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `news` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `slug` VARCHAR(150) NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `excerpt_en` VARCHAR(300) NULL,
    `excerpt_ml` VARCHAR(300) NULL,
    `body_en` TEXT NOT NULL,
    `body_ml` TEXT NOT NULL,
    `image` VARCHAR(255) NULL,
    `publish_date` DATE NOT NULL,
    `status` VARCHAR(20) DEFAULT 'published',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (`client_slug`, `slug`)
);

CREATE TABLE `events` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `slug` VARCHAR(150) NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `venue_en` VARCHAR(200) NOT NULL,
    `venue_ml` VARCHAR(200) NOT NULL,
    `event_date` DATE NOT NULL,
    `event_time` VARCHAR(50) NULL,
    `description_en` TEXT NOT NULL,
    `description_ml` TEXT NOT NULL,
    `image` VARCHAR(255) NULL,
    `status` VARCHAR(20) DEFAULT 'upcoming',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `offers` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `slug` VARCHAR(150) NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `description_en` TEXT NOT NULL,
    `description_ml` TEXT NOT NULL,
    `banner_image` VARCHAR(255) NULL,
    `valid_from` DATE NOT NULL,
    `valid_to` DATE NOT NULL,
    `is_active` INTEGER DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `achievements` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `title_en` VARCHAR(150) NOT NULL,
    `title_ml` VARCHAR(150) NOT NULL,
    `count_value` VARCHAR(50) NOT NULL,
    `suffix` VARCHAR(20) DEFAULT '+',
    `icon` VARCHAR(50) NULL,
    `sort_order` INTEGER DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `gallery` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `title_en` VARCHAR(150) NOT NULL,
    `title_ml` VARCHAR(150) NOT NULL,
    `image_path` VARCHAR(255) NOT NULL,
    `category` VARCHAR(50) DEFAULT 'general',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `downloads` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `title_en` VARCHAR(150) NOT NULL,
    `title_ml` VARCHAR(150) NOT NULL,
    `category` VARCHAR(60) NOT NULL,
    `file_path` VARCHAR(255) NOT NULL,
    `file_size_kb` INTEGER DEFAULT 0,
    `file_type` VARCHAR(10) DEFAULT 'PDF',
    `download_count` INTEGER DEFAULT 0,
    `status` VARCHAR(20) DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `tenders` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `tender_ref_no` VARCHAR(60) NOT NULL,
    `title_en` VARCHAR(200) NOT NULL,
    `title_ml` VARCHAR(200) NOT NULL,
    `description_en` TEXT NULL,
    `description_ml` TEXT NULL,
    `closing_date` DATETIME NOT NULL,
    `file_path` VARCHAR(255) NULL,
    `status` VARCHAR(20) DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `careers` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
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
    `description_en` TEXT NOT NULL,
    `description_ml` TEXT NOT NULL,
    `last_date_to_apply` DATE NOT NULL,
    `status` VARCHAR(20) DEFAULT 'open',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `career_applications` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `career_id` INTEGER NOT NULL,
    `applicant_name` VARCHAR(120) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `address` TEXT NULL,
    `resume_file` VARCHAR(255) NOT NULL,
    `cover_letter` TEXT NULL,
    `status` VARCHAR(20) DEFAULT 'new',
    `internal_notes` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`career_id`) REFERENCES `careers`(`id`) ON DELETE CASCADE
);

CREATE TABLE `enquiries` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `branch_id` INTEGER NULL,
    `tracking_code` VARCHAR(30) NOT NULL UNIQUE,
    `name` VARCHAR(120) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `subject` VARCHAR(150) NOT NULL,
    `category` VARCHAR(50) DEFAULT 'general',
    `message` TEXT NOT NULL,
    `status` VARCHAR(20) DEFAULT 'new',
    `assigned_to` INTEGER NULL,
    `internal_notes` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`assigned_to`) REFERENCES `users`(`id`) ON DELETE SET NULL
);

CREATE TABLE `service_requests` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `branch_id` INTEGER NOT NULL,
    `tracking_code` VARCHAR(30) NOT NULL UNIQUE,
    `request_type` VARCHAR(50) NOT NULL,
    `full_name` VARCHAR(120) NOT NULL,
    `member_number` VARCHAR(50) NULL,
    `email` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `message` TEXT NOT NULL,
    `attachment_path` VARCHAR(255) NULL,
    `status` VARCHAR(20) DEFAULT 'new',
    `assigned_to` INTEGER NULL,
    `resolution_notes` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`assigned_to`) REFERENCES `users`(`id`) ON DELETE SET NULL
);

CREATE TABLE `feedback` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `branch_id` INTEGER NULL,
    `name` VARCHAR(120) NOT NULL,
    `email` VARCHAR(150) NULL,
    `phone` VARCHAR(20) NULL,
    `rating` INTEGER NOT NULL DEFAULT 5,
    `category` VARCHAR(50) DEFAULT 'service',
    `comments` TEXT NOT NULL,
    `status` VARCHAR(20) DEFAULT 'new',
    `ip_address` VARCHAR(45) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `callback_requests` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `branch_id` INTEGER NULL,
    `name` VARCHAR(120) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `interested_in` VARCHAR(100) NULL,
    `preferred_time` VARCHAR(50) NULL,
    `status` VARCHAR(20) DEFAULT 'pending',
    `notes` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `audit_log` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `user_id` INTEGER NULL,
    `action` VARCHAR(100) NOT NULL,
    `details` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
);

CREATE TABLE `media` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `filename` VARCHAR(255) NOT NULL,
    `original_name` VARCHAR(255) NOT NULL,
    `mime_type` VARCHAR(100) NOT NULL,
    `file_size_kb` INTEGER NOT NULL,
    `dimensions` VARCHAR(50) NULL,
    `alt_text_en` VARCHAR(200) NOT NULL,
    `alt_text_ml` VARCHAR(200) NOT NULL,
    `file_path` VARCHAR(255) NOT NULL,
    `thumbnail_path` VARCHAR(255) NULL,
    `created_by` INTEGER NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `unclaimed_accounts` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `account_number_masked` VARCHAR(50) NOT NULL,
    `holder_name` VARCHAR(150) NOT NULL,
    `holder_address` TEXT NOT NULL,
    `branch_id` INTEGER NOT NULL,
    `unclaimed_amount` DECIMAL(12, 2) NOT NULL,
    `transferred_date` DATE NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE CASCADE
);

CREATE TABLE `members` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `client_slug` VARCHAR(60) NOT NULL,
    `member_number` VARCHAR(50) NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `email` VARCHAR(150) NULL,
    `branch_id` INTEGER NOT NULL,
    `otp_hash` VARCHAR(255) NULL,
    `otp_expires_at` DATETIME NULL,
    `status` VARCHAR(20) DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (`client_slug`, `member_number`),
    FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE CASCADE
);
