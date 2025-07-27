# Montink Mini ERP

Mini sistema de e-commerce desenvolvido em Laravel. Possui operações básicas de gerenciamento de produtos, cupons de desconto e fluxo de checkout com carrinho de compras. Utilizado para fins de testes e demonstração.

## Funcionalidades
- CRUD de produtos com variações e controle de estoque
- Cadastro e aplicação de cupons (percentual ou valor fixo)
- Carrinho de compras em sessão
- Processo de checkout com cálculo de frete
- Painel de administração de pedidos
- Webhook para atualização de status

## Tecnologias
- PHP 8.2+ (Laravel 12.x)
- MySQL
- Node/NPM
- Composer
- Docker & Docker Compose (opcional)

## Código e padrão
O projeto adota o padrão [PSR-12](https://www.php-fig.org/psr/psr-12/) e utiliza o [Laravel Pint](https://laravel.com/docs/pint) para verificação automática. Execute `./vendor/bin/pint --test` para conferir a formatação. Na revisão atual existem 40 ocorrências reportadas pelo Pint.

## Pré-requisitos
- PHP 8.2 ou superior
- Composer
- Node e NPM
- (Opcional) Docker e Docker Compose

## Instalação

1. Clone o repositório
```bash
git clone https://github.com/eobrunodiniz/testing-montink.git
cd testing-montink
```

2. Instale as dependências PHP
```bash
cd src
composer install
```

3. Copie `.env.example` para `.env` e ajuste as credenciais
```bash
cp .env.example .env
php artisan key:generate
```

4. Rode as migrações e compile os assets
```bash
php artisan migrate
npm install
npm run dev
```

5. Inicie o servidor
```bash
php artisan serve
```

### Usando Docker

Há um ambiente Docker para desenvolvimento. Após instalar Docker e Compose:
```bash
make build
make up
make composer-install
make npm-install
make artisan-migrate
```
A aplicação ficará disponível em `http://localhost:8085`.

## Testes

Os testes são executados via PHPUnit:
```bash
composer test
```
É necessário configurar o `.env.testing` ou ajustar o `.env` para apontar para um banco de dados de testes e definir `APP_KEY`. Os testes atuais falham sem essa configuração prévia.

## Licença
Distribuído sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.
