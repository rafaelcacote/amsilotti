<?php

namespace App\Http\Controllers;

use App\Models\MembroEquipeTecnica;
use Illuminate\Http\Request;

class MembroEquipeTecnicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $membros = MembroEquipeTecnica::orderBy('nome')->paginate(10);
        return view('membro_equipe_tecnicas.index', compact('membros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('membro_equipe_tecnicas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:15',
            'cargo' => 'required|in:Assistente Técnica,Perita Judicial',
        ]);

        MembroEquipeTecnica::create($validatedData);

        return redirect()->route('membro-equipe-tecnicas.index')
            ->with('success', 'Membro da equipe técnica criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MembroEquipeTecnica $membroEquipeTecnica)
    {
        return view('membro_equipe_tecnicas.show', compact('membroEquipeTecnica'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MembroEquipeTecnica $membroEquipeTecnica)
    {
        return view('membro_equipe_tecnicas.edit', compact('membroEquipeTecnica'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MembroEquipeTecnica $membroEquipeTecnica)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:15',
            'cargo' => 'required|in:Assistente Técnica,Perita Judicial',
        ]);

        $membroEquipeTecnica->update($validatedData);

        return redirect()->route('membro-equipe-tecnicas.index')
            ->with('success', 'Membro da equipe técnica atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MembroEquipeTecnica $membroEquipeTecnica)
    {
        $membroEquipeTecnica->delete();

        return redirect()->route('membro-equipe-tecnicas.index')
            ->with('success', 'Membro da equipe técnica excluído com sucesso!');
    }
}