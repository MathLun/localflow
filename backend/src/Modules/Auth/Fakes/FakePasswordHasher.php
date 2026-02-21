<?php

namespace App\Modules\Auth\Fakes;

use App\Modules\Auth\Application\Contracts\PasswordHasherInterface;

class FakePasswordHasher implements PasswordHasherInterface
{
	public function hash(string $password): string
	{
		return "hashed-" . $password;
	}

	public function verify(
		string $password,
		string $hash
	): bool {
		return $hash === "hashed-".$password;
	}
}
