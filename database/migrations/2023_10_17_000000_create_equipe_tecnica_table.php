<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('equipe_tecnica', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('telefone');
            $table->string('cargo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipe_tecnica');
    }
};
