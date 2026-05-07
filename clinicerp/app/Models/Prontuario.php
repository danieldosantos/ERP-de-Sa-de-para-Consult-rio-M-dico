<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Prontuario extends Model { use HasFactory; protected $fillable=['agendamento_id','medico_id','queixa_principal','historico','sinais_vitais','diagnostico','conduta','observacoes']; }
