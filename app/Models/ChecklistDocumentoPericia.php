<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistDocumentoPericia extends Model
{
    use HasFactory;

    /**
     * Item virtual da aba «Última Decisão» no editar perícia.
     * Não entra nos templates por tipo — armazena só nesta linha checklist.
     */
    public const ITEM_NOME_ULTIMA_DECISAO = '__ultima_decisao__';

    protected $table = 'checklist_documentos_pericias';

    protected $fillable = [
        'controle_pericia_id',
        'item_nome',
        'arquivo_nome',
        'arquivo_caminho',
        'arquivo_mime',
        'arquivo_tamanho',
        'nao_necessario',
        'observacoes',
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

    public static function isUltimaDecisaoItem(?string $itemNome): bool
    {
        return $itemNome !== null && trim($itemNome) === self::ITEM_NOME_ULTIMA_DECISAO;
    }
}
