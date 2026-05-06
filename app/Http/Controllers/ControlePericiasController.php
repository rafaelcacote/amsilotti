<?php

namespace App\Http\Controllers;

use App\Models\ControlePericia;
use App\Models\MembrosEquipeTecnica;
use App\Models\Cliente;
use App\Models\Agenda;
use App\Models\ChecklistDocumentoPericia;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mpdf\Mpdf;
use Carbon\Carbon;

class ControlePericiasController extends Controller
{
    /**
     * AJAX: Checa se já existe o número de processo informado
     */
    public function checkNumeroProcesso(Request $request)
    {
        $numero = $request->input('numero_processo');
        $existe = false;
        if ($numero) {
            $existe = \App\Models\ControlePericia::where('numero_processo', $numero)->exists();
        }
        return response()->json(['exists' => $existe]);
    }
    /**
     * Display a listing of the pericias.
     */
    public function index(Request $request): View
    {
        if (!auth()->user()->can('view pericias')) {
            abort(403, 'Você não tem permissão para visualizar perícias.');
        }

    $search = $request->input('search');
    $responsavelId = $request->input('responsavel_tecnico_id');
    $status = $request->input('status_atual');
    $vara = $request->input('vara');
    $tipoPericia = $request->input('tipo_pericia');
    $prazoFinalMes = $request->input('prazo_final_mes');
    $prazoFinalAno = $request->input('prazo_final_ano');
    $filtro = $request->input('filtro');

        $pericias = ControlePericia::query()
            ->with(['responsavelTecnico', 'requerente'])
            ->when($filtro === 'prazos-vencidos', function ($query) {
                return $query->where('prazo_final', '<', now())
                    ->whereNotIn('status_atual', ['Concluído', 'Entregue', 'Cancelado']);
            })
            ->when($filtro === 'aguardando-vistoria', function ($query) {
                return $query->where('status_atual', 'Aguardando Vistoria');
            })
            ->when($filtro === 'em-redacao', function ($query) {
                return $query->whereIn('status_atual', ['Em Redação', 'em redacao']);
            })
            ->when($filtro === 'entregues', function ($query) {
                return $query->whereIn('status_atual', ['Entregue', 'Concluído', 'concluido']);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('numero_processo', 'like', "%{$search}%")
                      ->orWhere('vara', 'like', "%{$search}%")
                      ->orWhere('requerido', 'like', "%{$search}%")
                      ->orWhereHas('requerente', function($q) use ($search) {
                          $q->where('nome', 'like', "%{$search}%");
                      });
                });
            })
            ->when($vara, function ($query, $vara) {
                return $query->where('vara', $vara);
            })
            ->when($responsavelId, function ($query, $responsavelId) {
                return $query->where('responsavel_tecnico_id', $responsavelId);
            })
            ->when($status, function ($query, $status) {
                return $query->whereRaw('LOWER(status_atual) = ?', [strtolower($status)]);
            })
            ->when($tipoPericia, function ($query, $tipoPericia) {
                return $query->where('tipo_pericia', $tipoPericia);
            })
            ->when($prazoFinalMes, function ($query) use ($prazoFinalMes) {
                return $query->whereMonth('prazo_final', $prazoFinalMes);
            })
            ->when($prazoFinalAno, function ($query) use ($prazoFinalAno) {
                return $query->whereYear('prazo_final', $prazoFinalAno);
            })
            ->latest()
            ->paginate(10);

        $responsaveis = MembrosEquipeTecnica::where('status', true)->orderBy('nome')->get();

        $statusOptions = [
            'Em Andamento',
            'Concluído',
            'Cancelado',
            'Aguardando Documentação',
            'Aguardando Pagamento',
            'Aguardando Vistoria',
            'Em Redação',
            'Entregue'
        ];

        return view('controle-pericias.index', compact('pericias', 'responsaveis', 'search', 'responsavelId', 'status', 'tipoPericia', 'statusOptions', 'filtro'));
    }

    /**
     * Show the form for creating a new pericia.
     */
    public function create(): View
    {
        if (!auth()->user()->can('create pericias')) {
            abort(403, 'Você não tem permissão para criar perícias.');
        }

        $responsaveis = MembrosEquipeTecnica::where('status', true)->orderBy('nome')->get();
        $clientes = Cliente::orderBy('nome')->get();
        $agenda = Agenda::orderBy('id')->get();

        $statusOptions = [
            'Em Andamento',
            'Concluído',
            'Cancelado',
            'Aguardando Documentação',
            'Aguardando Pagamento',
            'Aguardando Vistoria',
            'Em Redação',
            'Entregue'
        ];

        return view('controle-pericias.create', compact('responsaveis', 'statusOptions'));
    }

    /**
     * Store a newly created pericia in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if (!auth()->user()->can('create pericias')) {
            abort(403, 'Você não tem permissão para criar perícias.');
        }

        $validated = $request->validate([
            'numero_processo' => 'required|string|max:255|unique:controle_pericias,numero_processo',
            'requerente_id' => 'required|exists:clientes,id',
            'requerido' => 'required|string|max:255',
            'vara' => 'required|string|max:255',
            'tipo_pericia' => 'required|string|max:255',
            'data_nomeacao' => 'nullable|date',
            'status_atual' => 'required|string|max:255',
            'data_vistoria' => 'nullable|date',
            'prazo_final' => 'nullable|date',
            'decurso_prazo' => 'nullable|date',
            'valor' => 'nullable|string',
            'responsavel_tecnico_id' => 'nullable|exists:membros_equipe_tecnicas,id',
            'protocolo_responsavel_id' => 'nullable|exists:membros_equipe_tecnicas,id',
            'cadeia_dominial' => 'nullable|string',
            'protocolo' => 'nullable|string|max:255',
            'data_protocolo' => 'nullable|date',
            'observacoes' => 'nullable|string',
        ], [
            'numero_processo.unique' => 'Este número de processo já está cadastrado.'
        ]);

        // Conversão do valor se fornecido
        if (!empty($validated['valor'])) {
            $valor = str_replace(['R$', '.', ','], ['', '', '.'], $validated['valor']);
            $validated['valor'] = floatval($valor);
        }

        // Se o decurso não for informado manualmente, calcula automaticamente (+30 dias da vistoria)
        if (empty($validated['decurso_prazo']) && !empty($validated['data_vistoria'])) {
            $validated['decurso_prazo'] = Carbon::parse($validated['data_vistoria'])->addDays(30)->toDateString();
        }

        $pericia = ControlePericia::create($validated);

        // Criar agendamento automático se especificado
        if ($request->has('create_agenda') && !empty($validated['data_vistoria'])) {
            Agenda::create([
                'data' => $validated['data_vistoria'],
                'titulo' => 'Vistoria Pericial - Processo: ' . $validated['numero_processo'],
                'status' => 'Agendado',
                'local' => $validated['vara'] ?? 'Local da vistoria',
                'nota' => 'Perícia criada automaticamente para o processo: ' . $validated['numero_processo'],
            ]);

            return redirect()->route('controle-pericias.index')
                ->with('success', 'Perícia criada com sucesso!')
                ->with('agenda_criada', true);
        }

        return redirect()->route('controle-pericias.index')
            ->with('success', 'Perícia criada com sucesso!');
    }

    /**
     * Display the specified pericia.
     */
    public function show(ControlePericia $controlePericia): View
    {
        if (!auth()->user()->can('view pericias')) {
            abort(403, 'Você não tem permissão para visualizar perícias.');
        }

        $controlePericia->load('checklistDocumentos');
        $checklistItems = ControlePericia::checklistItemsByTipo($controlePericia->tipo_pericia);
        $checklistAgendaMap = $this->buildChecklistAgendaMap($controlePericia, $checklistItems);

        return view('controle-pericias.show', compact('controlePericia', 'checklistItems', 'checklistAgendaMap'));
    }

    /**
     * Show the form for editing the specified pericia.
     */
    public function edit(ControlePericia $controlePericia): View
    {
        if (!auth()->user()->can('edit pericias')) {
            abort(403, 'Você não tem permissão para editar perícias.');
        }

        $responsaveis = MembrosEquipeTecnica::where('status', true)->orderBy('nome')->get();
        $statusOptions = [
            'Em Andamento',
            'Concluído',
            'Cancelado',
            'Aguardando Documentação',
            'Aguardando Pagamento',
            'Aguardando Vistoria',
            'Em Redação',
            'Entregue'
        ];

        $controlePericia->load('checklistDocumentos');
        $checklistItems = ControlePericia::checklistItemsByTipo($controlePericia->tipo_pericia);
        $checklistAgendaMap = $this->buildChecklistAgendaMap($controlePericia, $checklistItems);

        return view('controle-pericias.edit', compact('controlePericia', 'responsaveis', 'statusOptions', 'checklistItems', 'checklistAgendaMap'));
    }

    public function agendarRecebimentoChecklistDocumento(Request $request, ControlePericia $controlePericia)
    {
        if (!auth()->user()->can('create agenda')) {
            return response()->json(['success' => false, 'message' => 'Você não tem permissão para criar compromissos na agenda.'], 403);
        }

        if (!auth()->user()->can('view pericias')) {
            return response()->json(['success' => false, 'message' => 'Você não tem permissão para acessar esta perícia.'], 403);
        }

        $validated = $request->validate([
            'item_nome' => 'required|string|max:255',
            'orgao_responsavel' => 'required|string|max:255',
            'data_prevista_entrega' => 'required|date|after_or_equal:today',
            'observacoes' => 'nullable|string|max:5000',
        ], [
            'orgao_responsavel.required' => 'O órgão responsável é obrigatório.',
            'data_prevista_entrega.required' => 'A data prevista de entrega é obrigatória.',
            'data_prevista_entrega.after_or_equal' => 'A data prevista de entrega não pode ser anterior à data atual.',
        ]);

        $itemNome = trim($validated['item_nome']);
        $itensPermitidos = ControlePericia::checklistItemsByTipo($controlePericia->tipo_pericia);

        if (!in_array($itemNome, $itensPermitidos, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Item de checklist inválido para este tipo de perícia.',
            ], 422);
        }

        $tipoAguardandoDocumento = \App\Models\TipoDeEvento::query()
            ->whereRaw('LOWER(nome) = ?', ['aguardando documento'])
            ->orWhereRaw('LOWER(codigo) = ?', ['aguardando_documento'])
            ->first();

        if (!$tipoAguardandoDocumento) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível criar o compromisso porque o tipo "Aguardando Documento" não está cadastrado.',
            ], 422);
        }

        $compromissoExistente = Agenda::query()
            ->where('controle_pericia_id', $controlePericia->id)
            ->where('checklist_item_nome', $itemNome)
            ->where('tipo', $tipoAguardandoDocumento->codigo)
            ->first();

        if ($compromissoExistente) {
            return response()->json([
                'success' => false,
                'message' => 'Este documento já possui um compromisso agendado.',
                'agenda' => [
                    'id' => $compromissoExistente->id,
                    'edit_url' => route('agenda.edit', $compromissoExistente->id),
                    'show_url' => route('agenda.show', $compromissoExistente->id),
                ],
            ], 409);
        }

        $observacoes = trim((string) ($validated['observacoes'] ?? ''));
        $descricaoLinhas = [
            'Documento: ' . $itemNome,
            'Órgão responsável: ' . $validated['orgao_responsavel'],
            'Processo: ' . ($controlePericia->numero_processo ?: 'Não informado'),
            'Referência da perícia: #' . $controlePericia->id,
        ];

        if ($observacoes !== '') {
            $descricaoLinhas[] = 'Observações: ' . $observacoes;
        }

        $agenda = Agenda::create([
            'titulo' => 'Receber documento: ' . $itemNome,
            'tipo' => $tipoAguardandoDocumento->codigo,
            'data' => Carbon::parse($validated['data_prevista_entrega'])->toDateString(),
            'hora' => '00:00:00',
            'status' => 'Agendada',
            'nota' => implode("\n", $descricaoLinhas),
            'num_processo' => $controlePericia->numero_processo,
            'requerente_id' => $controlePericia->requerente_id,
            'requerido' => $controlePericia->requerido,
            'controle_pericia_id' => $controlePericia->id,
            'checklist_item_nome' => $itemNome,
            'orgao_responsavel' => $validated['orgao_responsavel'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Compromisso criado na agenda com sucesso.',
            'agenda' => [
                'id' => $agenda->id,
                'edit_url' => route('agenda.edit', $agenda->id),
                'show_url' => route('agenda.show', $agenda->id),
            ],
        ]);
    }

    /**
     * Update the specified pericia in storage.

     */
    public function update(Request $request, ControlePericia $controlePericia): RedirectResponse
    {
        if (!auth()->user()->can('edit pericias')) {
            abort(403, 'Você não tem permissão para editar perícias.');
        }

        $validated = $request->validate([
            'numero_processo' => 'required|string|max:255',
            'requerente_id' => 'required|exists:clientes,id',
            'requerido' => 'required|string|max:255',
            'vara' => 'required|string|max:255',
            'tipo_pericia' => 'required|string|max:255',
            'data_nomeacao' => 'nullable|date',
            'status_atual' => 'required|string|max:255',
            'data_vistoria' => 'nullable|date',
            'prazo_final' => 'nullable|date',
            'decurso_prazo' => 'nullable|date',
            'valor' => 'nullable|string',
            'responsavel_tecnico_id' => 'nullable|exists:membros_equipe_tecnicas,id',
            'protocolo_responsavel_id' => 'nullable|exists:membros_equipe_tecnicas,id',
            'cadeia_dominial' => 'nullable|string',
            'protocolo' => 'nullable|string|max:255',
            'data_protocolo' => 'nullable|date',
            'observacoes' => 'nullable|string',
            'checklist_arquivos' => 'nullable|array',
            'checklist_arquivos.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:15360',
            'checklist_nomes' => 'nullable|array',
        ]);

        // Conversão do valor se fornecido
        if (!empty($validated['valor'])) {
            $valor = str_replace(['R$', '.', ','], ['', '', '.'], $validated['valor']);
            $validated['valor'] = floatval($valor);
        }

        // Se o decurso não for informado manualmente, calcula automaticamente (+30 dias da vistoria)
        if (empty($validated['decurso_prazo']) && !empty($validated['data_vistoria'])) {
            $validated['decurso_prazo'] = Carbon::parse($validated['data_vistoria'])->addDays(30)->toDateString();
        }

        unset($validated['checklist_arquivos'], $validated['checklist_nomes']);

        $controlePericia->update($validated);
        $this->handleChecklistUploads($request, $controlePericia);

        return redirect()->route('controle-pericias.index')
            ->with('success', 'Perícia atualizada com sucesso!');
    }

    /**
     * Update status of the specified pericia via AJAX.
     */
    public function updateStatus(Request $request, ControlePericia $pericia)
    {
        if (!auth()->user()->can('edit pericias')) {
            return response()->json(['success' => false, 'message' => 'Você não tem permissão para editar perícias.'], 403);
        }

        $validated = $request->validate([
            'status_atual' => 'required|string|in:' . implode(',', ControlePericia::statusOptions())
        ]);

        $pericia->update(['status_atual' => $validated['status_atual']]);

        return response()->json([
            'success' => true,
            'message' => 'Fase da perícia atualizada com sucesso!'
        ]);
    }

    /**
     * Remove the specified pericia from storage.
     */
    public function destroy(ControlePericia $controlePericia): RedirectResponse
    {
        if (!auth()->user()->can('delete pericias')) {
            abort(403, 'Você não tem permissão para excluir perícias.');
        }

        foreach ($controlePericia->checklistDocumentos as $documento) {
            if ($documento->arquivo_caminho) {
                Storage::disk('local')->delete($documento->arquivo_caminho);
            }
        }

        $controlePericia->delete();

        return redirect()->route('controle-pericias.index')
            ->with('success', 'Perícia excluída com sucesso!');
    }

    /**
     * Busca clientes para autocomplete (AJAX)
     */
    public function autocompleteClientes(Request $request)
    {
        $search = $request->input('q');
        $clientes = Cliente::where('nome', 'like', "%{$search}%")
            ->orderBy('nome')
            ->limit(10)
            ->get(['id', 'nome']);
        return response()->json($clientes);
    }

    /**
     * Gera o PDF elegante do registro de perícia.
     */
    public function printPdf($id)
    {
        if (!auth()->user()->can('export pericias')) {
            abort(403, 'Você não tem permissão para exportar perícias.');
        }

        $pericia = ControlePericia::with(['responsavelTecnico', 'requerente'])->findOrFail($id);
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);
        $html = view('controle-pericias.print', compact('pericia'))->render();
        $mpdf->WriteHTML($html);
        $filename = 'relatorio_pericia_' . $pericia->id . '.pdf';
        return response($mpdf->Output($filename, 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    /**
     * Gera o PDF da listagem de perícias com os filtros aplicados.
     */
    public function printList(Request $request)
    {
        if (!auth()->user()->can('export pericias')) {
            abort(403, 'Você não tem permissão para exportar perícias.');
        }

        $search = $request->input('search');
        $responsavelId = $request->input('responsavel_tecnico_id');
        $status = $request->input('status_atual');
        $vara = $request->input('vara');
        $tipoPericia = $request->input('tipo_pericia');
        $prazoFinalMes = $request->input('prazo_final_mes');
        $prazoFinalAno = $request->input('prazo_final_ano');
        $idsParam = $request->input('ids');

        $ids = $idsParam ? array_filter(array_map('intval', explode(',', $idsParam))) : [];

        $pericias = ControlePericia::query()
            ->with(['responsavelTecnico', 'requerente'])
            ->when(!empty($ids), function ($query) use ($ids) {
                return $query->whereIn('id', $ids);
            })
            ->when(empty($ids) && $search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('numero_processo', 'like', "%{$search}%")
                      ->orWhere('vara', 'like', "%{$search}%")
                      ->orWhere('requerido', 'like', "%{$search}%")
                      ->orWhereHas('requerente', function($q) use ($search) {
                          $q->where('nome', 'like', "%{$search}%");
                      });
                });
            })
            ->when(empty($ids) && $vara, function ($query, $vara) {
                return $query->where('vara', $vara);
            })
            ->when(empty($ids) && $responsavelId, function ($query, $responsavelId) {
                return $query->where('responsavel_tecnico_id', $responsavelId);
            })
            ->when(empty($ids) && $status, function ($query, $status) {
                return $query->where('status_atual', $status);
            })
            ->when(empty($ids) && $tipoPericia, function ($query, $tipoPericia) {
                return $query->where('tipo_pericia', $tipoPericia);
            })
            ->when(empty($ids) && $prazoFinalMes, function ($query) use ($prazoFinalMes) {
                return $query->whereMonth('prazo_final', $prazoFinalMes);
            })
            ->when(empty($ids) && $prazoFinalAno, function ($query) use ($prazoFinalAno) {
                return $query->whereYear('prazo_final', $prazoFinalAno);
            })
            ->latest()
            ->get();

        // Buscar informações dos filtros aplicados para exibir no cabeçalho do relatório
        $responsavelNome = null;
        if ($responsavelId) {
            $responsavel = MembrosEquipeTecnica::find($responsavelId);
            $responsavelNome = $responsavel ? $responsavel->nome : null;
        }

        $filtrosAplicados = [
            'search' => $search,
            'vara' => $vara,
            'responsavel' => $responsavelNome,
            'status' => $status,
            'tipo_pericia' => $tipoPericia,
            'mes' => $prazoFinalMes,
            'ano' => $prazoFinalAno
        ];

        // Processar colunas selecionadas
        $selectedColumns = $request->input('columns');
        $columns = [];
        if ($selectedColumns) {
            $columns = explode(',', $selectedColumns);
        } else {
            // Se nenhuma coluna foi selecionada, mostrar todas por padrão
            $columns = ['processo', 'requerente', 'requerido', 'vara', 'responsavel', 'tipo_pericia', 'status', 'laudo_entregue'];
        }

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L', // Paisagem para melhor visualização da tabela
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);

        $html = view('controle-pericias.print-list', compact('pericias', 'filtrosAplicados', 'columns'))->render();
        $mpdf->WriteHTML($html);
        
        $filename = 'listagem_pericias_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return response($mpdf->Output($filename, 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function downloadChecklistDocumento(ControlePericia $controlePericia, ChecklistDocumentoPericia $documento)
    {
        if (!auth()->user()->can('view pericias')) {
            abort(403, 'Você não tem permissão para visualizar perícias.');
        }

        if ((int) $documento->controle_pericia_id !== (int) $controlePericia->id) {
            abort(404);
        }

        if (empty($documento->arquivo_caminho)) {
            return redirect()->back()->with('error', 'Este documento não possui arquivo para visualização.');
        }

        $arquivoCaminho = (string) $documento->arquivo_caminho;
        $caminhoAbsoluto = Str::startsWith($arquivoCaminho, storage_path('app'))
            ? $arquivoCaminho
            : Storage::disk('local')->path($arquivoCaminho);

        if (!is_file($caminhoAbsoluto)) {
            // Evita novos erros para documentos com caminho quebrado.
            $documento->update([
                'arquivo_nome' => null,
                'arquivo_caminho' => null,
                'arquivo_mime' => null,
                'arquivo_tamanho' => null,
            ]);

            return redirect()->back()->with('error', 'Arquivo não encontrado. O item foi reativado para novo envio.');
        }

        return response()->file($caminhoAbsoluto);
    }

    public function destroyChecklistDocumento(ControlePericia $controlePericia, ChecklistDocumentoPericia $documento)
    {
        if (!auth()->user()->can('edit pericias')) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Você não tem permissão para editar perícias.'], 403);
            }
            abort(403, 'Você não tem permissão para editar perícias.');
        }

        if ((int) $documento->controle_pericia_id !== (int) $controlePericia->id) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Documento não encontrado para esta perícia.'], 404);
            }
            abort(404);
        }

        if ($documento->arquivo_caminho) {
            Storage::disk('local')->delete($documento->arquivo_caminho);
        }

        $documento->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Documento do checklist removido com sucesso.',
            ]);
        }

        return redirect()->back()->with('success', 'Documento do checklist removido com sucesso.');
    }

    public function uploadChecklistDocumento(Request $request, ControlePericia $controlePericia)
    {
        if (!auth()->user()->can('edit pericias')) {
            return response()->json(['success' => false, 'message' => 'Você não tem permissão para editar perícias.'], 403);
        }

        $validated = $request->validate([
            'item_nome' => 'required|string|max:255',
            'arquivo' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:15360',
        ]);

        $itemNome = trim($validated['item_nome']);
        $itensPermitidos = ControlePericia::checklistItemsByTipo($controlePericia->tipo_pericia);
        $isUltimaDecisao = ChecklistDocumentoPericia::isUltimaDecisaoItem($itemNome);

        if (!$isUltimaDecisao && !in_array($itemNome, $itensPermitidos, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Item de checklist inválido para este tipo de perícia.',
            ], 422);
        }

        $arquivo = $request->file('arquivo');

        $arquivoLimpo = Str::slug(pathinfo($arquivo->getClientOriginalName(), PATHINFO_FILENAME));
        $arquivoExtensao = $arquivo->getClientOriginalExtension();
        $nomeArquivo = ($arquivoLimpo ?: 'documento') . '-' . now()->format('YmdHis') . '-' . Str::lower(Str::random(6)) . '.' . $arquivoExtensao;
        $caminho = $arquivo->storeAs('pericias/checklist/' . $controlePericia->id, $nomeArquivo, 'local');

        $documento = $controlePericia->checklistDocumentos()->create([
            'item_nome' => $itemNome,
            'arquivo_nome' => $arquivo->getClientOriginalName(),
            'arquivo_caminho' => $caminho,
            'arquivo_mime' => $arquivo->getMimeType(),
            'arquivo_tamanho' => $arquivo->getSize(),
            'nao_necessario' => false,
            'enviado_por' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Documento salvo com sucesso.',
            'documento' => [
                'id' => $documento->id,
                'arquivo_nome' => $documento->arquivo_nome,
            ],
        ]);
    }

    public function toggleChecklistNaoNecessario(Request $request, ControlePericia $controlePericia)
    {
        if (!auth()->user()->can('edit pericias')) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Você não tem permissão para editar perícias.'], 403);
            }
            abort(403, 'Você não tem permissão para editar perícias.');
        }

        $validated = $request->validate([
            'item_nome' => 'required|string|max:255',
            'acao' => 'required|string|in:marcar,desmarcar',
        ]);

        $itemNome = trim($validated['item_nome']);

        if (ChecklistDocumentoPericia::isUltimaDecisaoItem($itemNome)) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Esta área não suporta documento marcado como «não necessário».'], 422);
            }
            return redirect()->back()->with('error', 'Esta área não suporta documento marcado como «não necessário».');
        }

        $itensPermitidos = ControlePericia::checklistItemsByTipo($controlePericia->tipo_pericia);

        if (!in_array($itemNome, $itensPermitidos, true)) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Item de checklist inválido para este tipo de perícia.'], 422);
            }
            return redirect()->back()->with('error', 'Item de checklist inválido para este tipo de perícia.');
        }

        $documentosDoItem = $controlePericia->checklistDocumentos()->where('item_nome', $itemNome)->get();

        if ($validated['acao'] === 'marcar') {
            foreach ($documentosDoItem as $doc) {
                if ($doc->arquivo_caminho) {
                    Storage::disk('local')->delete($doc->arquivo_caminho);
                }
                $doc->delete();
            }

            $controlePericia->checklistDocumentos()->create([
                'item_nome' => $itemNome,
                'nao_necessario' => true,
                'enviado_por' => Auth::id(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item marcado como não necessário.',
                    'acao_aplicada' => 'marcar',
                ]);
            }

            return redirect()->back()->with('success', 'Item marcado como não necessário.');
        }

        foreach ($documentosDoItem as $doc) {
            if ($doc->nao_necessario && empty($doc->arquivo_caminho)) {
                $doc->delete();
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item reativado para envio de documento.',
                'acao_aplicada' => 'desmarcar',
            ]);
        }

        return redirect()->back()->with('success', 'Item reativado para envio de documento.');
    }

    public function updateChecklistObservacoes(
        Request $request,
        ControlePericia $controlePericia,
        ChecklistDocumentoPericia $documento
    ) {
        if (!auth()->user()->can('edit pericias')) {
            return response()->json(['success' => false, 'message' => 'Você não tem permissão para editar perícias.'], 403);
        }

        if ((int) $documento->controle_pericia_id !== (int) $controlePericia->id) {
            abort(404);
        }

        if (empty($documento->arquivo_caminho)) {
            return response()->json([
                'success' => false,
                'message' => 'Observações só podem ser adicionadas após o envio do documento.',
            ], 422);
        }

        $validated = $request->validate([
            'observacoes' => 'nullable|string|max:5000',
        ]);

        $documento->update([
            'observacoes' => $validated['observacoes'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Observações salvas com sucesso.',
            'observacoes' => $documento->observacoes,
        ]);
    }

    private function handleChecklistUploads(Request $request, ControlePericia $controlePericia): void
    {
        $checklistNomes = $request->input('checklist_nomes', []);
        $arquivos = $request->file('checklist_arquivos', []);

        if (empty($checklistNomes) || empty($arquivos)) {
            return;
        }

        $itensPermitidos = ControlePericia::checklistItemsByTipo($controlePericia->tipo_pericia);

        foreach ($arquivos as $itemKey => $arquivo) {
            if (!$arquivo || !isset($checklistNomes[$itemKey])) {
                continue;
            }

            $itemNome = trim((string) $checklistNomes[$itemKey]);

            if ($itemNome === '') {
                continue;
            }

            if (! in_array($itemNome, $itensPermitidos, true)) {
                continue;
            }

            $arquivoLimpo = Str::slug(pathinfo($arquivo->getClientOriginalName(), PATHINFO_FILENAME));
            $arquivoExtensao = $arquivo->getClientOriginalExtension();
            $nomeArquivo = ($arquivoLimpo ?: 'documento') . '-' . now()->format('YmdHis') . '-' . Str::lower(Str::random(6)) . '.' . $arquivoExtensao;
            $caminho = $arquivo->storeAs('pericias/checklist/' . $controlePericia->id, $nomeArquivo, 'local');

            $controlePericia->checklistDocumentos()->create([
                'item_nome' => $itemNome,
                'arquivo_nome' => $arquivo->getClientOriginalName(),
                'arquivo_caminho' => $caminho,
                'arquivo_mime' => $arquivo->getMimeType(),
                'arquivo_tamanho' => $arquivo->getSize(),
                'enviado_por' => Auth::id(),
            ]);
        }
    }

    private function buildChecklistAgendaMap(ControlePericia $controlePericia, array $checklistItems): array
    {
        if (empty($checklistItems)) {
            return [];
        }

        $agendas = Agenda::query()
            ->where('controle_pericia_id', $controlePericia->id)
            ->whereIn('checklist_item_nome', $checklistItems)
            ->get(['id', 'checklist_item_nome', 'data', 'tipo']);

        $map = [];
        foreach ($agendas as $agenda) {
            if (!$agenda->checklist_item_nome || isset($map[$agenda->checklist_item_nome])) {
                continue;
            }

            $map[$agenda->checklist_item_nome] = [
                'id' => $agenda->id,
                'data' => $agenda->data,
                'show_url' => route('agenda.show', $agenda->id),
                'edit_url' => route('agenda.edit', $agenda->id),
            ];
        }

        return $map;
    }
}
