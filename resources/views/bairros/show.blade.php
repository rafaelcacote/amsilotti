@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-map-marker-alt me-2"></i>Detalhes do Bairro</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('bairros.edit', $bairro->id) }}" class="btn btn-sm btn-outline-success">
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
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">Informações do Bairro</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">ID</h6>
                                <p class="mb-0 fw-bold">#{{ $bairro->id }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Nome</h6>
                                <p class="mb-0 fw-bold">{{ $bairro->nome }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Zona</h6>
                                <p class="mb-0">
                                    <a href="{{ route('zonas.show', $bairro->zona_id) }}" class="text-decoration-none">
                                        {{ $bairro->zona->nome }}
                                    </a>
                                </p>
                            </div>
                            <div class="mb-0">
                                <h6 class="text-muted mb-1">Data de Criação</h6>
                                <p class="mb-0">{{ $bairro->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Histórico de Valores</h5>
                            <a href="{{ route('valores-bairros.create') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus me-2"></i>Novo Valor
                            </a>
                        </div>
                        <div class="card-body">
                            @if ($bairro->valoresBairro->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Valor</th>
                                                <th>Data de Cadastro</th>
                                                <th class="text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bairro->valoresBairro as $valor)
                                                <tr>
                                                    <td><strong>#{{ $valor->id }}</strong></td>
                                                    <td>R$ {{ number_format($valor->valor, 2, ',', '.') }}</td>
                                                    <td>{{ $valor->created_at->format('d/m/Y H:i') }}</td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <a href="{{ route('valores-bairros.edit', $valor->id) }}" class="btn btn-sm btn-outline-success">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('valores-bairros.destroy', $valor->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir este valor?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-muted mb-0">Nenhum valor cadastrado para este bairro.</p>
                                    <a href="{{ route('valores-bairros.create') }}" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-plus me-2"></i>Adicionar Valor
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