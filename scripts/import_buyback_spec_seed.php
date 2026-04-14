<?php

$host = 'localhost';
$user = 'buyback';
$pass = 'Buyback^!^2026#';
$name = 'db_buyback';
$ddlPath = __DIR__ . '/../database/20260409_buyback_spec_master.sql';
$seedPath = __DIR__ . '/../database/20260409_buyback_spec_seed.sql';

mysqli_report(MYSQLI_REPORT_OFF);

$mysqli = new mysqli($host, $user, $pass, $name);
if ($mysqli->connect_errno) {
    fwrite(STDERR, 'connect fail: ' . $mysqli->connect_error . PHP_EOL);
    exit(1);
}

$mysqli->set_charset('utf8mb4');

$ddlSql = file_get_contents($ddlPath);
if ($ddlSql === false) {
    fwrite(STDERR, 'failed to read DDL file' . PHP_EOL);
    exit(1);
}
$ddlSql = preg_replace('/^\xEF\xBB\xBF/', '', $ddlSql);

$seedSql = file_get_contents($seedPath);
if ($seedSql === false) {
    fwrite(STDERR, 'failed to read seed file' . PHP_EOL);
    exit(1);
}
$seedSql = preg_replace('/^\xEF\xBB\xBF/', '', $seedSql);

if (!$mysqli->query($ddlSql)) {
    if ((int) $mysqli->errno !== 1050) {
        fwrite(STDERR, 'ddl fail: ' . $mysqli->error . PHP_EOL);
        exit(1);
    }
}

if (!$mysqli->query('TRUNCATE TABLE buyback_spec_master')) {
    fwrite(STDERR, 'truncate fail: ' . $mysqli->error . PHP_EOL);
    exit(1);
}

if (!$mysqli->multi_query($seedSql)) {
    fwrite(STDERR, 'seed fail: ' . $mysqli->error . PHP_EOL);
    exit(1);
}

do {
    if ($result = $mysqli->store_result()) {
        $result->free();
    }
} while ($mysqli->more_results() && $mysqli->next_result());

if ($mysqli->errno) {
    fwrite(STDERR, 'seed loop fail: ' . $mysqli->error . PHP_EOL);
    exit(1);
}

$countResult = $mysqli->query('SELECT COUNT(*) AS cnt FROM buyback_spec_master');
$countRow = $countResult ? $countResult->fetch_assoc() : array('cnt' => 0);
echo 'imported rows: ' . (int) $countRow['cnt'] . PHP_EOL;
