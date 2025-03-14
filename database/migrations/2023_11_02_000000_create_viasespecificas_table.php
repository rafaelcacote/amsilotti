<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('viasespecificas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->string('trecho', 255)->nullable();
            $table->decimal('valor', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('viasespecificas');
    }
};