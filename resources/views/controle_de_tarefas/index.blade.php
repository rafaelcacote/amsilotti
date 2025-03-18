@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-tasks me-2"></i>Controle de Tarefas</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('controle_de_tarefas.create') }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                    <span>Nova Tarefa</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Filtro -->
                            <form action="{{ route('controle_de_tarefas.index') }}" method="GET">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label" for="processo">Processo</label>
                                        <input type="text" class="form-control" id="processo" name="processo"
                                            value="{{ request('processo') }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label" for="prioridade">Prioridade</label>
                                        <select class="form-select" id="prioridade" name="prioridade">
                                            <option value="">Todas</option>
                                            @foreach ($getPrioridadeValues as $prioridade)
                                                <option value="{{ $prioridade }}" {{ request('prioridade') == $prioridade ? 'selected' : '' }}>
                                                    {{ $prioridade }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="situacao">Situação</label>
                                        <select class="form-select" id="situacao" name="situacao">
                                            <option value="">Todas</option>
                                            @foreach ($getSituacaoValues as $situacao)
                                                <option value="{{ $situacao }}" {{ request('situacao') == $situacao ? 'selected' : '' }}>
                                                    {{ $situacao }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-search me-2"></i>Pesquisar</button>
                                            <a href="{{ route('controle_de_tarefas.index') }}"
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
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="px-4 py-3 border-bottom-0">#</th>
                                            <th class="px-4 py-3 border-bottom-0">Descrição da Atividade</th>
                                            <th class="px-4 py-3 border-bottom-0">Status</th>
                                            <th class="px-4 py-3 border-bottom-0">Responsável</th>
                                            <th class="px-4 py-3 border-bottom-0">Prazo</th>
                                            <th class="px-4 py-3 border-bottom-0">Situação</th>
                                            <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($tarefas->count() > 0)
                                            @foreach ($tarefas as $tarefa)
                                                <tr class="border-bottom border-light">
                                                    <td class="px-4 fw-medium text-muted">
                                                        <strong>#{{ $tarefa->id }}</strong>
                                                    </td>

                                                    <td class="px-4">{{ $tarefa->descricao_atividade }}</td>
                                                    <td class="px-4">

                                                        {{ $tarefa->status }}
                                                    </td>
                                                    <td class="px-4">{{ $tarefa->membroEquipe->nome ?? '' }}</td>
                                                    <td class="px-4">{{ $tarefa->prazo }}</td>
                                                    <td class="px-4">
                                                        <span class="badge fs-xs bg-@statusColor($tarefa->situacao)">
                                                            {{ $tarefa->situacao }}
                                                        </span>
                                                        </td>
                                                    <td class="px-4 text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('controle_de_tarefas.show', $tarefa->id) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('controle_de_tarefas.edit', $tarefa->id) }}"
                                                                class="btn btn-sm btn-outline-secondary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $tarefa->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>

                                                            <!-- Modal de exclusão -->
                                                            <x-delete-modal
                                                                :id="$tarefa->id"
                                                                title="Confirmar Exclusão"
                                                                message="Tem certeza que deseja excluir esta tarefa?"
                                                                :route="route('controle_de_tarefas.destroy', $tarefa->id)"
                                                                buttonLabel="Excluir"
                                                            />
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="11" class="text-center py-4">
                                                    <p class="mb-0 text-muted">Nenhuma tarefa encontrada.</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="px-4 py-3">
                                {{ $tarefas->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection