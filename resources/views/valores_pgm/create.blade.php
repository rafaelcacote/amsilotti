@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-dollar-sign me-2"></i>Novo Valor PGM</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('valores_pgm.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="bairro_id" class="form-label">Bairro</label>
                                            <select class="form-select @error('bairro_id') is-invalid @enderror"
                                                name="bairro_id" required>
                                                <option value="">Selecione um bairro</option>
                                                @foreach ($bairros as $bairro)
                                                    <option value="{{ $bairro->id }}"
                                                        {{ old('bairro_id') == $bairro->id ? 'selected' : '' }}>
                                                        {{ $bairro->nome }} ({{ $bairro->zona->nome }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('bairro_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="vigencia_id" class="form-label">Vigência</label>
                                            <select class="form-select @error('vigencia_id') is-invalid @enderror"
                                                name="vigencia_id" required>
                                                <option value="">Selecione uma vigência</option>
                                                @foreach ($vigencias as $vigencia)
                                                    <option value="{{ $vigencia->id }}"
                                                        {{ old('vigencia_id') == $vigencia->id ? 'selected' : '' }}>
                                                        {{ $vigencia->descricao }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('vigencia_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="valor" class="form-label">Valor (R$)</label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('valor') is-invalid @enderror" name="valor"
                                                value="{{ old('valor') }}" required>
                                            @error('valor')
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
