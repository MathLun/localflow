# LocalFlow

## Status
🚧 MVP em desenvolvimento.

## 🎯 Objetivo do Projeto

LocalFlow é um sistema SaaS voltado para gestão de pedidos e operações de pequenos negócios locais, com foco em simplicidade, segurança e escalabilidade controlada.

## 🧠 Arquitetura

O projeto segue uma arquitetura modular simples, separando:
- `public/` -> ponto de entrada (Front Controller).
- `bootstrap/` -> inicialização da aplicação.
- `src/Core/` -> infraestrutura base (Router, Request, etc...).
- `src/Controllers/` -> camada de aplicação.
- `src/Support/` -> utilitários e suporte.

## 🏗Estrutura Inicial do Projeto

Este projeto utiliza PHP Puro, com uma arquitetura inspirada em boas práticas de frameworks modernas, porém sem dependências externas.

A estrutura atual está organizada da seguinte forma:
```text
.
├── README.md
└── backend
    ├── bootstrap
    │   └── app.php
    ├── public
    │   └── index.php
    └── src
        ├── Controllers
        │   └── HelloController.php
        ├── Core
        │   └── Router.php
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

- [x] Estrutura base do backend
- [x] Router simples
- [x] Autoload manual
- [ ] Sistema de autenticação
- [ ] Integração com banco de dados
- [ ] Containerização com Docker
- [ ] API REST para pedidos
- [ ] Painel administrativo

## 🔐 Principios do Projeto

- Segurança desde a base (sanitização de inputs e middlewares)
- Separação clara de responsabilidades
- Baixa dependência externa
- Preparado para escalar gradualmente

## Licença

Este projeto está sob a licença MIT.
