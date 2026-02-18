<?php

use App\Modules\Auth\Application\UseCases\RegisterUserUseCase;
use App\Modules\Auth\Fakes\FakePasswordHasher;
use App\Modules\Auth\Fakes\FakeTokenGenerator;
use App\Modules\Auth\Application\DTO\RegisterRequest;
use App\Modules\Auth\Domain\Entities\User;
use App\Modules\Auth\Domain\Exceptions\EmailAlreadyExistsException;
use App\Modules\Auth\Infrastructure\Persistence\InMemory\InMemoryUserRepository;

$userRepository = new InMemoryUserRepository();
$passwordHasher = new FakePasswordHasher();
$tokenGenerator = new FakeTokenGenerator();
$usecase = new RegisterUserUseCase(
	$userRepository,
	$passwordHasher,
	$tokenGenerator
);

$request = new RegisterRequest(
	email: "admin@email.com",
	password: "123456",
);

$response = $usecase->execute($request)->toArray();

assertTrue(
	isset($response),
	'Deve existir resposta para testar'
);

$requestEmailExists = new RegisterRequest(
	email: "admin@email.com",
	password: "123456",
);

assertThrows(
	fn() => $usecase->execute($requestEmailExists),
	EmailAlreadyExistsException::class,
	'Deve retornar excessão se o email for invalido'
);
