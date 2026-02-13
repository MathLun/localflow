<?php

namespace App\Modules\Auth\Infrastructure\Persistence\InMemory;

use App\Modules\Auth\Domain\Entities\User;
use App\Modules\Auth\Domain\Repositories\UserRepositoryInterface;

final class InMemoryUserRepository
	implements UserRepositoryInterface
{
	/*
	 * @var array<string, User>
	 */
	private array $users = [];

	public function findById(string $id): ?User
	{
		return $this->users[$id] ?? null;
	}

	public function findByEmail(string $email): ?User
	{
		foreach($this->users as $user) {
			if ($user->email() === strtolower($email)) { return $user; }
		}
		return null;
	}

	public function save(User $user): void
	{
		$this->users[$user->id()] = $user;
	}
}
