<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fotosdeimoveis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->nullable()->constrained('imoveis')->onDelete('cascade');
            $table->string('url');
            $table->string('descricao', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fotosdeimoveis');
    }
};