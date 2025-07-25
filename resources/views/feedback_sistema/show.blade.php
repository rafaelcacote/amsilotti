@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes do Feedback</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $feedback->id }}</p>
            <p><strong>Usuário ID:</strong> {{ $feedback->usuario_id }}</p>
            <p><strong>Título:</strong> {{ $feedback->titulo }}</p>
            <p><strong>Tipo:</strong> {{ ucfirst($feedback->tipo_feedback) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($feedback->status) }}</p>
            <p><strong>Prioridade:</strong> {{ ucfirst($feedback->prioridade) }}</p>
            <p><strong>Descrição:</strong> {{ $feedback->descricao }}</p>
            @if($feedback->imagem_url)
                <p><strong>Imagem:</strong><br><img src="{{ $feedback->imagem_url }}" alt="Imagem do Feedback" style="max-width:300px;"></p>
            @endif
            <p><strong>Resposta:</strong> {{ $feedback->resposta }}</p>
        </div>
    </div>
    <a href="{{ route('feedback_sistema.index') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection
