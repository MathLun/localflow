<?php

namespace App\Modules\Auth\Application\DTO;

final class LoginResponse
{
	public function __construct(
		public readonly string $userId,
		public readonly string $email,
		public readonly string $role,
		public readonly string $accessToken
	) {}

	public function toArray(): array
	{
		return [
		  'userId' => $this->userId,
		  'email' => $this->email,
		  'role' => $this->role,
		  'accessToken' => $this->accessToken
		];
	}
}
