@extends('layouts.app')

@push('styles')
<style>
    .status-select {
        cursor: pointer;
        transition: all 0.2s ease;
        border-radius: 20px;
        padding-left: 12px;
    }
    
    .status-select:hover {
        opacity: 0.8;
        transform: translateY(-1px);
    }
    
    .status-select:disabled {
        opacity: 0.8;
        cursor: not-allowed;
        background-color: #f8f9fa !important;
    }
    
    /* Estilo especial para status "entregue" desabilitado */
    .status-select:disabled.bg-success {
        opacity: 0.9;
        background-color: #d1edff !important;
        border: 1px solid #198754;
    }
    
    .status-select option {
        background-color: white !important;
        color: black !important;
        padding: 8px 12px;
        position: relative;
    }
    
    /* Forçar fundo branco em todos os estados das opções */
    .status-select option:hover,
    .status-select option:focus,
    .status-select option:selected,
    .status-select option:checked {
        background-color: white !important;
        color: black !important;
    }
    
    /* Criar bolinhas coloridas usando conteúdo direto no HTML */
    .status-select option {
        font-family: inherit;
        background-color: white !important;
        color: black !important;
        padding: 8px;
    }
    
    /* Permitir HTML nas opções e garantir cores corretas */
    .status-select option span {
        font-size: 12px;
        margin-right: 6px;
        font-weight: bold;
    }
    
    /* Melhorar visual do dropdown */
    .status-select:focus {
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
        outline: none;
    }
    
    /* Adicionar uma bolinha no próprio select também */
    .status-select {
        position: relative;
        padding-left: 25px;
    }
    
    .status-select::before {
        content: '●';
        position: absolute;
        left: 8px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12px;
        pointer-events: none;
        z-index: 1;
    }
    
    /* Cores dinâmicas para o select baseado na classe atual */
    .status-select.bg-warning::before { color: #ffc107; }
    .status-select.bg-info::before { color: #0dcaf0; }
    .status-select.bg-secondary::before { color: #6c757d; }
    .status-select.bg-primary::before { color: #0d6efd; }
    .status-select.bg-success::before { color: #198754; }
    .status-select.bg-danger::before { color: #dc3545; }
    .status-select.bg-dark::before { color: #212529; }
    .status-select.bg-light::before { color: #6c757d; }
</style>
@endpush

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
                                
                                    <button type="button" id="btnImprimir"
                                        class="btn btn-sm btn-outline-info d-flex align-items-center gap-2 px-3 py-2"
                                        style="transition: all 0.2s ease;">
                                        <i class="fas fa-print" style="font-size: 0.9rem;"></i>
                                        <span>Imprimir</span>
                                    </button>
                                
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Collapse Filtros -->
                            <button
                                class="btn btn-outline-primary mb-3 w-100 d-flex align-items-center justify-content-center gap-2"
                                type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse"
                                aria-expanded="false" aria-controls="filtrosCollapse" style="font-size:1.1rem;">
                                <i class="fas fa-filter"></i>
                                <span>Filtros de Pesquisa</span>
                            </button>
                            <div class="collapse{{ request()->hasAny(['search', 'vara', 'responsavel_tecnico_id', 'tipo_pericia', 'status_atual', 'prazo_final_inicio', 'prazo_final_fim']) ? ' show' : '' }}"
                                id="filtrosCollapse">
                                <div class="card card-body border-0 shadow-sm mb-3">
                                    <form action="{{ route('controle-pericias.index') }}" method="GET">
                                        @csrf
                                        <div class="row align-items-end">
                                            <div class="col-md-2">
                                                <label class="form-label" for="search">Buscar</label>
                                                <input type="text" name="search" value="{{ $search ?? '' }}"
                                                    placeholder="Buscar por processo, parte ou vara..."
                                                    class="form-control">
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
                                                <label class="form-label" for="responsavel_tecnico_id">Responsável
                                                    Técnico</label>
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
                                            <div class="col-md-1">
                                                <label class="form-label" for="prazo_final_mes">Mês Entregue</label>
                                                <select class="form-select" name="prazo_final_mes" id="prazo_final_mes">
                                                    <option value="">Mês</option>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ request('prazo_final_mes') == $i ? 'selected' : '' }}>
                                                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label" for="prazo_final_ano">Ano Entregue</label>
                                                <select class="form-select" name="prazo_final_ano" id="prazo_final_ano">
                                                    <option value="">Ano</option>
                                                    @for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++)
                                                        <option value="{{ $y }}"
                                                            {{ request('prazo_final_ano') == $y ? 'selected' : '' }}>
                                                            {{ $y }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 d-flex justify-content-center">
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary"><i
                                                            class="fas fa-search me-2"></i>Pesquisar</button>
                                                    <a href="{{ route('controle-pericias.index') }}"
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
                                                            $statusColor = App\Models\ControlePericia::getStatusColor($pericia->status_atual);
                                                        @endphp
                                                        @can('edit pericias')
                                                            <select 
                                                                class="form-select form-select-sm status-select {{ $statusColor['class'] }}" 
                                                                data-pericia-id="{{ $pericia->id }}"
                                                                data-original-status="{{ $pericia->status_atual }}"
                                                                data-numero-processo="{{ $pericia->numero_processo ?? '' }}"
                                                                data-requerente="{{ $pericia->requerente ? $pericia->requerente->nome : '' }}"
                                                                data-vara="{{ $pericia->vara ?? '' }}"
                                                                data-prazo_final="{{ $pericia->prazo_final ?? '' }}"
                                                                style="border: none; font-weight: 500; min-width: 180px;"
                                                                {{ strtolower($pericia->status_atual) === 'entregue' ? 'disabled' : '' }}>
                                                                @foreach (App\Models\ControlePericia::statusOptions() as $statusOption)
                                                                    @php
                                                                        $optionColor = App\Models\ControlePericia::getStatusColor($statusOption);
                                                                    @endphp
                                                                    <option 
                                                                        value="{{ $statusOption }}"
                                                                        data-color="{{ $optionColor['color'] }}"
                                                                        data-class="{{ $optionColor['class'] }}"
                                                                        style="background-color: white !important; color: black !important;"
                                                                        {{ $pericia->status_atual == $statusOption ? 'selected' : '' }}>
                                                                        {{ $statusOption }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <span class="badge {{ $statusColor['class'] }}">{{ $pericia->status_atual }}</span>
                                                        @endcan
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

    <!-- Modal de Registro Financeiro -->
    <x-modal-financeiro 
        :title="'Registro Financeiro do Laudo'"
        :info="'A perícia foi marcada como <strong>entregue</strong>. Preencha os dados financeiros abaixo:'"
        :action="route('entrega-laudos-financeiro.store')"
    />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnImprimir = document.getElementById('btnImprimir');
            
            if (btnImprimir) {
                btnImprimir.addEventListener('click', function() {
                    // Capturar os parâmetros atuais da URL
                    const urlParams = new URLSearchParams(window.location.search);
                    
                    // Construir a URL de impressão com os mesmos parâmetros
                    const printUrl = '{{ route("controle-pericias.print-list") }}?' + urlParams.toString();
                    
                    // Abrir em nova aba
                    window.open(printUrl, '_blank');
                });
            }

            // Funcionalidade de edição inline do status
            const statusSelects = document.querySelectorAll('.status-select');
            
            statusSelects.forEach(select => {
                // Inicializar a bolinha colorida ao carregar a página
                updateSelectDot(select);
                
                // Adicionar bolinhas coloridas às opções
                addColoredDotsToOptions(select);
                
                select.addEventListener('change', function() {
                    const periciaId = this.dataset.periciaId;
                    const originalStatus = this.dataset.originalStatus;
                    const newStatus = this.value;
                    
                    // Se não mudou, não fazer nada
                    if (originalStatus === newStatus) {
                        return;
                    }
                    
                    // REGRA 1: Se o status original já é "entregue", não permitir alteração
                    if (originalStatus.toLowerCase() === 'entregue') {
                        this.value = originalStatus; // Reverter imediatamente
                        showToast('warning', 'Não é possível alterar o status de uma perícia que já foi entregue.');
                        return;
                    }
                    
                    // REGRA 2: Se está tentando mudar para "entregue", primeiro abrir modal
                    if (newStatus.toLowerCase() === 'entregue') {
                        this.value = originalStatus; // Reverter temporariamente
                        
                        // Verificar se já existe registro financeiro
                        checkExistingFinanceiroRecord(periciaId, originalStatus, newStatus, this);
                        return;
                    }
                    
                    // Para outros status, continuar normalmente
                    // Desabilitar o select durante a requisição
                    this.disabled = true;
                    
                    // Fazer a requisição AJAX
                    fetch(`{{ route('controle-pericias.index') }}/${periciaId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            status_atual: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Atualizar o data-original-status
                            this.dataset.originalStatus = newStatus;
                            
                            // Atualizar a classe CSS do select baseada no novo status
                            updateSelectClass(this, newStatus);
                            
                            // Atualizar a bolinha colorida
                            updateSelectDot(this);
                            
                            // Esta parte não será mais executada pois "entregue" é tratado antes
                            
                            // Mostrar toast de sucesso
                            showToast('success', data.message || 'Status atualizado com sucesso!');
                        } else {
                            // Reverter para o status original em caso de erro
                            this.value = originalStatus;
                            showToast('error', data.message || 'Erro ao atualizar status');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        // Reverter para o status original em caso de erro
                        this.value = originalStatus;
                        showToast('error', 'Erro de conexão ao atualizar status');
                    })
                    .finally(() => {
                        // Reabilitar o select
                        this.disabled = false;
                    });
                });
            });

            // Função para adicionar bolinhas coloridas às opções
            function addColoredDotsToOptions(select) {
                const statusColors = {
                    'aguardando despacho': '🟡',
                    'aguardando vistoria': '🔵', 
                    'aguardando pagamento': '🟡',
                    'aguardando laudo do perito': '⚪',
                    'aguardando quesitos': '⚪',
                    'Aguardando nomeação': '🔵',
                    'em redação': '🔵',
                    'entregue': '🟢',
                    'extinto': '🔴',
                    'transferido projudi': '⚫',
                    'suspenso': '🟡'
                };

                Array.from(select.options).forEach(option => {
                    const status = option.value;
                    const colorEmoji = statusColors[status] || '⚪';
                    
                    if (status) {
                        // Usar emoji colorido em vez de texto
                        option.textContent = `${colorEmoji} ${status}`;
                    }
                });
            }

            // Função para atualizar a classe CSS do select baseada no status
            function updateSelectClass(select, status) {
                // Encontrar a opção correspondente ao novo status
                const option = select.querySelector(`option[value="${status}"]`);
                if (option) {
                    const newClass = option.dataset.class;
                    
                    // Remover todas as classes de cor existentes
                    select.className = select.className.replace(/bg-\w+|text-\w+/g, '').trim();
                    
                    // Adicionar a nova classe
                    select.className = `form-select form-select-sm status-select ${newClass}`;
                }
            }

            // Função para atualizar a bolinha colorida do select
            function updateSelectDot(select) {
                // A cor da bolinha será definida automaticamente pelo CSS baseado na classe atual
                // Esta função pode ser expandida se necessário para lógica adicional
            }

            // Função para verificar se já existe registro financeiro
            function checkExistingFinanceiroRecord(periciaId, originalStatus, newStatus, selectElement) {
                // Fazer requisição para verificar se já existe registro
                fetch(`{{ route('entrega-laudos-financeiro.index') }}?controle_pericias_id=${periciaId}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        // Já existe registro, atualizar status diretamente
                        updateStatusDirectly(periciaId, originalStatus, newStatus, selectElement);
                        showToast('info', 'Status atualizado. Registro financeiro já existe para esta perícia.');
                    } else {
                        // Não existe registro, abrir modal obrigatório
                        openFinanceiroModal(periciaId, originalStatus, newStatus, selectElement);
                    }
                })
                .catch(error => {
                    console.log('Assumindo que não existe registro, abrindo modal...');
                    openFinanceiroModal(periciaId, originalStatus, newStatus, selectElement);
                });
            }

            // Função para abrir o modal financeiro
            function openFinanceiroModal(periciaId, originalStatus, newStatus, selectElement) {
                document.getElementById('controle_pericias_id').value = periciaId;
                
                // Extrair informações da perícia dos atributos data
                const periciaData = {
                    processo: selectElement.dataset.numeroProcesso || '',
                    requerente: selectElement.dataset.requerente || '',
                    vara: selectElement.dataset.vara || '',
                    prazo_final: selectElement.dataset.prazo_final || ''
                };
                
                // Atualizar informações no modal usando a função global
                if (window.updateModalPericia) {
                    window.updateModalPericia(periciaData);
                }
                
                // Armazenar referências para usar após o envio do formulário
                window.pendingStatusUpdate = {
                    periciaId: periciaId,
                    originalStatus: originalStatus,
                    newStatus: newStatus,
                    selectElement: selectElement
                };
                
                // Limpar formulário
                document.getElementById('formFinanceiro').reset();
                document.getElementById('controle_pericias_id').value = periciaId;
                // Não força seleção de status
                
                // Mostrar modal
                const modal = new bootstrap.Modal(document.getElementById('modalFinanceiro'));
                modal.show();
                
                // Adicionar evento para quando modal for fechado sem salvar
                modal._element.addEventListener('hidden.bs.modal', function(e) {
                    // Se ainda existe pendingStatusUpdate, significa que foi cancelado
                    if (window.pendingStatusUpdate) {
                        selectElement.value = originalStatus; // Manter status original
                        window.pendingStatusUpdate = null;
                        showToast('info', 'Alteração de status cancelada. É obrigatório preencher os dados financeiros.');
                    }
                    // Limpar as informações do modal
                    if (window.clearModalPericia) {
                        window.clearModalPericia();
                    }
                }, { once: true });
            }

            // Função para atualizar status diretamente (quando já existe registro financeiro)
            function updateStatusDirectly(periciaId, originalStatus, newStatus, selectElement) {
                selectElement.disabled = true;
                
                fetch(`{{ route('controle-pericias.index') }}/${periciaId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status_atual: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Atualizar o data-original-status
                        selectElement.dataset.originalStatus = newStatus;
                        selectElement.value = newStatus;
                        
                        // Atualizar a classe CSS do select baseada no novo status
                        updateSelectClass(selectElement, newStatus);
                        
                        // Atualizar a bolinha colorida
                        updateSelectDot(selectElement);
                        
                        showToast('success', data.message || 'Status atualizado com sucesso!');
                    } else {
                        selectElement.value = originalStatus;
                        showToast('error', data.message || 'Erro ao atualizar status');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    selectElement.value = originalStatus;
                    showToast('error', 'Erro de conexão ao atualizar status');
                })
                .finally(() => {
                    selectElement.disabled = false;
                });
            }

            // Manipular envio do formulário financeiro
            document.getElementById('formFinanceiro').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Processar campos com prefixos antes do envio
                const nfField = document.getElementById('nf');
                if (nfField.value && !nfField.value.startsWith('NF nº')) {
                    nfField.value = 'NF nº ' + nfField.value.trim();
                }

                const empenhoField = document.getElementById('empenho');
                if (empenhoField.value && !empenhoField.value.startsWith('NE nº')) {
                    empenhoField.value = 'NE nº ' + empenhoField.value.trim();
                }
                
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                // Garantir que os campos estejam presentes
                data.ano_pagamento = formData.get('ano_pagamento') || '';
                data.tipo_pessoa = formData.get('tipo_pessoa') || '';
                data.observacao = formData.get('observacao') || '';
                
                // Desabilitar botão de envio
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Salvando...';
                
                // Enviar dados
                fetch('{{ route("entrega-laudos-financeiro.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Agora atualizar o status da perícia para "entregue"
                        if (window.pendingStatusUpdate) {
                            const { periciaId, originalStatus, newStatus, selectElement } = window.pendingStatusUpdate;
                            
                            updateStatusDirectly(periciaId, originalStatus, newStatus, selectElement);
                            window.pendingStatusUpdate = null; // Limpar pendência
                        }
                        
                        // Fechar modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalFinanceiro'));
                        modal.hide();
                        
                        // Mostrar toast de sucesso
                        showToast('success', 'Registro financeiro criado e status atualizado para "entregue" com sucesso!');
                        
                        // Opcional: redirecionar para a página de financeiro
                        setTimeout(() => {
                            window.open('{{ route("entrega-laudos-financeiro.index") }}', '_blank');
                        }, 1500);
                    } else {
                        showToast('error', data.message || 'Erro ao criar registro financeiro');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    showToast('error', 'Erro de conexão ao criar registro financeiro');
                })
                .finally(() => {
                    // Reabilitar botão
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });

            // Aplicar máscara de dinheiro no campo valor
            document.getElementById('valor').addEventListener('input', function(e) {
                let value = e.target.value;
                
                // Remove tudo que não for dígito
                value = value.replace(/\D/g, '');
                
                // Converte para formato monetário
                value = (value/100).toFixed(2) + '';
                value = value.replace(".", ",");
                value = value.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
                value = value.replace(/(\d)(\d{3}),/g, "$1.$2,");
                
                e.target.value = 'R$ ' + value;
            });


        });

        // Função para mostrar toast notifications
        function showToast(type, message) {
            // Criar o elemento do toast
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            toast.style.position = 'fixed';
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';
            toast.style.minWidth = '300px';
            
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
            
            // Adicionar o toast ao body
            document.body.appendChild(toast);
            
            // Inicializar e mostrar o toast usando Bootstrap
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            // Remover o elemento do DOM depois que o toast for ocultado
            toast.addEventListener('hidden.bs.toast', function() {
                document.body.removeChild(toast);
            });
        }
    </script>
@endsection
