<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ControleDeTarefas;
use App\Models\Vistoria;
use App\Models\Imovel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller

{
    public function index(Request $request)
    {
        // Obtém o usuário logado
        $user = Auth::user();

        $getPrioridadeValues = ControleDeTarefas::getPrioridadeValues();
        $situacaoOptions = ControleDeTarefas::situacaoOptions();

        $getStatusValues = ControleDeTarefas::getStatusValues();

        // Obtém as tarefas do usuário logado
        // $tarefas = ControleDeTarefas::whereHas('membroEquipe', function ($query) use ($user) {
        //     $query->where('user_id', $user->id);
        // })->get();
        $query = ControleDeTarefas::query();
        $query->where('status', '!=', 'concluída');

        if ($user->membroEquipe && !$request->has('all') && !$user->is_admin) {
            $query->whereHas('membroEquipe', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $tarefas = $query->orderBy('id', 'desc')->get();

        $tarefasEmAndamento = ControleDeTarefas::where('status', 'em andamento')->count();
        $tarefasAtrasadas = ControleDeTarefas::where('status', 'atrasado')->count();
        $tarefasnaoIniciadas = ControleDeTarefas::where('status', 'nao iniciada')->count();
        $tarefasConcluidas = ControleDeTarefas::where('status', 'concluida')->count();





        // $minhasTarefasEmAndamento = ControleDeTarefas::whereHas('membroEquipe', function($query) use ($user) {
        //     $query->where('user_id', $user->id);
        // })->where('status', 'em_andamento')->count();



        // $tarefasEmAndamento = ControleDeTarefas::whereHas('membroEquipe', function ($query) use ($user) {
        //     $query->where('user_id', $user->id);
        // })->where('status', 'em_andamento')->count();

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




        $quantidadeVistorias = Vistoria::count();
        $quantidadeImoveis = Imovel::count();

        // Novos dados para o dashboard moderno
        $quantidadePericias = \App\Models\ControlePericia::count();
        $quantidadeTarefas = ControleDeTarefas::count();

        // Dados específicos para gráficos de perícias
        $periciasPorStatus = \App\Models\ControlePericia::selectRaw('status_atual, COUNT(*) as total')
            ->groupBy('status_atual')
            ->orderBy('total', 'desc')
            ->get();

        $periciasPorTipo = \App\Models\ControlePericia::selectRaw('tipo_pericia, COUNT(*) as total')
            ->whereNotNull('tipo_pericia')
            ->groupBy('tipo_pericia')
            ->orderBy('total', 'desc')
            ->get();

        $periciasPorResponsavel = \App\Models\ControlePericia::with('responsavelTecnico')
            ->selectRaw('responsavel_tecnico_id, COUNT(*) as total')
            ->whereNotNull('responsavel_tecnico_id')
            ->groupBy('responsavel_tecnico_id')
            ->orderBy('total', 'desc')
            ->limit(8)
            ->get();

        // Perícias por mês (últimos 6 meses)
        $periciasPorMes = \App\Models\ControlePericia::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, COUNT(*) as total')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Métricas importantes de perícias
        $periciasPrazosVencidos = \App\Models\ControlePericia::where('prazo_final', '<', now())
            ->whereNotIn('status_atual', ['Concluído', 'Entregue', 'Cancelado'])
            ->count();

        $periciasPendentesVistoria = \App\Models\ControlePericia::where('status_atual', 'Aguardando Vistoria')->count();
        $periciasEmRedacao = \App\Models\ControlePericia::whereIn('status_atual', ['Em Redação', 'em redacao'])->count();
        $periciasEntregues = \App\Models\ControlePericia::whereIn('status_atual', ['Entregue', 'Concluído', 'concluido'])->count();
        // Buscar compromissos a partir de hoje (futuros)
        $hoje = now()->startOfDay();
        $proximosCompromissos = \App\Models\Agenda::where('data', '>=', $hoje)
            ->orderBy('data', 'asc')
            ->limit(5)
            ->get();


        // Vistorias agendadas por mês (todas)
        $vistoriasAgendadasPorMes = Vistoria::join('agenda', 'vistorias.agenda_id', '=', 'agenda.id')
            ->selectRaw('DATE_FORMAT(agenda.data, "%Y-%m") as mes, COUNT(*) as total')
            ->where('agenda.data', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Vistorias realizadas por mês (status = "preenchido")
        $vistoriasRealizadasPorMes = Vistoria::join('agenda', 'vistorias.agenda_id', '=', 'agenda.id')
            ->selectRaw('DATE_FORMAT(agenda.data, "%Y-%m") as mes, COUNT(*) as total')
            ->where('agenda.data', '>=', now()->subMonths(6))
            ->where('vistorias.status', 'preenchido')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $ultimasVistorias = Vistoria::orderBy('created_at', 'desc')->limit(5)->get();
        $ultimasTarefas = ControleDeTarefas::orderBy('created_at', 'desc')->limit(5)->get();

        $imoveis = Imovel::with('bairro')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'endereco', 'numero', 'latitude', 'longitude', 'tipo', 'bairro_id']);

        // Monta a tabela dinâmica de tarefas por usuário
        $tarefasPorUsuario = \App\Models\User::with(['membroEquipe'])
            ->get()
            ->map(function($usuario) {
                $tarefas = \App\Models\ControleDeTarefas::whereHas('membroEquipe', function($q) use ($usuario) {
                    $q->where('user_id', $usuario->id);
                })->get();

                $statusMap = [
                    'nao iniciada' => 0,
                    'em andamento' => 0,
                    'atrasada' => 0,
                    'concluida' => 0,
                ];
                foreach ($tarefas as $tarefa) {
                    $status = strtolower($tarefa->status);
                    if (isset($statusMap[$status])) {
                        $statusMap[$status]++;
                    }
                }
                $avatar = $usuario->membroEquipe && $usuario->membroEquipe->avatar ? asset('storage/' . $usuario->membroEquipe->avatar) : asset('assets/img/avatars/default.png');
                return [
                    'id' => $usuario->id,
                    'nome' => $usuario->name,
                    'email' => $usuario->email,
                    'avatar' => $avatar,
                    'total' => $tarefas->count(),
                    'nao_iniciada' => $statusMap['nao iniciada'],
                    'em_andamento' => $statusMap['em andamento'],
                    'atrasada' => $statusMap['atrasada'],
                    'concluida' => $statusMap['concluida'],
                ];
            })
            ->filter(function($usuario) {
                return $usuario['total'] > 0;
            })
            ->values();

        // Passa as tarefas e novos dados para a view
        return view('dashboard', compact(
            'tarefas',
            'imoveis',
            'tarefasEmAndamento',
            'tarefasAtrasadas',
            'tarefasnaoIniciadas',
            'tarefasConcluidas',
            'quantidadeVistorias',
            'quantidadeImoveis',
            'quantidadePericias',
            'quantidadeTarefas',
            'proximosCompromissos',
            'vistoriasAgendadasPorMes',
            'vistoriasRealizadasPorMes',
            'ultimasVistorias',
            'ultimasTarefas',
            'situacaoOptions',
            'getPrioridadeValues',
            'user',
            'getStatusValues',
            'tarefasPorUsuario',
            'periciasPorStatus',
            'periciasPorTipo',
            'periciasPorResponsavel',
            'periciasPorMes',
            'periciasPrazosVencidos',
            'periciasPendentesVistoria',
            'periciasEmRedacao',
            'periciasEntregues'
        ));
    }
    /**
     * Retorna tarefas filtradas por usuário e status para o dashboard (AJAX)
     */
    public function tarefasPorStatus(Request $request)
    {
        $userId = $request->input('user_id');
        $status = $request->input('status');

        // Mapeamento para status do banco, considerando variações
        $statusMap = [
            'nao_iniciada' => ['nao iniciada', 'não iniciada', 'nao_iniciada', 'não_iniciada'],
            'em_andamento' => ['em andamento', 'em_andamento'],
            'atrasada' => ['atrasada', 'atrasado'],
            'concluida' => ['concluida', 'concluída'],
        ];

        $statusDb = $statusMap[$status] ?? null;
        if (!$userId || !$statusDb) {
            return response()->json([], 200);
        }

        $tarefas = \App\Models\ControleDeTarefas::whereHas('membroEquipe', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where(function($query) use ($statusDb) {
                foreach ($statusDb as $statusValue) {
                    $query->orWhereRaw('LOWER(status) = ?', [strtolower($statusValue)]);
                }
            })
            ->orderBy('prazo', 'asc')
            ->get();

        // Formata para o frontend
        $result = $tarefas->map(function($tarefa) {
            // Trata o campo prazo com segurança
            $prazoFormatado = '-';
            if ($tarefa->prazo) {
                try {
                    // Verifica se é uma data válida antes de tentar fazer o parse
                    if (strtotime($tarefa->prazo) !== false) {
                        $prazoFormatado = \Carbon\Carbon::parse($tarefa->prazo)->format('d/m/Y');
                    } else {
                        // Se não for uma data válida, mantém o valor original
                        $prazoFormatado = $tarefa->prazo;
                    }
                } catch (\Exception $e) {
                    // Em caso de erro, mantém o valor original
                    $prazoFormatado = $tarefa->prazo;
                }
            }

            return [
                'id' => $tarefa->id,
                'processo' => $tarefa->processo ?? '-',
                'descricao_atividade' => $tarefa->descricao_atividade ?? '-',
                'tipo_atividade' => $tarefa->tipo_atividade ?? '-',
                'prioridade' => $tarefa->prioridade ?? '-',
                'prazo' => $prazoFormatado,
            ];
        });

        return response()->json($result, 200);
    }
}
