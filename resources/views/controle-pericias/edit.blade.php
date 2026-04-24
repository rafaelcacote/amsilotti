@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-edit me-2"></i>Editar Perícia</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('controle-pericias.update', $controlePericia->id) }}" method="POST" enctype="multipart/form-data"
                                class="row g-3 needs-validation" novalidate>
                                @csrf
                                @method('PUT')

                                <!-- Linha 1 - Processo, Requerente, Requerido -->
                                <div class="col-md-3 mb-3">
                                    <label for="numero_processo" class="form-label">Número do Processo <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('numero_processo') is-invalid @enderror"
                                        id="numero_processo" name="numero_processo"
                                        value="{{ old('numero_processo', $controlePericia->numero_processo) }}" required readonly>
                                    @error('numero_processo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="requerente_id" class="form-label">Requerente <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control requerente-autocomplete @error('requerente_id') is-invalid @enderror"
                                        id="requerente_nome" placeholder="Digite para buscar requerente..."
                                        value="{{ old('requerente_nome', $controlePericia->requerente ? $controlePericia->requerente->nome : '') }}">
                                    <input type="hidden" name="requerente_id" id="requerente_id"
                                        value="{{ old('requerente_id', $controlePericia->requerente_id) }}">
                                    @error('requerente_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="requerido" class="form-label">Requerido <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('requerido') is-invalid @enderror"
                                        id="requerido" name="requerido"
                                        value="{{ old('requerido', $controlePericia->requerido) }}" required>
                                    @error('requerido')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Fim da linha 1 -->

                                <!-- Linha 2 - Vara, Datas e Status -->
                                <div class="col-md-3 mb-3">
                                    <label for="vara" class="form-label">Vara <span class="text-danger">*</span></label>
                                    <select class="form-select @error('vara') is-invalid @enderror" id="vara"
                                        name="vara" required>
                                        <option value="">Selecione a Vara</option>
                                        @foreach (App\Models\ControlePericia::varasOptions() as $vara)
                                            <option value="{{ $vara }}"
                                                {{ old('vara', $controlePericia->vara) == $vara ? 'selected' : '' }}>
                                                {{ $vara }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vara')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Linha 2 - Datas e Status -->
                                <div class="col-md-2 mb-2">
                                    <label for="data_nomeacao" class="form-label">Data de Nomeação</label>
                                    <input type="date" class="form-control @error('data_nomeacao') is-invalid @enderror"
                                        id="data_nomeacao" name="data_nomeacao"
                                        value="{{ old('data_nomeacao', $controlePericia->data_nomeacao ? $controlePericia->data_nomeacao->format('Y-m-d') : '') }}">
                                    @error('data_nomeacao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2 mb-2">
                                    <label for="data_vistoria" class="form-label">Data da Vistoria</label>
                                    <input type="date" class="form-control @error('data_vistoria') is-invalid @enderror"
                                        id="data_vistoria" name="data_vistoria"
                                        value="{{ old('data_vistoria', $controlePericia->data_vistoria ? $controlePericia->data_vistoria->format('Y-m-d') : '') }}">
                                    @error('data_vistoria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                <div class="col-md-2 mb-2">
                    <label for="prazo_final" class="form-label">Laudo Entregue</label>
                    <input type="date" class="form-control @error('prazo_final') is-invalid @enderror"
                        id="prazo_final" name="prazo_final"
                        value="{{ old('prazo_final', $controlePericia->prazo_final ? $controlePericia->prazo_final->format('Y-m-d') : '') }}">
                    @error('prazo_final')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-2 mb-2">
                    <label for="decurso_prazo" class="form-label">Decurso de Prazo</label>
                    <input type="date" class="form-control @error('decurso_prazo') is-invalid @enderror"
                        id="decurso_prazo" name="decurso_prazo"
                        value="{{ old('decurso_prazo', $controlePericia->decurso_prazo ? $controlePericia->decurso_prazo->format('Y-m-d') : '') }}">
                    @error('decurso_prazo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>                                <div class="col-md-3 mb-3">
                                    <label for="status_atual" class="form-label">Status Atual <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('status_atual') is-invalid @enderror"
                                        id="status_atual" name="status_atual" required>
                                        <option value="">Selecione</option>
                                        @foreach (App\Models\ControlePericia::statusOptions() as $statusOption)
                                            <option value="{{ $statusOption }}"
                                                {{ old('status_atual', $controlePericia->status_atual) == $statusOption ? 'selected' : '' }}>
                                                {{ $statusOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted mt-1" style="font-size: 0.92em;">
                                        <i class="fas fa-info-circle me-1"></i>
                                        O status <strong>Entregue</strong> só pode ser definido na listagem geral.
                                    </small>
                                    @error('status_atual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Linha 3 - Responsável, Valor, Protocolo -->
                                <div class="col-md-3 mb-3">
                                    <label for="responsavel_tecnico_id" class="form-label">Responsável Técnico</label>
                                    <select class="form-select @error('responsavel_tecnico_id') is-invalid @enderror"
                                        id="responsavel_tecnico_id" name="responsavel_tecnico_id">
                                        <option value="">Selecione</option>
                                        @foreach ($responsaveis as $responsavel)
                                            <option value="{{ $responsavel->id }}"
                                                {{ old('responsavel_tecnico_id', $controlePericia->responsavel_tecnico_id) == $responsavel->id ? 'selected' : '' }}>
                                                {{ $responsavel->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('responsavel_tecnico_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="valor" class="form-label">Valor (R$)</label>
                                    <input type="text" class="form-control money @error('valor') is-invalid @enderror"
                                        id="valor" name="valor"
                                        value="{{ old('valor', $controlePericia->valor ? number_format($controlePericia->valor, 2, ',', '.') : '') }}">
                                    @error('valor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-7 mb-3">
                                    <label class="form-label">Protocolo</label>
                                    <div class="d-flex align-items-center">
                                        <div class="me-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="protocolo"
                                                    id="protocolo_sim" value="sim"
                                                    {{ old('protocolo', $controlePericia->protocolo) == 'sim' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="protocolo_sim">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="protocolo"
                                                    id="protocolo_nao" value="nao"
                                                    {{ old('protocolo', $controlePericia->protocolo) == 'nao' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="protocolo_nao">Não</label>
                                            </div>
                                        </div>

                                        <div class="flex-grow-1" id="protocolo_responsavel_container"
                                            style="display: none;">
                                            <select
                                                class="form-select @error('protocolo_responsavel_id') is-invalid @enderror"
                                                id="protocolo_responsavel_id" name="protocolo_responsavel_id"
                                                aria-label="Responsável do Protocolo">
                                                <option value="">Selecione o Responsável do Protocolo</option>
                                                @foreach ($responsaveis as $responsavel)
                                                    <option value="{{ $responsavel->id }}"
                                                        {{ old('protocolo_responsavel_id', $controlePericia->protocolo_responsavel_id) == $responsavel->id ? 'selected' : '' }}>
                                                        {{ $responsavel->nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @error('protocolo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    @error('protocolo_responsavel_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Linha 4 - Cadeia Dominial e Observações -->
                                <div class="col-md-3 mb-3">
                                    <label for="cadeia_dominial" class="form-label">Cadeia Dominial</label>
                                    <select class="form-select @error('cadeia_dominial') is-invalid @enderror"
                                        id="cadeia_dominial" name="cadeia_dominial">
                                        <option value="">Selecione</option>
                                        <option value="em andamento"
                                            {{ old('cadeia_dominial', $controlePericia->cadeia_dominial) == 'em andamento' ? 'selected' : '' }}>
                                            Em andamento</option>
                                        <option value="concluída"
                                            {{ old('cadeia_dominial', $controlePericia->cadeia_dominial) == 'concluída' ? 'selected' : '' }}>
                                            Concluída</option>
                                        <option value="não se aplica"
                                            {{ old('cadeia_dominial', $controlePericia->cadeia_dominial) == 'não se aplica' ? 'selected' : '' }}>
                                            Não se aplica</option>
                                    </select>
                                    @error('cadeia_dominial')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="tipo_pericia" class="form-label">Tipo de Perícia <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('tipo_pericia') is-invalid @enderror"
                                        id="tipo_pericia" name="tipo_pericia" required>
                                        <option value="">Selecione</option>
                                        @foreach (App\Models\ControlePericia::tipopericiaOptions() as $tipopericiaOption)
                                            <option value="{{ $tipopericiaOption }}"
                                                {{ old('tipo_pericia', $controlePericia->tipo_pericia) == $tipopericiaOption ? 'selected' : '' }}>
                                                {{ $tipopericiaOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tipo_pericia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Linha 4 - Observações -->
                                <div class="col-md-12 mb-3">
                                    <label for="observacoes" class="form-label">Observações</label>
                                    <textarea class="form-control @error('observacoes') is-invalid @enderror" id="observacoes" name="observacoes"
                                        rows="3">{{ old('observacoes', $controlePericia->observacoes) }}</textarea>
                                    @error('observacoes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @php
                                    $documentosPorItem = $controlePericia->checklistDocumentos->keyBy('item_nome');
                                    $checklistTotal = count($checklistItems);
                                    $checklistConcluidos = $checklistItems
                                        ? collect($checklistItems)->filter(function ($item) use ($documentosPorItem) {
                                            $doc = $documentosPorItem->get($item);
                                            return $doc && ($doc->nao_necessario || !empty($doc->arquivo_caminho));
                                        })->count()
                                        : 0;
                                    $progresso = $checklistTotal > 0 ? round(($checklistConcluidos / $checklistTotal) * 100) : 0;
                                @endphp

                                <div class="col-md-12 mb-2">
                                    <div class="card border-0 shadow-sm bg-light">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="mb-0 text-primary">
                                                    <i class="fas fa-list-check me-2"></i>Checklist de Documentos
                                                </h5>
                                                <span class="badge bg-primary-subtle text-primary">
                                                    {{ $checklistConcluidos }}/{{ $checklistTotal }} itens com arquivo
                                                </span>
                                            </div>

                                            <div class="progress mb-3" style="height: 10px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progresso }}%;"
                                                    aria-valuenow="{{ $progresso }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                            @if (empty($checklistItems))
                                                <div class="alert alert-warning mb-0">
                                                    O tipo de perícia selecionado não possui checklist configurado.
                                                </div>
                                            @else
                                                <div class="row g-3">
                                                    @foreach ($checklistItems as $item)
                                                        @php
                                                            $itemKey = \Illuminate\Support\Str::slug($item, '_');
                                                            $documento = $documentosPorItem->get($item);
                                                            $isNaoNecessario = $documento && $documento->nao_necessario;
                                                        @endphp
                                                        <div class="col-md-6">
                                                            <div class="border rounded p-3 h-100 bg-white">
                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            {{ $documento ? 'checked' : '' }} disabled>
                                                                        <label class="form-check-label fw-semibold">
                                                                            {{ $item }}
                                                                        </label>
                                                                    </div>
                                                                    @if ($isNaoNecessario)
                                                                        <span class="badge bg-warning text-dark">Nao necessario</span>
                                                                    @elseif ($documento && $documento->arquivo_caminho)
                                                                        <span class="badge bg-success">Enviado</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">Pendente</span>
                                                                    @endif
                                                                </div>

                                                                @if ($documento && $documento->arquivo_caminho)
                                                                    <div class="small text-muted mb-2">
                                                                        Arquivo atual: <strong>{{ $documento->arquivo_nome }}</strong>
                                                                    </div>
                                                                    <div class="d-flex gap-2 mb-2">
                                                                        <a href="{{ route('controle-pericias.checklist.download', ['controlePericia' => $controlePericia->id, 'documento' => $documento->id]) }}"
                                                                            class="btn btn-sm btn-outline-primary">
                                                                            <i class="fas fa-download me-1"></i>Baixar
                                                                        </a>
                                                                        <form action="{{ route('controle-pericias.checklist.destroy', ['controlePericia' => $controlePericia->id, 'documento' => $documento->id]) }}"
                                                                            method="POST" onsubmit="return confirm('Remover este documento do checklist?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                                <i class="fas fa-trash me-1"></i>Remover
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                @endif

                                                                <div class="d-flex gap-2 align-items-center">
                                                                    <input class="form-control form-control-sm checklist-file-input"
                                                                        type="file"
                                                                        id="checklist_arquivo_{{ $itemKey }}"
                                                                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-primary checklist-save-btn"
                                                                        data-item-nome="{{ $item }}"
                                                                        data-item-key="{{ $itemKey }}"
                                                                        data-upload-url="{{ route('controle-pericias.checklist.upload', $controlePericia->id) }}">
                                                                        <i class="fas fa-upload me-1"></i>Salvar
                                                                    </button>
                                                                </div>
                                                                <div class="d-flex gap-2 mt-2">
                                                                    <form action="{{ route('controle-pericias.checklist.nao-necessario', $controlePericia->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="hidden" name="item_nome" value="{{ $item }}">
                                                                        <input type="hidden" name="acao" value="{{ $isNaoNecessario ? 'desmarcar' : 'marcar' }}">
                                                                        <button type="submit" class="btn btn-sm {{ $isNaoNecessario ? 'btn-outline-secondary' : 'btn-outline-warning' }}">
                                                                            <i class="fas {{ $isNaoNecessario ? 'fa-rotate-left' : 'fa-ban' }} me-1"></i>
                                                                            {{ $isNaoNecessario ? 'Reativar documento' : 'Marcar nao necessario' }}
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <small class="text-danger d-none mt-1 checklist-error"
                                                                    id="checklist_error_{{ $itemKey }}"></small>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <small class="text-muted d-block mt-2">
                                                    Uploads aceitos: PDF, imagem, Word e Excel (ate 15MB por arquivo).
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary me-md-2">
                                            <i class="fa-solid fa-floppy-disk me-1"></i> Atualizar
                                        </button>
                                        <a href="{{ route('controle-pericias.index') }}"
                                            class="btn btn-outline-secondary">
                                            <i class="fa-solid fa-arrow-left me-1"></i> Cancelar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Inicializa a máscara de moeda para o campo valor
            $('.money').mask('#.##0,00', {
                reverse: true
            });

            // Função para mostrar/esconder o campo de responsável do protocolo
            function toggleProtocoloResponsavel() {
                if ($('#protocolo_sim').is(':checked')) {
                    $('#protocolo_responsavel_container').show();
                } else {
                    $('#protocolo_responsavel_container').hide();
                }
            }

            // Inicializa o estado do campo de responsável do protocolo
            toggleProtocoloResponsavel();

            // Adiciona evento de mudança nos radio buttons
            $('input[name="protocolo"]').change(function() {
                toggleProtocoloResponsavel();
            });
        });
    </script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <script>
        $(document).ready(function() {
            // Autocomplete para o campo Requerente (modelo igual ao de tarefas)
            $(".requerente-autocomplete").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('autocomplete-clientes') }}",
                        dataType: "json",
                        data: {
                            q: request.term,
                        },
                        success: function(data) {
                            response(
                                $.map(data, function(item) {
                                    return {
                                        label: item.nome + (item.tipo ? ' - ' + item
                                            .tipo : ''),
                                        value: item.nome,
                                        id: item.id,
                                    };
                                })
                            );
                        },
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $("#requerente_id").val(ui.item.id);
                    return true;
                },
                change: function(event, ui) {
                    if (!ui.item) {
                        $(this).val("");
                        $("#requerente_id").val("");
                    }
                },
            });
        });
    </script>

    <script>
        $(function() {
            function showChecklistToast(message, type = 'success') {
                const toastId = 'toast_' + Date.now();
                const bgClass = type === 'success' ? 'text-bg-success' : 'text-bg-danger';
                const html = `
                    <div id="${toastId}" class="toast align-items-center ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">${message}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                `;

                let container = $('#checklistToastContainer');
                if (!container.length) {
                    $('body').append('<div id="checklistToastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;"></div>');
                    container = $('#checklistToastContainer');
                }

                container.append(html);
                const toastEl = document.getElementById(toastId);
                const toast = new bootstrap.Toast(toastEl, {
                    delay: 2800
                });
                toast.show();
                toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
            }

            $('.checklist-save-btn').on('click', function() {
                const btn = $(this);
                const itemNome = btn.data('item-nome');
                const itemKey = btn.data('item-key');
                const uploadUrl = btn.data('upload-url');
                const fileInput = $('#checklist_arquivo_' + itemKey);
                const errorEl = $('#checklist_error_' + itemKey);
                const file = fileInput[0].files[0];

                errorEl.addClass('d-none').text('');

                if (!file) {
                    errorEl.removeClass('d-none').text('Selecione um arquivo antes de salvar.');
                    return;
                }

                const formData = new FormData();
                formData.append('item_nome', itemNome);
                formData.append('arquivo', file);

                const originalHtml = btn.html();
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Salvando...');

                $.ajax({
                    url: uploadUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        showChecklistToast(response.message || 'Documento salvo com sucesso.', 'success');
                        window.location.reload();
                    },
                    error: function(xhr) {
                        let message = 'Não foi possível salvar o documento.';
                        if (xhr.responseJSON?.message) {
                            message = xhr.responseJSON.message;
                        } else if (xhr.responseJSON?.errors?.arquivo?.[0]) {
                            message = xhr.responseJSON.errors.arquivo[0];
                        }
                        errorEl.removeClass('d-none').text(message);
                        showChecklistToast(message, 'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });
        });
    </script>
@endsection
