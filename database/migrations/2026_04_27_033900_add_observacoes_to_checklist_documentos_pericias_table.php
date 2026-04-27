<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('checklist_documentos_pericias', function (Blueprint $table) {
            $table->text('observacoes')->nullable()->after('nao_necessario');
        });
    }

    public function down(): void
    {
        Schema::table('checklist_documentos_pericias', function (Blueprint $table) {
            $table->dropColumn('observacoes');
        });
    }
};
