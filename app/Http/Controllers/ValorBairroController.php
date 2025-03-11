<?php

namespace App\Http\Controllers;

use App\Models\Bairro;
use App\Models\ValorBairro;
use Illuminate\Http\Request;

class ValorBairroController extends Controller
{
    public function index(Request $request)
    {
        $bairros = Bairro::orderBy('nome')->get();
        
        $valores = ValorBairro::with('bairro.zona')
            ->when($request->bairro_id, function ($query) use ($request) {
                return $query->where('bairro_id', $request->bairro_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('valores_bairros.index', compact('valores', 'bairros'));
    }

    public function create()
    {
        $bairros = Bairro::with('zona')->orderBy('nome')->get();
        return view('valores_bairros.create', compact('bairros'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bairro_id' => 'required|exists:bairros,id',
            'valor' => 'required|numeric|min:0'
        ]);

        ValorBairro::create($request->all());

        return redirect()->route('valores-bairros.index')
            ->with('success', 'Valor de bairro cadastrado com sucesso!');
    }

    public function show(ValorBairro $valoresBairro)
    {
        $valoresBairro->load('bairro.zona');
        return view('valores_bairros.show', compact('valoresBairro'));
    }

    public function edit(ValorBairro $valoresBairro)
    {
        $bairros = Bairro::with('zona')->orderBy('nome')->get();
        return view('valores_bairros.edit', compact('valoresBairro', 'bairros'));
    }

    public function update(Request $request, ValorBairro $valoresBairro)
    {
        $request->validate([
            'bairro_id' => 'required|exists:bairros,id',
            'valor' => 'required|numeric|min:0'
        ]);

        $valoresBairro->update($request->all());

        return redirect()->route('valores-bairros.index')
            ->with('success', 'Valor de bairro atualizado com sucesso!');
    }

    public function destroy(ValorBairro $valoresBairro)
    {
        $valoresBairro->delete();

        return redirect()->route('valores-bairros.index')
            ->with('success', 'Valor de bairro excluído com sucesso!');
    }
}