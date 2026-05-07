<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Prescricao extends Model { use HasFactory; protected $fillable=['agendamento_id','medico_id','medicamentos']; }
