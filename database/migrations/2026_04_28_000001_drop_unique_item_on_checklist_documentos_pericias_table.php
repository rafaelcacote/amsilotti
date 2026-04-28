<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('checklist_documentos_pericias', function (Blueprint $table) {
            // FK em controle_pericia_id usa um índice; o UNIQUE composto atendia isso.
            $table->index('controle_pericia_id', 'checklist_documentos_controle_pericia_id_index');
        });
        Schema::table('checklist_documentos_pericias', function (Blueprint $table) {
            $table->dropUnique('checklist_pericia_item_unique');
        });
    }

    public function down(): void
    {
        Schema::table('checklist_documentos_pericias', function (Blueprint $table) {
            $table->unique(['controle_pericia_id', 'item_nome'], 'checklist_pericia_item_unique');
        });
        Schema::table('checklist_documentos_pericias', function (Blueprint $table) {
            $table->dropIndex('checklist_documentos_controle_pericia_id_index');
        });
    }
};
