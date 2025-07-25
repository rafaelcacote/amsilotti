<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Cliente;
use App\Models\Bairro;
use App\Models\TipoDeEvento;
use App\Models\Vistoria;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view agenda')) {
            abort(403, 'Você não tem permissão para visualizar a agenda.');
        }

        $agendas = Agenda::orderBy('data', 'desc')->paginate(10);
        return view('agenda.index', compact('agendas'));
    }

    public function create()
    {
        if (!auth()->user()->can('create agenda')) {
            abort(403, 'Você não tem permissão para criar compromissos na agenda.');
        }

        $bairros = Bairro::orderBy('nome')->get();
        $tipos = TipoDeEvento::getForSelect();
        $status = Agenda::getStatusValues();

        // Se há um requerente_id old, buscar o nome do cliente
        $requerenteNome = '';
        if (old('requerente_id')) {
            $cliente = Cliente::find(old('requerente_id'));
            if ($cliente) {
                $requerenteNome = $cliente->nome;
            }
        }

        return view('agenda.create', compact('bairros', 'tipos', 'status', 'requerenteNome'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create agenda')) {
            abort(403, 'Você não tem permissão para criar compromissos na agenda.');
        }

        // Validação básica para todos os tipos
        $rules = [
            'tipo' => 'required',
            'data' => 'required|date',
        ];

        // Validações específicas baseadas no tipo
        if ($request->tipo === 'vistoria') {
            // Para vistoria, todos os campos são obrigatórios
            $rules = array_merge($rules, [
                'status' => 'required',
                'num_processo' => 'required|string|max:50',
                'endereco' => 'required|string|max:255',
                'bairro' => 'required|string|max:100',
                'cidade' => 'required|string|max:100',
                'estado' => 'required|string|size:2',
                'hora' => 'nullable',
                'requerente_id' => 'nullable|integer|exists:clientes,id',
                'requerido' => 'nullable|string|max:200',
                'num' => 'nullable|string|max:10',
                'cep' => 'nullable|string|max:10',
                'nota' => 'nullable|string',
            ]);
        } else {
            // Para outros tipos, apenas título, data e hora são obrigatórios
            $rules = array_merge($rules, [
                'titulo' => 'required|string|max:200',
                'hora' => 'required',
                'local' => 'nullable|string|max:200',
                'nota' => 'nullable|string',
                'status' => 'required',
            ]);
        }

        // Mensagens personalizadas
        $messages = [
            'tipo.required' => 'O tipo é obrigatório.',
            'data.required' => 'A data é obrigatória.',
            'data.date' => 'A data deve ser uma data válida.',
            'titulo.required' => 'O título é obrigatório.',
            'hora.required' => 'A hora é obrigatória.',
            'status.required' => 'O status é obrigatório.',
            'num_processo.required' => 'O número do processo é obrigatório para vistorias.',
            'endereco.required' => 'O endereço é obrigatório para vistorias.',
            'bairro.required' => 'O bairro é obrigatório para vistorias.',
            'cidade.required' => 'A cidade é obrigatória para vistorias.',
            'estado.required' => 'O estado é obrigatório para vistorias.',
            'estado.size' => 'O estado deve ter exatamente 2 caracteres.',
        ];

        // Validar dados
        $data = $request->validate($rules, $messages);

        // Verificar se é uma vistoria e se já existe uma com o mesmo número de processo
        if ($data['tipo'] === 'vistoria' && !empty($data['num_processo'])) {
            $vistoriaExistente = Vistoria::where('num_processo', $data['num_processo'])->first();

            if ($vistoriaExistente) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['num_processo' => 'Já existe uma vistoria cadastrada com este número de processo.']);
            }
        }

        // Criar o registro na agenda
        $agenda = Agenda::create($data);

        // Se for uma vistoria, criar também o registro na tabela vistorias
        if ($data['tipo'] === 'vistoria') {
            Vistoria::create([
                'agenda_id' => $agenda->id,
                'num_processo' => $data['num_processo'],
                'requerido' => $data['requerido'],
                'requerente_id' => $data['requerente_id'],
                'endereco' => $data['endereco'],
                'num' => $data['num'],
                'bairro' => $data['bairro'],
                'cidade' => $data['cidade'],
                'estado' => $data['estado'],
                'status' => 'agendada',
            ]);
        }

        return redirect()->route('agenda.index')->with('success', 'Agenda criada com sucesso!');
    }

    public function show(Agenda $agenda)
    {
        if (!auth()->user()->can('view agenda')) {
            abort(403, 'Você não tem permissão para visualizar compromissos da agenda.');
        }

        return view('agenda.show', compact('agenda'));
    }

    public function edit(Agenda $agenda)
    {
        if (!auth()->user()->can('edit agenda')) {
            abort(403, 'Você não tem permissão para editar compromissos da agenda.');
        }

        $bairros = Bairro::orderBy('nome')->get();
        $tipos = TipoDeEvento::getForSelect();
        $status = Agenda::getStatusValues();
        return view('agenda.edit', compact('agenda', 'bairros', 'tipos', 'status'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        if (!auth()->user()->can('edit agenda')) {
            abort(403, 'Você não tem permissão para editar compromissos da agenda.');
        }

        // Debugging info
        \Log::info('Updating agenda', $request->all());

        $data = $request->validate([
            'tipo' => 'required',
            'titulo' => 'nullable|string|max:200',
            'num_processo' => 'nullable|string|max:50',
            'requerido' => 'nullable|string|max:200',
            'requerido_id' => 'nullable|integer|exists:clientes,id',
            'requerente_id' => 'nullable|integer|exists:clientes,id',
            'data' => 'required|date',
            'hora' => 'nullable',
            'local' => 'nullable|string|max:200',
            'endereco' => 'nullable|string|max:255',
            'num' => 'nullable|string|max:10',
            'bairro' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:10',
            'status' => 'required',
            'nota' => 'nullable|string',
        ]);

        \Log::info('Validated data', $data);

        $agenda->update($data);
        \Log::info('Agenda updated', $agenda->toArray());

        return redirect()->route('agenda.index')->with('success', 'Agenda atualizada com sucesso!');
    }

    public function destroy(Agenda $agenda)
    {
        if (!auth()->user()->can('delete agenda')) {
            abort(403, 'Você não tem permissão para excluir compromissos da agenda.');
        }

        // Verificar se é uma vistoria - não pode ser excluída pois tem registro relacionado
        if ($agenda->tipo === 'vistoria') {
            return redirect()->route('agenda.index')
                ->with('error', 'Não é possível excluir agendas do tipo "Vistoria" pois possuem registros relacionados no sistema.');
        }

        $agenda->delete();
        return redirect()->route('agenda.index')->with('success', 'Compromisso excluído com sucesso!');
    }

    // Autocomplete para clientes (requerente)
    public function searchCliente(Request $request)
    {
        $search = $request->get('q');
        $clientes = Cliente::where('nome', 'like', "%$search%")
            ->select('id', 'nome as text')
            ->limit(10)
            ->get();
        return response()->json(['results' => $clientes]);
    }

    // Método para obter eventos do calendário
    public function getEventos(Request $request)
    {
        $agendas = Agenda::with(['requerente', 'tipoDeEvento'])->get();

        $eventos = $agendas->map(function ($agenda) {
            return [
                'id' => $agenda->id,
                'title' => $agenda->tipo_nome,
                'start' => $agenda->data . ($agenda->hora ? 'T' . $agenda->hora : ''),
                'backgroundColor' => $agenda->tipo_cor,
                'borderColor' => $agenda->tipo_cor,
                'extendedProps' => [
                    'tipo' => $agenda->tipo,
                    'tipo_nome' => $agenda->tipo_nome,
                    'status' => $agenda->status,
                    'local' => $agenda->local,
                    'endereco' => $agenda->endereco,
                    'num' => $agenda->num,
                    'bairro' => $agenda->bairro,
                    'cidade' => $agenda->cidade,
                    'estado' => $agenda->estado,
                    'cep' => $agenda->cep,
                    'requerido' => $agenda->requerido,
                    'requerente_nome' => $agenda->requerente ? $agenda->requerente->nome : null,
                    'nota' => $agenda->nota,
                    'num_processo' => $agenda->num_processo
                ]
            ];
        });

        return response()->json($eventos);
    }

    public function imprimir($id)
    {
        $this->authorize('print agenda');

        $agenda = Agenda::findOrFail($id);

        // Configurar o MPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 15,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);

        // Configurar cabeçalho com logo
        $logoPath = public_path('img/cabecalho_detalhescompromisso.jpg'); // ou .png dependendo do formato
        if (!file_exists($logoPath)) {
            $logoPath = public_path('img/cabecalho_detalhescompromisso.png');
        }

        $html = $this->generateEventHtml($agenda, $logoPath);

        $mpdf->WriteHTML($html);

        // Definir nome do arquivo baseado no tipo de evento
        $filename = 'evento_' . $agenda->id . '_' . date('Y-m-d') . '.pdf';
        if ($agenda->tipo === 'vistoria' && $agenda->num_processo) {
            $filename = 'vistoria_' . str_replace(['/', '\\', ' '], '_', $agenda->num_processo) . '.pdf';
        }

        return $mpdf->Output($filename, 'I'); // 'I' para exibir no navegador
    }

    private function generateEventHtml($agenda, $logoPath)
    {
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = base64_encode(file_get_contents($logoPath));
            $logoMime = mime_content_type($logoPath);
            $logoBase64 = 'data:' . $logoMime . ';base64,' . $logoData;
        }

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
                .header { text-align: center; margin-bottom: 30px; }
                .header img { max-width: 100%; height: auto; }
                .title { color: #2c3e50; font-size: 24px; font-weight: bold; margin: 20px 0; text-align: center; }
                .info-section { margin-bottom: 25px; }
                .info-title { color: #34495e; font-size: 16px; font-weight: bold; margin-bottom: 10px; border-bottom: 2px solid #3498db; padding-bottom: 5px; }
                .info-row { margin-bottom: 8px; }
                .info-label { font-weight: bold; color: #2c3e50; display: inline-block; width: 150px; }
                .info-value { color: #34495e; }
                .badge { background-color: #3498db; color: white; padding: 3px 8px; border-radius: 4px; font-size: 12px; }
                .badge.success { background-color: #27ae60; }
                .badge.danger { background-color: #e74c3c; }
                .badge.warning { background-color: #f39c12; color: #2c3e50; }
                .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #7f8c8d; }
                table { width: 100%; border-collapse: collapse; margin-top: 15px; }
                td { padding: 8px; vertical-align: top; }
                .notes { background-color: #f8f9fa; padding: 15px; border-left: 4px solid #3498db; margin-top: 20px; }
            </style>
        </head>
        <body>';

        if ($logoBase64) {
            $html .= '<div class="header"><img src="' . $logoBase64 . '" alt="Cabeçalho"></div>';
        }

        if ($agenda->tipo === 'vistoria') {

            $html .= $this->generateVistoriaHtml($agenda);
        } else {

            $html .= $this->generateCompromissoHtml($agenda);
        }

        $html .= '<div class="footer">Documento gerado em ' . date('d/m/Y H:i:s') . '</div>';
        $html .= '</body></html>';

        return $html;
    }

    private function generateVistoriaHtml($agenda)
    {
        $statusClass = $agenda->status === 'Realizada' ? 'success' : ($agenda->status === 'Cancelada' ? 'danger' : 'warning');

        return '
        <div class="info-section">
            <div class="info-title">Informações do Processo</div>
            <table>
                <tr>
                    <td><span class="info-label">Número do Processo:</span></td>
                    <td><span class="info-value">' . ($agenda->num_processo ?: '-') . '</span></td>
                </tr>
                <tr>
                    <td><span class="info-label">Status:</span></td>
                    <td><span class="badge ' . $statusClass . '">' . ($agenda->status ?: '-') . '</span></td>
                </tr>
                <tr>
                    <td><span class="info-label">Data da Vistoria:</span></td>
                    <td><span class="info-value">' . ($agenda->data ? \Carbon\Carbon::parse($agenda->data)->format('d/m/Y') : '-') . '</span></td>
                </tr>
                <tr>
                    <td><span class="info-label">Hora da Vistoria:</span></td>
                    <td><span class="info-value">' . ($agenda->hora ? \Carbon\Carbon::parse($agenda->hora)->format('H:i') : '-') . '</span></td>
                </tr>
            </table>
        </div>

        <div class="info-section">
            <div class="info-title">Partes Envolvidas</div>
            <table>
                <tr>
                    <td><span class="info-label">Requerido:</span></td>
                    <td><span class="info-value">' . ($agenda->requerido ?: '-') . '</span></td>
                </tr>
                <tr>
                    <td><span class="info-label">Requerente:</span></td>
                    <td><span class="info-value">' . ($agenda->requerente ? $agenda->requerente->nome : '-') . '</span></td>
                </tr>
            </table>
        </div>

        <div class="info-section">
            <div class="info-title">Endereço da Vistoria</div>
            <table>
                <tr>
                    <td><span class="info-label">Endereço:</span></td>
                    <td><span class="info-value">' . ($agenda->endereco ?: '-') . '</span></td>
                </tr>
                <tr>
                    <td><span class="info-label">Número:</span></td>
                    <td><span class="info-value">' . ($agenda->num ?: '-') . '</span></td>
                </tr>
                <tr>
                    <td><span class="info-label">Bairro:</span></td>
                    <td><span class="info-value">' . ($agenda->bairro ?: '-') . '</span></td>
                </tr>
                <tr>
                    <td><span class="info-label">Cidade:</span></td>
                    <td><span class="info-value">' . ($agenda->cidade ?: '-') . '</span></td>
                </tr>
                <tr>
                    <td><span class="info-label">Estado:</span></td>
                    <td><span class="info-value">' . ($agenda->estado ?: '-') . '</span></td>
                </tr>
                <tr>
                    <td><span class="info-label">CEP:</span></td>
                    <td><span class="info-value">' . ($agenda->cep ?: '-') . '</span></td>
                </tr>
            </table>
        </div>

        ' . ($agenda->nota ? '<div class="notes"><strong>Observações:</strong><br>' . nl2br(htmlspecialchars($agenda->nota)) . '</div>' : '');
    }

    private function generateCompromissoHtml($agenda)
    {
        return '
        <div class="info-section">
            <div class="info-title">Informações do Compromisso</div>
            <table>
                <tr>
                    <td><span class="info-label">Título:</span></td>
                    <td><span class="info-value">' . ($agenda->titulo ?: '-') . '</span></td>
                </tr>
                <tr>
                    <td><span class="info-label">Tipo:</span></td>
                    <td><span class="info-value">' . ($agenda->tipo_nome ?: '-') . '</span></td>
                </tr>
                <tr>
                    <td><span class="info-label">Data:</span></td>
                    <td><span class="info-value">' . ($agenda->data ? \Carbon\Carbon::parse($agenda->data)->format('d/m/Y') : '-') . '</span></td>
                </tr>
                <tr>
                    <td><span class="info-label">Hora:</span></td>
                    <td><span class="info-value">' . ($agenda->hora ? \Carbon\Carbon::parse($agenda->hora)->format('H:i') : '-') . '</span></td>
                </tr>
                <tr>
                    <td><span class="info-label">Local:</span></td>
                    <td><span class="info-value">' . ($agenda->local ?: '-') . '</span></td>
                </tr>
            </table>
        </div>

        ' . ($agenda->nota ? '<div class="notes"><strong>Observações:</strong><br>' . nl2br(htmlspecialchars($agenda->nota)) . '</div>' : '');
    }
}
