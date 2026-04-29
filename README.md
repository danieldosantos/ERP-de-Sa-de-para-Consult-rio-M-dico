# ClinicERP

Sistema ERP para gestão de consultórios médicos, desenvolvido com **Laravel + MySQL + Blade (Breeze)**.

## ✅ Estado atual do projeto

Atualmente o projeto já possui:
- Autenticação completa com Laravel Breeze (login, registro, recuperação de senha e perfil).
- Dashboard protegido por autenticação.
- Módulo de **Usuários** com CRUD completo.
- Sincronização entre tabela de autenticação (`users`) e tabela de negócio (`usuarios`).
- Interface base com Tailwind/Vite.

---

## 🗂️ Principais arquivos criados/modificados (entrega atual)

> Este resumo foi feito para documentar os arquivos mais importantes da fase atual.

### Rotas
- `clinicerp/routes/web.php`
  - Define página inicial, dashboard autenticado, perfil e rotas do CRUD de usuários.
- `clinicerp/routes/auth.php`
  - Rotas padrão de autenticação do Breeze.

### Controllers
- `clinicerp/app/Http/Controllers/UsuarioController.php`
  - Regras do CRUD de usuários (listar, criar, editar, atualizar, excluir).
  - Validação dos campos e sincronização de dados com `users`.
- `clinicerp/app/Http/Controllers/DashboardController.php`
  - Controlador da tela de dashboard.

### Models
- `clinicerp/app/Models/Usuario.php`
  - Model da tabela `usuarios`.
- `clinicerp/app/Models/User.php`
  - Model de autenticação padrão do Laravel (login do sistema).

### Migrations
- `clinicerp/database/migrations/2026_04_29_155924_create_usuarios_table.php`
  - Cria a tabela `usuarios`.
- `clinicerp/database/migrations/2026_04_29_190000_add_user_id_to_usuarios_table.php`
  - Relaciona `usuarios` com `users` por `user_id`.

### Views (módulo Usuários)
- `clinicerp/resources/views/usuarios/index.blade.php`
  - Listagem de usuários.
- `clinicerp/resources/views/usuarios/create.blade.php`
  - Tela de cadastro de usuário.
- `clinicerp/resources/views/usuarios/edit.blade.php`
  - Tela de edição de usuário.
- `clinicerp/resources/views/usuarios/_form.blade.php`
  - Formulário compartilhado entre criação e edição.

### Views (base do sistema)
- `clinicerp/resources/views/dashboard.blade.php`
  - Tela inicial após login.
- `clinicerp/resources/views/layouts/app.blade.php`
  - Layout principal autenticado.
- `clinicerp/resources/views/layouts/navigation.blade.php`
  - Navegação principal do sistema.

---

## 🚀 Como executar localmente

No diretório `clinicerp/`:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Configure o banco no `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clinicerp
DB_USERNAME=root
DB_PASSWORD=
```

Depois rode:

```bash
php artisan migrate
npm run build
php artisan serve
```

Para desenvolvimento front-end:

```bash
npm run dev
```

---

## 🧪 Comandos úteis

```bash
php artisan route:list
php artisan migrate
php artisan config:clear
php artisan cache:clear
```

---

## 📌 Próximos módulos planejados

- Pacientes
- Médicos
- Agenda de consultas
- Prontuário
- Prescrições
- Financeiro
- Relatórios

---

## 📝 Observação

Este README foi atualizado para refletir os **principais arquivos da fase atual já entregue** e facilitar continuidade do projeto.
