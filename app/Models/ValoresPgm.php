<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValoresPgm extends Model
{
    protected $table = 'valores_pgm';
    protected $fillable = ['bairro_id', 'vigencia_id', 'valor'];

    public function bairro()
    {
        return $this->belongsTo(Bairro::class);
    }

    public function vigencia()
    {
        return $this->belongsTo(VigenciaPgm::class, 'vigencia_id');
    }
}
