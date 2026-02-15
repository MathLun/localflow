<?php

namespace App\Core\Database\Migrations;

use PDO;
use DateTimeImmutable;
use DateTimeZone;

class MigrationRunner
{
    private PDO $connection;
    private string $migrationsPath;

    public function __construct(PDO $connection, string $migrationsPath)
    {
        $this->connection = $connection;
        $this->migrationsPath = rtrim($migrationsPath, '/');
    }

    public function run(string $direction = 'up'): void
    {
        $this->ensureMigrationsTableExists();

	if ($direction === 'up') {
		$this->runUp();
	} elseif ($direction === 'down') {
		$this->runDown();
	} else {
		throw new \InvalidArgumentException("Direction must be 'up' or 'down'");
	}	
    }


    private function runUp(): void
    {
        $executedMigrations = $this->getExecutedMigrations();
        $migrationFiles = $this->getMigrationFiles();

        foreach ($migrationFiles as $file) {
            $migrationName = basename($file);

            if (in_array($migrationName, $executedMigrations)) {
                continue;
            }

	    $sql = $this->extractSection($file, 'UP');
	    $this->executeSQL($sql);
            $this->markAsExecuted($migrationName);

            echo "Migrated: {$migrationName}" . PHP_EOL;
        }
    }

    private function runDown(): void
    {
	    $lastMigration = $this->getLastExecutedMigration();
	    if (!$lastMigration)
	    {
		    echo "No migrations to rollback." . PHP_EOL;
		    return;
	    }

	    $file = $this->migrationsPath . '/' . $lastMigration;
	    $sql = $this->extractSection($file, 'DOWN');

	    try {
		    $this->executeSQL($sql);
		    $this->removeMigrationRecord($lastMigration);
		   echo "Rolled back: {$lastMigration}" . PHP_EOL;
	    } catch (\Throwable $e) {
		    throw $e;
	    }

    }

    private function executeSQL(string $sql): void
    {
	    $this->connection->beginTransaction();

	    try {
		$this->connection->exec($sql);
		$this->connection->commit();
	    } catch (\Throwable $e) {
		    $this->connection->rollback();
		    throw $e;
	    }
    }

    private function extractSection(
	    string $file,
	    string $section
    ): string {
	    $content = file_get_contents($file);

	    $pattern = "/--\s+{$section}\s*(.*?)\s*(?=--\s+(UP|DOWN)|$)/is";

	    if (!preg_match($pattern, $content, $matches))
	    {
		    throw new \RuntimeException("Session {$section} not found in {$file}");
	    }

	    return trim($matches[1]);
    }

    private function ensureMigrationsTableExists(): void
    {
        $this->connection->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id TEXT PRIMARY KEY,
                migration TEXT NOT NULL UNIQUE,
                executed_at TEXT NOT NULL
            );
        ");
    }

    private function getExecutedMigrations(): array
    {
        $stmt = $this->connection->query("SELECT migration FROM migrations");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function getLastExecutedMigration(): ?string
    {
	    $stmt = $this->connection->query("
		SELECT migration
		FROM migrations
		ORDER BY id DESC
		LIMIT 1
	    ");

	    return $stmt->fetchColumn() ?? null;

    }

    private function getMigrationFiles(): array
    {
        $files = glob($this->migrationsPath . '/*.sql');

        sort($files); // garante ordem por timestamp

        return $files ?: [];
    }

    private function executeMigration(string $file): void
    {
        $sql = file_get_contents($file);

        $this->connection->beginTransaction();

        try {
            $this->connection->exec($sql);
            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    private function markAsExecuted(string $migrationName): void
    {
        $stmt = $this->connection->prepare("
            INSERT INTO migrations (id, migration, executed_at)
            VALUES (:id, :migration, :executed_at)
        ");

	$stmt->execute([
	    'id' => $this->generateUuid(),
	    'migration' => $migrationName,
	    'executed_at' => $this->now()
        ]);
    }

    private function removeMigrationRecord(string $migration): void
    {
	    $stmt = $this->connection->prepare("
		DELETE FROM migrations WHERE migration = :migration
	    ");
	    $stmt->execute(['migration' => $migration]);
    }

    private function generateUuid(): string
    {
	    return bin2hex(random_bytes(16));
    }

    private function now(): string
    {
	    return (new DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo')))->format('Y-m-d H:i:s.u');
    }
}
