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
                        <form action="{{ route('clientes.store') }}" method="POST" class="row g-3 needs-validation" novalidate>
                            @csrf

                            <!-- Nome e Empresa -->
                            <div class="col-md-6 mb-3">
                                <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" required>
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="empresa" class="form-label">Empresa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('empresa') is-invalid @enderror" id="empresa" name="empresa" value="{{ old('empresa') }}" required>
                                @error('empresa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nome do Responsável e Profissão -->
                            <div class="col-md-6 mb-3">
                                <label for="nome_responsavel" class="form-label">Nome do Responsável </label>
                                <input type="text" class="form-control @error('nome_responsavel') is-invalid @enderror" id="nome_responsavel" name="nome_responsavel" value="{{ old('nome_responsavel') }}" required>
                                @error('nome_responsavel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="profissao" class="form-label">Profissão <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('profissao') is-invalid @enderror" id="profissao" name="profissao" value="{{ old('profissao') }}" required>
                                @error('profissao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email e Telefone -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control telefone-mask @error('telefone') is-invalid @enderror" id="telefone" name="telefone" value="{{ old('telefone') }}" required>
                                @error('telefone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <!-- Botões -->
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