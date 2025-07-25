<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotosDeImovel extends Model
{
    use HasFactory;

    protected $table = 'fotos_de_imoveis';

    protected $fillable = [
        'imovel_id',
        'caminho',
        'descricao',
    ];

    public function imovel()
    {
        return $this->belongsTo(Imovel::class, 'imovel_id');
    }
}
