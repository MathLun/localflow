<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Modules\Auth\Application\Contracts\TokenGeneratorInterface;
use App\Modules\Auth\Application\DTO\LoginResponse;
use App\Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use App\Modules\Auth\Domain\Exceptions\InvalidCredentialsException;

class LoginUseCase
{
	public function __construct(
		private UserRepositoryInterface $userRepository,
		private TokenGeneratorInterface $tokenGenerator
	) {}

	public function execute(
		string $email,
		string $password
	): LoginResponse {
		$user = $this->userRepository->findByEmail($email);
		if (!$user) 
		{
			throw new InvalidCredentialsException('Credenciais invalidas');
		}

		if (!$user->verifyPassword($password)) 
		{
			throw new InvalidCredentialsException('Credenciais invalidas');
		}

		$token = $this->tokenGenerator->generate($user->id(), $user->email(), $user->role());

		return new LoginResponse(
			userId: $user->id(),
			email: $user->email(),
			role: $user->role(),
			accessToken: $token
		);
	}
}
