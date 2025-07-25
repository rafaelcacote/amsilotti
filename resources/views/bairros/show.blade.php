@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-map-marker-alt me-2"></i>Detalhes do Bairro</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('bairros.edit', $bairro->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit me-2"></i>Editar
                                </a>
                                <a href="{{ route('bairros.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">Informações do Bairro</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-1">ID</h6>
                                    <p class="mb-0 fw-bold">#{{ $bairro->id }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-1">Nome</h6>
                                    <p class="mb-0 fw-bold">{{ $bairro->nome }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-1">Zona</h6>
                                    <p class="mb-0">
                                        <a href="{{ route('zonas.show', $bairro->zona_id) }}" class="text-decoration-none">
                                            {{ $bairro->zona->nome }}
                                        </a>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-1">PGM</h6>
                                    <p class="mb-0 fw-bold">{{ $bairro->valor_pgm }}</p>
                                </div>
                                <div class="col-md-12">
                                    <h6 class="text-muted mb-1">Data de Criação</h6>
                                    <p class="mb-0">{{ $bairro->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
