CREATE TABLE `buyback_spec_master` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `device_type` VARCHAR(30) NOT NULL,
    `part_type` VARCHAR(50) NOT NULL DEFAULT '',
    `manufacturer` VARCHAR(100) NOT NULL DEFAULT '',
    `category_name` VARCHAR(150) NOT NULL DEFAULT '',
    `model_name` VARCHAR(191) NOT NULL,
    `price_value` INT(11) NULL DEFAULT NULL,
    `sort_order` INT(11) NOT NULL DEFAULT 100,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_buyback_spec_identity` (`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`),
    KEY `idx_buyback_spec_active` (`is_active`),
    KEY `idx_buyback_spec_device` (`device_type`, `part_type`),
    KEY `idx_buyback_spec_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
