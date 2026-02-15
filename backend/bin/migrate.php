<?php

require __DIR__ . '/../src/Support/Autoload.php';

use App\Core\Database\Database;
use App\Core\Database\Migrations\MigrationRunner;

$databasePath = __DIR__ . '/../storage/database.sqlite';

$database = new Database($databasePath);

$runner = new MigrationRunner(
    $database->getConnection(),
    __DIR__ . '/../storage/migrations'
);

$direction = $argv[1] ?? 'up';
$runner->run($direction);
