<?php

namespace App\Http\Controllers;

use App\Models\ControleDeTarefas;
use App\Models\MembrosEquipeTecnica;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class ControleDeTarefasController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view tarefas')) {
            abort(403, 'Você não tem permissão para visualizar tarefas.');
        }
        
        // Inicia a query para buscar as tarefas

        $query = ControleDeTarefas::with(['membroEquipe.usuario', 'cliente'])
           ->when(!$request->has('status'), function($q) {
               $q->where('status', '!=', 'concluída');
           })
           ->orderBy('id', 'desc');

        // Filtro por Processo
        if ($request->has('cliente') && $request->cliente != '') {
            $query->whereHas('cliente', function($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->cliente . '%');
            });
        }
        
           // Filtro por Status (novo filtro)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', 'like', '%' . $request->status . '%');
        }

        // Filtro por Prioridade
        if ($request->has('prioridade') && $request->prioridade != '') {
            $query->where('prioridade', $request->prioridade);
        }

        // Filtro por Situação
        if ($request->has('situacao') && $request->situacao != '') {
            $query->where('situacao', $request->situacao);
        }
        
            // Filtro por Responsável (Membro da Equipe)
    if ($request->has('responsavel') && $request->responsavel != '') {
        $query->where('membro_id', $request->responsavel);
    }

        // Aplica a paginação
        $tarefas = $query->paginate(10); // 10 itens por página

        // Calculando o progresso de cada tarefa
        foreach ($tarefas as $tarefa) {
            $data_inicio = Carbon::parse($tarefa->data_inicio);
            $data_termino = Carbon::parse($tarefa->data_termino);
            $hoje = Carbon::now();

            // Total de dias entre o início e o término
            $totalDias = $data_inicio->diffInDays($data_termino);
            // Dias passados desde o início
            $diasPassados = $data_inicio->diffInDays($hoje);

            // Garantir que o progresso não ultrapasse 100% nem seja negativo
            $progresso = ($diasPassados / $totalDias) * 100;
            $progresso = min(100, max(0, $progresso)); // Limitar entre 0% e 100%

            // Adiciona a variável de progresso à tarefa
            $tarefa->progresso = $progresso;
        }

        // Obtém os valores possíveis para Prioridade
        $getPrioridadeValues = ControleDeTarefas::getPrioridadeValues();

        // Obtém os valores possíveis para Situação (se houver um método no modelo)
        $getStatusValues = ControleDeTarefas::getStatusValues(); // Adicione este método no modelo, se necessário
        
        $membros = MembrosEquipeTecnica::all();

        // Retorna a view com os dados
        return view('controle_de_tarefas.index', compact('tarefas', 'getPrioridadeValues', 'getStatusValues', 'membros'));
    }

    public function create()
    {
        if (!auth()->user()->can('create tarefas')) {
            abort(403, 'Você não tem permissão para criar tarefas.');
        }
        
        $membros = MembrosEquipeTecnica::all();
        $clientes = Cliente::all();
        // Obtém os valores possíveis para Prioridade
        $getPrioridadeValues = ControleDeTarefas::getPrioridadeValues();
        $getStatusValues = ControleDeTarefas::getStatusValues();
        return view('controle_de_tarefas.create', compact('membros', 'clientes', 'getPrioridadeValues', 'getStatusValues'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create tarefas')) {
            abort(403, 'Você não tem permissão para criar tarefas.');
        }

        $request->validate([
            'processo' => 'nullable',
            'descricao_atividade' => 'required',
            'status' => 'required',
            'prioridade' => 'required',
            'membro_id' => 'required',
            'cliente_id' => 'required',
            'data_inicio' => 'required|date',
            'prazo' => 'required',
            'situacao' => 'required',

        ]);



        ControleDeTarefas::create($request->all());

        return redirect()->route('controle_de_tarefas.index')
            ->with('success', 'Tarefa criada com sucesso.');
    }

    public function show(ControleDeTarefas $controleDeTarefas)
    {
        if (!auth()->user()->can('view tarefas')) {
            abort(403, 'Você não tem permissão para visualizar tarefas.');
        }
        
        return view('controle_de_tarefas.show', compact('controleDeTarefas'));
    }

    public function edit(ControleDeTarefas $controleDeTarefas)
    {
        if (!auth()->user()->can('edit tarefas')) {
            abort(403, 'Você não tem permissão para editar tarefas.');
        }
        
        $membros = MembrosEquipeTecnica::all();
        $clientes = Cliente::all();
        $getPrioridadeValues = ControleDeTarefas::getPrioridadeValues();
        $getStatusValues = ControleDeTarefas::getStatusValues();

        // Formatar as datas de acordo com o formato esperado (YYYY-MM-DD)
        // $controleDeTarefas->data_inicio = Carbon::parse($controleDeTarefas->data_inicio)->format('Y-m-d');
        //$controleDeTarefas->data_termino = Carbon::parse($controleDeTarefas->data_termino)->format('Y-m-d');

        //dd($controleDeTarefas->toArray());


        return view('controle_de_tarefas.edit', compact('controleDeTarefas', 'membros', 'clientes', 'getPrioridadeValues', 'getStatusValues'));
    }

    public function update(Request $request, ControleDeTarefas $controleDeTarefas)
    {
        if (!auth()->user()->can('edit tarefas')) {
            abort(403, 'Você não tem permissão para editar tarefas.');
        }
        
        $request->validate([
            'processo' => 'nullable',
            'descricao_atividade' => 'required',
            'status' => 'required',
            'prioridade' => 'required',
            'membro_id' => 'required',
            'cliente_id' => 'required',
            'data_inicio' => 'required|date',
            'prazo' => 'required',
            'situacao' => 'required'
        ]);

        $controleDeTarefas->update($request->all());

        return redirect()->route('controle_de_tarefas.index')
            ->with('success', 'Tarefa atualizada com sucesso.');
    }

    public function destroy(ControleDeTarefas $controleDeTarefas)
    {
        if (!auth()->user()->can('delete tarefas')) {
            abort(403, 'Você não tem permissão para excluir tarefas.');
        }
        
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

    public function updateStatus(Request $request, ControleDeTarefas $controleDeTarefas)
    {
        if (!auth()->user()->can('update status tarefas')) {
            abort(403, 'Você não tem permissão para atualizar status de tarefas.');
        }
        
        $request->validate([
            'status' => 'required|in:nao iniciada,em andamento,concluida,atrasado,Em Revisão,Aguardando Justiça'
        ]);

        $controleDeTarefas->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status atualizado com sucesso!'
        ]);
    }

    public function updateSituacao(Request $request, ControleDeTarefas $controleDeTarefas)
    {
        if (!auth()->user()->can('update situacao tarefas')) {
            abort(403, 'Você não tem permissão para atualizar situação de tarefas.');
        }
        
        // Se a situação for nula ou vazia, permitimos isso
        if ($request->situacao === null || $request->situacao === '') {
            // Usar uma string vazia em vez de null, caso a coluna não aceite valores nulos
            $controleDeTarefas->update(['situacao' => '']);
            
            return response()->json([
                'success' => true,
                'message' => 'Situação removida com sucesso!'
            ]);
        }
        
        $situacoes = implode(',', \App\Models\ControleDeTarefas::situacaoOptions());
        
        $request->validate([
            'situacao' => 'required|in:' . $situacoes
        ]);

        $controleDeTarefas->update(['situacao' => $request->situacao]);

        return response()->json([
            'success' => true,
            'message' => 'Situação atualizada com sucesso!'
        ]);
    }
    
    public function duplicate(ControleDeTarefas $controleDeTarefa)
    {
        if (!auth()->user()->can('duplicate tarefas')) {
            abort(403, 'Você não tem permissão para duplicar tarefas.');
        }
        
        try {
            $newTarefa = $controleDeTarefa->replicate();
            $newTarefa->situacao = 'nao iniciada';
            $newTarefa->created_at = now();
            $newTarefa->save();
            
            return redirect()->route('controle_de_tarefas.edit', $newTarefa->id)
                ->with('success', 'Tarefa duplicada com sucesso! Você pode agora editar as informações necessárias.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao duplicar tarefa: ' . $e->getMessage());
        }
    }
    
    public function getTarefasPorStatus(Request $request)
    {
        if (!auth()->user()->can('view tarefas')) {
            abort(403, 'Você não tem permissão para visualizar tarefas.');
        }

        $userId = $request->user_id;
        $status = $request->status;
        
        $statusMap = [
            'nao_iniciada' => 'nao iniciada',
            'em_andamento' => 'em andamento', 
            'atrasada' => 'atrasado',
            'concluida' => 'concluida'
        ];
        
        $statusBusca = $statusMap[$status] ?? $status;
        
        $tarefas = ControleDeTarefas::with(['membroEquipe.usuario', 'cliente'])
            ->whereHas('membroEquipe.usuario', function($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->where('status', $statusBusca)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($tarefas);
    }

    public function exportarParaImpressao(Request $request)
{
    if (!auth()->user()->can('export tarefas')) {
        abort(403, 'Você não tem permissão para exportar tarefas.');
    }    // Aplicar os mesmos filtros da index

    $query = ControleDeTarefas::query()
        ->with(['cliente', 'membroEquipe'])
        ->orderBy('prazo', 'asc');

    if ($request->cliente) {
        $query->whereHas('cliente', function($q) use ($request) {
            $q->where('nome', 'like', '%'.$request->cliente.'%');
        });
    }

    if ($request->prioridade) {
        $query->where('prioridade', $request->prioridade);
    }

    if ($request->situacao) {
        $query->where('situacao', $request->situacao);
    }

    // Filtro por tipo de atividade
    if ($request->has('tipo_atividade') && $request->tipo_atividade != '') {
        $query->where('tipo_atividade', $request->tipo_atividade);
    }

    if ($request->has('status') && $request->status != '') {
        $query->where('status', 'like', '%' . $request->status . '%');
    }

    if ($request->has('responsavel') && $request->responsavel != '') {
        $query->where('membro_id', $request->responsavel);
    }

    // Filtro para não mostrar concluídas, a menos que o usuário marque o checkbox
    if (!$request->has('mostrar_concluidas') || !$request->mostrar_concluidas) {
        $query->where('status', '!=', 'concluida');
    }

    $tarefas = $query->get();

    // Processar as datas para o formato correto
    $tarefas->transform(function($tarefa) {
        try {
            $tarefa->prazo_formatado = $this->parsePortugueseDate($tarefa->prazo)->format('d/m/Y');
        } catch (\Exception $e) {
            $tarefa->prazo_formatado = $tarefa->prazo; // Mantém o original se não puder converter
        }
        return $tarefa;
    });

    // Caminho para o logo
    $logo = public_path('/img/impressao.png');

    // Gerar PDF
    $pdf = Pdf::loadView('controle_de_tarefas.impressao', compact('tarefas', 'logo'))
        ->setPaper('a4', 'landscape');

    // Definir nome do arquivo
    $filename = 'relatorio_tarefas_' . now()->format('Ymd_His') . '.pdf';

    return $pdf->stream($filename);
}

// Adicione esta função no mesmo controller
private function parsePortugueseDate($dateString)
{
    if (empty($dateString)) {
        return null;
    }

    // Se já for uma data formatada (YYYY-MM-DD)
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateString)) {
        return \Carbon\Carbon::parse($dateString);
    }

    // Se for um número (dias)
    if (is_numeric($dateString)) {
        return \Carbon\Carbon::now()->addDays($dateString);
    }

    // Converter expressões em português
    $dateString = strtolower($dateString);
    $parts = explode(' ', $dateString);

    if (count($parts) === 2 && is_numeric($parts[0])) {
        $quantity = (int)$parts[0];
        $unit = $parts[1];

        $now = \Carbon\Carbon::now();

        switch ($unit) {
            case 'dia':
            case 'dias':
                return $now->addDays($quantity);
            case 'semana':
            case 'semanas':
                return $now->addWeeks($quantity);
            case 'mês':
            case 'mes':
            case 'meses':
                return $now->addMonths($quantity);
            case 'ano':
            case 'anos':
                return $now->addYears($quantity);
        }
    }

    // Tentar parsear como data em português
    try {
        $dateString = str_replace(
            ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho',
             'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'],
            ['january', 'february', 'march', 'april', 'may', 'june',
             'july', 'august', 'september', 'october', 'november', 'december'],
            $dateString
        );
        return \Carbon\Carbon::parse($dateString);
    } catch (\Exception $e) {
        return $now ?? \Carbon\Carbon::now();
    }
}
}
