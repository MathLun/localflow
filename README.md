# LocalFlow

## Status
🚧 MVP em desenvolvimento.

## 🎯 Objetivo do Projeto

LocalFlow é um sistema SaaS voltado para gestão de pedidos e operações de pequenos negócios locais, com foco em simplicidade, segurança e escalabilidade controlada.

## 🧠 Arquitetura Modular (Modular Monolith)

O LocalFlow adota o padrão Modular Monolith, organizando o sistema por módulos de negócio.

O padrão Modular Monolith foi escolhido para permitir evolução controlada do sistema, mantendo baixo aclopamento interno e facilitando uma futura migração para microserviços, se necessário.

Cada módulo é dividido em quatro camadas:

- `Domain` -> Regras de negócio e entidades.
- `Application` -> Casos de Uso.
- `Infra` -> Implementações técnicas (ex: repositórios).
- `Interfaces` -> Camada de entrada (HTTP, CLI, etc.).

## 🏗Estrutura Inicial do Projeto

Este projeto utiliza PHP Puro, com uma arquitetura inspirada em boas práticas modernas, priorizando baixo acoplamento, alta coesão e evolução incremental.

A estrutura atual está organizada da seguinte forma:
```text
.
├── bootstrap
│   └── app.php
├── public
│   └── index.php
└── src
    ├── Core
    │   └── Routing
    │       └── Router.php
    ├── Modules
    │   ├── Auth
    │   │   └── Interfaces
    │   │       └── Http
    │   │           └── LoginController.php
    │   ├── Orders
    │   ├── Products
    │   ├── Restaurants
    │   └── System
    └── Support
        └── Autoload.php
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

##  Roadmap

### Fase 1 - Fundamentos
- [x] Estrutura base do backend
- [x] Router simples
- [x] Autoload manual

### Fase 2 - MVP Funcional
- [ ] Sistema de autenticação
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

## Licença

Este projeto está sob a licença MIT.
