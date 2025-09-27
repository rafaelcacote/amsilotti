@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-gavel me-2"></i>Cadastrar Nova Perícia</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('controle-pericias.store') }}" method="POST"
                                class="row g-3 needs-validation" novalidate>
                                @csrf

                                <!-- Linha 1 - Processo, Requerente, Requerido -->
                                <div class="col-md-3 mb-3">
                                    <label for="numero_processo" class="form-label">Número do Processo <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('numero_processo') is-invalid @enderror"
                                        id="numero_processo" name="numero_processo" value="{{ old('numero_processo') }}"
                                        required>
                                    <div id="numero_processo-exists-feedback" class="invalid-feedback d-none">
                                        Este número de processo já existe!
                                    </div>
                                    @error('numero_processo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="requerente_id" class="form-label">Requerente <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control requerente-autocomplete @error('requerente_id') is-invalid @enderror"
                                        id="requerente_nome" placeholder="Digite para buscar requerente...">
                                    <input type="hidden" name="requerente_id" id="requerente_id"
                                        value="{{ old('requerente_id') }}">
                                    @error('requerente_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="requerido" class="form-label">Requerido <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('requerido') is-invalid @enderror"
                                        id="requerido" name="requerido" value="{{ old('requerido') }}" required>
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
                                                {{ old('vara') == $vara ? 'selected' : '' }}>
                                                {{ $vara }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vara')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2 mb-2">
                                    <label for="data_nomeacao" class="form-label">Data de Nomeação</label>
                                    <input type="date" class="form-control @error('data_nomeacao') is-invalid @enderror"
                                        id="data_nomeacao" name="data_nomeacao" value="{{ old('data_nomeacao') }}">
                                    @error('data_nomeacao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2 mb-2">
                                    <label for="data_vistoria" class="form-label">Data da Vistoria</label>
                                    <input type="date" class="form-control @error('data_vistoria') is-invalid @enderror"
                                        id="data_vistoria" name="data_vistoria" value="{{ old('data_vistoria') }}">
                                    @error('data_vistoria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2 mb-2">
                                    <label for="prazo_final" class="form-label">Laudo Entregue</label>
                                    <input type="date" class="form-control @error('prazo_final') is-invalid @enderror"
                                        id="prazo_final" name="prazo_final" value="{{ old('prazo_final') }}">
                                    @error('prazo_final')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                 <div class="col-md-2 mb-2">
                                    <label for="decurso_prazo" class="form-label">Decurso de Prazo</label>
                                    <input type="date" class="form-control @error('decurso_prazo') is-invalid @enderror"
                                        id="decurso_prazo" name="decurso_prazo" value="{{ old('decurso_prazo') }}">
                                    @error('decurso_prazo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="status_atual" class="form-label">Status Atual <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('status_atual') is-invalid @enderror"
                                        id="status_atual" name="status_atual" required>
                                        <option value="">Selecione</option>
                                        @foreach (App\Models\ControlePericia::statusOptions() as $statusOption)
                                            <option value="{{ $statusOption }}"
                                                {{ old('status_atual') == $statusOption ? 'selected' : '' }}>
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
                                                {{ old('responsavel_tecnico_id') == $responsavel->id ? 'selected' : '' }}>
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
                                        id="valor" name="valor" value="{{ old('valor') }}">
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
                                                    {{ old('protocolo') == 'sim' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="protocolo_sim">Sim</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="protocolo"
                                                    id="protocolo_nao" value="nao"
                                                    {{ old('protocolo') == 'nao' ? 'checked' : '' }}>
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
                                                        {{ old('protocolo_responsavel_id') == $responsavel->id ? 'selected' : '' }}>
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
                                </div> <!-- Linha 4 - Cadeia Dominial e Observações -->
                                <div class="col-md-3 mb-3">
                                    <label for="cadeia_dominial" class="form-label">Cadeia Dominial</label>
                                    <select class="form-select @error('cadeia_dominial') is-invalid @enderror"
                                        id="cadeia_dominial" name="cadeia_dominial">
                                        <option value="">Selecione</option>
                                        <option value="em andamento"
                                            {{ old('cadeia_dominial') == 'em andamento' ? 'selected' : '' }}>Em andamento
                                        </option>
                                        <option value="concluída"
                                            {{ old('cadeia_dominial') == 'concluída' ? 'selected' : '' }}>Concluída
                                        </option>
                                        <option value="não se aplica"
                                            {{ old('cadeia_dominial') == 'não se aplica' ? 'selected' : '' }}>Não se aplica
                                        </option>
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
                                                {{ old('tipo_pericia') == $tipopericiaOption ? 'selected' : '' }}>
                                                {{ $tipopericiaOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_atual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="observacoes" class="form-label">Observações</label>
                                    <textarea class="form-control @error('observacoes') is-invalid @enderror" id="observacoes" name="observacoes"
                                        rows="3">{{ old('observacoes') }}</textarea>
                                    @error('observacoes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Botões -->
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary me-md-2">
                                            <i class="fa-solid fa-floppy-disk me-1"></i> Salvar
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
        <!-- Modal Financeiro -->
            @include('components.modal-financeiro')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.11/jquery.autocomplete.min.js">
    </script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.11/jquery.autocomplete.css" />
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
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
        const form = $('form[action*="controle-pericias.store"]');
        const statusSelect = $('#status_atual');
        let shouldSubmitAfterFinanceiro = false;
        let modalFinanceiro = $('#modalFinanceiro');
        let formFinanceiro = $('#formFinanceiro');

        if (form.length && statusSelect.length && modalFinanceiro.length && formFinanceiro.length) {
            form.on('submit', function(e) {
                if (statusSelect.val().toLowerCase() === 'entregue' && !shouldSubmitAfterFinanceiro) {
                    e.preventDefault();
                    // Abrir modal financeiro
                    let bsModal = bootstrap.Modal.getOrCreateInstance(modalFinanceiro[0]);
                    bsModal.show();
                    // Exibir mensagem para o usuário (se função existir)
                    if (typeof showToast === 'function') {
                        showToast('info', 'Preencha os dados financeiros para salvar com status entregue.');
                    }
                }
            });

            // Handler único para submit do modal
            formFinanceiro.on('submit', function(ev) {
                ev.preventDefault();
                shouldSubmitAfterFinanceiro = true;
                let bsModal = bootstrap.Modal.getOrCreateInstance(modalFinanceiro[0]);
                bsModal.hide();
                form.submit();
            });

            // Handler para fechar o modal sem salvar
            modalFinanceiro.on('hidden.bs.modal', function() {
                if (!shouldSubmitAfterFinanceiro) {
                    if (typeof showToast === 'function') {
                        showToast('warning', 'Só é possível salvar com status entregue após preencher os dados financeiros.');
                    }
                }
                shouldSubmitAfterFinanceiro = false;
            });
        }
    });
</script>

@endsection

