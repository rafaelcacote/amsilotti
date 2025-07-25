@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-plus-circle me-2"></i>Novo Tipo de Evento</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tipos-de-evento.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nome" class="form-label">Nome do Tipo <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                                   id="nome" name="nome" value="{{ old('nome') }}" required>
                                            @error('nome')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Ex: Vistoria, Reunião, Entrega de Laudo</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="codigo" class="form-label">Código <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                                                   id="codigo" name="codigo" value="{{ old('codigo') }}" required>
                                            @error('codigo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Ex: vistoria, reuniao (sem espaços ou caracteres especiais)</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cor" class="form-label">Cor <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <input type="color" id="colorpicker" value="#0d6efd"
                                                        onchange="document.getElementById('cor').value = this.value;">
                                                </span>
                                                <input type="text" class="form-control @error('cor') is-invalid @enderror"
                                                       id="cor" name="cor" value="{{ old('cor', '#0d6efd') }}" required>
                                            </div>
                                            @error('cor')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Código de cor hexadecimal (ex: #0d6efd)</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label d-block">Opções</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" checked>
                                                <label class="form-check-label" for="ativo">Ativo</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="is_padrao" name="is_padrao" value="1">
                                                <label class="form-check-label" for="is_padrao">Padrão</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="descricao" class="form-label">Descrição</label>
                                    <textarea class="form-control @error('descricao') is-invalid @enderror"
                                              id="descricao" name="descricao" rows="3">{{ old('descricao') }}</textarea>
                                    @error('descricao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 d-flex">
                                    <a href="{{ route('tipos-de-evento.index') }}" class="btn btn-secondary me-2">
                                        <i class="fas fa-arrow-left me-1"></i>Voltar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Salvar
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

            // Gerar código a partir do nome (simplificado)
            document.getElementById('nome').addEventListener('blur', function() {
                const nomeInput = document.getElementById('nome');
                const codigoInput = document.getElementById('codigo');
                
                // Só gera o código se o campo estiver vazio
                if (codigoInput.value.trim() === '' && nomeInput.value.trim() !== '') {
                    const codigo = nomeInput.value
                        .toLowerCase()
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '') // Remove acentos
                        .replace(/[^\w\s]/g, '')         // Remove caracteres especiais
                        .replace(/\s+/g, '_');           // Substitui espaços por underscore
                    
                    codigoInput.value = codigo;
                }
            });
        });
    </script>
@endsection
