<?php

declare(strict_types=1);

$startTime = microtime(true);

require_once __DIR__ . '/../src/Support/Autoload.php';
require_once __DIR__ . '/Support/TestHelpers.php';

echo "=============================\n";
echo "      LOCALFLOW TESTS\n";
echo "=============================\n\n";

$testDirectory = __DIR__ . '/Modules';

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($testDirectory)
);

$testFiles = [];

foreach ($iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), 'Test.php')) {
        $testFiles[] = $file->getPathname();
    }
}

$totalFiles = count($testFiles);

if (empty($testFiles) || $totalFiles === 0) {
    echo "⚠️ No tests found.\n";
    exit(0);
}

$fileCounter = 0;

foreach ($testFiles as $testFile) {
    $fileCounter++;

    $fileStart = microtime(true);
    echo "---------------------------------\n";
    echo "[$fileCounter/$totalFiles] Running: " . str_replace(__DIR__ . '/', '', $testFile) . "\n";
    echo "---------------------------------\n\n";

    require_once $testFile;

    $fileTime = microtime(true) - $fileStart;

    echo "\n🧭 File time: " . number_format($fileTime, 4) . "s\n\n";
}

$totalTime = microtime(true) - $startTime;
$totalAssertions = getAssertionCount();
echo "=============================\n";
echo "🎉 ALL TESTS PASSED\n";
echo "-----------------------------\n";
echo "Files:  {$totalFiles}\n";
echo "Assertions:  {$totalAssertions}\n";
echo "Time:  " . number_format($totalTime, 4) . "s\n";
echo "=============================\n";

