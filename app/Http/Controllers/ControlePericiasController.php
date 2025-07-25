<?php

namespace App\Http\Controllers;

use App\Models\ControlePericia;
use App\Models\MembrosEquipeTecnica;
use App\Models\Cliente;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Mpdf\Mpdf;

class ControlePericiasController extends Controller
{
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
        $tipoPericia = $request->input('tipo_pericia');

        $pericias = ControlePericia::query()
            ->with(['responsavelTecnico', 'requerente'])
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
            ->when($responsavelId, function ($query, $responsavelId) {
                return $query->where('responsavel_tecnico_id', $responsavelId);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status_atual', $status);
            })
            ->when($tipoPericia, function ($query, $tipoPericia) {
                return $query->where('tipo_pericia', $tipoPericia);
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
        
        return view('controle-pericias.index', compact('pericias', 'responsaveis', 'search', 'responsavelId', 'status', 'tipoPericia', 'statusOptions'));
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
            'numero_processo' => 'required|string|max:255',
            'requerente_id' => 'required|exists:clientes,id',
            'requerido' => 'required|string|max:255',
            'vara' => 'required|string|max:255',
            'tipo_pericia' => 'required|string|max:255',
            'data_nomeacao' => 'nullable|date',
            'status_atual' => 'required|string|max:255',
            'data_vistoria' => 'nullable|date',
            'prazo_final' => 'nullable|date',
            'valor' => 'nullable|string',
            'responsavel_tecnico_id' => 'nullable|exists:membros_equipe_tecnicas,id',
            'protocolo_responsavel_id' => 'nullable|exists:membros_equipe_tecnicas,id',
            'cadeia_dominial' => 'nullable|string',
            'protocolo' => 'nullable|string|max:255',
            'data_protocolo' => 'nullable|date',
            'observacoes' => 'nullable|string',
        ]);

        // Conversão do valor se fornecido
        if (!empty($validated['valor'])) {
            $valor = str_replace(['R$', '.', ','], ['', '', '.'], $validated['valor']);
            $validated['valor'] = floatval($valor);
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

        return view('controle-pericias.show', compact('controlePericia'));
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

        return view('controle-pericias.edit', compact('controlePericia', 'responsaveis', 'statusOptions'));
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
            'valor' => 'nullable|string',
            'responsavel_tecnico_id' => 'nullable|exists:membros_equipe_tecnicas,id',
            'protocolo_responsavel_id' => 'nullable|exists:membros_equipe_tecnicas,id',
            'cadeia_dominial' => 'nullable|string',
            'protocolo' => 'nullable|string|max:255',
            'data_protocolo' => 'nullable|date',
            'observacoes' => 'nullable|string',
        ]);

        // Conversão do valor se fornecido
        if (!empty($validated['valor'])) {
            $valor = str_replace(['R$', '.', ','], ['', '', '.'], $validated['valor']);
            $validated['valor'] = floatval($valor);
        }

        $controlePericia->update($validated);

        return redirect()->route('controle-pericias.index')
            ->with('success', 'Perícia atualizada com sucesso!');
    }

    /**
     * Remove the specified pericia from storage.
     */
    public function destroy(ControlePericia $controlePericia): RedirectResponse
    {
        if (!auth()->user()->can('delete pericias')) {
            abort(403, 'Você não tem permissão para excluir perícias.');
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
}
