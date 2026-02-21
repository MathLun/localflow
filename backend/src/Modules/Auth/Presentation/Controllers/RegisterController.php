<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Modules\Auth\Application\UseCases\RegisterUserUseCase;
use App\Modules\Auth\Application\DTO\RegisterRequest;
use App\Shared\Infrastructure\Http\JsonResponse;

use DomainException;

class RegisterController
{
	public function __construct(
		private RegisterUserUseCase $usecase
	) {}

	public function handle(array $input): JsonResponse
	{
		try {
			if (
				!is_array($input) ||
				empty($input['email']) ||
				empty($input['password'])
			) {
				return new JsonResponse([
					'error' => 'Os devem ser preenchidos obrigatorios'
				], 400);
			}

			$request = new RegisterRequest(
				email: $input['email'], 
				password: $input['password']
			);
			$response = $this->usecase->execute($request);
			return new JsonResponse([
				'message' => 'Conta criada com sucesso.',
				'data' => $response->toArray()
			], 201);
		} catch (DomainException $e) {
			return new JsonResponse([
				'error' => $e->getMessage()
			], 409);
		} catch (\Throwable $e) {
			return new JsonResponse([
				'error' => $e->getMessage()
			], 500);
		}
	}
}
