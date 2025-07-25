<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clientes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'empresa',
        'nome_responsavel',
        'profissao',
        'email',
        'telefone',
        'tipo',
    ];

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

    public function controleDeTarefas()
    {
        return $this->hasMany(ControleDeTarefas::class, 'cliente_id');
    }
}
