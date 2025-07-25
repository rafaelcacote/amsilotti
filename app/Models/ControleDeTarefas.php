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
        'tipo_atividade',
        'status',
        'prioridade',
        'membro_id',
        'cliente_id',
        'data_inicio',
        'prazo',
        'data_termino',
        'situacao'

    ];

    protected $dates = ['data_inicio', 'data_termino'];

    public function membroEquipe()
    {
        return $this->belongsTo(MembrosEquipeTecnica::class, 'membro_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
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

    public static function getStatusValues()
    {
        // Corrigindo o uso de DB::raw
        $columnType = DB::selectOne("SHOW COLUMNS FROM controle_de_tarefas WHERE Field = 'status'")->Type;

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

    public static function tipoatividadeOptions()
    {
        return [
            'Aceite Pericial',
            'Documentos Confrontantes',
            'Emitir RRT',
            'Esclarecimento',
            'Fórmulario de vistoria',
            'Laudo Pericial',
            'Manifestação',
            'Memorial Descritivo',
            'Pedido de Alvara',
            'Pedido de Expedição de alvará',
            'Pesquisa de Mercado',
            'Planta Georreferenciada',
            'Projeto de Arquitetura',
            'Projeto Executivo',
            'Projetos Complementares',
            'Relatório Fotográfico',
            'Serviços ADM',
            'Solicitação Cartório',
            'Solicitação Externa',
            'Vistoria',
        ];
    }

        public static function situacaoOptions()
    {
        return [
            'Aguardando retorno do cliente',
            'Aguardando Cartório',
            'Aguardando SECT',
            'Aguardando SEHAB',
            'Aguardando despacho',
            'Entregue no e-SAJ',
            'Pendente documentação',
            'Em elaboração',
            'Pesquisa de Mercado',
        ];
    }

}
