<?php

resetDatabase();
createUser();

$ch = curl_init('http://localhost:8001/auth/login');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'email' => 'user@email.com',
    'password' => '123456'
]));

$responseBody = curl_exec($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$body = json_decode($responseBody, true);
$error = $body['error'];

assertTrue(
	isset($body['error']),
	'Deve retornar error para email inválido'
);

assertTrue(
	$error === 'Credenciais invalidas',
	'Mensagem deve indicar credenciais inválidas'
);

assertTrue(
	$statusCode === 401,
	'Deve retornar 401 para credenciais invalidas'
);

curl_close($ch);

echo "\n 🎉 All LoginErrorScenariosE2ETest success passed. \n\n";
