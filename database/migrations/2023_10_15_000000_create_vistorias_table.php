<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vistorias', function (Blueprint $table) {
            $table->id();
            $table->string('num_processo')->nullable();
            $table->string('requerente')->nullable();
            $table->string('requerido')->nullable();
            $table->string('nome');
            $table->string('cpf')->nullable();
            $table->string('telefone')->nullable();
            $table->string('endereco');
            $table->string('num')->nullable();
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->text('limites_confrontacoes')->nullable();
            $table->string('lado_direito')->nullable();
            $table->string('lado_esquerdo')->nullable();
            $table->string('topografia')->nullable();
            $table->string('formato_terreno')->nullable();
            $table->enum('superficie', ['Seca', 'Brejosa', 'Alagada'])->default('Seca');
            $table->text('documentacao')->nullable();
            $table->boolean('reside_no_imovel')->default(false);
            $table->date('data_ocupacao')->nullable();
            $table->enum('tipo_ocupacao', ['Residencial', 'Comercial', 'Mista'])->default('Residencial');
            $table->boolean('exerce_pacificamente_posse')->default(true);
            $table->enum('utiliza_da_benfeitoria', ['Uso Próprio', 'Alugada', 'Outros'])->default('Uso Próprio');
            $table->string('tipo_construcao')->nullable();
            $table->string('padrao_acabamento')->nullable();
            $table->string('idade_aparente')->nullable();
            $table->string('estado_de_conservacao')->nullable();
            $table->text('observacoes')->nullable();
            $table->string('acompanhamento_vistoria')->nullable();
            $table->string('cpf_acompanhante')->nullable();
            $table->string('telefone_acompanhante')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vistorias');
    }
};
