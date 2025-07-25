<?php

namespace App\Http\Controllers;

use App\Models\FeedbackSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackSistemaController extends Controller
{
    public function index()
    {
        $feedbacks = FeedbackSistema::orderByDesc('id')->paginate(15);
        return view('feedback_sistema.index', compact('feedbacks'));
    }

    public function create()
    {
        return view('feedback_sistema.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|integer',
            'tipo_feedback' => 'required|in:problema,melhoria',
            'titulo' => 'required|string',
            'descricao' => 'required|string',
            'status' => 'required|in:pendente,em andamento,resolvido,rejeitado',
            'prioridade' => 'required|in:baixa,média,alta',
            'imagem_url' => 'nullable|file|image|max:5120', // Corrigido para aceitar arquivo de imagem até 5MB
        ]);

        // Se imagem foi enviada via upload
        if ($request->hasFile('imagem_url')) {
            $path = $request->file('imagem_url')->store('feedbacks', 'public');
            $validated['imagem_url'] = '/storage/' . $path;
        }

        FeedbackSistema::create($validated);
        return redirect()->route('feedback_sistema.index')->with('success', 'Feedback criado com sucesso!');
    }

    public function edit($id)
    {
        $feedback = FeedbackSistema::findOrFail($id);
        return view('feedback_sistema.edit', compact('feedback'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|integer',
            'tipo_feedback' => 'required|in:problema,melhoria',
            'titulo' => 'required|string',
            'descricao' => 'required|string',
            'status' => 'required|in:pendente,em andamento,resolvido,rejeitado',
            'prioridade' => 'required|in:baixa,média,alta',
            'imagem_url' => 'nullable|file|image|max:5120', // Corrigido para aceitar arquivo de imagem até 5MB
        ]);
        $feedback = FeedbackSistema::findOrFail($id);
        if ($request->hasFile('imagem_url')) {
            $path = $request->file('imagem_url')->store('feedbacks', 'public');
            $validated['imagem_url'] = '/storage/' . $path;
        }
        $feedback->update($validated);
        return redirect()->route('feedback_sistema.index')->with('success', 'Feedback atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $feedback = FeedbackSistema::findOrFail($id);
        $feedback->delete();
        return redirect()->route('feedback_sistema.index')->with('success', 'Feedback removido com sucesso!');
    }

    public function show($id)
    {
        $feedback = FeedbackSistema::findOrFail($id);
        return view('feedback_sistema.show', compact('feedback'));
    }

    public function resolver($id)
    {
        $feedback = FeedbackSistema::findOrFail($id);
        $feedback->status = 'resolvido';
        $feedback->save();
        return redirect()->route('feedback_sistema.index')->with('success', 'Feedback marcado como resolvido!');
    }
}
