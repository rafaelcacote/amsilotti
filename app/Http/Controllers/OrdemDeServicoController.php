<?php

namespace App\Http\Controllers;

use App\Models\OrdemDeServico;
use App\Models\User;
use App\Models\MembrosEquipeTecnica;
use Illuminate\Http\Request;

class OrdemDeServicoController extends Controller
{
    public function index(Request $request)
    {
        $statusValues = OrdemDeServico::getStatusValues();
        $membros = MembrosEquipeTecnica::all();

        $ordens = OrdemDeServico::with('membroEquipeTecnica')
            ->when($request->status, function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->membro_id, function ($query) use ($request) {
                return $query->where('membro_id', $request->membro_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Altere o número para a quantidade desejada por página

        return view('ordens_de_servico.index', compact('ordens', 'statusValues', 'membros'));
    }

    public function create()
    {
        $membros = MembrosEquipeTecnica::all();
        $statusValues = OrdemDeServico::getStatusValues();
        return view('ordens_de_servico.create', compact('membros', 'statusValues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required',
            'membro_id' => 'required|exists:membros_equipe_tecnicas,id',
            'status' => 'required'
        ]);

        OrdemDeServico::create($request->all());

        return redirect()->route('ordens-de-servico.index')->with('success', 'Ordem de serviço criada com sucesso!');
    }

    public function show(OrdemDeServico $ordemDeServico)
    {
        return view('ordens_de_servico.show', compact('ordemDeServico'));
    }

    public function edit(OrdemDeServico $ordemDeServico)
    {
        $users = User::all();
        $statusValues = OrdemDeServico::getStatusValues();
        return view('ordens_de_servico.edit', compact('ordemDeServico', 'users', 'statusValues'));
    }

    public function update(Request $request, OrdemDeServico $ordemDeServico)
    {
        $request->validate([
            'descricao' => 'required',
            'user_id' => 'required|exists:users,id',
            'status' => 'required'
        ]);

        $ordemDeServico->update($request->all());

        return redirect()->route('ordens-de-servico.index')->with('success', 'Ordem de serviço atualizada com sucesso!');
    }

    public function destroy(OrdemDeServico $ordemDeServico)
    {
        $ordemDeServico->delete();

        return redirect()->route('ordens-de-servico.index')
            ->with('success', 'Ordem de serviço excluída com sucesso.');
    }
}
