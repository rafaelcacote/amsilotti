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
        'fator_fundamentacao',
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
        'quantidade_suites',
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
        'mobiliado',
        'banheiros',
        'gerador',
        'vagas_garagem',
        'area_lazer',
    'preco_venda_amostra',
    'transacao',
    'tipologia',
    'marina'
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

        public function imagens()
    {
        return $this->hasMany(FotosDeImovel::class, 'imovel_id');
    }


}
