@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-upload me-2"></i>Upload de Valores PGM em Massa
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('valores_pgm.upload.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="descricao" class="form-label">Descrição da Vigência</label>
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
                                            <label for="ativo" class="form-label">Ativo</label>
                                            <select class="form-select @error('ativo') is-invalid @enderror" name="ativo"
                                                required>
                                                <option value="1" {{ old('ativo') == '1' ? 'selected' : '' }}>Sim
                                                </option>
                                                <option value="0" {{ old('ativo') == '0' ? 'selected' : '' }}>Não
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
                                        <div class="mb-3">
                                            <label for="dados" class="form-label">Dados dos Valores</label>
                                            <textarea class="form-control @error('dados') is-invalid @enderror" name="dados" rows="15" required
                                                placeholder="Cole os dados aqui (Zona, Bairro, Valor - separados por tabulação ou espaços, um por linha):&#10;SUL	Centro	562.82&#10;SUL	N. S. Aparecida	217.82&#10;CENTRO-SUL	Adrianópolis	550.00">{{ old('dados') }}</textarea>
                                            @error('dados')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                <strong>Formato:</strong> Zona [TAB/ESPAÇOS] Bairro [TAB/ESPAÇOS] Valor<br>
                                                <strong>Exemplo:</strong> SUL Centro 562.82
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-upload me-2"></i>Processar Upload
                                            </button>
                                            <a href="{{ route('valores_pgm.index') }}" class="btn btn-secondary">
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
