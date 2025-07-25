@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-road me-2"></i>Vias Específicas</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('vias-especificas.create') }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                    <span>Nova Via</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Filtro -->
                            <form action="{{ route('vias-especificas.index') }}" method="GET">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-6">
                                        <label class="form-label" for="trecho">Trecho</label>
                                        <input type="text" class="form-control" id="trecho" name="trecho"
                                            value="{{ request('trecho') }}" placeholder="Filtrar por trecho">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-search me-2"></i>Filtrar</button>
                                            <a href="{{ route('vias-especificas.index') }}"
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
                            <div class="table-responsive">
                                <table class="table table-hover table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 border-bottom-0">#</th>
                                            <th class="px-4 py-3 border-bottom-0">Nome</th>
                                            <th class="px-4 py-3 border-bottom-0">Trecho</th>
                                            <th class="px-4 py-3 border-bottom-0">Valor</th>
                                            <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($vias->count() > 0)
                                            @foreach ($vias as $via)
                                                <tr class="border-bottom border-light">
                                                    <td class="px-4 fw-medium text-muted">
                                                        <strong>#{{ $via->id }}</strong>
                                                    </td>
                                                    <td class="px-4">{{ $via->nome }}</td>
                                                    <td class="px-4">{{ $via->trecho }}</td>
                                                    <td class="px-4">R$ {{ $via->valor }}</td>
                                                    <td class="px-4 text-center">
                                                        <x-action-buttons showRoute="vias-especificas.show"
                                                            editRoute="vias-especificas.edit"
                                                            destroyRoute="vias-especificas.destroy" :showButton="false"
                                                            :itemId="$via->id" />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <p class="text-muted mb-0">Nenhuma via encontrada.</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {{ $vias->links('vendor.pagination.simple-coreui') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
