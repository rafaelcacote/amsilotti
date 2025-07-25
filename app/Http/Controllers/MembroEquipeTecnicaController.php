<?php

namespace App\Http\Controllers;

use App\Models\MembrosEquipeTecnica;
use App\Models\User;
use Illuminate\Http\Request;

class MembroEquipeTecnicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MembrosEquipeTecnica::where('status', true);

        // Filtro por nome
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nome', 'like', '%' . $request->search . '%');
        }

        // Filtro por cargo
        if ($request->has('cargo') && !empty($request->cargo)) {
            $query->where('cargo', $request->cargo);
        }

        $membros = $query->orderBy('id', 'desc')->paginate(10);

        return view('membro_equipe_tecnicas.index', compact('membros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::all();
        return view('membro_equipe_tecnicas.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:15',
            'cargo' => 'required',
            'user_id' => 'nullable|',
        ]);

        MembrosEquipeTecnica::create($validatedData);

        return redirect()->route('membro-equipe-tecnicas.index')
            ->with('success', 'Membro da equipe técnica criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MembrosEquipeTecnica $membroEquipeTecnica)
    {
        $membroEquipeTecnica->load('usuario');
        return view('membro_equipe_tecnicas.show', compact('membroEquipeTecnica'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MembrosEquipeTecnica $membroEquipeTecnica)
    {
        $usuarios = User::all();
        $membroEquipeTecnica->load('usuario');

        return view('membro_equipe_tecnicas.edit', compact('membroEquipeTecnica', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MembrosEquipeTecnica $membroEquipeTecnica)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:15',
            'cargo' => 'required',
            'user_id' => 'nullable|',
        ]);

        $membroEquipeTecnica->update($validatedData);

        return redirect()->route('membro-equipe-tecnicas.index')
            ->with('success', 'Membro da equipe técnica atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MembrosEquipeTecnica $membroEquipeTecnica)
    {
        // Atualiza o status para false
        $membroEquipeTecnica->update(['status' => false]);

        return redirect()->route('membro-equipe-tecnicas.index')
            ->with('success', 'Membro da equipe técnica desativado com sucesso!');
    }
}
