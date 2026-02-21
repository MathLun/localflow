# Registro de Usuário

## Estado

O registro de usuário está implementado a nível de aplicação (UseCase), ainda sem integração com HTTP.

## Componentes

- RegisterUserUseCase
- RegisterRequest
- RegisterResponse
- EmailAlreadyExistsException
- PasswordHasherInterface
- FakePasswordHasher (para testes)

## Regras de negócio

- O e-mail não pode estar previamente cadastrado
- O UUID é gerado internamente pela entidade User
- A role padrão é RESTAURANT
- A senha é processada via PasswordHasherInterface

## Testes

- Fluxo de sucesso
- Exceção quando o e-mail já existe
