# Backend

Backend modular estruturado com separação clara de responsabilidades, preparado para suportar múltiplos domínios e módulos de negócio.

O módulo **Auth** é apenas o primeiro módulo implementado.

## Arquitetura

O projeto segue princípios de arquitetura em camadas, com foco em baixo acoplamento e alta coesão.

Estrutura geral
```bash
.
├── README.md
├── bin
│   ├── make_migration.php
│   └── migrate.php
├── bootstrap
│   └── app.php
├── docs
│   ├── modules
│   │   └── auth
│   │       └── login-flow.md
│   └── testing.md
├── public
│   └── index.php
├── src
│   ├── Core
│   │   ├── Database
│   │   │   ├── Database.php
│   │   │   └── Migrations
│   │   │       ├── MigrationGenerator.php
│   │   │       └── MigrationRunner.php
│   │   └── Routing
│   │       └── Router.php
│   ├── Modules
│   │   ├── Auth
│   │   │   ├── Application
│   │   │   │   ├── Contracts
│   │   │   │   │   └── TokenGeneratorInterface.php
│   │   │   │   ├── DTO
│   │   │   │   │   └── LoginResponse.php
│   │   │   │   └── UseCases
│   │   │   │       └── AuthenticateUserUseCase.php
│   │   │   ├── Domain
│   │   │   │   ├── Entities
│   │   │   │   │   └── User.php
│   │   │   │   ├── Exceptions
│   │   │   │   │   ├── InvalidCredentialsException.php
│   │   │   │   │   └── InvalidUserException.php
│   │   │   │   └── Repositories
│   │   │   │       └── UserRepositoryInterface.php
│   │   │   ├── Fakes
│   │   │   │   └── FakeTokenGenerator.php
│   │   │   ├── Infrastructure
│   │   │   │   └── Persistence
│   │   │   │       ├── InMemory
│   │   │   │       │   └── InMemoryUserRepository.php
│   │   │   │       └── SQLite
│   │   │   │           └── SQLiteUserRepository.php
│   │   │   └── Presentation
│   │   │       └── Controllers
│   │   │           └── LoginController.php
│   │   ├── Orders
│   │   ├── Products
│   │   ├── Restaurants
│   │   └── System
│   └── Support
│       └── Autoload.php
├── storage
│   ├── database.sqlite
│   └── migrations
│       └── 20260214010310_create_user_table.sql
└── tests
    ├── Modules
    │   └── Auth
    │       ├── Application
    │       │   └── AuthenticateUserUseCaseTest.php
    │       ├── Domain
    │       │   └── UserTest.php
    │       ├── Infrastructure
    │       │   ├── InMemoryUserRepositoryTest.php
    │       │   └── SQLiteUserRepositoryTest.php
    │       └── Presentation
    │           └── LoginControllerIntegrationTest.php
    ├── Support
    │   └── TestHelpers.php
    └── TestRunner.php
```

### Core

Contém componentes reutilizáveis e independentes do domínio específico.

inclui:

- Conexão com banco (Database)
- Sistema de migrations
- Componentes compartilhados

Não contém regras de negócio específicas.

### Modules

Cada domínio do sistema é isolado em cada módulo próprio.

Exemplo atual
```text
Modules/Auth
```

Cada módulo pode conter:

- Domain
- Application
- Infrastructure
- Presentation

Isso permite expansão futuras como:
```text
Modules/Orders
Modules/Products
Modules/Restaurants
```

Sem acoplamento entre domínios.

### Domain (por módulo)

Contém regras de negócios puras.

Exemplo no módulo Auth:

- Entidade User
- Controle temporal (now())
- Regras invariantes

O dominio não depende de infraestrutura.

### Application (em construção)

Orquestra casos de uso de cada módulo.

Exemplo futuros no Auth:

- LoginUseCase

Depende apenas de contratos.

### Infrastructure

Implementações técnicas:

- SQLite
- Repositórios concretos
- Scripts CLI
- Adapters externos

Implementa contratos definidos pelo domínio ou application.

## Banco de dados

O projeto utiliza SQLite como mecanismo de persistência inicial.

A camada de infraestrutura foi projetada para permitir futura substituição por outro driver (ex: PostgreSQL) sem impactar o domínio.

**Gerar uma migration**
```bash
php bin/make_migration.php nome_da_migration
```

**Exemplo**
```bash
php bin/make_migration.php create_user_table
```

**Executar migrations**
```bash
php bin/migrate.php
```

O comando:

- Cria o banco caso não exista
- Execute migrations pendentes

## Testes

Testes automatizados garantem estabilidade da camada de infraestrutura.

Atualmente implementado:

- Teste de integração do SQLiteUserRepository

Futuramente:

- Testes de UseCase
- Testes E2E
- Testes por módulos

## Roadmap

**Fase 1 - Fundação Arquitetural (concluída)**

- [x] Estrutura Modular
- [x] Separação em camadas
- [x] Sistema de migrations
- [x] Persistência SQLite
- [x] Repositório para módulo Auth
- [x] Testes de integração

**Fase 2 - Application Layer**

- [x] Implementação de UseCases (Auth)
- [x] Hash de senha
- [x] Recuperação por e-mail
- [x] Validação de domínio

**Fase 3 - Interface HTTP**

- [x] Controllers
- [x] Endpoint REST
- [x] Serialização JSON

**Fase 4 - Teste End-to-End**

- [ ] Cliente HTTP de Teste
- [ ] Fluxo completo de registro
- [ ] Fluxo completo de autenticação

## Diretrizes Arquiteturais

O backend foi projetado para:

- Crescer por módulos
- Manter domínio isolado
- Permitir troca de infraestrutura
- Suportar evolução incremental
- Garantir testabilidade

Auth é apenas o módulo inicial.

