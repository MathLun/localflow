<?php

$router = require __DIR__ . '/../bootstrap/app.php';

use App\Modules\Auth\Presentation\Controllers\LoginController;
$router->post('/auth/login', [LoginController::class, 'handle']);

$router->dispatch();
