# Projeto

Este projeto tem como objetivo ilustrar a estrutura de desenvolvimento de uma API utilizando o framework [Laravel](https://laravel.com/docs/7.x). Nele é implementado o conceito de Service Layer e Repository Pattern.

A aplicação desenvolvida é para uma api de cadastro de notas pessoais. O usuário pode se cadastrar usando o cadastro do sistema ou através do seu login no Facebook. Após logado o usuário pode criar notas pessoais e adicionar lembretes para as mesmas.

## Instalação

```sh
# Clonar o projeto
git clone https://github.com/souzaleo97/laravel-example.git

# Acessar a pasta do projeto
cd laravel-example

# Criar .env
cp -v .env.example .env

# Atualizar as informações do .env

# Instalar dependências do Composer
composer install

# Gerar chave para criptografia
php artisan key:generate

# Criar as tabelas no banco de dados
php artisan migrate

# Cache nas configurações
php artisan config:cache

# Cache nas rotas
php artisan route:cache

# Cache nos eventos
php artisan event:clear

# Cron
crontab -e
```

## Rotas

| Método |    Autenticação    |         URI         |
| ------ | :----------------: | :-----------------: |
| GET    |        :x:         | /api/login/facebook |
| POST   |        :x:         |     /api/login      |
| POST   | :heavy_check_mark: |     /api/logout     |
| GET    | :heavy_check_mark: |     /api/users      |
| GET    | :heavy_check_mark: |   /api/users/{ID}   |
| POST   |        :x:         |     /api/users      |
| PUT    | :heavy_check_mark: |   /api/users/{ID}   |
| DELETE | :heavy_check_mark: |   /api/users/{ID}   |
| GET    | :heavy_check_mark: |     /api/notes      |
| GET    | :heavy_check_mark: |   /api/notes/{ID}   |
| POST   | :heavy_check_mark: |     /api/notes      |
| PUT    | :heavy_check_mark: |   /api/notes/{ID}   |
| DELETE | :heavy_check_mark: |   /api/notes/{ID}   |

### Autenticação das Rotas

As rotas autenticadas devem conter o `Bearer token` em seu cabeçalho.
