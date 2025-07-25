<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeEvento extends Model
{
    use HasFactory;

    protected $table = 'tipos_de_evento';

    protected $fillable = [
        'nome',
        'codigo',
        'cor',
        'descricao',
        'ativo',
        'is_padrao'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'is_padrao' => 'boolean'
    ];

    // Relacionamento com agenda
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'tipo', 'codigo');
    }

    // Apenas tipos ativos
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    // Converter para select
    public static function getForSelect()
    {
        return self::ativos()
    ->orderBy('nome')
    ->get(['nome', 'codigo', 'cor'])
    ->mapWithKeys(function ($item) {
        return [$item->codigo => ['nome' => $item->nome, 'cor' => $item->cor]];
    })
    ->toArray();
    }

    // Obter mapeamento de cores por código
    public static function getCoresPorCodigo()
    {
        return self::ativos()
            ->get()
            ->pluck('cor', 'codigo')
            ->toArray();
    }
}
