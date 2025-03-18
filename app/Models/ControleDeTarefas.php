<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ControleDeTarefas extends Model
{
    use HasFactory;

    protected $fillable = [
        'processo',
        'descricao_atividade',
        'status',
        'prioridade',
        'membro_id',
        'data_inicio',
        'prazo',
        'data_termino',
        'situacao'
    ];

    protected $casts = [
        'data_inicio' => 'date', // Apenas data (Y-m-d)
        'data_termino' => 'date', // Apenas data (Y-m-d)
    ];

    public function membroEquipe()
    {
        return $this->belongsTo(MembrosEquipeTecnica::class, 'membro_id');
    }

    public static function getPrioridadeValues()
    {
        // Corrigindo o uso de DB::raw
        $columnType = DB::selectOne("SHOW COLUMNS FROM controle_de_tarefas WHERE Field = 'prioridade'")->Type;

        // Extraindo os valores do ENUM
        preg_match('/^enum\((.*)\)$/', $columnType, $matches);
        $enumValues = [];

        if (isset($matches[1])) {
            foreach (explode(',', $matches[1]) as $value) {
                $enumValues[] = trim($value, "'");
            }
        }

        return $enumValues;
    }

    public static function getSituacaoValues()
    {
        // Corrigindo o uso de DB::raw
        $columnType = DB::selectOne("SHOW COLUMNS FROM controle_de_tarefas WHERE Field = 'situacao'")->Type;

        // Extraindo os valores do ENUM
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
