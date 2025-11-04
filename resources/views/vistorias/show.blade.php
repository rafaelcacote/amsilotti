@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <!-- Cabeçalho -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-clipboard-check me-2"></i>Detalhes da Vistoria</h3>
                            <div>
                                <a href="{{ route('vistorias.edit', $vistoria->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit me-2"></i>Editar
                                </a>
                                <a href="{{ route('vistorias.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-arrow-left me-2"></i>Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Resumo da Vistoria -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-info-circle me-2"></i>Resumo da Vistoria</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Número do Processo:</label>
                                        <p class="fw-bold">{{ $vistoria->num_processo }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Requerente:</label>
                                        <p class="fw-bold">{{ $vistoria->requerente ? $vistoria->requerente->nome : 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Requerido:</label>
                                        <p class="fw-bold">{{ $vistoria->requerido ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Data de Criação:</label>
                                        <p class="fw-bold">
                                            {{ $vistoria->created_at ? $vistoria->created_at->format('d/m/Y H:i') : 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Última Atualização:</label>
                                        <p class="fw-bold">{{ $vistoria->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dados Pessoais -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-user me-2"></i>Dados Pessoais</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Nome:</label>
                                        <p class="fw-bold">{{ $vistoria->nome ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">CPF:</label>
                                        <p class="fw-bold">
                                            @if ($vistoria->cpf)
                                                {{ \App\Helpers\CpfHelper::format($vistoria->cpf) }}
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Telefone:</label>
                                        <p class="fw-bold">
                                            @if ($vistoria->telefone)
                                                ({{ substr($vistoria->telefone, 0, 2) }})
                                                {{ substr($vistoria->telefone, 2, 5) }}-{{ substr($vistoria->telefone, 7, 4) }}
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Endereço -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-map-marker-alt me-2"></i>Endereço</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Endereço:</label>
                                        <p class="fw-bold">{{ $vistoria->endereco ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Número:</label>
                                        <p class="fw-bold">{{ $vistoria->num ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Bairro:</label>
                                        <p class="fw-bold">{{ $vistoria->bairro ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Cidade:</label>
                                        <p class="fw-bold">{{ $vistoria->cidade ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Estado:</label>
                                        <p class="fw-bold">{{ $vistoria->estado ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Características do Imóvel -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-home me-2"></i>Características do Imóvel</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Limites e Confrontações:</label>
                                        @if (is_array($vistoria->limites_confrontacoes))
                                            <ul class="mb-0">
                                                <li><strong>Norte:</strong>
                                                    {{ $vistoria->limites_confrontacoes['norte'] ?? 'N/A' }}</li>
                                                <li><strong>Sul:</strong>
                                                    {{ $vistoria->limites_confrontacoes['sul'] ?? 'N/A' }}</li>
                                                <li><strong>Leste:</strong>
                                                    {{ $vistoria->limites_confrontacoes['leste'] ?? 'N/A' }}</li>
                                                <li><strong>Oeste:</strong>
                                                    {{ $vistoria->limites_confrontacoes['oeste'] ?? 'N/A' }}</li>
                                            </ul>
                                        @else
                                            <span class="fw-bold">N/A</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Topografia:</label>
                                        <p class="fw-bold">{{ $vistoria->topografia ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Formato do Terreno:</label>
                                        <p class="fw-bold">{{ $vistoria->formato_terreno ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Superfície:</label>
                                        <p class="fw-bold">{{ $vistoria->superficie ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Documentação:</label>
                                        <p class="fw-bold">{{ $vistoria->documentacao ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ocupação -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-user-check me-2"></i>Ocupação</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Reside no Imóvel:</label>
                                        <p class="fw-bold">{{ $vistoria->reside_no_imovel ? 'Sim' : 'Não' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Data de Ocupação:</label>
                                        <p class="fw-bold">
                                            {{ $vistoria->data_ocupacao ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Tipo de Ocupação:</label>
                                        <p class="fw-bold">{{ $vistoria->tipo_ocupacao ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Exerce Pacificamente a Posse:</label>
                                        <p class="fw-bold">{{ $vistoria->exerce_pacificamente_posse ? 'Sim' : 'Não' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Utilização da Benfeitoria:</label>
                                        <p class="fw-bold">{{ $vistoria->utiliza_benfeitoria ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Construção -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-building me-2"></i>Construção</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Tipo de Construção:</label>
                                        <p class="fw-bold">{{ $vistoria->tipo_construcao ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Padrão de Acabamento:</label>
                                        <p class="fw-bold">{{ $vistoria->padrao_acabamento ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Idade Aparente:</label>
                                        <p class="fw-bold">{{ $vistoria->idade_aparente ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Estado de Conservação:</label>
                                        <p class="fw-bold">{{ $vistoria->estado_conservacao ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Observações -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-sticky-note me-2"></i>Observações</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <p class="fw-bold">
                                            {{ $vistoria->observacoes ?? 'Nenhuma observação registrada.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Croqui -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-pencil-ruler me-2"></i>Croqui da Edificação
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            @if (!empty($vistoria->croqui_imagem))
                                <img src="{{ asset('storage/' . $vistoria->croqui_imagem) }}" alt="Croqui da Edificação"
                                    class="img-fluid rounded border mb-2"
                                    style="max-width:100%;height:auto;max-height:250px;">
                            @else
                                <div class="py-4 text-muted">
                                    <i class="fas fa-image fa-3x mb-3"></i>
                                    <p class="mb-0">Nenhum croqui foi cadastrado.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Acompanhamento -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-users me-2"></i>Acompanhamento</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Nome do Acompanhante:</label>
                                <p class="fw-bold">{{ $vistoria->acompanhamento_vistoria ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">CPF do Acompanhante:</label>
                                <p class="fw-bold">
                                    @if ($vistoria->cpf_acompanhante)
                                        {{ \App\Helpers\CpfHelper::format($vistoria->cpf_acompanhante) }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Telefone do Acompanhante:</label>
                                <p class="fw-bold">
                                    @if ($vistoria->telefone_acompanhante)
                                        ({{ substr($vistoria->telefone_acompanhante, 0, 2) }})
                                        {{ substr($vistoria->telefone_acompanhante, 2, 5) }}-{{ substr($vistoria->telefone_acompanhante, 7, 4) }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Equipe Técnica -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-users-cog me-2"></i>Equipe Técnica</h5>
                        </div>
                        <div class="card-body">
                            @if ($vistoria->membrosEquipeTecnica->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach ($vistoria->membrosEquipeTecnica as $membro)
                                        <div class="list-group-item border-0 px-0 py-2">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0 fw-bold">{{ $membro->nome }}</h6>
                                                <span class="badge bg-primary">{{ $membro->cargo }}</span>
                                            </div>
                                            <p class="mb-0 text-muted small">
                                                <i class="fas fa-phone-alt me-1"></i>
                                                @if ($membro->telefone)
                                                    ({{ substr($membro->telefone, 0, 2) }})
                                                    {{ substr($membro->telefone, 2, 5) }}-{{ substr($membro->telefone, 7, 4) }}
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-3 text-muted">
                                    <i class="fas fa-user-times fa-2x mb-2"></i>
                                    <p class="mb-0">Nenhum membro da equipe foi registrado.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Fotos -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-camera me-2"></i>Fotos do Imóvel</h5>
                        </div>
                        <div class="card-body">
                            @if ($vistoria->fotos->count() > 0)
                                <div class="row g-2">
                                    @foreach ($vistoria->fotos as $foto)
                                        <div class="col-6">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $foto->url) }}"
                                                    alt="{{ $foto->descricao }}"
                                                    class="img-fluid rounded border cursor-pointer" data-bs-toggle="modal"
                                                    data-bs-target="#fotoModal{{ $foto->id }}">
                                                @if ($foto->descricao)
                                                    <div
                                                        class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 text-white p-1 small">
                                                        {{ Str::limit($foto->descricao, 15) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Modal para visualização da foto -->
                                        <div class="modal fade" id="fotoModal{{ $foto->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">
                                                            {{ $foto->descricao ?? 'Foto sem descrição' }}</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/' . $foto->url) }}" class="img-fluid"
                                                            alt="Foto da vistoria">
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <small class="text-muted">Adicionada em:
                                                            {{ $foto->created_at->format('d/m/Y H:i') }}</small>
                                                        <div>
                                                            <a href="{{ asset('storage/' . $foto->url) }}"
                                                                download="foto-{{ $foto->id }}-vistoria-{{ $vistoria->id }}.jpg"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="fas fa-download me-1"></i>Baixar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-3 text-center">
                                    <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#todasFotosModal">
                                        <i class="fas fa-images me-1"></i>Ver Todas as Fotos
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-camera-slash fa-2x mb-3"></i>
                                    <p class="mb-0">Nenhuma foto foi adicionada.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para visualizar todas as fotos -->
    @if ($vistoria->fotos->count() > 0)
        <div class="modal fade" id="todasFotosModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Todas as Fotos da Vistoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            @foreach ($vistoria->fotos as $foto)
                                <div class="col-md-4 col-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <img src="{{ asset('storage/' . $foto->url) }}"
                                            class="card-img-top cursor-pointer" alt="{{ $foto->descricao }}"
                                            data-bs-toggle="modal" data-bs-target="#fotoModal{{ $foto->id }}">
                                        <div class="card-body p-3">
                                            <p class="card-text small mb-2">{{ $foto->descricao ?? 'Sem descrição' }}</p>
                                            <p class="card-text text-muted small mb-0">
                                                <i class="far fa-clock me-1"></i>
                                                {{ $foto->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .cursor-pointer {
            cursor: pointer;
        }

        .card {
            border-radius: 10px;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        .form-label {
            font-weight: 500;
            color: #6c757d;
        }

        .fw-bold {
            color: #343a40;
        }
    </style>



    @push('scripts')
        @include('layouts.partials.fabricjs')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function initShowCroqui() {
                    if (window.fabric && document.getElementById('croqui-canvas')) {
                        try {
                            var canvas = new fabric.Canvas('croqui-canvas', {
                                backgroundColor: '#fff'
                            });
                            canvas.loadFromJSON(@json($vistoria->croqui), function() {
                                canvas.renderAll();
                            });
                        } catch (e) {
                            document.getElementById('croqui-canvas').style.display = 'none';
                        }
                    } else {
                        setTimeout(initShowCroqui, 200);
                    }
                }
                initShowCroqui();
            });
        </script>
        <script>
            $(document).ready(function() {
                $('[data-bs-toggle="tooltip"]').tooltip();
            });
        </script>
    @endpush

@endsection
