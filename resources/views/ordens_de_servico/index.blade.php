@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                        <h3 class="mb-0 text-primary"><i class="cil-list me-2"></i>Ordens de Serviço</h3>
                        <div class="d-flex gap-2">
                            <a href="{{ route('ordens-de-servico.create') }}"
                               class="btn btn-sm btn-outline-primary">
                               <i class="cil-plus me-2"></i>Nova Ordem
                            </a>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        @include('ordens_de_servico._filter')
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
                                <thead class="small text-muted bg-blue-50">
                                    <tr>
                                        <th class="px-4 py-3 border-bottom-0">ID</th>
                                        <th class="px-4 py-3 border-bottom-0">Descrição</th>
                                        <th class="px-4 py-3 border-bottom-0">Responsável</th>
                                        <th class="px-4 py-3 border-bottom-0">Status</th>
                                        <th class="px-4 py-3 border-bottom-0 text-end" style="width: 140px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ordens as $ordem)
                                    <tr class="border-bottom border-light">
                                        <td class="px-4 fw-medium text-muted">#{{ $ordem->id }}</td>
                                        <td class="px-4">{{ Str::limit($ordem->descricao, 35) }}</td>
                                        <td class="px-4">
                                            <div class="d-flex align-items-center">
                                                <span class="text-muted">{{ $ordem->user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4">
                                            <span class="badge fs-xs rounded-pill bg-{{ statusColor($ordem->status) }}">
                                                {{ $ordem->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 text-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="{{ route('ordens-de-servico.show', $ordem->id) }}"
                                                   class="btn btn-icon btn-sm btn-outline-secondary rounded-circle"
                                                   data-coreui-toggle="tooltip"
                                                   title="Visualizar">
                                                    <i class="cil-magnifying-glass"></i>
                                                </a>
                                                <a href="{{ route('ordens-de-servico.edit', $ordem->id) }}"
                                                   class="btn btn-icon btn-sm btn-outline-secondary rounded-circle"
                                                   data-coreui-toggle="tooltip"
                                                   title="Editar">
                                                    <i class="cil-pencil"></i>
                                                </a>
                                                <form action="{{ route('ordens-de-servico.destroy', $ordem->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-icon btn-sm btn-outline-secondary rounded-circle"
                                                            data-coreui-toggle="tooltip"
                                                            title="Excluir"
                                                            onclick="return confirm('Confirmar exclusão?')">
                                                        <i class="cil-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($ordens->hasPages())
                        <div class="card-footer bg-white border-top">
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <div class="text-muted small">
                                    Exibindo {{ $ordens->firstItem() }} - {{ $ordens->lastItem() }} de {{ $ordens->total() }}
                                </div>
                                <div>
                                    {{ $ordens->links('vendor.pagination.simple-coreui') }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@php
function statusColor($status) {
    $status = strtolower($status);
    return [
        'pendente' => 'warning-soft',
        'em andamento' => 'danger-soft',
        'concluída' => 'success-soft',
        'cancelada' => 'danger-soft',
    ][$status] ?? 'secondary-soft';
}
@endphp

<style>
.bg-blue-50 { background-color: #f8f9fe; }
.bg-warning-soft { background-color: #fff3cd; color: #856404; }
.bg-info-soft { background-color: #d1ecf1; color: #0c5460; }
.bg-success-soft { background-color: #d4edda; color: #155724; }
.bg-danger-soft { background-color: #f8d7da; color: #721c24; }
.bg-secondary-soft { background-color: #e2e3e5; color: #383d41; }
.btn-icon { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; }
</style>
