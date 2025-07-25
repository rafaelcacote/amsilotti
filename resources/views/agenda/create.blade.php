@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-calendar-plus me-2"></i>Novo Compromisso</h3>
                        </div>
                        <div class="card-body">
                            {{-- @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}

                            <form action="{{ route('agenda.store') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="tipo" class="form-label">Tipo <span
                                                class="text-danger">*</span></label>
                                        <select name="tipo" id="tipo" class="form-select" required>
                                            <option value="">Selecione...</option>
                                            @foreach ($tipos as $key => $value)
                                                <option value="{{ $key }}" data-color="{{ $value['cor'] }}"
                                                    {{ old('tipo') == $key ? 'selected' : '' }}>
                                                    {{ $value['nome'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="data" class="form-label">Data <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="data"
                                            class="form-control @error('data') is-invalid @enderror" id="data"
                                            value="{{ old('data') }}">
                                        @error('data')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="hora" class="form-label">Hora <span
                                                class="text-danger hora-required" style="display:none;">*</span></label>
                                        <input type="time" name="hora"
                                            class="form-control @error('hora') is-invalid @enderror" id="hora"
                                            value="{{ old('hora') }}">
                                        @error('hora')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div id="campos-vistoria" style="display:none;">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="status" class="form-label">Status <span
                                                    class="text-danger vistoria-required"
                                                    style="display:none;">*</span></label>
                                            <select name="status" id="status_simples"
                                                class="form-select @error('status') is-invalid @enderror">
                                                @foreach ($status as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('status') == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="num_processo" class="form-label">Nº Processo <span
                                                    class="text-danger vistoria-required"
                                                    style="display:none;">*</span></label>
                                            <input type="text" name="num_processo"
                                                class="form-control @error('num_processo') is-invalid @enderror"
                                                id="num_processo" value="{{ old('num_processo') }}">
                                            @error('num_processo')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="requerente_nome" class="form-label">Requerente</label>
                                            <input type="text" class="form-control requerente-autocomplete"
                                                id="requerente_nome" placeholder="Digite para buscar cliente..."
                                                value="{{ old('requerente_nome') ?: $requerenteNome ?? '' }}">
                                            <input type="hidden" name="requerente_id" id="requerente_id"
                                                value="{{ old('requerente_id') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="requerido" class="form-label">Requerido</label>
                                            <input type="text" name="requerido" class="form-control" id="requerido"
                                                value="{{ old('requerido') }}">
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="endereco" class="form-label">Endereço <span
                                                    class="text-danger vistoria-required"
                                                    style="display:none;">*</span></label>
                                            <input type="text" name="endereco"
                                                class="form-control @error('endereco') is-invalid @enderror" id="endereco"
                                                value="{{ old('endereco') }}">
                                            @error('endereco')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-1">
                                            <label for="num" class="form-label">Número</label>
                                            <input type="text" name="num"
                                                class="form-control @error('num') is-invalid @enderror" id="num"
                                                value="{{ old('num') }}">
                                            @error('num')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="bairro" class="form-label">Bairro <span
                                                    class="text-danger vistoria-required"
                                                    style="display:none;">*</span></label>
                                            <select name="bairro" id="bairro"
                                                class="form-select @error('bairro') is-invalid @enderror"
                                                data-placeholder="Selecione o bairro...">
                                                <option value="">Selecione...</option>
                                                @foreach ($bairros as $bairro)
                                                    <option value="{{ $bairro->nome }}"
                                                        {{ old('bairro') == $bairro->nome ? 'selected' : '' }}>
                                                        {{ $bairro->nome }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('bairro')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="cidade" class="form-label">Cidade <span
                                                    class="text-danger vistoria-required"
                                                    style="display:none;">*</span></label>
                                            <input type="text" name="cidade"
                                                class="form-control @error('cidade') is-invalid @enderror" id="cidade"
                                                value="{{ old('cidade') }}">
                                            @error('cidade')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-1">
                                            <label for="estado" class="form-label">UF <span
                                                    class="text-danger vistoria-required"
                                                    style="display:none;">*</span></label>
                                            <input type="text" name="estado"
                                                class="form-control @error('estado') is-invalid @enderror" id="estado"
                                                maxlength="2" value="{{ old('estado') }}">
                                            @error('estado')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="cep" class="form-label">CEP</label>
                                            <input type="text" name="cep"
                                                class="form-control @error('cep') is-invalid @enderror" id="cep"
                                                value="{{ old('cep') }}">
                                            @error('cep')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div id="campos-simples" style="display:none;">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="titulo" class="form-label">Título <span
                                                    class="text-danger simples-required"
                                                    style="display:none;">*</span></label>
                                            <input type="text" name="titulo"
                                                class="form-control @error('titulo') is-invalid @enderror" id="titulo"
                                                value="{{ old('titulo') }}">
                                            @error('titulo')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="local" class="form-label">Local</label>
                                            <input type="text" name="local"
                                                class="form-control @error('local') is-invalid @enderror" id="local"
                                                value="{{ old('local') }}">
                                            @error('local')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="nota" class="form-label">Notas</label>
                                            <textarea name="nota" class="form-control @error('nota') is-invalid @enderror" id="nota" rows="3">{{ old('nota') }}</textarea>
                                            @error('nota')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
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

    <style>
        #requerente-suggestions {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        #requerente-suggestions .list-group-item {
            border-left: none;
            border-right: none;
        }

        #requerente-suggestions .list-group-item:hover {
            background-color: #f8f9fa;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Autocomplete para Requerente (igual cliente_id)
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
        });
    </script>


    <script>
        $(document).ready(function() {
            // Inicialização do Select2 para o campo bairro
            $('#bairro').select2({
                theme: "bootstrap-5",
                placeholder: "Selecione o bairro",
                closeOnSelect: true,
                width: '100%'
            });

            // Código existente para o campo tipo
            $('#tipo').select2({
                theme: "bootstrap-5",
                templateResult: formatOption,
                templateSelection: formatOption
            }).on('change', function() {
                // Chama a função alternarCampos quando o select2 mudar
                alternarCampos();
            });

            // Função para alternar a visibilidade dos campos baseado no tipo selecionado
            function alternarCampos() {
                var tipo = $('#tipo').val();

                // Esconder todos os campos primeiro
                $('#campos-vistoria').css('display', 'none');
                $('#campos-simples').css('display', 'none');

                // Esconder todos os asteriscos de obrigatório
                $('.vistoria-required, .simples-required, .hora-required').hide();

                if (tipo === 'vistoria') {
                    $('#campos-vistoria').css('display', 'block');
                    $('.vistoria-required').show(); // Mostrar asteriscos para campos de vistoria
                } else if (tipo !== '' && tipo !== 'vistoria') {
                    $('#campos-simples').css('display', 'block');
                    $('.simples-required, .hora-required').show(); // Mostrar asteriscos para campos simples
                }
            }

            // Executar na inicialização e quando há valores old()
            alternarCampos();

            // Se há valores old(), executar novamente após um pequeno delay para garantir que o select2 foi inicializado
            @if (old('tipo'))
                setTimeout(function() {
                    alternarCampos();
                }, 100);
            @endif

            function formatOption(state) {
                if (!state.id) return state.text;
                var color = $(state.element).data('color');
                return $(
                    '<span><span style="display:inline-block;width:12px;height:12px;background-color:' + color +
                    ';margin-right:6px;border-radius:2px;"></span>' + state.text + '</span>'
                );
            }

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
