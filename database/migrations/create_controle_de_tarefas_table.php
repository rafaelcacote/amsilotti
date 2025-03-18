<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('controle_de_tarefas', function (Blueprint $table) {
            $table->id();
            $table->string('processo');
            $table->string('descricao_atividade');
            $table->string('status');
            $table->string('prioridade');
            $table->foreignId('membro_id')->constrained('membros_equipe_tecnicas');
            $table->date('data_inicio');
            $table->date('prazo');
            $table->date('data_termino')->nullable();
            $table->string('situacao');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('controle_de_tarefas');
    }
};