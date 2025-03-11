<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'zona_id'];

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function valoresBairro()
    {
        return $this->hasMany(ValorBairro::class);
    }

    // Get the latest value for this neighborhood
    public function valorAtual()
    {
        return $this->hasOne(ValorBairro::class)->latest();
    }
}