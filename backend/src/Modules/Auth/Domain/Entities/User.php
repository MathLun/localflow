<?php

namespace App\Modules\Auth\Domain\Entities;

use App\Modules\Auth\Domain\Exceptions\InvalidUserException;

final class User
{
	private string $id;
	private string $email;
	private string $passwordHash;
	private string $role;

	private const ALLOWED_ROLES = ['ADMIN', 'RESTAURANT', 'STAFF'];

	private function __construct(
		string $id,
		string $email,
		string $passwordHash,
		string $role
	) {
		$email = strtolower(trim($email));
		$this->validateEmail($email);
		$this->validatePasswordHash($passwordHash);
		$this->validateRole($role);

		$this->id = $id;

		$this->email = $email;

		$this->passwordHash = $passwordHash;
		$this->role = $role;
	}

	public static function create(
		string $id,
		string $email,
		string $passwordHash,
		string $role
	): self {
		return new self($id, $email, $passwordHash, $role);
	}

	public function validateEmail(string $email): void
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new InvalidUserException('Invalid email format');
		}
	}

	public function validatePasswordHash(string $passwordHash): void
	{
		if (empty($passwordHash)) {
			throw new InvalidUserException('Password hash cannot be empty.');
		}
	}

	public function validateRole(string $role): void
	{
		if (!in_array($role, self::ALLOWED_ROLES, true)) {
			throw new InvalidUserException('Invalid role');
		}
	}

	public function verifyPassword(string $plainPassword): bool
	{
		return password_verify($plainPassword, $this->passwordHash);
	}

	public function id(): string
	{
		return $this->id;
	}

	public function email(): string
	{
		return $this->email;
	}

	public function passwordHash(): string
	{
		return $this->passwordHash;
	}

	public function role(): string
	{
		return $this->role;
	}
}
