@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-clipboard-check me-2"></i>Vistorias</h3>

                            @can ('imprimir vistoria')
                                <button type="button" id="btnImprimir"
                                    class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fas fa-print" style="font-size: 0.9rem;"></i>
                                    <span>Imprimir</span>
                                </button>
                            @endcan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body bg-light">
                            <!-- Filtro -->
                            <form action="{{ route('vistorias.index') }}" method="GET">
                                <div class="row align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label" for="num_processo">Processo</label>
                                        <input type="text" class="form-control" id="num_processo" name="num_processo"
                                            value="{{ request('num_processo') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="bairro">Bairro</label>
                                        <select class="form-control" id="bairro" name="bairro">
                                            <option value="">Todos</option>
                                            @foreach ($bairros as $bairro)
                                                <option value="{{ $bairro->nome }}"
                                                    {{ request('bairro') == $bairro->nome ? 'selected' : '' }}>
                                                    {{ $bairro->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="data_inicio">Data Início</label>
                                        <input type="date" class="form-control" id="data_inicio" name="data_inicio"
                                            value="{{ request('data_inicio') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="data_fim">Data Fim</label>
                                        <input type="date" class="form-control" id="data_fim" name="data_fim"
                                            value="{{ request('data_fim') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="status">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="">Todos</option>
                                            <option value="agendada" {{ request('status') == 'agendada' ? 'selected' : '' }}>
                                                Agendada</option>
                                            <option value="preenchido" {{ request('status') == 'preenchido' ? 'selected' : '' }}>
                                                Preenchido</option>
                                            <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>
                                                Cancelado</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end gap-2">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-search me-1"></i> Filtrar
                                        </button>
                                        <a href="{{ route('vistorias.index') }}" class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-eraser me-1"></i> Limpar
                                        </a>
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
                                            <th class="px-4 py-3 border-bottom-0">Processo</th>
                                            <th class="px-4 py-3 border-bottom-0">Requerido X Requerente</th>
                                            <th class="px-4 py-3 border-bottom-0">Data - Horario</th>
                                            <th class="px-4 py-3 border-bottom-0">Endereço</th>
                                            <th class="px-4 py-3 border-bottom-0">Bairro</th>
                                            <th class="px-4 py-3 border-bottom-0">Status</th>
                                            <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">
                                                Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($vistorias->count() > 0)
                                            @foreach ($vistorias as $vistoria)
                                                <tr class="border-bottom border-light">
                                                    <td class="px-4 fw-medium text-muted">
                                                        <strong>#{{ $vistoria->id }}</strong>
                                                    </td>
                                                    <td class="px-4">
                                                        <a href="https://consultasaj.tjam.jus.br/cpopg/search.do?cbPesquisa=NUMPROC&dadosConsulta.valorConsulta={{ $vistoria->num_processo }}"
                                                            target="_blank" class="d-inline-block text-truncate"
                                                            style="max-width: 200px;" data-coreui-toggle="tooltip"
                                                            data-coreui-placement="top"
                                                            title="{{ $vistoria->num_processo ?? '-' }}">
                                                            {{ $vistoria->num_processo }}
                                                        </a>
                                                    </td>
                                                    <td class="px-4">{{ $vistoria->requerente->nome ?? '-' }} X
                                                        {{ $vistoria->requerido ?? '-' }}</td>
                                                    <td class="px-4">
                                                        @if ($vistoria->agenda->data)
                                                            {{ \Carbon\Carbon::parse($vistoria->agenda->data)->format('d/m/Y') }}
                                                            @if ($vistoria->agenda->hora)
                                                                {{ ' - ' . \Carbon\Carbon::parse($vistoria->agenda->hora)->format('H:i') }}
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="px-4">
                                                        @php
                                                            $enderecoNumero = trim(
                                                                ($vistoria->endereco ?? '') .
                                                                    (isset($vistoria->num)
                                                                        ? ', nº ' . $vistoria->num
                                                                        : ''),
                                                            );
                                                        @endphp
                                                        {{ $enderecoNumero ?: '-' }}
                                                    </td>
                                                    <td class="px-4">{{ $vistoria->bairro ?? '-' }}</td>
                                                    <td class="px-4">
                                                        @php
                                                            $status = strtolower($vistoria->status);
                                                            $badgeClass = 'bg-secondary';
                                                            $icon = 'fa-clock';
                                                            $tooltip = 'Vistoria agendada, aguardando preenchimento.';
                                                            if ($status === 'agendado') {
                                                                $badgeClass = 'bg-primary';
                                                                $icon = 'fa-clock';
                                                                $tooltip =
                                                                    'Vistoria agendada, aguardando preenchimento.';
                                                            } elseif ($status === 'preenchido') {
                                                                $badgeClass = 'bg-success';
                                                                $icon = 'fa-check-circle';
                                                                $tooltip = 'Vistoria preenchida e salva.';
                                                            } elseif ($status === 'cancelado') {
                                                                $badgeClass = 'bg-danger';
                                                                $icon = 'fa-times-circle';
                                                                $tooltip = 'Vistoria cancelada.';
                                                            }
                                                        @endphp
                                                        <span
                                                            class="badge {{ $badgeClass }} d-inline-flex align-items-center gap-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ $tooltip }}">
                                                            <i class="fa-solid {{ $icon }}"></i>
                                                            {{ ucfirst($vistoria->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <!-- Botão Visualizar -->
                                                            @if (strtolower($vistoria->status) === 'agendada')
                                                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Só é possível visualizar após o preenchimento.">
                                                                    <button type="button"
                                                                        class="btn btn-light btn-show-vistoria"
                                                                        data-id="{{ $vistoria->id }}" title="Visualizar"
                                                                        disabled>
                                                                        <i class="fa-solid fa-magnifying-glass text-info"></i>
                                                                    </button>
                                                                </span>
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-light btn-show-vistoria"
                                                                    data-id="{{ $vistoria->id }}" title="Visualizar">
                                                                    <i class="fa-solid fa-magnifying-glass text-info"></i>
                                                                </button>
                                                            @endif
                                                            
                                                            <!-- Botão Imprimir Individual -->
                                                          @can ('imprimir vistoria')
                                                            @if (strtolower($vistoria->status) === 'agendada')
                                                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Só é possível imprimir após o preenchimento.">
                                                                    <button type="button"
                                                                        class="btn btn-light btn-print-vistoria"
                                                                        data-id="{{ $vistoria->id }}" title="Imprimir Vistoria"
                                                                        disabled>
                                                                        <i class="fa-solid fa-print text-success"></i>
                                                                    </button>
                                                                </span>
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-light btn-print-vistoria"
                                                                    data-id="{{ $vistoria->id }}" title="Imprimir Vistoria"
                                                                    data-bs-toggle="tooltip">
                                                                    <i class="fa-solid fa-print text-success"></i>
                                                                </button>
                                                            @endif
                                                          @endcan
                                                          @can('editar vistoria')
                                                            <button type="button" class="btn btn-light btn-edit-vistoria"
                                                                data-id="{{ $vistoria->id }}" title="Editar Vistoria">
                                                                <i class="fa-solid fa-clipboard-list text-warning"></i>
                                                            </button>
                                                          @endcan
                                                            
                                                            
                                                            <!-- Botão Excluir - só habilitado para status "agendada" -->

                                                            @can('excluir vistoria')
                                                                @if (strtolower($vistoria->status) === 'agendada')
                                                                    <button type="button"
                                                                        class="btn btn-light btn-delete-vistoria"
                                                                        data-id="{{ $vistoria->id }}"
                                                                        data-nome="{{ $vistoria->num_processo }}"
                                                                        data-status="{{ $vistoria->status }}"
                                                                        data-bs-toggle="tooltip" title="Excluir">
                                                                        <i class="fa-solid fa-trash-can text-danger"></i>
                                                                    </button>
                                                                @else
                                                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="Só é possível excluir vistorias com status 'Agendada'.">
                                                                        <button type="button"
                                                                            class="btn btn-light"
                                                                            disabled>
                                                                            <i class="fa-solid fa-trash-can text-muted"></i>
                                                                        </button>
                                                                    </span>
                                                                @endif
                                                            @endcan
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <p class="mb-0 text-muted">Nenhuma vistoria encontrada.</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="px-4 py-3">
                                {{ $vistorias->appends(request()->query())->links('vendor.pagination.simple-coreui') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Exclusão
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle fs-4 me-3"></i>
                        <div>
                            <strong>Atenção!</strong> Esta ação não pode ser desfeita.
                        </div>
                    </div>
                    
                    <!-- Alerta para status não permitido -->
                    <div class="alert alert-danger d-none" id="status-nao-permitido" role="alert">
                        <i class="fas fa-ban fs-4 me-3"></i>
                        <div>
                            <strong>Exclusão não permitida!</strong> Só é possível excluir vistorias com status <strong>"Agendada"</strong>.
                        </div>
                    </div>
                    
                    <p class="mb-3">Você está prestes a excluir a vistoria do processo: <strong id="processo-numero"></strong></p>
                    <p class="mb-3">Status atual: <span id="status-atual" class="badge"></span></p>
                    
                    <div class="row" id="detalhes-exclusao">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-users me-2"></i>Membros da Equipe Técnica
                                    </h6>
                                    <div id="membros-lista">
                                        <div class="text-muted">Carregando...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-info">
                                        <i class="fas fa-images me-2"></i>Fotos da Vistoria
                                    </h6>
                                    <div id="fotos-info">
                                        <div class="text-muted">Carregando...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="aviso-exclusao">
                        <p class="mt-3 mb-0 text-danger">
                            <i class="fas fa-trash me-2"></i>
                            <strong>Ao confirmar, serão excluídos:</strong>
                        </p>
                        <ul class="text-danger mb-0">
                            <li>A vistoria e todos os seus dados</li>
                            <li>As vinculações com os membros da equipe técnica</li>
                            <li>Todas as fotos associadas à vistoria</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="fas fa-trash me-1"></i>Confirmar Exclusão
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast de confirmação de exclusão -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
        <div id="toastExclusao" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>Vistoria excluída com sucesso!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let vistoriaIdToDelete = null;

            // Inicializar tooltips do Bootstrap 5
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Handle btn-edit-vistoria click to redirect to edit route
            $(document).on('click', '.btn-edit-vistoria', function(e) {
                e.preventDefault();
                const vistoriaId = $(this).data('id');

                // Redirect to vistorias.edit route with the vistoria ID
                window.location.href = "{{ route('vistorias.index') }}" + "/" + vistoriaId + "/edit";
            });

            // Handle print button click (impressão geral - pdf.blade.php)
            $('#btnImprimir').on('click', function(e) {
                e.preventDefault();

                // Get current filter parameters
                const params = new URLSearchParams(window.location.search);

                // Build print URL for pdf.blade.php (lista de vistorias) with current filters
                let printUrl = "{{ route('vistorias.imprimir') }}";
                if (params.toString()) {
                    printUrl += '?' + params.toString();
                }

                // Open PDF in new window
                window.open(printUrl, '_blank');
            });

            $(document).on('click', '.btn-show-vistoria', function(e) {
                e.preventDefault();
                const vistoriaId = $(this).data('id');
                window.location.href = "{{ url('vistorias') }}/" + vistoriaId;
            });

            // Handle print individual vistoria (impressao_unica.blade.php)
            $(document).on('click', '.btn-print-vistoria', function(e) {
                e.preventDefault();
                if ($(this).is(':disabled')) return;
                const vistoriaId = $(this).data('id');
                // Abre a rota que gera o PDF individual usando impressao_unica.blade.php
                const printUrl = "{{ url('vistorias') }}/" + vistoriaId + "/imprimir";
                window.open(printUrl, '_blank');
            });

            // Handle delete button click
            $(document).on('click', '.btn-delete-vistoria', function(e) {
                e.preventDefault();
                const vistoriaId = $(this).data('id');
                const numeroProcesso = $(this).data('nome');
                
                vistoriaIdToDelete = vistoriaId;
                
                // Atualizar o número do processo no modal
                $('#processo-numero').text(numeroProcesso || 'N/A');
                
                // Resetar o modal
                $('#status-nao-permitido').addClass('d-none');
                $('#detalhes-exclusao').show();
                $('#aviso-exclusao').show();
                $('#confirmDelete').show();
                
                // Mostrar loading
                $('#membros-lista').html('<div class="text-muted"><i class="fas fa-spinner fa-spin me-2"></i>Carregando...</div>');
                $('#fotos-info').html('<div class="text-muted"><i class="fas fa-spinner fa-spin me-2"></i>Carregando...</div>');
                
                // Abrir o modal
                const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                modal.show();
                
                // Buscar informações da vistoria
                $.ajax({
                    url: "{{ url('vistorias') }}/" + vistoriaId + "/delete-info",
                    method: 'GET',
                    success: function(response) {
                        // Atualizar status
                        const statusBadge = $('#status-atual');
                        statusBadge.text(response.status);
                        
                        // Definir classe do badge baseado no status
                        statusBadge.removeClass('bg-primary bg-success bg-danger bg-secondary');
                        if (response.status.toLowerCase() === 'agendada') {
                            statusBadge.addClass('bg-primary');
                        } else if (response.status.toLowerCase() === 'preenchido') {
                            statusBadge.addClass('bg-success');
                        } else if (response.status.toLowerCase() === 'cancelado') {
                            statusBadge.addClass('bg-danger');
                        } else {
                            statusBadge.addClass('bg-secondary');
                        }
                        
                        // Verificar se pode excluir
                        if (!response.pode_excluir) {
                            $('#status-nao-permitido').removeClass('d-none');
                            $('#detalhes-exclusao').hide();
                            $('#aviso-exclusao').hide();
                            $('#confirmDelete').hide();
                            return;
                        }
                        
                        // Atualizar lista de membros
                        if (response.membros && response.membros.length > 0) {
                            let membrosHtml = '<ul class="list-unstyled mb-0">';
                            response.membros.forEach(function(membro) {
                                membrosHtml += '<li class="mb-1"><i class="fas fa-user me-2"></i>' + membro + '</li>';
                            });
                            membrosHtml += '</ul>';
                            $('#membros-lista').html(membrosHtml);
                        } else {
                            $('#membros-lista').html('<div class="text-muted"><i class="fas fa-info-circle me-2"></i>Nenhum membro vinculado</div>');
                        }
                        
                        // Atualizar informações das fotos
                        if (response.total_fotos > 0) {
                            $('#fotos-info').html(
                                '<div class="d-flex align-items-center">' +
                                '<i class="fas fa-camera text-info me-2 fs-5"></i>' +
                                '<span class="fw-bold">' + response.total_fotos + ' foto(s)</span>' +
                                '</div>'
                            );
                        } else {
                            $('#fotos-info').html('<div class="text-muted"><i class="fas fa-info-circle me-2"></i>Nenhuma foto vinculada</div>');
                        }
                    },
                    error: function() {
                        $('#membros-lista').html('<div class="text-danger"><i class="fas fa-exclamation-circle me-2"></i>Erro ao carregar membros</div>');
                        $('#fotos-info').html('<div class="text-danger"><i class="fas fa-exclamation-circle me-2"></i>Erro ao carregar informações das fotos</div>');
                        
                        // Em caso de erro, assumir que não pode excluir
                        $('#status-nao-permitido').removeClass('d-none');
                        $('#detalhes-exclusao').hide();
                        $('#aviso-exclusao').hide();
                        $('#confirmDelete').hide();
                    }
                });
            });

            // Handle confirm delete
            $('#confirmDelete').on('click', function() {
                if (!vistoriaIdToDelete) return;
                // Mostrar loading no botão
                const $btn = $(this);
                const originalText = $btn.html();
                $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Excluindo...').prop('disabled', true);
                // Fazer requisição AJAX para excluir (POST + _method DELETE)
                $.ajax({
                    url: "{{ url('vistorias') }}/" + vistoriaIdToDelete,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        $('#confirmDeleteModal').modal('hide');
                        // Mostrar toast de sucesso
                        const toastEl = document.getElementById('toastExclusao');
                        const toast = new bootstrap.Toast(toastEl);
                        toast.show();
                        // Atualizar a lista de vistorias após exclusão
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr) {
                        $btn.html(originalText).prop('disabled', false);
                        let errorMessage = 'Erro ao excluir vistoria.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        const alertHtml = '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">' +
                            '<i class="fas fa-exclamation-circle me-2"></i>' + errorMessage +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                            '</div>';
                        $('.modal-body .alert-danger').remove();
                        $('.modal-body').append(alertHtml);
                    }
                });
            });
        });
    </script>
@endsection
