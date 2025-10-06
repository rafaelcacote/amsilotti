<?php

namespace App\Http\Controllers;

use App\Models\EntregaLaudoFinanceiro;
use App\Models\ControlePericia;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class EntregaLaudoFinanceiroController extends Controller
{
    /**
     * Display a listing of the entrega laudos financeiro.
     */
    public function index(Request $request): View
    {
        if (!auth()->user()->can('view pericias')) {
            abort(403, 'Você não tem permissão para visualizar registros financeiros de laudos.');
        }

        $search = $request->input('search');
        $status = $request->input('status');
        $vara = $request->input('vara');
        $upj = $request->input('upj');
        $mesPagamento = $request->input('mes_pagamento');
        $anoPagamento = $request->input('ano_pagamento');
        $financeiro = $request->input('financeiro');

        $entregasLaudos = EntregaLaudoFinanceiro::query()
            ->with(['controlePericia.requerente', 'controlePericia.responsavelTecnico'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('controlePericia', function ($q) use ($search) {
                    $q->where('numero_processo', 'like', "%{$search}%")
                      ->orWhere('vara', 'like', "%{$search}%")
                      ->orWhereHas('requerente', function ($q2) use ($search) {
                          $q2->where('nome', 'like', "%{$search}%");
                      });
                })->orWhere('financeiro', 'like', "%{$search}%")
                  ->orWhere('sei', 'like', "%{$search}%")
                  ->orWhere('nf', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($vara, function ($query, $vara) {
                return $query->whereHas('controlePericia', function ($q) use ($vara) {
                    $q->where('vara', $vara);
                });
            })
            ->when($upj, function ($query, $upj) {
                return $query->where('upj', $upj);
            })
            ->when($mesPagamento, function ($query, $mesPagamento) {
                return $query->where('mes_pagamento', $mesPagamento);
            })
            ->when($anoPagamento, function ($query, $anoPagamento) {
                return $query->where('ano_pagamento', $anoPagamento);
            })
            ->when($financeiro, function ($query, $financeiro) {
                return $query->whereRaw('LOWER(financeiro) = ?', [strtolower($financeiro)]);
            })
            ->latest()
            ->paginate(15);

        return view('entrega-laudos-financeiro.index', compact('entregasLaudos', 'search', 'status', 'vara', 'upj', 'mesPagamento', 'anoPagamento', 'financeiro'));
    }

    /**
     * Display the specified entrega laudo financeiro.
     */
    public function show(EntregaLaudoFinanceiro $entregaLaudoFinanceiro): View
    {
        if (!auth()->user()->can('view pericias')) {
            abort(403, 'Você não tem permissão para visualizar registros financeiros de laudos.');
        }

        $entregaLaudoFinanceiro->load(['controlePericia.requerente', 'controlePericia.responsavelTecnico']);

        return view('entrega-laudos-financeiro.show', compact('entregaLaudoFinanceiro'));
    }

    /**
     * Store a newly created entrega laudo financeiro in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if (!auth()->user()->can('create pericias')) {
            return response()->json(['success' => false, 'message' => 'Você não tem permissão para criar registros financeiros.'], 403);
        }

        $validated = $request->validate([
            'controle_pericias_id' => 'required|exists:controle_pericias,id',
            'status' => 'required|string|max:100',
            'upj' => 'nullable|string|max:20',
            'financeiro' => 'nullable|string|max:50',
            'protocolo_laudo' => 'nullable|date',
            'valor' => 'nullable|string',
            'sei' => 'nullable|string|max:50',
            'empenho' => 'nullable|string',
            'nf' => 'nullable|string|max:50',
            'mes_pagamento' => 'nullable|string|max:50',
            'ano_pagamento' => 'nullable|string|max:4',
            'tipo_pessoa' => 'nullable|string',
            'observacao' => 'nullable|string',
        ]);

        // Conversão do valor se fornecido
        if (!empty($validated['valor'])) {
            $valor = str_replace(['R$', '.', ','], ['', '', '.'], $validated['valor']);
            $validated['valor'] = floatval($valor);
        }

        // Verificar se já existe um registro para essa perícia
        $existingRecord = EntregaLaudoFinanceiro::where('controle_pericias_id', $validated['controle_pericias_id'])->first();
        
        if ($existingRecord) {
            return response()->json([
                'success' => false, 
                'message' => 'Já existe um registro financeiro para esta perícia.'
            ], 422);
        }

        $entregaLaudo = EntregaLaudoFinanceiro::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Registro financeiro criado com sucesso!',
            'data' => $entregaLaudo
        ]);
    }

    /**
     * Show the form for editing the specified entrega laudo financeiro.
     */
    public function edit(EntregaLaudoFinanceiro $entregaLaudosFinanceiro): View
    {
        if (!auth()->user()->can('edit pericias')) {
            abort(403, 'Você não tem permissão para editar registros financeiros de laudos.');
        }

        $entregaLaudosFinanceiro->load(['controlePericia.requerente']);

        return view('entrega-laudos-financeiro.edit', compact('entregaLaudosFinanceiro'));
    }

    /**
     * Update the specified entrega laudo financeiro in storage.
     */
    public function update(Request $request, EntregaLaudoFinanceiro $entregaLaudosFinanceiro)
    {
        if (!auth()->user()->can('edit pericias')) {
            abort(403, 'Você não tem permissão para editar registros financeiros.');
        }

        $validated = $request->validate([
            'status' => 'required|string|max:100',
            'upj' => 'nullable|string|max:20',
            'financeiro' => 'nullable|string|max:50',
            'valor' => 'nullable|string',
            'sei' => 'nullable|string|max:50',
            'nf' => 'nullable|string|max:50',
            'mes_pagamento' => 'nullable|string|max:50',
            'ano_pagamento' => 'nullable|digits:4',
            'tipo_pessoa' => 'nullable|string|max:20',
            'empenho' => 'nullable|string|max:45',
            'observacao' => 'nullable|string',
        ]);

        // Conversão do valor se fornecido
        if (!empty($validated['valor'])) {
            $valor = str_replace(['R$', '.', ','], ['', '', '.'], $validated['valor']);
            $validated['valor'] = floatval($valor);
        }

        // Mapear campos para o banco
        $updateData = [
            'status' => $validated['status'],
            'upj' => $validated['upj'],
            'financeiro' => $validated['financeiro'],
            'valor' => $validated['valor'] ?? null,
            'sei' => $validated['sei'],
            'nf' => $validated['nf'],
            'mes_pagamento' => $validated['mes_pagamento'],
            'ano_pagamento' => $validated['ano_pagamento'],
            'empenho' => $validated['empenho'],
            'tipo_pessoa' => $validated['tipo_pessoa'],
            'observacao' => $validated['observacao'],
        ];

        $entregaLaudosFinanceiro->update($updateData);

        // Se for requisição AJAX, retornar JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Registro financeiro atualizado com sucesso!'
            ]);
        }

        return redirect()->route('entrega-laudos-financeiro.index')
            ->with('success', 'Registro financeiro atualizado com sucesso!');
    }

    /**
     * Get details for drawer (AJAX)
     */
    public function getDetails(EntregaLaudoFinanceiro $entregaLaudoFinanceiro): JsonResponse
    {
        try {
            if (!auth()->user()->can('view pericias')) {
                return response()->json(['error' => 'Permissão negada'], 403);
            }

            $entregaLaudoFinanceiro->load(['controlePericia.requerente']);

        $data = [
            'entrega' => [
                'id' => $entregaLaudoFinanceiro->id,
                'status' => $entregaLaudoFinanceiro->status,
                'upj' => $entregaLaudoFinanceiro->upj,
                'financeiro' => $entregaLaudoFinanceiro->financeiro,
                'tipo_pessoa' => $entregaLaudoFinanceiro->tipo_pessoa,
                'valor_formatado' => $entregaLaudoFinanceiro->valor_formatado,
                'protocolo_laudo_formatted' => $entregaLaudoFinanceiro->protocolo_laudo ? 
                    $entregaLaudoFinanceiro->protocolo_laudo->format('d/m/Y') : null,
                'sei' => $entregaLaudoFinanceiro->sei,
                'nf' => $entregaLaudoFinanceiro->nf,
                'mes_pagamento' => $entregaLaudoFinanceiro->mes_pagamento,
                'empenho' => $entregaLaudoFinanceiro->empenho,
                    'observacao' => $entregaLaudoFinanceiro->observacao,
            ],
            'pericia' => null
        ];

        if ($entregaLaudoFinanceiro->controlePericia) {
            $pericia = $entregaLaudoFinanceiro->controlePericia;
            $data['pericia'] = [
                'id' => $pericia->id,
                'numero_processo' => $pericia->numero_processo,
                'vara' => $pericia->vara,
                'tipo_pericia' => $pericia->tipo_pericia,
                'status_atual' => $pericia->status_atual,
                'requerido' => $pericia->requerido,
                'data_nomeacao_formatted' => $pericia->data_nomeacao ? 
                    $pericia->data_nomeacao->format('d/m/Y') : null,
                'data_vistoria_formatted' => $pericia->data_vistoria ? 
                    $pericia->data_vistoria->format('d/m/Y') : null,
                'prazo_final_formatted' => $pericia->prazo_final ? 
                    $pericia->prazo_final->format('d/m/Y') : null,
                'valor_pericia_formatado' => $pericia->valor_formatado ?? null,
                'observacoes' => $pericia->observacoes,
                'requerente' => $pericia->requerente ? [
                    'nome' => $pericia->requerente->nome,
                    'cpf_cnpj' => $pericia->requerente->cpf_cnpj ?? null,
                ] : null
            ];
        }

        return response()->json($data);
        
        } catch (\Exception $e) {
            \Log::error('Erro ao buscar detalhes da entrega de laudo: ' . $e->getMessage());
            return response()->json(['error' => 'Erro interno do servidor'], 500);
        }
    }

    /**
     * Remove the specified entrega laudo financeiro from storage.
     */
    public function destroy(EntregaLaudoFinanceiro $entregaLaudoFinanceiro): RedirectResponse
    {
        if (!auth()->user()->can('delete pericias')) {
            abort(403, 'Você não tem permissão para excluir registros financeiros de laudos.');
        }

        $entregaLaudoFinanceiro->delete();

        return redirect()->route('entrega-laudos-financeiro.index')
            ->with('success', 'Registro financeiro excluído com sucesso!');
    }

    /**
     * Generate a printable list of entrega laudos financeiro.
     */
    public function printList(Request $request)
    {
        if (!auth()->user()->can('view pericias')) {
            abort(403, 'Você não tem permissão para visualizar registros financeiros de laudos.');
        }

        $search = $request->input('search');
        $status = $request->input('status');
        $vara = $request->input('vara');
        $upj = $request->input('upj');
        $mesPagamento = $request->input('mes_pagamento');
        $anoPagamento = $request->input('ano_pagamento');
        $financeiro = $request->input('financeiro');
        $selectedRecords = $request->input('selected_records');

        // Aplicar os mesmos filtros da listagem principal
        $query = EntregaLaudoFinanceiro::query()
            ->with(['controlePericia.requerente', 'controlePericia.responsavelTecnico'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('controlePericia', function ($q) use ($search) {
                    $q->where('numero_processo', 'like', "%{$search}%")
                      ->orWhere('vara', 'like', "%{$search}%")
                      ->orWhereHas('requerente', function ($q2) use ($search) {
                          $q2->where('nome', 'like', "%{$search}%");
                      });
                })->orWhere('financeiro', 'like', "%{$search}%")
                  ->orWhere('sei', 'like', "%{$search}%")
                  ->orWhere('nf', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($vara, function ($query, $vara) {
                return $query->whereHas('controlePericia', function ($q) use ($vara) {
                    $q->where('vara', $vara);
                });
            })
            ->when($upj, function ($query, $upj) {
                return $query->where('upj', $upj);
            })
            ->when($mesPagamento, function ($query, $mesPagamento) {
                return $query->where('mes_pagamento', $mesPagamento);
            })
            ->when($anoPagamento, function ($query, $anoPagamento) {
                return $query->where('ano_pagamento', $anoPagamento);
            })
            ->when($financeiro, function ($query, $financeiro) {
                return $query->whereRaw('LOWER(financeiro) = ?', [strtolower($financeiro)]);
            });

        // Se registros específicos foram selecionados, filtrar apenas esses
        if ($selectedRecords) {
            $recordIds = explode(',', $selectedRecords);
            $query->whereIn('id', $recordIds);
        }

        $entregasLaudos = $query->latest()->get();

        // Preparar os filtros aplicados para exibição no relatório
        $filtrosAplicados = [
            'search' => $search,
            'status' => $status,
            'vara' => $vara,
            'upj' => $upj,
            'mes_pagamento' => $mesPagamento,
            'ano_pagamento' => $anoPagamento,
            'financeiro' => $financeiro,
            'selected_records' => $selectedRecords,
        ];

        // Gerar o HTML da view
        $html = view('entrega-laudos-financeiro.print-list', compact('entregasLaudos', 'filtrosAplicados'))->render();

        // Configurar mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L', // Formato paisagem para acomodar mais colunas
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'default_font' => 'Arial'
        ]);

        // Escrever o HTML no PDF
        $mpdf->WriteHTML($html);

        // Gerar nome do arquivo com data e hora
        $filename = 'relatorio-financeiro-laudos-' . date('Y-m-d-H-i-s') . '.pdf';

        // Retornar o PDF para download
        return response($mpdf->Output($filename, 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }
}