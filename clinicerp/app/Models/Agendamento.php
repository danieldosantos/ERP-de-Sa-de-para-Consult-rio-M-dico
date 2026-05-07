<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agendamento extends Model
{
    use HasFactory;

    public const STATUS_OPCOES = ['agendada', 'confirmada', 'atendida', 'cancelada'];

    protected $fillable = ['data_hora', 'medico_id', 'paciente_id', 'status', 'observacoes'];

    protected $casts = ['data_hora' => 'datetime'];

    public function medico(): BelongsTo { return $this->belongsTo(Medico::class); }

    public function paciente(): BelongsTo { return $this->belongsTo(Paciente::class); }
}
