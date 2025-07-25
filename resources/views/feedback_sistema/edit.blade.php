@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Feedback</h1>
    <form action="{{ route('feedback_sistema.update', $feedback->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="usuario_id" class="form-label">Usuário</label>
                <input type="text" class="form-control" value="{{ $feedback->usuario->name ?? $feedback->usuario_id }}" disabled>
                <input type="hidden" name="usuario_id" value="{{ $feedback->usuario_id }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="tipo_feedback" class="form-label">Tipo de Feedback</label>
                <select name="tipo_feedback" class="form-control" required>
                    <option value="problema" {{ old('tipo_feedback', $feedback->tipo_feedback) == 'problema' ? 'selected' : '' }}>Problema</option>
                    <option value="melhoria" {{ old('tipo_feedback', $feedback->tipo_feedback) == 'melhoria' ? 'selected' : '' }}>Melhoria</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" required value="{{ old('titulo', $feedback->titulo) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="prioridade" class="form-label">Prioridade</label>
                <select name="prioridade" class="form-control">
                    <option value="baixa" {{ old('prioridade', $feedback->prioridade) == 'baixa' ? 'selected' : '' }}>Baixa</option>
                    <option value="média" {{ old('prioridade', $feedback->prioridade) == 'média' ? 'selected' : '' }}>Média</option>
                    <option value="alta" {{ old('prioridade', $feedback->prioridade) == 'alta' ? 'selected' : '' }}>Alta</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pendente" {{ old('status', $feedback->status) == 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="em andamento" {{ old('status', $feedback->status) == 'em andamento' ? 'selected' : '' }}>Em andamento</option>
                    <option value="resolvido" {{ old('status', $feedback->status) == 'resolvido' ? 'selected' : '' }}>Resolvido</option>
                    <option value="rejeitado" {{ old('status', $feedback->status) == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                </select>
            </div>
            <div class="col-12 mb-3">
                @if($feedback->imagem_url)
                    <label class="form-label">Imagem enviada</label><br>
                    <img src="{{ $feedback->imagem_url }}" alt="Imagem do feedback" style="max-width:200px;cursor:pointer" class="img-thumbnail mb-2" data-bs-toggle="modal" data-bs-target="#imagemModal">
                    <!-- Modal -->
                    <div class="modal fade" id="imagemModal" tabindex="-1" aria-labelledby="imagemModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imagemModalLabel">Visualizar Imagem</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ $feedback->imagem_url }}" alt="Imagem do feedback" style="max-width:100%;max-height:70vh" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-12 mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" required>{{ old('descricao', $feedback->descricao) }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('feedback_sistema.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
