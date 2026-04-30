<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ControlePericia extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'controle_pericias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numero_processo',
        'requerente_id',
        'requerido',
        'vara',
        'tipo_pericia',
        'data_nomeacao',
        'status_atual',
        'data_vistoria',
        'prazo_final',
        'decurso_prazo',
        'valor',
        'responsavel_tecnico_id',
        'cadeia_dominial',
        'protocolo',
        'protocolo_responsavel_id',
        'observacoes'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data_nomeacao' => 'date',
        'data_vistoria' => 'date',
        'prazo_final' => 'date',
        'decurso_prazo' => 'date',
        'valor' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

        public function requerente()
    {
        return $this->belongsTo(Cliente::class, 'requerente_id');
    }

    public function responsavelTecnico()
    {
        return $this->belongsTo(MembrosEquipeTecnica::class, 'responsavel_tecnico_id');
    }


    public function responsavelProtocolo()
    {
        return $this->belongsTo(MembrosEquipeTecnica::class, 'protocolo_responsavel_id');
    }

    public function entregaLaudoFinanceiro()
    {
        return $this->hasOne(EntregaLaudoFinanceiro::class, 'controle_pericias_id');
    }

    public function checklistDocumentos()
    {
        return $this->hasMany(ChecklistDocumentoPericia::class, 'controle_pericia_id');
    }

    /**
     * Scope a query to filter by status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status_atual', $status);
    }

    /**
     * Scope a query to filter by technical responsible.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $responsavelId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeResponsavel($query, $responsavelId)
    {
        return $query->where('responsavel_tecnico_id', $responsavelId);
    }

    /**
     * Get the formatted value attribute.
     *
     * @return string
     */
    public function getValorFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor, 2, ',', '.');
    }

   public static function varasOptions()
{
    return [
        'Assistência Técnica',
        'Vara de Registros Públicos',
        '1ª VFP',
        '2ª CIMA',
        '2ª VFP',
        '4ª VFP',
        '1ª Cível',
        '2ª Cível',
        '3ª Cível',
        '4ª Cível',
        '5ª Cível',
        '6ª Cível',
        '7ª Cível',
        '8ª Cível',
        '9ª Cível',
        '10ª Cível',
        '11ª Cível',
        '12ª Cível',
        '13ª Cível',
        '14ª Cível',
        '15ª Cível',
        '16ª Cível',
        '17ª Cível',
        '18ª Cível',
        '19ª Cível',
        '20ª Cível',
        '21ª Cível',
        '22ª Cível',
        '23ª Cível',

    ];
}

    public static function statusOptions()
        {
            return [
                'Aguardando despacho',
                'Aguardando vistoria',
                'Aguardando pagamento',
                'Aguardando laudo do perito',
                'Aguardando quesitos',
                'Aguardando nomeação',
                'Em redação',
                'Entregue',
                'Extinto',
                'Transferido projudi',
                'Transitado em julgado',
                'Suspenso'
            ];
        }


    /**
     * Get status color mapping
     */
    public static function statusColors()
    {
        return [
            'aguardando despacho' => ['class' => 'bg-warning text-dark', 'color' => '#ffc107'],
            'aguardando vistoria' => ['class' => 'bg-info text-white', 'color' => '#0dcaf0'],
            'aguardando pagamento' => ['class' => 'bg-warning text-dark', 'color' => '#ffc107'],
            'aguardando laudo do perito' => ['class' => 'bg-secondary text-white', 'color' => '#6c757d'],
            'aguardando quesitos' => ['class' => 'bg-secondary text-white', 'color' => '#6c757d'],
            'aguardando nomeação' => ['class' => 'bg-primary text-white', 'color' => '#0d6efd'],
            'em redação' => ['class' => 'bg-primary text-white', 'color' => '#0d6efd'],
            'entregue' => ['class' => 'bg-success text-white', 'color' => '#198754'],
            'extinto' => ['class' => 'bg-danger text-white', 'color' => '#dc3545'],
            'transferido projudi' => ['class' => 'bg-dark text-white', 'color' => '#212529'],
            'suspenso' => ['class' => 'bg-warning text-dark', 'color' => '#ffc107']
        ];
    }

    /**
     * Get color class for a specific status
     */
    public static function getStatusColor($status)
    {
        $colors = self::statusColors();
        return $colors[strtolower($status)] ?? ['class' => 'bg-light text-dark', 'color' => '#f8f9fa'];
    }

       public static function tipopericiaOptions()
        {
            return [
                'Justiça Comum',
                '⁠Justiça Gratuita',
                '⁠Assistência Técnica',
                '⁠Particular'
            ];
        }

    public static function checklistTemplates(): array
    {
        return [
            'justica_gratuita' => [
                'Aceite Pericial',
                'Contato com as Partes',
                'Reunião com as Partes',
                'Diligência Pericial',
                'Coleta de Documentos',
                'Relatório Fotográfico',
                'Formulário de Vistoria',
                'Planta Georreferenciada',
                'Memorial Descritivo',
                'Laudo Pericial',
                'Documentos dos Confrontantes',
                'Localização do Imóvel',
                'Solicitação IMPLURB',
                'Solicitação SECT',
                'Solicitação Juiz',
                'Resposta aos Quesitos',
                'Emissão RRT',
                'Protocolo do Laudo Pericial',
                'Expedição do Alvará de Pagamento dos Honorários',
                'Nota de Empenho',
                'Solicitação da Nota Fiscal',
                'Envio da Nota Fiscal',
                'Esclarecimento',
                'Manifestação',
            ],
            'justica_comum' => [
                'Aceite Pericial',
                'Proposta de Honorários',
                'Contato com as Partes',
                'Reunião com as Partes',
                'Diligência Pericial',
                'Coleta de Documentos',
                'Relatório Fotográfico',
                'Formulário de Vistoria',
                'Solicitação de Sobrevoo de Drone',
                'Sobrevoo de Drone',
                'Solicitação Cartório',
                'Solicitação Externa',
                'Solicitação IMPLURB',
                'Solicitação SECT',
                'Solicitação Juiz',
                'Pesquisa de Mercado',
                'Cadeia Dominial',
                'Planta Georreferenciada',
                'Memorial Descritivo',
                'Laudo Pericial',
                'Laudo de Avaliação',
                'Documentos dos Confrontantes',
                'Localização do Imóvel',
                'Resposta aos Quesitos',
                'Emissão RRT',
                'Protocolo do Laudo',
                'Expedição do Alvará de Pagamento dos Honorários',
                'Nota de Empenho',
                'Solicitação da Nota Fiscal',
                'Envio da Nota Fiscal',
                'Esclarecimento',
                'Manifestação',
            ],
            'assistencia_tecnica' => [
                'Proposta de Honorários',
                'Reunião com as Partes',
                'Elaboração de Quesitos',
                'Diligência Pericial',
                'Coleta de Documentos',
                'Relatório Fotográfico',
                'Solicitação Cartório',
                'Solicitação Externa',
                'Solicitação IMPLURB',
                'Solicitação SECT',
                'Solicitação Juiz',
                'Pesquisa de Mercado',
                'Cadeia Dominial',
                'Laudo Pericial',
                'Laudo de Avaliação',
                'Esclarecimento',
                'Manifestação',
            ],
            'particular' => [
                'Proposta de Honorários',
                'Reunião com o Solicitante',
                'Diligência Pericial',
                'Coleta de Documentos',
                'Relatório Fotográfico',
                'Planta de Arquitetura',
                'Projeto Executivo',
                'Projetos Complementares',
                'Planta Georreferenciada',
                'Memorial Descritivo',
                'Pesquisa de Mercado',
                'Cadeia Dominial',
                'Laudo Pericial',
                'Laudo de Avaliação',
                'Solicitação de Sobrevoo de Drone',
                'Sobrevoo de Drone',
                'Solicitação Cartório',
                'Solicitação Externa',
                'Solicitação IMPLURB',
                'Solicitação SECT',
                'Solicitação Juiz',
                'Documentos dos Confrontantes',
                'Localização do Imóvel',
                'Emissão RRT',
                'Solicitação da Nota Fiscal',
            ],
        ];
    }

    public static function checklistItemsByTipo(?string $tipoPericia): array
    {
        if (!$tipoPericia) {
            return [];
        }

        $normalized = Str::of($tipoPericia)
            ->ascii()
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/', '_')
            ->trim('_')
            ->toString();

        if (str_contains($normalized, 'gratuita')) {
            return self::checklistTemplates()['justica_gratuita'];
        }

        if (str_contains($normalized, 'comum')) {
            return self::checklistTemplates()['justica_comum'];
        }

        if (str_contains($normalized, 'assistencia')) {
            return self::checklistTemplates()['assistencia_tecnica'];
        }

        if (str_contains($normalized, 'particular')) {
            return self::checklistTemplates()['particular'];
        }

        return [];
    }
}
