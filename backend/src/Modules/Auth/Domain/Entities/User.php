<?php

namespace App\Modules\Auth\Domain\Entities;

use App\Modules\Auth\Domain\Exceptions\InvalidUserException;
use DateTimeImmutable;
use DateTimeZone;

final class User
{
	private string $id;
	private string $email;
	private string $passwordHash;
	private string $role;
	private string $createdAt;
	private string $updatedAt;

	private const ALLOWED_ROLES = ['ADMIN', 'RESTAURANT', 'STAFF'];

	private function __construct(
		string $id,
		string $email,
		string $passwordHash,
		string $role,
		string $createdAt,
		string $updatedAt
	) {
		$email = strtolower(trim($email));
		$this->validateEmail($email);
		$this->validatePasswordHash($passwordHash);
		$this->validateRole($role);

		$this->id = $id;

		$this->email = $email;

		$this->passwordHash = $passwordHash;
		$this->role = $role;

		$this->createdAt = $createdAt;
		$this->updatedAt = $updatedAt;
	}

	public static function create(
		string $id,
		string $email,
		string $passwordHash,
		string $role,
	): self {
		return new self(
			id: $id, 
			email: $email, 
			passwordHash: $passwordHash, 
			role: $role,
			createdAt: self::now(),
			updatedAt: self::now()
		);
	}

	public static function fromPersistence(
		string $id,
		string $email,
		string $passwordHash,
		string $role,
		string $createdAt,
		string $updatedAt
	): self {
		return new self(
			id: $id,
			email: $email,
			passwordHash: $passwordHash,
			role: $role,
			createdAt: $createdAt,
			updatedAt: $updatedAt
		);
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

	private static function now(): string
	{
		return (new DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo')))->format('Y-m-d H:i:s');
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

	public function createdAt(): string
	{
		return $this->createdAt;
	}

	public function updatedAt(): string
	{
		return $this->updatedAt;
	}
}
