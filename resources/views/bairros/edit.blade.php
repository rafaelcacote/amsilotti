@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-map-marker-alt me-2"></i>Editar Bairro</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('bairros.update', $bairro->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label for="nome" class="form-label">Nome do Bairro</label>
                                        <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                            id="nome" name="nome" value="{{ old('nome', $bairro->nome) }}" required>
                                        @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label for="zona_id" class="form-label">Zona</label>
                                        <select class="form-select @error('zona_id') is-invalid @enderror" id="zona_id"
                                            name="zona_id" required>
                                            <option value="">Selecione uma zona</option>
                                            @foreach ($zonas as $zona)
                                                <option value="{{ $zona->id }}"
                                                    {{ old('zona_id', $bairro->zona_id) == $zona->id ? 'selected' : '' }}>
                                                    {{ $zona->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('zona_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label for="valor" class="form-label">Valor</label>
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input type="text"
                                                class="form-control money @error('valor_pgm') is-invalid @enderror"
                                                id="valor_pgm" name="valor_pgm"
                                                value="{{ old('valor_pgm', $bairro->valor_pgm) }}" required>
                                            @error('valor_pgm')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                </div>




                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Atualizar
                            </button>
                            <a href="{{ route('bairros.index') }}" class="btn btn-outline-secondary">
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
