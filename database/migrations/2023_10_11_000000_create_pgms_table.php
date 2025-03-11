<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pgms', function (Blueprint $table) {
            $table->id();
            $table->string('zona');
            $table->string('local');
            $table->string('tipo');
            $table->decimal('valor', 10, 2); // Valor monetário com 2 casas decimais
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pgms');
    }
};
