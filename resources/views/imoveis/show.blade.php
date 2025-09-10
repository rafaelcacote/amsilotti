@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <!-- Título da Página -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary">
                                <i class="fas fa-map-marked-alt me-2"></i>Visualizar Imóvel
                            </h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('imoveis.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Voltar
                                </a>
                                
                                <a href="{{ route('imoveis.edit', $imovel->id) }}" class="btn btn-outline-warning">
                                    <i class="fas fa-edit me-2"></i>Editar
                                </a>
                                <button onclick="window.open('{{ route('gerar.pdf', $imovel->id) }}', '_blank')"
                                    class="btn btn-outline-primary" data-coreui-toggle="tooltip" data-coreui-placement="top"
                                    title="Imprimir Amostra">
                                    <i class="fas fa-print me-2"></i>Imprimir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conteúdo Principal -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">

                            <!-- Seção: Tipo do Imóvel -->
                            <div class="mb-6">
                                <h5 class="text-primary mb-3"><i class="fas fa-house me-2"></i>Tipo do Imóvel</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Tipo</strong>
                                        <p>{{ ucfirst(str_replace('_', ' ', $imovel->tipo)) }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Fator de Fundamentação</strong>
                                        <div class="d-flex align-items-center gap-2">
                                            <p class="mb-0">{{ $imovel->fator_fundamentacao ?? '-' }}</p>
                                        
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <!-- Seção: Endereço do Imóvel -->
                            <div class="mb-4">
                                <h5 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Endereço do Imóvel
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Endereço</strong>
                                        <p>{{ $imovel->endereco }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Número</strong>
                                        <p>{{ $imovel->numero }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <strong>Bairro / Zona</strong>
                                        <p>{{ $imovel->bairro->nome ?? '-' }} / {{ $imovel->bairro->zona->nome ?? '-' }}</p>
                                    </div>
                                    <!-- <div class="col-md-2">
                                        <strong>Zona</strong>
                                        <p>{{ $imovel->zona->nome ?? 'N/A' }}</p>
                                    </div> -->
                                    @if ($imovel->via_especifica_id)
                                        <div class="col-md-4">
                                            <strong>Via Específica</strong>
                                            <p>{{ $imovel->viaEspecifica->nome ?? 'N/A' }}</p>
                                        </div>
                                    @endif
                                    <div class="col-md-2">
                                        <strong>PGM</strong>
                                        <p>{{ $imovel->bairro->valor_pgm }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Latitude</strong>
                                        <p>{{ $imovel->latitude }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Longitude</strong>
                                        <p>{{ $imovel->longitude }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Localização do Imovel</strong>
                                        <div class="d-flex align-items-center gap-2">
                                           @if($imovel->latitude && $imovel->longitude)
                                                @php
                                                    // Substitui vírgula por ponto nas coordenadas
                                                    $latitude = str_replace(',', '.', $imovel->latitude);
                                                    $longitude = str_replace(',', '.', $imovel->longitude);
                                                @endphp
                                                <button onclick="window.open('https://www.google.com/maps?q={{ $latitude }},{{ $longitude }}', '_blank')" 
                                                    class="btn btn-sm btn-outline-primary" 
                                                    title="Ver no Google Maps">
                                                    <i class="fas fa-map-marked-alt"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Seção: Dados do Terreno (mostrar apenas se for terreno) -->
                            @if ($imovel->tipo == 'terreno')
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-landmark me-2"></i>DADOS DO TERRENO</h5>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong>Área Total</strong>
                                            <p>{{ number_format($imovel->area_total, 2, ',', '.') }} m²</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Benfeitoria</strong>
                                            <p>{{ ucfirst($imovel->benfeitoria) }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Posição na Quadra</strong>
                                            <p>{{ ucfirst(str_replace('_', ' ', $imovel->posicao_na_quadra)) }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Topologia</strong>
                                            <p>{{ $imovel->topologia }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Frente</strong>
                                            <p>{{ $imovel->frente }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Prof. Equiv</strong>
                                            <p>{{ $imovel->profundidade_equiv }}</p>
                                        </div>
                                         <div class="col-md-2">
                                            <strong>Tipologia</strong>
                                            <p>{{ $imovel->tipologia }}</p>
                                        </div>
                                         <div class="col-md-2">
                                            <strong>Marina</strong>
                                                <p>
                                                    @if($imovel->marina === 1 || $imovel->marina === '1')
                                                        <span class="badge bg-success">Sim</span>
                                                    @elseif($imovel->marina === 0 || $imovel->marina === '0')
                                                        <span class="badge bg-danger">Não</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Seção: Dados da Construção (Apartamento) -->
                            @if ($imovel->tipo == 'apartamento')
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-building me-2"></i>DADOS DA CONSTRUÇÃO</h5>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong>Área Util</strong>
                                            <p>{{ number_format($imovel->area_construida, 2, ',', '.') }} m²</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Mobiliado</strong>
                                            <p>{{ ucfirst($imovel->mobiliado) }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>{{ $imovel->banheiros == 1 ? 'Banheiro' : 'Banheiros' }}</strong>
                                            <p>{{ $imovel->banheiros }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Gerador Energia</strong>
                                            <p>{{ $imovel->gerador }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Padrão Construtivo</strong>
                                            <p>{{ ucfirst($imovel->padrao) }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Estado Conservação</strong>
                                            <p>{{ ucfirst(str_replace('_', ' ', $imovel->estado_conservacao)) }}</p>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2">
                                            <strong>Andar</strong>
                                            <p>{{ $imovel->andar }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Idade do Prédio</strong>
                                            <p>{{ $imovel->idade_predio }} anos</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>{{ $imovel->quantidade_suites == 1 ? 'Quant. Suíte' : 'Quant. Suítes' }}</strong>
                                            <p>{{ $imovel->quantidade_suites }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Vagas de Garagem</strong>
                                            <p>{{ $imovel->vagas_garagem }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Area de Lazer</strong>
                                            <p>{{ $imovel->area_lazer }}</p>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <strong>Descrição do Imóvel</strong>
                                            <p>{{ $imovel->descricao_imovel }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Seção: Dados da Construção (imovel_urbano) -->
                            @if ($imovel->tipo == 'imovel_urbano')
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-building me-2"></i>DADOS DA CONSTRUÇÃO</h5>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong>Área Construída</strong>
                                            <p>{{ number_format($imovel->area_construida, 2, ',', '.') }} m²</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Benfeitoria</strong>
                                            <p>{{ ucfirst($imovel->benfeitoria) }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Posição na Quadra</strong>
                                            <p>{{ $imovel->posicao_na_quadra }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Topologia</strong>
                                            <p>{{ $imovel->topologia }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Padrão Construtivo</strong>
                                            <p>{{ ucfirst($imovel->padrao) }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Estado Conservação</strong>
                                            <p>{{ ucfirst(str_replace('_', ' ', $imovel->estado_conservacao)) }}</p>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <strong>Descrição do Imóvel</strong>
                                            <p>{{ $imovel->descricao_imovel }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Seção: Dados da Construção (galpao) -->
                            @if ($imovel->tipo == 'galpao')
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-building me-2"></i>DADOS DA CONSTRUÇÃO</h5>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong>Área Construída</strong>
                                            <p>{{ number_format($imovel->area_construida, 2, ',', '.') }} m²</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Benfeitoria</strong>
                                            <p>{{ ucfirst($imovel->benfeitoria) }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Posição na Quadra</strong>
                                            <p>{{ $imovel->posicao_na_quadra }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Topologia</strong>
                                            <p>{{ $imovel->topologia }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Padrão Construtivo</strong>
                                            <p>{{ ucfirst($imovel->padrao) }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Estado Conservação</strong>
                                            <p>{{ ucfirst(str_replace('_', ' ', $imovel->estado_conservacao)) }}</p>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <strong>Descrição do Imóvel</strong>
                                            <p>{{ $imovel->descricao_imovel }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Seção: Dados da Construção (sala_comercial) -->
                            @if ($imovel->tipo == 'sala_comercial')
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-building me-2"></i>DADOS DA CONSTRUÇÃO</h5>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong>Área Util</strong>
                                            <p>{{ number_format($imovel->area_construida, 2, ',', '.') }} m²</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Mobiliado</strong>
                                            <p>{{ ucfirst($imovel->mobiliado) }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Banheiros</strong>
                                            <p>{{ $imovel->banheiros }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Gerador</strong>
                                            <p>{{ $imovel->gerador }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Padrão Construtivo</strong>
                                            <p>{{ ucfirst($imovel->padrao) }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Estado Conservação</strong>
                                            <p>{{ ucfirst(str_replace('_', ' ', $imovel->estado_conservacao)) }}</p>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <strong>Vagas Garagem</strong>
                                            <p>{{ ucfirst($imovel->vagas_garagem) }}</p>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <strong>Descrição do Imóvel</strong>
                                            <p>{{ $imovel->descricao_imovel }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Seção: Dados Econômicos -->
                            <div class="mb-4">
                                <h5 class="text-primary mb-3"><i class="fas fa-coins me-2"></i>Dados Econômicos</h5>
                                <div class="row">
                                    <div class="col-md-2">
                                        <strong>Valor Total</strong>
                                        <p>R$ {{ number_format($imovel->valor_total_imovel, 2, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <strong>Fator Oferta</strong>
                                        <p>{{ $imovel->fator_oferta }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Preço Unitário</strong>
                                        <p>R$ {{ number_format($imovel->preco_unitario1, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Seção: Fonte de Informação -->
                            <div class="mb-4">
                                <h5 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Fonte de Informação
                                </h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Fonte</strong>
                                        <p>{{ $imovel->fonte_informacao }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Contato</strong>
                                        <p>{{ $imovel->contato }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Link</strong>
                                        @if ($imovel->link)
                                            <a href="{{ $imovel->link }}"
                                                target="_blank">{{ Str::limit($imovel->link, 30) }}</a>
                                        @else
                                            <p>N/A</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Seção: Fotos do Imóvel -->
                            <div class="mb-4">
                                <h5 class="text-primary mb-3"><i class="fas fa-camera me-2"></i>Fotos do Imóvel</h5>
                                <div class="row">
                                    @forelse($imovel->fotos as $foto)
                                        <div class="col-md-3 mb-3">
                                            <img src="{{ asset('storage/' . $foto->caminho) }}" class="img-thumbnail"
                                                style="height: 200px; width: 100%; object-fit: cover;">
                                            <p class="mt-2"><small>{{ $foto->descricao }}</small></p>
                                        </div>
                                    @empty
                                        <div class="col-md-12">
                                            <p>Nenhuma foto cadastrada para este imóvel</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Botões de Ação -->
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('imoveis.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Voltar </a>
                                 <a href="{{ route('imoveis.edit', $imovel->id) }}" class="btn btn-outline-warning">
                                    <i class="fas fa-edit me-2"></i>Editar
                                </a>
                                <button onclick="window.open('{{ route('gerar.pdf', $imovel->id) }}', '_blank')"
                                    class="btn btn-outline-primary" data-coreui-toggle="tooltip"
                                    data-coreui-placement="top" title="Imprimir Amostra">
                                    <i class="fas fa-print me-2"></i>Imprimir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection