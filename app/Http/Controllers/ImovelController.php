<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use App\Models\Bairro;
use App\Models\ViaEspecifica;
use App\Models\Zona;
use App\Models\FotosDeImovel;
use App\Models\ImagemImovel;
use App\Http\Requests\Imoveis\UpdateImovelRequest;
use Illuminate\Http\Request;
use DB;
use PDF;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ImovelController extends Controller
{
    public function index(Request $request)
{
    $bairros = Bairro::all();
    $vias = ViaEspecifica::all();

    $imoveis = Imovel::with(['bairro', 'viaEspecifica'])

        ->when($request->id, function ($query) use ($request) {
            // Verifica se é uma string com múltiplos IDs separados por vírgula
            if (strpos($request->id, ',') !== false) {
                // Remove espaços e divide por vírgula
                $ids = array_map('trim', explode(',', $request->id));
                // Remove valores vazios e garante que são números
                $ids = array_filter($ids, function($id) {
                    return is_numeric($id) && $id > 0;
                });
                if (!empty($ids)) {
                    return $query->whereIn('id', $ids);
                }
            } else {
                // Busca por ID único (comportamento original)
                return $query->where('id', $request->id);
            }
        })
        ->when($request->bairro, function ($query) use ($request) {
            return $query->whereIn('bairro_id', (array) $request->bairro);
        })
        ->when($request->tipo, function ($query) use ($request) {
            return $query->where('tipo', $request->tipo);
        })
        // NOVO: Filtro de área SEMPRE considera ambos os campos, independente do tipo
        ->when($request->area_min, function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('area_total', '>=', $request->area_min)
                  ->orWhere('area_construida', '>=', $request->area_min);
            });
        })
        ->when($request->area_max, function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('area_total', '<=', $request->area_max)
                  ->orWhere('area_construida', '<=', $request->area_max);
            });
        })
          ->orderBy('created_at', 'desc')
        ->orderBy('id', 'desc') // Adiciona ordenação por ID
        ->paginate(10);

    return view('imoveis.index', compact('imoveis', 'bairros', 'vias'));
}

    public function create()
    {
        $bairros = Bairro::all();
        $vias = ViaEspecifica::all();
        $zonas = Zona::all();
        return view('imoveis.create', compact('bairros', 'vias', 'zonas'));
    }

    public function store(Request $request)
    {
                // Crie o validador separadamente
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|string|max:255',
            'fator_fundamentacao' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'numero' => 'nullable|',
            'bairro_id' => 'required|exists:bairros,id',
            'zona_id' => 'required|exists:zonas,id',
            'pgm' => 'nullable|regex:/^\d+(,\d{1,2})?$/',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'area_total' => 'nullable|numeric', // Campo original (não mais usado diretamente)
            'area_total_dados_terreno' => 'nullable|numeric', // Para seção Dados do Terreno
            'area_terreno_construcao' => 'nullable|numeric', // Para Área Terreno na construção
            'area_total_terreno' => 'nullable|numeric', // Para seção específica de terreno
            'area_construida' => 'nullable|numeric',
            'frente' => 'nullable|numeric',
            'profundidade_equiv' => 'nullable|numeric',
            'padrao' => 'nullable|string|max:255',
            'estado_conservacao' => 'nullable|string|max:255',
            'descricao_imovel' => 'nullable|string',
            'valor_total_imovel' => 'nullable|numeric',
            'preco_unitario1' => 'nullable|numeric',
            'fonte_informacao' => 'nullable|string|max:255',
            'contato' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:900',
            'imagens_data' => 'required|json',
            'fator_oferta' => 'nullable',
            'via_especifica_id' => 'nullable',
            'benfeitoria' => 'nullable|string|',
            'benfeitoria_terreno' => 'nullable|string|',
            'posicao_na_quadra' => 'nullable|string|max:255',
            'posicao_na_quadra_terreno' => 'nullable|string|max:255',
            'topologia' => 'nullable|string',
            'topologia_terreno' => 'nullable|string',
            'andar' => 'nullable|integer',
            'idade_predio' => 'nullable|integer',
            'quantidade_suites' => 'nullable|integer',
            'mobiliado' => 'nullable',
            'banheiros' => 'nullable|integer',
            'vagas_garagem' => 'nullable|integer',
            'gerador' => 'nullable',
            'area_lazer' => 'nullable',
            'transacao' => 'nullable|string|max:255'

        ]);



        // Verifique se falhou
        if ($validator->fails()) {
            // Armazena as imagens na sessão
            if ($request->has('imagens_data')) {
                session()->flash('imagens_data', $request->imagens_data);
            }

            return back()
                ->withErrors($validator) // Passa o objeto validator inteiro
                ->withInput();
        }

            // Obter os dados validados
            $validated = $validator->validated();

            // Unificar os campos de área em area_total baseado no tipo
            if ($request->tipo === 'terreno') {
                // Para terreno, usa area_total_dados_terreno
                $validated['area_total'] = $validated['area_total_dados_terreno'] ?? null;
            } elseif ($request->tipo === 'galpao' || $request->tipo === 'imovel_urbano') {
                // Para galpão e imóvel urbano, usa area_terreno_construcao
                $validated['area_total'] = $validated['area_terreno_construcao'] ?? null;
            } else {
                // Para outros tipos (apartamento, sala_comercial), usa area_total_dados_terreno
                $validated['area_total'] = $validated['area_total_dados_terreno'] ?? null;
            }

            // Remove os campos específicos para não tentar salvar no banco
            unset($validated['area_total_dados_terreno']);
            unset($validated['area_terreno_construcao']);
            unset($validated['area_total_terreno']);

            // Mapear campos de terreno se o tipo for 'terreno'
            if ($request->tipo === 'terreno') {
                if (isset($validated['benfeitoria_terreno'])) {
                    $validated['benfeitoria'] = $validated['benfeitoria_terreno'];
                    unset($validated['benfeitoria_terreno']);
                }
                if (isset($validated['posicao_na_quadra_terreno'])) {
                    $validated['posicao_na_quadra'] = $validated['posicao_na_quadra_terreno'];
                    unset($validated['posicao_na_quadra_terreno']);
                }
                if (isset($validated['topologia_terreno'])) {
                    $validated['topologia'] = $validated['topologia_terreno'];
                    unset($validated['topologia_terreno']);
                }
            }

            // Converter valores decimais (substituir vírgula por ponto)
                if (!empty($validated['pgm'])) {
                    $validated['pgm'] = str_replace(',', '.', $validated['pgm']);
                }


             // Adicionar a lógica para as vagas de garagem baseada no tipo
                if ($request->tipo === 'apartamento') {
                    $validated['vagas_garagem'] = $request->vagas_garagem_apartamento;
                } elseif ($request->tipo === 'sala_comercial') {
                    $validated['vagas_garagem'] = $request->vagas_garagem_sala;
                }

                //dd($validated);

            // Criar o imóvel
            $imovel = Imovel::create($validated);
            // Processar as imagens
            $imagens = json_decode($request->imagens_data, true);

            if (count($imagens) < 3) {
                return back()->withErrors(['imagens' => 'É necessário enviar pelo menos 3 imagens.'])->withInput();
            }

            foreach ($imagens as $imagemData) {
                // Decodificar a imagem base64
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imagemData['data']));

                // Gerar um nome único para a imagem
                $imageName = Str::uuid() . '.jpg';
                $imagePath = 'fotos_imoveis/' . $imageName;

                // Salvar a imagem no storage
                Storage::disk('public')->put($imagePath, $imageData);

                // Criar o registro da imagem no banco de dados
                $imovel->imagens()->create([
                    'caminho' => $imagePath,
                    'descricao' => $imagemData['descricao'] ?? '',
                    'ordem' => $imagemData['ordem'] ?? ''
                ]);
            }

            return redirect()->route('imoveis.index')->with('success', 'Imóvel cadastrado com sucesso!');
    }


    public function show(Imovel $imovel)
    {
        $imovel->load('bairro', 'zona');
        return view('imoveis.show', compact('imovel'));
    }

    public function edit($imovel)
    {
        $imovel = Imovel::findOrFail($imovel);
        $bairros = Bairro::all(); // Se necessário
        $zonas = Zona::all(); // Se necessário

        return view('imoveis.edit', compact('imovel', 'bairros', 'zonas'));
    }

