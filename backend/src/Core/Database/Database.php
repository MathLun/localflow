<?php

namespace App\Core\Database;

use PDO;

final class Database
{
	private PDO $connection;

	public function __construct(
		string $dbFilePath
	) {
		$this->connection = new PDO("sqlite:" . $dbFilePath);
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function getConnection(): PDO
	{
		return $this->connection;
	}
}
