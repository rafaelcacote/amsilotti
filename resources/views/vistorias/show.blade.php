@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                        <h3 class="mb-0 text-primary"><i class="fas fa-clipboard-check me-2"></i>Detalhes da Vistoria</h3>
                        <div class="d-flex gap-2">
                            <a href="{{ route('vistorias.edit', $vistoria->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                            <a href="{{ route('vistorias.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Voltar
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Coluna da esquerda -->
                            <div class="col-md-6">
                                <!-- Dados do Processo -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2 text-primary">Dados do Processo</h5>
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-4">
                                            <p class="mb-1 fw-bold">Número do Processo:</p>
                                            <p>{{ $vistoria->num_processo ?: 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1 fw-bold">Requerente:</p>
                                            <p>{{ $vistoria->requerente ?: 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1 fw-bold">Requerido:</p>
                                            <p>{{ $vistoria->requerido ?: 'Não informado' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dados Pessoais -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2 text-primary">Dados Pessoais</h5>
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-4">
                                            <p class="mb-1 fw-bold">Nome:</p>
                                            <p>{{ $vistoria->nome }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1 fw-bold">CPF:</p>
                                            <p>{{ $vistoria->cpf ?: 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1 fw-bold">Telefone:</p>
                                            <p>{{ $vistoria->telefone ?: 'Não informado' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Endereço -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2 text-primary">Endereço</h5>
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-12">
                                            <p class="mb-1 fw-bold">Endereço Completo:</p>
                                            <p>{{ $vistoria->endereco }}, {{ $vistoria->num ?: 'S/N' }} - {{ $vistoria->bairro }}, {{ $vistoria->cidade }}/{{ $vistoria->estado }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Características do Imóvel -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2 text-primary">Características do Imóvel</h5>
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-6">
                                            <p class="mb-1 fw-bold">Lado Direito:</p>
                                            <p>{{ $vistoria->lado_direito ?: 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1 fw-bold">Lado Esquerdo:</p>
                                            <p>{{ $vistoria->lado_esquerdo ?: 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1 fw-bold">Topografia:</p>
                                            <p>{{ $vistoria->topografia ?: 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1 fw-bold">Formato do Terreno:</p>
                                            <p>{{ $vistoria->formato_terreno ?: 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1 fw-bold">Superfície:</p>
                                            <p><span class="badge bg-{{ $vistoria->superficie == 'Seca' ? 'success' : ($vistoria->superficie == 'Brejosa' ? 'warning' : 'danger') }}">{{ $vistoria->superficie }}</span></p>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="mb-1 fw-bold">Limites e Confrontações:</p>
                                            <p>{{ $vistoria->limites_confrontacoes ?: 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="mb-1 fw-bold">Documentação:</p>
                                            <p>{{ $vistoria->documentacao ?: 'Não informado' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Coluna da direita -->
                            <div class="col-md-6">
                                <!-- Ocupação -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2 text-primary">Ocupação</h5>
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-4">
                                            <p class="mb-1 fw-bold">Reside no Imóvel:</p>
                                            <p>{{ $vistoria->reside_no_imovel ? 'Sim' : 'Não' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1 fw-bold">Data de Ocupação:</p>
                                            <p>{{ $vistoria->data_ocupacao ? $vistoria->data_ocupacao->format('d/m/Y') : 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1 fw-bold">Tipo de Ocupação:</p>
                                            <p><span class="badge bg-{{ $vistoria->tipo_ocupacao == 'Residencial' ? 'success' : ($vistoria->tipo_ocupacao == 'Comercial' ? 'primary' : 'warning') }}">{{ $vistoria->tipo_ocupacao }}</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1 fw-bold">Exerce Pacificamente a Posse:</p>
                                            <p>{{ $vistoria->exerce_pacificamente_posse ? 'Sim' : 'Não' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1 fw-bold">Utilização da Benfeitoria:</p>
                                            <p>{{ $vistoria->utiliza_da_benfeitoria }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Construção -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2 text-primary">Construção</h5>
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-6">
                                            <p class="mb-1 fw-bold">Tipo de Construção:</p>
                                            <p>{{ $vistoria->tipo_construcao ?: 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1 fw-bold">Padrão de Acabamento:</p>
                                            <p>{{ $vistoria->padrao_acabamento ?: 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1 fw-bold">Idade Aparente:</p>
                                            <p>{{ $vistoria->idade_aparente ?: 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1 fw-bold">Estado de Conservação:</p>
                                            <p>{{ $vistoria->estado_de_conservacao ?: 'Não informado' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Acompanhamento -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2 text-primary">Acompanhamento da Vistoria</h5>
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-12">
                                            <p class="mb-1 fw-bold">Acompanhante:</p>
                                            <p>{{ $vistoria->acompanhamento_vistoria ?: 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1 fw-bold">CPF do Acompanhante:</p>
                                            <p>{{ $vistoria->cpf_acompanhante ?: 'Não informado' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1 fw-bold">Telefone do Acompanhante:</p>
                                            <p>{{ $vistoria->telefone_acompanhante ?: 'Não informado' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Observações -->
                                <div class="mb-4">
                                    <h5 class="border-bottom pb-2 text-primary">Observações</h5>
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-12">
                                            <p>{{ $vistoria->observacoes ?: 'Nenhuma observação registrada.' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fotos -->
                        @if($vistoria->fotos->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 text-primary">Fotos da Vistoria</h5>
                                <div class="row g-3 mt-2">
                                    @foreach($vistoria->fotos as $foto)
                                    <div class="col-md-3 mb-3">
                                        <div class="card h-100">
                                            <img src="{{ asset('storage/' . $foto->url) }}" class="card-img-top" alt="Foto da vistoria" style="height: 200px; object-fit: cover;">
                                            <div class="card-body">
                                                <p class="card-text">{{ $foto->descricao ?: 'Sem descrição' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection