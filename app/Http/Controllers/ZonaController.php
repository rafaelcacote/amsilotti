<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    public function index()
    {
    $zonas = Zona::orderByRaw("tipo = 'trecho' DESC")->orderBy('nome')->paginate(10);
        return view('zonas.index', compact('zonas'));
    }

    public function create()
    {
        return view('zonas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:zona,trecho'
        ]);

        Zona::create($request->all());

        return redirect()->route('zonas.index')
            ->with('success', 'Zona criada com sucesso!');
    }

    public function show(Zona $zona)
    {
        return view('zonas.show', compact('zona'));
    }

    public function edit(Zona $zona)
    {
        return view('zonas.edit', compact('zona'));
    }

    public function update(Request $request, Zona $zona)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:zona,trecho'
        ]);

        $zona->update($request->all());

        return redirect()->route('zonas.index')
            ->with('success', 'Zona atualizada com sucesso!');
    }

    public function destroy(Zona $zona)
    {
        // Check if the zone has neighborhoods before deleting
        if ($zona->bairros()->count() > 0) {
            return redirect()->route('zonas.index')
                ->with('error', 'Não é possível excluir esta zona pois existem bairros associados a ela.');
        }

        $zona->delete();

        return redirect()->route('zonas.index')
            ->with('success', 'Zona excluída com sucesso!');
    }
}
