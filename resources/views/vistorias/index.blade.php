@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-clipboard-check me-2"></i>Vistorias</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('vistorias.create') }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                    <span>Nova Vistoria</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Filtro -->
                            <form action="{{ route('vistorias.index') }}" method="GET">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label" for="nome">Nome</label>
                                        <input type="text" class="form-control" id="nome" name="nome"
                                            value="{{ request('nome') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="bairro">Bairro</label>
                                        <input type="text" class="form-control" id="bairro" name="bairro"
                                            value="{{ request('bairro') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="tipo_ocupacao">Tipo de Ocupação</label>
                                        <select class="form-select" id="tipo_ocupacao" name="tipo_ocupacao">
                                            <option value="">Todos</option>
                                            @foreach ($tipoOcupacaoValues as $tipo)
                                                <option value="{{ $tipo }}" {{ request('tipo_ocupacao') == $tipo ? 'selected' : '' }}>
                                                    {{ $tipo }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search me-1"></i> Filtrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="px-4 py-3 border-bottom-0">#</th>
                                            <th class="px-4 py-3 border-bottom-0">Nome</th>
                                            <th class="px-4 py-3 border-bottom-0">Endereço</th>
                                            <th class="px-4 py-3 border-bottom-0">Bairro</th>
                                            <th class="px-4 py-3 border-bottom-0">Tipo Ocupação</th>
                                            <th class="px-4 py-3 border-bottom-0">Data Criação</th>
                                            <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($vistorias->count() > 0)
                                            @foreach ($vistorias as $vistoria)
                                                <tr class="border-bottom border-light">
                                                    <td class="px-4 fw-medium text-muted">
                                                        <strong>#{{ $vistoria->id }}</strong>
                                                    </td>
                                                    <td class="px-4">{{ $vistoria->nome }}</td>
                                                    <td class="px-4">{{ $vistoria->endereco }}, {{ $vistoria->num }}</td>
                                                    <td class="px-4">{{ $vistoria->bairro }}</td>
                                                    <td class="px-4">
                                                        <span class="badge bg-{{ $vistoria->tipo_ocupacao == 'Residencial' ? 'success' : ($vistoria->tipo_ocupacao == 'Comercial' ? 'primary' : 'warning') }}">
                                                            {{ $vistoria->tipo_ocupacao }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4">{{ $vistoria->created_at->format('d/m/Y') }}</td>
                                                    <td class="px-4 text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('vistorias.show', $vistoria->id) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('vistorias.edit', $vistoria->id) }}"
                                                                class="btn btn-sm btn-outline-secondary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('vistorias.destroy', $vistoria->id) }}"
                                                                method="POST" class="d-inline"
                                                                onsubmit="return confirm('Tem certeza que deseja excluir esta vistoria?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <p class="mb-0 text-muted">Nenhuma vistoria encontrada.</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="px-4 py-3">
                                {{ $vistorias->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection