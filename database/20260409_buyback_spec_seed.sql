-- Generated from application/views/sell/sell_view.php.260326.bak
-- Run after 20260409_buyback_spec_master.sql
INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 1세대', '라이젠 1200', 3000, 10, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 1세대', '라이젠 1300', 4000, 20, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 1세대', '라이젠 1400', 4000, 30, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 1세대', '라이젠 1500', 4839, 40, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 1세대', '라이젠 1600', 10516, 50, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 1세대', '라이젠 1700', 20000, 60, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 1세대', '라이젠 1800', 22000, 70, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 2세대', '라이젠 2200', 10000, 80, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 2세대', '라이젠 2400', 16000, 90, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 2세대', '라이젠 2600', 17500, 100, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 2세대', '라이젠 2700', 31000, 110, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 3세대', 'AMD 라이젠 3100', 10000, 120, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 3세대', 'AMD 라이젠 3200', 15000, 130, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 3세대', 'AMD 라이젠 3300', 12000, 140, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 3세대', 'AMD 라이젠 3400', 20000, 150, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 3세대', 'AMD 라이젠 3500', 19000, 160, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 3세대', 'AMD 라이젠 3600', 28000, 170, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 3세대', 'AMD 라이젠 3600X/XT', 30000, 180, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 3세대', 'AMD 라이젠 3700', 50000, 190, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 3세대', 'AMD 라이젠 3800X/XT', 55000, 200, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 3세대', 'AMD 라이젠 3900X/XT', 80000, 210, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 3세대', 'AMD 라이젠 4350', 20000, 220, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 3세대', 'AMD 라이젠 4650', 35000, 230, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 3세대', 'AMD 라이젠 4750', 45000, 240, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 4세대', 'AMD 라이젠 5500', 40000, 250, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 4세대', 'AMD 라이젠 5600', 58871, 260, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 4세대', 'AMD 라이젠 5700', 75000, 270, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 4세대', 'AMD 라이젠 5800', 110000, 280, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 4세대', 'AMD 라이젠 5800X3D', 150000, 290, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 4세대', 'AMD 라이젠 5900', 140000, 300, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 4세대', 'AMD 라이젠 5950', 180000, 310, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 5세대', 'AMD 라이젠 7500', 60000, 320, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 5세대', 'AMD 라이젠 7600', 80000, 330, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 5세대', 'AMD 라이젠 7700', 120000, 340, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 5세대', 'AMD 라이젠 7800X3D', 220000, 350, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 5세대', 'AMD 라이젠 7900', 170000, 360, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 5세대', 'AMD 라이젠 7900X3D', 230000, 370, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 5세대', 'AMD 라이젠 7950', 280000, 380, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 5세대', 'AMD 라이젠 7950X3D', 370000, 390, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 6세대', 'AMD 라이젠5 9600', 110000, 400, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 6세대', 'AMD 라이젠5 9700', 150000, 410, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 6세대', 'AMD 라이젠7 9800X3D', 330000, 420, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 6세대', 'AMD 라이젠9 9900', 220000, 430, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 6세대', 'AMD 라이젠9 9900X3D', 300000, 440, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 6세대', 'AMD 라이젠9 9950', 330000, 450, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', 'AMD 6세대', 'AMD 라이젠9 9950X3D', 430000, 460, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 10세대', '인텔 셀러론 G5900', 14710, 470, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 10세대', '인텔 코어i3 10100', 54548, 480, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 10세대', '인텔 코어i5 10400', 83710, 490, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 10세대', '인텔 코어i5 10500', 86694, 500, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 10세대', '인텔 코어i5 10600', 78508, 510, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 10세대', '인텔 코어i7 10700', 170726, 520, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 10세대', '인텔 코어i9 10850', 186452, 530, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 10세대', '인텔 코어i9 10900', 229839, 540, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 10세대', '인텔 펜티엄 G6400', 30000, 550, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 11세대', '인텔 코어i5 11400', 73710, 560, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 11세대', '인텔 코어i5 11500', 78710, 570, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 11세대', '인텔 코어i5 11600', 69960, 580, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 11세대', '인텔 코어i7 11700', 144839, 590, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 11세대', '인텔 코어i9 11900', 166008, 600, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 12세대', '인텔 코어i3 12100', 54919, 610, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 12세대', '인텔 코어i5 12400', 89355, 620, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 12세대', '인텔 코어i5 12500', 116452, 630, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 12세대', '인텔 코어i5 12600', 98495, 640, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 12세대', '인텔 코어i7 12700', 190927, 650, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 12세대', '인텔 코어i9 12900', 232968, 660, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 12세대', '인텔 펜티엄 G6900', 30000, 670, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 12세대', '인텔 펜티엄 G7400', 37419, 680, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 13세대', '인텔 코어i3 13100', 57016, 690, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 13세대', '인텔 코어i5 13400', 95645, 700, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 13세대', '인텔 코어i5 13500', 116452, 710, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 13세대', '인텔 코어i5 13600', 98226, 720, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 13세대', '인텔 코어i7 13700', 199234, 730, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 13세대', '인텔 코어i9 13900', 306000, 740, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 14세대', '인텔 코어I3 14100', 62419, 750, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 14세대', '인텔 코어I5 14400', 104032, 760, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 14세대', '인텔 코어I5 14500', 124839, 770, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 14세대', '인텔 코어I5 14600', 106613, 780, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 14세대', '인텔 코어I7 14700', 217823, 790, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 14세대', '인텔 코어I9 14900', 323306, 800, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 1세대', '인텔 제온 G6950', 100, 810, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 1세대', '인텔 코어i3 530', 100, 820, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 1세대', '인텔 코어i3 540', 100, 830, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 1세대', '인텔 코어i3 550', 100, 840, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 1세대', '인텔 코어i5 650', 200, 850, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 1세대', '인텔 코어i5 660', 200, 860, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 1세대', '인텔 코어i5 661', 200, 870, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 1세대', '인텔 코어i5 750', 100, 880, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 1세대', '인텔 코어i5 760', 100, 890, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 1세대', '인텔 코어i7 860', 300, 900, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 1세대', '인텔 코어i7 870', 400, 910, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 1세대', '인텔 코어i7 875', 400, 920, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 1세대', '인텔 코어i7 880', 400, 930, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 코어i3 2100', 500, 940, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 코어i3 2105', 500, 950, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 코어i3 2120', 500, 960, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 코어i3 2130', 500, 970, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 코어i5 2300', 4000, 980, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 코어i5 2310', 4000, 990, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 코어i5 2320', 5000, 1000, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 코어i5 2400', 6000, 1010, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 코어i5 2500', 7000, 1020, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 코어i7 2600', 22000, 1030, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 코어i7 2700', 22000, 1040, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 펜티엄 G530', 100, 1050, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 펜티엄 G540', 100, 1060, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 펜티엄 G550', 100, 1070, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 펜티엄 G620', 100, 1080, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 펜티엄 G630', 100, 1090, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 펜티엄 G640', 100, 1100, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 펜티엄 G645', 100, 1110, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 펜티엄 G840', 100, 1120, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 펜티엄 G850', 100, 1130, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 펜티엄 G860', 100, 1140, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 2세대', '인텔 펜티엄 G870', 100, 1150, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 코어i3 3210', 300, 1160, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 코어i3 3220', 500, 1170, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 코어i3 3240', 500, 1180, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 코어i3 3250', 500, 1190, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 코어i5 3330', 5000, 1200, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 코어i5 3350', 5000, 1210, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 코어i5 3450', 6000, 1220, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 코어i5 3470', 8000, 1230, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 코어i5 3550', 7000, 1240, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 코어i5 3570', 9000, 1250, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 코어i7 3770', 29500, 1260, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 펜티엄 G1610', 100, 1270, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 펜티엄 G1620', 100, 1280, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 펜티엄 G1630', 100, 1290, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 펜티엄 G2020', 200, 1300, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 펜티엄 G2030', 200, 1310, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 펜티엄 G2120', 200, 1320, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 펜티엄 G2130', 200, 1330, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 3세대', '인텔 펜티엄 G2150', 200, 1340, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i3 4130', 500, 1350, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i3 4150', 500, 1360, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i3 4160', 500, 1370, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i3 4170', 500, 1380, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i3 4330', 700, 1390, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i3 4340', 700, 1400, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i3 4360', 700, 1410, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i3 4370', 700, 1420, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i5 4430', 11000, 1430, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i5 4440', 12000, 1440, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i5 4450', 12000, 1450, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i5 4460', 13000, 1460, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i5 4570', 14000, 1470, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i5 4590', 14000, 1480, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i5 4670', 14000, 1490, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i5 4690', 14000, 1500, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i7 4770', 32000, 1510, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 코어i7 4790', 34500, 1520, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G1820', 100, 1530, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G1830', 100, 1540, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G1840', 100, 1550, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G1850', 100, 1560, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G3220', 200, 1570, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G3240', 200, 1580, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G3250', 200, 1590, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G3258', 200, 1600, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G3260', 200, 1610, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G3420', 200, 1620, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G3430', 200, 1630, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G3440', 200, 1640, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G3450', 200, 1650, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 4세대', '인텔 펜티엄 G3460', 200, 1660, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 6세대', '인텔 코어i3 6100', 3000, 1670, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 6세대', '인텔 코어i3 6300', 3000, 1680, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 6세대', '인텔 코어i3 6320', 3000, 1690, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 6세대', '인텔 코어i5 6400', 24000, 1700, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 6세대', '인텔 코어i5 6500', 25000, 1710, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 6세대', '인텔 코어i5 6600', 25000, 1720, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 6세대', '인텔 코어i7 6700', 47500, 1730, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 6세대', '인텔 펜티엄 G3900', 100, 1740, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 6세대', '인텔 펜티엄 G3920', 100, 1750, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 6세대', '인텔 펜티엄 G4400', 500, 1760, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 6세대', '인텔 펜티엄 G4500', 500, 1770, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 6세대', '인텔 펜티엄 G4520', 500, 1780, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 7세대', '인텔 코어i3 7100', 5323, 1790, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 7세대', '인텔 코어i3 7300', 5323, 1800, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 7세대', '인텔 코어i3 7350', 5323, 1810, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 7세대', '인텔 코어i5 7400', 34258, 1820, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 7세대', '인텔 코어i5 7500', 36258, 1830, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 7세대', '인텔 코어i5 7600', 36258, 1840, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 7세대', '인텔 코어i7 7320', 5323, 1850, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 7세대', '인텔 코어i7 7700', 67774, 1860, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 7세대', '인텔 펜티엄 G3930', 100, 1870, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 7세대', '인텔 펜티엄 G3950', 100, 1880, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 7세대', '인텔 펜티엄 G4560', 500, 1890, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 7세대', '인텔 펜티엄 G4600', 500, 1900, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 7세대', '인텔 펜티엄 G4620', 500, 1910, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 8세대', '인텔 셀러론 G4900', 468, 1920, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 8세대', '인텔 셀러론 G4920', 468, 1930, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 8세대', '인텔 코어i3 8100', 13000, 1940, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 8세대', '인텔 코어i3 8350', 14000, 1950, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 8세대', '인텔 코어i5 8400', 57000, 1960, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 8세대', '인텔 코어i5 8500', 60000, 1970, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 8세대', '인텔 코어i5 8600', 60000, 1980, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 8세대', '인텔 코어i7 8700', 111694, 1990, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 8세대', '인텔 펜티엄 G5400', 1000, 2000, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 8세대', '인텔 펜티엄 G5600', 1000, 2010, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 9세대', '인텔 셀러론 G4930', 474, 2020, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 9세대', '인텔 코어i3 9100', 16661, 2030, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 9세대', '인텔 코어i5 9400', 58177, 2040, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 9세대', '인텔 코어i5 9500', 58597, 2050, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 9세대', '인텔 코어i5 9600', 52218, 2060, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 9세대', '인텔 코어i7 9700', 116855, 2070, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 9세대', '인텔 코어i9 9900', 210538, 2080, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 9세대', '인텔 펜티엄 G5420', 1000, 2090, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔 9세대', '인텔 펜티엄 G5620', 1000, 2100, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔1366소켓', '인텔 코어i7 920', 200, 2110, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔1366소켓', '인텔 코어i7 930', 200, 2120, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔1366소켓', '인텔 코어i7 940', 200, 2130, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔1366소켓', '인텔 코어i7 950', 200, 2140, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔1366소켓', '인텔 코어i7 960', 300, 2150, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔1366소켓', '인텔 코어i7 965', 300, 2160, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔1366소켓', '인텔 코어i7 975', 300, 2170, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔1366소켓', '인텔 코어i7 980', 450, 2180, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔1366소켓', '인텔 코어i7 990', 1000, 2190, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔2010소켓', '인텔 i7 6900', 4000, 2200, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔2011소켓', '인텔 i7 3820', 500, 2210, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔2011소켓', '인텔 i7 3930', 1000, 2220, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔2011소켓', '인텔 i7 3960', 1500, 2230, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔2011소켓', '인텔 i7 3970', 2000, 2240, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔2011소켓', '인텔 i7 4820', 1000, 2250, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔2011소켓', '인텔 i7 4930', 1500, 2260, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔2011소켓', '인텔 i7 4960', 2000, 2270, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔2011소켓', '인텔 i7 5820', 1500, 2280, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔2011소켓', '인텔 i7 5930', 2000, 2290, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔2011소켓', '인텔 i7 5960', 2500, 2300, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'CPU', '', '인텔2011소켓', '인텔 i7 6800', 3000, 2310, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '노트북용HDD', '노트북용 1.5TB SATA', 7000, 2320, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '노트북용HDD', '노트북용 1TB SATA', 6000, 2330, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '노트북용HDD', '노트북용 2TB SATA', 12000, 2340, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '노트북용HDD', '노트북용 500G SATA', 1000, 2350, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '노트북용HDD', '노트북용 640G SATA', 1000, 2360, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '노트북용HDD', '노트북용 750G SATA', 1000, 2370, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑', '8TB SATA', 40000, 2380, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '1.5TB SATA', 6000, 2390, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '10TB SATA', 40000, 2400, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '12TB SATA', 45000, 2410, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '14TB SATA', 50000, 2420, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '16TB SATA', 55000, 2430, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '18TB SATA', 60000, 2440, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '1TB SATA', 5000, 2450, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '2TB SATA', 10000, 2460, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '3TB SATA', 15000, 2470, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '4TB SATA', 20000, 2480, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '500G SATA', 1000, 2490, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '5TB SATA', 25000, 2500, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '640G SATA', 1000, 2510, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '6TB SATA', 30000, 2520, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('HDD', '', '', '데스크탑HDD', '750G SATA', 1000, 2530, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('모니터', '', '', '삼성/LG', '삼성 LG LED 20인치', 1000, 2540, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('모니터', '', '', '삼성/LG', '삼성 LG LED 22인치', 5000, 2550, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('모니터', '', '', '삼성/LG', '삼성 LG LED 23인치', 5000, 2560, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('모니터', '', '', '삼성/LG', '삼성 LG LED 24인치', 10000, 2570, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('모니터', '', '', '삼성/LG', '삼성 LG LED 27인치', 25000, 2580, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('모니터', '', '', '삼성/LG', '삼성 LG LED 32인치', 35000, 2590, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('모니터', '', '', '중소기업', '중소기업 LED 20인치', 1000, 2600, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('모니터', '', '', '중소기업', '중소기업 LED 22인치', 3000, 2610, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('모니터', '', '', '중소기업', '중소기업 LED 23인치', 3000, 2620, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('모니터', '', '', '중소기업', '중소기업 LED 24인치', 5000, 2630, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('모니터', '', '', '중소기업', '중소기업 LED 27인치', 15000, 2640, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('모니터', '', '', '중소기업', '중소기업 LED 32인치', 35000, 2650, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD A320 칩셋', 12000, 2660, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD A520 칩셋', 15000, 2670, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD A620 칩셋', 25000, 2680, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD B350 칩셋', 15000, 2690, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD B450 칩셋', 20000, 2700, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD B550 칩셋', 20000, 2710, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD B650 칩셋', 30000, 2720, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD B650E 칩셋', 45000, 2730, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD X370 칩셋', 15000, 2740, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD X399 칩셋', 40000, 2750, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD X470 칩셋', 25000, 2760, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD X570 칩셋', 35000, 2770, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD X670 칩셋', 50000, 2780, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', 'RYZEN', 'AMD X670E 칩셋', 55000, 2790, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 10,11세대', 'B460 계열 칩셋', 17000, 2800, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 10,11세대', 'B560 계열 칩셋', 20000, 2810, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 10,11세대', 'H410 계열 칩셋', 15000, 2820, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 10,11세대', 'H470 계열 칩셋', 22000, 2830, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 10,11세대', 'H510 계열 칩셋', 17000, 2840, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 10,11세대', 'H570 계열 칩셋', 23000, 2850, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 10,11세대', 'Z490 계열 칩셋', 35000, 2860, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 10,11세대', 'Z590 계열 칩셋', 40000, 2870, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 12세대', 'B660 계열 칩셋', 30000, 2880, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 12세대', 'B760 계열 칩셋', 35000, 2890, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 12세대', 'H610 계열 칩셋', 20000, 2900, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 12세대', 'H670 계열 칩셋', 35000, 2910, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 12세대', 'H770 계열 칩셋', 40000, 2920, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 12세대', 'Z690 계열 칩셋', 50000, 2930, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 12세대', 'Z790 계열 칩셋', 55000, 2940, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 1366소켓', 'X58', 3000, 2950, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 1세대', 'H55', 1000, 2960, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 1세대', 'P55', 1000, 2970, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 2,3세대', 'B75 칩셋 보드', 2000, 2980, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 2,3세대', 'H61 칩셋 보드', 2000, 2990, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 2,3세대', 'H67 칩셋 보드', 2000, 3000, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 2,3세대', 'H77 칩셋 보드', 2000, 3010, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 2,3세대', 'P67 칩셋 보드', 2000, 3020, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 2,3세대', 'Z68 칩셋 보드', 2000, 3030, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 2,3세대', 'Z77 칩셋 보드', 2000, 3040, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 2011소켓', 'X79', 3000, 3050, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 2011소켓', 'X99', 5000, 3060, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 4세대', 'B85 계열 칩셋보드', 4387, 3070, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 4세대', 'H81 계열 칩셋보드', 3387, 3080, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 4세대', 'H87 계열 칩셋', 4774, 3090, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 4세대', 'H97 계열 칩셋', 5161, 3100, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 4세대', 'P85 계열 칩셋보드', 4387, 3110, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 4세대', 'Z87 계열 칩셋', 5548, 3120, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 4세대', 'Z97 계열 칩셋', 6323, 3130, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 4세대', '보드 H81 BTC', 2000, 3140, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 6,7세대', 'B150 계열 칩셋', 10000, 3150, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 6,7세대', 'B250 계열 칩셋', 11000, 3160, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 6,7세대', 'H110 계열 칩셋', 8000, 3170, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 6,7세대', 'H270 계열 칩셋', 13000, 3180, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 6,7세대', 'Z170 계열 칩셋', 15000, 3190, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 6,7세대', 'Z270 계열 칩셋', 20000, 3200, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 6,7세대', '보드 H110 GIGABYTE D3A', 2000, 3210, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 6,7세대', '보드 H170', 12000, 3220, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 8,9세대', 'B360/365 계열 칩셋', 12000, 3230, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 8,9세대', 'H310 계열 칩셋', 10000, 3240, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 8,9세대', 'H370 계열 칩셋', 15000, 3250, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 8,9세대', 'Z370 계열 칩셋', 20000, 3260, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('M.B', '', '', '인텔 8,9세대', 'Z390 계열 칩셋', 25000, 3270, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('POWER', '', '', '정격', 'Power 정격500W 이상', 1000, 3280, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 1G', 100, 3290, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 1G 10600', 100, 3300, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 1G 8500', 100, 3310, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 2G', 100, 3320, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 2G 10600', 500, 3330, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 2G 12800', 500, 3340, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 2G 8500', 500, 3350, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 4G', 300, 3360, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 4G 10600', 500, 3370, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 4G 12800', 1000, 3380, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 4G 8500', 1000, 3390, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 8G', 2000, 3400, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 8G 10600', 6645, 3410, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 노트북', 'DDR3 8G 12800', 8323, 3420, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 1G', 100, 3430, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 1G 10600', 100, 3440, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 1G 8500', 100, 3450, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 2G', 200, 3460, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 2G 10600', 200, 3470, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 2G 12800', 200, 3480, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 2G 8500', 200, 3490, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 4G', 300, 3500, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 4G 10600', 500, 3510, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 4G 12800', 500, 3520, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 4G 8500', 500, 3530, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 8G', 1000, 3540, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 8G 10600', 3484, 3550, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR3 데스크탑', 'DDR3 8G 12800', 3968, 3560, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 16G', 20161, 3570, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 16G 17000', 31290, 3580, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 16G 19200', 31806, 3590, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 16G 21300', 34839, 3600, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 16G 25600', 39194, 3610, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 32G 21300', 60806, 3620, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 32G 25600', 64194, 3630, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 4G', 742, 3640, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 4G 17000', 845, 3650, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 4G 19200', 1484, 3660, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 4G 21300', 3484, 3670, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 8G', 6323, 3680, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 8G 17000', 14097, 3690, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 8G 19200', 14774, 3700, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 8G 21300', 16581, 3710, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 노트북', 'DDR4 8G 25600', 17097, 3720, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 16G', 20161, 3730, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 16G 17000', 34839, 3740, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 16G 19200', 35161, 3750, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 16G 21300', 40161, 3760, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 16G 23400', 29581, 3770, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 16G 25600', 44839, 3780, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 32G 25600', 47097, 3790, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 4G', 742, 3800, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 4G 17000', 3484, 3810, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 4G 19200', 3484, 3820, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 4G 21300', 3484, 3830, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 8G', 6323, 3840, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 8G 17000', 13774, 3850, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 8G 19200', 14452, 3860, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 8G 21300', 16258, 3870, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR4 데스크탑', 'DDR4 8G 25600', 16452, 3880, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR5 노트북', 'DDR5 16G', 29839, 3890, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR5 노트북', 'DDR5 32G', 59839, 3900, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR5 노트북', 'DDR5 8G', 12419, 3910, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR5 데스크탑', 'DDR5 16G', 33548, 3920, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR5 데스크탑', 'DDR5 32G', 59839, 3930, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'RAM', '', 'DDR5 데스크탑', 'DDR5 8G', 13161, 3940, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'SSD', '', '공용', 'SSD 120G', 3000, 3950, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'SSD', '', '공용', 'SSD 1TB', 22500, 3960, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'SSD', '', '공용', 'SSD 240G', 8500, 3970, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'SSD', '', '공용', 'SSD 2TB', 40000, 3980, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'SSD', '', '공용', 'SSD 500G', 17500, 3990, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R7 240 2G', 1000, 4000, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R7 250 1G', 1000, 4010, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R7 260', 1000, 4020, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R7 260X 2G', 1000, 4030, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R9 270 2G', 1000, 4040, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R9 270X 2G', 1000, 4050, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R9 280 2G', 1000, 4060, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R9 280X 3G', 1000, 4070, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R9 290 4G', 1000, 4080, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R9 290X 4G', 2000, 4090, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R9 370 2G', 2000, 4100, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R9 370X 2G', 3000, 4110, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R9 380 4G', 3000, 4120, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R9 380X 4G', 4000, 4130, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R9 390 8G', 5000, 4140, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'ATI R9 390X 8G', 6000, 4150, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 460', 2000, 4160, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 470', 3000, 4170, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 480', 7500, 4180, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 5300', 10000, 4190, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 550', 2000, 4200, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 5500', 15000, 4210, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 5500 XT', 20000, 4220, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 560', 4000, 4230, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 5600', 25000, 4240, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 5600 XT', 30000, 4250, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 570', 9000, 4260, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 5700', 55000, 4270, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 5700 XT', 65000, 4280, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 580', 12500, 4290, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 6400', 20000, 4300, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 6500 XT', 30000, 4310, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 6600', 40000, 4320, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 6600 XT', 60000, 4330, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 6700 XT', 90000, 4340, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 6750 XT', 95000, 4350, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 6800', 130000, 4360, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 6800 XT', 150000, 4370, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 6900 XT', 170000, 4380, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 6950 XT', 230000, 4390, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 7600', 80000, 4400, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 7600 XT', 120000, 4410, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 7700 XT', 160000, 4420, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 7800 XT', 200000, 4430, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 7900 GRE', 280000, 4440, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 7900 XT', 300000, 4450, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'AMD(ATI)', 'RX 7900 XTX', 450000, 4460, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GT 1030', 10000, 4470, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GT 520', 1000, 4480, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GT 610', 2000, 4490, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GT 630', 2000, 4500, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GT 640', 2000, 4510, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GT 710', 3000, 4520, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GT 730', 3000, 4530, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 1050', 35000, 4540, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 1050 TI', 40000, 4550, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 1060', 52500, 4560, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 1070', 70000, 4570, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 1070 TI', 75000, 4580, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 1080', 80000, 4590, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 1080 TI', 90000, 4600, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 1650', 70000, 4610, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 1660', 90000, 4620, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 1660 TI', 100000, 4630, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 550 TI', 1000, 4640, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 560', 1000, 4650, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 560 SE', 1000, 4660, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 560 TI', 1000, 4670, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 570', 1000, 4680, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 580', 1000, 4690, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 650', 2000, 4700, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 650 TI', 2667, 4710, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 660', 4000, 4720, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 660 TI', 5000, 4730, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 670', 6000, 4740, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 680', 7000, 4750, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 690', 8000, 4760, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 750', 8000, 4770, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 750 TI', 10000, 4780, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 760', 12000, 4790, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 770', 13000, 4800, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 780', 16000, 4810, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 780 TI', 20000, 4820, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 950', 15000, 4830, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 960', 26000, 4840, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 970', 28000, 4850, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 980', 30000, 4860, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'GTX 980 TI', 35000, 4870, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 2060', 112500, 4880, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 2070', 120000, 4890, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 2080', 130000, 4900, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 2080 SUPER', 140000, 4910, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 2080 TI', 150000, 4920, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 3050', 100000, 4930, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 3060', 160000, 4940, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 3060 TI', 170000, 4950, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 3070', 200000, 4960, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 3070 TI', 220000, 4970, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 3080', 240000, 4980, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 3080 TI', 280000, 4990, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 3090', 450000, 5000, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 3090 TI', 500000, 5010, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 4060', 170000, 5020, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 4060 TI', 190000, 5030, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 4070', 310000, 5040, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 4070 SUPER', 380000, 5050, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 4070 TI', 430000, 5060, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 4070 TI SUPER', 480000, 5070, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 4080', 570000, 5080, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 4080 SUPER', 620000, 5090, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 4090', 2300000, 5100, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 5060', 280000, 5110, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 5060 TI', 380000, 5120, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 5070', 490000, 5130, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 5070 TI', 670000, 5140, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 5080', 980000, 5150, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', 'RTX 5090', 2500000, 5160, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', '쿼드로 A100', 4300000, 5170, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', '쿼드로 A4000', 300000, 5180, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', '쿼드로 A5000', 500000, 5190, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', '쿼드로 A6000', 3000000, 5200, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('parts', 'VGA', '', 'NVIDIA', '쿼드로 H100', 17741935, 5210, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I3 10세대 14 / 15인치', 90000, 5220, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I3 11세대 14 / 15인치', 140000, 5230, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I3 12세대 14 / 15인치', 170000, 5240, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I3 13세대 14 / 15인치', 180000, 5250, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I3 1세대 14 / 15인치', 5000, 5260, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I3 2세대 14 / 15인치', 5000, 5270, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I3 3세대 14 / 15인치', 5000, 5280, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I3 4세대 14 / 15인치', 10000, 5290, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I3 5세대 14 / 15인치', 10000, 5300, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I3 6세대 14 / 15인치', 25000, 5310, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I3 7세대 14 / 15인치', 45000, 5320, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I3 8세대 14 / 15인치', 70000, 5330, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I3 9세대 14 / 15인치', 70000, 5340, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I5 10세대 14 / 15인치', 135000, 5350, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I5 11세대 14 / 15인치', 190000, 5360, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I5 12세대 14 / 15인치', 220000, 5370, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I5 13세대 14 / 15인치', 280000, 5380, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I5 1세대 14 / 15인치', 5000, 5390, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I5 2세대 14 / 15인치', 10000, 5400, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I5 3세대 14 / 15인치', 10000, 5410, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I5 4세대 14 / 15인치', 15000, 5420, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I5 5세대 14 / 15인치', 20000, 5430, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I5 6세대 14 / 15인치', 35000, 5440, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I5 7세대 14 / 15인치', 55000, 5450, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I5 8세대 14 / 15인치', 110000, 5460, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I5 9세대 14 / 15인치', 110000, 5470, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I7 10세대 14 / 15인치', 175000, 5480, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I7 11세대 14 / 15인치', 200000, 5490, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I7 12세대 14 / 15인치', 250000, 5500, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I7 13세대 14 / 15인치', 320000, 5510, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I7 1세대 14 / 15인치', 5000, 5520, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I7 2세대 14 / 15인치', 10000, 5530, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I7 3세대 14 / 15인치', 15000, 5540, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I7 4세대 14 / 15인치', 25000, 5550, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I7 5세대 14 / 15인치', 25000, 5560, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I7 6세대 14 / 15인치', 45000, 5570, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I7 7세대 14 / 15인치', 65000, 5580, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I7 8세대 14 / 15인치', 120000, 5590, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', 'HP / DELL / 기타', '인텔 I7 9세대 14 / 15인치', 120000, 5600, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I3 10세대 14 / 15인치', 130000, 5610, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I3 11세대 14 / 15인치', 160000, 5620, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I3 12세대 14 / 15인치', 180000, 5630, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I3 13세대 14 / 15인치', 180000, 5640, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I3 1세대 14 / 15인치', 10000, 5650, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I3 2세대 14 / 15인치', 10000, 5660, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I3 3세대 14 / 15인치', 10000, 5670, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I3 4세대 14 / 15인치', 15000, 5680, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I3 5세대 14 / 15인치', 25000, 5690, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I3 6세대 14 / 15인치', 35000, 5700, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I3 7세대 14 / 15인치', 55000, 5710, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I3 8세대 14 / 15인치', 80000, 5720, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I3 9세대 14 / 15인치', 80000, 5730, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I5 10세대 14 / 15인치', 170000, 5740, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I5 11세대 14 / 15인치', 220000, 5750, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I5 12세대 14 / 15인치', 250000, 5760, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I5 13세대 14 / 15인치', 320000, 5770, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I5 1세대 14 / 15인치', 15000, 5780, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I5 2세대 14 / 15인치', 20000, 5790, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I5 3세대 14 / 15인치', 20000, 5800, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I5 4세대 14 / 15인치', 25000, 5810, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I5 5세대 14 / 15인치', 35000, 5820, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I5 6세대 14 / 15인치', 45000, 5830, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I5 7세대 14 / 15인치', 65000, 5840, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I5 8세대 14 / 15인치', 120000, 5850, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I5 9세대 14 / 15인치', 120000, 5860, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I7 10세대 14 / 15인치', 210000, 5870, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I7 11세대 14 / 15인치', 240000, 5880, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I7 12세대 14 / 15인치', 290000, 5890, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I7 13세대 14 / 15인치', 360000, 5900, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I7 1세대 14 / 15인치', 20000, 5910, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I7 2세대 14 / 15인치', 25000, 5920, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I7 3세대 14 / 15인치', 25000, 5930, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I7 4세대 14 / 15인치', 35000, 5940, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I7 5세대 14 / 15인치', 45000, 5950, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I7 6세대 14 / 15인치', 55000, 5960, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I7 7세대 14 / 15인치', 75000, 5970, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I7 8세대 14 / 15인치', 130000, 5980, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '', '삼성 / LG', '인텔 I7 9세대 14 / 15인치', 130000, 5990, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '10세대 i5/8G/X', 96000, 6000, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '11세대 i5/8G/X', 104000, 6010, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '12세대 i5/8G/X', 120000, 6020, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '13세대 i5/8G/X', 160000, 6030, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '14세대 i5/8G/X', 184000, 6040, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '1세대 i5/4G/X', 4000, 6050, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '2세대 i5/4G/X', 4000, 6060, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '3세대 i5/4G/X', 4000, 6070, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '4세대 i5/4G/X', 8000, 6080, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '5세대 i5/4G/X', 16000, 6090, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '6세대 i5/8G/X', 48000, 6100, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '7세대 i5/8G/X', 48000, 6110, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '8세대 i5/8G/X', 64000, 6120, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', '9세대 i5/8G/X', 72000, 6130, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Dell', '', 'Core2Duo이하', 4000, 6140, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '10세대 i5/8G/X', 96000, 6150, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '11세대 i5/8G/X', 104000, 6160, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '12세대 i5/8G/X', 120000, 6170, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '13세대 i5/8G/X', 160000, 6180, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '14세대 i5/8G/X', 184000, 6190, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '1세대 i5/4G/X', 4000, 6200, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '2세대 i5/4G/X', 4000, 6210, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '3세대 i5/4G/X', 4000, 6220, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '4세대 i5/4G/X', 8000, 6230, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '5세대 i5/4G/X', 16000, 6240, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '6세대 i5/8G/X', 48000, 6250, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '7세대 i5/8G/X', 48000, 6260, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '8세대 i5/8G/X', 64000, 6270, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', '9세대 i5/8G/X', 72000, 6280, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'HP', '', 'Core2Duo이하', 4000, 6290, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '10세대 i5/8G/X', 96000, 6300, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '11세대 i5/8G/X', 104000, 6310, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '12세대 i5/8G/X', 120000, 6320, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '13세대 i5/8G/X', 160000, 6330, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '14세대 i5/8G/X', 184000, 6340, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '1세대 i5/4G/X', 4000, 6350, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '2세대 i5/4G/X', 4000, 6360, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '3세대 i5/4G/X', 4000, 6370, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '4세대 i5/4G/X', 8000, 6380, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '5세대 i5/4G/X', 16000, 6390, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '6세대 i5/8G/X', 48000, 6400, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '7세대 i5/8G/X', 48000, 6410, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '8세대 i5/8G/X', 64000, 6420, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', '9세대 i5/8G/X', 72000, 6430, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', 'Lenovo', '', 'Core2Duo이하', 4000, 6440, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '10세대 i5/8G/X', 72000, 6450, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '11세대 i5/8G/X', 80000, 6460, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '12세대 i5/8G/X', 96000, 6470, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '13세대 i5/8G/X', 128000, 6480, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '14세대 i5/8G/X', 160000, 6490, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '1세대 i5/4G/X', 4000, 6500, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '2세대 i5/4G/X', 4000, 6510, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '3세대 i5/4G/X', 4000, 6520, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '4세대 i5/4G/X', 8000, 6530, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '5세대 i5/4G/X', 16000, 6540, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '6세대 i5/8G/X', 24000, 6550, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '7세대 i5/8G/X', 24000, 6560, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '8세대 i5/8G/X', 40000, 6570, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', '9세대 i5/8G/X', 48000, 6580, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '기타', '', 'Core2Duo이하', 4000, 6590, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '10세대 i5/8G/X', 160000, 6600, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '11세대 i5/8G/X', 200000, 6610, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '12세대 i5/8G/X', 240000, 6620, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '13세대 i5/8G/X', 280000, 6630, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '14세대 i5/8G/X', 320000, 6640, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '1세대 i5/4G/X', 4000, 6650, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '2세대 i5/4G/X', 4000, 6660, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '3세대 i5/4G/X', 4000, 6670, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '4세대 i5/4G/X', 16000, 6680, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '5세대 i5/4G/X', 24000, 6690, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '6세대 i5/8G/X', 64000, 6700, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '7세대 i5/8G/X', 64000, 6710, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '8세대 i5/8G/X', 120000, 6720, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', '9세대 i5/8G/X', 120000, 6730, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '삼성', '', 'Core2Duo이하', 4000, 6740, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', '10세대 i5/8G/X', 240000, 6750, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', '1세대 i5/4G/X', 4000, 6760, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', '2세대 i5/4G/X', 4000, 6770, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', '3세대 i5/4G/X', 4000, 6780, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', '4세대 i5/4G/X', 16000, 6790, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', '5세대 i5/4G/X', 24000, 6800, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', '6세대 i5/8G/X', 88000, 6810, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', '7세대 i5/8G/X', 88000, 6820, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', '8세대 i5/8G/X', 160000, 6830, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', '9세대 i5/8G/X', 200000, 6840, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', 'Core2Duo이하', 4000, 6850, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', 'M1/8G/256G', 280000, 6860, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', 'M2/8G/256G', NULL, 6870, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', 'M3/8G/X', NULL, 6880, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '애플', '', 'M4/8G/X', NULL, 6890, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '10세대 i5/8G/X', 184000, 6900, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '11세대 i5/8G/X', 224000, 6910, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '12세대 i5/8G/X', 264000, 6920, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '13세대 i5/8G/X', 304000, 6930, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '14세대 i5/8G/X', 344000, 6940, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '1세대 i5/4G/X', 4000, 6950, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '2세대 i5/4G/X', 4000, 6960, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '3세대 i5/4G/X', 4000, 6970, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '4세대 i5/4G/X', 16000, 6980, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '5세대 i5/4G/X', 24000, 6990, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '6세대 i5/8G/X', 88000, 7000, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '7세대 i5/8G/X', 88000, 7010, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '8세대 i5/8G/X', 144000, 7020, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', '9세대 i5/8G/X', 144000, 7030, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('노트북', '', '엘지', '', 'Core2Duo이하', 4000, 7040, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '10세대', 40000, 7050, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '11세대', 48000, 7060, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '12세대', 64000, 7070, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '13세대', 64000, 7080, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '14세대', 80000, 7090, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '1세대', 6000, 7100, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '2세대', 6000, 7110, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '3세대', 6000, 7120, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '4세대', 6000, 7130, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '5세대', NULL, 7140, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '6세대', 16000, 7150, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '7세대', 16000, 7160, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '8세대', 32000, 7170, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', '9세대', 32000, 7180, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Dell', '', 'Core2Duo이하', 6000, 7190, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '10세대', 40000, 7200, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '11세대', 48000, 7210, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '12세대', 64000, 7220, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '13세대', 64000, 7230, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '14세대', 80000, 7240, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '1세대', 6000, 7250, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '2세대', 6000, 7260, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '3세대', 6000, 7270, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '4세대', 6000, 7280, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '5세대', NULL, 7290, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '6세대', 16000, 7300, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '7세대', 16000, 7310, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '8세대', 32000, 7320, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', '9세대', 32000, 7330, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'HP', '', 'Core2Duo이하', 6000, 7340, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '10세대', 40000, 7350, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '11세대', 48000, 7360, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '12세대', 64000, 7370, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '13세대', 64000, 7380, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '14세대', 80000, 7390, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '1세대', 6000, 7400, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '2세대', 6000, 7410, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '3세대', 6000, 7420, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '4세대', 6000, 7430, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '5세대', NULL, 7440, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '6세대', 16000, 7450, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '7세대', 16000, 7460, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '8세대', 32000, 7470, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', '9세대', 32000, 7480, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', 'Lenovo', '', 'Core2Duo이하', 6000, 7490, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '10세대', 40000, 7500, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '11세대', 48000, 7510, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '12세대', 64000, 7520, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '13세대', 64000, 7530, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '14세대', 80000, 7540, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '1세대', 6000, 7550, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '2세대', 6000, 7560, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '3세대', 6000, 7570, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '4세대', 6000, 7580, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '5세대', NULL, 7590, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '6세대', 16000, 7600, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '7세대', 16000, 7610, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '8세대', 32000, 7620, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', '9세대', 32000, 7630, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '기타', '', 'Core2Duo이하', 6000, 7640, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '10세대', 120000, 7650, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '11세대', 128000, 7660, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '12세대', 144000, 7670, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '13세대', 152000, 7680, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '14세대', 176000, 7690, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '1세대', 6000, 7700, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '2세대', 6000, 7710, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '3세대', 6000, 7720, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '4세대', 16000, 7730, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '5세대', NULL, 7740, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '6세대', 24000, 7750, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '7세대', 56000, 7760, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '8세대', 72000, 7770, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', '9세대', 72000, 7780, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '삼성', '', 'Core2Duo이하', 6000, 7790, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', '10세대 i5/8G/X', NULL, 7800, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', '1세대 i5/4G/X', 6000, 7810, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', '2세대 i5/4G/X', 6000, 7820, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', '3세대 i5/4G/X', 6000, 7830, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', '4세대 i5/4G/X', 6000, 7840, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', '5세대 i5/4G/X', NULL, 7850, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', '6세대 i5/8G/X', NULL, 7860, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', '7세대 i5/8G/X', NULL, 7870, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', '8세대 i5/8G/X', NULL, 7880, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', '9세대 i5/8G/X', NULL, 7890, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', 'Core2Duo이하', 6000, 7900, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', 'M1/8G/X', NULL, 7910, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', 'M2/8G/X', NULL, 7920, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', 'M3/8G/X', NULL, 7930, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '애플', '', 'M4/8G/X', NULL, 7940, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '10세대', 40000, 7950, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '11세대', 48000, 7960, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '12세대', 64000, 7970, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '13세대', 64000, 7980, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '14세대', 80000, 7990, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '1세대', 6000, 8000, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '2세대', 6000, 8010, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '3세대', 6000, 8020, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '4세대', 6000, 8030, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '5세대', NULL, 8040, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '6세대', 16000, 8050, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '7세대', 16000, 8060, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '8세대', 32000, 8070, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', '9세대', 32000, 8080, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);

INSERT INTO `buyback_spec_master`
(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)
VALUES ('데스크탑', '', '엘지', '', 'Core2Duo이하', 6000, 8090, 1)
ON DUPLICATE KEY UPDATE
  `price_value` = VALUES(`price_value`),
  `sort_order` = VALUES(`sort_order`),
  `is_active` = VALUES(`is_active`);
