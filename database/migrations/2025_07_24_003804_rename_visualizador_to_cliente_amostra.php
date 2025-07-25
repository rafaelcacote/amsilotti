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
        // Atualizar o nome do role de 'visualizador' para 'cliente_amostra'
        \DB::table('roles')->where('name', 'visualizador')->update(['name' => 'cliente_amostra']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverter o nome do role de 'cliente_amostra' para 'visualizador'
        \DB::table('roles')->where('name', 'cliente_amostra')->update(['name' => 'visualizador']);
    }
};
