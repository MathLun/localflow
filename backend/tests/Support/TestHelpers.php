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
		echo "Error Temporal: ".$e->getMessage();
            exit(1);
        }

        echo "✅ PASS: {$message}\n";
    }
}

function resetDatabase(): void
{
    setupDatabase();

    $backendPath = dirname(dirname(__DIR__));
    $dbPath = $backendPath . '/storage/database.sqlite';
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Checa se a tabela 'users' existe
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users';");
    $tableExists = $stmt->fetchColumn();

    if (!$tableExists) {
        echo "⚠️ Tabela 'users' não existe, criando novamente..." . PHP_EOL;
        setupDatabase(); // cria tabelas de novo
    }

    // Limpa a tabela se existir
    $pdo->exec('DELETE FROM users;');

    $count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    echo "Users após reset: " . $count . PHP_EOL;
    echo "Banco resetado." . PHP_EOL;
}

/* ==========
 *   Seed 
 * =≈=≈====== */
function createUser(
	string $email = 'admin@email.com',
	string $password = '123456',
	string $role = 'ADMIN'
): void {
	$backendRoot = dirname(__DIR__, 2);
	$dbPath = $backendRoot.'/storage/database.sqlite';
	$pdo = new PDO('sqlite:'.$dbPath);
	$stmt = $pdo->prepare("
		INSERT INTO users (id, email, password_hash, role, created_at, updated_at) VALUES (:id, :email, :password_hash, :role, :created_at, :updated_at)
	");

	$stmt->execute([
		'id' => uniqid(),
		'email' => $email,
		'password_hash' => password_hash($password, PASSWORD_DEFAULT),
		'role' => $role,
		'created_at' => date('Y-m-d H:i:s'),
		'updated_at' => date('Y-m-d H:i:s')
	]);
}

function setupDatabase(): void
{
	$backendPath = dirname(dirname(__DIR__));
	$storagePath = $backendPath . '/storage';
	if (!is_dir($storagePath)) {
    		mkdir($storagePath, 0777, true); // cria storage se não existir
	}

	$migratePath = $backendPath . '/bin/migrate.php';
	shell_exec("php {$migratePath}"); // cria as tabelas
	$dbPath = $storagePath . '/database.sqlite';
    	$pdo = new PDO('sqlite:' . $dbPath);
    	$pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id TEXT PRIMARY KEY,
            email TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            role TEXT NOT NULL,
            created_at TEXT,
            updated_at TEXT
        )
    	");
}
