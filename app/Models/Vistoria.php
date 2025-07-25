<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Vistoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'agenda_id',
        'num_processo',
        'requerente',
        'requerente_id',
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
        'topografia',
        'formato_terreno',
        'superficie',
        'documentacao',
        'reside_no_imovel',
        'data_ocupacao',
        'tipo_ocupacao',
        'exerce_pacificamente_posse',
        'utiliza_benfeitoria',
        'tipo_construcao',
        'padrao_acabamento',
        'idade_aparente',
        'estado_conservacao',
        'observacoes',
        'croqui',
        'croqui_imagem',
        'acompanhamento_vistoria',
        'cpf_acompanhante',
        'telefone_acompanhante',
        'status'
    ];

    protected $casts = [
        'reside_no_imovel' => 'boolean',
        'exerce_pacificamente_posse' => 'boolean',
        'data_ocupacao' => 'date',
        'limites_confrontacoes' => 'array',
    ];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function requerente()
    {
        return $this->belongsTo(Cliente::class, 'requerente_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotosDeVistoria::class);
    }

    public function membrosEquipeTecnica()
    {
        return $this->belongsToMany(
            MembrosEquipeTecnica::class,
            'vistoria_membro_equipe',
            'vistoria_id',
            'membro_equipe_tecnica_id'
        );
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

    public static function getUtilizaDaBenfeitoriaValues()
    {
        // Como não há uma coluna enum para isto, retornamos valores fixos
        return ['Uso Próprio', 'Alugada', 'Outros'];
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
