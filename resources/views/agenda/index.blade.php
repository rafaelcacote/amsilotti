@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-calendar-alt me-2"></i>Agenda</h3>
                            <div class="ms-auto d-flex gap-2">
                                @can('view agenda tipos-evento')
                                <a href="{{ route('tipos-de-evento.index') }}" class="btn btn-info">
                                    <i class="fas fa-palette me-1"></i> Tipos de Evento
                                </a>
                                @endcan
                                @can('create agenda')
                                <a href="{{ route('agenda.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-1"></i> Novo Compromisso
                                </a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">

                            <ul class="nav nav-tabs mb-3" id="agendaTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="calendario-tab" data-bs-toggle="tab"
                                        data-bs-target="#calendario" type="button" role="tab"
                                        aria-controls="calendario" aria-selected="true">
                                        <i class="fas fa-calendar-alt me-1"></i> Calendário
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="lista-tab" data-bs-toggle="tab" data-bs-target="#lista"
                                        type="button" role="tab" aria-controls="lista" aria-selected="false">
                                        <i class="fas fa-list me-1"></i> Lista
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="agendaTabsContent">
                                <div class="tab-pane fade show active" id="calendario" role="tabpanel"
                                    aria-labelledby="calendario-tab">
                                    <div id="calendar" style="min-height: 700px;"></div>
                                </div>
                                <div class="tab-pane fade" id="lista" role="tabpanel" aria-labelledby="lista-tab">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-bordered table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Tipo</th>
                                                    <th>Data / Hora</th>
                                                    <th>Status</th>
                                                    <th style="width: 150px;" class="text-center">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($agendas as $agenda)
                                                    <tr>
                                                        <td>{{ $agenda->id }}</td>
                                                        <td>
                                                            <span class="badge"
                                                                style="background-color: {{ $agenda->tipo_cor }}; color: white;">
                                                                {{ $agenda->tipo_nome }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            @if ($agenda->data)
                                                                {{ \Carbon\Carbon::parse($agenda->data)->format('d/m/Y') }}
                                                                <!-- Formato com data e hora -->
                                                                @if ($agenda->hora)
                                                                    {{ ' - ' . \Carbon\Carbon::parse($agenda->hora)->format('H:i') }}
                                                                @endif
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge {{ $agenda->status === 'Realizada' ? 'bg-success' : ($agenda->status === 'Cancelada' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                                                {{ $agenda->status_nome }}
                                                            </span>
                                                        </td>
                                                        <!-- <td>
                                                                        <a href="{{ route('agenda.show', $agenda) }}"
                                                                            class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                                        <a href="{{ route('agenda.edit', $agenda) }}"
                                                                            class="btn btn-primary btn-sm"><i
                                                                                class="fas fa-edit"></i></a>
                                                                        <form id="form-excluir-{{ $agenda->id }}"
                                                                            action="{{ route('agenda.destroy', $agenda) }}"
                                                                            method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm btn-excluir-agenda"
                                                                                data-id="{{ $agenda->id }}"
                                                                                data-processo="{{ $agenda->num_processo ?? ($agenda->titulo ?? '-') }}">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td> -->

                                                        <td width="150px" class="text-center">
                                                            <x-action-buttons-agenda showRoute="agenda.show"
                                                                editRoute="agenda.edit" destroyRoute="agenda.destroy"
                                                                printRoute="agenda.imprimir"
                                                                :itemId="$agenda->id" title="Confirmar Exclusão"
                                                                message="Tem certeza que deseja excluir este compromisso?" />
                                                        </td>



                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">Nenhuma agenda encontrada.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="px-4 py-3">
                                        <div id="pagination-container">
                                            {{ $agendas->links('vendor.pagination.simple-coreui') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/locales-all.global.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/pt-br.min.js"></script>
    @include('agenda.modal_detalhes_evento')
    @include('agenda.modal_confirmar_exclusao')
    @include('components.toast_exclusao')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Função para gerenciar as abas e paginação
            function initTabManagement() {
                // Verifica se há um parâmetro de aba na URL
                const urlParams = new URLSearchParams(window.location.search);
                const activeTab = urlParams.get('tab');

                if (activeTab === 'lista') {
                    // Ativa a aba lista
                    document.getElementById('calendario-tab').classList.remove('active');
                    document.getElementById('lista-tab').classList.add('active');
                    document.getElementById('calendario').classList.remove('show', 'active');
                    document.getElementById('lista').classList.add('show', 'active');
                }

                // Adiciona evento de clique nos links de paginação
                function addPaginationListeners() {
                    const paginationLinks = document.querySelectorAll('#pagination-container a');
                    paginationLinks.forEach(link => {
                        link.addEventListener('click', function(e) {
                            // Verifica se a aba lista está ativa
                            const listaTab = document.getElementById('lista-tab');
                            if (listaTab && listaTab.classList.contains('active')) {
                                // Adiciona o parâmetro tab=lista na URL
                                const url = new URL(this.href);
                                url.searchParams.set('tab', 'lista');
                                this.href = url.toString();
                            }
                        });
                    });
                }

                // Adiciona listeners iniciais
                addPaginationListeners();

                // Adiciona evento aos botões das abas para limpar o parâmetro tab da URL
                document.getElementById('calendario-tab').addEventListener('click', function() {
                    // Remove o parâmetro tab da URL quando volta para o calendário
                    const url = new URL(window.location);
                    url.searchParams.delete('tab');
                    window.history.replaceState({}, '', url);
                });

                document.getElementById('lista-tab').addEventListener('click', function() {
                    // Adiciona o parâmetro tab=lista na URL quando vai para lista
                    const url = new URL(window.location);
                    url.searchParams.set('tab', 'lista');
                    window.history.replaceState({}, '', url);
                });

                // Observer para detectar mudanças no container de paginação (caso seja atualizado via AJAX)
                const paginationContainer = document.getElementById('pagination-container');
                if (paginationContainer) {
                    const observer = new MutationObserver(function(mutations) {
                        mutations.forEach(function(mutation) {
                            if (mutation.type === 'childList') {
                                addPaginationListeners();
                            }
                        });
                    });

                    observer.observe(paginationContainer, {
                        childList: true,
                        subtree: true
                    });
                }
            }

            // Inicializa o gerenciamento de abas
            initTabManagement();

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                locale: 'pt-br',
                buttonText: {
                    today: 'Hoje',
                    month: 'Mês',
                    week: 'Semana',
                    day: 'Dia',
                    list: 'Lista'
                },
                height: 700,
                events: {
                    url: '{{ route('agenda.eventos') }}',
                    method: 'GET',
                    failure: function() {
                        console.error('Erro ao carregar eventos');
                    }
                },
                dayMaxEvents: 4, // Limitar a quantidade de eventos visíveis por dia
                eventDisplay: 'block',
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false,
                    hour12: false
                },
                // Traduções adicionais
                dayHeaderFormat: {
                    weekday: 'short',
                    
                },
                allDayText: 'Dia inteiro',
                noEventsText: 'Não há eventos para exibir',
                moreLinkText: 'mais',
                // Formatação de título
                titleFormat: {
                    year: 'numeric',
                    month: 'long'
                },
                viewDidMount: function(view) {
                    // Ajusta o espaçamento das células de dia no mês
                    if (view.type === 'dayGridMonth') {
                        $('.fc-daygrid-day').css('height', '120px');
                    }
                },
                eventDidMount: function(info) {
                    // Adiciona informações ao evento para melhorar a exibição
                    var event = info.event;
                    var props = event.extendedProps;
                    var eventEl = info.el;

                    // Adiciona classe para tipo de evento
                    if (props.tipo) {
                        $(eventEl).addClass('event-tipo-' + props.tipo);
                    }

                    // Preparar o texto detalhado
                    var detailText = '';
                    if (props.num_processo) {
                        detailText = props.num_processo;
                    } else if (props.requerido) {
                        detailText = props.requerido;
                    } else if (props.local) {
                        detailText = props.local;
                    }

                    // Mostrar apenas o tipo completo do evento
                    var eventTitle = '<span class="fc-event-tipo">' + (props.tipo_nome || '') +
                        '</span>';

                    // Aplicar o título completo
                    $(eventEl).find('.fc-event-title').html(eventTitle);

                    // Adicionar atributos para tooltip completo
                    var plainTitle = props.tipo_nome || '';
                    // Adicionar detalhes apenas no tooltip
                    if (props.num_processo) {
                        plainTitle += ' - Proc: ' + props.num_processo;
                    } else if (props.requerido) {
                        plainTitle += ' - ' + props.requerido;
                    } else if (props.local) {
                        plainTitle += ' - ' + props.local;
                    }

                    $(eventEl).attr('data-full-title', plainTitle);
                    $(eventEl).attr('title', plainTitle);
                },
                eventClick: function(info) {
                    var agenda = info.event.extendedProps;
                    // Corrige: garantir que campos existam e mostrem corretamente
                    if (agenda.tipo === 'vistoria') {
                        $('#modalDetalhesEventoLabel').html(
                            '<i class="fas fa-calendar-check me-2"></i>Detalhes da Vistoria');
                        $('#detalhe-num-processo').text(agenda.num_processo || '-');
                        $('#detalhe-status').text(agenda.status || '-');
                        $('#detalhe-data').text(info.event.start ? moment(info.event.start).format(
                            'DD/MM/YYYY') : '-');
                        $('#detalhe-hora').text(info.event.start ? moment(info.event.start).format(
                            'HH:mm') : '-');
                        $('#detalhe-requerido').text(agenda.requerido || '-');
                        $('#detalhe-requerente').text(agenda.requerente_nome || '-');
                        $('#detalhe-endereco').text(agenda.endereco || '-');
                        $('#detalhe-numero').text(agenda.num || '-');
                        $('#detalhe-bairro').text(agenda.bairro || '-');
                        $('#detalhe-cidade').text(agenda.cidade || '-');
                        $('#detalhe-estado').text(agenda.estado || '-');
                        $('#detalhe-cep').text(agenda.cep || '-');
                        $('#detalhe-nota').text(agenda.nota || '-');
                        $('#detalhe-id').text(info.event.id);
                        $('#detalhe-status').removeClass().addClass('badge ms-2').addClass(agenda
                            .status === 'Realizada' ? 'bg-success' : (agenda.status ===
                                'Cancelada' ? 'bg-danger' : 'bg-warning text-dark'));
                        $('.modal-vistoria').show();
                        $('.modal-simples').hide();
                    } else {
                        $('#modalDetalhesEventoLabel').html(
                            '<i class="fas fa-calendar-check me-2"></i>Detalhes do Compromisso');
                        $('#detalhe-titulo').text(info.event.title || '-');
                        $('#detalhe-local').text(agenda.local || '-');
                        $('#detalhe-hora-simples').text(info.event.start ? moment(info.event.start)
                            .format(
                                'HH:mm') : '-');
                        $('#detalhe-nota').text(agenda.nota || '-');
                        $('#detalhe-tipo').text(agenda.tipo_nome || agenda.tipo || '-');
                        $('#detalhe-id').text(info.event.id);
                        $('.modal-vistoria').hide();
                        $('.modal-simples').show();
                    }
                    var modal = new bootstrap.Modal(document.getElementById('modalDetalhesEvento'));
                    modal.show();
                    info.jsEvent.preventDefault();
                },
                eventDisplay: 'block',
                nowIndicator: true,
                selectable: false,
                dayMaxEvents: true,
            });

            calendar.render();

            // Exclusão customizada
            $(document).on('click', '.btn-excluir-agenda', function(e) {
                e.preventDefault();
                var agendaId = $(this).data('id');
                var processo = $(this).data('processo') || '-';
                $('#processo-exclusao').text(processo);
                $('#btnConfirmarExclusao').data('id', agendaId);
                var modal = new bootstrap.Modal(document.getElementById('modalConfirmarExclusao'));
                modal.show();
            });

            $('#btnConfirmarExclusao').on('click', function() {
                var id = $(this).data('id');
                if (id) {
                    // Cria um formulário dinamicamente para enviar DELETE
                    var form = $('<form>', {
                        'method': 'POST',
                        'action': '{{ url('agenda') }}/' + id
                    });

                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': '_token',
                        'value': '{{ csrf_token() }}'
                    }));

                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': '_method',
                        'value': 'DELETE'
                    }));

                    $('body').append(form);
                    form.submit();
                }
            });

            // Ações do modal de detalhes
            $(document).on('click', '#btn-editar-evento', function() {
                var agendaId = $('#detalhe-id').text();
                if (agendaId) {
                    // Gera a URL base até 'agenda' sem o id
                    var baseUrl = "{{ url('agenda') }}";
                    window.location.href = baseUrl + '/' + agendaId + '/edit';
                }
            });

            $(document).on('click', '#btn-visualizar-evento', function() {
                var agendaId = $('#detalhe-id').text();
                if (agendaId) {
                    var baseUrl = "{{ url('agenda') }}";
                    window.location.href = baseUrl + '/' + agendaId;
                }
            });

            // Botão excluir evento do modal
            $(document).on('click', '#btn-excluir-evento', function() {
                var agendaId = $('#detalhe-id').text();
                if (agendaId) {
                    // Busca informações do evento para mostrar no modal de confirmação
                    var titulo = $('#detalhe-titulo').text() || $('#detalhe-num-processo').text() ||
                        'este evento';
                    $('#processo-exclusao').text(titulo);
                    $('#btnConfirmarExclusao').data('id', agendaId);

                    // Fecha o modal de detalhes e abre o modal de confirmação
                    var modalDetalhes = bootstrap.Modal.getInstance(document.getElementById(
                        'modalDetalhesEvento'));
                    modalDetalhes.hide();

                    setTimeout(function() {
                        var modalConfirmacao = new bootstrap.Modal(document.getElementById(
                            'modalConfirmarExclusao'));
                        modalConfirmacao.show();
                    }, 300);
                }
            });

            // Botão imprimir evento do modal
            $(document).on('click', '#btn-imprimir-evento', function() {
                var agendaId = $('#detalhe-id').text();
                if (agendaId) {
                    // Abre uma nova janela/aba para impressão
                    var printUrl = "{{ url('agenda') }}/" + agendaId + "/imprimir";
                    window.open(printUrl, '_blank');
                }
            }); // Adiciona tooltip e título completo nos eventos
            $(document).on('mouseenter', '.fc-event', function() {
                var fullTitle = $(this).attr('data-full-title') || '';
                if (fullTitle) {
                    $(this).attr('data-title', fullTitle);
                }
            });

            // Garante que a altura das células é consistente
            function adjustCalendarHeight() {
                var containerHeight = $('#calendar').height();
                var numWeeks = $('.fc-scrollgrid-sync-table tbody tr').length;
                var minRowHeight = Math.floor((containerHeight - 100) / numWeeks);

                $('.fc-daygrid-day-frame').css('min-height', minRowHeight + 'px');
            }

            // Ajusta o tamanho quando o calendário é renderizado
            calendar.on('viewDidMount', function() {
                setTimeout(adjustCalendarHeight, 100);
            });

            // Ajusta o tamanho quando a janela é redimensionada
            $(window).resize(function() {
                setTimeout(adjustCalendarHeight, 100);
            });

            // Tradução adicional após a renderização
            calendar.on('viewDidMount', function() {
                // Garante que qualquer texto "more" seja traduzido
                $('.fc-daygrid-more-link').each(function() {
                    var text = $(this).text();
                    if (text.indexOf('more') >= 0) {
                        $(this).text(text.replace('more', 'mais'));
                    }
                });

                // Ajusta outros elementos que possam permanecer em inglês
                $('.fc-list-empty').text('Não há eventos para exibir');
            });
        });

        @if (session('success') || old('_method') === 'DELETE')
            setTimeout(function() {
                var toastEl = document.getElementById('toastExclusao');
                if (toastEl) {
                    var toast = new bootstrap.Toast(toastEl);
                    toast.show();
                }
            }, 500);
        @endif
    </script>

    <style>
        #calendar {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            padding: 20px;
        }

        .fc-toolbar-title {
            font-size: 1.5rem;
            color: #0d6efd;
            font-weight: 600;
        }

        /* Ajustes para as células do calendário */
        .fc-daygrid-day-frame {
            min-height: 110px !important;
        }

        .fc-daygrid-day-top {
            padding: 3px !important;
        }

        .fc-daygrid-day-number {
            font-size: 0.9rem;
            font-weight: 500;
            padding: 3px !important;
        }

        /* Reduzir o padding do cabeçalho dos dias da semana */
        .fc-col-header-cell {
            padding: 6px 0 !important;
        }

        /* Ajuste no container de eventos para aproveitar espaço */
        .fc-daygrid-day-events {
            margin-top: 1px !important;
            padding: 0 2px !important;
        }

        /* Botões de "mais eventos" */
        .fc-daygrid-more-link {
            font-size: 0.7rem;
            margin-top: 1px;
            padding: 0px 3px;
            background-color: #f8f9fa;
            border-radius: 3px;
            color: #0d6efd !important;
            font-weight: 500;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .fc .fc-button-primary {
            background: #0d6efd;
            border: none;
            border-radius: 6px;
            font-weight: 500;
        }

        .fc .fc-button-primary:not(:disabled):active,
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background: #0b5ed7;
        }

        .fc .fc-daygrid-event {
            border-radius: 4px;
            font-size: 0.75rem;
            padding: 3px 6px;
            font-weight: 500;
            border: none !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
            margin-bottom: 1px;
            line-height: 1.2;
            max-height: 28px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Adiciona um indicador colorido à esquerda do evento */
        .fc .fc-daygrid-event::before {
            content: "";
            display: inline-block;
            width: 3px;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            background-color: rgba(255, 255, 255, 0.8);
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .fc .fc-event-title {
            font-weight: 600;
            color: white !important;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
            padding-left: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: center;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background: #e7f1ff;
        }

        .fc .fc-event {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .fc .fc-event:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
            z-index: 5;
        }


        .fc .fc-event:hover::after {
            content: attr(data-full-title);
            position: absolute;
            bottom: calc(100% + 5px);
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(33, 37, 41, 0.95);
            color: white;
            padding: 5px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            white-space: normal;
            max-width: 250px;
            width: max-content;
            z-index: 1000;
            pointer-events: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            line-height: 1.3;
            text-align: center;
        }


        .fc-event-tipo {
            font-weight: 700;
            display: block;
            width: 100%;
            text-align: center;
            padding: 1px 0;
        }

        /* Ajuste para calendário em telas menores */
        @media (max-width: 768px) {
            .fc .fc-daygrid-event {
                font-size: 0.65rem;
                padding: 1px 3px;
            }

            .fc-daygrid-day-frame {
                min-height: 80px !important;
            }

            .fc-daygrid-more-link {
                font-size: 0.65rem;
            }

            #calendar {
                padding: 10px;
            }
        }

        /* Legenda de cores responsiva */
        @media (max-width: 768px) {
            .d-flex.flex-wrap.gap-3 {
                flex-direction: column;
                gap: 0.5rem !important;
            }
        }

        /* Estilos específicos para cada tipo de evento */
        .event-tipo-vistoria::before {
            background-color: rgba(255, 255, 255, 0.8) !important;
        }

        .event-tipo-entrega_laudo::before {
            background-color: rgba(215, 247, 255, 0.9) !important;
        }

        .event-tipo-reuniao::before {
            background-color: rgba(255, 248, 214, 0.9) !important;
        }

        .event-tipo-visita_tecnica::before {
            background-color: rgba(255, 236, 214, 0.9) !important;
        }

        .event-tipo-compromisso_externo::before {
            background-color: rgba(237, 214, 255, 0.9) !important;
        }

        /* CSS adicional para traduzir textos fixos */
        .fc-more-popover .fc-popover-title {
            content: "Mais eventos";
        }

        /* Ajuste para o botão "mais" */
        .fc-daygrid-more-link::before {
            content: "mais ";
            display: inline;
        }

        /* Adiciona uma cor de fundo suave aos botões para destacar */
        .fc-button-primary {
            background-color: #0d6efd !important;
            border-color: #0a58ca !important;
            transition: all 0.2s ease;
        }

        .fc-button-primary:hover {
            background-color: #0b5ed7 !important;
            border-color: #0a53be !important;
            box-shadow: 0 0 0 0.25rem rgba(49, 132, 253, 0.25);
        }
    </style>
@endsection
