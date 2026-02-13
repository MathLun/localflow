<?php


use App\Modules\Auth\Domain\Entities\User;
use App\Modules\Auth\Infrastructure\Persistence\InMemory\InMemoryUserRepository;

echo "Running InMemoryUserRepository tests...\n\n";

$repo = new InMemoryUserRepository();

$user = User::create(
		id: '1',
		email: 'matheuslunadev@gmail.com',
		passwordHash: password_hash('123456', PASSWORD_DEFAULT),
		role: 'ADMIN'
);

$repo->save($user);

$foundById = $repo->findById('1');
$foundByEmail = $repo->findByEmail('matheuslunadev@gmail.com');

assertTrue(
	$foundById !== null,
	'Deve encontrar usuário pelo ID'
);

assertTrue(
	$foundByEmail !== null,
	'Deve encontrar usuário pelo Email'
);

echo "\n 🎉 All InMemoryUserRepository tests passed. \n\n";
