<?php
$db = new PDO('sqlite:database/database.sqlite');
$tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name")->fetchAll(PDO::FETCH_COLUMN);
foreach ($tables as $table) {
    $cnt = $db->query("SELECT COUNT(*) FROM \"$table\"")->fetchColumn();
    echo "$table: $cnt rows\n";
}
