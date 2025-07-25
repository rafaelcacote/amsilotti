<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackSistema extends Model
{
    use HasFactory;

    protected $table = 'feedback_sistema';

    protected $fillable = [
        'usuario_id',
        'tipo_feedback',
        'titulo',
        'descricao',
        'status',
        'prioridade',
        'imagem_url',
    ];

    // Relacionamento com usuário
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
