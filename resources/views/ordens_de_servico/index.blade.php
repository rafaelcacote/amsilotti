@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-clipboard-list me-2"></i>Ordens de Serviço</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('ordens-de-servico.create') }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                    <span>Nova Ordem</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Filtro -->
                            <form action="{{ route('ordens-de-servico.index') }}" method="GET">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label" for="status">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="">Todos</option>
                                            @foreach ($statusValues as $status)
                                                <option value="{{ $status }}"
                                                    {{ request('status') == $status ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="user_id">Responsável</label>
                                        <select class="form-select" id="user_id" name="user_id">
                                            <option value="">Todos</option>
                                            @foreach ($membros as $membro)
                                                <option value="{{ $membro->id }}"
                                                    {{ request('user_id') == $membro->id ? 'selected' : '' }}>
                                                    {{ $membro->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-search me-2"></i>Pesquisar</button>
                                            <a href="{{ route('ordens-de-servico.index') }}"
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
                                            <th class="px-4 py-3 border-bottom-0">Descrição</th>
                                            <th class="px-4 py-3 border-bottom-0">Responsável</th>
                                            <th class="px-4 py-3 border-bottom-0">Data Criação</th>
                                            <th class="px-4 py-3 border-bottom-0">Status</th>
                                            <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($ordens->count() > 0)
                                            @foreach ($ordens as $ordem)
                                                <tr class="border-bottom border-light">
                                                    <td class="px-4 fw-medium text-muted">
                                                        <strong>#{{ $ordem->id }}</strong>
                                                    </td>
                                                    <td class="px-4">{{ Str::limit($ordem->descricao, 35) }}</td>
                                                    <td class="px-4">
                                                        <div class="d-flex align-items-center">
                                                            <span
                                                                class="text-muted">{{ $ordem->membroEquipeTecnica->nome }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 fw-medium text-muted">
                                                        {{ $ordem->created_at->format('d/m/Y H:i') }}</td>
                                                    <td class="px-4">
                                                        <span class="badge fs-xs bg-@statusColor($ordem->status)">
                                                            {{ $ordem->status }}
                                                        </span>
                                                    </td>

                                                    <td class="px-4">
                                                        <div class="d-flex gap-2">
                                                            <a class="btn btn-light"
                                                                href="{{ route('ordens-de-servico.show', $ordem->id) }}">
                                                                <i class="fa-solid fa-magnifying-glass text-info"></i>
                                                            </a>
                                                            <a class="btn btn-light"
                                                                href="{{ route('ordens-de-servico.edit', $ordem->id) }}">
                                                                <i class="fa-solid fa-pen-to-square text-warning"></i>
                                                            </a>
                                                            <x-delete-modal :id="$ordem->id" title="Confirmar Exclusão"
                                                                message="Tem certeza que deseja excluir esta ordem de serviço?"
                                                                :route="route(
                                                                    'ordens-de-servico.destroy',
                                                                    $ordem->id,
                                                                )" buttonLabel="Excluir" />
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $ordem->id }}">
                                                                <i class="fa-solid fa-trash-can text-danger"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                                        <h5 class="text-muted">Nenhum registro encontrado</h5>
                                                        <p class="text-muted">Tente ajustar os filtros de pesquisa</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end mt-3">

                                {{ $ordens->links('vendor.pagination.simple-coreui') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
