SET @partner_slug := 'sample-partner';
SET @partner_name := '샘플 회원사';
SET @partner_admin_user_id := 2;
SET @partner_admin_type := 'BOTH';

UPDATE `users_admin`
SET `type` = @partner_admin_type
WHERE `id` = @partner_admin_user_id;

INSERT INTO `partner` (
    `slug`,
    `name`,
    `is_active`
) VALUES (
    @partner_slug,
    @partner_name,
    1
)
ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `is_active` = VALUES(`is_active`);

SET @partner_id := (
    SELECT `id`
    FROM `partner`
    WHERE `slug` = @partner_slug
    LIMIT 1
);

INSERT INTO `partner_admin_map` (
    `partner_id`,
    `admin_user_id`,
    `is_active`
) VALUES (
    @partner_id,
    @partner_admin_user_id,
    1
)
ON DUPLICATE KEY UPDATE
    `is_active` = VALUES(`is_active`);

SELECT
    p.`id`,
    p.`slug`,
    p.`name`,
    p.`is_active`,
    pam.`admin_user_id`,
    ua.`type` AS `admin_type`
FROM `partner` p
LEFT JOIN `partner_admin_map` pam
    ON pam.`partner_id` = p.`id`
LEFT JOIN `users_admin` ua
    ON ua.`id` = pam.`admin_user_id`
WHERE p.`slug` = @partner_slug;
