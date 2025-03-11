@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-map-marker-alt me-2"></i>Bairros</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('bairros.create') }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                    <span>Novo Bairro</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Filtro -->
                            <form action="{{ route('bairros.index') }}" method="GET">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-6">
                                        <label class="form-label" for="zona_id">Zona</label>
                                        <select class="form-select" id="zona_id" name="zona_id">
                                            <option value="">Todas</option>
                                            @foreach ($zonas as $zona)
                                                <option value="{{ $zona->id }}"
                                                    {{ request('zona_id') == $zona->id ? 'selected' : '' }}>
                                                    {{ $zona->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-search me-2"></i>Filtrar</button>
                                            <a href="{{ route('bairros.index') }}"
                                                class="btn btn-outline-secondary"><i
                                                    class="fas fa-times me-2"></i>Limpar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-hover table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 border-bottom-0">#</th>
                                            <th class="px-4 py-3 border-bottom-0">Nome</th>
                                            <th class="px-4 py-3 border-bottom-0">Zona</th>
                                            <th class="px-4 py-3 border-bottom-0">Valor Atual</th>
                                            <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($bairros->count() > 0)
                                            @foreach ($bairros as $bairro)
                                                <tr class="border-bottom border-light">
                                                    <td class="px-4 fw-medium text-muted">
                                                        <strong>#{{ $bairro->id }}</strong>
                                                    </td>
                                                    <td class="px-4">{{ $bairro->nome }}</td>
                                                    <td class="px-4">{{ $bairro->zona->nome }}</td>
                                                    <td class="px-4">
                                                        @if ($bairro->valorAtual)
                                                            R$ {{ number_format($bairro->valorAtual->valor, 2, ',', '.') }}
                                                        @else
                                                            <span class="text-muted">Não definido</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 text-center">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <a href="{{ route('bairros.show', $bairro->id) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('bairros.edit', $bairro->id) }}"
                                                                class="btn btn-sm btn-outline-success">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('bairros.destroy', $bairro->id) }}" method="POST"
                                                                class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Tem certeza que deseja excluir este bairro?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <p class="text-muted mb-0">Nenhum bairro encontrado.</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {{ $bairros->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection