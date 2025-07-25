@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-map-marked-alt me-2"></i>Detalhes da Zona</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('zonas.edit', $zona->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit me-2"></i>Editar
                                </a>
                                <a href="{{ route('zonas.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">Informações da Zona</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">ID</h6>
                                <p class="mb-0 fw-bold">#{{ $zona->id }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Nome</h6>
                                <p class="mb-0 fw-bold">{{ $zona->nome }}</p>
                            </div>
                            <div class="mb-0">
                                <h6 class="text-muted mb-1">Data de Criação</h6>
                                <p class="mb-0">{{ $zona->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Bairros nesta Zona</h5>
                            <a href="{{ route('bairros.create') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus me-2"></i>Novo Bairro
                            </a>
                        </div>
                        <div class="card-body">
                            @if ($zona->bairros->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nome</th>
                                                <th>Valor Atual</th>
                                                <th class="text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($zona->bairros as $bairro)
                                                <tr>
                                                    <td><strong>#{{ $bairro->id }}</strong></td>
                                                    <td>{{ $bairro->nome }}</td>
                                                    <td>
                                                        @if ($bairro->valorAtual)
                                                            R$ {{ number_format($bairro->valorAtual->valor, 2, ',', '.') }}
                                                        @else
                                                            <span class="text-muted">Não definido</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            {{-- <a href="{{ route('bairros.show', $bairro->id) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('bairros.edit', $bairro->id) }}"
                                                                class="btn btn-sm btn-outline-success">
                                                                <i class="fas fa-edit"></i>
                                                            </a> --}}
                                                            <x-action-buttons showRoute="bairros.show"
                                                                editRoute="bairros.edit" destroyRoute="bairros.destroy"
                                                                :itemId="$bairro->id" :deleteButton="false" />
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-muted mb-0">Nenhum bairro cadastrado nesta zona.</p>
                                    <a href="{{ route('bairros.create') }}" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-plus me-2"></i>Adicionar Bairro
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
