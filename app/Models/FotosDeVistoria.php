<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotosDeVistoria extends Model
{
    use HasFactory;
    
    protected $table = 'fotosdevistorias';
    
    protected $fillable = ['vistoria_id', 'url', 'descricao'];
    
    public function vistoria()
    {
        return $this->belongsTo(Vistoria::class);
    }
}