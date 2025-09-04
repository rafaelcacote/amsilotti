<?php
namespace App\Http\Controllers;

use App\Models\Bairro;
use App\Models\VigenciaPgm;
use Illuminate\Http\Request;

class VigenciaController extends Controller
{
    // Retorna o nome da vigência ativa para o bairro
    public function getVigenciaNome($bairro_id)
    {
        $bairro = Bairro::find($bairro_id);
        if (!$bairro) {
            return response()->json(['nome' => null]);
        }
        // Supondo que o bairro tem vigencia_pgm_id
        $vigencia = VigenciaPgm::where('id', $bairro->vigencia_pgm_id)
            ->where('ativo', 1)
            ->first();
        return response()->json(['nome' => $vigencia ? $vigencia->descricao : null]);
    }
}
