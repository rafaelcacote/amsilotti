@extends('layouts.app')

@php
    $openChecklistAba = request()->boolean('open_checklist');
@endphp

@section('content')
    <style>
        .checklist-file-selected {
            background-color: #fff9db;
            border-color: #ffe08a;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.18);
        }

        .checklist-upload-selected {
            background-color: #fff9db;
            border: 1px solid #ffe08a;
            border-radius: 0.5rem;
            padding: 0.35rem;
        }

        .checklist-observacoes-btn {
            position: relative;
        }

        .checklist-observacoes-indicator {
            position: absolute;
            top: -3px;
            right: -3px;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background-color: #dc3545;
            border: 1px solid #fff;
        }
    </style>

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

                                <div class="col-12">
                                    <div class="border rounded p-3 bg-light">
                                        <div class="row g-2 align-items-center">
                                            <div class="col-lg-4">
                                                <small class="text-muted d-block">Processo</small>
                                                <strong>{{ $controlePericia->numero_processo }}</strong>
                                            </div>
                                            <div class="col-lg-4">
                                                <small class="text-muted d-block">Tipo de Perícia</small>
                                                <strong>{{ $controlePericia->tipo_pericia ?: 'Não informado' }}</strong>
                                            </div>
                                            <div class="col-lg-4">
                                                <small class="text-muted d-block">Fase da Perícia</small>
                                                <strong>{{ $controlePericia->status_atual ?: 'Não informado' }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <ul class="nav nav-tabs" id="editPericiaTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link {{ $openChecklistAba ? '' : 'active' }}" id="dados-pericia-tab" data-bs-toggle="tab"
                                                data-bs-target="#dados-pericia-pane" type="button" role="tab"
                                                aria-controls="dados-pericia-pane" aria-selected="{{ $openChecklistAba ? 'false' : 'true' }}">
                                                Dados da Perícia
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link {{ $openChecklistAba ? 'active' : '' }}" id="checklist-tab" data-bs-toggle="tab"
                                                data-bs-target="#checklist-pane" type="button" role="tab"
                                                aria-controls="checklist-pane" aria-selected="{{ $openChecklistAba ? 'true' : 'false' }}">
                                                Checklist de Documentos
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-12">
                                    <div class="tab-content border border-top-0 rounded-bottom p-3 bg-white"
                                        id="editPericiaTabsContent">
                                        <div class="tab-pane fade {{ $openChecklistAba ? '' : 'show active' }}" id="dados-pericia-pane" role="tabpanel"
                                            aria-labelledby="dados-pericia-tab">
                                            <div class="row g-3">
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

                                <!-- Linha 2 - Vara, Datas e fase da perícia -->
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

                                <!-- Linha 2 - Datas e fase da perícia -->
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
                                    <label for="status_atual" class="form-label">Fase da Perícia <span
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
                                        A fase <strong>Entregue</strong> só pode ser definida na listagem geral.
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

                                <div class="col-md-4 mb-3">
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

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Protocolo</label>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
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

                                <!-- Observações -->
                                <div class="col-md-12 mb-3">
                                    <label for="observacoes" class="form-label">Observações</label>
                                    <textarea class="form-control @error('observacoes') is-invalid @enderror" id="observacoes" name="observacoes"
                                        rows="3">{{ old('observacoes', $controlePericia->observacoes) }}</textarea>
                                    @error('observacoes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade {{ $openChecklistAba ? 'show active' : '' }}" id="checklist-pane" role="tabpanel"
                                            aria-labelledby="checklist-tab">
                                @php
                                    $documentosPorItem = $controlePericia->checklistDocumentos->groupBy('item_nome');
                                    $checklistItemConcluido = function (string $item) use ($documentosPorItem) {
                                        $docs = $documentosPorItem->get($item, collect());
                                        if ($docs->isEmpty()) {
                                            return false;
                                        }
                                        if ($docs->contains(fn ($d) => (bool) ($d->nao_necessario ?? false))) {
                                            return true;
                                        }

                                        return $docs->contains(fn ($d) => ! empty($d->arquivo_caminho));
                                    };
                                    $checklistTotal = count($checklistItems);
                                    $checklistConcluidos = $checklistItems
                                        ? collect($checklistItems)->filter(fn ($item) => $checklistItemConcluido($item))->count()
                                        : 0;
                                    $progresso = $checklistTotal > 0 ? round(($checklistConcluidos / $checklistTotal) * 100) : 0;

                                    $fasesChecklist = [
                                        'Aceite Pericial' => [
                                            'Aceite Pericial',
                                            'Proposta de Honorários',
                                            'Marcação de Vistoria',
                                            'Contato com as Partes',
                                            'Reunião com as Partes',
                                            'Reunião com o Solicitante',
                                        ],
                                        'Vistoria Pericial' => [
                                            'Roteiro Pericial',
                                            'Diligência Pericial',
                                            'Relatório Fotográfico',
                                            'Formulário de Vistoria',
                                            'Coleta de Documentos',
                                            'Solicitação Cartório',
                                            'Solicitação IMPLURB',
                                            'Solicitação SECT',
                                            'Solicitação Externa',
                                            'Solicitação Juiz',
                                            'Solicitação de Sobrevoo de Drone',
                                            'Sobrevoo de Drone',
                                        ],
                                        'Análise Laboratorial' => [
                                            'Planta Georreferenciada',
                                            'Memorial Descritivo',
                                            'Cadeia Dominial',
                                            'Título Definitivo',
                                            'Parecer Técnico',
                                            'Documentos dos Confrontantes',
                                            'Mapa de Localização',
                                            'Localização do Imóvel',
                                            'Laudo Pericial',
                                            'Laudo de Avaliação',
                                            'Pesquisa de Mercado',
                                            'Planta de Arquitetura',
                                            'Projeto Executivo',
                                            'Projetos Complementares',
                                        ],
                                        'Fase Final' => [
                                            'Resposta aos Quesitos',
                                            'Elaboração de Quesitos',
                                            'Emissão RRT',
                                            'Protocolo do Laudo',
                                            'Protocolo do Laudo Pericial',
                                            'Expedição de Alvará',
                                            'Expedição do Alvará de Pagamento dos Honorários',
                                            'Nota de Empenho',
                                            'Solicitação da Nota Fiscal',
                                            'Envio da Nota Fiscal',
                                            'Esclarecimento',
                                            'Manifestação',
                                        ],
                                    ];

                                    $itensRestantes = collect($checklistItems);
                                    $checklistAgrupadoPorFase = [];

                                    foreach ($fasesChecklist as $faseNome => $faseItens) {
                                        $itensDaFase = collect($faseItens)->filter(fn($item) => in_array($item, $checklistItems, true))->values();
                                        if ($itensDaFase->isNotEmpty()) {
                                            $checklistAgrupadoPorFase[$faseNome] = $itensDaFase;
                                            $itensRestantes = $itensRestantes->reject(fn($item) => $itensDaFase->contains($item))->values();
                                        }
                                    }

                                    if ($itensRestantes->isNotEmpty()) {
                                        $checklistAgrupadoPorFase['Outros Itens'] = $itensRestantes->values();
                                    }
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
                                                <div class="accordion" id="checklistFasesAccordion">
                                                    @foreach ($checklistAgrupadoPorFase as $faseNome => $faseItens)
                                                        @php
                                                            $faseKey = \Illuminate\Support\Str::slug($faseNome, '_');
                                                            $totalFase = $faseItens->count();
                                                            $concluidosFase = $faseItens->filter(fn ($item) => $checklistItemConcluido($item))->count();
                                                            $progressoFase = $totalFase > 0 ? round(($concluidosFase / $totalFase) * 100) : 0;
                                                        @endphp

                                                        <div class="accordion-item mb-2 border rounded">
                                                            <h2 class="accordion-header" id="heading_{{ $faseKey }}">
                                                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapse_{{ $faseKey }}"
                                                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse_{{ $faseKey }}">
                                                                    <div class="w-100 pe-3">
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <strong>{{ $faseNome }}</strong>
                                                                            <span class="badge bg-primary-subtle text-primary">{{ $concluidosFase }}/{{ $totalFase }}</span>
                                                                        </div>
                                                                        <div class="progress mt-2" style="height: 7px;">
                                                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progressoFase }}%;"></div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </h2>
                                                            <div id="collapse_{{ $faseKey }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                                aria-labelledby="heading_{{ $faseKey }}" data-bs-parent="#checklistFasesAccordion">
                                                                <div class="accordion-body pt-3">
                                                                    <div class="row g-3">
                                                    @foreach ($faseItens as $item)
                                                        @php
                                                            $itemKey = \Illuminate\Support\Str::slug($item, '_');
                                                            $docs = $documentosPorItem->get($item, collect());
                                                            $isNaoNecessario = $docs->contains(fn ($d) => (bool) ($d->nao_necessario ?? false));
                                                            $arquivos = $docs->filter(fn ($d) => ! empty($d->arquivo_caminho))->values();
                                                            $temArquivo = $arquivos->isNotEmpty();
                                                        @endphp
                                                        <div class="col-md-6">
                                                            <div class="border rounded p-3 h-100 bg-white">
                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            {{ $docs->isNotEmpty() ? 'checked' : '' }} disabled>
                                                                        <label class="form-check-label fw-semibold">
                                                                            {{ $item }}
                                                                        </label>
                                                                    </div>
                                                                    <span
                                                                        id="checklist_status_badge_{{ $itemKey }}"
                                                                        class="badge {{ $isNaoNecessario ? 'bg-warning text-dark' : ($temArquivo ? 'bg-success' : 'bg-secondary') }}">
                                                                        @if ($isNaoNecessario)
                                                                            Nao necessario
                                                                        @elseif ($temArquivo)
                                                                            {{ $arquivos->count() }} arquivo(s)
                                                                        @else
                                                                            Pendente
                                                                        @endif
                                                                    </span>
                                                                </div>

                                                                @if ($temArquivo)
                                                                    <ul class="list-group list-group-flush small mb-2 border rounded" id="checklist_arquivos_list_{{ $itemKey }}">
                                                                        @foreach ($arquivos as $documento)
                                                                            <li class="list-group-item px-2 py-2 d-flex justify-content-between align-items-center gap-2"
                                                                                id="checklist_doc_row_{{ $documento->id }}">
                                                                                <span class="text-truncate" title="{{ $documento->arquivo_nome }}">{{ $documento->arquivo_nome }}</span>
                                                                                <div class="d-flex gap-1 flex-shrink-0">
                                                                                    <a href="{{ route('controle-pericias.checklist.download', ['controlePericia' => $controlePericia->id, 'documento' => $documento->id]) }}"
                                                                                        class="btn btn-sm btn-outline-primary"
                                                                                        title="Visualizar documento"
                                                                                        target="_blank"
                                                                                        rel="noopener noreferrer">
                                                                                        <i class="fas fa-eye"></i>
                                                                                    </a>
                                                                                    <button
                                                                                        type="button"
                                                                                        class="btn btn-sm btn-outline-info checklist-observacoes-btn"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#checklistObservacoesModal"
                                                                                        data-documento-id="{{ $documento->id }}"
                                                                                        data-item-key="{{ $itemKey }}"
                                                                                        data-documento-item="{{ $item }}"
                                                                                        data-observacoes="{{ $documento->observacoes ?? '' }}"
                                                                                        data-save-url="{{ route('controle-pericias.checklist.observacoes', ['controlePericia' => $controlePericia->id, 'documento' => $documento->id]) }}"
                                                                                        title="{{ $documento->observacoes ? 'Editar observações' : 'Adicionar observações' }}">
                                                                                        <i class="fas fa-comment-dots"></i>
                                                                                        <span
                                                                                            id="checklist_obs_ind_{{ $documento->id }}"
                                                                                            class="checklist-observacoes-indicator {{ empty($documento->observacoes) ? 'd-none' : '' }}"></span>
                                                                                    </button>
                                                                                    <button
                                                                                        type="button"
                                                                                        class="btn btn-sm btn-outline-danger checklist-remove-btn"
                                                                                        data-item-key="{{ $itemKey }}"
                                                                                        data-doc-row-id="checklist_doc_row_{{ $documento->id }}"
                                                                                        data-delete-url="{{ route('controle-pericias.checklist.destroy', ['controlePericia' => $controlePericia->id, 'documento' => $documento->id]) }}"
                                                                                        title="Remover documento">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif

                                                                <div class="d-flex gap-2 align-items-center checklist-upload-row {{ $isNaoNecessario ? 'd-none' : '' }}"
                                                                    id="checklist_upload_row_{{ $itemKey }}">
                                                                    <input class="form-control form-control-sm checklist-file-input"
                                                                        type="file"
                                                                        id="checklist_arquivo_{{ $itemKey }}"
                                                                        multiple
                                                                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-primary checklist-save-btn"
                                                                        data-item-nome="{{ $item }}"
                                                                        data-item-key="{{ $itemKey }}"
                                                                        data-upload-url="{{ route('controle-pericias.checklist.upload', $controlePericia->id) }}">
                                                                        <i class="fas fa-upload me-1"></i>Salvar
                                                                    </button>
                                                                </div>
                                                                <div
                                                                    class="d-flex gap-2 mt-2 {{ ($temArquivo && ! $isNaoNecessario) ? 'd-none' : '' }}"
                                                                    id="checklist_nao_necessario_wrapper_{{ $itemKey }}">
                                                                        <button
                                                                            type="button"
                                                                            class="btn btn-sm {{ $isNaoNecessario ? 'btn-outline-secondary' : 'btn-outline-warning' }} checklist-nao-necessario-btn"
                                                                            id="checklist_nao_necessario_btn_{{ $itemKey }}"
                                                                            data-item-nome="{{ $item }}"
                                                                            data-item-key="{{ $itemKey }}"
                                                                            data-toggle-url="{{ route('controle-pericias.checklist.nao-necessario', $controlePericia->id) }}"
                                                                            data-acao="{{ $isNaoNecessario ? 'desmarcar' : 'marcar' }}">
                                                                            <i class="fas {{ $isNaoNecessario ? 'fa-rotate-left' : 'fa-ban' }} me-1 checklist-nao-necessario-icon"></i>
                                                                            <span class="checklist-nao-necessario-label">{{ $isNaoNecessario ? 'Reativar documento' : 'Documento Não necessário' }}</span>
                                                                        </button>
                                                                </div>
                                                                <small class="text-danger d-none mt-1 checklist-error"
                                                                    id="checklist_error_{{ $itemKey }}"></small>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <small class="text-muted d-block mt-2">
                                                    Você pode enviar vários arquivos por item (selecione vários no campo ou envie em etapas). Formatos: PDF, imagem, Word e Excel (até 15MB por arquivo).
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
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
            let pendingRemove = null;

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

            $('.checklist-file-input').on('change', function() {
                const input = $(this);
                const hasFile = this.files && this.files.length > 0;
                const uploadRow = input.closest('.checklist-upload-row');
                input.toggleClass('checklist-file-selected', hasFile);
                uploadRow.toggleClass('checklist-upload-selected', hasFile);
            });

            $('.checklist-save-btn').on('click', function() {
                const btn = $(this);
                const itemNome = btn.data('item-nome');
                const itemKey = btn.data('item-key');
                const uploadUrl = btn.data('upload-url');
                const fileInput = $('#checklist_arquivo_' + itemKey);
                const errorEl = $('#checklist_error_' + itemKey);
                const files = fileInput[0].files;

                errorEl.addClass('d-none').text('');

                if (!files || !files.length) {
                    errorEl.removeClass('d-none').text('Selecione um ou mais arquivos antes de salvar.');
                    return;
                }

                const originalHtml = btn.html();
                let index = 0;
                const total = files.length;

                function uploadNext() {
                    if (index >= total) {
                        showChecklistToast(total > 1 ? total + ' documentos salvos com sucesso.' : 'Documento salvo com sucesso.', 'success');
                        fileInput.val('');
                        fileInput.removeClass('checklist-file-selected');
                        fileInput.closest('.checklist-upload-row').removeClass('checklist-upload-selected');
                        btn.prop('disabled', false).html(originalHtml);
                        setTimeout(function() {
                            const u = new URL(window.location.href);
                            u.searchParams.set('open_checklist', '1');
                            window.location.assign(u.toString());
                        }, 900);
                        return;
                    }

                    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Salvando ' + (index + 1) + '/' + total + '...');

                    const formData = new FormData();
                    formData.append('item_nome', itemNome);
                    formData.append('arquivo', files[index]);
                    index += 1;

                    $.ajax({
                        url: uploadUrl,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            uploadNext();
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
                            btn.prop('disabled', false).html(originalHtml);
                        }
                    });
                }

                uploadNext();
            });

            $('.checklist-remove-btn').on('click', function() {
                const btn = $(this);
                pendingRemove = {
                    btn: btn,
                    itemKey: btn.data('item-key'),
                    deleteUrl: btn.data('delete-url'),
                    docRowId: btn.attr('data-doc-row-id') || null
                };
                const modal = new bootstrap.Modal(document.getElementById('checklistRemoveConfirmModal'));
                modal.show();
            });

            $('#checklistConfirmRemoveBtn').on('click', function() {
                if (!pendingRemove) {
                    return;
                }

                const confirmBtn = $(this);
                const btn = pendingRemove.btn;
                const itemKey = pendingRemove.itemKey;
                const deleteUrl = pendingRemove.deleteUrl;
                const docRowId = pendingRemove.docRowId;
                const uploadRow = $('#checklist_upload_row_' + itemKey);
                const statusBadge = $('#checklist_status_badge_' + itemKey);
                const errorEl = $('#checklist_error_' + itemKey);
                const naoNecessarioWrapper = $('#checklist_nao_necessario_wrapper_' + itemKey);
                const listEl = $('#checklist_arquivos_list_' + itemKey);
                const removeModalEl = document.getElementById('checklistRemoveConfirmModal');
                const removeModal = bootstrap.Modal.getInstance(removeModalEl);

                errorEl.addClass('d-none').text('');
                const originalHtml = btn.html();
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
                confirmBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Removendo...');

                $.ajax({
                    url: deleteUrl,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if (docRowId) {
                            $('#' + docRowId).remove();
                        }
                        if (listEl.length) {
                            const remaining = listEl.find('li').length;
                            if (remaining === 0) {
                                listEl.remove();
                                statusBadge.removeClass('bg-success bg-warning text-dark').addClass('bg-secondary').text('Pendente');
                                uploadRow.removeClass('d-none');
                                naoNecessarioWrapper.removeClass('d-none');
                            } else {
                                statusBadge.removeClass('bg-secondary bg-warning text-dark').addClass('bg-success').text(remaining + ' arquivo(s)');
                            }
                        }

                        showChecklistToast(response.message || 'Documento removido com sucesso.', 'success');
                        if (removeModal) {
                            removeModal.hide();
                        }
                    },
                    error: function(xhr) {
                        let message = 'Não foi possível remover o documento.';
                        if (xhr.responseJSON?.message) {
                            message = xhr.responseJSON.message;
                        }
                        errorEl.removeClass('d-none').text(message);
                        showChecklistToast(message, 'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(originalHtml);
                        confirmBtn.prop('disabled', false).html('Confirmar remoção');
                        pendingRemove = null;
                    }
                });
            });

            $('.checklist-nao-necessario-btn').on('click', function() {
                const btn = $(this);
                const itemNome = btn.data('item-nome');
                const itemKey = btn.data('item-key');
                const toggleUrl = btn.data('toggle-url');
                const acao = btn.data('acao');
                const uploadRow = $('#checklist_upload_row_' + itemKey);
                const errorEl = $('#checklist_error_' + itemKey);

                errorEl.addClass('d-none').text('');

                const originalHtml = btn.html();
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Processando...');

                $.ajax({
                    url: toggleUrl,
                    method: 'PATCH',
                    data: {
                        item_nome: itemNome,
                        acao: acao
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        const marcado = response.acao_aplicada === 'marcar';

                        btn.data('acao', marcado ? 'desmarcar' : 'marcar');
                        btn.toggleClass('btn-outline-warning', !marcado);
                        btn.toggleClass('btn-outline-secondary', marcado);
                        btn.html(`
                            <i class="fas ${marcado ? 'fa-rotate-left' : 'fa-ban'} me-1 checklist-nao-necessario-icon"></i>
                            <span class="checklist-nao-necessario-label">${marcado ? 'Reativar documento' : 'Documento Não necessário'}</span>
                        `);

                        if (marcado) {
                            uploadRow.addClass('d-none');
                        } else {
                            uploadRow.removeClass('d-none');
                        }

                        showChecklistToast(response.message || 'Documento atualizado com sucesso.', 'success');
                        const u = new URL(window.location.href);
                        u.searchParams.set('open_checklist', '1');
                        window.location.assign(u.toString());
                    },
                    error: function(xhr) {
                        let message = 'Não foi possível atualizar o documento.';
                        if (xhr.responseJSON?.message) {
                            message = xhr.responseJSON.message;
                        }
                        errorEl.removeClass('d-none').text(message);
                        showChecklistToast(message, 'error');
                        btn.html(originalHtml);
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                    }
                });
            });

            const observacoesModal = $('#checklistObservacoesModal');
            const observacoesForm = $('#checklistObservacoesForm');
            const observacoesTextarea = $('#checklist_observacoes_texto');
            const observacoesSaveBtn = $('#checklist_observacoes_salvar');
            const observacoesError = $('#checklist_observacoes_erro');
            const observacoesTitle = $('#checklistObservacoesItemNome');
            const observacoesSaveUrl = $('#checklist_observacoes_save_url');
            const observacoesItemKey = $('#checklist_observacoes_item_key');

            $('.checklist-observacoes-btn').on('click', function() {
                const btn = $(this);
                observacoesTitle.text(btn.data('documento-item'));
                observacoesTextarea.val(btn.data('observacoes') || '');
                observacoesSaveUrl.val(btn.data('save-url'));
                observacoesItemKey.val(btn.data('item-key') || '');
                $('#checklist_observacoes_doc_id').val(btn.data('documento-id') || '');
                observacoesError.addClass('d-none').text('');
            });

            observacoesForm.on('submit', function(e) {
                e.preventDefault();

                const saveUrl = observacoesSaveUrl.val();
                const observacoes = observacoesTextarea.val();
                const itemKey = observacoesItemKey.val();
                const docId = $('#checklist_observacoes_doc_id').val();

                if (!saveUrl) {
                    observacoesError.removeClass('d-none').text('Não foi possível identificar o documento para salvar.');
                    return;
                }

                observacoesSaveBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Salvando...');
                observacoesError.addClass('d-none').text('');

                $.ajax({
                    url: saveUrl,
                    method: 'PATCH',
                    data: {
                        observacoes: observacoes
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        const hasObservacoes = !!(observacoes && observacoes.trim().length);
                        const indicator = docId ? $('#checklist_obs_ind_' + docId) : $();

                        if (indicator.length) {
                            indicator.toggleClass('d-none', !hasObservacoes);
                        }

                        const observacoesBtn = docId
                            ? $('.checklist-observacoes-btn[data-documento-id="' + docId + '"]')
                            : $('.checklist-observacoes-btn[data-item-key="' + itemKey + '"]');
                        observacoesBtn.attr('title', hasObservacoes ? 'Editar observações' : 'Adicionar observações');
                        observacoesBtn.data('observacoes', observacoes);

                        showChecklistToast(response.message || 'Observações salvas com sucesso.', 'success');
                        const modalEl = document.getElementById('checklistObservacoesModal');
                        const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modalInstance.hide();
                    },
                    error: function(xhr) {
                        let message = 'Não foi possível salvar as observações.';
                        if (xhr.responseJSON?.message) {
                            message = xhr.responseJSON.message;
                        } else if (xhr.responseJSON?.errors?.observacoes?.[0]) {
                            message = xhr.responseJSON.errors.observacoes[0];
                        }
                        observacoesError.removeClass('d-none').text(message);
                        showChecklistToast(message, 'error');
                    },
                    complete: function() {
                        observacoesSaveBtn.prop('disabled', false).html('<i class="fas fa-save me-1"></i>Salvar observações');
                    }
                });
            });
        });
    </script>

    <div class="modal fade" id="checklistObservacoesModal" tabindex="-1" aria-labelledby="checklistObservacoesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checklistObservacoesModalLabel">
                        Observações do documento: <span id="checklistObservacoesItemNome"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form id="checklistObservacoesForm">
                    <div class="modal-body">
                        <input type="hidden" id="checklist_observacoes_save_url">
                        <input type="hidden" id="checklist_observacoes_item_key">
                        <input type="hidden" id="checklist_observacoes_doc_id">
                        <label for="checklist_observacoes_texto" class="form-label">Observações</label>
                        <textarea
                            id="checklist_observacoes_texto"
                            class="form-control"
                            rows="6"
                            maxlength="5000"
                            placeholder="Digite as observações para este documento..."></textarea>
                        <small class="text-muted d-block mt-1">Máximo de 5000 caracteres.</small>
                        <small class="text-danger d-none mt-2" id="checklist_observacoes_erro"></small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="checklist_observacoes_salvar">
                            <i class="fas fa-save me-1"></i>Salvar observações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="checklistRemoveConfirmModal" tabindex="-1" aria-labelledby="checklistRemoveConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checklistRemoveConfirmModalLabel">Confirmar remoção</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja remover este documento do checklist?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="checklistConfirmRemoveBtn">Confirmar remoção</button>
                </div>
            </div>
        </div>
    </div>
@endsection
