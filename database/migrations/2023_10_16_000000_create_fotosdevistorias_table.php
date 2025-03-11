<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fotosdevistorias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vistoria_id')->constrained()->onDelete('cascade');
            $table->string('url');
            $table->string('descricao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fotosdevistorias');
    }
};