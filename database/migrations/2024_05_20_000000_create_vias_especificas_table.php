<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViasEspecificasTable extends Migration
{
    public function up()
    {
        Schema::create('vias_especificas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('trecho')->nullable();
            $table->decimal('valor', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vias_especificas');
    }
}