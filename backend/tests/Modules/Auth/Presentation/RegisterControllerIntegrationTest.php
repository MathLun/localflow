<?php

use App\Modules\Auth\Presentation\Controllers\RegisterController;
use App\Modules\Auth\Application\UseCases\RegisterUserUseCase;
use App\Modules\Auth\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use App\Modules\Auth\Fakes\FakePasswordHasher;
use App\Modules\Auth\Fakes\FakeTokenGenerator;

$userRepository = new InMemoryUserRepository();
$tokenGenerator = new FakeTokenGenerator();
$passwordHasher = new FakePasswordHasher();
$usecase = new RegisterUserUseCase(
	$userRepository,
	$passwordHasher,
	$tokenGenerator
);
$controller = new RegisterController($usecase);

$response = $controller->handle([
	'email' => 'admin@email.com',
	'password' => '123456'
]);

$body = json_decode($response->getBody(), true);

assertTrue(
	isset($body['data']['accessToken']),
	'Deve existir accessToken'
);

assertTrue(
	$body['data']['email'] === 'admin@email.com',
	'Deve retornar o email como admin@email.com, email recebido: '.($body['data']['email'] ?? 'null')
);
