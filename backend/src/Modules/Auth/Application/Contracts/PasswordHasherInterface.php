<?php

namespace App\Modules\Auth\Application\Contracts;

interface PasswordHasherInterface
{
	public function hash(string $password): string;
	public function verify(
		string $password,
		string $hash
	): bool;
}
