@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-map-marked-alt me-2"></i>Zonas</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('zonas.create') }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                    <span>Nova Zona</span>
                                </a>
                            </div>
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
                                            <th class="px-4 py-3 border-bottom-0">Data Criação</th>
                                            <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($zonas->count() > 0)
                                            @foreach ($zonas as $zona)
                                                <tr class="border-bottom border-light">
                                                    <td class="px-4 fw-medium text-muted">
                                                        <strong>#{{ $zona->id }}</strong>
                                                    </td>
                                                    <td class="px-4">{{ $zona->nome }}</td>
                                                    <td class="px-4">{{ $zona->tipo }}</td>
                                                    <td class="px-4 fw-medium text-muted">
                                                        {{ $zona->created_at->format('d/m/Y H:i') }}</td>
                                                    <td class="px-4 text-center">
                                                        <x-action-buttons showRoute="zonas.show" editRoute="zonas.edit"
                                                            destroyRoute="zonas.destroy" :itemId="$zona->id" />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <p class="text-muted mb-0">Nenhuma zona encontrada.</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {{ $zonas->links('vendor.pagination.simple-coreui') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
