@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-road me-2"></i>Nova Via Específica</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('vias-especificas.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                        id="nome" name="nome" value="{{ old('nome') }}">
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="trecho" class="form-label">Trecho</label>
                                    <input type="text" class="form-control @error('trecho') is-invalid @enderror"
                                        id="trecho" name="trecho" value="{{ old('trecho') }}">
                                    @error('trecho')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="valor" class="form-label">Valor</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="text"
                                            class="form-control money @error('valor') is-invalid @enderror" id="valor"
                                            name="valor" value="{{ old('valor') }}">
                                        @error('valor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Salvar
                                    </button>
                                    <a href="{{ route('vias-especificas.index') }}" class="btn btn-outline-secondary">
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
