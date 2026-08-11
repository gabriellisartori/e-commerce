# Pizzaria e-commerce

Sistema web de e-commerce para pizzaria, desenvolvido como atividade da disciplina de **Projeto Integrador II**, com o objetivo de desenvolver um sistema web para um **stakeholder real: um dono de pizzaria**. O projeto foi desenvolvido em conjunto com a **Taís A. Pritsch**.

O sistema atende dois públicos:

- **Cliente**: navega pelo cardápio, escolhe pizzas inteiras ou meia a meia, adiciona ingredientes adicionais, monta o carrinho e realiza pedidos.
- **Estabelecimento (dono da pizzaria)**: administra o cardápio, categorias, ingredientes, promoções, horário de funcionamento, limite diário de vendas e acompanha os pedidos recebidos.

## Stack de tecnologia

- **Backend**: PHP 8.1+ / Laravel 10, autenticação via Laravel Sanctum, exportação de dados em CSV/Excel (Maatwebsite), envio de e-mails.
- **Frontend**: Vue 3 (Options API), Vue Router, Vuetify 3, Element Plus, Axios, Vuelidate (validação de formulários), vue3-toastify e SweetAlert2 (feedback ao usuário), SCSS.
- **Banco de dados**: MySQL (migrations no Laravel).

## Funcionalidades

### Área do cliente

- **Cadastro e login** de clientes (com autenticação por token via Sanctum).
- **Cardápio**: listagem de produtos e pizzas em promoção.
- **Montagem do pedido**: escolha entre pizza inteira ou **meia a meia** (metades de sabores diferentes), com controle de valor pelo sabor mais caro.
- **Adicionais**: seleção de ingredientes adicionais por pizza (com modal de detalhes).
- **Carrinho de compras**: persistido em `localStorage`, com controle de quantidade e valores.
- **Realização de pedidos** com observação, valor total e notificação por e-mail ao estabelecimento.
- **Consulta de pedidos próprios** ("meus pedidos").
- Páginas institucionais: **Sobre nós** e **Contato**.

### Área do estabelecimento

- **Cadastro e gerenciamento do estabelecimento**: dados básicos, endereço e informações do "sobre nós".
- **Categorias**: CRUD de categorias do cardápio.
- **Ingredientes**: CRUD de ingredientes disponíveis, com exportação de arquivo.
- **Produtos (cardápio)**: CRUD de produtos com imagem, valor, ativação, ingredientes, adicionais e promoções, com exportação de arquivo.
- **Promoções**: CRUD de promoções, inclusive pizzas em promoção destacadas no cardápio.
- **Horário de funcionamento**: definição dos horários de atendimento.
- **Limite diário de pizzas**: configuração de um limite de vendas por dia; ao atingir o limite, novos pedidos são bloqueados.
- **Pedidos**: listagem com filtro por período, detalhamento e atualização de status de pagamento, com exportação em CSV.
- **Perfil**: edição de dados do usuário.

### Destaques técnicos

- API REST com autenticação por token (Sanctum) e middleware para verificar se o usuário é dono do estabelecimento (`verify.establishment.user`).
- Validação de dados nas requisições com Form Requests e resources para padronização das respostas da API.
- Envio de e-mail automático ao dono da pizzaria quando um novo pedido é realizado.
- Exportação de relatórios (pedidos, ingredientes, produtos e promoções) em arquivos CSV/Excel.
- Cartão do pedido com controle de estoque por limite diário de vendas.

## Estrutura do projeto

```
e-commerce/
├── backend/          # API Laravel 10 (PHP)
│   ├── app/
│   │   ├── Http/Controllers/   # Controllers da API
│   │   ├── Http/Requests/      # Validação das requisições
│   │   ├── Http/Resources/     # Formatação das respostas
│   │   ├── Models/             # Models Eloquent
│   │   ├── Services/           # Regras de negócio (pedidos, etc.)
│   │   └── Mail/               # E-mails transacionais
│   ├── database/
│   │   ├── migrations/         # Schema do banco de dados
│   │   └── seeders/            # Dados iniciais
│   ├── routes/api.php          # Rotas da API
│   └── .env.example            # Configurações de ambiente
└── frontend/         # SPA Vue 3
    └── src/
        ├── pages/              # Páginas (cliente e estabelecimento)
        ├── components/         # Componentes reutilizáveis e modais
        ├── router/             # Rotas da aplicação
        ├── store/              # Validações compartilhadas
        └── assets/             # Estilos (SCSS), fontes e imagens
```

## Como executar

### Backend (API)

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
# configure o banco de dados no .env e execute:
php artisan migrate --seed
php artisan serve
```

### Frontend (SPA)

```bash
cd frontend
npm install
npm run serve
```

Acesse a aplicação no endereço indicado pelo Vue CLI (por padrão `http://localhost:8080`).

## Autores

- Gabrielli Sartori
- Taís A. Pritsch
