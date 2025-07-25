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
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="bg-light p-3 rounded">
                                        <h5 class="border-bottom pb-2">Informações do Processo</h5>
                                        <div class="row mt-3">
                                            <div class="col-md-4 mb-3">
                                                <strong>Número do Processo:</strong>
                                                <p>{{ $controlePericia->numero_processo }}</p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <strong>Requerente:</strong>
                                                <p>
                                                    @if ($controlePericia->requerente)
                                                        {{ $controlePericia->requerente->nome }}
                                                        @if ($controlePericia->requerente->tipo)
                                                            <span
                                                                class="text-muted small">({{ $controlePericia->requerente->tipo }})</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">Não informado</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <strong>Requerido:</strong>
                                                <p>{{ $controlePericia->requerido ?: 'Não informado' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <div class="bg-light p-3 rounded">
                                        <h5 class="border-bottom pb-2">Datas e Status</h5>
                                        <div class="row mt-3">
                                            <div class="col-md-3 mb-3">
                                                <strong>Data de Nomeação:</strong>
                                                <p>{{ $controlePericia->data_nomeacao ? $controlePericia->data_nomeacao->format('d/m/Y') : 'Não definida' }}
                                                </p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <strong>Data da Vistoria:</strong>
                                                <p>{{ $controlePericia->data_vistoria ? $controlePericia->data_vistoria->format('d/m/Y') : 'Não definida' }}
                                                </p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <strong>Prazo Final:</strong>
                                                <p>{{ $controlePericia->prazo_final ? $controlePericia->prazo_final->format('d/m/Y') : 'Não definido' }}
                                                </p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <strong>Status Atual:</strong>
                                                <p>
                                                    @php
                                                        $statusClass = match (
                                                            strtolower($controlePericia->status_atual)
                                                        ) {
                                                            'aguardando vistoria' => 'bg-info',
                                                            'em redação', 'em redacao' => 'bg-primary',
                                                            'aguardando pagamento' => 'bg-warning',
                                                            'aguardando documentação' => 'bg-secondary',
                                                            'concluído', 'concluido', 'entregue' => 'bg-success',
                                                            'cancelado' => 'bg-danger',
                                                            default => 'bg-light text-dark',
                                                        };
                                                    @endphp
                                                    <span
                                                        class="badge {{ $statusClass }}">{{ $controlePericia->status_atual }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <div class="bg-light p-3 rounded">
                                        <h5 class="border-bottom pb-2">Informações Adicionais</h5>
                                        <div class="row mt-3">
                                            <div class="col-md-4 mb-3">
                                                <strong>Responsável Técnico:</strong>
                                                <p>{{ $controlePericia->responsavelTecnico ? $controlePericia->responsavelTecnico->nome : 'Não atribuído' }}
                                                </p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <strong>Tipo de Perícia:</strong>
                                                <p>{{ $controlePericia->tipo_pericia ?: 'Não informado' }}</p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <strong>Valor:</strong>
                                                <p>{{ $controlePericia->valor ? 'R$ ' . number_format($controlePericia->valor, 2, ',', '.') : 'Não definido' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4 mb-3">
                                                <strong>Protocolo:</strong>
                                                <p>{{ $controlePericia->protocolo ?: 'Não definido' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <div class="bg-light p-3 rounded">
                                        <h5 class="border-bottom pb-2">Cadeia Dominial</h5>
                                        <div class="mt-3">
                                            <p>{!! nl2br(e($controlePericia->cadeia_dominial)) ?: 'Não informada' !!}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <div class="bg-light p-3 rounded">
                                        <h5 class="border-bottom pb-2">Observações</h5>
                                        <div class="mt-3">
                                            <p>{!! nl2br(e($controlePericia->observacoes)) ?: 'Não informadas' !!}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="bg-light p-3 rounded">
                                        <h5 class="border-bottom pb-2">Informações do Sistema</h5>
                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <strong>Data de Cadastro:</strong>
                                                <p>{{ $controlePericia->created_at->format('d/m/Y H:i:s') }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <strong>Última Atualização:</strong>
                                                <p>{{ $controlePericia->updated_at->format('d/m/Y H:i:s') }}</p>
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
@endsection
