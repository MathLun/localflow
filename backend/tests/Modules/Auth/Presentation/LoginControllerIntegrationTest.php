<?php

use App\Modules\Auth\Presentation\Controllers\LoginController;
use App\Modules\Auth\Application\UseCases\AuthenticateUserUseCase;
use App\Modules\Auth\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use App\Modules\Auth\Fakes\FakeTokenGenerator;
use App\Modules\Auth\Domain\Entities\User;
use App\Modules\Auth\Domain\Exceptions\InvalidCredentialsException;

$userRepository = new InMemoryUserRepository();
$tokenGenerator = new FakeTokenGenerator();
$usecase = new AuthenticateUserUseCase(
	$userRepository, 
	$tokenGenerator
);
$controller = new LoginController($usecase);

$user = User::create(
	id: '1',
	email: 'matheuslunadev@gmail.com',
	passwordHash: password_hash('123456', PASSWORD_DEFAULT),
	role: 'ADMIN'
);

$userRepository->save($user);
$response = $controller->handle([
	'email' => "matheuslunadev@gmail.com",
	'password' => "123456"
]);

$body = json_decode($response->getBody(), true);
assertTrue(
	isset($body['data']['accessToken']),
	'Deve retornar accessToken quando credenciais forem válidas.'
);

/*
assertTrue(
	$body['data']['accessToken'] === 'fake-token-1',
	'Deve retornar o token esperado'
);

assertThrows(
	fn() => $controller->handle([
		'email' => 'matheuslunadev@gmail.com',
		'password' => '12345'
	]),
	InvalidCredentialsException::class,
	'Deve lançar exceção quando as credenciais está inválida'
);
 */
