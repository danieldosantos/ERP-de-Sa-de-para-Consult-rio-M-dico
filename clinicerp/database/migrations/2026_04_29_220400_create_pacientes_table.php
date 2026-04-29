<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('pacientes', function (Blueprint $t) { $t->id(); $t->string('nome',120); $t->string('cpf',20)->nullable()->unique(); $t->string('telefone',20)->nullable(); $t->string('email',150)->nullable(); $t->date('data_nascimento')->nullable(); $t->boolean('ativo')->default(true); $t->timestamps(); }); } public function down(): void { Schema::dropIfExists('pacientes'); } };
