<?php

namespace App\Http\Controllers;

use App\Models\ControleDeTarefas;
use App\Models\MembrosEquipeTecnica;
use Illuminate\Http\Request;


class ControleDeTarefasController extends Controller
{
    public function index(Request $request)
    {
        // Inicia a query para buscar as tarefas

        $query = ControleDeTarefas::with('membroEquipe.usuario');

        // Filtro por Processo
        if ($request->has('processo') && $request->processo != '') {
            $query->where('processo', 'like', '%' . $request->processo . '%');
        }

        // Filtro por Prioridade
        if ($request->has('prioridade') && $request->prioridade != '') {
            $query->where('prioridade', $request->prioridade);
        }

        // Filtro por Situação
        if ($request->has('situacao') && $request->situacao != '') {
            $query->where('situacao', $request->situacao);
        }

        // Aplica a paginação
        $tarefas = $query->paginate(10); // 10 itens por página

        // Obtém os valores possíveis para Prioridade
        $getPrioridadeValues = ControleDeTarefas::getPrioridadeValues();

        // Obtém os valores possíveis para Situação (se houver um método no modelo)
        $getSituacaoValues = ControleDeTarefas::getSituacaoValues(); // Adicione este método no modelo, se necessário

        // Retorna a view com os dados
        return view('controle_de_tarefas.index', compact('tarefas', 'getPrioridadeValues', 'getSituacaoValues'));
    }

    public function create()
    {
        $membros = MembrosEquipeTecnica::all();
        // Obtém os valores possíveis para Prioridade
        $getPrioridadeValues = ControleDeTarefas::getPrioridadeValues();
        $getSituacaoValues = ControleDeTarefas::getSituacaoValues();
        return view('controle_de_tarefas.create', compact('membros', 'getPrioridadeValues', 'getSituacaoValues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'processo' => 'required',
            'descricao_atividade' => 'required',
            'status' => 'required',
            'prioridade' => 'required',
            'membro_id' => 'required',
            'data_inicio' => 'required|date',
            'prazo' => 'required',
            'situacao' => 'required'
        ]);

        ControleDeTarefas::create($request->all());

        return redirect()->route('controle_de_tarefas.index')
            ->with('success', 'Tarefa criada com sucesso.');
    }

    public function show(ControleDeTarefas $controleDeTarefas)
    {
        return view('controle_de_tarefas.show', compact('controleDeTarefas'));
    }

    public function edit(ControleDeTarefas $controleDeTarefas)
    {
        $membros = MembrosEquipeTecnica::all();
        $getPrioridadeValues = ControleDeTarefas::getPrioridadeValues();
        $getSituacaoValues = ControleDeTarefas::getSituacaoValues();


        return view('controle_de_tarefas.edit', compact('controleDeTarefas', 'membros', 'getPrioridadeValues', 'getSituacaoValues'));
    }

    public function update(Request $request, ControleDeTarefas $controleDeTarefas)
    {
        $request->validate([
            'processo' => 'required',
            'descricao_atividade' => 'required',
            'status' => 'required',
            'prioridade' => 'required',
            'membro_id' => 'required',
            'data_inicio' => 'required|date',
            'prazo' => 'required|date',
            'situacao' => 'required'
        ]);

        $controleDeTarefas->update($request->all());

        return redirect()->route('controle_de_tarefas.index')
            ->with('success', 'Tarefa atualizada com sucesso.');
    }

    public function destroy(ControleDeTarefas $controleDeTarefas)
    {
        $controleDeTarefas->delete();

        return redirect()->route('controle_de_tarefas.index')
            ->with('success', 'Tarefa removida com sucesso.');
    }

    public function dashboard()
    {
        $userId = auth()->id();
        $tarefas = ControleDeTarefas::whereHas('membroEquipe.usuario', function ($query) use ($userId) {
            $query->where('id', $userId);
        })->get();

        return view('controle_de_tarefas.dashboard', compact('tarefas'));
    }
}
