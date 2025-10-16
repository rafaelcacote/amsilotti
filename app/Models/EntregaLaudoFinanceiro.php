<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaLaudoFinanceiro extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entrega_laudos_financeiro';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'controle_pericias_id',
        'upj',
        'financeiro',
        'protocolo_laudo',
        'valor',
        'sei',
        'empenho',
        'nf',
        'mes_pagamento',
        'ano_pagamento',
        'tipo_pessoa',
        'tipo_pericia',
        'observacao'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'protocolo_laudo' => 'date',
        'valor' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relationship with ControlePericia
     */
    public function controlePericia()
    {
        return $this->belongsTo(ControlePericia::class, 'controle_pericias_id');
    }

    /**
     * Get status options for select
     */
    public static function statusOptions()
    {
        return [
            'Atesto Perícia',
            'Emissão NF - Contador',
            'Liquidado',
            'GABPRES/TJ',
            'Proc. Adm/SEI',
            'SECOFT',
            'SECOP/DVCOP',
            
        ];
    }

    /**
     * Get UPJ options for select
     */
    public static function upjOptions()
    {
        return [
            '1ª UPJ',
            '2ª UPJ',
            '3ª UPJ',
            '4ª UPJ'
        ];
    }

    /**
     * Get financeiro options for select
     */
    public static function financeiroOptions()
    {
        return [
            'Pendente',
            'Adiantamento',
            'Liquidado',
            'Parcialmente',
        ];
    }

    /**
     * Get month payment options for select
     */
    public static function mesPagamentoOptions()
    {
        return [
            'Janeiro',
            'Fevereiro',
            'Março',
            'Abril',
            'Maio',
            'Junho',
            'Julho',
            'Agosto',
            'Setembro',
            'Outubro',
            'Novembro',
            'Dezembro'
        ];
    }

    /**
     * Get vara options for select
     */
    public static function varaOptions()
    {
        return static::whereHas('controlePericia')
            ->join('controle_pericias', 'entrega_laudos_financeiro.controle_pericias_id', '=', 'controle_pericias.id')
            ->whereNotNull('controle_pericias.vara')
            ->distinct()
            ->orderBy('controle_pericias.vara')
            ->pluck('controle_pericias.vara')
            ->filter()
            ->values()
            ->toArray();
    }

    /**
     * Get tipo pessoa options for select
     */
    public static function tipoPessoaOptions()
    {
        return [
            'Física',
            'Jurídica'
        ];
    }

    /**
     * Get tipo pericia options for select
     */
    public static function tipoPericiaOptions()
    {
        return [
            'Particular',
            'Justiça comum',
            'Justiça Gratuita'
        ];
    }

    /**
     * Get formatted value attribute
     */
    public function getValorFormatadoAttribute()
    {
        return $this->valor ? 'R$ ' . number_format($this->valor, 2, ',', '.') : null;
    }

    
}