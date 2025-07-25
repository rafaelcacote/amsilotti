@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-user-plus me-2"></i>Criar Novo Cliente</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('clientes.store') }}" method="POST" class="row g-3 needs-validation"
                                novalidate>
                                @csrf

                                <!-- Linha 1 - Nome, Empresa, Profissão -->
                                <div class="col-md-4 mb-3">
                                    <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                        id="nome" name="nome" value="{{ old('nome') }}" required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="empresa" class="form-label">Empresa </label>
                                    <input type="text" class="form-control @error('empresa') is-invalid @enderror"
                                        id="empresa" name="empresa" value="{{ old('empresa') }}">
                                    @error('empresa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="profissao" class="form-label">Profissão </label>
                                    <input type="text" class="form-control @error('profissao') is-invalid @enderror"
                                        id="profissao" name="profissao" value="{{ old('profissao') }}">
                                    @error('profissao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Linha 2 - Nome do Responsável, Email, Telefone -->
                                <div class="col-md-4 mb-3">
                                    <label for="nome_responsavel" class="form-label">Nome do Responsável</label>
                                    <input type="text"
                                        class="form-control @error('nome_responsavel') is-invalid @enderror"
                                        id="nome_responsavel" name="nome_responsavel" value="{{ old('nome_responsavel') }}">
                                    @error('nome_responsavel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="telefone" class="form-label">Telefone </label>
                                    <input type="text" class="form-control phone @error('telefone') is-invalid @enderror"
                                        id="telefone" name="telefone" value="{{ old('telefone') }}">
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Linha 3 - Tipo de Cliente (ocupando 4 colunas) -->
                                <div class="col-md-4 mb-3">
                                    <label for="tipo" class="form-label">Tipo de Cliente <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('tipo') is-invalid @enderror" id="tipo"
                                        name="tipo">
                                        <option value="">Selecione</option>
                                        <option value="Particular" {{ old('tipo') == 'Particular' ? 'selected' : '' }}>
                                            Particular</option>
                                        <option value="Tribunal" {{ old('tipo') == 'Tribunal' ? 'selected' : '' }}>Tribunal
                                        </option>
                                        <option value="justiça comum" {{ old('tipo') == 'justiça comum' ? 'selected' : '' }}>Justiça comum
                                        </option>
                                        <option value="justiça gratuita" {{ old('tipo') == 'justiça gratuita' ? 'selected' : '' }}>Justiça gratuita
                                        </option> 
                                        <option value="Perito" {{ old('tipo') == 'Perito' ? 'selected' : '' }}>Perito
                                        </option>
                                        <option value="Assistente Técnico" {{ old('tipo') == 'Assistente Técnico' ? 'selected' : '' }}>Assistente Técnico
                                        </option>
                                    </select>
                                    @error('tipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Botões (ocupando 12 colunas - linha completa) -->
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary me-md-2">
                                            <i class="fa-solid fa-floppy-disk me-1"></i> Salvar
                                        </button>
                                        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                                            <i class="fa-solid fa-arrow-left me-1"></i> Cancelar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
