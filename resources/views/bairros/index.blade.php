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
                                            <a href="{{ route('bairros.index') }}" class="btn btn-outline-secondary"><i
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

                            <div class="table-responsive">
                                <table class="table table-hover table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 border-bottom-0">#</th>
                                            <th class="px-4 py-3 border-bottom-0">Zona</th>
                                            <th class="px-4 py-3 border-bottom-0">Bairro</th>
                                            <th class="px-4 py-3 border-bottom-0">Valor PGM</th>
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
                                                    <td class="px-4">{{ $bairro->zona->nome }}</td>
                                                    <td class="px-4">{{ $bairro->nome }}</td>
                                                    <td class="px-4">{{ $bairro->valor_pgm }}</td>


                                                    <td class="px-4 text-center">
                                                        <x-action-buttons showRoute="bairros.show" editRoute="bairros.edit"
                                                            destroyRoute="bairros.destroy" :itemId="$bairro->id" />
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

                                {{ $bairros->links('vendor.pagination.simple-coreui') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
