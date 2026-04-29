# ClinicERP — ERP de Saúde para Consultório Médico

Este repositório contém a base inicial do projeto **ClinicERP**, construída com **Laravel** e autenticação pronta via **Laravel Breeze**.

## ✅ Status atual do projeto (o que já foi feito)

Com base na estrutura atual do código:

- Projeto Laravel criado e funcional.
- Autenticação Breeze instalada (login, registro, recuperação de senha, verificação de e-mail, profile).
- Front-end com Vite/NPM configurado.
- Migrações padrão do Laravel presentes.
- Model, migration e controller de `Usuario` criados (estrutura inicial/crua).
- `DashboardController` criado (ainda não conectado nas rotas).
- Rotas padrão de autenticação e dashboard protegidas por `auth` e `verified`.
- Banco MySQL planejado para `clinicerp` (inclusive com opção em Docker).

---

## 🧱 Stack usada até agora

- **PHP / Laravel**
- **Composer**
- **MySQL**
- **Node.js + NPM**
- **Laravel Breeze** (Blade)
- **Vite**

---

## 📁 Estrutura importante já existente

- `routes/web.php`: rota pública `/`, rota `/dashboard` com middleware `auth` + `verified`, e rotas de profile.
- `routes/auth.php`: fluxo completo de autenticação Breeze.
- `app/Models/Usuario.php`: model criado.
- `app/Http/Controllers/UsuarioController.php`: controller resource criado (métodos ainda vazios).
- `app/Http/Controllers/DashboardController.php`: controller criado.
- `database/migrations/2026_04_29_155924_create_usuarios_table.php`: migration da tabela `usuarios`.

---

## 🚀 Como rodar o projeto local

> Abaixo está o passo a passo consolidado, já alinhado com o que você descreveu.

## 1) Verificar ferramentas instaladas

```bash
php -v
composer -V
mysql --version
git --version
node -v
npm -v
```

## 2) Se faltar PHP / Composer / Node (Windows + winget)

```bash
winget install PHP.PHP
winget install Composer.Composer
winget install OpenJS.NodeJS.LTS
winget install Git.Git
```

Feche e abra o terminal novamente, depois valide:

```bash
php -v
composer -V
node -v
npm -v
```

## 3) Instalação de dependências

Dentro da pasta do projeto:

```bash
composer install
npm install
```

## 4) Configurar ambiente

```bash
copy .env.example .env
php artisan key:generate
```

## 5) Configurar banco no `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clinicerp
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

> Se usar usuário dedicado:

```env
DB_USERNAME=clinictest
DB_PASSWORD=saude123
```

## 6) Rodar migrações

```bash
php artisan migrate
```

## 7) Build de assets

```bash
npm run build
```

Para desenvolvimento contínuo:

```bash
npm run dev
```

## 8) Subir servidor Laravel

```bash
php artisan serve
```

Acessar: http://127.0.0.1:8000

---

## 🐳 Banco MySQL com Docker (já definido)

Se quiser padronizar o banco via container, crie um arquivo `docker-compose.yml` na raiz com:

```yaml
services:
  db:
    image: mysql:8.0
    container_name: mysql_server
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: saude
      MYSQL_DATABASE: clinicerp
      MYSQL_USER: clinictest
      MYSQL_PASSWORD: saude123
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql
    networks:
      - mysql_network

volumes:
  mysql_data:

networks:
  mysql_network:
    driver: bridge
```

Subir o banco:

```bash
docker compose up -d
```

Depois ajuste o `.env` para bater com esse usuário/senha.

---


### Erro comum: `Table 'clinicerp.usuarios' doesn't exist`
Se ao abrir `/usuarios` aparecer esse erro, rode:

```bash
php artisan migrate
```

Se ainda falhar, confirme se o `.env` aponta para o banco correto e execute:

```bash
php artisan config:clear
php artisan migrate
```

## 🛠️ Comandos úteis do dia a dia

```bash
php artisan route:list
php artisan migrate:fresh
php artisan cache:clear
php artisan config:clear
php artisan serve
npm run dev
```

---


## 🎯 Entrega da fase atual (Dias 1 a 3) — concluída

Data de conclusão: **29/04/2026**.

### Escopo entregue
- **Criar projeto Laravel + banco MySQL**
  - Projeto Laravel funcional com configuração de banco via `.env`.
  - Migrações prontas para tabelas padrão e tabela `usuarios`.
- **Estudos aplicados no código**
  - PHP básico aplicado em controllers e models.
  - Laravel aplicado com rotas, controllers, views, migrations e models.
- **Entregas funcionais**
  - Tela de login (Breeze) funcionando.
  - Dashboard inicial com atalhos do módulo.
  - Cadastro de usuários completo (listar, criar, editar e excluir).

### Rotas principais desta fase
- `GET /login`
- `GET /dashboard`
- `GET /usuarios`
- `GET /usuarios/create`
- `PUT /usuarios/{usuario}`
- `DELETE /usuarios/{usuario}`


### Como cadastrar usuário no módulo `usuarios`
1. Faça login em `http://127.0.0.1:8000/login`.
2. Acesse `http://127.0.0.1:8000/usuarios`.
3. Clique no botão **Cadastrar usuário** (ou **+ Novo usuário** no topo).
4. Preencha nome, e-mail, telefone e status, e salve.

> Observação: isso é diferente do `/register` (cadastro da conta de autenticação do Laravel Breeze).


### Regras de cadastro e login (evitar duplicidade)
- O cadastro em `/usuarios/create` agora cria **dois registros sincronizados**:
  1. `users` (autenticação/login)
  2. `usuarios` (dados do módulo de negócio)
- O e-mail é validado como único em **ambas** as tabelas (`users` e `usuarios`).
- Se um e-mail já existir, o sistema bloqueia novo cadastro para evitar registro duplo.
- A senha é definida no cadastro do painel e pode ser alterada na edição do usuário.

## 📌 Próximos passos recomendados

1. Conectar `DashboardController` e `UsuarioController` nas rotas.
2. Implementar CRUD real de `usuarios` (campos, validação, views).
3. Adicionar relacionamento entre usuários do sistema (`users`) e dados de pacientes/usuários de negócio.
4. Criar seeders/factories para dados de teste.
5. Escrever testes de feature para as novas rotas.

---

## Observação

Este README substitui o README padrão do Laravel e documenta o estado atual real do projeto até este momento.
