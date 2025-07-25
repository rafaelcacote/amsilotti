@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-tasks me-2"></i>Detalhes da Tarefa</h3>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <!-- Seção: Dados da Tarefa -->
                                <div class="col-md-12 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="fas fa-file-alt me-2"></i>Descrição da
                                            Atividade</h6>
                                        <p class="fs-5 mb-0">{{ $controleDeTarefas->descricao_atividade }}</p>
                                    </div>
                                </div>

                                <!-- Seção: Processo -->
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="fas fa-list-alt me-2"></i>Processo</h6>
                                        <p class="fs-5 mb-0">{{ $controleDeTarefas->processo }}</p>
                                    </div>
                                </div>

                                <!-- Seção: Status -->
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="fas fa-info-circle me-2"></i>Tipo de Atividade
                                        </h6>
                                        <p class="fs-5 mb-0">{{ $controleDeTarefas->tipo_atividade }}</p>

                                    </div>
                                </div>

                                <!-- Seção: Prioridade -->
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="fas fa-exclamation-circle me-2"></i>Prioridade
                                        </h6>
                                        {{ $controleDeTarefas->prioridade }}
                                        <span class="badge fs-6 bg-@prioridadeColor($controleDeTarefas->prioridade) py-2 px-3">
                                            {{ $controleDeTarefas->prioridade }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Seção: Membro Responsável -->
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="fas fa-user me-2"></i>Membro Responsável</h6>
                                        <p class="fs-5 mb-0">
                                            {{ $controleDeTarefas->membroEquipe ? $controleDeTarefas->membroEquipe->nome : 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Seção: Data de Início -->
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="far fa-calendar-alt me-2"></i>Data de Início
                                        </h6>
                                        <p class="fs-5 mb-0">
                                            {{ \Carbon\Carbon::parse($controleDeTarefas->data_inicio)->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Seção: Prazo -->
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="fas fa-hourglass-half me-2"></i>Prazo</h6>
                                        <p class="fs-5 mb-0">{{ $controleDeTarefas->prazo }}</p>
                                    </div>
                                </div>

                                <!-- Seção: Data de Término -->
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="far fa-calendar-check me-2"></i>Data de
                                            Término</h6>
                                        <p class="fs-5 mb-0">
                                            {{ \Carbon\Carbon::parse($controleDeTarefas->data_termino)->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Seção: Situação -->
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="fas fa-check-circle me-2"></i>Situação</h6>
                                        <span
                                            class="badge rounded-pill fs-6 py-2 px-3
                                            @if ($controleDeTarefas->situacao == 'em andamento') bg-info text-white
                                            @elseif($controleDeTarefas->situacao == 'atrasado') bg-danger text-white
                                            @elseif($controleDeTarefas->situacao == 'nao iniciada') bg-warning text-dark
                                            @elseif($controleDeTarefas->situacao == 'concluida') bg-success text-white @endif"
                                            style="width: fit-content;">
                                            <i
                                                class="fas
                                                @if ($controleDeTarefas->situacao == 'em andamento') fa-play
                                                @elseif($controleDeTarefas->situacao == 'atrasado') fa-exclamation-triangle
                                                @elseif($controleDeTarefas->situacao == 'nao iniciada') fa-clock
                                                @elseif($controleDeTarefas->situacao == 'concluida') fa-check @endif
                                                me-1"></i>
                                            {{ ucfirst($controleDeTarefas->situacao) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões de Ação -->
                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('controle_de_tarefas.edit', $controleDeTarefas->id) }}"
                                    class="btn btn-warning me-2">
                                    <i class="fas fa-pencil-alt me-2"></i>Editar
                                </a>
                                <a href="{{ route('controle_de_tarefas.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