public function update(Request $request, Imovel $imovel)
{
   $input = $request->all();

    if (($input['tipo'] ?? '') === 'terreno') {
        // Se vierem os campos com sufixo _terreno, use eles para os campos principais
        if (isset($input['benfeitoria_terreno'])) {
            $input['benfeitoria'] = $input['benfeitoria_terreno'];
        }
        if (isset($input['posicao_na_quadra_terreno'])) {
            $input['posicao_na_quadra'] = $input['posicao_na_quadra_terreno'];
        }
        if (isset($input['topologia_terreno'])) {
            $input['topologia'] = $input['topologia_terreno'];
        }
        if (isset($input['profundidade_equivalente'])) {
            $input['profundidade_equiv'] = $input['profundidade_equivalente'];
        }
        // frente geralmente já vem igual, mas pode garantir:
        if (isset($input['frente_terreno'])) {
            $input['frente'] = $input['frente_terreno'];
        }
    }


    // Validação dos dados (similar ao store)
    $validator = Validator::make($input, [
        'tipo' => 'required|string|max:255',
        'fator_fundamentacao' => 'required|string|max:255',
        'endereco' => 'required|string|max:255',
        'numero' => 'nullable',
        'bairro_id' => 'required|exists:bairros,id',
        'zona_id' => 'required|exists:zonas,id',
        'pgm' => 'nullable|numeric',
        'latitude' => 'nullable|string|max:255',
        'longitude' => 'nullable|string|max:255',
        'area_total' => 'nullable|numeric',
        'area_total_dados_terreno' => 'nullable|numeric', // Para seção Dados do Terreno
        'area_terreno_construcao' => 'nullable|numeric', // Para Área Terreno na construção
        'area_total_terreno' => 'nullable|numeric', // Para seção específica de terreno
        'area_construida' => 'nullable|numeric',
        'frente' => 'nullable|numeric',
        'profundidade_equiv' => 'nullable|numeric',
        'padrao' => 'nullable|string|max:255',
        'estado_conservacao' => 'nullable|string|max:255',
        'descricao_imovel' => 'nullable|string',
        'valor_total_imovel' => 'nullable|numeric',
        'preco_unitario1' => 'nullable|numeric',
        'fonte_informacao' => 'nullable|string|max:255',
        'contato' => 'nullable|string|max:255',
        'link' => 'nullable|url|max:900',        'imagens_data' => 'nullable|json',
        'imagens_removidas' => 'nullable|json',
        'imagens.*.descricao' => 'nullable|string|max:255',
        'fator_oferta' => 'nullable',
        'via_especifica_id' => 'nullable',
        'benfeitoria' => 'nullable|string',
        'posicao_na_quadra' => 'nullable|string|max:255',
        'topologia' => 'nullable|string',
        'andar' => 'nullable|integer',
        'idade_predio' => 'nullable|integer',
        'quantidade_suites' => 'nullable|integer',
        'mobiliado' => 'nullable',
        'banheiros' => 'nullable|integer',
        'vagas_garagem' => 'nullable|integer',
        'gerador' => 'nullable',
        'area_lazer' => 'nullable',
        'transacao' => 'nullable|string|max:255'
    ]);

    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput();
    }

    // Obter os dados validados
    $validated = $validator->validated();

    // Unificar os campos de área em area_total baseado no tipo
    if ($request->tipo === 'terreno') {
        // Para terreno, usa area_total_dados_terreno
        $validated['area_total'] = $validated['area_total_dados_terreno'] ?? null;
    } elseif ($request->tipo === 'galpao' || $request->tipo === 'imovel_urbano') {
        // Para galpão e imóvel urbano, usa area_terreno_construcao
        $validated['area_total'] = $validated['area_terreno_construcao'] ?? null;
    } else {
        // Para outros tipos (apartamento, sala_comercial), usa area_total_dados_terreno
        $validated['area_total'] = $validated['area_total_dados_terreno'] ?? null;
    }

    // Remove os campos específicos para não tentar salvar no banco
    unset($validated['area_total_dados_terreno']);
    unset($validated['area_terreno_construcao']);
    unset($validated['area_total_terreno']);



    // Converter valores decimais (substituir vírgula por ponto)
    if (!empty($validated['pgm'])) {
        $validated['pgm'] = str_replace(',', '.', $validated['pgm']);
    }

    // Adicionar a lógica para as vagas de garagem baseada no tipo
    if ($request->tipo === 'apartamento') {
        $validated['vagas_garagem'] = $request->vagas_garagem_apartamento;
    } elseif ($request->tipo === 'sala_comercial') {
        $validated['vagas_garagem'] = $request->vagas_garagem_sala;
    }    // Atualizar o imóvel
    $imovel->update($validated);

    // Processar atualizações de descrições de imagens existentes
    if ($request->has('imagens')) {
        foreach ($request->imagens as $imagemId => $dadosImagem) {
            if (isset($dadosImagem['descricao'])) {
                $imagem = $imovel->fotos()->find($imagemId);
                if ($imagem) {
                    $imagem->update(['descricao' => $dadosImagem['descricao']]);
                }
            }
        }
    }

    // Processar imagens removidas
    if ($request->has('imagens_removidas')) {
        $imagensRemovidas = json_decode($request->imagens_removidas, true);
        foreach ($imagensRemovidas as $imagemId) {
            $imagem = $imovel->imagens()->find($imagemId);
            if ($imagem) {
                Storage::disk('public')->delete($imagem->caminho);
                $imagem->delete();
            }
        }
    }

    // Processar novas imagens (se houver)
    $imagens = [];
    if ($request->has('imagens_data') && $request->imagens_data) {
        $imagens = json_decode($request->imagens_data, true) ?? [];
        // Adiciona novas imagens e atualiza descrições
        foreach ($imagens as $imagemData) {
            if (!isset($imagemData['id'])) {
                $imageData = base64_decode(preg_replace('#^data:image/\\w+;base64,#i', '', $imagemData['data']));
                $imageName = Str::uuid() . '.jpg';
                $imagePath = 'fotos_imoveis/' . $imageName;
                Storage::disk('public')->put($imagePath, $imageData);
                $imovel->imagens()->create([
                    'caminho' => $imagePath,
                    'descricao' => $imagemData['descricao'] ?? '',
                    'ordem' => $imagemData['ordem'] ?? ''
                ]);
            } else {
                $imagem = $imovel->imagens()->find($imagemData['id']);
                if ($imagem && isset($imagemData['descricao'])) {
                    $imagem->update(['descricao' => $imagemData['descricao']]);
                }
            }
        }
    }

    // Garantir que o imóvel tenha pelo menos 3 imagens após todas as operações
    $totalImagens = $imovel->imagens()->count();
    if ($totalImagens < 3) {
        return back()->withErrors(['imagens' => 'É necessário ter pelo menos 3 imagens.'])->withInput();
    }

    return redirect()->route('imoveis.index')->with('success', 'Imóvel atualizado com sucesso!');
}




    public function destroy(Imovel $imovel)
    {
        // Exclui todas as fotos relacionadas ao imóvel
        $imovel->fotos()->delete();

        // Exclui o imóvel
        $imovel->delete();

        return redirect()->route('imoveis.index')->with('success', 'Imóvel e fotos relacionadas removidos com sucesso!');
    }

    public function gerarPdf($id)
    {
        $imovel = Imovel::with('bairro', 'zona', 'fotos')->findOrFail($id);
        // Para a logo - use caminho relativo

        $logo = 'img/cabecalho_relatorio.png';

        // Para as fotos - vamos usar URLs relativas
        $fotosData = [];
        foreach ($imovel->fotos as $foto) {
            $fotosData[] = [
                'url' => 'storage/fotos_imoveis/' . basename($foto->caminho),
                'descricao' => $foto->descricao
            ];
        }

        $html = view('imoveis.amostracompletapdf', [
            'imovel' => $imovel,
            'logo' => $logo,
            'fotos' => $fotosData
        ])->render();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'tempDir' => storage_path('app/temp'),
            'default_font' => 'arial',
            'margin_top' => 40, // Ajuste conforme necessário
            'margin_header' => 10, // Espaço para o cabeçalho
            'allow_output_buffering' => true
        ]);

        // Configuração importante para encontrar os recursos
        $mpdf->SetBasePath(public_path());

        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_imovel.pdf', 'I');
    }

