<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class OrdemDeServico extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'descricao', 'membro_id', 'status'];

    public function membroEquipeTecnica()
    {
        return $this->belongsTo(MembrosEquipeTecnica::class, 'membro_id');
    }

    public static function getStatusValues()
    {
        // Corrigindo o uso de DB::raw
        $columnType = DB::selectOne("SHOW COLUMNS FROM ordem_de_servicos WHERE Field = 'status'")->Type;

        // Extraindo os valores do ENUM
        preg_match('/^enum\((.*)\)$/', $columnType, $matches);
        $enumValues = [];

        if (isset($matches[1])) {
            foreach (explode(',', $matches[1]) as $value) {
                $enumValues[] = trim($value, "'");
            }
        }

        return $enumValues;
    }
}
