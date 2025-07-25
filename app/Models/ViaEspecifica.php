<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViaEspecifica extends Model
{
    protected $table = 'vias_especificas';

    protected $fillable = [
        'nome',
        'trecho',
        'valor'
    ];

    public function imoveis()
    {
        return $this->hasMany(Imovel::class, 'via_especifica_id');
    }

    public function setValorAttribute($value)
    {
        $this->attributes['valor'] = str_replace(['.', ','], ['', '.'], $value);
    }

    public function getValorAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }
}
