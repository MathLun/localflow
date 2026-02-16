<?php

use App\Modules\Auth\Application\UseCases\AuthenticateUserUseCase;
use App\Modules\Auth\Fakes\FakeTokenGenerator;
use App\Modules\Auth\Domain\Entities\User;
use App\Modules\Auth\Domain\Exceptions\InvalidCredentialsException;
use App\Modules\Auth\Infrastructure\Persistence\InMemory\InMemoryUserRepository;

echo "Running LoginUseCase tests...\n\n";

$repository = new InMemoryUserRepository();
$tokenGenerator = new FakeTokenGenerator();

$user = User::create(
	id: '1',
	email: 'matheuslunadev@gmail.com',
	passwordHash: password_hash('123456', PASSWORD_DEFAULT),
	role: 'ADMIN'
);

$repository->save($user);

$usecase = new AuthenticateUserUseCase(
	$repository, 
	$tokenGenerator
);

/*
 * Teste 1: Login com successo
 */
$usecase->execute('matheuslunadev@gmail.com', '123456');
assertTrue(
	true,
	'Deve logar com successo com credenciais válidas
'
);

/*
 * Teste 2: Email Inexistente
 */
assertThrows(
	fn() => $usecase->execute('notfound@email.com','123456'),
	InvalidCredentialsException::class,
	'Deve lançar excessão quando email não existe.'
);

/*
 * Teste 3: Senha invalida
 */
assertThrows(
	fn() => $usecase->execute('matheuslunadev@gmail.com', 'wrong-password'),
	InvalidCredentialsException::class,
	'Deve lançar excessão quando a senha está incorreta.'
);

/*
 * Teste 4: 
 */
$response = $usecase->execute('matheuslunadev@gmail.com', '123456');
assertTrue(
	$response->userId === '1',
	'Deve retornar id correto'
);

assertTrue(
	$response->email === 'matheuslunadev@gmail.com',
	'Deve retornar o email correto'
);

assertTrue(
	$response->role === 'ADMIN',
	'Deve retornar a role correta'
);

assertTrue(
	$response->accessToken === 'fake-token-1',
	'Deve retornar o token correto'
);

echo "\n 🎉 All AuthenticateUserUseCase tests passed.\n\n";
