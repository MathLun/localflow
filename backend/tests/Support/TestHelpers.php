<?php

declare(strict_types=1);

$GLOBALS['__test_assertions'] = 0;

function incrementAssertion(): void
{
	$GLOBALS['__test_assertions']++;
}

function getAssertionCount(): int
{
	return $GLOBALS['__test_assertions'];
}

function assertTrue(bool $condition, string $message): void
{
    if (!$condition) {
        echo "❌ FAIL: {$message}\n";
        exit(1);
    }

    echo "✅ PASS: {$message}\n";
}

function assertFalse(bool $condition, string $message): void
{
    assertTrue(!$condition, $message);
}

function assertThrows(callable $fn, string $expectedException, string $message): void
{
    try {
        $fn();
        echo "❌ FAIL: {$message} (no exception thrown)\n";
        exit(1);
    } catch (\Throwable $e) {
        if (!$e instanceof $expectedException) {
            echo "❌ FAIL: {$message} (unexpected exception " . get_class($e) . ")\n";
            exit(1);
        }

        echo "✅ PASS: {$message}\n";
    }
}
