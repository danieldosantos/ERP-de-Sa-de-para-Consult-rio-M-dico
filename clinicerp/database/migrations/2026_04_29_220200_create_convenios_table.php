<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('convenios', function (Blueprint $t) { $t->id(); $t->string('nome',120)->unique(); $t->string('cnpj',30)->nullable(); $t->string('telefone',20)->nullable(); $t->boolean('ativo')->default(true); $t->timestamps(); }); } public function down(): void { Schema::dropIfExists('convenios'); } };
