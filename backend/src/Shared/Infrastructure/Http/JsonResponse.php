<?php

namespace App\Shared\Infrastructure\Http;

class JsonResponse
{
	public function __construct(
		private array $data,
		private int $statusCode
	) {}

	public function getStatusCode(): int
	{
		return $this->statusCode;
	}

	public function getBody(): string
	{
		return json_encode($this->data);
	}
}
