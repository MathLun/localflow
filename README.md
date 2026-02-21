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
  - Login Flow (com Controller, Integração e E2E)
  - Register UseCase (nível de aplicação com testes unitários)

## 🏗Estrutura Inicial do Projeto

Este projeto utiliza PHP Puro, com uma arquitetura inspirada em boas práticas modernas, priorizando baixo acoplamento, alta coesão e evolução incremental.

A estrutura atual está organizada da seguinte forma:
```text
.
├── CHANGELOG.md
├── README.md
└── backend
    ├── README.md
    ├── bin
    ├── bootstrap
    ├── docs
    ├── public
    ├── src
    ├── storage
    └── tests
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

O projeto possui dois níveis de testes automatizados:

### 🧪 Testes Unitários e de Integração

Validam regras de negócio, repositórios e controllers de forma isolada.

```bash
cd backend
php tests/TestRunner.php
```

### 🌐 Testes End-to-End (E2E)

Executam requisições HTTP reais contra a aplicação, validando o fluxo complexo. (ex: LoginFlow).

Atualmente cobrem:

- Login com sucesso
- Credenciais inválidas (401)
- Payload inválido ou campos obrigatórios ausente (400)

Antes de rodar, inicie o servidor PHP embutido:

```bash
cd backend
php -S localhost:8000 -t public
```

Em outro terminal, execute:

```bash
php tests/E2ETestRunner.php
```

### 📌 Observações

Os testes E2E validam:

- Status code da resposta
- Estrutura do JSON retornando
- Fluxo completo de autenticação

## 🔐 Endpoints disponíveis

### Login

**POST** /auth/login

Autentica um usuário com email e senha.

**Exemplo de requisição**
```bash
curl -X POST 
http://localhost:8000/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@email.com",
    "password": "123456"
  }'
```

**Exemplo de resposta (sucesso)**
```json
{
  "userId": "1",
  "email": "admin@email.com",
  "role": "ADMIN",
  "accessToken": "fake-token-1"
}
```

##  Roadmap

### Fase 1 - Fundamentos
- [x] Estrutura base do backend
- [x] Router simples
- [x] Autoload manual

### Fase 2 - MVP Funcional
- [x] Sistema de autenticação (Login Flow)
- [x] UseCase de registro de usuário
- [x] Integração com banco de dados (SQLite)
- [x] API REST para login
- [ ] API REST para pedidos

### Fase 3 - Infraestrutura
- [ ] Containerização com Docker
- [ ] Painel administrativo

## 🔐 Princípios do Projeto

- Segurança desde a base (sanitização de inputs e middlewares)
- Separação clara de responsabilidades
- Baixa dependência externa
- Preparado para escalar gradualmente

## 📘 Documentação
- [Login Flow](backend/docs/modules/auth/login-flow.md)
- [Register User - (em desenvolvimento)](backend/docs/modules/auth/register-user.md)
- [Testing Strategy](backend/docs/testing.md)

## Licença

Este projeto está sob a licença MIT.
