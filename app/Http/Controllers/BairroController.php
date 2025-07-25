<?php

namespace App\Http\Controllers;

use App\Models\Bairro;
use App\Models\Zona;
use App\Models\ValorBairro;
use Illuminate\Http\Request;

class BairroController extends Controller
{
    public function index(Request $request)
    {
        $zonas = Zona::orderBy('nome')->get();

        $bairros = Bairro::with('zona')
            ->when($request->zona_id, function ($query) use ($request) {
                return $query->where('zona_id', $request->zona_id);
            })
            ->orderBy('nome')
            ->paginate(10);

        return view('bairros.index', compact('bairros', 'zonas'));
    }

    public function create()
    {
        $zonas = Zona::orderBy('nome')->get();
        return view('bairros.create', compact('zonas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'zona_id' => 'required|exists:zonas,id'
        ]);

        Bairro::create($request->all());

        return redirect()->route('bairros.index')
            ->with('success', 'Bairro criado com sucesso!');
    }

    public function show(Bairro $bairro)
    {
        $bairro->load(['zona' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('bairros.show', compact('bairro'));
    }

    public function edit(Bairro $bairro)
    {
        $zonas = Zona::orderBy('nome')->get();
        return view('bairros.edit', compact('bairro', 'zonas'));
    }

    public function update(Request $request, Bairro $bairro)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'zona_id' => 'required|exists:zonas,id',
            'valor_pgm' => 'required'
        ]);

        $bairro->update($request->all());

        return redirect()->route('bairros.index')
            ->with('success', 'Bairro atualizado com sucesso!');
    }

    public function destroy(Bairro $bairro)
    {
        // Verifica se o bairro tem móveis associados antes de excluir
        if ($bairro->imoveis()->exists()) {
            return redirect()->route('bairros.index')
                ->with('error', 'Não é possível excluir este bairro pois existem móveis associados a ele.');
        }

        $bairro->delete();

        return redirect()->route('bairros.index')
            ->with('success', 'Bairro excluído com sucesso!');
    }

public function getBairroData($id)
    {
        $bairro = Bairro::with('zona')->find($id);

        //dd($bairro);

        if (!$bairro) {
            return response()->json([
                'error' => 'Bairro não encontrado.',
            ], 404);
        }


        return response()->json([
            'zona_id' => $bairro->zona ? $bairro->zona->id : null,
            'zona_nome' => $bairro->zona ? $bairro->zona->nome : null,
            //'pgm' => number_format((float) $bairro->valor_pgm, 2, '.', ''),
            'pgm' => $bairro->valor_pgm ? $bairro->valor_pgm : null,
        ]);
    }
}
