<?php

namespace App\Modules\Auth\Application\Contracts;

interface TokenGeneratorInterface
{
	public function generate(
		string $userId,
		string $email,
		string $role
	): string;
}

