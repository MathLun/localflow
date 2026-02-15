<?php

namespace App\Core\Database\Migrations;

class MigrationGenerator
{
    private string $migrationsPath;

    public function __construct(string $migrationsPath)
    {
        $this->migrationsPath = rtrim($migrationsPath, '/');
    }

    public function generate(string $name): string
    {
        $timestamp = date('YmdHis');

        $sanitized = $this->sanitizeName($name);

        $fileName = "{$timestamp}_{$sanitized}.sql";
        $filePath = "{$this->migrationsPath}/{$fileName}";

        if (file_exists($filePath)) {
            throw new \RuntimeException("Migration already exists: {$fileName}");
        }

        file_put_contents($filePath, $this->getTemplate($sanitized));

        return $filePath;
    }

    private function sanitizeName(string $name): string
    {
        return strtolower(trim(preg_replace('/[^a-zA-Z0-9_]+/', '_', $name)));
    }

    private function getTemplate(string $name): string
    {
	$createdAt = date('Y-m-d H:i:s');

        return <<<SQL
-- Migration: {$name}
-- Created at: {$createdAt}

-- UP
-- Write your SQL here

-- DOWN
-- Optional rollback SQL

SQL;
    }
}
