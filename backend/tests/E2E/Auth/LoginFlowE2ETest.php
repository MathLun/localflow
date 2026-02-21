<?php

resetDatabase();
createUser();

$ch = curl_init('http://localhost:8001/auth/login');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'email' => 'admin@email.com',
    'password' => '123456'
]));

$responseBody = curl_exec($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$body = json_decode($responseBody, true);
$data = $body['data'];

assertTrue(
	is_array($body),
	'resposta deve ser JSON válido'
);

assertTrue(
	$statusCode === 200,
	'Status deve ser 200'
);

assertTrue(
	isset($data['accessToken']),
	'Deve conter accessToken'
);

assertTrue(
	$data['email'] === 'admin@email.com',
	'Email deve bater'
);

curl_close($ch);


