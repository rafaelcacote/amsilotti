<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use App\Models\Bairro;
use App\Models\ViaEspecifica;
use App\Models\Zona;
use Illuminate\Http\Request;

class ImovelController extends Controller
{
    public function index(Request $request)
    {
        $bairros = Bairro::all();
        $vias = ViaEspecifica::all();

        $imoveis = Imovel::with(['bairro', 'viaEspecifica'])
            ->when($request->bairro_id, function ($query) use ($request) {
                return $query->where('bairro_id', $request->bairro_id);
            })
            ->when($request->via_especifica_id, function ($query) use ($request) {
                return $query->where('via_especifica_id', $request->via_especifica_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('imoveis.index', compact('imoveis', 'bairros', 'vias'));
    }

    public function create()
    {
        $bairros = Bairro::all();
        $vias = ViaEspecifica::all();
        $zonas = Zona::all();
        return view('imoveis.create', compact('bairros', 'vias', 'zonas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'endereco' => 'required|string|max:191',
            'bairro_id' => 'nullable|exists:bairros,id',
            'via_especifica_id' => 'nullable|exists:vias_especificas,id',
            // Add validation for other fields
        ]);

        Imovel::create($data);

        return redirect()->route('imoveis.index')->with('success', 'Imóvel criado com sucesso!');
    }

    public function show(Imovel $imovel)
    {
        return view('imoveis.show', compact('imovel'));
    }

    public function edit(Imovel $imovel)
    {
        $bairros = Bairro::all();
        $vias = ViaEspecifica::all();
        return view('imoveis.edit', compact('imovel', 'bairros', 'vias'));
    }

    public function update(Request $request, Imovel $imovel)
    {
        $data = $request->validate([
            'endereco' => 'required|string|max:191',
            'bairro_id' => 'nullable|exists:bairros,id',
            'via_especifica_id' => 'nullable|exists:vias_especificas,id',
            // Add validation for other fields
        ]);

        $imovel->update($data);

        return redirect()->route('imoveis.index')->with('success', 'Imóvel atualizado com sucesso!');
    }

    public function destroy(Imovel $imovel)
    {
        $imovel->delete();
        return redirect()->route('imoveis.index')->with('success', 'Imóvel removido com sucesso!');
    }
}