SET SESSION sql_mode = '';

SET @has_ype := (
    SELECT COUNT(1)
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'users_admin'
      AND column_name = 'ype'
);

SET @sql_drop_ype := IF(@has_ype = 1,
    'ALTER TABLE `users_admin` DROP COLUMN `ype`',
    'SELECT 1');
PREPARE stmt FROM @sql_drop_ype;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @has_type := (
    SELECT COUNT(1)
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'users_admin'
      AND column_name = 'type'
);

SET @sql_type_col := IF(@has_type = 0,
    'ALTER TABLE `users_admin` ADD COLUMN `type` VARCHAR(20) NOT NULL DEFAULT ''SITE'' AFTER `level`',
    'SELECT 1');
PREPARE stmt FROM @sql_type_col;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

UPDATE `users_admin`
SET `type` = 'SITE'
WHERE `type` IS NULL OR TRIM(`type`) = '';

SET @has_idx_type := (
    SELECT COUNT(1)
    FROM information_schema.statistics
    WHERE table_schema = DATABASE()
      AND table_name = 'users_admin'
      AND index_name = 'idx_users_admin_type'
);

SET @sql_type_idx := IF(@has_idx_type = 0,
    'ALTER TABLE `users_admin` ADD KEY `idx_users_admin_type` (`type`)',
    'SELECT 1');
PREPARE stmt FROM @sql_type_idx;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
