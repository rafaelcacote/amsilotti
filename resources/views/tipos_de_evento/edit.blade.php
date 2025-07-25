@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-edit me-2"></i>Editar Tipo de Evento</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tipos-de-evento.update', $tipo) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nome" class="form-label">Nome do Tipo <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                                   id="nome" name="nome" value="{{ old('nome', $tipo->nome) }}" required>
                                            @error('nome')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="codigo" class="form-label">Código <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                                                   id="codigo" name="codigo" value="{{ old('codigo', $tipo->codigo) }}" required>
                                            @error('codigo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Alterar o código pode afetar compromissos existentes</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cor" class="form-label">Cor <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <input type="color" id="colorpicker" value="{{ old('cor', $tipo->cor) }}"
                                                        onchange="document.getElementById('cor').value = this.value;">
                                                </span>
                                                <input type="text" class="form-control @error('cor') is-invalid @enderror"
                                                       id="cor" name="cor" value="{{ old('cor', $tipo->cor) }}" required>
                                            </div>
                                            @error('cor')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label d-block">Opções</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1"
                                                      {{ old('ativo', $tipo->ativo) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ativo">Ativo</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="is_padrao" name="is_padrao" value="1"
                                                      {{ old('is_padrao', $tipo->is_padrao) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_padrao">Padrão</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="descricao" class="form-label">Descrição</label>
                                    <textarea class="form-control @error('descricao') is-invalid @enderror"
                                              id="descricao" name="descricao" rows="3">{{ old('descricao', $tipo->descricao) }}</textarea>
                                    @error('descricao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 d-flex">
                                    <a href="{{ route('tipos-de-evento.index') }}" class="btn btn-secondary me-2">
                                        <i class="fas fa-arrow-left me-1"></i>Voltar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Salvar Alterações
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Atualizar o color picker quando o valor do input é alterado
            document.getElementById('cor').addEventListener('input', function() {
                document.getElementById('colorpicker').value = this.value;
            });
        });
    </script>
@endsection
