<?php

namespace App\Http\Controllers;

use App\Models\ViaEspecifica;
use Illuminate\Http\Request;

class ViaEspecificaController extends Controller
{
    public function index(Request $request)
    {
        $viasespecificas = ViaEspecifica::orderBy('created_at', 'desc')->paginate(10);
        return view('viasespecificas.index', compact('viasespecificas'));
    }

    public function create()
    {
        return view('viasespecificas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'trecho' => 'nullable|string|max:255',
            'valor' => 'required|numeric'
        ]);

        ViaEspecifica::create($data);

        return redirect()->route('viasespecificas.index')->with('success', 'Via Específica criada com sucesso!');
    }

    public function show(ViaEspecifica $viasespecifica)
    {
        return view('viasespecificas.show', compact('viasespecifica'));
    }

    public function edit(ViaEspecifica $viasespecifica)
    {
        return view('viasespecificas.edit', compact('viasespecifica'));
    }

    public function update(Request $request, ViaEspecifica $viasespecifica)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'trecho' => 'nullable|string|max:255',
            'valor' => 'required|numeric'
        ]);

        $viasespecifica->update($data);

        return redirect()->route('viasespecificas.index')->with('success', 'Via Específica atualizada com sucesso!');
    }

    public function destroy(ViaEspecifica $viasespecifica)
    {
        $viasespecifica->delete();
        return redirect()->route('viasespecificas.index')->with('success', 'Via Específica removida com sucesso!');
    }
}