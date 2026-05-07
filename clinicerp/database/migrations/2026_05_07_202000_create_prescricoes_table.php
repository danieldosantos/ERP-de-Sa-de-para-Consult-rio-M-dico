<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('prescricoes', function (Blueprint $table) { $table->id(); $table->foreignId('agendamento_id')->constrained()->cascadeOnDelete(); $table->foreignId('medico_id')->constrained()->cascadeOnDelete(); $table->text('medicamentos'); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('prescricoes'); } };
