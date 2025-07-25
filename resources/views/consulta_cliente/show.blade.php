@extends('layouts.app')

@section('title', 'Detalhes do Imóvel')

@section('content')
    <div class="container-fluid px-4 py-4">
        <!-- Título da Página -->
        <div class="row mb-3">
            <div class="col">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="fas fa-home me-2"></i>Detalhes do Imóvel #{{ $imovel->id }}
                        </h1>
                        <p class="text-muted mt-2">Informações completas sobre o imóvel selecionado</p>
                    </div>
                    <a href="{{ route('consulta.cliente.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar à Consulta
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Informações Principais -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informações Gerais</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="text-muted small">Tipo do Imóvel</label>
                                    <div class="fw-medium">
                                        <span class="badge bg-primary fs-6">
                                            {{ $imovel->tipo == 'terreno' ? 'Terreno' : 
                                               ($imovel->tipo == 'apartamento' ? 'Apartamento' : 
                                               ($imovel->tipo == 'imovel_urbano' ? 'Imóvel Urbano' : 
                                               ($imovel->tipo == 'sala_comercial' ? 'Sala Comercial' : 'Galpão'))) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="text-muted small">Valor Total</label>
                                    <div class="fw-medium text-success">
                                        @if ($imovel->valor_total_imovel)
                                            R$ {{ number_format($imovel->valor_total_imovel, 2, ',', '.') }}
                                        @else
                                            <span class="text-muted">Não informado</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="text-muted small">Área</label>
                                    <div class="fw-medium text-info">
                                        @if ($imovel->tipo == 'terreno')
                                            {{ number_format($imovel->area_total, 2, ',', '.') }} m²
                                        @else
                                            {{ $imovel->area_construida ? number_format($imovel->area_construida, 2, ',', '.') : '0,00' }} m²
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="text-muted small">Data de Cadastro</label>
                                    <div class="fw-medium">{{ $imovel->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Localização -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Localização</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="info-item">
                                    <label class="text-muted small">Endereço Completo</label>
                                    <div class="fw-medium">
                                        {{ $imovel->endereco }}
                                        @if($imovel->numero), {{ $imovel->numero }}@endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label class="text-muted small">Bairro</label>
                                    <div class="fw-medium">{{ $imovel->bairro->nome ?? 'Não informado' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label class="text-muted small">Zona</label>
                                    <div class="fw-medium">{{ $imovel->zona->nome ?? 'Não informado' }}</div>
                                </div>
                            </div>
                            @if($imovel->viaEspecifica)
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label class="text-muted small">Via Específica</label>
                                    <div class="fw-medium">{{ $imovel->viaEspecifica->nome }}</div>
                                </div>
                            </div>
                            @endif
                        </div>

                        @if (!empty($imovel->latitude) && !empty($imovel->longitude))
                            <div class="mt-4">
                                <button class="btn btn-outline-success view-location"
                                    data-bs-toggle="tooltip"
                                    title="Ver no mapa"
                                    data-latitude="{{ str_replace(',', '.', $imovel->latitude) }}"
                                    data-longitude="{{ str_replace(',', '.', $imovel->longitude) }}"
                                    data-id="{{ $imovel->id }}"
                                    data-tipo="{{ $imovel->tipo == 'terreno' ? 'Terreno' : ($imovel->tipo == 'apartamento' ? 'Apartamento' : ($imovel->tipo == 'imovel_urbano' ? 'Imóvel Urbano' : ($imovel->tipo == 'sala_comercial' ? 'Sala Comercial' : 'Galpão'))) }}"
                                    data-bairro="{{ $imovel->bairro->nome ?? '' }}"
                                    data-area="{{ $imovel->tipo == 'terreno' ? $imovel->area_total : $imovel->area_construida }}">
                                    <i class="fas fa-map me-2"></i>Ver no Mapa
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Características Técnicas -->
                @if ($imovel->tipo == 'terreno')
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-ruler-combined me-2"></i>Características do Terreno</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label class="text-muted small">Área Total</label>
                                    <div class="fw-medium">{{ number_format($imovel->area_total, 2, ',', '.') }} m²</div>
                                </div>
                            </div>
                            @if($imovel->frente)
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label class="text-muted small">Frente</label>
                                    <div class="fw-medium">{{ number_format($imovel->frente, 2, ',', '.') }} m</div>
                                </div>
                            </div>
                            @endif
                            @if($imovel->fundos)
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label class="text-muted small">Fundos</label>
                                    <div class="fw-medium">{{ number_format($imovel->fundos, 2, ',', '.') }} m</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-building me-2"></i>Características da Construção</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @if($imovel->area_construida)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="text-muted small">Área Construída</label>
                                    <div class="fw-medium">{{ number_format($imovel->area_construida, 2, ',', '.') }} m²</div>
                                </div>
                            </div>
                            @endif
                            @if($imovel->area_terreno)
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="text-muted small">Área do Terreno</label>
                                    <div class="fw-medium">{{ number_format($imovel->area_terreno, 2, ',', '.') }} m²</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar com informações adicionais -->
            <div class="col-lg-4">
                <!-- Status e Situação -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-tag me-2"></i>Status</h5>
                    </div>
                    <div class="card-body">
                        @if($imovel->situacao)
                        <div class="mb-3">
                            <label class="text-muted small">Situação</label>
                            <div>
                                <span class="badge bg-info">{{ ucfirst($imovel->situacao) }}</span>
                            </div>
                        </div>
                        @endif
                        
                        @if($imovel->fator_fundamentacao)
                        <div class="mb-3">
                            <label class="text-muted small">Fator de Fundamentação</label>
                            <div class="fw-medium">{{ $imovel->fator_fundamentacao }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Informações de Amostra -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Amostra</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted small">Preço de Venda da Amostra</label>
                            <div class="fw-bold text-success fs-5">
                                @if ($imovel->preco_venda_amostra && $imovel->preco_venda_amostra > 0)
                                    R$ {{ number_format($imovel->preco_venda_amostra, 2, ',', '.') }}
                                @else
                                    <span class="text-muted">Não disponível</span>
                                @endif
                            </div>
                        </div>
                        
                        @if ($imovel->preco_venda_amostra && $imovel->preco_venda_amostra > 0)
                        <div class="d-grid">
                            @if(isset($itemNoCarrinho) && $itemNoCarrinho)
                                <button class="btn btn-success" disabled>
                                    <i class="fa-solid fa-check me-2"></i>Já Adicionado
                                </button>
                            @else
                                <button class="btn btn-primary btn-add-carrinho" data-amostra-id="{{ $imovel->id }}">
                                    <i class="fa-solid fa-cart-plus me-2"></i>Comprar Amostra
                                </button>
                            @endif
                        </div>
                        @else
                        <div class="d-grid">
                            <button class="btn btn-secondary" disabled>
                                <i class="fa-solid fa-times me-2"></i>Amostra Indisponível
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Fotos do Imóvel -->
                @if($imovel->fotos && $imovel->fotos->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-images me-2"></i>Fotos do Imóvel</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            @foreach($imovel->fotos as $foto)
                                <div class="col-6">
                                    <a href="{{ asset('storage/' . $foto->caminho_foto) }}" 
                                       data-bs-toggle="modal" 
                                       data-bs-target="#photoModal"
                                       onclick="showPhoto('{{ asset('storage/' . $foto->caminho_foto) }}')">
                                        <img src="{{ asset('storage/' . $foto->caminho_foto) }}" 
                                             class="img-fluid rounded shadow-sm hover-zoom" 
                                             style="height: 100px; width: 100%; object-fit: cover; cursor: pointer;">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal para exibir fotos -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">Foto do Imóvel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalPhoto" src="" class="img-fluid" alt="Foto do imóvel">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Visualização de Localização -->
    <div class="modal fade" id="singleLocationModal" tabindex="-1" aria-labelledby="singleLocationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="singleLocationModalLabel">Localização do Imóvel #<span id="imovelIdTitle"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="googleMapsIframe" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Botão flutuante do carrinho -->
    <div id="carrinho-indicador" class="d-none" style="position: fixed; bottom: 30px; right: 30px; z-index: 1050;">
        <a href="{{ route('carrinho.index') }}" class="btn btn-success btn-lg shadow position-relative">
            <i class="fa-solid fa-cart-shopping"></i> Ver Carrinho
            <span id="carrinho-contador" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.75rem;">
                0
            </span>
        </a>
    </div>
@endsection

@push('styles')
<style>
    .info-item {
        margin-bottom: 1rem;
    }
    
    .info-item label {
        font-weight: 600;
        margin-bottom: 0.25rem;
        display: block;
    }
    
    .hover-zoom {
        transition: transform 0.2s;
    }
    
    .hover-zoom:hover {
        transform: scale(1.05);
    }
    
    .card {
        border-radius: 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Verificar se o elemento carrinho-indicador existe
        const carrinhoIndicador = document.getElementById('carrinho-indicador');
        const carrinhoContador = document.getElementById('carrinho-contador');
        
        // Função para atualizar o contador do carrinho
        function atualizarContadorCarrinho() {
            fetch("{{ route('carrinho.contador') }}", {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (carrinhoContador) {
                    carrinhoContador.textContent = data.total_itens;
                }
                
                // Mostra ou esconde o indicador baseado na quantidade
                if (data.total_itens > 0) {
                    carrinhoIndicador.classList.remove('d-none');
                } else {
                    carrinhoIndicador.classList.add('d-none');
                }
            })
            .catch(error => {
                console.error('Erro ao atualizar contador do carrinho:', error);
            });
        }

        // Carrega o contador inicial
        atualizarContadorCarrinho();

        // Funcionalidade do mapa
        document.querySelectorAll('.view-location').forEach(button => {
            button.addEventListener('click', function() {
                const latitude = parseFloat(this.dataset.latitude);
                const longitude = parseFloat(this.dataset.longitude);
                const codigo = this.dataset.id;

                document.getElementById('imovelIdTitle').textContent = codigo;

                // Monta a URL do Google Maps Embed
                const mapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}&hl=pt-BR&z=17&output=embed`;
                document.getElementById('googleMapsIframe').src = mapsUrl;

                const modal = new bootstrap.Modal(document.getElementById('singleLocationModal'));
                modal.show();
            });
        });

        // Funcionalidade do carrinho
        document.querySelectorAll('.btn-add-carrinho').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                var amostraId = this.dataset.amostraId;
                var btnElement = this;
                
                // Desabilita o botão durante a requisição
                btnElement.disabled = true;
                btnElement.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Adicionando...';
                
                fetch("{{ route('carrinho.adicionar') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ amostra_id: amostraId })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text().then(text => {
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            throw new Error('Resposta não é um JSON válido');
                        }
                    });
                })
                .then(data => {
                    if(data.success) {
                        // Atualiza o contador do carrinho
                        if (carrinhoContador && data.total_itens) {
                            carrinhoContador.textContent = data.total_itens;
                        }
                        
                        // Mostra o indicador do carrinho
                        if (carrinhoIndicador) {
                            carrinhoIndicador.classList.remove('d-none');
                        }
                        
                        // Deixa o botão permanentemente como "Adicionado" e desabilitado
                        btnElement.disabled = true;
                        btnElement.classList.remove('btn-primary');
                        btnElement.classList.add('btn-success');
                        btnElement.innerHTML = '<i class="fa-solid fa-check me-2"></i>Adicionado';
                        
                        // Exibe mensagem de sucesso
                        alert('Amostra adicionada ao carrinho com sucesso!');
                    } else {
                        btnElement.disabled = false;
                        btnElement.innerHTML = '<i class="fa-solid fa-cart-plus me-2"></i>Comprar Amostra';
                        alert('Erro ao adicionar ao carrinho: ' + (data.message || 'Erro desconhecido'));
                    }
                })
                .catch(error => {
                    btnElement.disabled = false;
                    btnElement.innerHTML = '<i class="fa-solid fa-cart-plus me-2"></i>Comprar Amostra';
                    alert('Erro ao adicionar ao carrinho: ' + error.message);
                });
            });
        });

        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    
    function showPhoto(photoUrl) {
        document.getElementById('modalPhoto').src = photoUrl;
    }
</script>
@endpush
