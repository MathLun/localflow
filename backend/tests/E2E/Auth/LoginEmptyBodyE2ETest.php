<?php

resetDatabase();
createUser();

$ch = curl_init('http://localhost:8001/auth/login');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'email' => '',
    'password' => '123456'
]));

$responseBody = curl_exec($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$body = json_decode($responseBody, true);
$error = $body['error'];

assertTrue(
	$statusCode === 400,
	'Deve retornar 400 se body estiver vazio'
);

assertTrue(
	$error === 'Email e senha são obrigatórios',
	'Mensagem deve indicar email e senha são obrigatórios'
);
curl_close($ch);

echo "\n 🎉 All LoginEmptyBodyE2ETest success passed.\n\n";
