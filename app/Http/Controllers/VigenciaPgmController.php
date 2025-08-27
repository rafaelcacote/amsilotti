<?php
namespace App\Http\Controllers;

use App\Models\VigenciaPgm;
use Illuminate\Http\Request;

class VigenciaPgmController extends Controller
{
    public function index()
    {
        $vigencias = VigenciaPgm::all();
        return view('vigencia_pgm.index', compact('vigencias'));
    }

    public function create()
    {
        return view('vigencia_pgm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',
            'ativo' => 'required|boolean',
        ]);
        VigenciaPgm::create($request->all());
        return redirect()->route('vigencia_pgm.index');
    }

    public function edit(VigenciaPgm $vigencia_pgm)
    {
        return view('vigencia_pgm.edit', compact('vigencia_pgm'));
    }

    public function update(Request $request, VigenciaPgm $vigencia_pgm)
    {
        $request->validate([
            'descricao' => 'required',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',
            'ativo' => 'required|boolean',
        ]);
        $vigencia_pgm->update($request->all());
        return redirect()->route('vigencia_pgm.index');
    }

    public function destroy(VigenciaPgm $vigencia_pgm)
    {
        $vigencia_pgm->delete();
        return redirect()->route('vigencia_pgm.index');
    }
}
