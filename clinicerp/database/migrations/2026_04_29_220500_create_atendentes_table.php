<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('atendentes', function (Blueprint $t) { $t->id(); $t->string('nome',120); $t->string('telefone',20)->nullable(); $t->string('email',150)->nullable(); $t->foreignId('user_id')->unique()->constrained()->cascadeOnDelete(); $t->boolean('ativo')->default(true); $t->timestamps(); }); } public function down(): void { Schema::dropIfExists('atendentes'); } };
