<?php

require __DIR__ . '/../src/Support/Autoload.php';

use App\Core\Routing\Router;
use App\Modules\Auth\Domain\Entities\User;
use App\Modules\Auth\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use App\Modules\Auth\Fakes\FakeTokenGenerator;
use App\Modules\Auth\Application\UseCases\LoginUseCase;
use App\Modules\Auth\Presentation\Controllers\LoginController;

$router = new Router();
$userRepository = new InMemoryUserRepository();
$tokenGenerator = new FakeTokenGenerator();

$user = User::create(
	id: '1',
	email: 'matheuslunadev@gmail.com',
	passwordHash: password_hash('123456', PASSWORD_DEFAULT),
	role: 'ADMIN'
);

$userRepository->save($user);

$loginUseCase = new LoginUseCase(
	$userRepository,
	$tokenGenerator
);

// Registrar dependências do controller
$router->bind(LoginController::class, fn() => new LoginController($loginUseCase));

return $router;
