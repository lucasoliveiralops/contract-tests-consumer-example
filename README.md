# 📜 Testes de Contrato com Pact-PHP

Este repositório exemplifica a implementação de testes de contrato (Consumer-Driven Contracts) utilizando **Pact-PHP**, demonstrando a perspectiva do **consumidor**.

## 🛠 Stack

- **Symfony** (Estrutura base do projeto)
- **Pact-PHP** (Implementação de contratos)
- **PHPUnit** (Execução de testes)
- **Pact Broker** (Gerenciamento de contratos)

## 🔍 Visão Geral do projeto

### Conceitos Fundamentais

**📌 Provedor de Serviço**  
O serviço que fornece dados ou funcionalidades através de uma API (ex: um microsserviço de usuários que fornece endpoints REST).

**📌 Teste de Contrato (CDC)**  
Consumer-Driven Contracts: abordagem onde os consumidores definem as expectativas do contrato (requests/responses esperados) que o provedor deve cumprir.

**📌 Pact**  
Arquivo JSON que documenta:
- As interações esperadas (requests/responses)
- Os cenários de teste
- Metadados sobre consumidor/provedor

**📌 Pact Broker**  
Serviço que:
- Armazena e versiona contratos (pacts)
- Fornece dashboard para visualização
- Gerencia matriz de compatibilidade entre consumidores/provedores

## 🧪 Testes de Contrato (CDC)

### Estrutura dos Testes
- **Arquivo de Teste**: `tests/Cases/Contract/UserServiceTest.php`
- **Pacto Gerado**: `tests/Cases/Contract/Pact/ms-notification-control-ms-user.json`

### Fluxo de Trabalho
- **Passo 1:** O teste do consumidor é executado
- **Passo 2:** Um arquivo de pacto é gerado
- **Passo 3:** O pacto é publicado no Pact Broker
- **Passo 4:** O provedor valida contra o contrato (Para entender como o provedor valida o contrato acesse: [ 🔗 Provedor de Exemplo](https://github.com/lucasoliveiralops/contract-tests-provider-example/))


## 🚀 Instalação e Execução

### Pré-requisitos
- Docker
- Docker Compose

### Passo a Passo

```bash
# 1. Clonar o repositório
git clone https://github.com/lucasoliveiralops/contract-tests-consumer-example.git
cd contract-tests-consumer-example

# 2. Iniciar containers
docker compose up -d --build

# 3. Executar testes
docker exec -it ms-user sh -c "./vendor/bin/phpunit"
```

## 🤝 Contribuição

Abra uma issue ou envie um pull request! Este projeto tem como objetivo facilitar a adoção de testes de contrato em PHP. 🚀
