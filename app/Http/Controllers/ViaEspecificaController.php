<?php

namespace App\Http\Controllers;

use App\Models\ViaEspecifica;
use Illuminate\Http\Request;

class ViaEspecificaController extends Controller
{
    public function index(Request $request)
    {
        // Inicia a query para buscar as vias específicas
        $query = ViaEspecifica::query();

        // Filtro por trecho (se o parâmetro 'trecho' estiver presente na requisição)
        if ($request->has('trecho') && $request->trecho != '') {
            $query->where('trecho', 'like', '%' . $request->trecho . '%');
        }

        // Ordena os resultados pelo nome (ou outro campo desejado)
        $query->orderBy('nome');

        // Pagina os resultados (por exemplo, 10 itens por página)
        $vias = $query->paginate(10);

        // Retorna a view com os dados filtrados e paginados
        return view('vias-especificas.index', compact('vias'));
    }

    public function create()
    {
        return view('vias-especificas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'trecho' => 'required|string|max:255',
            'valor' => 'required|string|min:0',
        ]);

        // Cria a nova via específica
        ViaEspecifica::create($request->all());

        return redirect()->route('vias-especificas.index')
            ->with('success', 'Via específica criada com sucesso!');
    }

    public function show(ViaEspecifica $viaEspecifica)
    {
        return view('vias-especificas.show', compact('viaEspecifica'));
    }

    public function edit(ViaEspecifica $viaEspecifica)
    {
        return view('vias-especificas.edit', compact('viaEspecifica'));
    }

    public function update(Request $request, ViaEspecifica $viaEspecifica)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'trecho' => 'nullable|string|max:255',
            'valor' => 'required|string|min:0',
        ]);

        // Atualiza a via específica
        $viaEspecifica->update($request->all());

        return redirect()->route('vias-especificas.index')
            ->with('success', 'Via específica atualizada com sucesso!');
    }

    public function destroy(ViaEspecifica $viaEspecifica)
    {
        // Verifica se o bairro tem móveis associados antes de excluir
        if ($viaEspecifica->imoveis()->exists()) {
            return redirect()->route('vias-especificas.index')
                ->with('error', 'Não é possível excluir esta via pois existem móveis associados a ele.');
        }

        $viaEspecifica->delete();
        return redirect()->route('vias-especificas.index');
    }
}
