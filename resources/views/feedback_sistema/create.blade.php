@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                        <h3 class="mb-0 text-primary"><i class="fa fa-plus me-2"></i>Novo Feedback</h3>
                        <a href="{{ route('feedback_sistema.index') }}" class="btn btn-sm btn-outline-secondary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('feedback_sistema.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="usuario_id" class="form-label">Usuário</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                                    <input type="hidden" name="usuario_id" value="{{ Auth::id() }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_feedback" class="form-label">Tipo de Feedback</label>
                                    <select name="tipo_feedback" class="form-control" required>
                                        <option value="problema" {{ old('tipo_feedback') == 'problema' ? 'selected' : '' }}>Problema</option>
                                        <option value="melhoria" {{ old('tipo_feedback') == 'melhoria' ? 'selected' : '' }}>Melhoria</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="titulo" class="form-label">Módulo Sistema</label>
                                    <input type="text" name="titulo" class="form-control" required value="{{ old('titulo') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="prioridade" class="form-label">Prioridade</label>
                                    <select name="prioridade" class="form-control">
                                        <option value="baixa" {{ old('prioridade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                        <option value="média" {{ old('prioridade') == 'média' ? 'selected' : '' }}>Média</option>
                                        <option value="alta" {{ old('prioridade') == 'alta' ? 'selected' : '' }}>Alta</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="pendente" {{ old('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                        <option value="em andamento" {{ old('status') == 'em andamento' ? 'selected' : '' }}>Em andamento</option>
                                        <option value="resolvido" {{ old('status') == 'resolvido' ? 'selected' : '' }}>Resolvido</option>
                                        <option value="rejeitado" {{ old('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="descricao" class="form-label">Descrição</label>
                                    <textarea name="descricao" class="form-control" required>{{ old('descricao') }}</textarea>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="imagem_url" class="form-label">Imagem (cole ou selecione)</label>
                                    <input type="file" name="imagem_url" id="imagem_url" class="form-control" accept="image/*">
                                    <div id="preview" class="mt-2"></div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Salvar</button>
                            <a href="{{ route('feedback_sistema.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Permite colar imagem do clipboard no input file
const fileInput = document.getElementById('imagem_url');
document.addEventListener('paste', function (event) {
    if (event.clipboardData && event.clipboardData.files.length > 0) {
        fileInput.files = event.clipboardData.files;
        previewImage(fileInput.files[0]);
    }
});
fileInput.addEventListener('change', function() {
    if (fileInput.files.length > 0) {
        previewImage(fileInput.files[0]);
    }
});
function previewImage(file) {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '200px';
            img.className = 'img-thumbnail';
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
