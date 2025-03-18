@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-tasks me-2"></i>Adicionar Nova Tarefa</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('controle_de_tarefas.store') }}" method="POST">
                                @csrf

                                <!-- Seção: Dados da Tarefa -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-file-alt me-2"></i>Dados da Tarefa</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="processo" class="form-label">Processo</label>
                                                <input type="text"
                                                    class="form-control @error('processo') is-invalid @enderror"
                                                    id="processo" name="processo" value="{{ old('processo') }}" required>
                                                @error('processo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="descricao_atividade" class="form-label">Descrição da Atividade</label>
                                                <textarea class="form-control @error('descricao_atividade') is-invalid @enderror"
                                                    id="descricao_atividade" name="descricao_atividade" rows="3" required>{{ old('descricao_atividade') }}</textarea>
                                                @error('descricao_atividade')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Status e Prioridade -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Status e Prioridade</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <input type="text"
                                                    class="form-control @error('status') is-invalid @enderror"
                                                    id="status" name="status" value="{{ old('status') }}" required>
                                                @error('status')
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
                                                    <option value="baixa" {{ old('prioridade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                                    <option value="media" {{ old('prioridade') == 'media' ? 'selected' : '' }}>Média</option>
                                                    <option value="alta" {{ old('prioridade') == 'alta' ? 'selected' : '' }}>Alta</option>
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
                                                        <option value="{{ $membro->id }}" {{ old('membro_id') == $membro->id ? 'selected' : '' }}>
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
                                    <h5 class="text-primary mb-3"><i class="fas fa-calendar-alt me-2"></i>Datas e Prazos</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="data_inicio" class="form-label">Data Início</label>
                                                <input type="date"
                                                    class="form-control @error('data_inicio') is-invalid @enderror"
                                                    id="data_inicio" name="data_inicio" value="{{ old('data_inicio') }}" required>
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
                                                    <option value="1 dia" {{ old('prazo') == '1 dia' ? 'selected' : '' }}>1 dia</option>
                                                    <option value="2 dias" {{ old('prazo') == '2 dias' ? 'selected' : '' }}>2 dias</option>
                                                    <option value="3 dias" {{ old('prazo') == '3 dias' ? 'selected' : '' }}>3 dias</option>
                                                    <option value="4 dias" {{ old('prazo') == '4 dias' ? 'selected' : '' }}>4 dias</option>
                                                    <option value="5 dias" {{ old('prazo') == '5 dias' ? 'selected' : '' }}>5 dias</option>
                                                    <option value="1 semana" {{ old('prazo') == '1 semana' ? 'selected' : '' }}>1 semana</option>
                                                    <option value="2 semanas" {{ old('prazo') == '2 semanas' ? 'selected' : '' }}>2 semanas</option>
                                                    <option value="3 semanas" {{ old('prazo') == '3 semanas' ? 'selected' : '' }}>3 semanas</option>
                                                    <option value="1 mês" {{ old('prazo') == '1 mês' ? 'selected' : '' }}>1 mês</option>
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
                                                    id="data_termino" name="data_termino" value="{{ old('data_termino') }}">
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
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="situacao" class="form-label">Situação</label>
                                                <select class="form-select" id="situacao" name="situacao">
                                                    <option value="">Todas</option>
                                                    @foreach ($getSituacaoValues as $situacao)
                                                        <option value="{{ $situacao }}" {{ request('situacao') == $situacao ? 'selected' : '' }}>
                                                            {{ $situacao }}
                                                        </option>
                                                    @endforeach
                                                </select>
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
@endsection