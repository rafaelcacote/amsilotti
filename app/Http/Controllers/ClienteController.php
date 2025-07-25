<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ClienteController extends Controller
{
    /**
     * Display a listing of the clients.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $clientes = Cliente::query()
            ->when($search, function ($query, $search) {
                return $query->where('nome', 'like', "%{$search}%")
                    ->orWhere('empresa', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('clientes.index', compact('clientes', 'search'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create(): View
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'empresa' => 'nullable|string|max:255',
            'nome_responsavel' => 'nullable|string|max:255',
            'profissao' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'tipo' => 'required',
        ]);

        Cliente::create($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente criado com sucesso!');
    }

    /**
     * Display the specified client.
     */
    public function show(Cliente $cliente): View
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Cliente $cliente): View
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, Cliente $cliente): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'empresa' => 'nullable|string|max:255',
            'nome_responsavel' => 'nullable|string|max:255',
            'profissao' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'tipo' => 'required',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy(Cliente $cliente): RedirectResponse
    {
        if ($cliente->controleDeTarefas()->count() > 0) {
            return redirect()->route('clientes.index')
                ->with('error', "Não é possível excluir o cliente '{$cliente->nome}' pois existem tarefas associadas a ele.");
        }

        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }
}
