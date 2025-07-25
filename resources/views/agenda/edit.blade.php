@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-calendar-edit me-2"></i>Editar Agenda</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('agenda.update', $agenda) }}" method="POST" class="needs-validation"
                                novalidate>
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="tipo" class="form-label">Tipo <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select name="tipo_display" id="tipo" class="form-select" required
                                                disabled>
                                                <option value="">Selecione...</option>
                                                @foreach ($tipos as $key => $value)
                                                    <option value="{{ $key }}"
                                                        @if ($agenda->tipo == $key) selected @endif>
                                                        {{ $value['nome'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-secondary" id="btn-editar-tipo"
                                                title="Habilitar edição do tipo">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="tipo" id="tipo_hidden" value="{{ $agenda->tipo }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="data" class="form-label">Data</label>
                                        <input type="date" name="data" class="form-control" id="data"
                                            value="{{ $agenda->data }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="hora" class="form-label">Hora</label>
                                        <input type="time" name="hora" class="form-control" id="hora"
                                            value="{{ $agenda->hora }}">
                                    </div>
                                </div>
                                <!-- Campo de status oculto para garantir que sempre é enviado -->
                                <input type="hidden" name="status" id="status_hidden" value="{{ $agenda->status }}">
                                <div id="campos-vistoria" style="display:none;">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" id="status_simples" class="form-select">
                                                @foreach ($status as $key => $value)
                                                    <option value="{{ $key }}"
                                                        @if ($agenda->status == $key) selected @endif>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="num_processo" class="form-label">Nº Processo</label>
                                            <input type="text" name="num_processo" class="form-control" id="num_processo"
                                                value="{{ $agenda->num_processo }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="requerido" class="form-label">Requerido</label>
                                            <input type="text" name="requerido" class="form-control" id="requerido"
                                                value="{{ $agenda->requerido }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="requerente_nome" class="form-label">Requerente</label>
                                            <input type="text" class="form-control requerente-autocomplete"
                                                id="requerente_nome"
                                                value="{{ $agenda->requerente ? $agenda->requerente->nome : '' }}"
                                                placeholder="Digite para buscar cliente...">
                                            <input type="hidden" name="requerente_id" id="requerente_id"
                                                value="{{ $agenda->requerente_id }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="endereco" class="form-label">Endereço</label>
                                            <input type="text" name="endereco" class="form-control" id="endereco"
                                                value="{{ $agenda->endereco }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="num" class="form-label">Número</label>
                                            <input type="text" name="num" class="form-control" id="num"
                                                value="{{ $agenda->num }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="bairro" class="form-label">Bairro</label>
                                            <select name="bairro" id="bairro" class="form-select">
                                                <option value="">Selecione...</option>
                                                @foreach ($bairros as $bairro)
                                                    <option value="{{ $bairro->nome }}"
                                                        @if ($agenda->bairro == $bairro->nome) selected @endif>
                                                        {{ $bairro->nome }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="cidade" class="form-label">Cidade</label>
                                            <input type="text" name="cidade" class="form-control" id="cidade"
                                                value="{{ $agenda->cidade }}">
                                        </div>
                                        <div class="col-md-1">
                                            <label for="estado" class="form-label">UF</label>
                                            <input type="text" name="estado" class="form-control" id="estado"
                                                maxlength="2" value="{{ $agenda->estado }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="cep" class="form-label">CEP</label>
                                            <input type="text" name="cep" class="form-control" id="cep"
                                                value="{{ $agenda->cep }}">
                                        </div>
                                    </div>
                                </div>
                                <div id="campos-simples" style="display:none;">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="titulo" class="form-label">Título</label>
                                            <input type="text" name="titulo" class="form-control" id="titulo"
                                                value="{{ $agenda->titulo }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="local" class="form-label">Local</label>
                                            <input type="text" name="local" class="form-control" id="local"
                                                value="{{ $agenda->local }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="nota" class="form-label">Notas</label>
                                            <textarea name="nota" class="form-control" id="nota" rows="3">{{ $agenda->nota }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Salvar
                                        </button>
                                        <a href="{{ route('agenda.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times me-1"></i> Cancelar
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
        document.addEventListener('DOMContentLoaded', function() {
            // Função para habilitar/desabilitar edição do tipo
            document.getElementById('btn-editar-tipo').addEventListener('click', function() {
                var tipoSelect = document.getElementById('tipo');
                var tipoHidden = document.getElementById('tipo_hidden');
                var btnEditar = document.getElementById('btn-editar-tipo');

                if (tipoSelect.disabled) {
                    // Habilitar edição
                    tipoSelect.disabled = false;
                    tipoSelect.name = 'tipo'; // Mudar o name para que seja enviado
                    btnEditar.innerHTML = '<i class="fas fa-lock"></i>';
                    btnEditar.title = 'Bloquear edição do tipo';
                    btnEditar.classList.remove('btn-outline-secondary');
                    btnEditar.classList.add('btn-warning');
                } else {
                    // Desabilitar edição
                    tipoSelect.disabled = true;
                    tipoSelect.name = 'tipo_display'; // Voltar ao name original
                    tipoHidden.value = tipoSelect.value; // Atualizar o hidden
                    btnEditar.innerHTML = '<i class="fas fa-edit"></i>';
                    btnEditar.title = 'Habilitar edição do tipo';
                    btnEditar.classList.remove('btn-warning');
                    btnEditar.classList.add('btn-outline-secondary');
                }
            });

            function alternarCampos() {
                var tipo = document.getElementById('tipo').value;
                document.getElementById('campos-vistoria').style.display = (tipo === 'vistoria') ? '' : 'none';
                document.getElementById('campos-simples').style.display = (tipo !== 'vistoria' && tipo !== '') ?
                    '' : 'none';
            }
            document.getElementById('tipo').addEventListener('change', function() {
                alternarCampos();
                // Atualizar o campo hidden quando o tipo mudar (se estiver habilitado)
                if (!this.disabled) {
                    document.getElementById('tipo_hidden').value = this.value;
                }
            });

            // Atualizar o campo status_hidden quando o status visível mudar
            document.getElementById('status_simples').addEventListener('change', function() {
                document.getElementById('status_hidden').value = this.value;
            });

            alternarCampos();
            // Autocomplete para Requerente (igual create)
            $(".requerente-autocomplete").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('api.clientes.search') }}",
                        dataType: "json",
                        data: {
                            term: request.term,
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

            // Prevenir que o Enter submeta o formulário e fazer com que vá para o próximo campo
            $('form input, form select').on('keydown', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();

                    // Encontrar todos os campos focáveis
                    var inputs = $('form input:not([type=hidden]), form select, form textarea').filter(
                        ':visible:not([disabled])');
                    var idx = inputs.index(this);

                    // Se não for o último campo, vá para o próximo
                    if (idx < inputs.length - 1) {
                        inputs[idx + 1].focus();
                    }
                    // Se for o último campo, focar no botão de submissão
                    else {
                        $('form button[type=submit]').focus();
                    }

                    return false;
                }
            });
        });
    </script>
@endsection
