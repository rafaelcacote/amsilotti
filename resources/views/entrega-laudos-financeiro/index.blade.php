@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0" style="color: #5c58cb;"><i class="fas fa-money-bill-wave me-2"></i>Financeiro de Laudos</h3>
                            <button type="button" class="btn btn-outline-info" id="btnImprimir">
                                <i class="fas fa-print me-2"></i>Imprimir
                            </button>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Collapse Filtros -->
                            <button class="btn mb-3 w-100 d-flex align-items-center justify-content-center gap-2"
                                type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse"
                                aria-expanded="false" aria-controls="filtrosCollapse" style="font-size:1.1rem; border: 1px solid #5c58cb; color: #5c58cb; background: #fff;">
                                <i class="fas fa-filter"></i>
                                <span>Filtros de Pesquisa</span>
                            </button>
                            <div class="collapse{{ request()->hasAny(['search', 'status', 'vara', 'upj', 'mes_pagamento']) ? ' show' : '' }}"
                                id="filtrosCollapse">
                                <div class="card card-body border-0 shadow-sm mb-3">
                                    <form action="{{ route('entrega-laudos-financeiro.index') }}" method="GET">
                                        @csrf
                                        <div class="row align-items-end">
                                            <div class="col-md-3">
                                                <label class="form-label" for="search">Buscar</label>
                                                <input type="text" name="search" value="{{ $search ?? '' }}"
                                                    placeholder="Buscar por processo, financeiro, SEI, NF..."
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="status">Status</label>
                                                <select class="form-select" name="status" id="status">
                                                    <option value="">Todos</option>
                                                    @foreach (App\Models\EntregaLaudoFinanceiro::statusOptions() as $statusOption)
                                                        <option value="{{ $statusOption }}"
                                                            {{ request('status') == $statusOption ? 'selected' : '' }}>
                                                            {{ $statusOption }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="financeiro">Financeiro</label>
                                                <select class="form-select" name="financeiro" id="financeiro">
                                                    <option value="">Todos</option>
                                                    @foreach (App\Models\EntregaLaudoFinanceiro::financeiroOptions() as $financeiroOption)
                                                        <option value="{{ $financeiroOption }}" {{ request('financeiro') == $financeiroOption ? 'selected' : '' }}>
                                                            {{ $financeiroOption }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="vara">Vara</label>
                                                <select class="form-select" name="vara" id="vara">
                                                    <option value="">Todas</option>
                                                    @foreach (App\Models\EntregaLaudoFinanceiro::varaOptions() as $varaOption)
                                                        <option value="{{ $varaOption }}"
                                                            {{ request('vara') == $varaOption ? 'selected' : '' }}>
                                                            {{ $varaOption }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label" for="upj">UPJ</label>
                                                <select class="form-select" name="upj" id="upj">
                                                    <option value="">Todas</option>
                                                    @foreach (App\Models\EntregaLaudoFinanceiro::upjOptions() as $upjOption)
                                                        <option value="{{ $upjOption }}"
                                                            {{ request('upj') == $upjOption ? 'selected' : '' }}>
                                                            {{ $upjOption }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="mes_pagamento">Mês Pagamento</label>
                                                <select class="form-select" name="mes_pagamento" id="mes_pagamento">
                                                    <option value="">Todos</option>
                                                    @foreach (App\Models\EntregaLaudoFinanceiro::mesPagamentoOptions() as $mesOption)
                                                        <option value="{{ $mesOption }}"
                                                            {{ request('mes_pagamento') == $mesOption ? 'selected' : '' }}>
                                                            {{ $mesOption }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="d-flex gap-2 justify-content-center mt-3">
                                                    <button type="submit" class="btn" style="background: #5c58cb; color: #fff; border: 1px solid #5c58cb;"><i class="fas fa-search me-2"></i>Pesquisar</button>
                                                    <a href="{{ route('entrega-laudos-financeiro.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times me-2"></i>Limpar</a>
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
                            <!-- Contadores -->
                            <div class="mb-3 d-flex gap-3 align-items-center flex-wrap">
                                <div class="bg-white shadow-sm rounded px-4 py-3 d-flex align-items-center gap-2">
                                    <span class="fw-semibold text-success" style="font-size: 1.1rem;">
                                        <i class="fas fa-database me-2"></i>Total registros:
                                    </span>
                                    <span class="badge bg-success fs-5">{{ $entregasLaudos->total() }}</span>
                                </div>
                                <div class="bg-white shadow-sm rounded px-4 py-3 d-flex align-items-center gap-2">
                                    <span class="fw-semibold text-info" style="font-size: 1.1rem;">
                                        <i class="fas fa-filter me-2"></i>Exibindo:
                                    </span>
                                    <span class="badge bg-info fs-5">{{ $entregasLaudos->count() }}</span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-striped align-middle table-sm">
                                    <thead>
                                        <tr>
                                            <th style="width: 12%;">Processo</th>
                                            <th style="width: 8%;">Vara</th>
                                            <th style="width: 6%;">UPJ</th>
                                            <th style="width: 10%;">Financeiro</th>
                                            <th style="width: 10%;">Status</th>
                                            <th style="width: 8%;">Protocolo Laudo</th>
                                            <th style="width: 8%;">R$</th>
                                            <th style="width: 10%;">Proc Adm</th>
                                            <th style="width: 10%;">Empenho</th>
                                            <th style="width: 8%;">NF</th>
                                            <th style="width: 12%;">Mês/Ano Pagamento</th>
                                            <th style="width: 8%; min-width: 80px;">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($entregasLaudos->count() > 0)
                                            @foreach ($entregasLaudos as $entregaLaudo)
                                                @if(is_object($entregaLaudo) && method_exists($entregaLaudo, 'getAttribute'))
                                                <tr class="drawer-row" data-id="{{ $entregaLaudo->id }}">
                                                    <!-- 1. Processo -->
                                                    <td>
                                                        @if ($entregaLaudo->controlePericia && $entregaLaudo->controlePericia->numero_processo)
                                                            <a href="https://consultasaj.tjam.jus.br/cpopg/search.do?cbPesquisa=NUMPROC&dadosConsulta.valorConsulta={{ $entregaLaudo->controlePericia->numero_processo }}"
                                                                target="_blank" class="text-decoration-none"
                                                                title="{{ $entregaLaudo->controlePericia->numero_processo }}">
                                                                {{ $entregaLaudo->controlePericia->numero_processo }}
                                                            </a>
                                                        @else
                                                            <span class="text-muted small fst-italic">sem processo</span>
                                                        @endif
                                                    </td>
                                                    <!-- 2. Vara -->
                                                    <td>{{ $entregaLaudo->controlePericia->vara ?? '-' }}</td>
                                                    <!-- 3. UPJ -->
                                                    <td>{{ ucfirst($entregaLaudo->upj ?? '-') }}</td>
                                                    <!-- 4. Financeiro -->
                                                    <td>{{ ucfirst($entregaLaudo->financeiro ?? '-') }}</td>
                                                    <!-- 5. Status -->
                                                    <td>{{ ucfirst($entregaLaudo->status ?? '-') }}</td>
                                                    <!-- 5. Protocolo Laudo -->
                                                    <td>{{ $entregaLaudo->controlePericia->prazo_final ? \Carbon\Carbon::parse($entregaLaudo->controlePericia->prazo_final)->format('d/m/Y') : '-' }}</td>
                                                    <!-- 6. R$ -->
                                                    <td>
                                                        @if($entregaLaudo->valor)
                                                            <span class="fw-bold text-success">{{ $entregaLaudo->valor_formatado }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <!-- 7. SEI -->
                                                    <td>{{ $entregaLaudo->sei ?? '-' }}</td>
                                                    <!-- 8. Empenho -->
                                                    <td>{{ $entregaLaudo->empenho ?? '-' }}</td>
                                                    <!-- 9. NF -->
                                                    <td>{{ $entregaLaudo->nf ?? '-' }}</td>
                                                    <!-- 10. Mês Pagamento -->
                                                    <td>{{ $entregaLaudo->mes_pagamento ?? '-' }}/{{ $entregaLaudo->ano_pagamento ?? '-' }}</td>
                                                    <!-- 11. Ações -->
                                                    <td style="min-width: 80px;">
                                                        <!-- <button type="button" class="btn btn-sm btn-outline-primary btn-edit-financeiro" 
                                                            title="Editar"
                                                            data-id="{{ $entregaLaudo->id }}"
                                                            data-status="{{ $entregaLaudo->status ?? '' }}"
                                                            data-upj="{{ $entregaLaudo->upj ?? '' }}"
                                                            data-financeiro="{{ $entregaLaudo->financeiro ?? '' }}"
                                                            data-valor="{{ $entregaLaudo->valor ?? '' }}"
                                                            data-protocolo-laudo="{{ $entregaLaudo->protocolo_laudo ? $entregaLaudo->protocolo_laudo->format('Y-m-d') : '' }}"
                                                            data-sei="{{ $entregaLaudo->sei ?? '' }}"
                                                            data-nf="{{ $entregaLaudo->nf ?? '' }}"
                                                            data-mes-pagamento="{{ $entregaLaudo->mes_pagamento ?? '' }}"
                                                            data-empenho="{{ $entregaLaudo->empenho ?? '' }}"
                                                            data-observacoes="{{ $entregaLaudo->observacoes ?? '' }}"
                                                            data-controle-pericias-id="{{ $entregaLaudo->controle_pericias_id }}"
                                                            data-processo="{{ $entregaLaudo->controlePericia->numero_processo ?? '' }}"
                                                            data-requerente="{{ $entregaLaudo->controlePericia->requerente->nome ?? '' }}"
                                                            data-vara="{{ $entregaLaudo->controlePericia->vara ?? '' }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button> -->
                                                            <a href="{{ route('entrega-laudos-financeiro.edit', $entregaLaudo->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="11" class="text-center py-4">
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
                                {{ $entregasLaudos->links('vendor.pagination.simple-coreui') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Drawer Lateral -->
    <div id="detailsDrawer" class="drawer-overlay">
        <div class="drawer-content">
            <div class="drawer-header">
                <h4 class="drawer-title">
                    <i class="fas fa-info-circle me-2"></i>Detalhes da Perícia
                </h4>
                <button type="button" class="btn-close drawer-close" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="drawer-body">
                <div class="loading-spinner text-center py-5" style="display: none;">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="mt-3 text-muted">Carregando informações...</p>
                </div>
                
                <div class="drawer-content-data" style="display: none;">
                    <!-- Informações da Perícia -->
                    <div class="info-section">
                        <h5 class="section-title">
                            <i class="fas fa-gavel me-2"></i>Informações da Perícia
                        </h5>
                        <div class="row g-3">
                            <!-- Coluna 1 - Identificação -->
                            <div class="col-4">
                                <div class="info-item mb-3">
                                    <label class="info-label">Processo:</label>
                                    <span class="info-value" id="drawer-processo">-</span>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="info-label">Requerente:</label>
                                    <span class="info-value" id="drawer-requerente">-</span>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="info-label">Vara:</label>
                                    <span class="info-value" id="drawer-vara">-</span>
                                </div>
                            </div>
                            <!-- Coluna 2 - Status e Tipo -->
                            <div class="col-4">
                                <div class="info-item mb-3">
                                    <label class="info-label">Status da Perícia:</label>
                                    <span class="info-value" id="drawer-status-pericia">-</span>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="info-label">Tipo Perícia:</label>
                                    <span class="info-value" id="drawer-tipo-pericia">-</span>
                                </div>
                            </div>
                            <!-- Coluna 3 - Datas -->
                            <div class="col-4">
                                <div class="info-item mb-3">
                                    <label class="info-label">Data Nomeação:</label>
                                    <span class="info-value" id="drawer-data-nomeacao">-</span>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="info-label">Data Vistoria:</label>
                                    <span class="info-value" id="drawer-data-vistoria">-</span>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="info-label">Prazo Final:</label>
                                    <span class="info-value" id="drawer-prazo-final">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informações Financeiras -->
                    <div class="info-section">
                        <h5 class="section-title">
                            <i class="fas fa-dollar-sign me-2"></i>Informações Financeiras
                        </h5>
                        <div class="row g-3">
                            <!-- Coluna 1 - Status e Controle -->
                            <div class="col-4">
                                <div class="info-item mb-3">
                                    <label class="info-label">Status Financeiro:</label>
                                    <span class="info-value" id="drawer-status-financeiro">-</span>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="info-label">UPJ:</label>
                                    <span class="info-value" id="drawer-upj">-</span>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="info-label">Financeiro:</label>
                                    <span class="info-value" id="drawer-financeiro">-</span>
                                </div>
                            </div>
                            <!-- Coluna 2 - Valores e Pagamento -->
                            <div class="col-4">
                                <div class="info-item mb-3">
                                    <label class="info-label">Valor:</label>
                                    <span class="info-value" id="drawer-valor">-</span>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="info-label">Mês Pagamento:</label>
                                    <span class="info-value" id="drawer-mes-pagamento">-</span>
                                </div>
                            </div>
                            <!-- Coluna 3 - Documentação -->
                            <div class="col-4">
                                <div class="info-item mb-3">
                                    <label class="info-label">Protocolo Laudo:</label>
                                    <span class="info-value" id="drawer-protocolo-laudo">-</span>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="info-label">Proc Adm:</label>
                                    <span class="info-value" id="drawer-sei">-</span>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="info-label">NF:</label>
                                    <span class="info-value" id="drawer-nf">-</span>
                                </div>
                               
                            </div>
                             <div class="col-4">
                                <div class="info-item mb-6">
                                    <label class="info-label">Observações:</label>
                                    <span class="info-value" id="drawer-observacao">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const drawerRows = document.querySelectorAll('.drawer-row');
    const drawer = document.getElementById('detailsDrawer');
    const drawerClose = document.querySelector('.drawer-close');
    const loadingSpinner = document.querySelector('.loading-spinner');
    const drawerContentData = document.querySelector('.drawer-content-data');
    
    console.log('Drawer inicializado');
    console.log('Linhas com drawer-row:', drawerRows.length);
    console.log('Drawer element:', drawer);

    // Abrir drawer ao clicar na linha
    drawerRows.forEach(row => {
        row.addEventListener('click', function(e) {
            // Evitar abrir drawer se clicar em botões de ação
            if (e.target.closest('.btn') || e.target.closest('a') || e.target.closest('form')) {
                console.log('Click cancelado - elemento de ação detectado');
                return;
            }
            
            const entregaId = this.dataset.id;
            console.log('Abrindo drawer para ID:', entregaId);
            
            if (!entregaId) {
                console.error('ID não encontrado na linha');
                return;
            }
            
            openDrawer(entregaId);
        });
    });

    // Fechar drawer
    if (drawerClose) {
        drawerClose.addEventListener('click', closeDrawer);
    }
    
    // Fechar drawer clicando no overlay
    if (drawer) {
        drawer.addEventListener('click', function(e) {
            if (e.target === drawer) {
                closeDrawer();
            }
        });
    }

    // Fechar drawer com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && drawer && drawer.classList.contains('active')) {
            closeDrawer();
        }
    });



    function openDrawer(entregaId) {
        console.log('Função openDrawer chamada para ID:', entregaId);
        
        if (!drawer) {
            console.error('Drawer não encontrado!');
            return;
        }
        
        drawer.classList.add('active');
        
        if (loadingSpinner) {
            loadingSpinner.style.display = 'block';
        }
        
        if (drawerContentData) {
            drawerContentData.style.display = 'none';
        }
        
        // Requisição AJAX para buscar os dados
        fetch(`{{ url('entrega-laudos-financeiro') }}/${entregaId}/details`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Dados recebidos:', data);
            populateDrawer(data);
            if (loadingSpinner) loadingSpinner.style.display = 'none';
            if (drawerContentData) drawerContentData.style.display = 'block';
        })
        .catch(error => {
            console.error('Erro ao carregar dados:', error);
            if (loadingSpinner) loadingSpinner.style.display = 'none';
            if (drawerContentData) {
                drawerContentData.innerHTML = '<div class="alert alert-danger m-3">Erro ao carregar os dados. Tente novamente.</div>';
                drawerContentData.style.display = 'block';
            }
        });
    }

    function closeDrawer() {
        console.log('Fechando drawer');
        if (drawer) {
            drawer.classList.remove('active');
        }
    }

    function populateDrawer(data) {
        console.log('Populando drawer com dados:', data);
        
        // Informações da Perícia
        const setElementText = (id, text) => {
            const element = document.getElementById(id);
            if (element) element.textContent = text || '-';
        };
        
        const setElementHtml = (id, html) => {
            const element = document.getElementById(id);
            if (element) element.innerHTML = html || '-';
        };

        // Informações da Perícia
        setElementText('drawer-processo', data.pericia?.numero_processo);
        setElementText('drawer-requerente', data.pericia?.requerente?.nome);
        setElementText('drawer-vara', data.pericia?.vara);
        setElementText('drawer-tipo-pericia', data.pericia?.tipo_pericia);
        setElementText('drawer-status-pericia', data.pericia?.status_atual);
        setElementText('drawer-data-nomeacao', data.pericia?.data_nomeacao_formatted);
        setElementText('drawer-data-vistoria', data.pericia?.data_vistoria_formatted);
        setElementText('drawer-prazo-final', data.pericia?.prazo_final_formatted);

        // Informações Financeiras
        setElementHtml('drawer-status-financeiro', data.entrega?.status ? 
            `<span class="status-badge ${getStatusClass(data.entrega.status)}">${data.entrega.status}</span>` : '-');
        setElementText('drawer-upj', data.entrega?.upj);
        setElementText('drawer-financeiro', data.entrega?.financeiro);
        setElementText('drawer-valor', data.entrega?.valor_formatado);
        setElementText('drawer-protocolo-laudo', data.pericia?.prazo_final_formatted);
        setElementText('drawer-mes-pagamento', data.entrega?.mes_pagamento);
        setElementText('drawer-sei', data.entrega?.sei);
        setElementText('drawer-nf', data.entrega?.nf);
        setElementText('drawer-observacao', data.entrega?.observacao);
    }

    function getStatusClass(status) {
        const statusLower = status.toLowerCase();
        switch(statusLower) {
            case 'liquidado':
                return 'bg-success text-white';
            case 'pagamento/presidencia':
                return 'bg-warning text-dark';
            case 'aguardando sei':
                return 'bg-info text-white';
            case 'secoft/empenho':
                return 'bg-primary text-white';
            default:
                return 'bg-light text-dark';
        }
    }
});
</script>

<style>
    /* Drawer Styles - Deslizar Lateral */
    .drawer-overlay {
        position: fixed;
        top: 0;
        right: -100%;
        width: 100%;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1050;
        visibility: hidden;
        opacity: 0;
        backdrop-filter: blur(3px);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .drawer-overlay.active {
        right: 0;
        visibility: visible;
        opacity: 1;
    }

    .drawer-content {
        position: absolute;
        right: -700px;
        top: 0;
        width: 700px;
        height: 100vh;
        background: white;
        box-shadow: -2px 0 20px rgba(0, 0, 0, 0.15);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: right 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .drawer-overlay.active .drawer-content {
        right: 0;
    }

    .drawer-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    background: linear-gradient(135deg, #5c58cb 0%, #5c58cb 100%);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }

    .drawer-title {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .drawer-close {
        background: none;
        border: none;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 50%;
        transition: background-color 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
    }

    .drawer-close:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .drawer-body {
        flex: 1;
        overflow-y: auto;
        padding: 0;
    }

    .info-section {
        padding: 1.5rem;
        border-bottom: 1px solid #f8f9fa;
    }

    .info-section:last-child {
        border-bottom: none;
    }

    .section-title {
    color: #5c58cb;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
    }

    .info-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 0.9rem;
    border-left: 4px solid #5c58cb;
        transition: all 0.3s ease;
        min-height: 65px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .info-item:hover {
        background: #e9ecef;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-left-color: #5c58cb;
    }

    .info-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        color: #6c757d;
        margin-bottom: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .info-value {
        font-size: 1rem;
        color: #212529;
        font-weight: 600;
        word-break: break-word;
        line-height: 1.3;
    }

    /* Robust table alignment - força estrutura fixa */
    .table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }
    
    .table thead th:nth-child(1) { width: 11%; } /* Processo */
    .table thead th:nth-child(2) { width: 18%; } /* Requerente */
    .table thead th:nth-child(3) { width: 10%; } /* Status */
    .table thead th:nth-child(4) { width: 8%; }  /* UPJ */
    .table thead th:nth-child(5) { width: 9%; }  /* Vara */
    .table thead th:nth-child(6) { width: 9%; }  /* Financeiro */
    .table thead th:nth-child(7) { width: 9%; }  /* Valor */
    .table thead th:nth-child(8) { width: 9%; }  /* Protocolo */
    .table thead th:nth-child(9) { width: 11%; } /* Mês Pagamento */
    .table thead th:nth-child(10) { width: 6%; } /* Ações */
    
    .table th,
    .table td {
        vertical-align: middle;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        padding: 0.75rem 0.5rem;
        border: none;
    }
    
    .table .text-truncate-col {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    /* Força alinhamento específico por coluna */
    .table tbody td:nth-child(1),
    .table thead th:nth-child(1) { text-align: left; }   /* Processo */
    .table tbody td:nth-child(2),
    .table thead th:nth-child(2) { text-align: left; }   /* Requerente */
    .table tbody td:nth-child(3),
    .table thead th:nth-child(3) { text-align: center; } /* Status */
    .table tbody td:nth-child(4),
    .table thead th:nth-child(4) { text-align: center; } /* UPJ */
    .table tbody td:nth-child(5),
    .table thead th:nth-child(5) { text-align: center; } /* Vara */
    .table tbody td:nth-child(6),
    .table thead th:nth-child(6) { text-align: center; } /* Financeiro */
    .table tbody td:nth-child(7),
    .table thead th:nth-child(7) { text-align: right; }  /* Valor */
    .table tbody td:nth-child(8),
    .table thead th:nth-child(8) { text-align: center; } /* Protocolo */
    .table tbody td:nth-child(9),
    .table thead th:nth-child(9) { text-align: center; } /* Mês Pagamento */
    .table tbody td:nth-child(10),
    .table thead th:nth-child(10) { text-align: center; } /* Ações */

    /* Simplified row hover - sem transformações que podem afetar layout */
    .drawer-row {
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    
    .drawer-row:hover {
        background-color: #f8f9fa !important;
    }

    /* Loading spinner */
    .loading-spinner .spinner-border {
        width: 3rem;
        height: 3rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .drawer-content {
            width: 100% !important;
            right: -100% !important;
        }
        
        .drawer-overlay.active .drawer-content {
            right: 0 !important;
        }
        
        /* Em tablets, 2 colunas */
        .info-section .col-4:nth-child(1),
        .info-section .col-4:nth-child(2) {
            flex: 0 0 50% !important;
            max-width: 50% !important;
        }
        
        .info-section .col-4:nth-child(3) {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }
    
    @media (max-width: 576px) {
        /* Em mobile, volta para layout de 1 coluna */
        .info-section .col-4 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }
        
        .drawer-overlay.style-modal .drawer-content,
        .drawer-overlay.style-fade .drawer-content {
            width: 95% !important;
            max-width: 95% !important;
        }
        
        .drawer-overlay.style-expand .drawer-content {
            top: 10px !important;
            right: 10px !important;
        }
        
        .drawer-overlay.style-expand.active .drawer-content {
            width: calc(100% - 20px) !important;
            height: calc(100vh - 20px) !important;
        }
    }

    /* Efeitos extras */
    .drawer-content {
        animation: drawerAppear 0.3s ease-out;
    }
    
    @keyframes drawerAppear {
        0% { 
            opacity: 0;
            filter: blur(2px);
        }
        100% { 
            opacity: 1;
            filter: blur(0px);
        }
    }

    /* Status badges in drawer */
    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

    <!-- Modal de Edição Financeiro -->
    @include('components.modal-financeiro', [
        'title' => 'Editar Registro Financeiro',
        'action' => '#',
        'method' => 'PUT',
        'info' => 'Edite os dados financeiros abaixo:'
    ])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar máscaras monetárias quando jQuery estiver disponível
            if (typeof $ !== 'undefined' && $.fn.mask) {
                $('.money').mask('#.##0,00', {
                    reverse: true,
                    translation: {
                        '#': {pattern: /[0-9]/}
                    }
                });
            }

            // Botões de editar
            const botoesEdit = document.querySelectorAll('.btn-edit-financeiro');
            
            botoesEdit.forEach(botao => {
                botao.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const status = this.dataset.status;
                    const upj = this.dataset.upj;
                    const financeiro = this.dataset.financeiro;
                    const valor = this.dataset.valor;
                    const protocoloLaudo = this.dataset.protocoloLaudo;
                    const sei = this.dataset.sei;
                    const nf = this.dataset.nf;
                    const mesPagamento = this.dataset.mesPagamento;
                    const empenho = this.dataset.empenho;
                    const observacoes = this.dataset.observacoes;
                    const controlePericiasId = this.dataset.controlePericiasId;
                    const processo = this.dataset.processo;
                    const requerente = this.dataset.requerente;
                    const vara = this.dataset.vara;

                    console.log('Dados do botão:', { upj, vara, status }); // Debug

                    // Primeiro preencher os campos básicos do formulário
                    document.getElementById('status_financeiro').value = status || '';
                    document.getElementById('financeiro').value = financeiro || '';
                    document.getElementById('valor').value = valor || '';
                    document.getElementById('protocolo_laudo').value = protocoloLaudo || '';
                    document.getElementById('sei').value = sei || '';
                    document.getElementById('nf').value = nf || '';
                    document.getElementById('mes_pagamento').value = mesPagamento || '';
                    document.getElementById('empenho').value = empenho || '';
                    document.getElementById('observacoes').value = observacoes || '';
                    document.getElementById('controle_pericias_id').value = controlePericiasId || '';
                    
                    // Atualizar informações da perícia no modal e configurar UPJ
                    if (typeof window.updateModalPericia === 'function') {
                        window.updateModalPericia({
                            processo: processo,
                            requerente: requerente,
                            vara: vara,
                            upj: upj || '' // Passar a UPJ para a função, garantindo que não seja undefined
                        });
                    }
                    
                    // Aplicar máscara no valor depois de preencher
                    if (typeof $ !== 'undefined') {
                        $('#valor').trigger('input');
                    }

                    // Definir a ação do formulário para update
                    const form = document.getElementById('formFinanceiro');
                    form.action = `{{ route('entrega-laudos-financeiro.index') }}/${id}`;
                    
                    // Verificar se já existe o input method, caso não, adicionar
                    let methodInput = form.querySelector('input[name="_method"]');
                    if (!methodInput) {
                        methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'PUT';
                        form.appendChild(methodInput);
                    }

                    // Abrir o modal
                    const modal = new bootstrap.Modal(document.getElementById('modalFinanceiro'));
                    modal.show();
                    
                    // Adicionar event listener para limpar dados quando modal fechar
                    modal._element.addEventListener('hidden.bs.modal', function() {
                        if (typeof window.clearModalPericia === 'function') {
                            window.clearModalPericia();
                        }
                    }, { once: true });
                });
            });

            // Submissão do formulário via AJAX
            document.getElementById('formFinanceiro').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const actionUrl = this.action;
                
                // Desabilitar botão de submit
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Salvando...';
                
                fetch(actionUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Fechar modal
                        bootstrap.Modal.getInstance(document.getElementById('modalFinanceiro')).hide();
                        
                        // Mostrar mensagem de sucesso
                        showToast('success', data.message || 'Registro atualizado com sucesso!');
                        
                        // Recarregar a página após um pequeno delay
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast('error', data.message || 'Erro ao atualizar registro');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    showToast('error', 'Erro de conexão ao atualizar registro');
                })
                .finally(() => {
                    // Reabilitar botão
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });

            // Função para mostrar toast notifications
            function showToast(type, message) {
                // Criar o elemento do toast
                const toast = document.createElement('div');
                toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : type === 'warning' ? 'warning' : 'info'} border-0`;
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');
                toast.style.position = 'fixed';
                toast.style.top = '20px';
                toast.style.right = '20px';
                toast.style.zIndex = '9999';
                toast.style.minWidth = '300px';
                
                const iconMap = {
                    'success': 'check-circle',
                    'error': 'exclamation-circle',
                    'warning': 'exclamation-triangle',
                    'info': 'info-circle'
                };
                
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-${iconMap[type] || 'info-circle'} me-2"></i>
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
        });

        // Botão de impressão
        document.getElementById('btnImprimir').addEventListener('click', function() {
            // Capturar os parâmetros de filtro da URL atual
            const urlParams = new URLSearchParams(window.location.search);
            
            // Construir a URL para impressão
            let printUrl = "{{ route('entrega-laudos-financeiro.print') }}";
            if (urlParams.toString()) {
                printUrl += '?' + urlParams.toString();
            }
            
            // Abrir a impressão em uma nova aba
            window.open(printUrl, '_blank');
        });
    </script>

    <style>
        /* Garantir que a tabela seja sempre responsiva */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Estilização específica para a tabela de laudos financeiros */
        .table-sm td, .table-sm th {
            padding: 0.5rem;
            font-size: 0.875rem;
        }
        
        /* Garantir que a coluna de ações seja sempre visível */
        .table th:last-child,
        .table td:last-child {
            position: sticky;
            right: 0;
            background-color: #fff;
            border-left: 1px solid #dee2e6;
            z-index: 10;
        }
        
        /* Ajuste para linhas alternadas com sticky column */
        .table-striped tbody tr:nth-of-type(odd) td:last-child {
            background-color: rgba(0,0,0,.05);
        }
        
        /* Hover para a coluna sticky */
        .table-hover tbody tr:hover td:last-child {
            background-color: rgba(0,0,0,.075);
        }
        
        /* Estilo específico para o botão de ação */
        .btn-edit-financeiro {
            white-space: nowrap;
        }
        
        /* Responsividade adicional */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.75rem;
            }
            
            .table th, .table td {
                padding: 0.25rem;
                white-space: nowrap;
            }
        }
    </style>

@endsection




