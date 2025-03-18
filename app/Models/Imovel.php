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
        'numero',
        'bairro_id',
        'via_especifica_id',
        'latitude',
        'longitude',
        'area_total',
        'valor_estimado',
        'zona_id',
        'tipo',
        'pgm',
        'formato',
        'topografia',
        'posicao_na_quadra',
        'frente',
        'profundidade_equiv',
        'topologia',
        'padrao',
        'area_construida',
        'benfeitoria',
        'descricao_imovel',
        'andar',
        'idade_predio',
        'quatidade_suites',
        'idade_aparente',
        'estado_conservacao',
        'acessibilidade',
        'modalidade',
        'valor_total_imovel',
        'valor_construcao',
        'valor_terreno',
        'fator_oferta',
        'preco_unitario1',
        'preco_unitario2',
        'preco_unitario3',
        'fonte_informacao',
        'contato',
        'link',
    ];

    public function bairro()
    {
        return $this->belongsTo(Bairro::class, 'bairro_id');
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class, 'zona_id');
    }

    public function viaEspecifica()
    {
        return $this->belongsTo(ViaEspecifica::class, 'via_especifica_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotosDeImovel::class, 'imovel_id');
    }



    // Mutators
    public function setValorTotalImovelAttribute($value)
    {
        $this->attributes['valor_total_imovel'] = str_replace(['.', ','], ['', '.'], $value);
    }

    public function setValorConstrucaoAttribute($value)
    {
        $this->attributes['valor_construcao'] = str_replace(['.', ','], ['', '.'], $value);
    }

    public function setValorTerrenoAttribute($value)
    {
        $this->attributes['valor_terreno'] = str_replace(['.', ','], ['', '.'], $value);
    }

    public function setFatorOfertaAttribute($value)
    {
        $this->attributes['fator_oferta'] = str_replace(['.', ','], ['', '.'], $value);
    }

    public function setPrecoUnitario1Attribute($value)
    {
        $this->attributes['preco_unitario1'] = str_replace(['.', ','], ['', '.'], $value);
    }

    public function setPrecoUnitario2Attribute($value)
    {
        $this->attributes['preco_unitario2'] = str_replace(['.', ','], ['', '.'], $value);
    }

    public function setPrecoUnitario3Attribute($value)
    {
        $this->attributes['preco_unitario3'] = str_replace(['.', ','], ['', '.'], $value);
    }

    // Accessors
    public function getValorTotalImovelAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getValorConstrucaoAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getValorTerrenoAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getFatorOfertaAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getPrecoUnitario1Attribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getPrecoUnitario2Attribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getPrecoUnitario3Attribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    // // Mutator para area_total
    // public function setAreaTotalAttribute($value)
    // {
    //     // Remove "m²" e substitui vírgula por ponto
    //     $this->attributes['area_total'] = str_replace([' m²', ','], ['', '.'], $value);
    // }

    // // Mutator para area_construida
    // public function setAreaConstruidaAttribute($value)
    // {
    //     // Remove "m²" e substitui vírgula por ponto
    //     $this->attributes['area_construida'] = str_replace([' m²', ','], ['', '.'], $value);
    // }

    // // Accessor para area_total
    // public function getAreaTotalAttribute($value)
    // {
    //     // Formata o valor para exibir como "123,45 m²"
    //     return number_format($value, 2, ',', '.') . ' m²';
    // }

    // // Accessor para area_construida
    // public function getAreaConstruidaAttribute($value)
    // {
    //     // Formata o valor para exibir como "123,45 m²"
    //     return number_format($value, 2, ',', '.') . ' m²';
    // }
}
