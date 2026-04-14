const fs = require('fs');
const path = require('path');
const vm = require('vm');

const root = process.cwd();
const sellViewPath = path.join(root, 'application', 'views', 'sell', 'sell_view.php.260326.bak');
const outputPath = path.join(root, 'database', '20260409_buyback_spec_seed.sql');

const source = fs.readFileSync(sellViewPath, 'utf8');

function extract(regex, label) {
  const match = source.match(regex);
  if (!match) {
    throw new Error(`${label} block not found`);
  }
  return match[1];
}

const priceDBLiteral = extract(/const priceDB = (\[[\s\S]*?\]);\s*\n\s*\/\/ State/, 'priceDB');
const secondLiteral = extract(/const secondPriceTable = (\{[\s\S]*?\});\s*\n\s*function getSecondManufacturers/, 'secondPriceTable');

const sandbox = {};
vm.runInNewContext(`priceDB = ${priceDBLiteral}; secondPriceTable = ${secondLiteral};`, sandbox);

const rows = [];

function esc(value) {
  if (value === null || value === undefined) {
    return 'NULL';
  }

  return `'${String(value).replace(/\\/g, '\\\\').replace(/'/g, "\\'")}'`;
}

let sortOrder = 10;

for (const item of sandbox.priceDB) {
  let deviceType = item.type;
  let partType = '';

  if (['CPU', 'RAM', 'SSD', 'VGA'].includes(item.type)) {
    deviceType = 'parts';
    partType = item.type;
  }

  rows.push({
    device_type: deviceType,
    part_type: partType,
    manufacturer: '',
    category_name: item.category || '',
    model_name: item.name || '',
    price_value: item.price === null || item.price === undefined ? null : Number(item.price),
    sort_order: sortOrder,
    is_active: 1,
  });

  sortOrder += 10;
}

for (const [deviceType, manufacturerMap] of Object.entries(sandbox.secondPriceTable)) {
  for (const [manufacturer, modelMap] of Object.entries(manufacturerMap)) {
    for (const [modelName, priceValue] of Object.entries(modelMap)) {
      rows.push({
        device_type: deviceType,
        part_type: '',
        manufacturer,
        category_name: '',
        model_name: modelName,
        price_value: priceValue === null || priceValue === undefined ? null : Number(priceValue),
        sort_order: sortOrder,
        is_active: 1,
      });

      sortOrder += 10;
    }
  }
}

const header = [
  '-- Generated from application/views/sell/sell_view.php.260326.bak',
  '-- Run after 20260409_buyback_spec_master.sql',
  ''
].join('\n');

const statements = rows.map((row) => {
  return [
    'INSERT INTO `buyback_spec_master`',
    '(`device_type`, `part_type`, `manufacturer`, `category_name`, `model_name`, `price_value`, `sort_order`, `is_active`)',
    `VALUES (${esc(row.device_type)}, ${esc(row.part_type)}, ${esc(row.manufacturer)}, ${esc(row.category_name)}, ${esc(row.model_name)}, ${row.price_value === null ? 'NULL' : row.price_value}, ${row.sort_order}, ${row.is_active})`,
    'ON DUPLICATE KEY UPDATE',
    '  `price_value` = VALUES(`price_value`),',
    '  `sort_order` = VALUES(`sort_order`),',
    '  `is_active` = VALUES(`is_active`);',
    ''
  ].join('\n');
});

fs.writeFileSync(outputPath, header + statements.join('\n'), 'utf8');
console.log(`Generated ${rows.length} seed rows -> ${outputPath}`);
