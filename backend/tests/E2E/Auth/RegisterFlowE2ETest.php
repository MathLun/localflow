<?php

declare(strict_types=1);

resetDatabase();

echo "\n🔹️ RegisterFlowE2ETest\n";

$payload = json_encode([
	'email' => 'admin@email.com',
	'password' => '123456'
]);

$headers = [
	'Content-Type: application/json'
];

$ch = curl_init('http://localhost:8001/auth/register');

curl_setopt_array($ch, [
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_POST => true,
	CURLOPT_POSTFIELDS => $payload,
	CURLOPT_HTTPHEADER => $headers,
]);

$response = curl_exec($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

$body = json_decode($response, true);

assertTrue(
	$statusCode === 201,
	'Deve retornar status 201 ao registrar usuário, recebido: ' . $statusCode
);

assertTrue(
	$body['data']['email'] === 'admin@email.com',
	'Deve retornar email admin@email.com'
);
