<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('checklist_documentos_pericias', function (Blueprint $table) {
            $table->id();
            $table->integer('controle_pericia_id');
            $table->string('item_nome');
            $table->string('arquivo_nome');
            $table->string('arquivo_caminho');
            $table->string('arquivo_mime')->nullable();
            $table->unsignedBigInteger('arquivo_tamanho')->nullable();
            $table->foreignId('enviado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['controle_pericia_id', 'item_nome'], 'checklist_pericia_item_unique');
            $table->foreign('controle_pericia_id')
                ->references('id')
                ->on('controle_pericias')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checklist_documentos_pericias');
    }
};
