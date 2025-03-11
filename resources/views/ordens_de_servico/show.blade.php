@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-clipboard-list me-2"></i>Detalhes da Ordem de
                                Serviço</h3>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="fas fa-align-left me-2"></i>Descrição</h6>
                                        <p class="fs-5 mb-0">{{ $ordemDeServico->descricao }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="fas fa-user me-2"></i>Responsável</h6>
                                        <p class="fs-5 mb-0">
                                            {{ $ordemDeServico->user ? $ordemDeServico->user->name : 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="fas fa-tasks me-2"></i>Status</h6>
                                        <span class="badge fs-6 bg-@statusColor($ordemDeServico->status) py-2 px-3">
                                            {{ $ordemDeServico->status }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="far fa-calendar-alt me-2"></i>Data de Criação
                                        </h6>
                                        <p class="fs-5 mb-0">{{ $ordemDeServico->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-muted mb-2"><i class="far fa-calendar-check me-2"></i>Última
                                            Atualização</h6>
                                        <p class="fs-5 mb-0">{{ $ordemDeServico->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('ordens-de-servico.edit', $ordemDeServico->id) }}"
                                    class="btn btn-warning me-2">
                                    <i class="fas fa-pencil-alt me-2"></i>Editar
                                </a>
                                <a href="{{ route('ordens-de-servico.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
