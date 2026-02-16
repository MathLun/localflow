<?php

require __DIR__ . '/../src/Support/Autoload.php';

use App\Core\Routing\Router;
use App\Core\Database\Database;
use App\Modules\Auth\Domain\Entities\User;
use App\Modules\Auth\Infrastructure\Persistence\SQLite\SQLiteUserRepository;
use App\Modules\Auth\Fakes\FakeTokenGenerator;
use App\Modules\Auth\Application\UseCases\AuthenticateUserUseCase;
use App\Modules\Auth\Presentation\Controllers\LoginController;

$database = new Database(__DIR__ . '/../storage/database.sqlite');

$connection = $database->getConnection();
$router = new Router();
$userRepository = new SQLiteUserRepository($connection);
$tokenGenerator = new FakeTokenGenerator();

$user = User::create(
	id: '1',
	email: 'admin@email.com',
	passwordHash: password_hash('123456', PASSWORD_DEFAULT),
	role: 'ADMIN'
);

$userRepository->save($user);

$authenticateUserUseCase = new AuthenticateUserUseCase(
	$userRepository,
	$tokenGenerator
);

// Registrar dependências do controller
$router->bind(LoginController::class, fn() => new LoginController($authenticateUserUseCase));

return $router;
