<?php

namespace App\Http\Controllers;

use App\Models\OrdemDeServico;
use App\Models\User;
use Illuminate\Http\Request;

class OrdemDeServicoController extends Controller
{
    public function index()
    {
        $statusValues = OrdemDeServico::getStatusValues();
        $users = User::all();
        $ordens = OrdemDeServico::with('user')->get();
        return view('ordens_de_servico.index', compact('ordens', 'statusValues', 'users'));
    }

    public function create()
    {
        $users = User::all();
        $statusValues = OrdemDeServico::getStatusValues();
        return view('ordens_de_servico.create', compact('users', 'statusValues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required',
            'user_id' => 'required|exists:users,id',
            'status' => 'required'
        ]);

        OrdemDeServico::create($request->all());

        return redirect()->route('ordens-de-servico.index')
            ->with('success', 'Ordem de serviço criada com sucesso.');
    }

    public function show(OrdemDeServico $ordemDeServico)
    {
        return view('ordens_de_servico.show', compact('ordemDeServico'));
    }

    public function edit(OrdemDeServico $ordemDeServico)
    {
        $users = User::all();
        return view('ordens_de_servico.edit', compact('ordemDeServico', 'users'));
    }

    public function update(Request $request, OrdemDeServico $ordemDeServico)
    {
        $request->validate([
            'descricao' => 'required',
            'user_id' => 'required|exists:users,id',
            'status' => 'required'
        ]);

        $ordemDeServico->update($request->all());

        return redirect()->route('ordens-de-servico.index')
            ->with('success', 'Ordem de serviço atualizada com sucesso.');
    }

    public function destroy(OrdemDeServico $ordemDeServico)
    {
        $ordemDeServico->delete();

        return redirect()->route('ordens-de-servico.index')
            ->with('success', 'Ordem de serviço excluída com sucesso.');
    }
}
