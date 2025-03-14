<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imovel extends Model
{
    use HasFactory;

    protected $table = 'imoveis';

    protected $fillable = [
        'endereco',
        'bairro_id',
        'via_especifica_id',
        'latitude',
        'longitude',
        'area_total',
        'valor_estimado',
        'Zona',
        'Tipo',
        'PGM',
        'Formato',
        'Topografia',
        'Posicao_Na_Quadra',
        'Frente',
        'Profundidade_Equiv',
        'Topologia',
        'Padrao',
        'Area_Construida',
        'Benfeitoria',
        'Descricao_Imovel',
        'Idade_Aparente',
        'Estado_Conservacao',
        'Acessibilidade',
        'Modalidade',
        'Valor_Total_Imovel',
        'Valor_Construcao',
        'Valor_Terreno',
        'Fator_Oferta',
        'Preco_Unitario'
    ];

    public function bairro()
    {
        return $this->belongsTo(Bairro::class, 'bairro_id');
    }

    public function viaEspecifica()
    {
        return $this->belongsTo(ViaEspecifica::class, 'via_especifica_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotosDeImovel::class, 'imovel_id');
    }
}