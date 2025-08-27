<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VigenciaPgm extends Model
{
    protected $table = 'vigencia_pgm';
    protected $fillable = ['descricao', 'data_inicio', 'data_fim', 'ativo'];

    public function valoresPgm()
    {
        return $this->hasMany(ValoresPgm::class, 'vigencia_id');
    }
}
