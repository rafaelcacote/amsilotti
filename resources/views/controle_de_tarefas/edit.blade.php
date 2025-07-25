@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-tasks me-2"></i>Editar Tarefa</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('controle_de_tarefas.update', $controleDeTarefas->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Seção: Dados da Tarefa -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-file-alt me-2"></i>Dados da Tarefa</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="processo" class="form-label">Processo</label>
                                                <input type="text"
                                                    class="form-control @error('processo') is-invalid @enderror"
                                                    id="processo" name="processo"
                                                    value="{{ old('processo', $controleDeTarefas->processo) }}" required>
                                                @error('processo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="descricao_atividade" class="form-label">Descrição da
                                                    Atividade</label>
                                                <textarea class="form-control @error('descricao_atividade') is-invalid @enderror" id="descricao_atividade"
                                                    name="descricao_atividade" rows="3" required>{{ old('descricao_atividade', $controleDeTarefas->descricao_atividade) }}</textarea>
                                                @error('descricao_atividade')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Status e Prioridade -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Tipo de Atividade e
                                        Prioridade
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Tipo de Atividade</label>
                                                <select class="form-select select2 @error('status') is-invalid @enderror"
                                                    id="tipo_atividade" name="tipo_atividade">
                                                    <option value="">Selecione...</option>
                                                    @foreach (App\Models\ControleDeTarefas::tipoatividadeOptions() as $option)
                                                        <option value="{{ $option }}"
                                                            {{ old('tipo_atividade', $controleDeTarefas->tipo_atividade) == $option ? 'selected' : '' }}>
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('tipo_atividade')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="cliente_id" class="form-label">Cliente</label>
                                                <input type="text"
                                                    class="form-control cliente-autocomplete @error('cliente_id') is-invalid @enderror"
                                                    id="cliente_nome" placeholder="Digite para buscar cliente..."
                                                    value="{{ $controleDeTarefas->cliente ? $controleDeTarefas->cliente->nome : '' }}">
                                                <input type="hidden" name="cliente_id" id="cliente_id"
                                                    value="{{ old('cliente_id', $controleDeTarefas->cliente_id) }}">
                                                @error('cliente_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="prioridade" class="form-label">Prioridade</label>
                                                <select class="form-select @error('prioridade') is-invalid @enderror"
                                                    id="prioridade" name="prioridade" required>
                                                    <option value="">Selecione</option>
                                                    <option value="baixa"
                                                        {{ old('prioridade', $controleDeTarefas->prioridade) == 'baixa' ? 'selected' : '' }}>
                                                        Baixa</option>
                                                    <option value="media"
                                                        {{ old('prioridade', $controleDeTarefas->prioridade) == 'media' ? 'selected' : '' }}>
                                                        Média</option>
                                                    <option value="alta"
                                                        {{ old('prioridade', $controleDeTarefas->prioridade) == 'alta' ? 'selected' : '' }}>
                                                        Alta</option>
                                                </select>
                                                @error('prioridade')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="membro_id" class="form-label">Membro</label>
                                                <select class="form-select @error('membro_id') is-invalid @enderror"
                                                    id="membro_id" name="membro_id" required>
                                                    <option value="">Selecione</option>
                                                    @foreach ($membros as $membro)
                                                        <option value="{{ $membro->id }}"
                                                            {{ old('membro_id', $controleDeTarefas->membro_id) == $membro->id ? 'selected' : '' }}>
                                                            {{ $membro->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('membro_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Datas e Prazos -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-calendar-alt me-2"></i>Datas e Prazos
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="data_inicio" class="form-label">Data Início</label>
                                                <input type="date"
                                                    class="form-control @error('data_inicio') is-invalid @enderror"
                                                    id="data_inicio" name="data_inicio"
                                                    value="{{ old('data_inicio', $controleDeTarefas->data_inicio) }}"
                                                    required>
                                                @error('data_inicio')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="prazo" class="form-label">Prazo</label>
                                                <select class="form-select @error('prazo') is-invalid @enderror"
                                                    id="prazo" name="prazo" required>
                                                    <option value="">Selecione</option>
                                                    <option value="1 dia"
                                                        {{ old('prazo', $controleDeTarefas->prazo) == '1 dia' ? 'selected' : '' }}>
                                                        1 dia</option>
                                                    <option value="2 dias"
                                                        {{ old('prazo', $controleDeTarefas->prazo) == '2 dias' ? 'selected' : '' }}>
                                                        2 dias</option>
                                                    <option value="3 dias"
                                                        {{ old('prazo', $controleDeTarefas->prazo) == '3 dias' ? 'selected' : '' }}>
                                                        3 dias</option>
                                                    <option value="4 dias"
                                                        {{ old('prazo', $controleDeTarefas->prazo) == '4 dias' ? 'selected' : '' }}>
                                                        4 dias</option>
                                                    <option value="5 dias"
                                                        {{ old('prazo', $controleDeTarefas->prazo) == '5 dias' ? 'selected' : '' }}>
                                                        5 dias</option>
                                                    <option value="1 semana"
                                                        {{ old('prazo', $controleDeTarefas->prazo) == '1 semana' ? 'selected' : '' }}>
                                                        1 semana</option>
                                                    <option value="2 semanas"
                                                        {{ old('prazo', $controleDeTarefas->prazo) == '2 semanas' ? 'selected' : '' }}>
                                                        2 semanas</option>
                                                    <option value="3 semanas"
                                                        {{ old('prazo', $controleDeTarefas->prazo) == '3 semanas' ? 'selected' : '' }}>
                                                        3 semanas</option>
                                                    <option value="1 mês"
                                                        {{ old('prazo', $controleDeTarefas->prazo) == '1 mês' ? 'selected' : '' }}>
                                                        1 mês</option>
                                                </select>
                                                @error('prazo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="data_termino" class="form-label">Data Término</label>
                                                <input type="date"
                                                    class="form-control @error('data_termino') is-invalid @enderror"
                                                    id="data_termino" name="data_termino"
                                                    value="{{ old('data_termino', $controleDeTarefas->data_termino) }}">
                                                @error('data_termino')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Situação -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-check-circle me-2"></i>Situação</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="situacao" class="form-label">Situação</label>
                                                <select class="form-select @error('situacao') is-invalid @enderror"
                                                    id="situacao" name="situacao">
                                                    <option value="">Selecione</option>
                                                    @foreach (App\Models\ControleDeTarefas::situacaoOptions() as $option)
                                                        <option value="{{ $option }}"
                                                            {{ old('situacao') == $option ? 'selected' : '' }}>
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('situacao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status" name="status">
                                                    <option value="">Selecione</option>
                                                    @foreach (App\Models\ControleDeTarefas::getStatusValues() as $option) 
                                                        <option value="{{ $option }}"
                                                            {{ old('status') == $option ? 'selected' : '' }}>
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botões de Ação -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Salvar
                                    </button>
                                    <a href="{{ route('controle_de_tarefas.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Cancelar
                                    </a>
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
            // Função para calcular a data de término
            function calcularDataTermino() {
                const dataInicio = $('#data_inicio').val();
                const prazo = $('#prazo').val();

                if (dataInicio && prazo) {
                    const dias = parsePrazoParaDias(prazo);
                    if (dias > 0) {
                        const data = new Date(dataInicio);
                        data.setDate(data.getDate() + dias);

                        // Formatar a data para YYYY-MM-DD (formato do input date)
                        const dataTermino = data.toISOString().split('T')[0];
                        $('#data_termino').val(dataTermino);
                    }
                }
            }

            // Função para converter o prazo em dias
            function parsePrazoParaDias(prazo) {
                if (!prazo) return 0;

                const partes = prazo.split(' ');
                const valor = parseInt(partes[0]);
                const unidade = partes[1];

                switch (unidade) {
                    case 'dia':
                    case 'dias':
                        return valor;
                    case 'semana':
                    case 'semanas':
                        return valor * 7;
                    case 'mês':
                        return valor * 30; // Aproximação
                    default:
                        return 0;
                }
            }

            // Event listeners
            $('#data_inicio, #prazo').change(function() {
                calcularDataTermino();
            });

            // Também calcular quando a página carrega (se já houver valores)
            calcularDataTermino();
        });
    </script>

    <script>
        $(document).ready(function() {
            // Configuração do autocomplete para o campo de cliente
            $(".cliente-autocomplete").autocomplete({
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
                                    console.log(item);
                                    return {
                                        label: item.nome + " - " + item.tipo,
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
                    // Quando um cliente é selecionado, atualiza o campo hidden com o ID do cliente
                    $("#cliente_id").val(ui.item.id);
                    return true;
                },
                change: function(event, ui) {
                    // Se o usuário limpar o campo ou não selecionar um item da lista
                    if (!ui.item) {
                        $(this).val("");
                        $("#cliente_id").val("");
                    }
                },
            });
        });
    </script>
@endsection
