<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Usuario;

class UsuarioPolicy
{
    public function viewAny(User $user): bool
    {
        return (bool) $user->usuario?->is_admin;
    }

    public function view(User $user, Usuario $usuario): bool
    {
        return (bool) $user->usuario?->is_admin;
    }

    public function create(User $user): bool
    {
        return (bool) $user->usuario?->is_admin;
    }

    public function update(User $user, Usuario $usuario): bool
    {
        return (bool) $user->usuario?->is_admin;
    }

    public function delete(User $user, Usuario $usuario): bool
    {
        return (bool) $user->usuario?->is_admin;
    }
}
