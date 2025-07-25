<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembrosEquipeTecnica extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'telefone',
        'cargo',
        'user_id',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Mutator: Formata o telefone antes de salvar no banco de dados
    public function setTelefoneAttribute($value)
    {
        // Remove todos os caracteres não numéricos
        $this->attributes['telefone'] = preg_replace('/[^0-9]/', '', $value);
    }

    // Accessor: Formata o telefone ao recuperar do banco de dados
    public function getTelefoneAttribute($value)
    {
        // Aplica a máscara (92) 99999-9999
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $value);
    }
}
