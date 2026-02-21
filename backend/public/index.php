<?php

$router = require __DIR__ . '/../bootstrap/app.php';

use App\Modules\Auth\Presentation\Controllers\LoginController;
$router->post('/auth/login', [LoginController::class, 'handle']);

use App\Modules\Auth\Presentation\Controllers\RegisterController;
$router->post('/auth/register', [RegisterController::class, 'handle']);

$router->dispatch();
