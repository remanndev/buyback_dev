CREATE TABLE IF NOT EXISTS `partner` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(60) NOT NULL,
    `name` VARCHAR(120) NOT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `ros_api_url` VARCHAR(255) DEFAULT NULL,
    `ros_api_key` VARCHAR(255) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_partner_slug` (`slug`),
    KEY `idx_partner_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `partner_admin_map` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `partner_id` BIGINT UNSIGNED NOT NULL,
    `admin_user_id` INT NOT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_partner_admin` (`partner_id`, `admin_user_id`),
    KEY `idx_partner_admin_active` (`partner_id`, `is_active`),
    KEY `idx_partner_admin_user` (`admin_user_id`),
    CONSTRAINT `fk_partner_admin_map_partner`
        FOREIGN KEY (`partner_id`) REFERENCES `partner` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_partner_admin_map_admin_user`
        FOREIGN KEY (`admin_user_id`) REFERENCES `users_admin` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET @has_member_user_id := (
    SELECT COUNT(1)
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'buyback_request'
      AND column_name = 'member_user_id'
);
SET @sql_member_user_col := IF(@has_member_user_id = 0,
    'ALTER TABLE `buyback_request` ADD COLUMN `member_user_id` INT DEFAULT NULL AFTER `partner_id`',
    'SELECT 1');
PREPARE stmt FROM @sql_member_user_col;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @has_api_send_status := (
    SELECT COUNT(1)
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'buyback_request'
      AND column_name = 'api_send_status'
);
SET @sql_api_send_status_col := IF(@has_api_send_status = 0,
    'ALTER TABLE `buyback_request` ADD COLUMN `api_send_status` VARCHAR(20) NOT NULL DEFAULT ''READY'' AFTER `ros_wa_id`',
    'SELECT 1');
PREPARE stmt FROM @sql_api_send_status_col;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @has_api_sent_at := (
    SELECT COUNT(1)
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'buyback_request'
      AND column_name = 'api_sent_at'
);
SET @sql_api_sent_at_col := IF(@has_api_sent_at = 0,
    'ALTER TABLE `buyback_request` ADD COLUMN `api_sent_at` DATETIME DEFAULT NULL AFTER `api_send_status`',
    'SELECT 1');
PREPARE stmt FROM @sql_api_sent_at_col;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @has_api_error_message := (
    SELECT COUNT(1)
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'buyback_request'
      AND column_name = 'api_error_message'
);
SET @sql_api_error_message_col := IF(@has_api_error_message = 0,
    'ALTER TABLE `buyback_request` ADD COLUMN `api_error_message` VARCHAR(255) DEFAULT NULL AFTER `api_sent_at`',
    'SELECT 1');
PREPARE stmt FROM @sql_api_error_message_col;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @has_api_request_payload := (
    SELECT COUNT(1)
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'buyback_request'
      AND column_name = 'api_request_payload'
);
SET @sql_api_request_payload_col := IF(@has_api_request_payload = 0,
    'ALTER TABLE `buyback_request` ADD COLUMN `api_request_payload` LONGTEXT DEFAULT NULL AFTER `api_error_message`',
    'SELECT 1');
PREPARE stmt FROM @sql_api_request_payload_col;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @has_api_response_payload := (
    SELECT COUNT(1)
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'buyback_request'
      AND column_name = 'api_response_payload'
);
SET @sql_api_response_payload_col := IF(@has_api_response_payload = 0,
    'ALTER TABLE `buyback_request` ADD COLUMN `api_response_payload` LONGTEXT DEFAULT NULL AFTER `api_request_payload`',
    'SELECT 1');
PREPARE stmt FROM @sql_api_response_payload_col;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @has_idx_member_user := (
    SELECT COUNT(1)
    FROM information_schema.statistics
    WHERE table_schema = DATABASE()
      AND table_name = 'buyback_request'
      AND index_name = 'idx_member_user_id'
);
SET @sql_member_user := IF(@has_idx_member_user = 0,
    'ALTER TABLE `buyback_request` ADD KEY `idx_member_user_id` (`member_user_id`)',
    'SELECT 1');
PREPARE stmt FROM @sql_member_user;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @has_idx_api_status := (
    SELECT COUNT(1)
    FROM information_schema.statistics
    WHERE table_schema = DATABASE()
      AND table_name = 'buyback_request'
      AND index_name = 'idx_api_send_status'
);
SET @sql_api_status := IF(@has_idx_api_status = 0,
    'ALTER TABLE `buyback_request` ADD KEY `idx_api_send_status` (`api_send_status`)',
    'SELECT 1');
PREPARE stmt FROM @sql_api_status;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @has_idx_ros := (
    SELECT COUNT(1)
    FROM information_schema.statistics
    WHERE table_schema = DATABASE()
      AND table_name = 'buyback_request'
      AND index_name = 'idx_ros_wa_id'
);
SET @sql_ros := IF(@has_idx_ros = 0,
    'ALTER TABLE `buyback_request` ADD KEY `idx_ros_wa_id` (`ros_wa_id`)',
    'SELECT 1');
PREPARE stmt FROM @sql_ros;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
