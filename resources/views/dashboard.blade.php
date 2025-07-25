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
                                Próximos Compromissos
                            </span>
                            <a href="{{ route('agenda.index') }}"
                                class="btn btn-outline-primary btn-sm ms-2 d-flex align-items-center">
                                <i class="fas fa-calendar-day me-1"></i> Agenda
                            </a>
                        </h5>
                        <ul class="list-group list-group-flush">
                            @forelse ($proximosCompromissos as $compromisso)
                                <li class="list-group-item compromisso-item" style="cursor:pointer;"
                                    data-titulo="{{ $compromisso->titulo ?? 'Compromisso' }}"
                                    data-data="{{ \Carbon\Carbon::parse($compromisso->data)->format('d/m/Y') }}"
                                    data-descricao="{{ $compromisso->descricao ?? '' }}"
                                    data-local="{{ $compromisso->local ?? '' }}">
                                    <div class="fw-bold"><i class="fas fa-calendar-check me-1 text-success"></i>
                                        {{ $compromisso->titulo ?? 'Compromisso' }}</div>
                                    <div class="text-muted small">
                                        {{ \Carbon\Carbon::parse($compromisso->data)->format('d/m/Y') }}</div>
                                </li>
                            @empty
                                <li class="list-group-item text-muted"><i class="fas fa-calendar-times me-1"></i> Nenhum
                                    compromisso futuro.</li>
                            @endforelse
                        </ul>
                        <!-- Modal de detalhes do compromisso -->
                        <div class="modal fade" id="compromissoModal" tabindex="-1" aria-labelledby="compromissoModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="compromissoModalLabel">Detalhes do Compromisso</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <strong>Título:</strong> <span id="modalCompromissoTitulo"></span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Data:</strong> <span id="modalCompromissoData"></span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Local:</strong> <span id="modalCompromissoLocal"></span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Descrição:</strong>
                                            <div id="modalCompromissoDescricao" class="border rounded p-2 bg-light"></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                            </div>
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
                        document.getElementById('modalCompromissoTitulo').textContent = this
                            .getAttribute('data-titulo');
                        document.getElementById('modalCompromissoData').textContent = this.getAttribute(
                            'data-data');
                        document.getElementById('modalCompromissoLocal').textContent = this
                            .getAttribute('data-local') || '-';
                        document.getElementById('modalCompromissoDescricao').textContent = this
                            .getAttribute('data-nota') || '-';
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

                    // Formata os labels para F/Y
                    let labels = todosMeses.map(function(mes) {
                        try {
                            return moment(mes, 'YYYY-MM').format('MMMM/YYYY');
                        } catch (e) {
                            return mes;
                        }
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

                    // Adiciona moment.js para formatação
                    if (typeof moment === 'undefined') {
                        var script = document.createElement('script');
                        script.src = 'https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js';
                        script.onload = renderChart;
                        document.head.appendChild(script);
                    } else {
                        renderChart();
                    }

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
                        <th class="bg-body-secondary text-center"><i class="fas fa-hourglass-start text-warning"></i> Não iniciada</th>
                        <th class="bg-body-secondary text-center"><i class="fas fa-spinner text-info"></i> Em andamento</th>
                        <th class="bg-body-secondary text-center"><i class="fas fa-exclamation-triangle text-danger"></i> Atrasada</th>
                        <th class="bg-body-secondary text-center"><i class="fas fa-check-circle text-success"></i> Concluída</th>
                        <th class="bg-body-secondary text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tarefasPorUsuario as $usuario)
                        <tr>
                            <td class="text-center">
                                <div class="avatar avatar-md">
                                    <img class="avatar-img" src="{{ ($usuario['avatar'] && strpos($usuario['avatar'], 'default.png') === false) ? $usuario['avatar'] : asset('img/user.png') }}" alt="{{ $usuario['nome'] }}">
                                </div>
                            </td>
                            <td class="fw-semibold">{{ $usuario['nome'] }}</td>
                            <td class="text-muted small">{{ $usuario['email'] }}</td>
                            <td class="text-center fw-bold">{{ $usuario['total'] }}</td>
                            <td class="text-center">
                                <span class="badge bg-warning text-dark">{{ $usuario['nao_iniciada'] ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark">{{ $usuario['em_andamento'] ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger">{{ $usuario['atrasada'] ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">{{ $usuario['concluida'] ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('controle_de_tarefas.index', ['user' => $usuario['id']]) }}" class="btn btn-outline-primary btn-sm" title="Ver tarefas do usuário">
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
    </style>
    {{-- escolher todas as tarefas ou somente a do usuario --}}
    <script>
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
