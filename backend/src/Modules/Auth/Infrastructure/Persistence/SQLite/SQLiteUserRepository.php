<?php

namespace App\Modules\Auth\Infrastructure\Persistence\SQLite;

use PDO;
use App\Modules\Auth\Domain\Entities\User;
use App\Modules\Auth\Domain\Repositories\UserRepositoryInterface;

class SQLiteUserRepository
	implements UserRepositoryInterface
{
	public function __construct(
		private PDO $connection
	) {}

	public function save(User $user): void
	{
		$sql = <<<SQL
		  INSERT INTO users (
			id,
			email,
			password_hash,
			role,
			created_at,
			updated_at
		  ) VALUES (
			:id,
			:email,
			:password_hash,
			:role,
			:created_at,
			:updated_at
		  )
		  ON CONFLICT(id) DO UPDATE SET
		  	email = excluded.email,
			password_hash = excluded.password_hash,
			role = excluded.role,
			updated_at = excluded.created_at 
		SQL;


		$stmt = $this->connection->prepare($sql);
		$stmt->execute([
			'id' => $user->id(),
			'email' => $user->email(),
			'password_hash' => $user->passwordHash(),
			'role' => $user->role(),
			'created_at' => $user->createdAt(),
			'updated_at' => $user->updatedAt()
		]);

	}

	public function findByEmail(string $email): ?User
	{
		$sql = <<<SQL
			SELECT * FROM users
			WHERE email = :email
			LIMIT 1
		SQL;
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([
			'email' => $email
		]);

		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		return $data ? $this->mapToUser($data) : null;
	}

	public function findById(string $id): ?User
	{
	}

	private function mapToUser(array $data): User
	{
		return User::fromPersistence(
			id: $data['id'],
			email: $data['email'],
			passwordHash: $data['password_hash'],
			role: $data['role'],
			createdAt: $data['created_at'],
			updatedAt: $data['updated_at']
		);
	}
}
