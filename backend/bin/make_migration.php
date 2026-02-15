<?php

require __DIR__ . '/../src/Support/Autoload.php';

use App\Core\Database\Migrations\MigrationGenerator;

if ($argc < 2) {
    echo "Usage: php database/make_migration.php migration_name\n";
    exit(1);
}

$name = $argv[1];

$generator = new MigrationGenerator(__DIR__ . '/../storage/migrations');

$path = $generator->generate($name);

echo "Migration created at: {$path}" . PHP_EOL;
