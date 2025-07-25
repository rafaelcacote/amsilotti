@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-tasks me-2"></i>Controle de Tarefas</h3>
                            <div class="d-flex gap-2">
                                @can('create tarefas')
                                <a href="{{ route('controle_de_tarefas.create') }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                    <span>Nova Tarefa</span>
                                </a>
                                @endcan
                                @can('export tarefas')
                                <button onclick="imprimirTarefas()"
                                    class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fas fa-print" style="font-size: 0.9rem;"></i>
                                    <span>Imprimir</span>
                                </button>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Filtro -->
                            <form action="{{ route('controle_de_tarefas.index') }}" method="GET">
                                @csrf
                                <div class="row align-items-end">
                                    
                                    <div class="col-md-3">
                                        <label class="form-label" for="cliente">Cliente</label>
                                        <input type="text" class="form-control" id="cliente" name="cliente"
                                            value="{{ request('cliente') }}" placeholder="Digite o nome do cliente">
                                    </div>

                                    <div class="col-md-1">
                                        <label class="form-label" for="prioridade">Prioridade</label>
                                        <select class="form-select" id="prioridade" name="prioridade">
                                            <option value="">Todas</option>
                                            @foreach ($getPrioridadeValues as $prioridade)
                                                <option value="{{ $prioridade }}"
                                                    {{ request('prioridade') == $prioridade ? 'selected' : '' }}>
                                                    {{ $prioridade }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="situacao">Situação</label>
                                        <select class="form-select" id="situacao" name="situacao">
                                            <option value="">Todas</option>
                                            @foreach (App\Models\ControleDeTarefas::situacaoOptions() as $option)
                                                <option value="{{ $option }}"
                                                    {{ old('situacao') == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="tipo_atividade" class="form-label">Tipo de Atividade</label>
                                        <select class="form-select @error('tipo_atividade') is-invalid @enderror"
                                            id="tipo_atividade" name="tipo_atividade">
                                            <option value="">Selecione</option>
                                            @foreach (App\Models\ControleDeTarefas::tipoatividadeOptions() as $option)
                                                <option value="{{ $option }}"
                                                    {{ old('tipo_atividade') == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('tipo_atividade')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="responsavel">Responsável</label>
                                        <select class="form-select" id="responsavel" name="responsavel">
                                            <option value="">Todos</option>
                                            @foreach ($membros as $membro)
                                                <option value="{{ $membro->id }}"
                                                    {{ request('responsavel') == $membro->id ? 'selected' : '' }}>
                                                    {{ $membro->usuario->name ?? 'Nome não disponível' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
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
                            <div class="table-responsive" style="overflow-x: auto;">
                                <table class="table table-hover table-striped align-middle" style="min-width: 1200px;">
                                    <thead class="bg-light">
                                        <tr>
                                            <!-- <th class="px-4 py-3 border-bottom-0">#</th> -->
                                            <th class="px-4 py-3 border-bottom-0">Processo</th>
                                            <th class="px-4 py-3 border-bottom-0">Cliente</th>
                                            <th class="px-4 py-3 border-bottom-0">Tipo de Atividade</th>
                                            {{-- <th class="px-4 py-3 border-bottom-0">Descrição da Atividade</th> --}}
                                            <th class="px-4 py-3 border-bottom-0">Responsável</th>
                                            <th class="px-4 py-3 border-bottom-0">Prioridade</th>
                                            <th class="px-4 py-3 border-bottom-0">Prazo</th>
                                            <th class="px-4 py-3 border-bottom-0">Situação</th>
                                            <th class="px-4 py-3 border-bottom-0">Status</th>
                                            <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($tarefas->count() > 0)
                                            @foreach ($tarefas as $tarefa)
                                                <tr class="border-bottom border-light">
                                                    <!-- <td class="px-4 fw-medium text-muted">
                                                                                                                <strong>#{{ $tarefa->id }}</strong>
                                                                                                            </td> -->
                                                    <td class="px-4">
                                                        @if ($tarefa->processo)
                                                            <a href="https://consultasaj.tjam.jus.br/cpopg/search.do?cbPesquisa=NUMPROC&dadosConsulta.valorConsulta={{ $tarefa->processo }}"
                                                                target="_blank" class="d-inline-block text-truncate"
                                                                style="max-width: 200px;" data-coreui-toggle="tooltip"
                                                                data-coreui-placement="top"
                                                                title="{{ $tarefa->processo }}">
                                                                {{ $tarefa->processo }}
                                                            </a>
                                                        @else
                                                            <span class="text-muted small opacity-75 fst-italic">sem
                                                                processo</span>
                                                        @endif
                                                    </td>

                                                    <td class="px-4">
                                                        @if ($tarefa->cliente && $tarefa->cliente->nome)
                                                            <span class="d-inline-block text-truncate"
                                                                style="max-width: 150px;" data-coreui-toggle="tooltip"
                                                                data-coreui-placement="top"
                                                                title="{{ $tarefa->cliente->nome }} - {{ $tarefa->cliente->empresa }} - {{ $tarefa->processo }}">
                                                                {{ $tarefa->cliente->nome }}
                                                            </span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="px-4">

                                                        <span class="d-inline-block text-truncate"
                                                            style="max-width: 150px;" data-coreui-toggle="tooltip"
                                                            data-coreui-placement="top"
                                                            title="{{ $tarefa->tipo_atividade }}">
                                                            {{ $tarefa->tipo_atividade }}
                                                        </span>
                                                    </td>

                                                    {{-- <td class="px-4">
                                                        <span class="d-inline-block text-truncate"
                                                            style="max-width: 200px;" data-coreui-toggle="tooltip"
                                                            data-coreui-placement="top"
                                                            title="{{ $tarefa->descricao_atividade }}">
                                                            {{ $tarefa->descricao_atividade }}
                                                        </span>
                                                    </td> --}}

                                                    <td class="px-4">
                                                        @if ($tarefa->membroEquipe && $tarefa->membroEquipe->nome)
                                                            {{ explode(' ', $tarefa->membroEquipe->nome)[0] }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    <td class="px-4">
                                                        <span
                                                            class="badge
                                                            @if (strtolower($tarefa->prioridade) == 'alta') bg-danger text-white
                                                            @elseif(strtolower($tarefa->prioridade) == 'média' || strtolower($tarefa->prioridade) == 'media') bg-warning text-dark
                                                            @elseif(strtolower($tarefa->prioridade) == 'baixa') bg-info text-white
                                                            @else bg-secondary text-white @endif">
                                                            {{ ucfirst($tarefa->prioridade) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4">{{ $tarefa->prazo }}</td>
                                                    <td class="px-4">
                                                        @can('update situacao tarefas')
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm dropdown-toggle" type="button"
                                                                data-coreui-toggle="dropdown" aria-expanded="false">
                                                                {{ $tarefa->situacao ?: '-' }}
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item situacao-option"
                                                                        href="#" data-id="{{ $tarefa->id }}"
                                                                        data-situacao=""
                                                                        onclick="console.log('Clicou em remover situação com data-situacao: ', this.getAttribute('data-situacao'))">
                                                                        <i
                                                                            class="fas fa-times-circle text-danger me-2"></i>Remover
                                                                        situação
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <hr class="dropdown-divider">
                                                                </li>
                                                                @foreach (App\Models\ControleDeTarefas::situacaoOptions() as $situacao)
                                                                    <li>
                                                                        <a class="dropdown-item situacao-option"
                                                                            href="#" data-id="{{ $tarefa->id }}"
                                                                            data-situacao="{{ $situacao }}">
                                                                            {{ $situacao }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        @else
                                                        <span class="text-muted">{{ $tarefa->situacao ?: '-' }}</span>
                                                        @endcan
                                                    </td>
                                                    <td class="px-4">
                                                        @can('update status tarefas')
                                                        <div class="dropdown">
                                                            <button
                                                                class="btn btn-sm dropdown-toggle
                                                                @if ($tarefa->status == 'em andamento') btn-info
                                                                @elseif($tarefa->status == 'atrasado') btn-danger
                                                                @elseif($tarefa->status == 'nao iniciada') btn-warning
                                                                @elseif($tarefa->status == 'Em Revisão') btn-primary
                                                                @elseif($tarefa->status == 'Aguardando Justiça') btn-secondary
                                                                @elseif($tarefa->status == 'concluida') btn-success @endif"
                                                                type="button" data-coreui-toggle="dropdown"
                                                                aria-expanded="false"> {{ ucfirst($tarefa->status) }}
                                                            </button>
                                                            <div class="date-info">
                                                                @if ($tarefa->data_inicio)
                                                                    <div><i class="far fa-calendar-alt me-1"></i>Início:
                                                                        @if (is_string($tarefa->data_inicio))
                                                                            {{ \Carbon\Carbon::parse($tarefa->data_inicio)->format('d/m/Y') }}
                                                                        @else
                                                                            {{ $tarefa->data_inicio->format('d/m/Y') }}
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                                @if ($tarefa->data_termino)
                                                                    <div><i class="fas fa-calendar-check me-1"></i>Término:
                                                                        @if (is_string($tarefa->data_termino))
                                                                            {{ \Carbon\Carbon::parse($tarefa->data_termino)->format('d/m/Y') }}
                                                                        @else
                                                                            {{ $tarefa->data_termino->format('d/m/Y') }}
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <ul class="dropdown-menu">
                                                                @foreach ($getStatusValues as $status)
                                                                    <li>
                                                                        <a class="dropdown-item status-option"
                                                                            href="#" data-id="{{ $tarefa->id }}"
                                                                            data-status="{{ $status }}">
                                                                            <span
                                                                                class="badge me-2                                                                                @if ($status == 'em andamento') bg-info text-white
                                                                                @elseif($status == 'atrasado') bg-danger text-white
                                                                                @elseif($status == 'nao iniciada') bg-warning text-dark
                                                                                @elseif($status == 'Em Revisão') bg-primary text-white
                                                                                @elseif($status == 'Aguardando Justiça') bg-secondary text-white
                                                                                @elseif($status == 'concluida') bg-success text-white @endif">
                                                                                &nbsp;
                                                                            </span>
                                                                            {{ ucfirst($status) }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        @else
                                                        <span class="badge
                                                            @if ($tarefa->status == 'em andamento') bg-info text-white
                                                            @elseif($tarefa->status == 'atrasado') bg-danger text-white
                                                            @elseif($tarefa->status == 'nao iniciada') bg-warning text-dark
                                                            @elseif($tarefa->status == 'Em Revisão') bg-primary text-white
                                                            @elseif($tarefa->status == 'Aguardando Justiça') bg-secondary text-white
                                                            @elseif($tarefa->status == 'concluida') bg-success text-white @endif">
                                                            {{ ucfirst($tarefa->status) }}
                                                        </span>
                                                        <div class="date-info">
                                                            @if ($tarefa->data_inicio)
                                                                <div><i class="far fa-calendar-alt me-1"></i>Início:
                                                                    @if (is_string($tarefa->data_inicio))
                                                                        {{ \Carbon\Carbon::parse($tarefa->data_inicio)->format('d/m/Y') }}
                                                                    @else
                                                                        {{ $tarefa->data_inicio->format('d/m/Y') }}
                                                                    @endif
                                                                </div>
                                                            @endif
                                                            @if ($tarefa->data_termino)
                                                                <div><i class="fas fa-calendar-check me-1"></i>Término:
                                                                    @if (is_string($tarefa->data_termino))
                                                                        {{ \Carbon\Carbon::parse($tarefa->data_termino)->format('d/m/Y') }}
                                                                    @else
                                                                        {{ $tarefa->data_termino->format('d/m/Y') }}
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @endcan
                                                    </td>

                                                    <td class="px-4 text-center">
                                                        <x-action-buttons-tarefas showRoute="controle_de_tarefas.show"
                                                            editRoute="controle_de_tarefas.edit"
                                                            destroyRoute="controle_de_tarefas.destroy"
                                                            duplicateRoute="controle_de_tarefas.duplicate"
                                                            :itemId="$tarefa->id" title="Confirmar Exclusão"
                                                            message="Tem certeza que deseja excluir esta tarefa?"
                                                            duplicateTitle="Confirmar Duplicação"
                                                            duplicateMessage="Deseja duplicar esta tarefa? Uma nova tarefa será criada com as mesmas informações." />
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

                                {{ $tarefas->links('vendor.pagination.simple-coreui') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast para feedback visual -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="statusToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Atualização de Status</strong>
                <small>Agora</small>
                <button type="button" class="btn-close btn-close-white" data-coreui-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Status atualizado com sucesso!
            </div>
        </div>
    </div>

    <style>
        /* Ajustes para o dropdown */
        .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
            z-index: 1060;
        }

        /* Garante que o dropdown não fique cortado na tabela */
        .table-responsive {
            overflow: visible;
        }

        /* Ajuste para linhas da tabela */
        .table tr {
            position: relative;
        }

        .progress-xs {
            height: 6px !important;
        }

        /* Ajuste para a tabela */
        .table td {
            vertical-align: middle !important;
        }

        /* Estilo para as datas de início e término */
        .date-info {
            font-size: 0.75rem;
            line-height: 1.2;
            color: #6c757d;
            margin-top: 3px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Atualização da situação via AJAX
            document.querySelectorAll('.situacao-option').forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tarefaId = this.getAttribute('data-id');
                    const novaSituacao = this.getAttribute('data-situacao');
                    const dropdown = this.closest('.dropdown');
                    const button = dropdown.querySelector('.dropdown-toggle');

                    console.log('Atualizando situação:', {
                        tarefaId: tarefaId,
                        novaSituacao: novaSituacao
                    });

                    // Envia requisição AJAX
                    fetch(`{{ route('controle_de_tarefas.update_situacao', ['controleDeTarefas' => 'ID_PLACEHOLDER']) }}`
                            .replace('ID_PLACEHOLDER', tarefaId), {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    situacao: novaSituacao
                                })
                            })
                        .then(response => {
                            console.log('Resposta do servidor:', response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Dados do servidor:', data);
                            if (data.success) {
                                // Atualiza o botão visualmente
                                button.textContent = novaSituacao || '-';

                                // Feedback visual com toast
                                const toast = new coreui.Toast(document.getElementById(
                                    'statusToast'));
                                document.querySelector('#statusToast .toast-header').className =
                                    'toast-header bg-success text-white';

                                let mensagem = '';
                                if (novaSituacao) {
                                    mensagem =
                                        `Situação atualizada para "${novaSituacao}" com sucesso!`;
                                } else {
                                    mensagem = 'Situação removida com sucesso!';
                                }

                                document.querySelector('#statusToast .toast-body').textContent =
                                    mensagem;
                                toast.show();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });

            // Atualização do status via AJAX
            document.querySelectorAll('.status-option').forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();

                    const tarefaId = this.getAttribute('data-id');
                    const novoStatus = this.getAttribute('data-status');
                    const dropdown = this.closest('.dropdown');
                    const button = dropdown.querySelector('.dropdown-toggle');

                    // Envia requisição AJAX
                    fetch(`{{ route('controle_de_tarefas.update_status', ['controleDeTarefas' => 'ID_PLACEHOLDER']) }}`
                            .replace('ID_PLACEHOLDER', tarefaId), {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    status: novoStatus
                                })
                            })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Atualiza o botão visualmente
                                button.textContent = novoStatus.charAt(0).toUpperCase() +
                                    novoStatus.slice(1);

                                // Atualiza as classes do botão
                                button.classList.remove('btn-info', 'btn-danger', 'btn-warning',
                                    'btn-primary', 'btn-secondary', 'btn-success');

                                switch (novoStatus) {
                                    case 'em andamento':
                                        button.classList.add('btn-info');
                                        break;
                                    case 'atrasado':
                                        button.classList.add('btn-danger');
                                        break;
                                    case 'nao iniciada':
                                        button.classList.add('btn-warning');
                                        break;
                                    case 'Em Revisão':
                                        button.classList.add('btn-primary');
                                        break;
                                    case 'Aguardando Justiça':
                                        button.classList.add('btn-secondary');
                                        break;
                                    case 'concluida':
                                        button.classList.add('btn-success');
                                        break;
                                }

                                // Feedback visual
                                const toast = new coreui.Toast(document.getElementById(
                                    'statusToast'));
                                document.querySelector('#statusToast .toast-header').className =
                                    'toast-header';

                                // Adiciona cor ao header do toast com base no status
                                switch (novoStatus) {
                                    case 'em andamento':
                                        document.querySelector('#statusToast .toast-header')
                                            .classList.add('bg-info', 'text-white');
                                        break;
                                    case 'atrasado':
                                        document.querySelector('#statusToast .toast-header')
                                            .classList.add('bg-danger', 'text-white');
                                        break;
                                    case 'nao iniciada':
                                        document.querySelector('#statusToast .toast-header')
                                            .classList.add('bg-warning', 'text-dark');
                                        break;
                                    case 'Em Revisão':
                                        document.querySelector('#statusToast .toast-header')
                                            .classList.add('bg-primary', 'text-white');
                                        break;
                                    case 'Aguardando Justiça':
                                        document.querySelector('#statusToast .toast-header')
                                            .classList.add('bg-secondary', 'text-white');
                                        break;
                                    case 'concluida':
                                        document.querySelector('#statusToast .toast-header')
                                            .classList.add('bg-success', 'text-white');
                                        break;
                                }

                                document.querySelector('#statusToast .toast-body').textContent =
                                    `Status atualizado para "${novoStatus.charAt(0).toUpperCase() + novoStatus.slice(1)}" com sucesso!`;
                                toast.show();

                                // Mostrar o toast de sucesso
                                const statusToast = document.getElementById('statusToast');
                                const bsToast = new bootstrap.Toast(statusToast);
                                bsToast.show();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>

    <script>
        function imprimirTarefas() {
            // Pegar os filtros atuais corretamente
            const filtros = {
                cliente: document.getElementById('cliente').value,
                prioridade: document.getElementById('prioridade').value,
                situacao: document.getElementById('situacao').value,
                tipo_atividade: document.getElementById('tipo_atividade').value,
                responsavel: document.getElementById('responsavel').value,
                
            };

            // Criar um formulário dinâmico para enviar os filtros
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('controle_de_tarefas.exportar_para_impressao') }}';
            form.target = '_blank'; // Isso faz abrir em nova aba/janela

            // Adicionar token CSRF
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
            form.appendChild(csrfToken);

            // Adicionar filtros como campos ocultos
            Object.keys(filtros).forEach(key => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = filtros[key];
                form.appendChild(input);
            });

            // Adicionar formulário ao corpo e submeter
            document.body.appendChild(form);
            form.submit();

            // Remover o formulário após o envio
            setTimeout(() => document.body.removeChild(form), 100);
        }
    </script>


@endsection
