@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-success">
                                <i class="fas fa-money-bill-wave me-2"></i>Detalhes do Registro Financeiro
                            </h3>
                            <a href="{{ route('entrega-laudos-financeiro.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Voltar
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Informações da Perícia -->
                                <div class="col-md-6">
                                    <div class="card bg-light mb-3">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0"><i class="fas fa-gavel me-2"></i>Dados da Perícia</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold">Processo:</td>
                                                    <td>
                                                        @if($entregaLaudoFinanceiro->controlePericia && $entregaLaudoFinanceiro->controlePericia->numero_processo)
                                                            <a href="https://consultasaj.tjam.jus.br/cpopg/search.do?cbPesquisa=NUMPROC&dadosConsulta.valorConsulta={{ $entregaLaudoFinanceiro->controlePericia->numero_processo }}"
                                                                target="_blank">
                                                                {{ $entregaLaudoFinanceiro->controlePericia->numero_processo }}
                                                                <i class="fas fa-external-link-alt ms-1"></i>
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Não informado</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Requerente:</td>
                                                    <td>{{ $entregaLaudoFinanceiro->controlePericia && $entregaLaudoFinanceiro->controlePericia->requerente ? $entregaLaudoFinanceiro->controlePericia->requerente->nome : 'Não informado' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Requerido:</td>
                                                    <td>{{ $entregaLaudoFinanceiro->controlePericia->requerido ?? 'Não informado' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Vara:</td>
                                                    <td>{{ $entregaLaudoFinanceiro->controlePericia->vara ?? 'Não informado' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Responsável Técnico:</td>
                                                    <td>{{ $entregaLaudoFinanceiro->controlePericia && $entregaLaudoFinanceiro->controlePericia->responsavelTecnico ? $entregaLaudoFinanceiro->controlePericia->responsavelTecnico->nome : 'Não informado' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Status da Perícia:</td>
                                                    <td>
                                                        @if($entregaLaudoFinanceiro->controlePericia)
                                                            @php
                                                                $statusColor = App\Models\ControlePericia::getStatusColor($entregaLaudoFinanceiro->controlePericia->status_atual);
                                                            @endphp
                                                            <span class="badge {{ $statusColor['class'] }}">
                                                                {{ $entregaLaudoFinanceiro->controlePericia->status_atual }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">Não informado</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informações Financeiras -->
                                <div class="col-md-6">
                                    <div class="card bg-light mb-3">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Dados Financeiros</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold">Status Financeiro:</td>
                                                    <td>
                                                        @php
                                                            $statusClass = match (strtolower($entregaLaudoFinanceiro->status ?? '')) {
                                                                'liquidado' => 'bg-success',
                                                                'pagamento/presidencia' => 'bg-warning text-dark',
                                                                'aguardando sei' => 'bg-info',
                                                                'secoft/empenho' => 'bg-primary',
                                                                default => 'bg-light text-dark',
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $statusClass }}">{{ $entregaLaudoFinanceiro->status ?? 'Não informado' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">UPJ:</td>
                                                    <td>{{ ucfirst($entregaLaudoFinanceiro->upj ?? 'Não informado') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Financeiro:</td>
                                                    <td>{{ ucfirst($entregaLaudoFinanceiro->financeiro ?? 'Não informado') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Protocolo do Laudo:</td>
                                                    <td>{{ $entregaLaudoFinanceiro->protocolo_laudo ? $entregaLaudoFinanceiro->protocolo_laudo->format('d/m/Y') : 'Não informado' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Valor:</td>
                                                    <td>
                                                        @if($entregaLaudoFinanceiro->valor)
                                                            <span class="fw-bold text-success fs-5">{{ $entregaLaudoFinanceiro->valor_formatado }}</span>
                                                        @else
                                                            <span class="text-muted">Não informado</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">SEI:</td>
                                                    <td>{{ $entregaLaudoFinanceiro->sei ?? 'Não informado' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">NF:</td>
                                                    <td>
                                                        @if($entregaLaudoFinanceiro->nf)
                                                            <span class="badge bg-primary">NF: {{ $entregaLaudoFinanceiro->nf }}</span>
                                                        @else
                                                            <span class="text-muted">Não informado</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Empenho:</td>
                                                    <td>
                                                        @if($entregaLaudoFinanceiro->empenho)
                                                            <span class="badge bg-info">Empenho: {{ $entregaLaudoFinanceiro->empenho }}</span>
                                                        @else
                                                            <span class="text-muted">Não informado</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Mês de Pagamento:</td>
                                                    <td>{{ $entregaLaudoFinanceiro->mes_pagamento ?? 'Não informado' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Tipo de Perícia:</td>
                                                    <td>{{ $entregaLaudoFinanceiro->tipo_pericia ?? 'Não informado' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- Informações de Sistema -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card bg-light">
                                        <div class="card-header bg-secondary text-white">
                                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informações do Sistema</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Criado em:</strong> {{ $entregaLaudoFinanceiro->created_at->format('d/m/Y H:i:s') }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Última atualização:</strong> {{ $entregaLaudoFinanceiro->updated_at->format('d/m/Y H:i:s') }}</p>
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
    </div>
@endsection