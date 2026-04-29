<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medico extends Model
{
    use HasFactory;
    protected $fillable = ['nome','crm','email','telefone','especialidade_id','user_id','ativo'];
    protected $casts = ['ativo'=>'boolean'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function especialidade(): BelongsTo { return $this->belongsTo(Especialidade::class); }
}
