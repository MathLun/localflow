<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Modules\Auth\Domain\Entities\User;
use App\Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use App\Modules\Auth\Application\Contracts\PasswordHasherInterface;
use App\Modules\Auth\Application\Contracts\TokenGeneratorInterface;
use App\Modules\Auth\Application\DTO\RegisterRequest;
use App\Modules\Auth\Application\DTO\RegisterResponse;
use App\Modules\Auth\Domain\Exceptions\EmailAlreadyExistsException;

class RegisterUserUseCase
{
	public function __construct(
		private UserRepositoryInterface $userRepository,
		private PasswordHasherInterface $passwordHasher,
		private TokenGeneratorInterface $tokenGenerator
	) {}

	public function execute(
		RegisterRequest $request
	): RegisterResponse {
		$userExists = $this->userRepository->findByEmail($request->getEmail());

		if ($userExists) {
			throw new EmailAlreadyExistsException('Email já cadastrado');
		}

		$hashedPassword = $this->passwordHasher->hash($request->getPassword());

		$user = User::register(
			email: $request->getEmail(),
			passwordHash: $hashedPassword,
		);

		$this->userRepository->save($user);

		$token = $this->tokenGenerator->generate($user->id(), $user->email(), $user->role());

		return new RegisterResponse(
			userId: $user->id(), 
			email: $user->email(), 
			role: $user->role(),
			accessToken: $token
		);
	}
}
