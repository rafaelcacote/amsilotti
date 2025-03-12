<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('membro_equipe_tecnicas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('telefone')->nullable();
            $table->enum('cargo', ['Assistente Técnica', 'Perita Judicial']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('membro_equipe_tecnicas');
    }
};
