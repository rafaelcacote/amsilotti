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
        Schema::create('carrinho', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('amostra_id');
            $table->integer('quantidade')->default(1);
            $table->timestamp('adicionado_em')->useCurrent();
            
            // Índices para melhor performance
            $table->index(['usuario_id']);
            $table->index(['amostra_id']);
            $table->unique(['usuario_id', 'amostra_id']); // Evita duplicatas
            
            // Chaves estrangeiras
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('amostra_id')->references('id')->on('imoveis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrinho');
    }
};