// No ImovelController.php
public function gerarMultiploPdf($ids)
{
    // Converter a string de IDs para array
    $idsArray = explode(',', $ids);

    // Buscar todos os imóveis selecionados
    $imoveis = Imovel::with('bairro', 'zona', 'fotos')
        ->whereIn('id', $idsArray)
        ->get();

    // Caminho para a logo
    //$logo = 'img/impressao.png';
    $logo = 'img/cabecalho_relatorio.png';

    // Preparar os dados para a view
    $imoveisData = [];
    foreach ($imoveis as $imovel) {
        $fotosData = [];
        foreach ($imovel->fotos as $foto) {
            $fotosData[] = [
                'url' => 'storage/fotos_imoveis/' . basename($foto->caminho),
                'descricao' => $foto->descricao
            ];
        }

        $imoveisData[] = [
            'imovel' => $imovel,
            'fotos' => $fotosData
        ];
    }

    $html = view('imoveis.amostracompletamultiplapdf', [
        'imoveis' => $imoveisData,
        'logo' => $logo,
        'totalImoveis' => count($imoveis)
    ])->render();

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4-L',
        'tempDir' => storage_path('app/temp'),
        'default_font' => 'arial',
        'margin_top' => 40,
        'margin_header' => 10,
        'allow_output_buffering' => true
    ]);

    $mpdf->SetBasePath(public_path());
    $mpdf->WriteHTML($html);
    return $mpdf->Output('relatorio_imoveis.pdf', 'I');
}
    public function gerarPdfMultiploResumido($ids)
    {
        // Convertendo os IDs passados como uma string separada por vírgulas para um array
        $imoveisIds = explode(',', $ids);

        // Buscando os imóveis com os IDs fornecidos, incluindo suas relações
        $imoveis = Imovel::with('bairro', 'zona', 'fotos')->whereIn('id', $imoveisIds)->get();

        // Caminho para o logo e imagem de impressão
        $logo = public_path('/img/impressao.png');
        $impressao2 = public_path('/img/impressao2.png');
        $storagePath = storage_path('app/public'); // Caminho absoluto do storage

        // Gerando o PDF
        $pdf = Pdf::loadView('imoveis.amostraresumidapdf', compact('imoveis', 'logo', 'impressao2', 'storagePath'))
            ->setPaper('a4', 'landscape');

        // Retornando o PDF gerado para o navegador
        return $pdf->stream('amostra_imoveis_selecionados.pdf');
    }


    public function searchViasEspecificas(Request $request)
    {
        $term = $request->get('term');
        $results = ViaEspecifica::where('nome', 'LIKE', '%' . $term . '%')
            ->orWhere('trecho', 'LIKE', '%' . $term . '%')
            ->get();

        $data = [];
        foreach ($results as $result) {
            $valorFormatado = number_format((float) str_replace(',', '.', $result->valor), 2, '.', '');
            $data[] = [
                'label' => $result->nome . ' | ' . $result->trecho, // Exibe nome e trecho no dropdown
                'value' => $result->trecho, // Valor padrão (não será usado devido ao return false no select)
                'via_especifica_id' => $result->id, // ID da via específica
                'valor' => $valorFormatado // Valor do PGM
            ];
        }

        return response()->json($data);
    }


    public function destroyFoto($id)
    {
        \Log::info("Tentando excluir imagem ID: $id");

        try {
            $imagem = FotosDeImovel::findOrFail($id);
            \Log::info("Imagem encontrada: " . $imagem->caminho);

            // Remove o arquivo físico do disco 'public'
            if (Storage::disk('public')->exists($imagem->caminho)) {
                Storage::disk('public')->delete($imagem->caminho);
                \Log::info("Arquivo físico removido: " . $imagem->caminho);
            } else {
                \Log::warning("Arquivo não encontrado: " . $imagem->caminho);
            }

            // Remove do banco de dados
            $imagem->delete();
            \Log::info("Registro da imagem removido do banco de dados");

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error("Erro ao excluir imagem: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }







    public function printMap(Request $request)
    {
        try {
            \Log::info('Iniciando printMap');
            \Log::info('Request data:', $request->all());

            $mapImage = $request->input('map_image');
            $imoveisData = json_decode($request->input('imoveis_data'), true);

            if (!$mapImage) {
                \Log::error('Imagem do mapa não fornecida');
                return back()->with('error', 'Imagem do mapa não fornecida');
            }

            if (!$imoveisData || empty($imoveisData)) {
                \Log::error('Dados dos imóveis não fornecidos');
                return back()->with('error', 'Dados dos imóveis não fornecidos');
            }

            \Log::info('Dados recebidos - Imóveis: ' . count($imoveisData));

            // Remove o prefixo data:image/png;base64, da imagem
            $mapImage = str_replace('data:image/png;base64,', '', $mapImage);
            $mapImageDecoded = base64_decode($mapImage);

            if (!$mapImageDecoded) {
                \Log::error('Falha ao decodificar a imagem');
                return back()->with('error', 'Falha ao decodificar a imagem do mapa');
            }

            // Salva a imagem temporariamente
            $tempImagePath = storage_path('app/temp_map_' . time() . '.png');
            $result = file_put_contents($tempImagePath, $mapImageDecoded);

            if (!$result) {
                \Log::error('Falha ao salvar imagem temporária');
                return back()->with('error', 'Falha ao salvar imagem temporária');
            }

            \Log::info('Imagem temporária salva: ' . $tempImagePath);

            // Redimensiona a imagem para reduzir o tamanho se necessário
            $this->resizeImage($tempImagePath, 800, 600);

            // Configurações do mPDF
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4-L',
                'orientation' => 'L',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'tempDir' => storage_path('app/temp')
            ]);

            // Usar referência de arquivo ao invés de base64 para imagens grandes
            $tempMapPath = 'temp_map_' . time() . '.png';

            // HTML simplificado usando referência de arquivo
            $html = $this->generateOptimizedMapReportHtml($tempMapPath, $imoveisData);

            \Log::info('HTML gerado, criando PDF...');

            $mpdf->WriteHTML($html);

            // Remove o arquivo temporário
            if (file_exists($tempImagePath)) {
                unlink($tempImagePath);
            }

            $fileName = 'mapa_imoveis_' . date('Y-m-d_H-i-s') . '.pdf';

            \Log::info('PDF gerado com sucesso: ' . $fileName);

            // Retorna o PDF inline com headers para nova aba
            return response($mpdf->Output('', 'S'))
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');

        } catch (\Exception $e) {
            \Log::error('Erro em printMap: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()->with('error', 'Erro ao gerar relatório do mapa: ' . $e->getMessage());
        }
    }

    private function resizeImage($imagePath, $maxWidth, $maxHeight)
    {
        $imageInfo = getimagesize($imagePath);
        $width = $imageInfo[0];
        $height = $imageInfo[1];

        if ($width <= $maxWidth && $height <= $maxHeight) {
            return; // Não precisa redimensionar
        }

        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = $width * $ratio;
        $newHeight = $height * $ratio;

        $source = imagecreatefrompng($imagePath);
        $resized = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagepng($resized, $imagePath);

        imagedestroy($source);
        imagedestroy($resized);
    }


    private function generateOptimizedMapReportHtml($mapImagePath, $imoveisData)
    {
        $cabecalhoPath = public_path('img/cabecalho_impressaomapa.png');
        $cabecalhoHtml = '';

        if (file_exists($cabecalhoPath)) {
            $cabecalhoHtml = '<div style="text-align: center; margin-bottom: 20px;">
                                <img src="' . $cabecalhoPath . '" style="max-width: 100%; height: auto;" alt="Cabeçalho">
                            </div>';
        }

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }
                .titulo {
                    text-align: center;
                    color: #333;
                    margin-bottom: 15px;
                    font-size: 16px;
                    font-weight: bold;
                }
                .info-geral {
                    text-align: center;
                    margin-bottom: 15px;
                    font-size: 12px;
                    color: #666;
                }
                .content {
                    width: 100%;
                    margin-top: 10px;
                }
                .map-section {
                    float: left;
                    width: 58%;
                    margin-right: 2%;
                }
                .table-section {
                    float: right;
                    width: 40%;
                }
                .map-image {
                    width: 100%;
                    height: auto;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    max-height: 400px;
                    object-fit: contain;
                }
                .imoveis-table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 9px;
                }
                .imoveis-table th,
                .imoveis-table td {
                    border: 1px solid #ddd;
                    padding: 4px;
                    text-align: left;
                    word-wrap: break-word;
                }
                .imoveis-table th {
                    background-color: #f5f5f5;
                    font-weight: bold;
                    font-size: 8px;
                }
                .imoveis-table tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                .clearfix::after {
                    content: "";
                    display: table;
                    clear: both;
                }
            </style>
        </head>
        <body>';

        $html .= $cabecalhoHtml;
        //$html .= '<div class="titulo">RELATÓRIO DE LOCALIZAÇÃO DOS IMÓVEIS</div>';
        $html .= '<div class="info-geral">Data: ' . date('d/m/Y H:i') . ' | Total de Imóveis: ' . count($imoveisData) . '</div>';

        $html .= '<div class="content clearfix">';

        // Seção do mapa (lado esquerdo)
        $html .= '<div class="map-section">';
        $html .= '<img src="' . storage_path('app/' . $mapImagePath) . '" class="map-image" alt="Mapa dos Imóveis">';
        $html .= '</div>';

        // Seção da tabela (lado direito)
        $html .= '<div class="table-section">';
        $html .= '<table class="imoveis-table">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Cód.</th>';
        $html .= '<th>Tipo</th>';
        $html .= '<th>Bairro</th>';
        $html .= '<th>Área</th>';
        $html .= '<th>Coordenadas</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        foreach ($imoveisData as $imovel) {
            $html .= '<tr>';
            $html .= '<td>#' . htmlspecialchars($imovel['id']) . '</td>';
            $html .= '<td>' . htmlspecialchars(substr($imovel['tipo'], 0, 8)) . '</td>'; // Limita o tamanho
            $html .= '<td>' . htmlspecialchars(substr($imovel['bairro'], 0, 10)) . '</td>'; // Limita o tamanho
            $html .= '<td>' . htmlspecialchars($imovel['area']) . '</td>';
            $html .= '<td>' . number_format($imovel['latitude'], 4) . '<br>' . number_format($imovel['longitude'], 4) . '</td>'; // Quebra linha nas coordenadas
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
        $html .= '</div>'; // Fecha content

        $html .= '</body></html>';

        return $html;
    }

    public function getSelectedData(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json(['success' => false, 'message' => 'Nenhum ID fornecido']);
            }

            $imoveis = Imovel::with('bairro')
                ->whereIn('id', $ids)
                ->select('id', 'tipo', 'bairro_id', 'area_total', 'area_construida', 'valor_total_imovel', 'latitude', 'longitude')
                ->get()
                ->map(function ($imovel) {
                    return [
                        'id' => $imovel->id,
                        'tipo' => $this->formatTipo($imovel->tipo),
                        'bairro' => $imovel->bairro->nome ?? '',
                        'valor' => $imovel->valor_total_imovel ? 'R$ ' . number_format($imovel->valor_total_imovel, 2, ',', '.') : '-',
                        'area' => $this->formatArea($imovel),
                        'latitude' => $imovel->latitude,
                        'longitude' => $imovel->longitude
                    ];
                });

            return response()->json(['success' => true, 'imoveis' => $imoveis]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao buscar dados dos imóveis']);
        }
    }

    private function formatTipo($tipo)
    {
        $tipos = [
            'terreno' => 'Terreno',
            'apartamento' => 'Apartamento',
            'imovel_urbano' => 'Imóvel Urbano',
            'sala_comercial' => 'Sala Comercial',
            'galpao' => 'Galpão'
        ];

        return $tipos[$tipo] ?? ucfirst($tipo);
    }

    private function formatArea($imovel)
    {
        if ($imovel->tipo == 'terreno') {
            return $imovel->area_total ? number_format($imovel->area_total, 2, ',', '.') . ' m²' : '-';
        } else {
            return $imovel->area_construida ? number_format($imovel->area_construida, 2, ',', '.') . ' m²' : '-';
        }
    }

    public function printMapDirect(Request $request)
    {
        try {
            \Log::info('Iniciando printMapDirect');

            $imovelIds = json_decode($request->input('imovel_ids'), true);

            if (empty($imovelIds)) {
                return back()->with('error', 'Nenhum imóvel selecionado');
            }

            \Log::info('IDs dos imóveis:', $imovelIds);

            // Buscar dados dos imóveis
            $imoveis = Imovel::with('bairro')
                ->whereIn('id', $imovelIds)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->select('id', 'tipo', 'bairro_id', 'area_total', 'area_construida', 'valor_total_imovel', 'latitude', 'longitude')
                ->get();

            if ($imoveis->isEmpty()) {
                return back()->with('error', 'Nenhum imóvel com coordenadas válidas encontrado');
            }

            \Log::info('Imóveis encontrados: ' . $imoveis->count());

            // Formatar dados dos imóveis
            $imoveisData = $imoveis->map(function ($imovel) {
                return [
                    'id' => $imovel->id,
                    'tipo' => $this->formatTipo($imovel->tipo),
                    'bairro' => $imovel->bairro->nome ?? '',
                    'valor' => $imovel->valor_total_imovel ? 'R$ ' . number_format($imovel->valor_total_imovel, 2, ',', '.') : '-',
                    'area' => $this->formatArea($imovel),
                    'latitude' => (float) str_replace(',', '.', $imovel->latitude),
                    'longitude' => (float) str_replace(',', '.', $imovel->longitude)
                ];
            })->toArray();

            // Gerar mapa estático usando Google Static Maps API
            $mapImageUrl = $this->generateStaticMapUrl($imoveisData);

            if (!$mapImageUrl) {
                return back()->with('error', 'Erro ao gerar mapa estático');
            }

            // Baixar a imagem do mapa
            $mapImageData = file_get_contents($mapImageUrl);

            if (!$mapImageData) {
                return back()->with('error', 'Erro ao baixar imagem do mapa');
            }

            // Salvar temporariamente
            $tempImagePath = storage_path('app/static_map_' . time() . '.png');
            file_put_contents($tempImagePath, $mapImageData);

            // Configurações do mPDF
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4-L',
                'orientation' => 'L',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'tempDir' => storage_path('app/temp')
            ]);

            // Gerar HTML do relatório
            $html = $this->generateStaticMapReportHtml($tempImagePath, $imoveisData);

            $mpdf->WriteHTML($html);

            // Remove o arquivo temporário
            if (file_exists($tempImagePath)) {
                unlink($tempImagePath);
            }

            $fileName = 'mapa_imoveis_' . date('Y-m-d_H-i-s') . '.pdf';

            \Log::info('PDF gerado com sucesso via método direto: ' . $fileName);

            // Retorna o PDF inline
            return response($mpdf->Output('', 'S'))
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');

        } catch (\Exception $e) {
            \Log::error('Erro em printMapDirect: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()->with('error', 'Erro ao gerar mapa: ' . $e->getMessage());
        }
    }

    private function generateStaticMapUrl($imoveisData)
    {
        try {
            $apiKey = 'AIzaSyDlG0ouFD-X3AknpUDzwpfpzE6tw5LU8ws'; // Sua chave da API

            $baseUrl = 'https://maps.googleapis.com/maps/api/staticmap';
            $params = [
                'size' => '800x600',
                'maptype' => 'roadmap',
                'key' => $apiKey
            ];

            // Adicionar marcadores
            $markers = [];
            foreach ($imoveisData as $imovel) {
                $markers[] = 'color:red|label:' . $imovel['id'] . '|' . $imovel['latitude'] . ',' . $imovel['longitude'];
            }

            if (!empty($markers)) {
                $params['markers'] = implode('&markers=', $markers);
            }

            // Construir URL
            $url = $baseUrl . '?';
            foreach ($params as $key => $value) {
                if ($key === 'markers') {
                    $url .= 'markers=' . $value;
                } else {
                    $url .= $key . '=' . urlencode($value) . '&';
                }
            }

            $url = rtrim($url, '&');

            \Log::info('URL do mapa estático: ' . $url);

            return $url;

        } catch (\Exception $e) {
            \Log::error('Erro ao gerar URL do mapa estático: ' . $e->getMessage());
            return null;
        }
    }

    private function generateStaticMapReportHtml($mapImagePath, $imoveisData)
    {
        $cabecalhoPath = public_path('img/cabecalho_impressaomapa.png');
        $cabecalhoHtml = '';

        if (file_exists($cabecalhoPath)) {
            $cabecalhoHtml = '<div style="text-align: center; margin-bottom: 20px;">
                                <img src="' . $cabecalhoPath . '" style="max-width: 100%; height: auto;" alt="Cabeçalho">
                            </div>';
        }

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }
                .titulo {
                    text-align: center;
                    color: #333;
                    margin-bottom: 15px;
                    font-size: 16px;
                    font-weight: bold;
                }
                .info-geral {
                    text-align: center;
                    margin-bottom: 15px;
                    font-size: 12px;
                    color: #666;
                }
                .content {
                    width: 100%;
                    margin-top: 10px;
                }
                .map-section {
                    float: left;
                    width: 58%;
                    margin-right: 2%;
                }
                .table-section {
                    float: right;
                    width: 40%;
                }
                .map-image {
                    width: 100%;
                    height: auto;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    max-height: 400px;
                    object-fit: contain;
                }
                .imoveis-table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 9px;
                }
                .imoveis-table th,
                .imoveis-table td {
                    border: 1px solid #ddd;
                    padding: 4px;
                    text-align: left;
                    word-wrap: break-word;
                }
                .imoveis-table th {
                    background-color: #f5f5f5;
                    font-weight: bold;
                    font-size: 8px;
                }
                .imoveis-table tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                .clearfix::after {
                    content: "";
                    display: table;
                    clear: both;
                }
            </style>
        </head>
        <body>';

        $html .= $cabecalhoHtml;
        $html .= '<div class="info-geral">Data: ' . date('d/m/Y H:i') . ' | Total de Imóveis: ' . count($imoveisData) . '</div>';

        $html .= '<div class="content clearfix">';

        // Seção do mapa (lado esquerdo)
        $html .= '<div class="map-section">';
        $html .= '<img src="' . $mapImagePath . '" class="map-image" alt="Mapa dos Imóveis">';
        $html .= '</div>';

        // Seção da tabela (lado direito)
        $html .= '<div class="table-section">';
        $html .= '<table class="imoveis-table">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Cód.</th>';
        $html .= '<th>Tipo</th>';
        $html .= '<th>Bairro</th>';
        $html .= '<th>Área</th>';
        $html .= '<th>Coordenadas</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        foreach ($imoveisData as $imovel) {
            $html .= '<tr>';
            $html .= '<td>#' . htmlspecialchars($imovel['id']) . '</td>';
            $html .= '<td>' . htmlspecialchars(substr($imovel['tipo'], 0, 8)) . '</td>';
            $html .= '<td>' . htmlspecialchars(substr($imovel['bairro'], 0, 10)) . '</td>';
            $html .= '<td>' . htmlspecialchars($imovel['area']) . '</td>';
            $html .= '<td>' . number_format($imovel['latitude'], 4) . '<br>' . number_format($imovel['longitude'], 4) . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
        $html .= '</div>'; // Fecha content

        $html .= '</body></html>';

        return $html;
    }
}
