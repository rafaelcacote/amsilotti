<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use App\Models\Bairro;
use App\Models\ViaEspecifica;
use App\Models\Zona;
use App\Models\FotosDeImovel;
use Illuminate\Http\Request;
use DB;
use PDF;

class ImovelController extends Controller
{
    public function index(Request $request)
    {
        $bairros = Bairro::all();
        $vias = ViaEspecifica::all();

        $imoveis = Imovel::with(['bairro', 'viaEspecifica'])
            ->when($request->bairro, function ($query) use ($request) {
                return $query->whereIn('bairro_id', (array) $request->bairro);
            })
            ->when($request->tipo, function ($query) use ($request) {
                return $query->where('tipo', $request->tipo);
            })
            ->when($request->tipo && $request->tipo !== 'terreno', function ($query) use ($request) {
                // Filtra por área construída para tipos que não são terreno
                return $query->when($request->area_min, function ($query) use ($request) {
                    return $query->where('area_construida', '>=', $request->area_min);
                })
                    ->when($request->area_max, function ($query) use ($request) {
                        return $query->where('area_construida', '<=', $request->area_max);
                    });
            })
            ->when($request->tipo && $request->tipo === 'terreno', function ($query) use ($request) {
                // Filtra por área total para terreno
                return $query->when($request->area_min, function ($query) use ($request) {
                    return $query->where('area_total', '>=', $request->area_min);
                })
                    ->when($request->area_max, function ($query) use ($request) {
                        return $query->where('area_total', '<=', $request->area_max);
                    });
            })
            ->orderBy('created_at', 'desc')
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
        //dd($request->all());

        // Validação dos campos do imóvel
        $data = $request->validate([
            'endereco' => 'required|string|max:191',
            'numero' => 'nullable|string|max:10',
            'bairro_id' => 'nullable|exists:bairros,id',
            'via_especifica_id' => 'nullable|exists:vias_especificas,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'area_total' => 'nullable|',
            'valor_estimado' => 'nullable|',
            'zona_id' => 'nullable|exists:zonas,id',
            'tipo' => 'required|string|max:50',
            'pgm' => 'nullable|',
            'formato' => 'nullable|string|max:50',
            'topografia' => 'nullable|string|max:50',
            'posicao_na_quadra' => 'nullable|string|max:50',
            'frente' => 'nullable|numeric',
            'profundidade_equiv' => 'nullable|numeric',
            'topologia' => 'nullable|string|max:50',
            'padrao' => 'nullable|string|max:50',
            'area_construida' => 'nullable|',
            'benfeitoria' => 'nullable|string',
            'descricao_imovel' => 'nullable|string',
            'andar' => 'nullable|integer',
            'idade_predio' => 'nullable|integer',
            'quatidade_suites' => 'nullable|integer',
            'idade_aparente' => 'nullable|integer',
            'estado_conservacao' => 'nullable|string|max:50',
            'acessibilidade' => 'nullable|string|max:50',
            'modalidade' => 'nullable|string|max:50',
            'valor_total_imovel' => 'nullable|',
            'valor_construcao' => 'nullable|',
            'valor_terreno' => 'nullable|',
            'fator_oferta' => 'nullable|',
            'preco_unitario1' => 'nullable|',
            'preco_unitario2' => 'nullable|',
            'preco_unitario3' => 'nullable|',
            'fonte_informacao' => 'nullable|string|max:100',
            'contato' => 'nullable|string|max:50',
            'link' => 'nullable|string|max:200',
            'fotos_imovel' => 'nullable|array',
            'fotos_imovel.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'descricoes_fotos' => 'nullable|array',
            'descricoes_fotos.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Cria o imóvel
            $imovel = Imovel::create($data);

            // // Salva as fotos do imóvel
            if ($request->hasFile('fotos_imovel')) {
                $fotos = $request->file('fotos_imovel');
                $descricoes = $request->input('descricoes_fotos', []);


                foreach ($fotos as $index => $foto) {
                    $caminhoFoto = $foto->store('fotos_imoveis', 'public');
                    FotosDeImovel::create([
                        'imovel_id' => $imovel->id,
                        'caminho' => $caminhoFoto,
                        'descricao' => isset($descricoes[$index]) ? $descricoes[$index] : null
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('imoveis.index')->with('success', 'Imóvel criado com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao salvar imagens: ' . $e->getMessage());
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao criar o imóvel: ' . $e->getMessage());
        }
    }

    public function show(Imovel $imovel)
    {
        $imovel->load('bairro', 'zona');
        return view('imoveis.show', compact('imovel'));
    }

    public function edit($id)
    {
        $imovel = Imovel::findOrFail($id);
        $bairros = Bairro::all();
        $zonas = Zona::all();

        return view('imoveis.edit', compact('imovel', 'bairros', 'zonas'));
    }

    public function update(Request $request, $id)
    {
        // Validação dos campos do imóvel
        $data = $request->validate([
            'endereco' => 'required|string|max:191',
            'numero' => 'nullable|string|max:10',
            'bairro_id' => 'nullable|exists:bairros,id',
            'via_especifica_id' => 'nullable|exists:vias_especificas,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'area_total' => 'nullable|',
            'valor_estimado' => 'nullable|',
            'zona_id' => 'nullable|exists:zonas,id',
            'tipo' => 'required|string|max:50',
            'pgm' => 'nullable|',
            'formato' => 'nullable|string|max:50',
            'topografia' => 'nullable|string|max:50',
            'posicao_na_quadra' => 'nullable|string|max:50',
            'frente' => 'nullable|numeric',
            'profundidade_equiv' => 'nullable|numeric',
            'topologia' => 'nullable|string|max:50',
            'padrao' => 'nullable|string|max:50',
            'area_construida' => 'nullable|',
            'benfeitoria' => 'nullable|string',
            'descricao_imovel' => 'nullable|string',
            'andar' => 'nullable|integer',
            'idade_predio' => 'nullable|integer',
            'quatidade_suites' => 'nullable|integer',
            'idade_aparente' => 'nullable|integer',
            'estado_conservacao' => 'nullable|string|max:50',
            'acessibilidade' => 'nullable|string|max:50',
            'modalidade' => 'nullable|string|max:50',
            'valor_total_imovel' => 'nullable|',
            'valor_construcao' => 'nullable|',
            'valor_terreno' => 'nullable|',
            'fator_oferta' => 'nullable|',
            'preco_unitario1' => 'nullable|',
            'preco_unitario2' => 'nullable|',
            'preco_unitario3' => 'nullable|',
            'fonte_informacao' => 'nullable|string|max:100',
            'contato' => 'nullable|string|max:50',
            'link' => 'nullable|string|max:200',
            'fotos_imovel' => 'nullable|array',
            'fotos_imovel.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'descricoes_fotos' => 'nullable|array',
            'descricoes_fotos.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Atualiza o imóvel
            $imovel = Imovel::findOrFail($id);
            $imovel->update($data);

            // Salva as fotos do imóvel
            if ($request->hasFile('fotos_imovel')) {
                $fotos = $request->file('fotos_imovel');
                $descricoes = $request->input('descricoes_fotos', []);

                foreach ($fotos as $index => $foto) {
                    $caminhoFoto = $foto->store('fotos_imoveis', 'public');
                    FotosDeImovel::create([
                        'imovel_id' => $imovel->id,
                        'caminho' => $caminhoFoto,
                        'descricao' => isset($descricoes[$index]) ? $descricoes[$index] : null
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('imoveis.index')->with('success', 'Imóvel atualizado com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar imóvel: ' . $e->getMessage());
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao atualizar o imóvel: ' . $e->getMessage());
        }
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
        // Busca o imóvel pelo ID
        $imovel = Imovel::findOrFail($id);
        $imovel->load('bairro', 'zona');
        $logo = public_path('/img/logo.png');
        $impressao2 = public_path('/img/impressao2.png');
        // Carrega a view Blade
        $pdf = Pdf::loadView('imoveis.amostracompletapdf', compact('imovel', 'logo', 'impressao2'))
            ->setPaper('a4', 'landscape');

        // Retorna o PDF para download
        //return $pdf->download('amostracompletapdf.pdf');

        // Ou, se você quiser visualizar o PDF no navegador:
        return $pdf->stream('amostracompletapdf.pdf');
    }
}
