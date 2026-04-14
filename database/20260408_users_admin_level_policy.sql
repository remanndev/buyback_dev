UPDATE users_admin
SET level = 80
WHERE type = 'PARTNER';

UPDATE users_admin
SET level = 90
WHERE type IN ('SITE', 'BOTH')
  AND LOWER(username) NOT IN ('sadmin', 'admin');