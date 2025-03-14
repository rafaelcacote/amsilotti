<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('imoveis', function (Blueprint $table) {
            $table->id();
            $table->string('endereco');
            $table->foreignId('bairro_id')->nullable()->constrained('bairros')->onDelete('set null');
            $table->foreignId('via_especifica_id')->nullable()->constrained('vias_especificas')->onDelete('set null');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('area_total', 10, 2)->nullable();
            $table->decimal('valor_estimado', 15, 2)->nullable();
            $table->timestamp('criado_em')->useCurrent();
            $table->string('Zona', 50)->nullable();
            $table->string('Tipo', 50)->nullable();
            $table->string('PGM', 50)->nullable();
            $table->string('Formato', 50)->nullable();
            $table->string('Topografia', 50)->nullable();
            $table->string('Posicao_Na_Quadra', 50)->nullable();
            $table->decimal('Frente', 10, 2)->nullable();
            $table->decimal('Profundidade_Equiv', 10, 2)->nullable();
            $table->string('Topologia', 50)->nullable();
            $table->string('Padrao', 50)->nullable();
            $table->decimal('Area_Construida', 10, 2)->nullable();
            $table->text('Benfeitoria')->nullable();
            $table->text('Descricao_Imovel')->nullable();
            $table->integer('Idade_Aparente')->nullable();
            $table->string('Estado_Conservacao', 50)->nullable();
            $table->string('Acessibilidade', 50)->nullable();
            $table->string('Modalidade', 50)->nullable();
            $table->decimal('Valor_Total_Imovel', 15, 2)->nullable();
            $table->decimal('Valor_Construcao', 15, 2)->nullable();
            $table->decimal('Valor_Terreno', 15, 2)->nullable();
            $table->decimal('Fator_Oferta', 5, 2)->nullable();
            $table->decimal('Preco_Unitario', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imoveis');
    }
};