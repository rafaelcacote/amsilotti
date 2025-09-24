<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlePericia extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'controle_pericias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numero_processo',
        'requerente_id',
        'requerido',
        'vara',
        'tipo_pericia',
        'data_nomeacao',
        'status_atual',
        'data_vistoria',
        'prazo_final',
        'decurso_prazo',
        'valor',
        'responsavel_tecnico_id',
        'cadeia_dominial',
        'protocolo',
        'protocolo_responsavel_id',
        'observacoes'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data_nomeacao' => 'date',
        'data_vistoria' => 'date',
        'prazo_final' => 'date',
        'decurso_prazo' => 'date',
        'valor' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

        public function requerente()
    {
        return $this->belongsTo(Cliente::class, 'requerente_id');
    }

    public function responsavelTecnico()
    {
        return $this->belongsTo(MembrosEquipeTecnica::class, 'responsavel_tecnico_id');
    }


    public function responsavelProtocolo()
    {
        return $this->belongsTo(MembrosEquipeTecnica::class, 'protocolo_responsavel_id');
    }

    /**
     * Scope a query to filter by status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status_atual', $status);
    }

    /**
     * Scope a query to filter by technical responsible.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $responsavelId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeResponsavel($query, $responsavelId)
    {
        return $query->where('responsavel_tecnico_id', $responsavelId);
    }

    /**
     * Get the formatted value attribute.
     *
     * @return string
     */
    public function getValorFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor, 2, ',', '.');
    }

   public static function varasOptions()
{
    return [
        'Assistência Técnica',
        'Vara de Registros Públicos',
        '1ª VFPE',
        '2ª CIMA',
        '2ª VIPE',
        '1ª Cível',
        '2ª Cível',
        '3ª Cível',
        '4ª Cível',
        '5ª Cível',
        '6ª Cível',
        '7ª Cível',
        '8ª Cível',
        '9ª Cível',
        '10ª Cível',
        '11ª Cível',
        '12ª Cível',
        '13ª Cível',
        '14ª Cível',
        '15ª Cível',
        '16ª Cível',
        '17ª Cível',
        '18ª Cível',
        '19ª Cível',
        '20ª Cível',
        '21ª Cível',
        '22ª Cível',
        '23ª Cível',

    ];
}

    public static function statusOptions()
        {
            return [
                'aguardando despacho',
                'aguardando vistoria',
                'aguardando pagamento',
                'aguardando laudo do perito',
                'aguardando quesitos',
                'Aguardando nomeação',
                'em redação',
                'entregue',
                'extinto',
                'transferido projudi',
                'suspenso'
            ];
        }

       public static function tipopericiaOptions()
        {
            return [
                'Justiça Comum',
                '⁠Justiça Gratuita',
                '⁠Assistência Técnica',
                '⁠Particular'
            ];
        }
}
