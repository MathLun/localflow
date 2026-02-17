<?php

require_once __DIR__ . '/Support/TestHelpers.php';

function requireAllTests(string $directory): void
{
    $files = scandir($directory);

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $path = $directory . '/' . $file;

        if (is_dir($path)) {
            requireAllTests($path);
        }

        if (str_ends_with($file, 'Test.php')) {
            require_once $path;
        }
    }
}

requireAllTests(__DIR__ . '/E2E');

echo "\n🚀 E2E tests finished.\n";
