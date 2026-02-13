<?php

require __DIR__ . '/../../../../src/Support/Autoload.php';

use App\Modules\Auth\Domain\Entities\User;
use App\Modules\Auth\Domain\Exceptions\InvalidUserException;

echo "Running User Entity Tests...\n\n";

/*
 * Teste 1: Criação valida
 */
$user = User::create(
	id: '1',
	email: 'matheus86luna@hotmail.com',
	passwordHash: password_hash('123456', PASSWORD_DEFAULT),
	role: 'ADMIN'
);

assertTrue($user->email() === 'matheus86luna@hotmail.com', 'Email deve ser retornado corretamente');
assertTrue(!empty($user->passwordHash()), 'Password hash não pode estar vazio.');

/*
 * Teste 2: Email Invalido
 */
assertThrows(
	fn() => User::create(
		id: '2',
		email: 'matheuslunadev.invalido',
		passwordHash: password_hash('certo', PASSWORD_DEFAULT),
		role: 'STAFF'
	),
	InvalidUserException::class,
	'Deve lançar exceção para email inválido'
);

/*
 * Teste 3: verifyPassword() - senha correta
 */
$plainPassword = '123456';
assertTrue(
	$user->verifyPassword($plainPassword),
	'verifyPassword deve retornar true para senha correta'
);

/*
 * Teste 4: verifyPassword() - senha incorreta
 */
$plainPassword = '12345';
assertFalse(
	$user->verifyPassword($plainPassword),
	'verifyPassword deve retornar false para senha incorreta'
);

/*
 * Teste 5: Role invalida
 */
assertThrows(
	fn() => User::create(
		id: '3',
		email: 'matheuslunadev@gmail.com',
		passwordHash: password_hash('certo', PASSWORD_DEFAULT),
		role: 'INVALID'
	),
	InvalidUserException::class,
	'Deve lançar exceção para role inválida'
);

/*
 * Teste 6: Password vazia
 */
assertThrows(
	fn() => User::create(
		id: '4',
		email: 'matheuslunadev@gmail.com',
		passwordHash: '',
		role: 'ADMIN'
	),
	InvalidUserException::class,
	'Deve lançar exceção para password vazia'
);

echo "\n 🎉 All User tests passed. \n\n";
