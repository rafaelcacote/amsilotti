@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <!-- Título da Página -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                        <h3 class="mb-0 text-primary">
                            <i class="fas fa-map-marked-alt me-2"></i>Visualizar Imóvel
                        </h3>
                        <div class="d-flex gap-2">
                            <a href="{{ route('imoveis.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Voltar
                            </a>
                            <button onclick="window.print()" class="btn btn-outline-primary">
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
                        <div class="mb-5">
                            <h5 class="text-primary mb-4">
                                <i class="fas fa-house me-2"></i>Tipo do Imóvel
                            </h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Tipo</strong>
                                    @if ($imovel->tipo == 'terreno')
                                    <p>Terreno</p>
                                    @elseif ($imovel->tipo == 'apartamento')
                                    <p>Apartamento</p>
                                    @elseif ($imovel->tipo == 'imovel_urbano')
                                    <p>Imóvel Urbano</p>
                                    @elseif ($imovel->tipo == 'galpao')
                                    <p>Galpão</p>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <!-- Seção: Endereço e Coordenadas -->
                        <div class="mb-5">
                            <h5 class="text-primary mb-4">
                                <i class="fas fa-map-marker-alt me-2"></i>Endereço e Localização
                            </h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Endereço</strong>
                                    <p>{{ $imovel->endereco }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Número</strong>
                                    <p>{{ $imovel->numero }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Bairro</strong>
                                    <p>{{ $imovel->bairro->nome }}</p>
                                </div>
                                <div class="col-md-2">
                                    <strong>Zona</strong>
                                    <p>{{ $imovel->zona->nome }}</p>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <strong>Latitude</strong>
                                    <p>{{ $imovel->latitude }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Longitude</strong>
                                    <p>{{ $imovel->longitude }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>PGM</strong>
                                    <p>{{ $imovel->pgm }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Seção: Dados do Terreno -->
                        @if($imovel->tipo != 'apartamento')
                        <div class="mb-5">
                            <h5 class="text-primary mb-4">
                                <i class="fas fa-landmark me-2"></i>Dados do Terreno
                            </h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Área Total</strong>
                                    <p>{{ $imovel->area_total }}m²</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Formato</strong>
                                    <p>{{ $imovel->formato }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Posição na Quadra</strong>
                                    <p>{{ $imovel->posicao_na_quadra }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Frente</strong>
                                    <p>{{ $imovel->frente }}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <strong>Prof. Equiv</strong>
                                    <p>{{ $imovel->profundidade_equiv }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Topologia</strong>
                                    <p>{{ $imovel->topologia }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Topografia</strong>
                                    <p>{{ $imovel->topografia }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Seção: Dados da Construção -->
                        @if($imovel->tipo != 'terreno')
                        <div class="mb-5">
                            <h5 class="text-primary mb-4">
                                <i class="fas fa-building me-2"></i>Dados da Construção
                            </h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Padrão</strong>
                                    <p>{{ $imovel->padrao }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Área Construída</strong>
                                    <p>{{ $imovel->area_construida }}m²</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Idade Aparente</strong>
                                    <p>{{ $imovel->idade_aparente }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Estado de Conservação</strong>
                                    <p>{{ $imovel->estado_conservacao }}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <strong>Benfeitoria</strong>
                                    <p>{{ $imovel->benfeitoria }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Acessibilidade</strong>
                                    <p>{{ $imovel->acessibilidade }}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <strong>Descrição do Imóvel</strong>
                                    <p>{{ $imovel->descricao_imovel }}</p>
                                </div>
                            </div>
                            @if($imovel->tipo == 'apartamento')
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <strong>Andar</strong>
                                    <p>{{ $imovel->andar }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Idade do Prédio</strong>
                                    <p>{{ $imovel->idade_predio }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Quantidade de Suítes</strong>
                                    <p>{{ $imovel->quantidade_suites }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Seção: Dados Econômicos -->
                        <div class="mb-5">
                            <h5 class="text-primary mb-4">
                                <i class="fas fa-coins me-2"></i>Dados Econômicos
                            </h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Modalidade</strong>
                                    <p>{{ $imovel->modalidade }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Valor Total do Imóvel</strong>
                                    <p>{{ $imovel->valor_total_imovel }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Valor da Construção</strong>
                                    <p>{{ $imovel->valor_construcao }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Valor do Terreno</strong>
                                    <p>{{ $imovel->valor_terreno }}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <strong>Preço Unitário 1</strong>
                                    <p>{{ $imovel->preco_unitario1 }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Preço Unitário 2</strong>
                                    <p>{{ $imovel->preco_unitario2 }}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Preço Unitário 3</strong>
                                    <p>{{ $imovel->preco_unitario3 }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Seção: Fonte de Informação -->
                        <div class="mb-5">
                            <h5 class="text-primary mb-4">
                                <i class="fas fa-info-circle me-2"></i>Fonte de Informação
                            </h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Fonte de Informação</strong>
                                    <p>{{ $imovel->fonte_informacao }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Contato</strong>
                                    <p>{{ $imovel->contato }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Link</strong>
                                    <p>{{ $imovel->link }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Seção: Fotos do Imóvel -->
                        <div class="mb-5">
                            <h5 class="text-primary mb-4">
                                <i class="fas fa-camera me-2"></i>Fotos do Imóvel
                            </h5>
                            <div class="row">
                                @foreach($imovel->fotos as $foto)
                                <div class="col-md-3 mb-3">
                                    <img src="{{ asset('storage/' . $foto->caminho) }}" class="img-fluid rounded" alt="Foto do Imóvel">
                                    <p><strong>Descrição:</strong> {{ $foto->descricao }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Botão Voltar -->
                        <div class="d-flex justify-content-end mt-4 gap-2">
                            <a href="{{ route('imoveis.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Voltar
                            </a>
                            <button onclick="window.print()" class="btn btn-outline-primary">
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