<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('medicos', function (Blueprint $table) {
            $table->foreignId('unidade_consultorio_id')->nullable()->after('especialidade_id')->constrained('unidades_consultorios');
        });
    }

    public function down(): void
    {
        Schema::table('medicos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('unidade_consultorio_id');
        });
    }
};
