<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Modules\Auth\Application\UseCases\AuthenticateUserUseCase;
use App\Modules\Auth\Application\DTO\LoginResponse;

class LoginController
{

	public function __construct(
		private AuthenticateUserUseCase $usecase
	) {}

	public function handle(array $request): array
	{
		$response = $this->usecase->execute($request['email'], $request['password']);

		return $response->toArray();
	}
}
