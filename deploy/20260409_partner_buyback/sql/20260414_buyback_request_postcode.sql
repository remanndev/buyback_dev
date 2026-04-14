SET @has_postcode := (
    SELECT COUNT(1)
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'buyback_request'
      AND column_name = 'postcode'
);

SET @sql_postcode_col := IF(
    @has_postcode = 0,
    'ALTER TABLE `buyback_request` ADD COLUMN `postcode` VARCHAR(10) DEFAULT NULL AFTER `phone`',
    'SELECT 1'
);

PREPARE stmt FROM @sql_postcode_col;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
