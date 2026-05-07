<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ExameSolicitado extends Model { use HasFactory; protected $table='exames_solicitados'; protected $fillable=['agendamento_id','medico_id','paciente_id','exame_id','numero_pedido','agendado_para','status','hl7_ack']; }
