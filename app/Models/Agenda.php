<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agenda';

    protected $fillable = [
        'titulo',
        'num_processo',
        'requerido',
        'requerido_id',
        'requerente_id',
        'data',
        'hora',
        'local',
        'endereco',
        'num',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'status',
        'nota',
        'tipo',
    ];

    // Relacionamento com Cliente (requerente)
    public function requerente()
    {
        return $this->belongsTo(Cliente::class, 'requerente_id');
    }

    // Relacionamento com Cliente (requerido, se necessário)
    public function requeridoCliente()
    {
        return $this->belongsTo(Cliente::class, 'requerido_id');
    }
    
    // Relacionamento com o tipo de evento
    public function tipoDeEvento()
    {
        return $this->belongsTo(TipoDeEvento::class, 'tipo', 'codigo');
    }

    // Lista de tipos possíveis - usar banco de dados
    public static function getTipoValues()
    {
        // Verificar se a tabela existe no banco
        try {
            $tipos = TipoDeEvento::getForSelect();
            
            // Se não há tipos no banco, retorna os valores padrão
            if (count($tipos) === 0) {
                return [
                    'vistoria' => 'Vistoria',
                    'entrega_laudo' => 'Entrega de Laudo',
                    'reuniao' => 'Reunião',
                    'visita_tecnica' => 'Visita Técnica',
                    'compromisso_externo' => 'Compromisso Externo',
                ];
            }
            
            return $tipos;
        } catch (\Exception $e) {
            // Fallback para valores padrão se houver erro
            return [
                'vistoria' => 'Vistoria',
                'entrega_laudo' => 'Entrega de Laudo',
                'reuniao' => 'Reunião',
                'visita_tecnica' => 'Visita Técnica',
                'compromisso_externo' => 'Compromisso Externo',
            ];
        }
    }

    // Lista de status possíveis
    public static function getStatusValues()
    {
        return [
            'Agendada' => 'Agendada',
            'Realizada' => 'Realizada',
            'Cancelada' => 'Cancelada',
        ];
    }

    // Helper para exibir nome do tipo
    public function getTipoNomeAttribute()
    {
        if ($this->tipoDeEvento) {
            return $this->tipoDeEvento->nome;
        }
        return self::getTipoValues()[$this->tipo] ?? $this->tipo;
    }

    // Helper para exibir nome do status
    public function getStatusNomeAttribute()
    {
        return self::getStatusValues()[$this->status] ?? $this->status;
    }

    // Lista de cores por tipo - usar banco de dados
    public static function getTipoCores()
    {
        // Verificar se a tabela existe no banco
        try {
            $cores = TipoDeEvento::getCoresPorCodigo();
            
            // Se não há cores no banco, retorna os valores padrão
            if (count($cores) === 0) {
                return [
                    'vistoria' => '#28a745',           // Verde para vistorias
                    'entrega_laudo' => '#17a2b8',      // Azul claro para entrega de laudo
                    'reuniao' => '#ffc107',            // Amarelo para reuniões
                    'visita_tecnica' => '#fd7e14',     // Laranja para visitas técnicas
                    'compromisso_externo' => '#6f42c1', // Roxo para compromissos externos
                ];
            }
            
            return $cores;
        } catch (\Exception $e) {
            // Fallback para valores padrão se houver erro
            return [
                'vistoria' => '#28a745',           // Verde para vistorias
                'entrega_laudo' => '#17a2b8',      // Azul claro para entrega de laudo
                'reuniao' => '#ffc107',            // Amarelo para reuniões
                'visita_tecnica' => '#fd7e14',     // Laranja para visitas técnicas
                'compromisso_externo' => '#6f42c1', // Roxo para compromissos externos
            ];
        }
    }

    // Helper para obter a cor do tipo
    public function getTipoCorAttribute()
    {
        if ($this->tipoDeEvento) {
            return $this->tipoDeEvento->cor;
        }
        return self::getTipoCores()[$this->tipo] ?? '#007bff';
    }
}
