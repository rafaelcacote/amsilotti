<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistDocumentoPericia extends Model
{
    use HasFactory;

    protected $table = 'checklist_documentos_pericias';

    protected $fillable = [
        'controle_pericia_id',
        'item_nome',
        'arquivo_nome',
        'arquivo_caminho',
        'arquivo_mime',
        'arquivo_tamanho',
        'nao_necessario',
        'enviado_por',
    ];

    public function controlePericia()
    {
        return $this->belongsTo(ControlePericia::class, 'controle_pericia_id');
    }

    public function usuarioEnvio()
    {
        return $this->belongsTo(User::class, 'enviado_por');
    }
}
