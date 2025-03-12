<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Vistoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_processo',
        'requerente',
        'requerido',
        'nome',
        'cpf',
        'telefone',
        'endereco',
        'num',
        'bairro',
        'cidade',
        'estado',
        'limites_confrontacoes',
        'lado_direito',
        'lado_esquerdo',
        'topografia',
        'formato_terreno',
        'superficie',
        'documentacao',
        'reside_no_imovel',
        'data_ocupacao',
        'tipo_ocupacao',
        'exerce_pacificamente_posse',
        'utiliza_da_benfeitoria',
        'tipo_construcao',
        'padrao_acabamento',
        'idade_aparente',
        'estado_de_conservacao',
        'observacoes',
        'acompanhamento_vistoria',
        'cpf_acompanhante',
        'telefone_acompanhante'
    ];

    protected $casts = [
        'reside_no_imovel' => 'boolean',
        'exerce_pacificamente_posse' => 'boolean',
        'data_ocupacao' => 'date'
    ];

    public function fotos()
    {
        return $this->hasMany(FotosDeVistoria::class);
    }

    public static function getSuperficieValues()
    {
        $columnType = DB::selectOne("SHOW COLUMNS FROM vistorias WHERE Field = 'superficie'")->Type;
        return self::extractEnumValues($columnType);
    }

    public static function getTipoOcupacaoValues()
    {
        $columnType = DB::selectOne("SHOW COLUMNS FROM vistorias WHERE Field = 'tipo_ocupacao'")->Type;
        return self::extractEnumValues($columnType);
    }



    private static function extractEnumValues($columnType)
    {
        preg_match('/^enum\((.*)\)$/', $columnType, $matches);
        $enumValues = [];

        if (isset($matches[1])) {
            foreach (explode(',', $matches[1]) as $value) {
                $enumValues[] = trim($value, "'");
            }
        }

        return $enumValues;
    }
}
