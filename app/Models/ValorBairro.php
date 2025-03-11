<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorBairro extends Model
{
    use HasFactory;

    protected $table = 'valoresbairros';
    
    protected $fillable = ['bairro_id', 'valor'];

    public function bairro()
    {
        return $this->belongsTo(Bairro::class);
    }
}