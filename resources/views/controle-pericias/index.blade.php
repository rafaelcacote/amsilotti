@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-gavel me-2"></i>Controle de Perícias</h3>
                            <div class="d-flex gap-2">
                                @can('create pericias')
                                    <a href="{{ route('controle-pericias.create') }}"
                                        class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2"
                                        style="transition: all 0.2s ease;">
                                        <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                        <span>Nova Perícia</span>
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Collapse Filtros -->
                            <button class="btn btn-outline-primary mb-3 w-100 d-flex align-items-center justify-content-center gap-2" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" aria-expanded="false" aria-controls="filtrosCollapse" style="font-size:1.1rem;">
                                <i class="fas fa-filter"></i>
                                <span>Filtros de Pesquisa</span>
                            </button>
                            <div class="collapse{{ request()->hasAny(['search','vara','responsavel_tecnico_id','tipo_pericia','status_atual','prazo_final_inicio','prazo_final_fim']) ? ' show' : '' }}" id="filtrosCollapse">
                                <div class="card card-body border-0 shadow-sm mb-3">
                                    <form action="{{ route('controle-pericias.index') }}" method="GET">
                                        @csrf
                                        <div class="row align-items-end">
                                            <div class="col-md-2">
                                                <label class="form-label" for="search">Buscar</label>
                                                <input type="text" name="search" value="{{ $search ?? '' }}"
                                                    placeholder="Buscar por processo, parte ou vara..." class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="vara">Vara</label>
                                                <select class="form-select" name="vara" id="vara">
                                                    <option value="">Todas</option>
                                                    @foreach (App\Models\ControlePericia::varasOptions() as $varaOption)
                                                        <option value="{{ $varaOption }}"
                                                            {{ request('vara') == $varaOption ? 'selected' : '' }}>
                                                            {{ $varaOption }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="responsavel_tecnico_id">Responsável Técnico</label>
                                                <select class="form-select" name="responsavel_tecnico_id"
                                                    id="responsavel_tecnico_id">
                                                    <option value="">Todos</option>
                                                    @foreach ($responsaveis as $responsavel)
                                                        <option value="{{ $responsavel->id }}"
                                                            {{ $responsavelId == $responsavel->id ? 'selected' : '' }}>
                                                            {{ $responsavel->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="tipo_pericia">Tipo de Perícia</label>
                                                <select class="form-select" name="tipo_pericia" id="tipo_pericia">
                                                    <option value="">Todos</option>
                                                    @foreach (App\Models\ControlePericia::tipopericiaOptions() as $tipopericiaOption)
                                                        <option value="{{ $tipopericiaOption }}"
                                                            {{ $tipoPericia == $tipopericiaOption ? 'selected' : '' }}>
                                                            {{ $tipopericiaOption }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="status_atual">Status</label>
                                                <select class="form-select" name="status_atual" id="status_atual">
                                                    <option value="">Todos</option>
                                                    @foreach (App\Models\ControlePericia::statusOptions() as $statusOption)
                                                        <option value="{{ $statusOption }}"
                                                            {{ $status == $statusOption ? 'selected' : '' }}>
                                                            {{ $statusOption }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="prazo_final_inicio">Data Entregue (De)</label>
                                                <input type="date" class="form-control" name="prazo_final_inicio" id="prazo_final_inicio" value="{{ request('prazo_final_inicio') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="prazo_final_fim">Data Entregue (Até)</label>
                                                <input type="date" class="form-control" name="prazo_final_fim" id="prazo_final_fim" value="{{ request('prazo_final_fim') }}">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 d-flex justify-content-center">
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search me-2"></i>Pesquisar</button>
                                                    <a href="{{ route('controle-pericias.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times me-2"></i>Limpar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <!-- Contadores de Perícias -->
                            <div class="mb-3 d-flex gap-3 align-items-center flex-wrap">
                                <div class="bg-white shadow-sm rounded px-4 py-3 d-flex align-items-center gap-2">
                                    <span class="fw-semibold text-primary" style="font-size: 1.1rem;">
                                        <i class="fas fa-database me-2"></i>Total cadastradas:
                                    </span>
                                    <span class="badge bg-primary fs-5">{{ $totalPericias ?? $pericias->total() }}</span>
                                </div>
                                <div class="bg-white shadow-sm rounded px-4 py-3 d-flex align-items-center gap-2">
                                    <span class="fw-semibold text-success" style="font-size: 1.1rem;">
                                        <i class="fas fa-filter me-2"></i>Exibindo:
                                    </span>
                                    <span class="badge bg-success fs-5">{{ $pericias->count() }}</span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 border-bottom-0">Nº Processo</th>
                                            <th class="px-4 py-3 border-bottom-0">Requerente</th>
                                            <th class="px-4 py-3 border-bottom-0">Requerido</th>
                                            <th class="px-4 py-3 border-bottom-0">Vara</th>
                                            <th class="px-4 py-3 border-bottom-0">Responsável</th>
                                            <th class="px-4 py-3 border-bottom-0">Tipo de Perícia</th>
                                            <th class="px-4 py-3 border-bottom-0">Status</th>
                                            <th class="px-4 py-3 border-bottom-0">Laudo Entregue</th>
                                            <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($pericias->count() > 0)
                                            @foreach ($pericias as $pericia)
                                                <tr class="border-bottom border-light">

                                                    <td class="px-4">
                                                        @if ($pericia->numero_processo)
                                                            <a href="https://consultasaj.tjam.jus.br/cpopg/search.do?cbPesquisa=NUMPROC&dadosConsulta.valorConsulta={{ $pericia->numero_processo }}"
                                                                target="_blank" class="d-inline-block text-truncate"
                                                                style="max-width: 200px;" data-coreui-toggle="tooltip"
                                                                data-coreui-placement="top"
                                                                title="{{ $pericia->numero_processo }}">
                                                                {{ $pericia->numero_processo }}
                                                            </a>
                                                        @else
                                                            <span class="text-muted small opacity-75 fst-italic">sem
                                                                processo</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4">
                                                        {{ $pericia->requerente ? $pericia->requerente->nome : '-' }}
                                                    </td>
                                                    <td class="px-4">
                                                        {{ $pericia->requerido ?? '-' }}
                                                    </td>
                                                    <td class="px-4">{{ $pericia->vara }}</td>
                                                    <td class="px-4">
                                                        {{ $pericia->responsavelTecnico ? $pericia->responsavelTecnico->nome : 'Não atribuído' }}
                                                    </td>
                                                    <td class="px-4">
                                                        {{ $pericia->tipo_pericia ?: 'Não informado' }}
                                                    </td>
                                                    <td class="px-4">
                                                        @php
                                                            $statusClass = match (strtolower($pericia->status_atual)) {
                                                                'aguardando vistoria' => 'bg-info',
                                                                'em redação', 'em redacao' => 'bg-primary',
                                                                'aguardando pagamento' => 'bg-warning',
                                                                'aguardando documentação' => 'bg-secondary',
                                                                'concluído', 'concluido', 'entregue' => 'bg-success',
                                                                'cancelado' => 'bg-danger',
                                                                default => 'bg-light text-dark',
                                                            };
                                                        @endphp
                                                        <span
                                                            class="badge {{ $statusClass }}">{{ $pericia->status_atual }}</span>
                                                    </td>
                                                    <td class="px-4">
                                                        {{ $pericia->prazo_final ? $pericia->prazo_final->format('d/m/Y') : 'Não definido' }}
                                                    </td>
                                                    <td class="px-4">
                                                        <x-action-buttons-pericias showRoute="controle-pericias.show"
                                                            editRoute="controle-pericias.edit"
                                                            destroyRoute="controle-pericias.destroy"
                                                            printRoute="controle-pericias.print" :itemId="$pericia->id"
                                                            title="Confirmar Exclusão"
                                                            message="Tem certeza que deseja excluir esta perícia?" />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="text-center py-4">
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
                                {{ $pericias->links('vendor.pagination.simple-coreui') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('agenda_criada'))
        <!-- Modal de Confirmação de Agenda -->
        <div class="modal fade" id="modalAgendaCriada" tabindex="-1" aria-labelledby="modalAgendaCriadaLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgendaCriadaLabel">Evento criado na Agenda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Tipo:</strong> {{ session('agenda_criada.tipo') }}</p>
                        <p><strong>Data:</strong>
                            {{ \Carbon\Carbon::parse(session('agenda_criada.data'))->format('d/m/Y') }}</p>
                        <p><strong>Título:</strong> {{ session('agenda_criada.titulo') }}</p>
                        <p><strong>Status:</strong> {{ session('agenda_criada.status') }}</p>
                        <p><strong>Local:</strong> {{ session('agenda_criada.local') ?? '-' }}</p>
                        <p><strong>Notas:</strong> {{ session('agenda_criada.nota') ?? '-' }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                var modal = new bootstrap.Modal(document.getElementById('modalAgendaCriada'));
                modal.show();
            });
        </script>
    @endif
@endsection
