<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ordens_de_servico', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status');
            $table->foreignId('membro_equipe_tecnicas_id')->nullable()->constrained('membro_equipe_tecnicas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordens_de_servico');
    }
};