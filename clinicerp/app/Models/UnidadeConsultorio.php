<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadeConsultorio extends Model
{
    use HasFactory;
    protected $table = 'unidades_consultorios';
    protected $fillable = ['nome','endereco','telefone','ativo'];
    protected $casts = ['ativo'=>'boolean'];
}
