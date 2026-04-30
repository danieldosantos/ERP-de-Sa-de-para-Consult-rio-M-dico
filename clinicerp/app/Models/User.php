<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected static bool $syncingFromUsuario = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saved(function (User $user): void {
            if (static::$syncingFromUsuario) {
                return;
            }

            Usuario::withoutEvents(function () use ($user): void {
                $usuario = $user->usuario ?: new Usuario(['user_id' => $user->id]);

                $usuario->fill([
                    'nome' => $user->name,
                    'email' => $user->email,
                    'ativo' => $usuario->exists ? $usuario->ativo : true,
                    'is_admin' => $usuario->exists ? $usuario->is_admin : false,
                ]);

                $usuario->user()->associate($user);
                $usuario->save();
            });
        });
    }

    public static function syncFromUsuario(Usuario $usuario, ?string $plainPassword = null): self
    {
        static::$syncingFromUsuario = true;

        try {
            $user = $usuario->user ?: new self();
            $user->name = $usuario->nome;
            $user->email = $usuario->email;

            if ($plainPassword !== null && $plainPassword !== '') {
                $user->password = Hash::make($plainPassword);
            }

            if (! $user->exists && empty($user->password)) {
                $user->password = Hash::make('SenhaTemporaria@123');
            }

            $user->save();

            return $user;
        } finally {
            static::$syncingFromUsuario = false;
        }
    }

    public function usuario(): HasOne
    {
        return $this->hasOne(Usuario::class);
    }
}
