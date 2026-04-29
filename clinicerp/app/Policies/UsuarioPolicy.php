<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Usuario;

class UsuarioPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Usuario $usuario): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Usuario $usuario): bool
    {
        return true;
    }

    public function delete(User $user, Usuario $usuario): bool
    {
        return true;
    }
}
