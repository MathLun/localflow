<?php

$router = require __DIR__ . '/../bootstrap/app.php';

use App\Modules\Auth\Interfaces\Http\LoginController;
$router->get('/auth/login', [LoginController::class, 'index']);

$router->dispatch();
