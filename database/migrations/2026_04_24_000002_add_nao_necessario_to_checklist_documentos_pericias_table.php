<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('checklist_documentos_pericias', function (Blueprint $table) {
            $table->string('arquivo_nome')->nullable()->change();
            $table->string('arquivo_caminho')->nullable()->change();
            $table->boolean('nao_necessario')->default(false)->after('arquivo_tamanho');
        });
    }

    public function down(): void
    {
        Schema::table('checklist_documentos_pericias', function (Blueprint $table) {
            $table->dropColumn('nao_necessario');
            $table->string('arquivo_nome')->nullable(false)->change();
            $table->string('arquivo_caminho')->nullable(false)->change();
        });
    }
};
