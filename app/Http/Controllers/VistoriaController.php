<?php

namespace App\Http\Controllers;

use App\Models\Vistoria;
use App\Models\Agenda;
use App\Models\Bairro;
use App\Models\FotosDeVistoria;
use App\Models\MembrosEquipeTecnica;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class VistoriaController extends Controller
{        public function index(Request $request)
    {
          if (!auth()->user()->can('view vistoria')) {
            abort(403, 'Você não tem permissão para visualizar a agenda.');
        }

        $query = Vistoria::query();

        // Filtro por número do processo
        if ($request->filled('num_processo')) {
            $query->where('num_processo', 'like', '%' . $request->num_processo . '%');
        }

        // Filtro por bairro
        if ($request->filled('bairro')) {
            $query->where('bairro', 'like', '%' . $request->bairro . '%');
        }

        // Filtro por data início - usando agenda se existir relacionamento, senão created_at
        if ($request->filled('data_inicio')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('agenda', function($subQuery) use ($request) {
                    $subQuery->whereDate('data', '>=', $request->data_inicio);
                })->orWhereDoesntHave('agenda')->whereDate('created_at', '>=', $request->data_inicio);
            });
        }

        // Filtro por data fim - usando agenda se existir relacionamento, senão created_at
        if ($request->filled('data_fim')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('agenda', function($subQuery) use ($request) {
                    $subQuery->whereDate('data', '<=', $request->data_fim);
                })->orWhereDoesntHave('agenda')->whereDate('created_at', '<=', $request->data_fim);
            });
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $vistorias = $query->with(['agenda', 'requerente'])->orderBy('created_at', 'desc')->paginate(10);

        // Preservar os parâmetros de filtro na paginação
        $vistorias->appends($request->query());

        $eventos = Vistoria::all();

        $bairros = Bairro::orderBy('nome')->get();

        return view('vistorias.index', compact('vistorias', 'eventos', 'bairros'));
    }

    public function create(Request $request)
    {
        $superficieValues = Vistoria::getSuperficieValues();
        $tipoOcupacaoValues = Vistoria::getTipoOcupacaoValues();
        $membrosEquipe = MembrosEquipeTecnica::where('status', 1)->orderBy('nome')->get();

        $agenda = null;
        if ($request->has('vistoria_id')) {
            $agenda = Agenda::findOrFail($request->vistoria_id);
        }

        return view('vistorias.create', compact(
            'superficieValues',
            'tipoOcupacaoValues',
            'membrosEquipe',
            'agenda'
        ));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|digits:11',
            'telefone' => 'nullable|string|max:15',
            'endereco' => 'required|string|max:255',
            'num' => 'nullable|string|max:10',
            'bairro' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'num_processo' => 'nullable|string|max:50',
            'requerente' => 'nullable|string|max:255',
            'requerido' => 'nullable|string|max:255',
            'limites_confrontacoes' => 'nullable|array',
            'limites_confrontacoes.norte' => 'nullable|string|max:255',
            'limites_confrontacoes.sul' => 'nullable|string|max:255',
            'limites_confrontacoes.leste' => 'nullable|string|max:255',
            'limites_confrontacoes.oeste' => 'nullable|string|max:255',
            'topografia' => 'nullable|string|max:100',
            'formato_terreno' => 'nullable|string|max:100',
            'superficie' => 'nullable|in:Seca,Brejosa,Alagada',
            'documentacao' => 'nullable|string',
            'reside_no_imovel' => 'boolean',
            'data_ocupacao' => 'nullable|date',
            'tipo_ocupacao' => 'nullable|in:Residencial,Comercial,Mista',
            'exerce_pacificamente_posse' => 'boolean',
            'utiliza_benfeitoria' => 'nullable|',
            'tipo_construcao' => 'nullable|string|max:100',
            'padrao_acabamento' => 'nullable|string|max:100',
            'idade_aparente' => 'nullable|string|max:50',
            'estado_conservacao' => 'nullable|string|max:100',
            'observacoes' => 'nullable|string',
            'acompanhamento_vistoria' => 'nullable|string|max:255',
            'cpf_acompanhante' => 'nullable|digits:11',
            'telefone_acompanhante' => 'nullable|string|max:15',
            'croqui' => 'nullable|string',
            'fotos.*' => 'nullable|image|max:2048',
            'fotos_base64.*' => 'nullable|string',
            'descricoes.*' => 'nullable|string|max:255',
            'nomes_arquivos.*' => 'nullable|string|max:255',
            'membros_equipe_ids' => 'nullable|json',
            'croqui_imagem' => 'nullable|image|max:4096',
        ]);


        // Processar imagem do croqui gerada pelo canvas (base64)
        if ($request->filled('croqui_imagem_base64')) {
            $croquiBase64 = $request->input('croqui_imagem_base64');
            if (preg_match('/^data:image\/(png|jpeg);base64,/', $croquiBase64)) {
                $croquiBase64 = preg_replace('/^data:image\/(png|jpeg);base64,/', '', $croquiBase64);
                $croquiBase64 = str_replace(' ', '+', $croquiBase64);
                $croquiImage = base64_decode($croquiBase64);
                $croquiFileName = 'vistorias/croqui_' . uniqid() . '.png';
                \Storage::disk('public')->put($croquiFileName, $croquiImage);
                $validatedData['croqui_imagem'] = $croquiFileName;
            }
        }

        $validatedData['status'] = 'agendado'; // Define status inicial
        $vistoria = Vistoria::create($validatedData);

        // Processar membros da equipe técnica se existirem
        if ($request->filled('membros_equipe_ids')) {
            $membrosIds = json_decode($request->membros_equipe_ids, true);
            if (is_array($membrosIds) && !empty($membrosIds)) {
                // Salvar na tabela pivot
                foreach ($membrosIds as $membroId) {
                    if (is_numeric($membroId)) {
                        \DB::table('vistoria_membro_equipe')->insert([
                            'vistoria_id' => $vistoria->id,
                            'membro_equipe_tecnica_id' => $membroId,
                            //'created_at' => now(),
                            //'updated_at' => now()
                        ]);
                    }
                }
            }
        }

        // Processar fotos tradicionais (upload de arquivo)
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $key => $foto) {
                $path = $foto->store('vistorias', 'public');
                $descricao = $request->descricoes[$key] ?? null;

                FotosDeVistoria::create([
                    'vistoria_id' => $vistoria->id,
                    'url' => $path,
                    'descricao' => $descricao
                ]);
            }
        }

        // Processar fotos em base64 (tiradas pela câmera do tablet)
        if ($request->filled('fotos_base64')) {
            foreach ($request->fotos_base64 as $key => $fotoBase64) {
                if (!empty($fotoBase64)) {
                    // Decodificar base64
                    $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $fotoBase64));

                    // Gerar nome único para o arquivo
                    $nomeArquivo = $request->nomes_arquivos[$key] ?? 'foto_' . time() . '_' . $key . '.jpg';
                    $nomeArquivo = 'vistorias/' . uniqid() . '_' . $nomeArquivo;

                    // Salvar arquivo
                    Storage::disk('public')->put($nomeArquivo, $imageData);

                    // Salvar no banco
                    $descricao = $request->descricoes[$key] ?? null;

                    FotosDeVistoria::create([
                        'vistoria_id' => $vistoria->id,
                        'url' => $nomeArquivo,
                        'descricao' => $descricao
                    ]);
                }
            }
        }

        return redirect()->route('vistorias.index')
            ->with('success', 'Vistoria criada com sucesso! Fotos e equipe técnica foram salvos corretamente.');
    }

    public function show(Vistoria $vistoria)
        {
            if (request()->wantsJson()) {
                return response()->json($vistoria->load('requerente', 'membrosEquipe', 'fotos'));
            }

            // Carrega as relações necessárias para a view
            $vistoria->load('requerente', 'membrosEquipeTecnica', 'fotos');

            return view('vistorias.show', compact('vistoria'));
        }

    public function edit(Request $request,Vistoria $vistoria)
    {
        // Carregar os relacionamentos necessários
        $vistoria->load(['fotos', 'membrosEquipeTecnica']);

        $superficieValues = Vistoria::getSuperficieValues();
        $tipoOcupacaoValues = Vistoria::getTipoOcupacaoValues();
        $membrosEquipe = MembrosEquipeTecnica::where('status', 1)->orderBy('nome')->get();

        $agenda = null;
        if ($request->has('vistoria_id')) {
            $agenda = Agenda::findOrFail($request->vistoria_id);
        }

        return view('vistorias.edit', compact(
            'vistoria',
            'superficieValues',
            'tipoOcupacaoValues',
            'membrosEquipe',
            'agenda'
        ));
    }

    public function update(Request $request, Vistoria $vistoria)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|digits:11',
            'telefone' => 'nullable|string|max:15',
            'endereco' => 'required|string|max:255',
            'num' => 'nullable|string|max:10',
            'bairro' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'num_processo' => 'nullable|string|max:50',
            'requerente_id' => 'required|integer|exists:clientes,id',
            'requerido' => 'nullable|string|max:255',
            'limites_confrontacoes' => 'nullable|array',
            'limites_confrontacoes.norte' => 'nullable|string|max:255',
            'limites_confrontacoes.sul' => 'nullable|string|max:255',
            'limites_confrontacoes.leste' => 'nullable|string|max:255',
            'limites_confrontacoes.oeste' => 'nullable|string|max:255',
            'lado_direito' => 'nullable|string|max:255',
            'lado_esquerdo' => 'nullable|string|max:255',
            'topografia' => 'nullable|string|max:100',
            'formato_terreno' => 'nullable|string|max:100',
            'superficie' => 'nullable|in:Seca,Brejosa,Alagada',
            'documentacao' => 'nullable|string',
            'reside_no_imovel' => 'boolean',
            'data_ocupacao' => 'nullable|date',
            'tipo_ocupacao' => 'nullable|in:Residencial,Comercial,Mista',
            'exerce_pacificamente_posse' => 'boolean',
            'utiliza_benfeitoria' => 'nullable|string',
            'tipo_construcao' => 'nullable|string|max:100',
            'padrao_acabamento' => 'nullable|string|max:100',
            'idade_aparente' => 'nullable|string|max:50',
            'estado_conservacao' => 'nullable|string|max:100',
            'observacoes' => 'nullable|string',
            'acompanhamento_vistoria' => 'nullable|string|max:255',
            'cpf_acompanhante' => 'nullable|digits:11',
            'telefone_acompanhante' => 'nullable|string|max:15',
            'croqui' => 'nullable|string',
            'fotos.*' => 'nullable|image|max:2048',
            'fotos_base64.*' => 'nullable|string',
            'descricoes.*' => 'nullable|string|max:255',
            'nomes_arquivos.*' => 'nullable|string|max:255',
            'membros_equipe_ids' => 'nullable|json',
            'remover_fotos_existentes.*' => 'nullable|integer|exists:fotosdevistorias,id',
            'descricoes_existentes.*' => 'nullable|string|max:255',
            'croqui_imagem' => 'nullable|image|max:4096',
            'croqui_imagem_base64' => 'nullable|string',
        ]);




        // Processar imagem do croqui gerada pelo canvas (base64)
        if ($request->filled('croqui_imagem_base64')) {
            // Remove o croqui antigo se existir
            if ($vistoria->croqui_imagem && \Storage::disk('public')->exists($vistoria->croqui_imagem)) {
                \Storage::disk('public')->delete($vistoria->croqui_imagem);
            }
            $croquiBase64 = $request->input('croqui_imagem_base64');
            if (preg_match('/^data:image\/(png|jpeg);base64,/', $croquiBase64)) {
                $croquiBase64 = preg_replace('/^data:image\/(png|jpeg);base64,/', '', $croquiBase64);
                $croquiBase64 = str_replace(' ', '+', $croquiBase64);
                $croquiImage = base64_decode($croquiBase64);
                $croquiFileName = 'vistorias/croqui_' . uniqid() . '.png';
                \Storage::disk('public')->put($croquiFileName, $croquiImage);
                $validatedData['croqui_imagem'] = $croquiFileName;
            }
        }



        $validatedData['status'] = 'preenchido'; // Atualiza status ao preencher
        $vistoria->update($validatedData);

        // Debug temporário - verificar se croqui_imagem foi salvo
        // dd([
        //     'croqui_imagem_base64_received' => $request->filled('croqui_imagem_base64'),
        //     'croqui_imagem_saved' => $vistoria->croqui_imagem,
        //     'vistoria' => $vistoria
        // ]);

       // Processar membros da equipe técnica se existirem
        if ($request->filled('membros_equipe_ids')) {
            // Primeiro, remover os membros existentes
            \DB::table('vistoria_membro_equipe')->where('vistoria_id', $vistoria->id)->delete();

            $membrosIds = json_decode($request->membros_equipe_ids, true);
            if (is_array($membrosIds) && !empty($membrosIds)) {
                // Salvar na tabela pivot
                foreach ($membrosIds as $membroId) {
                    if (is_numeric($membroId)) {
                        \DB::table('vistoria_membro_equipe')->insert([
                            'vistoria_id' => $vistoria->id,
                            'membro_equipe_tecnica_id' => $membroId,
                            //'created_at' => now(),
                            //'updated_at' => now()
                        ]);
                    }
                }
            }
        }

        // Processar fotos tradicionais (upload de arquivo)
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $key => $foto) {
                $path = $foto->store('vistorias', 'public');
                $descricao = $request->descricoes[$key] ?? null;

                FotosDeVistoria::create([
                    'vistoria_id' => $vistoria->id,
                    'url' => $path,
                    'descricao' => $descricao
                ]);
            }
        }

        // Processar fotos em base64 (tiradas pela câmera do tablet)
        if ($request->filled('fotos_base64')) {
            foreach ($request->fotos_base64 as $key => $fotoBase64) {
                if (!empty($fotoBase64)) {
                    // Decodificar base64
                    $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $fotoBase64));

                    // Gerar nome único para o arquivo
                    $nomeArquivo = $request->nomes_arquivos[$key] ?? 'foto_' . time() . '_' . $key . '.jpg';
                    $nomeArquivo = 'vistorias/' . uniqid() . '_' . $nomeArquivo;

                    // Salvar arquivo
                    Storage::disk('public')->put($nomeArquivo, $imageData);

                    // Salvar no banco
                    $descricao = $request->descricoes[$key] ?? null;

                    FotosDeVistoria::create([
                        'vistoria_id' => $vistoria->id,
                        'url' => $nomeArquivo,
                        'descricao' => $descricao
                    ]);
                }
            }
        }

        // Processar remoção de fotos existentes
        if ($request->filled('remover_fotos_existentes')) {
            foreach ($request->remover_fotos_existentes as $fotoId) {
                $foto = FotosDeVistoria::find($fotoId);
                if ($foto && $foto->vistoria_id == $vistoria->id) {
                    // Remover arquivo do storage
                    if (Storage::disk('public')->exists($foto->url)) {
                        Storage::disk('public')->delete($foto->url);
                    }
                    // Remover registro do banco
                    $foto->delete();
                }
            }
        }

        return redirect()->route('vistorias.index')
            ->with('success', 'Vistoria atualizada com sucesso!');
    }

    public function destroy(Vistoria $vistoria)
    {
        // Verificar se o status permite exclusão
        if (strtolower($vistoria->status) !== 'agendada') {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Só é possível excluir vistorias com status "Agendada".'
                ], 403);
            }

            return redirect()->route('vistorias.index')
                ->with('error', 'Só é possível excluir vistorias com status "Agendada".');
        }

        // Excluir fotos do storage
        foreach ($vistoria->fotos as $foto) {
            if (Storage::disk('public')->exists($foto->url)) {
                Storage::disk('public')->delete($foto->url);
            }
        }

        $vistoria->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vistoria excluída com sucesso!'
            ]);
        }

        return redirect()->route('vistorias.index')
            ->with('success', 'Vistoria excluída com sucesso!');
    }

    public function deleteFoto($id)
    {
        \Log::info('Iniciando deleteFoto', ['foto_id' => $id, 'is_ajax' => request()->ajax()]);

        try {
            // Verificar se o ID é válido
            if (!is_numeric($id)) {
                \Log::warning('ID inválido fornecido', ['foto_id' => $id]);
                if (request()->ajax() || request()->wantsJson() || request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'ID da foto inválido.'
                    ], 400);
                }
                return back()->with('error', 'ID da foto inválido.');
            }

            $foto = FotosDeVistoria::find($id);

            if (!$foto) {
                \Log::warning('Foto não encontrada', ['foto_id' => $id]);
                if (request()->ajax() || request()->wantsJson() || request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Foto não encontrada.'
                    ], 404);
                }
                return back()->with('error', 'Foto não encontrada.');
            }

            \Log::info('Foto encontrada, iniciando exclusão', ['foto_id' => $id, 'foto_url' => $foto->url]);

            // Remover arquivo do storage se existir
            if ($foto->url && Storage::disk('public')->exists($foto->url)) {
                Storage::disk('public')->delete($foto->url);
                \Log::info('Arquivo removido do storage', ['foto_url' => $foto->url]);
            }

            // Remover registro do banco
            $foto->delete();
            \Log::info('Foto removida do banco com sucesso', ['foto_id' => $id]);

            // Retornar JSON para requisições AJAX
            if (request()->ajax() || request()->wantsJson() || request()->expectsJson()) {
                \Log::info('Retornando JSON de sucesso para AJAX');
                return response()->json([
                    'success' => true,
                    'message' => 'Foto excluída com sucesso!'
                ], 200);
            }

            return back()->with('success', 'Foto excluída com sucesso!');

        } catch (\Exception $e) {
            \Log::error('Erro ao excluir foto: ' . $e->getMessage(), [
                'foto_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            if (request()->ajax() || request()->wantsJson() || request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro interno do servidor ao excluir foto.'
                ], 500);
            }

            return back()->with('error', 'Erro ao excluir foto.');
        }
    }


     public function imprimir(Request $request)
    {
        if (!auth()->user()->can('imprimir vistoria')) {
            abort(403, 'Você não tem permissão para visualizar a agenda.');
        }
        
        $query = Agenda::where('tipo', 'vistoria');

        // Aplicar os mesmos filtros da listagem
        if ($request->filled('num_processo')) {
            $query->where('num_processo', 'like', '%' . $request->num_processo . '%');
        }

        if ($request->filled('bairro')) {
            $query->where('bairro', 'like', '%' . $request->bairro . '%');
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('data', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data', '<=', $request->data_fim);
        }

        $vistorias = $query->with(['requerente'])->orderBy('created_at', 'desc')->get();

        // Gerar o HTML para o PDF
        $html = view('vistorias.pdf', compact('vistorias', 'request'))->render();

        // Configurar o MPDF
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'L', // Landscape para tabela mais larga
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 5,
            'margin_bottom' => 10,
            'default_font' => 'Arial',
        ]);

        // Configurar metadados
        $mpdf->SetTitle('Lista de Vistorias');
        $mpdf->SetAuthor('Sistema de Perícias');
        $mpdf->SetCreator('Laravel MPDF');

        $mpdf->WriteHTML($html);

        // Retornar o PDF
        return response($mpdf->Output('lista-vistorias-' . date('Y-m-d-H-i-s') . '.pdf', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="lista-vistorias-' . date('Y-m-d-H-i-s') . '.pdf"'
        ]);
    }

    public function imprimirIndividual($id)
    {
         $usuarioLogado = auth()->user();

         $vistoria = \App\Models\Vistoria::with(['requerente', 'fotos', 'membrosEquipeTecnica', 'agenda'])->findOrFail($id);
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);
        $html = view('vistorias.impressao_unica', compact('vistoria', 'usuarioLogado'))->render();
        $mpdf->WriteHTML($html);
        $filename = 'vistoria_' . $vistoria->id . '.pdf';
        return response($mpdf->Output($filename, 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    // Método de teste para debug
    public function testeImprimir($id)
    {
        try {
            $vistoria = Vistoria::findOrFail($id);

            $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Teste Vistoria #' . $vistoria->id . '</title>
</head>
<body>
    <h1>Teste de Impressão</h1>
    <p>Vistoria ID: ' . $vistoria->id . '</p>
    <p>Processo: ' . ($vistoria->num_processo ?? 'N/A') . '</p>
    <p>Status: ' . ($vistoria->status ?? 'N/A') . '</p>
</body>
</html>';

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
            ]);

            $mpdf->WriteHTML($html);

            return response($mpdf->Output('teste-vistoria-' . $vistoria->id . '.pdf', 'S'), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="teste-vistoria-' . $vistoria->id . '.pdf"'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro no teste: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function getDeleteInfo($id)
    {
        $vistoria = Vistoria::with(['fotos'])->findOrFail($id);

        $membros = [];
        $totalFotos = $vistoria->fotos->count();

        // Verificar se a relação membrosEquipeTecnica existe
        try {
            $vistoria->load('membrosEquipeTecnica');
            $membros = $vistoria->membrosEquipeTecnica->pluck('nome')->toArray();
        } catch (\Exception $e) {
            // Se não existir a relação, continuar com array vazio
            $membros = [];
        }

        return response()->json([
            'num_processo' => $vistoria->num_processo,
            'membros' => $membros,
            'total_fotos' => $totalFotos,
            'status' => $vistoria->status,
            'pode_excluir' => strtolower($vistoria->status) === 'agendada'
        ]);
    }
}
