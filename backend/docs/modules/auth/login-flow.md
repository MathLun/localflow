# LocalFlow - Login Flow

## 🎯 Objetivo

Quando as credenciais são validas, o sistema retorna um LoginResponse, contendo um accessToken e informações básicas do usuário autenticado (userId, email, role).

Em caso de falha, o sistema lança InvalidCredentialsException, sem revelar qual credencial falhou.


## Fluxo Arquitetural

O fluxo segue a arquitetura modular monolitica da aplicação:

```
 Router -> LoginController -> LoginUseCase -> 
 UserRepository -> User -> LoginResponse
```

### Responsabilidades:
#### LoginController (Presentation)
- Recebe os dados de entrada
- Chama o UseCase
- Retorna os dados formatados

#### LoginUseCase (Application)
- Orquestra o processo de autenticação
- Valida credenciais
- Gera Token

#### User (Domain Entity)
- Representa o usuário
- Encapsula validação de senha

#### UserRepositoryInterface (Domain Contract)
- Define contrato de busca de usuário

#### InMemoryUserRepository (Infrastructure)
- Implementação concreta para persistência em memória

#### TokenGenerationInterface (Application Contract)
- Define contrato para geração de token

#### FakeTokenGenerator (Test/Fake)
- Implementação fake utilizada para testes

## Regras de Negócio

- O usuário deve existir.
- A senha deve corresponder ao usuário.
- Em qualquer falha de autenticação, o sistema lança InvalidCredentialsException.
- O sistema não informa se o erro foi email ou senha inconrreta (proteção contra enumeração de usuários).

## Tratamento de Erros

- O LoginUseCase lança exceções de domínio.
- O Controller não captura essas exceções. O tratamento HTTP deve ser responsabilidade de camada externa (infraestrutura).

## Estratégia de Testes

O Login Flow possui:

#### Unit Tests

- LoginUseCaseTest
- UserTest
- InMemoryUserRepository

#### Integration Test

- LoginControllerIntegrationTest

Os testes cobrem:

- Login válido
- Credenciais inválidas
- Fluxo completo de integração entre camadas

## Decisões Arquiteturais

- Uso de apenas uma exceção (InvalidCredentialsException) para segurança dos dados.
- Separação clara entre Domain, Application, Infrastructure e Presentation.
- Controller desaclopado de infraestrutura HTTP.
- Uso de contratos (interfaces) para dependências externas.
