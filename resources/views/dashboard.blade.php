@extends('layouts.app')

@section('content')
    <div class="container-lg px-4">

        <div class="tab-content rounded-bottom">
            <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1011">
                <div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-4">
                    <div class="col">
                        <div
                            class="card border-0 shadow h-100 bg-primary custom-gradient-primary position-relative overflow-hidden">
                            <div class="card-body d-flex flex-column justify-content-between align-items-stretch p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div>
                                        <div class="fs-4 fw-bold text-white">{{ $quantidadeVistorias }}</div>
                                        <div class="text-white-50 text-uppercase fw-semibold small">Vistorias</div>
                                    </div>
                                    <span class="rounded-circle bg-white bg-opacity-25 p-2 ms-2 d-inline-block">
                                        <i class="fas fa-clipboard-list fa-lg text-white"></i>
                                    </span>
                                </div>
                                <a href="{{ route('vistorias.index') }}"
                                    class="btn btn-light rounded-pill px-3 py-1 fw-bold shadow-sm mt-auto">Acessar
                                    Vistorias</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div
                            class="card border-0 shadow h-100 bg-success custom-gradient-success position-relative overflow-hidden">
                            <div class="card-body d-flex flex-column justify-content-between align-items-stretch p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div>
                                        <div class="fs-4 fw-bold text-white">{{ $quantidadeImoveis }}</div>
                                        <div class="text-white-50 text-uppercase fw-semibold small">Imóveis</div>
                                    </div>
                                    <span class="rounded-circle bg-white bg-opacity-25 p-2 ms-2 d-inline-block">
                                        <i class="fas fa-home fa-lg text-white"></i>
                                    </span>
                                </div>
                                <a href="{{ route('imoveis.index') }}"
                                    class="btn btn-light rounded-pill px-3 py-1 fw-bold shadow-sm mt-auto">Acessar
                                    Imóveis</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div
                            class="card border-0 shadow h-100 bg-warning custom-gradient-warning position-relative overflow-hidden">
                            <div class="card-body d-flex flex-column justify-content-between align-items-stretch p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div>
                                        <div class="fs-4 fw-bold text-white">{{ $quantidadePericias }}</div>
                                        <div class="text-white-50 text-uppercase fw-semibold small">Perícias</div>
                                    </div>
                                    <span class="rounded-circle bg-white bg-opacity-25 p-2 ms-2 d-inline-block">
                                        <i class="fas fa-balance-scale fa-lg text-white"></i>
                                    </span>
                                </div>
                                <a href="{{ route('controle-pericias.index') }}"
                                    class="btn btn-light rounded-pill px-3 py-1 fw-bold shadow-sm mt-auto">Acessar
                                    Perícias</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div
                            class="card border-0 shadow h-100 bg-danger custom-gradient-danger position-relative overflow-hidden">
                            <div class="card-body d-flex flex-column justify-content-between align-items-stretch p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div>
                                        <div class="fs-4 fw-bold text-white">{{ $quantidadeTarefas }}</div>
                                        <div class="text-white-50 text-uppercase fw-semibold small">Tarefas</div>
                                    </div>
                                    <span class="rounded-circle bg-white bg-opacity-25 p-2 ms-2 d-inline-block">
                                        <i class="fas fa-tasks fa-lg text-white"></i>
                                    </span>
                                </div>
                                <a href="{{ route('controle_de_tarefas.index') }}"
                                    class="btn btn-light rounded-pill px-3 py-1 fw-bold shadow-sm mt-auto">Acessar
                                    Tarefas</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row.g-4-->
            </div>
        </div>

        <div class="row mb-4 mt-4">
            <div class="col-lg-8 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title d-flex align-items-center">
                            <i class="fas fa-chart-bar me-2 text-primary"></i>
                            Vistorias por Mês
                        </h5>
                        <canvas id="vistoriasChart" width="558" height="279"
                            style="display: block; box-sizing: border-box; height: 279px; width: 558px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title d-flex align-items-center justify-content-between">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-2 text-warning"></i>
                                Compromissos
                            </span>
                            <a href="{{ route('agenda.index') }}"
                                class="btn btn-outline-primary btn-sm ms-2 d-flex align-items-center">
                                <i class="fas fa-calendar-day me-1"></i> Agenda
                            </a>
                        </h5>
                        <ul class="list-group list-group-flush">
                            @forelse ($proximosCompromissos as $compromisso)
                                @php
                                    $isToday = \Carbon\Carbon::parse($compromisso->data)->isToday();
                                    $compromissoClass = $isToday
                                        ? 'compromisso-item compromisso-hoje'
                                        : 'compromisso-item';
                                @endphp
                                <li class="list-group-item {{ $compromissoClass }}" style="cursor:pointer;"
                                    data-titulo="{{ $compromisso->titulo ?? 'Compromisso' }}"
                                    data-data="{{ \Carbon\Carbon::parse($compromisso->data)->format('d/m/Y') }}"
                                    data-descricao="{{ $compromisso->descricao ?? '' }}"
                                    data-local="{{ $compromisso->local ?? '' }}"
                                    data-tipo="{{ $compromisso->tipo ?? 'Compromisso' }}"
                                    data-requerido="{{ $compromisso->requerido ?? '' }}"
                                    data-requerente="{{ $compromisso->requerente->nome ?? '' }}"
                                    data-nota="{{ $compromisso->nota ?? '' }}">
                                    <div class="fw-bold d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar-check me-1 text-success"></i>
                                            {{ $compromisso->tipoDeEvento->nome ?? 'Compromisso' }}
                                            <span class="compromisso-data-pequena">- <i
                                                    class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($compromisso->data)->format('d/m/Y') }}</span>
                                        </div>
                                        @if ($isToday)
                                            <span class="badge bg-gradient-primary text-white badge-hoje pulse-animation">
                                                <i class="fas fa-star me-1"></i>HOJE
                                            </span>
                                        @endif
                                    </div>
                                    <style>
                                        .compromisso-data-pequena {
                                            font-size: 0.92em;
                                            color: #888;
                                            font-weight: 400;
                                            margin-left: 2px;
                                            vertical-align: middle;
                                        }
                                    </style>

                                    @if (strtolower($compromisso->tipo ?? '') === 'vistoria')
                                        @if ($compromisso->requerido || $compromisso->requerente)
                                            <div class="text-muted" style="font-size: 0.85rem; margin-top: 2px;">
                                                @if ($compromisso->requerido)
                                                    <div><i class="fas fa-user-tag me-1"
                                                            style="font-size: 0.8rem;"></i>{{ $compromisso->requerido }}
                                                    </div>
                                                @endif
                                                @if ($compromisso->requerente)
                                                    <div><i class="fas fa-user me-1"
                                                            style="font-size: 0.8rem;"></i>{{ $compromisso->requerente->nome ?? $compromisso->requerente }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        @if ($compromisso->nota)
                                            <div class="text-muted"
                                                style="font-size: 0.85rem; margin-top: 2px; font-style: italic;">
                                                <i class="fas fa-sticky-note me-1"
                                                    style="font-size: 0.8rem;"></i>{{ Str::limit($compromisso->nota, 50) }}
                                            </div>
                                        @endif
                                    @endif

                                    <div class="text-muted small mt-1">

                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-muted"><i class="fas fa-calendar-times me-1"></i> Nenhum
                                    compromisso futuro.</li>
                            @endforelse
                        </ul>
                        <!-- Modal de detalhes do compromisso -->
                        <div class="modal fade" id="compromissoModal" tabindex="-1" aria-labelledby="compromissoModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content border-0 shadow-lg">
                                    <div class="modal-header bg-gradient bg-primary text-white border-0">
                                        <h5 class="modal-title d-flex align-items-center" id="compromissoModalLabel">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            Detalhes do Compromisso
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Fechar"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="row g-4">
                                            <!-- Informações principais -->
                                            <div class="col-12">
                                                <div class="card border-0 bg-light">
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-8">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <i class="fas fa-tag text-primary me-2"></i>
                                                                    <small
                                                                        class="text-muted text-uppercase fw-bold">Título</small>
                                                                </div>
                                                                <h6 class="mb-0 fw-bold" id="modalCompromissoTitulo"></h6>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <i class="fas fa-bookmark text-warning me-2"></i>
                                                                    <small
                                                                        class="text-muted text-uppercase fw-bold">Tipo</small>
                                                                </div>
                                                                <span class="badge bg-primary px-3 py-2 rounded-pill"
                                                                    id="modalCompromissoTipo"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Data e Local -->
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-clock text-success me-2"></i>
                                                    <small class="text-muted text-uppercase fw-bold">Data</small>
                                                </div>
                                                <div class="p-3 bg-light rounded">
                                                    <span class="fw-bold" id="modalCompromissoData"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                                    <small class="text-muted text-uppercase fw-bold">Local</small>
                                                </div>
                                                <div class="p-3 bg-light rounded">
                                                    <span id="modalCompromissoLocal"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Informações específicas para vistorias -->
                                        <div id="modalVistoriaInfo" style="display: none;" class="mt-4">
                                            <div class="card border-0 bg-info bg-opacity-10">
                                                <div class="card-header bg-info bg-opacity-20 border-0">
                                                    <h6 class="mb-0 text-info">
                                                        <i class="fas fa-eye me-2"></i>
                                                        Informações da Vistoria
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="fas fa-user-tag text-info me-2"></i>
                                                                <small
                                                                    class="text-muted text-uppercase fw-bold">Requerido</small>
                                                            </div>
                                                            <div class="p-2 bg-white rounded border">
                                                                <span id="modalCompromissoRequerido"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="fas fa-user text-info me-2"></i>
                                                                <small
                                                                    class="text-muted text-uppercase fw-bold">Requerente</small>
                                                            </div>
                                                            <div class="p-2 bg-white rounded border">
                                                                <span id="modalCompromissoRequerente"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Nota para outros tipos -->
                                        <div id="modalNotaInfo" style="display: none;" class="mt-4">
                                            <div class="card border-0 bg-warning bg-opacity-10">
                                                <div class="card-header bg-warning bg-opacity-20 border-0">
                                                    <h6 class="mb-0 text-warning-emphasis">
                                                        <i class="fas fa-sticky-note me-2"></i>
                                                        Nota do Compromisso
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="p-3 bg-white rounded border" id="modalCompromissoNota">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Descrição -->
                                        <div class="mt-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="fas fa-file-alt text-secondary me-2"></i>
                                                <h6 class="mb-0 text-secondary">Descrição</h6>
                                            </div>
                                            <div class="p-3 bg-light rounded border" id="modalCompromissoDescricao"
                                                style="min-height: 60px;"></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 bg-light">
                                        <button type="button" class="btn btn-outline-secondary px-4"
                                            data-bs-dismiss="modal">
                                            <i class="fas fa-times me-2"></i>Fechar
                                        </button>
                                        <!-- <button type="button" class="btn btn-primary px-4">
                                                    <i class="fas fa-edit me-2"></i>Editar
                                                </button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção de Gráficos de Perícias -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-gradient-warning text-white border-0 py-3">
                        <h4 class="mb-0 d-flex align-items-center">
                            <i class="fas fa-gavel me-3"></i>
                            <span>Análise de Perícias</span>
                            <a href="{{ route('controle-pericias.index') }}"
                                class="btn btn-outline-light btn-sm ms-auto d-flex align-items-center">
                                <i class="fas fa-external-link-alt me-2"></i>Ver Todas
                            </a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Métricas Rápidas de Perícias -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100 bg-danger bg-opacity-10">
                    <div class="card-body text-center py-3">
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <div class="bg-danger bg-opacity-20 rounded-circle p-2 me-2">
                                <i class="fas fa-exclamation-triangle fa-lg text-danger"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 text-danger" style="font-size:1.6rem;">{{ $periciasPrazosVencidos }}</h4>
                                <div class="pericia-metrica-legenda">Prazos vencidos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100 bg-info bg-opacity-10">
                    <div class="card-body text-center py-3">
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <div class="bg-info bg-opacity-20 rounded-circle p-2 me-2">
                                <i class="fas fa-eye fa-lg text-info"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 text-info" style="font-size:1.6rem;">{{ $periciasPendentesVistoria }}
                                </h4>
                                <div class="pericia-metrica-legenda">Aguard. vistoria</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100 bg-primary bg-opacity-10">
                    <div class="card-body text-center py-3">
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <div class="bg-primary bg-opacity-20 rounded-circle p-2 me-2">
                                <i class="fas fa-edit fa-lg text-primary"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 text-primary" style="font-size:1.6rem;">{{ $periciasEmRedacao }}</h4>
                                <div class="pericia-metrica-legenda">Em redação</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100 bg-success bg-opacity-10">
                    <div class="card-body text-center py-3">
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <div class="bg-success bg-opacity-20 rounded-circle p-2 me-2">
                                <i class="fas fa-check-circle fa-lg text-success"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 text-success" style="font-size:1.6rem;">{{ $periciasEntregues }}</h4>
                                <div class="pericia-metrica-legenda">Entregues</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .pericia-metrica-legenda {
                font-size: 0.95rem;
                color: #666;
                font-weight: 500;
                letter-spacing: 0.01em;
                text-transform: none;
                margin-top: 2px;
            }
            
            /* Estilos para o modal de tarefas */
            .table th {
                background-color: #f8f9fa;
                border-top: none;
                font-weight: 600;
                font-size: 0.9rem;
            }
            
            .table td {
                vertical-align: middle;
                font-size: 0.9rem;
            }
            
            .badge {
                font-size: 0.75rem;
            }
            
            /* Ajuste para células com texto longo */
            .table td div[title] {
                cursor: help;
            }
            
            /* Cursor pointer para badges clicáveis */
            .badge-status {
                transition: all 0.2s ease;
            }
            
            .badge-status:hover {
                transform: scale(1.05);
                filter: brightness(1.1);
            }
        </style>

        <!-- Gráficos de Perícias (Apenas Status e Tipo) -->
        <div class="row mb-4 g-4 align-items-stretch">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 h-100 bg-white position-relative">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h4 class="card-title mb-4 d-flex align-items-center text-warning">
                            <i class="fas fa-chart-pie me-2"></i>
                            Distribuição por Status
                        </h4>
                        <div class="d-flex flex-column align-items-center justify-content-center"
                            style="min-height: 320px;">
                            <canvas id="periciasStatusChart" style="max-height: 260px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 h-100 bg-white position-relative">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h4 class="card-title mb-4 d-flex align-items-center text-info">
                            <i class="fas fa-chart-donut me-2"></i>
                            Distribuição por Tipo de Perícia
                        </h4>
                        <div class="d-flex flex-column align-items-center justify-content-center"
                            style="min-height: 320px;">
                            <canvas id="periciasTipoChart" style="max-height: 260px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Modal de detalhes do compromisso
                document.querySelectorAll('.compromisso-item').forEach(function(item) {
                    item.addEventListener('click', function() {
                        const titulo = this.getAttribute('data-titulo');
                        const data = this.getAttribute('data-data');
                        const local = this.getAttribute('data-local');
                        const descricao = this.getAttribute('data-descricao');
                        const tipo = this.getAttribute('data-tipo');
                        const requerido = this.getAttribute('data-requerido');
                        const requerente = this.getAttribute('data-requerente');
                        const nota = this.getAttribute('data-nota');

                        // Preenche as informações básicas
                        document.getElementById('modalCompromissoTitulo').textContent = titulo;
                        document.getElementById('modalCompromissoTipo').textContent = tipo;

                        // Verifica se é hoje e adiciona indicação especial
                        const modalDataElement = document.getElementById('modalCompromissoData');
                        const hoje = new Date().toLocaleDateString('pt-BR');
                        const isHoje = data === hoje;

                        if (isHoje) {
                            modalDataElement.innerHTML = `
                                <div class="d-flex align-items-center">
                                    <span class="me-2">${data}</span>
                                    <span class="badge bg-gradient-warning text-white pulse-animation">
                                        <i class="fas fa-star me-1"></i>HOJE
                                    </span>
                                </div>
                            `;
                        } else {
                            modalDataElement.textContent = data;
                        }

                        document.getElementById('modalCompromissoLocal').textContent = local || '-';
                        document.getElementById('modalCompromissoDescricao').textContent = descricao ||
                            '-';

                        // Controla a exibição das seções específicas
                        const vistoriaInfo = document.getElementById('modalVistoriaInfo');
                        const notaInfo = document.getElementById('modalNotaInfo');

                        if (tipo && tipo.toLowerCase() === 'vistoria') {
                            // Mostra informações de vistoria
                            document.getElementById('modalCompromissoRequerido').textContent =
                                requerido || '-';
                            document.getElementById('modalCompromissoRequerente').textContent =
                                requerente || '-';
                            vistoriaInfo.style.display = 'block';
                            notaInfo.style.display = 'none';
                        } else {
                            // Mostra nota para outros tipos
                            document.getElementById('modalCompromissoNota').textContent = nota || '-';
                            vistoriaInfo.style.display = 'none';
                            notaInfo.style.display = 'block';
                        }

                        var modal = new bootstrap.Modal(document.getElementById('compromissoModal'));
                        modal.show();
                    });
                });
                const ctx = document.getElementById('vistoriasChart');
                if (ctx) {
                    // Monta os labels (meses) a partir dos dados de vistorias agendadas e realizadas
                    let mesesAgendadas = {!! json_encode($vistoriasAgendadasPorMes->pluck('mes')->toArray()) !!};
                    let mesesRealizadas = {!! json_encode($vistoriasRealizadasPorMes->pluck('mes')->toArray()) !!};
                    let todosMeses = Array.from(new Set([...mesesAgendadas, ...mesesRealizadas])).sort();

                    // Função para formatar mês/ano em português
                    function formatarMesAno(mesString) {
                        const [ano, mes] = mesString.split('-');
                        const meses = [
                            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                        ];
                        return meses[parseInt(mes) - 1] + '/' + ano;
                    }

                    // Formata os labels para mostrar o nome do mês/ano
                    let labels = todosMeses.map(function(mes) {
                        return formatarMesAno(mes);
                    });

                    // Preenche os dados para cada mês (0 se não houver)
                    let agendadasData = todosMeses.map(mes => {
                        let idx = mesesAgendadas.indexOf(mes);
                        return idx !== -1 ? {!! json_encode($vistoriasAgendadasPorMes->pluck('total')->toArray()) !!}[idx] : 0;
                    });
                    let realizadasData = todosMeses.map(mes => {
                        let idx = mesesRealizadas.indexOf(mes);
                        return idx !== -1 ? {!! json_encode($vistoriasRealizadasPorMes->pluck('total')->toArray()) !!}[idx] : 0;
                    });

                    // Renderiza o gráfico diretamente
                    function renderChart() {
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                        label: 'Vistorias Agendadas',
                                        data: agendadasData,
                                        backgroundColor: 'rgba(37, 99, 235, 0.6)',
                                        borderColor: '#2563eb',
                                        borderWidth: 2,
                                        borderRadius: 8,
                                        maxBarThickness: 40
                                    },
                                    {
                                        label: 'Vistorias Realizadas',
                                        data: realizadasData,
                                        backgroundColor: 'rgba(16, 185, 129, 0.6)',
                                        borderColor: '#10b981',
                                        borderWidth: 2,
                                        borderRadius: 8,
                                        maxBarThickness: 40
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: true
                                    },
                                    tooltip: {
                                        enabled: true,
                                        callbacks: {
                                            label: function(context) {
                                                return ' ' + context.parsed.y + ' vistorias';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            color: '#6b7280',
                                            font: {
                                                weight: 'bold'
                                            }
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: '#e5e7eb'
                                        },
                                        ticks: {
                                            color: '#6b7280'
                                        }
                                    }
                                }
                            }
                        });
                    }

                    // Chama a função para renderizar o gráfico
                    renderChart();
                }

                // === GRÁFICOS DE PERÍCIAS (Apenas Status e Tipo) ===
                // Gráfico de Perícias por Status (Doughnut)
                const statusCtx = document.getElementById('periciasStatusChart');
                if (statusCtx) {
                    const statusData = {!! json_encode($periciasPorStatus) !!};
                    const statusLabels = statusData.map(item => item.status_atual || 'Sem Status');
                    const statusValues = statusData.map(item => item.total);
                    // Cores elegantes para status
                    const statusColors = [
                        '#fd7e14', '#198754', '#0dcaf0', '#ffc107', '#dc3545', '#6f42c1', '#20c997', '#6c757d'
                    ];
                    new Chart(statusCtx, {
                        type: 'doughnut',
                        data: {
                            labels: statusLabels,
                            datasets: [{
                                data: statusValues,
                                backgroundColor: statusColors.slice(0, statusLabels.length),
                                borderWidth: 2,
                                borderColor: '#fff',
                                hoverOffset: 16
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '70%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        font: {
                                            size: 14,
                                            weight: 'bold'
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const total = statusValues.reduce((a, b) => a + b, 0);
                                            const percentage = ((context.raw / total) * 100).toFixed(1);
                                            return ` ${context.label}: ${context.raw} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
                // Gráfico de Perícias por Tipo (Pie)
                const tipoCtx = document.getElementById('periciasTipoChart');
                if (tipoCtx) {
                    const tipoData = {!! json_encode($periciasPorTipo) !!};
                    const tipoLabels = tipoData.map(item => item.tipo_pericia || 'Não Informado');
                    const tipoValues = tipoData.map(item => item.total);
                    const tipoColors = [
                        '#0d6efd', '#198754', '#dc3545', '#ffc107', '#fd7e14', '#6f42c1', '#20c997', '#6c757d'
                    ];
                    new Chart(tipoCtx, {
                        type: 'pie',
                        data: {
                            labels: tipoLabels,
                            datasets: [{
                                data: tipoValues,
                                backgroundColor: tipoColors.slice(0, tipoLabels.length),
                                borderWidth: 2,
                                borderColor: '#fff',
                                hoverOffset: 16
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        font: {
                                            size: 14,
                                            weight: 'bold'
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const total = tipoValues.reduce((a, b) => a + b, 0);
                                            const percentage = ((context.raw / total) * 100).toFixed(1);
                                            return ` ${context.label}: ${context.raw} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Gráfico de Perícias por Responsável (Bar Horizontal)
                const responsavelCtx = document.getElementById('periciasResponsavelChart');
                if (responsavelCtx) {
                    const responsavelData = {!! json_encode($periciasPorResponsavel) !!};
                    const responsavelLabels = responsavelData.map(item =>
                        item.responsavel_tecnico ? item.responsavel_tecnico.nome : 'Não Atribuído'
                    );
                    const responsavelValues = responsavelData.map(item => item.total);

                    new Chart(responsavelCtx, {
                        type: 'bar',
                        data: {
                            labels: responsavelLabels,
                            datasets: [{
                                label: 'Perícias Atribuídas',
                                data: responsavelValues,
                                backgroundColor: 'rgba(13, 110, 253, 0.8)',
                                borderColor: '#0d6efd',
                                borderWidth: 1,
                                borderRadius: 6
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return ` ${context.parsed.x} perícias`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    grid: {
                                        color: '#e9ecef'
                                    },
                                    ticks: {
                                        stepSize: 1
                                    }
                                },
                                y: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        font: {
                                            size: 11
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Gráfico Timeline de Perícias (Line)
                const timelineCtx = document.getElementById('periciasTimelineChart');
                if (timelineCtx) {
                    const timelineData = {!! json_encode($periciasPorMes) !!};

                    // Função para formatar mês/ano
                    function formatarMes(mesString) {
                        if (!mesString) return '';
                        const [ano, mes] = mesString.split('-');
                        const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
                            'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
                        ];
                        return meses[parseInt(mes) - 1] + '/' + ano.slice(2);
                    }

                    const timelineLabels = timelineData.map(item => formatarMes(item.mes));
                    const timelineValues = timelineData.map(item => item.total);

                    new Chart(timelineCtx, {
                        type: 'line',
                        data: {
                            labels: timelineLabels,
                            datasets: [{
                                label: 'Perícias Criadas',
                                data: timelineValues,
                                borderColor: '#198754',
                                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                                borderWidth: 3,
                                pointBackgroundColor: '#198754',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 6,
                                pointHoverRadius: 8,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return ` ${context.parsed.y} perícias`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        font: {
                                            size: 10
                                        }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: '#e9ecef'
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        font: {
                                            size: 10
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>

        <div class="table-responsive">
            <table class="table border mb-0 align-middle">
                <thead class="fw-semibold text-nowrap">
                    <tr>
                        <th class="bg-body-secondary text-center"><i class="fas fa-user"></i></th>
                        <th class="bg-body-secondary">Nome</th>
                        <th class="bg-body-secondary">E-mail</th>
                        <th class="bg-body-secondary text-center">Total</th>
                        <th class="bg-body-secondary text-center"><i class="fas fa-hourglass-start text-warning"></i> Não
                            iniciada</th>
                        <th class="bg-body-secondary text-center"><i class="fas fa-spinner text-info"></i> Em andamento
                        </th>
                        <th class="bg-body-secondary text-center"><i class="fas fa-exclamation-triangle text-danger"></i>
                            Atrasada</th>
                        <th class="bg-body-secondary text-center"><i class="fas fa-check-circle text-success"></i>
                            Concluída</th>
                        <th class="bg-body-secondary text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tarefasPorUsuario as $usuario)
                        <tr>
                            <td class="text-center">
                                <div class="avatar avatar-md">
                                    <img class="avatar-img"
                                        src="{{ $usuario['avatar'] && strpos($usuario['avatar'], 'default.png') === false ? $usuario['avatar'] : asset('img/user.png') }}"
                                        alt="{{ $usuario['nome'] }}">
                                </div>
                            </td>
                            <td class="fw-semibold">
                                <a href="{{ route('controle_de_tarefas.index', ['user' => $usuario['id']]) }}" class="text-decoration-none text-primary" title="Ver tarefas do usuário">
                                    {{ $usuario['nome'] }}
                                </a>
                            </td>
                            <td class="text-muted small">{{ $usuario['email'] }}</td>
                            <td class="text-center fw-bold">{{ $usuario['total'] }}</td>
                            <td class="text-center">
                                <span class="badge bg-warning text-dark badge-status" style="cursor:pointer" 
                                      data-user-id="{{ $usuario['id'] }}" 
                                      data-user-nome="{{ $usuario['nome'] }}" 
                                      data-user-email="{{ $usuario['email'] }}" 
                                      data-status="nao_iniciada"
                                      data-total="{{ $usuario['nao_iniciada'] ?? 0 }}">{{ $usuario['nao_iniciada'] ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark badge-status" style="cursor:pointer"
                                      data-user-id="{{ $usuario['id'] }}" 
                                      data-user-nome="{{ $usuario['nome'] }}" 
                                      data-user-email="{{ $usuario['email'] }}" 
                                      data-status="em_andamento"
                                      data-total="{{ $usuario['em_andamento'] ?? 0 }}">{{ $usuario['em_andamento'] ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger badge-status" style="cursor:pointer"
                                      data-user-id="{{ $usuario['id'] }}" 
                                      data-user-nome="{{ $usuario['nome'] }}" 
                                      data-user-email="{{ $usuario['email'] }}" 
                                      data-status="atrasada"
                                      data-total="{{ $usuario['atrasada'] ?? 0 }}">{{ $usuario['atrasada'] ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success badge-status" style="cursor:pointer" 
                                      data-user-id="{{ $usuario['id'] }}" 
                                      data-user-nome="{{ $usuario['nome'] }}" 
                                      data-user-email="{{ $usuario['email'] }}" 
                                      data-status="concluida"
                                      data-total="{{ $usuario['concluida'] ?? 0 }}">{{ $usuario['concluida'] ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('controle_de_tarefas.index', ['user' => $usuario['id']]) }}"
                                    class="btn btn-outline-primary btn-sm" title="Ver tarefas do usuário">
                                    <i class="fas fa-tasks"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Nenhum usuário com tarefas encontradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal de tarefas por status -->
        <div class="modal fade" id="tarefasModal" tabindex="-1" aria-labelledby="tarefasModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white border-0" id="tarefasModalHeader">
                        <h5 class="modal-title" id="tarefasModalLabel">
                            <i class="fas fa-tasks me-2"></i>
                            <span id="tarefasModalTitle">Tarefas</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Responsável:</strong> <span id="tarefasResponsavel"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Status:</strong> <span id="tarefasStatus"></span>
                                </div>
                            </div>
                        </div>
                        <div id="tarefasModalContent">
                            <!-- Conteúdo dinâmico da tabela -->
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener para todos os badges de status
            document.querySelectorAll('.badge-status').forEach(function(badge) {
                badge.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const userNome = this.getAttribute('data-user-nome');
                    const userEmail = this.getAttribute('data-user-email');
                    const status = this.getAttribute('data-status');
                    const total = this.getAttribute('data-total');
                    
                    // Se não há tarefas, não abrir modal
                    if (parseInt(total) === 0) {
                        return;
                    }
                    
                    // Configurar cores e textos baseados no status
                    let statusConfig = {
                        'nao_iniciada': {
                            color: 'bg-warning',
                            text: 'Não Iniciadas',
                            icon: 'fas fa-hourglass-start'
                        },
                        'em_andamento': {
                            color: 'bg-info',
                            text: 'Em Andamento',
                            icon: 'fas fa-spinner'
                        },
                        'atrasada': {
                            color: 'bg-danger',
                            text: 'Atrasadas',
                            icon: 'fas fa-exclamation-triangle'
                        },
                        'concluida': {
                            color: 'bg-success',
                            text: 'Concluídas',
                            icon: 'fas fa-check-circle'
                        }
                    };
                    
                    const config = statusConfig[status];
                    
                    // Configurar modal
                    const modalHeader = document.getElementById('tarefasModalHeader');
                    const modalTitle = document.getElementById('tarefasModalTitle');
                    const responsavelSpan = document.getElementById('tarefasResponsavel');
                    const statusSpan = document.getElementById('tarefasStatus');
                    
                    modalHeader.className = `modal-header text-white border-0 ${config.color}`;
                    modalTitle.innerHTML = `<i class="${config.icon} me-2"></i>Tarefas ${config.text}`;
                    responsavelSpan.textContent = `${userNome} (${userEmail})`;
                    statusSpan.innerHTML = `<span class="badge ${config.color} text-white">${config.text}: ${total}</span>`;
                    
                    // Mostrar loading
                    document.getElementById('tarefasModalContent').innerHTML = `
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                            <p class="mt-2">Carregando tarefas...</p>
                        </div>`;
                    
                    // Abrir modal primeiro
                    var modal = new bootstrap.Modal(document.getElementById('tarefasModal'));
                    modal.show();
                    
                    // Buscar tarefas via AJAX
                    fetch(`{{ route('dashboard.tarefas_por_status') }}?user_id=${userId}&status=${status}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(tarefas => {
                        // Gerar tabela com dados reais
                        let tableHtml = `
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Processo</th>
                                            <th>Descrição</th>
                                            <th>Tipo Atividade</th>
                                            <th>Prioridade</th>
                                            <th>Prazo</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                        
                        if(tarefas.length > 0) {
                            tarefas.forEach(function(tarefa) {
                                let prioridadeClass = tarefa.prioridade === 'Alta' ? 'danger' : 
                                                     (tarefa.prioridade === 'Média' ? 'warning' : 'success');
                                
                                tableHtml += `
                                    <tr>
                                        <td>${tarefa.processo || '-'}</td>
                                        <td>
                                            <div style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" 
                                                 title="${(tarefa.descricao_atividade || '').replace(/"/g, '&quot;')}">
                                                ${tarefa.descricao_atividade || '-'}
                                            </div>
                                        </td>
                                        <td>${tarefa.tipo_atividade || '-'}</td>
                                        <td><span class="badge bg-${prioridadeClass}">${tarefa.prioridade || '-'}</span></td>
                                        <td>${tarefa.prazo || '-'}</td>
                                        <td>
                                            <a href="/controle_de_tarefas/${tarefa.id}" class="btn btn-sm btn-outline-primary" title="Ver detalhes da tarefa">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>`;
                            });
                        } else {
                            tableHtml += `
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                        Nenhuma tarefa encontrada com este status.
                                    </td>
                                </tr>`;
                        }
                        
                        tableHtml += `
                                    </tbody>
                                </table>
                            </div>`;
                        
                        document.getElementById('tarefasModalContent').innerHTML = tableHtml;
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        document.getElementById('tarefasModalContent').innerHTML = `
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Erro ao carregar tarefas. Tente novamente.
                            </div>`;
                    });
                });
            });
        });
        </script>
                    </div>
                </div>
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

        .form-switch .form-check-input {
            width: 3em;
            height: 1.5em;
            cursor: pointer;
        }

        .form-switch .form-check-label {
            font-weight: 500;
            cursor: pointer;
            user-select: none;
        }

        /* Estilo para os compromissos */
        .compromisso-item {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .compromisso-item:hover {
            background-color: #f8f9fa;
            border-left-color: #0d6efd;
            transform: translateX(2px);
        }

        /* Estilo especial para compromissos de hoje */
        .compromisso-hoje {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-left: 4px solid #fd7e14 !important;
            box-shadow: 0 2px 8px rgba(253, 126, 20, 0.2);
            position: relative;
            overflow: hidden;
        }

        .compromisso-hoje::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #fd7e14, #ffc107, #fd7e14);
            animation: shimmer 2s infinite;
        }

        .compromisso-hoje:hover {
            background: linear-gradient(135deg, #fff3cd 0%, #ffe082 100%);
            border-left-color: #fd7e14 !important;
            transform: translateX(3px);
            box-shadow: 0 4px 12px rgba(253, 126, 20, 0.3);
        }

        /* Badge "HOJE" com animação */
        .badge-hoje {
            background: linear-gradient(135deg, #fd7e14, #ffc107) !important;
            border: 1px solid rgba(255, 255, 255, 0.3);
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .badge-hoje::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            bottom: -1px;
            background: linear-gradient(45deg, #fd7e14, #ffc107, #fd7e14, #ffc107);
            border-radius: inherit;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .badge-hoje:hover::before {
            opacity: 1;
        }

        /* Badge especial para o modal */
        .bg-gradient-warning {
            background: linear-gradient(135deg, #fd7e14, #ffc107) !important;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            box-shadow: 0 2px 6px rgba(253, 126, 20, 0.3);
        }

        /* Animação de pulso suave */
        .pulse-animation {
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2), 0 0 0 0 rgba(253, 126, 20, 0.7);
            }

            50% {
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2), 0 0 0 3px rgba(253, 126, 20, 0.3);
            }
        }

        /* Animação shimmer para a borda superior */
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .compromisso-item .text-muted {
            line-height: 1.3;
        }

        /* Melhorias para o modal */
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }

        .modal-header.bg-gradient {
            background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
        }

        .modal-body .card {
            transition: all 0.2s ease;
        }

        .modal-body .card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .badge.rounded-pill {
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Animação suave para as seções do modal */
        #modalVistoriaInfo,
        #modalNotaInfo {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ajuste mapa */

        .custom-marker {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .legend .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .bg-blue {
            background-color: #0d6efd;
        }

        .bg-green {
            background-color: #198754;
        }

        .bg-orange {
            background-color: #fd7e14;
        }

        .bg-olive {
            background-color: #808000;
        }

        .filter-btn {
            cursor: pointer;
            transition: all 0.3s;
            opacity: 0.7;
        }

        .filter-btn.active {
            opacity: 1;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
        }

        .filter-btn:not(.active) {
            text-decoration: line-through;
            filter: grayscale(70%);
        }

        .count {
            font-size: 0.8em;
            opacity: 0.9;
            margin-left: 3px;
        }

        /* Melhora o alinhamento dos ícones */
        .filter-btn i {
            margin-right: 5px;
        }

        .count {
            transition: all 0.3s ease;
            /* Suaviza a animação */
            display: inline-block;
            /* Necessário para a transformação */
        }

        .count-update {
            transform: scale(1.1);
            /* Aumenta 10% */
            color: #ff0;
            /* Muda para amarelo momentaneamente */
            font-weight: bold;
        }

        /* === ESTILOS PARA GRÁFICOS DE PERÍCIAS === */
        .bg-gradient-warning {
            background: linear-gradient(135deg, #fd7e14 0%, #fd7e14 100%);
        }

        /* Cards de métricas de perícias */
        .card.bg-danger.bg-opacity-10:hover,
        .card.bg-info.bg-opacity-10:hover,
        .card.bg-primary.bg-opacity-10:hover,
        .card.bg-success.bg-opacity-10:hover {
            transform: translateY(-2px);
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Animação para os números das métricas */
        .card h3 {
            transition: all 0.3s ease;
        }

        .card:hover h3 {
            transform: scale(1.1);
        }

        /* Melhorias nos canvas dos gráficos */
        #periciasStatusChart,
        #periciasTipoChart,
        #periciasResponsavelChart,
        #periciasTimelineChart {
            transition: all 0.3s ease;
        }

        /* Header personalizado da seção de perícias */
        .bg-gradient-warning {
            background: linear-gradient(135deg, #fd7e14, #f58220, #e07b1a);
        }

        /* Responsividade para gráficos em telas menores */
        @media (max-width: 768px) {
            .card .card-body canvas {
                max-height: 250px !important;
            }

            .row.mb-4 .col-md-3 {
                margin-bottom: 1rem;
            }
        }

        /* Hover effect nos cards de gráficos */
        .card.shadow-sm:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            transition: box-shadow 0.3s ease;
        }

        /* Estilo para títulos dos gráficos */
        .card-title i {
            background: rgba(0, 0, 0, 0.1);
            padding: 8px;
            border-radius: 50%;
            margin-right: 12px !important;
        }

        /* Loading state para gráficos */
        .chart-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 200px;
            color: #6c757d;
        }

        .chart-loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    {{-- escolher todas as tarefas ou somente a do usuario --}}
    <script>
                // Modal de tarefas concluídas por usuário
                document.querySelectorAll('.badge-concluida').forEach(function(badge) {
                    badge.addEventListener('click', function() {
                        const userId = this.getAttribute('data-user-id');
                        const userNome = this.getAttribute('data-user-nome');
                        const userEmail = this.getAttribute('data-user-email');
                        const total = this.getAttribute('data-total');
                        // Aqui você pode buscar via AJAX as tarefas concluídas do usuário, ou exibir dados estáticos
                        // Exemplo de conteúdo dinâmico:
                        let html = `<div class='mb-3'><strong>Responsável:</strong> ${userNome} (${userEmail})</div>`;
                        html += `<div class='mb-3'><strong>Total concluídas:</strong> ${total}</div>`;
                        html += `<div class='alert alert-info'>Aqui você pode listar as tarefas concluídas desse usuário.</div>`;
                        document.getElementById('concluidaModalContent').innerHTML = html;
                        var modal = new bootstrap.Modal(document.getElementById('concluidaModal'));
                        modal.show();
                    });
                });
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('toggleTarefas');
            if (toggle) {
                toggle.addEventListener('change', function() {
                    const url = new URL(window.location.href);

                    if (this.checked) {
                        url.searchParams.set('all', '1');
                    } else {
                        url.searchParams.delete('all');
                    }

                    window.location.href = url.toString();
                });
            }
        });
    </script>



    {{-- atualiza a situação via ajax --}}
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
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Atualiza o botão visualmente
                                button.textContent = novaSituacao.charAt(0).toUpperCase() +
                                    novaSituacao.slice(1);

                                // Atualiza as classes do botão
                                button.classList.remove('btn-info', 'btn-danger', 'btn-warning',
                                    'btn-success');

                                switch (novaSituacao) {
                                    case 'em andamento':
                                        button.classList.add('btn-info');
                                        break;
                                    case 'atrasado':
                                        button.classList.add('btn-danger');
                                        break;
                                    case 'nao iniciada':
                                        button.classList.add('btn-warning');
                                        break;
                                    case 'concluida':
                                        button.classList.add('btn-success');
                                        break;
                                }

                                // Feedback visual
                                const toast = new coreui.Toast(document.getElementById(
                                    'liveToast'), {
                                    autohide: true,
                                    delay: 3000
                                });
                                document.querySelector('.toast-body').textContent =
                                    'Situação atualizada com sucesso!';
                                toast.show();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>

    {{-- mapa com os imovies --}}
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <!-- Leaflet MarkerCluster (para agrupar marcadores) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializa o mapa
            const map = L.map('imoveisMap').setView([-15.7889, -47.8792], 12);

            // Adiciona o tile layer do OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Cria um cluster de marcadores
            const markers = L.markerClusterGroup();
            const allMarkers = L.markerClusterGroup(); // Armazenará todos os marcadores

            // Dados dos imóveis
            const imoveis = @json($imoveis ?? []);

            // Adiciona marcadores para cada imóvel
            imoveis.forEach(imovel => {
                if (imovel.latitude && imovel.longitude) {
                    // Define ícone com base no tipo do imóvel
                    let icone;
                    switch (imovel.tipo) {
                        case 'casa':
                            icone = '<i class="fas fa-home" style="color:blue; font-size:18px;"></i>';
                            break;
                        case 'apartamento':
                            icone = '<i class="fas fa-building" style="color:green; font-size:18px;"></i>';
                            break;
                        case 'terreno':
                            icone = '<i class="fas fa-tree" style="color:orange; font-size:18px;"></i>';
                            break;
                        case 'comercial':
                            icone = '<i class="fas fa-store" style="color:red; font-size:18px;"></i>';
                            break;
                        case 'galpao':
                            icone =
                                '<i class="fas fa-warehouse" style="color:olive; font-size:18px;"></i>';
                            break;
                        default:
                            icone =
                                '<i class="fas fa-map-marker-alt" style="color:gray; font-size:18px;"></i>';
                    }

                    // Cria o marcador
                    const marker = L.marker([parseFloat(imovel.latitude), parseFloat(imovel.longitude)], {
                        icon: L.divIcon({
                            html: icone,
                            className: 'custom-icon',
                            iconSize: [24, 24]
                        }),
                        tipo: imovel.tipo // Armazena o tipo no marcador
                    }).bindPopup(`
                        <b>${imovel.tipo ? imovel.tipo.toUpperCase() : 'Imóvel'}</b><br>
                        ${imovel.endereco || ''} ${imovel.numero || ''}<br>
                        ${imovel.bairro ? 'Bairro: ' + imovel.bairro.nome + '<br>' : ''}
                        <a href="/imoveis/${imovel.id}" target="_blank">Ver detalhes</a>
                    `);

                    allMarkers.addLayer(marker); // Adiciona ao grupo de todos os marcadores
                }
            });

            // Adiciona todos os marcadores inicialmente
            markers.addLayers(allMarkers.getLayers());
            map.addLayer(markers);

            // Ajusta o zoom para mostrar todos os marcadores
            if (imoveis.length > 0) {
                map.fitBounds(markers.getBounds());
            }

            // Função para filtrar marcadores
            function filterMarkers(tipo) {
                markers.clearLayers();

                if (tipo === 'todos') {
                    markers.addLayers(allMarkers.getLayers());
                } else {
                    const filtered = allMarkers.getLayers().filter(marker => {
                        return marker.options.tipo === tipo;
                    });
                    markers.addLayers(filtered);
                }

                // Atualiza os contadores visíveis
                //updateVisibleCounters();
                function updateVisibleCounters() {
                    document.querySelectorAll('.filter-btn').forEach(btn => {
                        const tipo = btn.dataset.tipo;
                        const countElement = btn.querySelector('.count');

                        // Adiciona classe de animação
                        countElement.classList.add('count-update');

                        // Espera 10ms para garantir que a classe foi aplicada
                        setTimeout(() => {
                            // Atualiza os números (seu código original)
                            if (tipo === 'todos') {
                                const visibleCount = markers.getLayers().length;
                                countElement.textContent = `(${visibleCount})`;
                            } else {
                                const visibleCount = markers.getLayers().filter(marker =>
                                    marker.options.tipo === tipo
                                ).length;
                                countElement.textContent = `(${visibleCount})`;
                            }

                            // Remove a classe de animação após a atualização
                            countElement.classList.remove('count-update');
                        }, 10);
                    });
                }

                if (markers.getLayers().length > 0) {
                    map.fitBounds(markers.getBounds());
                }
            }

            // Eventos de clique na legenda
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const tipo = this.dataset.tipo;

                    // Ativa/desativa o botão
                    this.classList.toggle('active');

                    // Comportamento especial para o botão "Todos"
                    if (tipo === 'todos') {
                        const isActive = this.classList.contains('active');
                        document.querySelectorAll('.filter-btn').forEach(b => {
                            b.classList.toggle('active', isActive);
                        });
                        filterMarkers(isActive ? 'todos' : '');
                        return;
                    }

                    // Atualiza o estado do botão "Todos"
                    const otherActive = Array.from(document.querySelectorAll(
                            '.filter-btn:not([data-tipo="todos"])'))
                        .filter(b => b.classList.contains('active')).length > 0;

                    document.querySelector('.filter-btn[data-tipo="todos"]')
                        .classList.toggle('active', !otherActive);

                    // Aplica o filtro
                    if (!otherActive) {
                        markers.clearLayers();
                    } else {
                        const activeTypes = Array.from(document.querySelectorAll(
                                '.filter-btn.active:not([data-tipo="todos"])'))
                            .map(b => b.dataset.tipo);

                        if (activeTypes.length === 0) {
                            markers.clearLayers();
                        } else if (activeTypes.length === 1) {
                            filterMarkers(activeTypes[0]);
                        } else {
                            markers.clearLayers();
                            const filtered = allMarkers.getLayers().filter(marker => {
                                return activeTypes.includes(marker.options.tipo);
                            });
                            markers.addLayers(filtered);
                            map.fitBounds(markers.getBounds());
                        }
                    }
                });
            });

            function updateCounters() {
                const tipos = ['todos', 'casa', 'apartamento', 'terreno', 'comercial', 'galpao'];

                tipos.forEach(tipo => {
                    if (tipo === 'todos') {
                        const count = allMarkers.getLayers().length;
                        document.querySelector(`.filter-btn[data-tipo="${tipo}"] .count`).textContent =
                            `(${count})`;
                    } else {
                        const count = allMarkers.getLayers().filter(marker =>
                            marker.options.tipo === tipo
                        ).length;
                        document.querySelector(`.filter-btn[data-tipo="${tipo}"] .count`).textContent =
                            `(${count})`;
                    }
                });
            }

            // Chame esta função após carregar os marcadores
            updateCounters();
        });
    </script>
@endsection
