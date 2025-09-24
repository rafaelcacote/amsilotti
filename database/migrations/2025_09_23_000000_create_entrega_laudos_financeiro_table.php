<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entrega_laudos_financeiro', function (Blueprint $table) {
            $table->id();
            $table->string('status', 100)->nullable();
            $table->unsignedBigInteger('controle_pericias_id');
            $table->string('upj', 20)->nullable();
            $table->string('financeiro', 50)->nullable();
            $table->date('protocolo_laudo')->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->string('sei', 50)->nullable();
            $table->text('empenho')->nullable();
            $table->string('nf', 50)->nullable();
            $table->string('mes_pagamento', 50)->nullable();
            $table->timestamps();

            $table->foreign('controle_pericias_id')->references('id')->on('controle_pericias')->onDelete('cascade');
            $table->index('controle_pericias_id');
            $table->index('status');
            $table->index('mes_pagamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrega_laudos_financeiro');
    }
};