@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-map-signs me-2"></i>Novo Valor de Bairro</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('valores-bairros.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="bairro_id" class="form-label">Bairro</label>
                                    <select class="form-select @error('bairro_id') is-invalid @enderror" id="bairro_id" name="bairro_id" required>
                                        <option value="">Selecione um bairro</option>
                                        @foreach ($bairros as $bairro)
                                            <option value="{{ $bairro->id }}" {{ old('bairro_id') == $bairro->id ? 'selected' : '' }}>
                                                {{ $bairro->nome }} ({{ $bairro->zona->nome }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bairro_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="valor" class="form-label">Valor</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" step="0.01" min="0" class="form-control @error('valor') is-invalid @enderror" id="valor" name="valor" value="{{ old('valor') }}" required>
                                        @error('valor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Salvar
                                    </button>
                                    <a href="{{ route('valores-bairros.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Cancelar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection