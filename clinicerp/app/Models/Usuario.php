<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Usuario extends Model
{
    use HasFactory;

    protected static bool $syncingFromUser = false;

    protected $fillable = [
        'user_id',
        'nome',
        'email',
        'telefone',
        'ativo',
        'is_admin',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'is_admin' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(function (Usuario $usuario): void {
            if (static::$syncingFromUser) {
                return;
            }

            $user = User::syncFromUsuario($usuario);

            if ($usuario->user_id !== $user->id) {
                static::$syncingFromUser = true;

                try {
                    $usuario->user()->associate($user);
                    $usuario->save();
                } finally {
                    static::$syncingFromUser = false;
                }
            }
        });
    }

    public static function syncFromUser(User $user): Usuario
    {
        static::$syncingFromUser = true;

        try {
            $usuario = $user->usuario ?: new self();
            $usuario->fill([
                'nome' => $user->name,
                'email' => $user->email,
                'ativo' => $usuario->exists ? $usuario->ativo : true,
                'is_admin' => $usuario->exists ? $usuario->is_admin : false,
            ]);
            $usuario->user()->associate($user);
            $usuario->save();

            return $usuario;
        } finally {
            static::$syncingFromUser = false;
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
