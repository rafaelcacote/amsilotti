@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-calendar me-2"></i>Nova Vigência PGM</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('vigencia_pgm.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="descricao" class="form-label">Descrição</label>
                                            <input type="text"
                                                class="form-control @error('descricao') is-invalid @enderror"
                                                name="descricao" value="{{ old('descricao') }}" required>
                                            @error('descricao')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="data_inicio" class="form-label">Data Início</label>
                                            <input type="date"
                                                class="form-control @error('data_inicio') is-invalid @enderror"
                                                name="data_inicio" value="{{ old('data_inicio') }}" required>
                                            @error('data_inicio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="data_fim" class="form-label">Data Fim</label>
                                            <input type="date"
                                                class="form-control @error('data_fim') is-invalid @enderror" name="data_fim"
                                                value="{{ old('data_fim') }}" required>
                                            @error('data_fim')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="ativo" class="form-label">Status</label>
                                            <select class="form-select @error('ativo') is-invalid @enderror" name="ativo"
                                                required>
                                                <option value="1" {{ old('ativo') == '1' ? 'selected' : '' }}>Ativo
                                                </option>
                                                <option value="0" {{ old('ativo') == '0' ? 'selected' : '' }}>Inativo
                                                </option>
                                            </select>
                                            @error('ativo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-2"></i>Salvar
                                            </button>
                                            <a href="{{ route('vigencia_pgm.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left me-2"></i>Voltar
                                            </a>
                                        </div>
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
