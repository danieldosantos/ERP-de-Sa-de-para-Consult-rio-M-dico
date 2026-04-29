<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Atendente extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'telefone', 'email', 'user_id', 'ativo'];

    protected $casts = ['ativo' => 'boolean'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
