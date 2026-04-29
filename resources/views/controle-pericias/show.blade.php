@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-gavel me-2"></i>Detalhes da Perícia</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('controle-pericias.edit', $controlePericia->id) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit me-1"></i> Editar
                                </a>
                                <a href="{{ route('controle-pericias.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Voltar
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @php
                                $statusClass = match (strtolower($controlePericia->status_atual)) {
                                    'aguardando vistoria' => 'bg-info',
                                    'em redação', 'em redacao' => 'bg-primary',
                                    'aguardando pagamento' => 'bg-warning text-dark',
                                    'aguardando documentação' => 'bg-secondary',
                                    'concluído', 'concluido', 'entregue' => 'bg-success',
                                    'cancelado' => 'bg-danger',
                                    default => 'bg-light text-dark',
                                };

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
                                $checklistItensVisiveis = collect($checklistItems)->filter(function ($item) use ($documentosPorItem) {
                                    $docs = $documentosPorItem->get($item, collect());
                                    return ! $docs->contains(fn ($d) => (bool) ($d->nao_necessario ?? false));
                                })->values();
                                $checklistTotal = $checklistItensVisiveis->count();
                                $checklistConcluidos = $checklistItensVisiveis
                                    ? $checklistItensVisiveis->filter(fn ($item) => $checklistItemConcluido($item))->count()
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

                                $itensRestantes = $checklistItensVisiveis;
                                $checklistAgrupadoPorFase = [];

                                foreach ($fasesChecklist as $faseNome => $faseItens) {
                                    $itensDaFase = collect($faseItens)->filter(fn ($item) => $checklistItensVisiveis->contains($item))->values();
                                    if ($itensDaFase->isNotEmpty()) {
                                        $checklistAgrupadoPorFase[$faseNome] = $itensDaFase;
                                        $itensRestantes = $itensRestantes->reject(fn ($item) => $itensDaFase->contains($item))->values();
                                    }
                                }

                                if ($itensRestantes->isNotEmpty()) {
                                    $checklistAgrupadoPorFase['Outros Itens'] = $itensRestantes->values();
                                }
                            @endphp

                            <div class="border rounded p-3 bg-light mb-3">
                                <div class="row g-3 align-items-center">
                                    <div class="col-lg-4">
                                        <small class="text-muted d-block">Processo</small>
                                        <strong class="fs-6">{{ $controlePericia->numero_processo }}</strong>
                                    </div>
                                    <div class="col-lg-4">
                                        <small class="text-muted d-block">Fase da Perícia</small>
                                        <span class="badge {{ $statusClass }}">{{ $controlePericia->status_atual }}</span>
                                    </div>
                                    <div class="col-lg-4">
                                        <small class="text-muted d-block">Checklist</small>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-primary-subtle text-primary">{{ $checklistConcluidos }}/{{ $checklistTotal }}</span>
                                            <div class="progress flex-grow-1" style="height: 8px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progresso }}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <ul class="nav nav-tabs mb-3" id="periciaShowTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados-pane"
                                        type="button" role="tab" aria-controls="dados-pane" aria-selected="true">
                                        Dados da Perícia
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="checklist-tab" data-bs-toggle="tab" data-bs-target="#checklist-pane"
                                        type="button" role="tab" aria-controls="checklist-pane" aria-selected="false">
                                        Checklist de Documentos
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="sistema-tab" data-bs-toggle="tab" data-bs-target="#sistema-pane"
                                        type="button" role="tab" aria-controls="sistema-pane" aria-selected="false">
                                        Sistema
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="periciaShowTabsContent">
                                <div class="tab-pane fade show active" id="dados-pane" role="tabpanel" aria-labelledby="dados-tab">
                                    <div class="row g-3">
                                        <div class="col-lg-6">
                                            <div class="border rounded p-3 h-100">
                                                <h6 class="mb-3 text-primary">Partes e Processo</h6>
                                                <div class="row g-2">
                                                    <div class="col-6"><small class="text-muted">Requerente</small></div>
                                                    <div class="col-6 text-end">
                                                        {{ $controlePericia->requerente ? $controlePericia->requerente->nome : 'Não informado' }}
                                                    </div>
                                                    <div class="col-6"><small class="text-muted">Requerido</small></div>
                                                    <div class="col-6 text-end">{{ $controlePericia->requerido ?: 'Não informado' }}</div>
                                                    <div class="col-6"><small class="text-muted">Tipo de Perícia</small></div>
                                                    <div class="col-6 text-end">{{ $controlePericia->tipo_pericia ?: 'Não informado' }}</div>
                                                    <div class="col-6"><small class="text-muted">Responsável Técnico</small></div>
                                                    <div class="col-6 text-end">
                                                        {{ $controlePericia->responsavelTecnico ? $controlePericia->responsavelTecnico->nome : 'Não atribuído' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="border rounded p-3 h-100">
                                                <h6 class="mb-3 text-primary">Prazos e Financeiro</h6>
                                                <div class="row g-2">
                                                    <div class="col-6"><small class="text-muted">Nomeação</small></div>
                                                    <div class="col-6 text-end">{{ $controlePericia->data_nomeacao ? $controlePericia->data_nomeacao->format('d/m/Y') : 'Não definida' }}</div>
                                                    <div class="col-6"><small class="text-muted">Vistoria</small></div>
                                                    <div class="col-6 text-end">{{ $controlePericia->data_vistoria ? $controlePericia->data_vistoria->format('d/m/Y') : 'Não definida' }}</div>
                                                    <div class="col-6"><small class="text-muted">Laudo Entregue</small></div>
                                                    <div class="col-6 text-end">{{ $controlePericia->prazo_final ? $controlePericia->prazo_final->format('d/m/Y') : 'Não definido' }}</div>
                                                    <div class="col-6"><small class="text-muted">Valor</small></div>
                                                    <div class="col-6 text-end">{{ $controlePericia->valor ? 'R$ ' . number_format($controlePericia->valor, 2, ',', '.') : 'Não definido' }}</div>
                                                    <div class="col-6"><small class="text-muted">Protocolo</small></div>
                                                    <div class="col-6 text-end">{{ $controlePericia->protocolo ?: 'Não definido' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="border rounded p-3">
                                                <h6 class="mb-2 text-primary">Observações Gerais</h6>
                                                <p class="mb-0">{!! nl2br(e($controlePericia->observacoes)) ?: 'Não informadas' !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="checklist-pane" role="tabpanel" aria-labelledby="checklist-tab">
                                    @if (empty($checklistItems))
                                        <p class="text-muted mb-0">Sem checklist configurado para este tipo de perícia.</p>
                                    @else
                                        <div class="accordion" id="checklistFasesAccordionShow">
                                            @foreach ($checklistAgrupadoPorFase as $faseNome => $faseItens)
                                                @php
                                                    $faseKey = \Illuminate\Support\Str::slug($faseNome, '_');
                                                    $totalFase = $faseItens->count();
                                                    $concluidosFase = $faseItens->filter(fn ($item) => $checklistItemConcluido($item))->count();
                                                    $progressoFase = $totalFase > 0 ? round(($concluidosFase / $totalFase) * 100) : 0;
                                                @endphp
                                                <div class="accordion-item mb-2 border rounded">
                                                    <h2 class="accordion-header" id="show_heading_{{ $faseKey }}">
                                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#show_collapse_{{ $faseKey }}"
                                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="show_collapse_{{ $faseKey }}">
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
                                                    <div id="show_collapse_{{ $faseKey }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                        aria-labelledby="show_heading_{{ $faseKey }}" data-bs-parent="#checklistFasesAccordionShow">
                                                        <div class="accordion-body pt-3">
                                                            <div class="row g-2">
                                                                @foreach ($faseItens as $item)
                                                                    @php
                                                                        $docs = $documentosPorItem->get($item, collect());
                                                                        $arquivos = $docs->filter(fn ($d) => ! empty($d->arquivo_caminho))->values();
                                                                        $temArquivo = $arquivos->isNotEmpty();
                                                                    @endphp
                                                                    <div class="col-md-6">
                                                                        <div class="border rounded p-2 bg-white h-100">
                                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                                <div class="pe-2">
                                                                                    <i class="fas {{ $temArquivo ? 'fa-check-circle text-success' : 'fa-circle text-muted' }} me-2"></i>
                                                                                    {{ $item }}
                                                                                    @if ($temArquivo)
                                                                                        <span class="badge bg-primary-subtle text-primary ms-2">{{ $arquivos->count() }} arquivo(s)</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            @if ($temArquivo)
                                                                                <ul class="list-group list-group-flush small mb-0">
                                                                                    @foreach ($arquivos as $documento)
                                                                                        <li class="list-group-item px-2 py-1 d-flex justify-content-between align-items-center gap-2">
                                                                                            <span class="text-truncate" title="{{ $documento->arquivo_nome }}">{{ $documento->arquivo_nome }}</span>
                                                                                            <div class="d-flex gap-1 flex-shrink-0">
                                                                                                <a href="{{ route('controle-pericias.checklist.download', ['controlePericia' => $controlePericia->id, 'documento' => $documento->id]) }}"
                                                                                                    class="btn btn-sm btn-outline-primary py-0 px-2"
                                                                                                    title="Visualizar documento"
                                                                                                    target="_blank"
                                                                                                    rel="noopener noreferrer">
                                                                                                    <i class="fas fa-eye"></i>
                                                                                                </a>
                                                                                                @if (!empty($documento->observacoes))
                                                                                                    <button
                                                                                                        type="button"
                                                                                                        class="btn btn-sm btn-outline-info py-0 px-2 checklist-show-observacoes-btn"
                                                                                                        title="Visualizar informações"
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-target="#checklistShowObservacoesModal"
                                                                                                        data-item-nome="{{ $item }}"
                                                                                                        data-observacoes="{{ $documento->observacoes ?? '' }}">
                                                                                                        <i class="fas fa-comment-dots"></i>
                                                                                                    </button>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="d-inline-block"
                                                                                                        data-bs-toggle="tooltip"
                                                                                                        data-bs-placement="top"
                                                                                                        title="Não há informações cadastradas.">
                                                                                                        <button
                                                                                                            type="button"
                                                                                                            class="btn btn-sm btn-outline-info py-0 px-2 checklist-show-observacoes-btn"
                                                                                                            disabled>
                                                                                                            <i class="fas fa-comment-dots"></i>
                                                                                                        </button>
                                                                                                    </span>
                                                                                                @endif
                                                                                            </div>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="tab-pane fade" id="sistema-pane" role="tabpanel" aria-labelledby="sistema-tab">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="border rounded p-3">
                                                <small class="text-muted d-block">Data de Cadastro</small>
                                                <strong>{{ $controlePericia->created_at->format('d/m/Y H:i:s') }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="border rounded p-3">
                                                <small class="text-muted d-block">Última Atualização</small>
                                                <strong>{{ $controlePericia->updated_at->format('d/m/Y H:i:s') }}</strong>
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
    </div>

    <div class="modal fade" id="checklistShowObservacoesModal" tabindex="-1"
        aria-labelledby="checklistShowObservacoesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checklistShowObservacoesModalLabel">
                        Observações do documento: <span id="checklistShowObservacoesItemNome"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0" id="checklistShowObservacoesTexto"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemNomeEl = document.getElementById('checklistShowObservacoesItemNome');
            const observacoesEl = document.getElementById('checklistShowObservacoesTexto');
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            document.querySelectorAll('.checklist-show-observacoes-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const itemNome = btn.getAttribute('data-item-nome') || '';
                    const observacoes = btn.getAttribute('data-observacoes') || '';
                    itemNomeEl.textContent = itemNome;
                    observacoesEl.textContent = observacoes.trim() !== '' ? observacoes : 'Sem observações cadastradas.';
                });
            });
        });
    </script>
@endsection
