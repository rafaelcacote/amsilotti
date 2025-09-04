<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'zona_id', 'valor_pgm'];

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function vigenciaPgm()
    {
        return $this->belongsTo(VigenciaPgm::class, 'vigencia_pgm_id');
    }

    public function imoveis()
    {
        return $this->hasMany(Imovel::class, 'bairro_id');
    }

    public function setValorPgmAttribute($value)
    {
        $this->attributes['valor_pgm'] = str_replace(['.', ','], ['', '.'], $value);
    }

    public function getValorPgmAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }
}
