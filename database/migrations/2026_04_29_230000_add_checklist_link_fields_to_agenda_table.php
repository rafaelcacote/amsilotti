<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('agenda')) {
            return;
        }

        Schema::table('agenda', function (Blueprint $table) {
            if (!Schema::hasColumn('agenda', 'controle_pericia_id')) {
                $table->unsignedBigInteger('controle_pericia_id')->nullable()->after('requerente_id');
                $table->index('controle_pericia_id', 'agenda_controle_pericia_idx');
            }

            if (!Schema::hasColumn('agenda', 'checklist_item_nome')) {
                $table->string('checklist_item_nome', 255)->nullable()->after('controle_pericia_id');
                $table->index('checklist_item_nome', 'agenda_checklist_item_nome_idx');
            }

            if (!Schema::hasColumn('agenda', 'orgao_responsavel')) {
                $table->string('orgao_responsavel', 255)->nullable()->after('checklist_item_nome');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('agenda')) {
            return;
        }

        Schema::table('agenda', function (Blueprint $table) {
            if (Schema::hasColumn('agenda', 'orgao_responsavel')) {
                $table->dropColumn('orgao_responsavel');
            }

            if (Schema::hasColumn('agenda', 'checklist_item_nome')) {
                $table->dropIndex('agenda_checklist_item_nome_idx');
                $table->dropColumn('checklist_item_nome');
            }

            if (Schema::hasColumn('agenda', 'controle_pericia_id')) {
                $table->dropIndex('agenda_controle_pericia_idx');
                $table->dropColumn('controle_pericia_id');
            }
        });
    }
};
