<?php

use App\Core\Database\Database;
use App\Modules\Auth\Domain\Entities\User;
use App\Modules\Auth\Infrastructure\Persistence\SQLite\SQLiteUserRepository;

echo "Running SQLiteUserRepository tests...\n\n";

$database = new Database(__DIR__ . '/../../../../storage/database.sqlite');
$connection = $database->getConnection();
$userRepository = new SQLiteUserRepository($connection);

$user = User::create(
	id: '1',
	email: 'admin@email.com',
	passwordHash: password_hash('123456', PASSWORD_DEFAULT),
	role: 'ADMIN'
);

$userRepository->save($user);

$email = "admin@email.com";
$foundByEmail = $userRepository->findByEmail($email);

assertTrue(
	$foundByEmail !== null,
	'Deve encontrar usuário pelo email'
);

assertTrue(
	$foundByEmail->email() === "matheus86luna@hotmail.com",
	'Deve ser igual ao email salvo'
);

echo "\n 🎉 All SQLiteUserRepository tests passed.\n\n";
