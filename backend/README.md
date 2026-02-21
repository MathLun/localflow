# Backend

Backend modular estruturado com separação clara de responsabilidades, preparado para suportar múltiplos domínios e módulos de negócio.

O módulo **Auth** é apenas o primeiro módulo implementado e atualmente suporta:

- Registro de usuário (nível Apllication)
- Autenticação (Login Flow)
- Persistência via SQLite
- Testes unitários, integrações e E2E (Login)

## 🧠 Arquitetura

O projeto segue o padrão **Modular Monolith**, com arquitetura em camadas:

- **Domain**
- **Application**
- **Infrastructure**
- **Presentation**

Foco em:

- Baixo acoplamento
- Alta coesão
- Testabilidade
- Evolução incremental

## 📁 Estrutura geral
```bash
backend
├── bin
├── bootstrap
├── docs
│   └── modules
├── public
├── src
│   ├── Core
│   ├── Modules
│   ├── Shared
│   └── Support
├── storage
│   └── migrations
└── tests
    ├── E2E
    ├── Modules
    └── Support
```

### 🧩 Core

Contém componentes reutilizáveis e independentes do domínio específico.

inclui:

- Conexão com banco (Database)
- Sistema de migrations
- Componentes compartilhados

Não contém regras de negócio específicas.

### 🧱 Modules

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

## 🔐 Módulo Auth

Atualmente contém:

### Domain

- Entidade `User`
- Exceptions de domínio
- `UserRepositoryInterface`

### Application

- `AuthenticateUserUseCase`
- `RegisterUserUseCase`
- `PasswordHasherInterface`

A camada Application depende apenas de contratos.

### Infrastructure

- `SQLiteUserRepository`
- `InMemoryUserRepository`
- `FakeTokenGenerator`
- `FakePasswordHasher`

Implementa contratos definidos pelo domínio ou aplicação.

### Presentation

- `LoginController`
- (RegisterController em construção)

## 🗄 Banco de dados

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

## 🧪 Testes

O projeto possui múltiplos níveis de testes.

### ✅️ Testes Unitários

- Entidades
- UseCases
- Contratos

### ✅️ Testes de Infraestrutura

- InMemoryUserRepository
- SQLiteUserRepository

### Testes de Integração

- LoginController

### ✅️ Testes End-to-End (E2E)

Cobrem o fluxo real de autenticação.

- Login com sucesso
- Credenciais inválidas (401)
- Payload inválido (400)

### 📁 Estrutura de Testes

```bash
.
├── E2E
│   └── Auth
│       └── LoginFlowE2ETest.php
├── E2ETestRunner.php
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

### ▶️ Executando o Projeto

**Requisitos**

- PHP 8.2+

**Rodar servidor local**
```bash
cd backend
php -S localhost:8000 -t public
```

### ▶️ Executando os testes

🧩 **Unitários e Integrações**
```bash
php tests/TestRunner.php
```

🌐 **End-to-End**

inicie o servidor
```bash
php -S localhost:8000 -t public
```

Em outro terminal:
```bash
php tests/E2ETestRunner.php
```

### 🎯 Objetivo

Garantir:

- Isolamento total do dominio
- Confiabilidade da infraestrutura
- Evolução controlada
- Validação de fluxos completos via HTTP real
- Facilidade futura de extração para microserviços
- Segurança desde a base

## Roadmap

**Fase 1 - Fundação Arquitetural** ✅️

- [x] Modular Monolith
- [x] Migrations
- [x] SQLite
- [x] Login Flow
- [x] Testes E2E de Login

**Fase 2 - Application Layer** 🔄

- [x] RegisterUserUseCase
- [x] AuthenticateUserUseCase
- [x] RegisterRequest (DTO)
- [x] RegisterResponse (DTO)
- [x] LoginResponse (DTO)
- [x] PasswordHasherInterface (Contract)
- [x] TokenGeneratorInterface (Contract)
- [x] Hash de senha
- [x] Recuperação por e-mail
- [x] Validação de domínio
- [x] Tratamento de exceções de negócio

**Fase 3 - Interface HTTP** 🌐

- [x] Controllers (LoginController, RegisterController)
- [x] Endpoint REST
- [x] Serialização JSON

**Fase 4 - Teste End-to-End** 🧪

- [x] Cliente HTTP de Teste
- [x] Fluxo completo de registro
- [x] Fluxo completo de autenticação

**Fase 5 - Expansão de Domínios** 🧱

- Orders
- Products
- Restaurants

## Diretrizes Arquiteturais

O backend foi projetado para:

- Crescer por módulos
- Manter domínio isolado
- Permitir troca de infraestrutura
- Suportar evolução incremental
- Garantir altas cobertura de testes.

Auth é apenas o módulo inicial.

