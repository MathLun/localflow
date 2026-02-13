# LocalFlow

## Status
🚧 MVP em desenvolvimento.

## 🎯 Objetivo do Projeto

LocalFlow é um sistema SaaS voltado para gestão de pedidos e operações de pequenos negócios locais, com foco em simplicidade, segurança e escalabilidade controlada.

## 🧠 Arquitetura Modular (Modular Monolith)

O LocalFlow adota o padrão Modular Monolith, organizando o sistema por módulos de negócio.

O padrão Modular Monolith foi escolhido para permitir evolução controlada do sistema, mantendo baixo acoplamento interno e facilitando uma futura migração para microserviços, se necessário.

Cada módulo é dividido em quatro camadas:

- `Domain` -> Regras de negócio e entidades.
- `Application` -> Casos de Uso.
- `Infrastructure` -> Implementações técnicas (ex: repositórios).
- `Presentation` -> Camada de entrada (HTTP, CLI, etc.).

## Módulos Implementados
- **Auth**
-- Login Flow

## 🏗Estrutura Inicial do Projeto

Este projeto utiliza PHP Puro, com uma arquitetura inspirada em boas práticas modernas, priorizando baixo acoplamento, alta coesão e evolução incremental.

A estrutura atual está organizada da seguinte forma:
```text
backend
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
│   │   └── Routing
│   │       └── Router.php                                     │   ├── Modules
│   │   ├── Auth
│   │   │   ├── Application
│   │   │   │   ├── Contracts
│   │   │   │   │   └── TokenGeneratorInterface.php            │   │   │   │   ├── DTO                                        │   │   │   │   │   └── LoginResponse.php
│   │   │   │   └── UseCases
│   │   │   │       └── LoginUseCase.php                       │   │   │   ├── Domain                                         │   │   │   │   ├── Entities                                   │   │   │   │   │   └── User.php                               │   │   │   │   ├── Exceptions
│   │   │   │   │   ├── InvalidCredentialsException.php
│   │   │   │   │   └── InvalidUserException.php
│   │   │   │   └── Repositories
│   │   │   │       └── UserRepositoryInterface.php
│   │   │   ├── Fakes
│   │   │   │   └── FakeTokenGenerator.php
│   │   │   ├── Infrastructure
│   │   │   │   └── Persistence
│   │   │   │       └── InMemory
│   │   │   │           └── InMemoryUserRepository.php
│   │   │   └── Presentation
│   │   │       └── Controllers
│   │   │           └── LoginController.php
│   │   ├── Orders
│   │   ├── Products
│   │   ├── Restaurants
│   │   └── System
│   └── Support
│       └── Autoload.php
└── tests
    ├── Modules
    │   └── Auth
    │       ├── Application
    │       │   └── LoginUseCaseTest.php
    │       ├── Domain
    │       │   └── UserTest.php
    │       ├── Infrastructure
    │       │   └── InMemoryUserRepositoryTest.php
    │       └── Presentation
    │           └── LoginControllerIntegrationTest.php
    ├── Support
    │   └── TestHelpers.php
    └── TestRunner.php
```

## Executando o projeto
### Requisitos
- PHP 8.2+
- Servidor embutido do PHP ou Nginx/Apache

### Rodando localmente
```bash
cd backend
php -S localhost:8000 -t public
```

## Rodando os testes

Para garantir que todas as features implementadas estão funcionando corretamente, incluindo o Login Flow, você pode rodar os testes automáticos:
```bash
cd backend
php tests/TestRunner.php
```

##  Roadmap

### Fase 1 - Fundamentos
- [x] Estrutura base do backend
- [x] Router simples
- [x] Autoload manual

### Fase 2 - MVP Funcional
- [x] Sistema de autenticação (Login Flow)
- [ ] Integração com banco de dados
- [ ] API REST para pedidos

### Fase 3 - Infraestrutura
- [ ] Containerização com Docker
- [ ] Painel administrativo

## 🔐 Princípios do Projeto

- Segurança desde a base (sanitização de inputs e middlewares)
- Separação clara de responsabilidades
- Baixa dependência externa
- Preparado para escalar gradualmente

## Documentação
- [Login Flow](backend/docs/modules/auth/login-flow.md)
- [Testing Strategy](backend/docs/testing.md)

## Licença

Este projeto está sob a licença MIT.
