<?php

namespace App\Http\Controllers;

use App\Models\Vistoria;
use App\Models\FotosDeVistoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VistoriaController extends Controller
{
    public function index(Request $request)
    {
        $vistorias = Vistoria::query()
            ->when($request->nome, function ($query) use ($request) {
                return $query->where('nome', 'like', '%' . $request->nome . '%');
            })
            ->when($request->bairro, function ($query) use ($request) {
                return $query->where('bairro', 'like', '%' . $request->bairro . '%');
            })
            ->when($request->tipo_ocupacao, function ($query) use ($request) {
                return $query->where('tipo_ocupacao', $request->tipo_ocupacao);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $tipoOcupacaoValues = Vistoria::getTipoOcupacaoValues();

        return view('vistorias.index', compact('vistorias', 'tipoOcupacaoValues'));
    }

    public function create()
    {
        $superficieValues = Vistoria::getSuperficieValues();
        $tipoOcupacaoValues = Vistoria::getTipoOcupacaoValues();
        $utilizaDaBenfeitoriaValues = Vistoria::getTipoOcupacaoValues();

            //dd($utilizaDaBenfeitoriaValues);

        return view('vistorias.create', compact(
            'superficieValues',
            'tipoOcupacaoValues',
            'utilizaDaBenfeitoriaValues'
        ));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|max:14',
            'telefone' => 'nullable|string|max:15',
            'endereco' => 'required|string|max:255',
            'num' => 'nullable|string|max:10',
            'bairro' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'num_processo' => 'nullable|string|max:50',
            'requerente' => 'nullable|string|max:255',
            'requerido' => 'nullable|string|max:255',
            'limites_confrontacoes' => 'nullable|string',
            'lado_direito' => 'nullable|string|max:255',
            'lado_esquerdo' => 'nullable|string|max:255',
            'topografia' => 'nullable|string|max:100',
            'formato_terreno' => 'nullable|string|max:100',
            'superficie' => 'required|in:Seca,Brejosa,Alagada',
            'documentacao' => 'nullable|string',
            'reside_no_imovel' => 'boolean',
            'data_ocupacao' => 'nullable|date',
            'tipo_ocupacao' => 'required|in:Residencial,Comercial,Mista',
            'exerce_pacificamente_posse' => 'boolean',
            'utiliza_da_benfeitoria' => 'required|in:Uso Próprio,Alugada,Outros',
            'tipo_construcao' => 'nullable|string|max:100',
            'padrao_acabamento' => 'nullable|string|max:100',
            'idade_aparente' => 'nullable|string|max:50',
            'estado_de_conservacao' => 'nullable|string|max:100',
            'observacoes' => 'nullable|string',
            'acompanhamento_vistoria' => 'nullable|string|max:255',
            'cpf_acompanhante' => 'nullable|string|max:14',
            'telefone_acompanhante' => 'nullable|string|max:15',
            'fotos.*' => 'nullable|image|max:2048',
            'descricoes.*' => 'nullable|string|max:255',
        ]);

        $vistoria = Vistoria::create($validatedData);

        // Processar fotos se existirem
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

        return redirect()->route('vistorias.index')
            ->with('success', 'Vistoria criada com sucesso!');
    }

    public function show(Vistoria $vistoria)
    {
        return view('vistorias.show', compact('vistoria'));
    }

    public function edit(Vistoria $vistoria)
    {
        $superficieValues = Vistoria::getSuperficieValues();
        $tipoOcupacaoValues = Vistoria::getTipoOcupacaoValues();
        $utilizaDaBenfeitoriaValues = Vistoria::getUtilizaDaBenfeitoriaValues();

        return view('vistorias.edit', compact(
            'vistoria',
            'superficieValues',
            'tipoOcupacaoValues',
            'utilizaDaBenfeitoriaValues'
        ));
    }

    public function update(Request $request, Vistoria $vistoria)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|max:14',
            'telefone' => 'nullable|string|max:15',
            'endereco' => 'required|string|max:255',
            'num' => 'nullable|string|max:10',
            'bairro' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'num_processo' => 'nullable|string|max:50',
            'requerente' => 'nullable|string|max:255',
            'requerido' => 'nullable|string|max:255',
            'limites_confrontacoes' => 'nullable|string',
            'lado_direito' => 'nullable|string|max:255',
            'lado_esquerdo' => 'nullable|string|max:255',
            'topografia' => 'nullable|string|max:100',
            'formato_terreno' => 'nullable|string|max:100',
            'superficie' => 'required|in:Seca,Brejosa,Alagada',
            'documentacao' => 'nullable|string',
            'reside_no_imovel' => 'boolean',
            'data_ocupacao' => 'nullable|date',
            'tipo_ocupacao' => 'required|in:Residencial,Comercial,Mista',
            'exerce_pacificamente_posse' => 'boolean',
            'utiliza_da_benfeitoria' => 'required|in:Uso Próprio,Alugada,Outros',
            'tipo_construcao' => 'nullable|string|max:100',
            'padrao_acabamento' => 'nullable|string|max:100',
            'idade_aparente' => 'nullable|string|max:50',
            'estado_de_conservacao' => 'nullable|string|max:100',
            'observacoes' => 'nullable|string',
            'acompanhamento_vistoria' => 'nullable|string|max:255',
            'cpf_acompanhante' => 'nullable|string|max:14',
            'telefone_acompanhante' => 'nullable|string|max:15',
            'fotos.*' => 'nullable|image|max:2048',
            'descricoes.*' => 'nullable|string|max:255',
        ]);

        $vistoria->update($validatedData);

        // Processar fotos se existirem
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

        return redirect()->route('vistorias.index')
            ->with('success', 'Vistoria atualizada com sucesso!');
    }

    public function destroy(Vistoria $vistoria)
    {
        // Excluir fotos do storage
        foreach ($vistoria->fotos as $foto) {
            if (Storage::disk('public')->exists($foto->url)) {
                Storage::disk('public')->delete($foto->url);
            }
        }

        $vistoria->delete();

        return redirect()->route('vistorias.index')
            ->with('success', 'Vistoria excluída com sucesso!');
    }

    public function deleteFoto($id)
    {
        $foto = FotosDeVistoria::findOrFail($id);

        if (Storage::disk('public')->exists($foto->url)) {
            Storage::disk('public')->delete($foto->url);
        }

        $foto->delete();

        return back()->with('success', 'Foto excluída com sucesso!');
    }
}
