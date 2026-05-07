<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_hora');
            $table->foreignId('medico_id')->constrained('medicos');
            $table->foreignId('paciente_id')->constrained('pacientes');
            $table->enum('status', ['agendada', 'confirmada', 'atendida', 'cancelada'])->default('agendada');
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
