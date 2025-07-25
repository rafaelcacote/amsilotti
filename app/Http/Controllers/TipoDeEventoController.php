<?php

namespace App\Http\Controllers;

use App\Models\TipoDeEvento;
use Illuminate\Http\Request;

class TipoDeEventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view agenda tipos-evento');
        
        $tipos = TipoDeEvento::orderBy('nome')->paginate(10);
        return view('tipos_de_evento.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create agenda tipos-evento');
        
        return view('tipos_de_evento.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create agenda tipos-evento');
        
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:tipos_de_evento,nome',
            'codigo' => 'required|string|max:50|unique:tipos_de_evento,codigo|alpha_dash',
            'cor' => 'required|string|max:20',
            'descricao' => 'nullable|string',
            'ativo' => 'boolean',
            'is_padrao' => 'boolean',
        ]);

        TipoDeEvento::create($validated);
        return redirect()->route('tipos-de-evento.index')->with('success', 'Tipo de evento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoDeEvento $tiposDeEvento)
    {
        $this->authorize('view agenda tipos-evento');
        
        return view('tipos_de_evento.show', ['tipo' => $tiposDeEvento]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoDeEvento $tiposDeEvento)
    {
        $this->authorize('edit agenda tipos-evento');
        
        return view('tipos_de_evento.edit', ['tipo' => $tiposDeEvento]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoDeEvento $tiposDeEvento)
    {
        $this->authorize('edit agenda tipos-evento');
        
        $validated = $request->validate([
            'nome' => 'required|string|max:100|unique:tipos_de_evento,nome,' . $tiposDeEvento->id,
            'codigo' => 'required|string|max:50|unique:tipos_de_evento,codigo,' . $tiposDeEvento->id . '|alpha_dash',
            'cor' => 'required|string|max:20',
            'descricao' => 'nullable|string',
            'ativo' => 'boolean',
            'is_padrao' => 'boolean',
        ]);

        $tiposDeEvento->update($validated);
        return redirect()->route('tipos-de-evento.index')->with('success', 'Tipo de evento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoDeEvento $tiposDeEvento)
    {
        $this->authorize('delete agenda tipos-evento');
        
        // Verificar se o tipo está sendo usado em alguma agenda
        if ($tiposDeEvento->agendas()->count() > 0) {
            return redirect()->route('tipos-de-evento.index')->with('error', 'Não é possível excluir um tipo de evento que está sendo usado em compromissos.');
        }

        $tiposDeEvento->delete();
        return redirect()->route('tipos-de-evento.index')->with('success', 'Tipo de evento excluído com sucesso!');
    }
}
