<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Modules\Auth\Application\UseCases\AuthenticateUserUseCase;
use App\Modules\Auth\Application\DTO\LoginResponse;
use App\Modules\Auth\Domain\Exceptions\InvalidCredentialsException;
use App\Shared\Infrastructure\Http\JsonResponse;

class LoginController
{

	public function __construct(
		private AuthenticateUserUseCase $usecase
	) {}

	public function handle(array $request): JsonResponse
	{

		try {
			if (
				!isset($request['email']) || 
				!isset($request['password']) ||
				trim($request['email']) === '' ||
				trim($request['password']) === ''
			) {
				return new JsonResponse([ 'error' => 'Email e senha são obrigatórios'], 400);
			}

			$response = $this->usecase->execute($request['email'], $request['password']);
			return new JsonResponse([
				'data' => $response->toArray()
			], 200);
		} catch (InvalidCredentialsException $e) {
			return new JsonResponse([
				'error' => $e->getMessage()
			], 401);
		} catch (\Throwable $e) {
			return new JsonResponse([
				'error'  => $e->getMessage()
			], 500);	
		}
	}

}
