<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('prontuarios', function (Blueprint $table) { $table->id(); $table->foreignId('agendamento_id')->constrained()->cascadeOnDelete(); $table->foreignId('medico_id')->constrained()->cascadeOnDelete(); $table->text('queixa_principal'); $table->text('historico')->nullable(); $table->string('sinais_vitais', 255)->nullable(); $table->text('diagnostico')->nullable(); $table->text('conduta')->nullable(); $table->text('observacoes')->nullable(); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('prontuarios'); } };
