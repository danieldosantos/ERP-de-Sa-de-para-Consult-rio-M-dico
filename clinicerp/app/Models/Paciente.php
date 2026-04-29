<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $fillable = ['nome','cpf','telefone','email','data_nascimento','ativo'];
    protected $casts = ['data_nascimento'=>'date','ativo'=>'boolean'];
}
