<?php

namespace App\Modules\Auth\Fakes;

use App\Modules\Auth\Application\Contracts\TokenGeneratorInterface;

final class FakeTokenGenerator
	implements TokenGeneratorInterface
{
	public function generate(
		string $userId,
		string $email,
		string $role
	): string {
		return 'fake-token-' . $userId;
	}
}
