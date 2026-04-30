# ClinicERP

Guia rápido para cadastrar **até 15 usuários diretamente no banco de dados** do projeto.

## Pré-requisitos

- PHP 8.1+
- Composer
- MySQL 8+
- Node.js (opcional para interface)

## 1) Suba o projeto

No diretório `clinicerp/`:

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Configure as credenciais no arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clinicerp
DB_USERNAME=root
DB_PASSWORD=
```

Execute as migrations:

```bash
php artisan migrate
```

---

## 2) Cadastrar usuários direto no banco (limite: 15)

A aplicação usa as tabelas `users` (autenticação) e `usuarios` (dados de negócio).  
Para garantir consistência, insira nas duas tabelas usando o mesmo `user_id`.

### SQL de exemplo (1 usuário)

> Troque os valores (`nome`, `email`, `cpf`, etc.) para cada novo cadastro.

```sql
-- 1) Inserir na tabela de autenticação
INSERT INTO users (name, email, password, created_at, updated_at)
VALUES (
  'João Silva',
  'joao1@clinica.com',
  '$2y$12$abcdefghijklmnopqrstuvABCDEFGHIJKLMNOpqrstuvwxyz123456',
  NOW(),
  NOW()
);

-- 2) Pegar o ID gerado
SET @new_user_id = LAST_INSERT_ID();

-- 3) Inserir na tabela de negócio
INSERT INTO usuarios (
  user_id,
  nome,
  email,
  telefone,
  cpf,
  data_nascimento,
  role,
  created_at,
  updated_at
)
VALUES (
  @new_user_id,
  'João Silva',
  'joao1@clinica.com',
  '(11) 99999-0001',
  '12345678901',
  '1990-01-01',
  'admin',
  NOW(),
  NOW()
);
```

---

## 3) Validar o limite de 15 usuários

Antes de inserir, confira quantos já existem:

```sql
SELECT COUNT(*) AS total_usuarios FROM usuarios;
```

Se o resultado for menor que 15, você pode continuar os cadastros.  
Para listar os cadastrados:

```sql
SELECT id, user_id, nome, email, role, created_at
FROM usuarios
ORDER BY id ASC;
```

---

## 4) Inserção em lote (até completar 15)

Fluxo recomendado:

1. Verificar quantidade atual com `COUNT(*)`.
2. Calcular quantos faltam para 15.
3. Inserir somente a quantidade faltante.
4. Validar novamente com `COUNT(*)`.

---

## 5) Observações importantes

- Use **emails e CPFs únicos** para evitar erros de constraint.
- O campo `password` em `users` deve ser um **hash bcrypt**.
- Se preferir, faça o cadastro pela interface web (`/usuarios/create`) para o Laravel sincronizar os dados automaticamente.

