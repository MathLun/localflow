<?php

$router = require __DIR__ . '/../bootstrap/app.php';

$router->get('/', 'HelloController@index');

$router->dispatch();
