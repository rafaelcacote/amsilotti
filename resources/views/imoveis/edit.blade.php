@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-map-marked-alt me-2"></i>Editar Imóvel</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('imoveis.update', $imovel->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <!-- Seção: Tipo do Imóvel -->
                                <div class="mb-6">
                                    <h5 class="text-primary mb-3"><i class="fas fa-house me-2"></i>Tipo do
                                        Imóvel</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="tipo" class="form-label">Tipo</label>
                                                <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" onchange="toggleSections()">
                                                    <option value="">Selecione o Tipo</option>
                                                    <option value="apartamento" {{ old('tipo', $imovel->tipo) == 'apartamento' ? 'selected' : '' }}>Apartamento</option>
                                                    <option value="imovel_urbano" {{ old('tipo', $imovel->tipo) == 'imovel_urbano' ? 'selected' : '' }}>Imóvel Urbano</option>
                                                    <option value="galpao" {{ old('tipo', $imovel->tipo) == 'galpao' ? 'selected' : '' }}>Galpão</option>
                                                    <option value="terreno" {{ old('tipo', $imovel->tipo) == 'terreno' ? 'selected' : '' }}>Terreno</option>
                                                </select>
                                                @error('tipo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Endereço do Imóvel -->
                                <div class="mb-4" id="endereco-imovel">
                                    <h5 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Endereço do
                                        Imóvel</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="endereco" class="form-label">Endereço</label>
                                                <input type="text"
                                                    class="form-control @error('endereco') is-invalid @enderror"
                                                    id="endereco" name="endereco" value="{{ old('endereco', $imovel->endereco) }}" >
                                                @error('endereco')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="numero" class="form-label">Número</label>
                                                <input type="text"
                                                    class="form-control @error('numero') is-invalid @enderror"
                                                    id="numero" name="numero" value="{{ old('numero', $imovel->numero) }}">
                                                @error('numero')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="bairro_id" class="form-label">Bairro</label>
                                                <select class="form-select @error('bairro_id') is-invalid @enderror" id="bairro_id" name="bairro_id">
                                                    <option value="">Selecione o Bairro</option>
                                                    @foreach ($bairros as $bairro)
                                                        <option value="{{ $bairro->id }}" {{ old('bairro_id', $imovel->bairro_id) == $bairro->id ? 'selected' : '' }}>
                                                            {{ $bairro->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('bairro_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="zona" class="form-label">Zona</label>
                                                <select class="form-select @error('zona_id') is-invalid @enderror" id="zona" name="zona_id">
                                                    <option value="">Selecione a Zona</option>
                                                    @foreach ($zonas as $item)
                                                        <option value="{{ $item->id }}" {{ old('zona_id', $imovel->zona_id) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('zona')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="pgm" class="form-label">PGM</label>
                                                <input type="text" class="form-control @error('pgm') is-invalid @enderror" id="pgm" name="pgm" value="{{ old('pgm', $imovel->pgm) }}">
                                                @error('pgm')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="latitude" class="form-label">Latitude</label>
                                                <input type="text"
                                                    class="form-control @error('latitude') is-invalid @enderror"
                                                    id="latitude" name="latitude" value="{{ old('latitude', $imovel->latitude) }}">
                                                @error('latitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="longitude" class="form-label">Longitude</label>
                                                <input type="text"
                                                    class="form-control @error('longitude') is-invalid @enderror"
                                                    id="longitude" name="longitude" value="{{ old('longitude', $imovel->longitude) }}">
                                                @error('longitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Dados do Terreno -->
                                <div class="mb-4" id="dados-terreno">
                                    <h5 class="text-primary mb-3"><i class="fas fa-landmark me-2"></i>Dados do Terreno
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="area_total" class="form-label">Área Total</label>
                                                <input type="text"
                                                    class="form-control area @error('area_total') is-invalid @enderror"
                                                    id="area_total" name="area_total" value="{{ old('area_total', $imovel->area_total) }}">
                                                @error('area_total')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="formato" class="form-label">Formato</label>
                                                <input type="text"
                                                    class="form-control @error('formato') is-invalid @enderror"
                                                    id="formato" name="formato" value="{{ old('formato', $imovel->formato) }}">
                                                @error('formato')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="posicao_na_quadra" class="form-label">Posição na
                                                    Quadra</label>
                                                <input type="text"
                                                    class="form-control @error('posicao_na_quadra') is-invalid @enderror"
                                                    id="posicao_na_quadra" name="posicao_na_quadra"
                                                    value="{{ old('posicao_na_quadra', $imovel->posicao_na_quadra) }}">
                                                @error('posicao_na_quadra')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="frente" class="form-label">Frente</label>
                                                <input type="text"
                                                    class="form-control @error('frente') is-invalid @enderror"
                                                    id="frente" name="frente"
                                                    value="{{ old('frente', $imovel->frente) }}">
                                                @error('frente')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="profundidade_equiv" class="form-label">Prof. Equiv</label>
                                                <input type="text"
                                                    class="form-control @error('profundidade_equiv') is-invalid @enderror"
                                                    id="profundidade_equiv" name="profundidade_equiv"
                                                    value="{{ old('profundidade_equiv', $imovel->profundidade_equiv) }}">
                                                @error('profundidade_equiv')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="topologia" class="form-label">Topologia</label>
                                                <select class="form-select @error('topologia') is-invalid @enderror" id="topologia" name="topologia">
                                                    <option value="">Selecione a Topologia</option>
                                                    <option value="superficie_seca" {{ old('topologia', $imovel->topologia) == 'superficie_seca' ? 'selected' : '' }}>Superfície Seca</option>
                                                    <option value="superficie_alagada" {{ old('topologia', $imovel->topologia) == 'superficie_alagada' ? 'selected' : '' }}>Superfície Permanentemente Alagada</option>
                                                    <option value="superficie_brejosa" {{ old('topologia', $imovel->topologia) == 'superficie_brejosa' ? 'selected' : '' }}>Superfície Brejosa</option>
                                                </select>
                                                @error('topologia')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="topografia" class="form-label">Topografia</label>

                                                <select class="form-select @error('topografia') is-invalid @enderror" id="topografia" name="topografia">
                                                    <option value="">Selecione a Topografia</option>
                                                    <option value="caido_fundo_5" {{ old('topografia', $imovel->topografia) == 'caido_fundo_5' ? 'selected' : '' }}>Caído para Fundo de 5%</option>
                                                    <option value="caido_fundo_10" {{ old('topografia', $imovel->topografia) == 'caido_fundo_10' ? 'selected' : '' }}>Caído para Fundo de 10%</option>
                                                    <option value="aclive_10" {{ old('topografia', $imovel->topografia) == 'aclive_10' ? 'selected' : '' }}>Em Aclive 10%</option>
                                                    <option value="aclive_20" {{ old('topografia', $imovel->topografia) == 'aclive_20' ? 'selected' : '' }}>Em Aclive 20%</option>
                                                    <option value="abaixo_nivel_1m" {{ old('topografia', $imovel->topografia) == 'abaixo_nivel_1m' ? 'selected' : '' }}>Abaixo do Nível da Rua 1M</option>
                                                    <option value="abaixo_nivel_1_2_5m" {{ old('topografia', $imovel->topografia) == 'abaixo_nivel_1_2_5m' ? 'selected' : '' }}>Abaixo do Nível da Rua 1 à 2.50M</option>
                                                    <option value="acima_nivel_2m" {{ old('topografia', $imovel->topografia) == 'acima_nivel_2m' ? 'selected' : '' }}>Acima do Nível da Rua até 2M</option>
                                                    <option value="acima_nivel_2_4m" {{ old('topografia', $imovel->topografia) == 'acima_nivel_2_4m' ? 'selected' : '' }}>Acima do Nível da Rua 2M até 4M</option>
                                                </select>

                                                @error('topografia')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Dados da Construção -->
                                <div class="mb-4" id="dados-construcao">
                                    <h5 class="text-primary mb-3"><i class="fas fa-building me-2"></i>Dados da Construção
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="padrao" class="form-label">Padrão</label>
                                                <select class="form-select @error('padrao') is-invalid @enderror" id="padrao" name="padrao">
                                                    <option value="">Selecione o Padrão</option>
                                                    <option value="simples" {{ old('padrao', $imovel->padrao) == 'simples' ? 'selected' : '' }}>Simples</option>
                                                    <option value="medio" {{ old('padrao', $imovel->padrao) == 'medio' ? 'selected' : '' }}>Médio</option>
                                                    <option value="fino" {{ old('padrao', $imovel->padrao) == 'fino' ? 'selected' : '' }}>Fino</option>
                                                </select>
                                                @error('padrao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="area_construida" class="form-label">Área Construída</label>
                                                <input type="text"
                                                    class="form-control area @error('area_construida') is-invalid @enderror"
                                                    id="area_construida" name="area_construida"
                                                    value="{{ old('area_construida', $imovel->area_construida) }}">
                                                @error('area_construida')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="idade_aparente" class="form-label"> Idade Aparente</label>
                                                <input type="text"
                                                    class="form-control @error('idade_aparente') is-invalid @enderror"
                                                    id="idade_aparente" name="idade_aparente"
                                                    value="{{ old('idade_aparente', $imovel->idade_aparente) }}">
                                                @error('idade_aparente')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="estado_conservacao" class="form-label">Estado de
                                                    Conservação</label>
                                                    <select class="form-select @error('estado_conservacao') is-invalid @enderror" id="estado_conservacao" name="estado_conservacao">
                                                        <option value="">Selecione o Estado de Conservação</option>
                                                        <option value="bom" {{ old('estado_conservacao', $imovel->estado_conservacao) == 'bom' ? 'selected' : '' }}>Bom – 0,00</option>
                                                        <option value="muito_bom" {{ old('estado_conservacao', $imovel->estado_conservacao) == 'muito_bom' ? 'selected' : '' }}>Muito Bom – 0,32</option>
                                                        <option value="otimo" {{ old('estado_conservacao', $imovel->estado_conservacao) == 'otimo' ? 'selected' : '' }}>Ótimo – 2,52</option>
                                                        <option value="intermediario" {{ old('estado_conservacao', $imovel->estado_conservacao) == 'intermediario' ? 'selected' : '' }}>Intermediário – 8,09</option>
                                                        <option value="regular" {{ old('estado_conservacao', $imovel->estado_conservacao) == 'regular' ? 'selected' : '' }}>Regular – 18,10</option>
                                                        <option value="deficiente" {{ old('estado_conservacao', $imovel->estado_conservacao) == 'deficiente' ? 'selected' : '' }}>Deficiente – 33,20</option>
                                                        <option value="mau" {{ old('estado_conservacao', $imovel->estado_conservacao) == 'mau' ? 'selected' : '' }}>Mau – 52,60</option>
                                                        <option value="muito_mau" {{ old('estado_conservacao', $imovel->estado_conservacao) == 'muito_mau' ? 'selected' : '' }}>Muito Mau – 75,20</option>
                                                        <option value="demolicao" {{ old('estado_conservacao', $imovel->estado_conservacao) == 'demolicao' ? 'selected' : '' }}>Demolição – 100,00</option>
                                                    </select>
                                                @error('estado_conservacao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="benfeitoria" class="form-label">Benfeitoria</label>
                                                <input type="text"
                                                    class="form-control @error('benfeitoria') is-invalid @enderror"
                                                    id="benfeitoria" name="benfeitoria"
                                                    value="{{ old('benfeitoria', $imovel->benfeitoria) }}">
                                                @error('benfeitoria')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="acessibilidade" class="form-label">Acessibilidade</label>
                                                <select class="form-select @error('acessibilidade') is-invalid @enderror" id="acessibilidade" name="acessibilidade">
                                                    <option value="">Selecione a Acessibilidade</option>
                                                    <option value="conducao_direta" {{ old('acessibilidade', $imovel->acessibilidade) == 'conducao_direta' ? 'selected' : '' }}>Condução Direta</option>
                                                    <option value="conducao_menos_1000m" {{ old('acessibilidade', $imovel->acessibilidade) == 'conducao_menos_1000m' ? 'selected' : '' }}>Condução a Menos de 1.000M</option>
                                                </select>
                                                @error('acessibilidade')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="descricao_imovel" class="form-label">Descrição do
                                                    Imóvel</label>
                                                <textarea class="form-control @error('descricao_imovel') is-invalid @enderror" id="descricao_imovel"
                                                    name="descricao_imovel">{{ old('descricao_imovel', $imovel->descricao_imovel) }}</textarea>
                                                @error('descricao_imovel')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Campos específicos para Apartamento -->
                                    <div id="apartamento-campos" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="andar" class="form-label">Andar</label>
                                                    <input type="number"
                                                        class="form-control @error('andar') is-invalid @enderror"
                                                        id="andar" name="andar" value="{{ old('andar', $imovel->andar) }}">
                                                    @error('andar')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="idade_predio" class="form-label">Idade do Prédio</label>
                                                    <input type="number"
                                                        class="form-control @error('idade_predio') is-invalid @enderror"
                                                        id="idade_predio" name="idade_predio" value="{{ old('idade_predio', $imovel->idade_predio) }}">
                                                    @error('idade_predio')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="quatidade_suites" class="form-label">Quantidade de Suítes</label>
                                                    <input type="number"
                                                        class="form-control @error('quatidade_suites') is-invalid @enderror"
                                                        id="quatidade_suites" name="quatidade_suites" value="{{ old('quatidade_suites', $imovel->quatidade_suites) }}">
                                                    @error('quatidade_suites')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Dados Econômicos -->
                                <div class="mb-4" id="dados-economicos">
                                    <h5 class="text-primary mb-3"><i class="fas fa-coins me-2"></i>Dados Econômicos</h5>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="modalidade" class="form-label">Modalidade</label>
                                                <input type="text"
                                                    class="form-control @error('modalidade') is-invalid @enderror"
                                                    id="modalidade" name="modalidade" value="{{ old('modalidade', $imovel->modalidade) }}">
                                                @error('modalidade')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="valor_total_imovel" class="form-label">Valor Total do
                                                    Imóvel</label>
                                                <input type="text"
                                                    class="form-control money @error('valor_total_imovel') is-invalid @enderror"
                                                    id="valor_total_imovel" name="valor_total_imovel"
                                                    value="{{ old('valor_total_imovel', $imovel->valor_total_imovel) }}">
                                                @error('valor_total_imovel')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="valor_construcao" class="form-label">Valor da
                                                    Construção</label>
                                                <input type="text"
                                                    class="form-control money @error('valor_construcao') is-invalid @enderror"
                                                    id="valor_construcao" name="valor_construcao"
                                                    value="{{ old('valor_construcao', $imovel->valor_construcao) }}">
                                                @error('valor_construcao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="valor_terreno" class="form-label">Valor do Terreno</label>
                                                <input type="text"
                                                    class="form-control money @error('valor_terreno') is-invalid @enderror"
                                                    id="valor_terreno" name="valor_terreno"
                                                    value="{{ old('valor_terreno', $imovel->valor_terreno) }}">
                                                @error('valor_terreno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="fator_oferta" class="form-label">Fator de Oferta</label>
                                                <input type="text"
                                                    class="form-control money @error('fator_oferta') is-invalid @enderror"
                                                    id="fator_oferta" name="fator_oferta"
                                                    value="{{ old('fator_oferta', $imovel->fator_oferta) }}">
                                                @error('fator_oferta')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="preco_unitario1" class="form-label">Preço Unitário</label>
                                                <input type="text"
                                                    class="form-control money @error('preco_unitario1') is-invalid @enderror"
                                                    id="preco_unitario1" name="preco_unitario1"
                                                    value="{{ old('preco_unitario1', $imovel->preco_unitario1) }}">
                                                @error('preco_unitario1')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="preco_unitario2" class="form-label">Preço Unitário</label>
                                                <input type="text"
                                                    class="form-control money @error('preco_unitario2') is-invalid @enderror"
                                                    id="preco_unitario2" name="preco_unitario2"
                                                    value="{{ old('preco_unitario2', $imovel->preco_unitario2) }}">
                                                @error('preco_unitario2')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="preco_unitario3" class="form-label">Preço Unitário</label>
                                                <input type="text"
                                                    class="form-control money @error('preco_unitario3') is-invalid @enderror"
                                                    id="preco_unitario3" name="preco_unitario3"
                                                    value="{{ old('preco_unitario3', $imovel->preco_unitario3) }}">
                                                @error('preco_unitario3')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Fonte de Informação -->
                                <div class="mb-4" id="fonte-informacao">
                                    <h5 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Fonte de
                                        Informação</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="fonte_informacao" class="form-label">Fonte de
                                                    Informação</label>
                                                <input type="text"
                                                    class="form-control @error('fonte_informacao') is-invalid @enderror"
                                                    id="fonte_informacao" name="fonte_informacao"
                                                    value="{{ old('fonte_informacao', $imovel->fonte_informacao) }}">
                                                @error('fonte_informacao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="contato" class="form-label">Contato</label>
                                                <input type="text"
                                                    class="form-control @error('contato') is-invalid @enderror"
                                                    id="contato" name="contato"
                                                    value="{{ old('contato', $imovel->contato) }}">
                                                @error('contato')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="link" class="form-label">Link</label>
                                                <input type="text"
                                                    class="form-control @error('link') is-invalid @enderror"
                                                    id="link" name="link"
                                                    value="{{ old('link', $imovel->link) }}">
                                                @error('link')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Fotos do Imóvel -->
                                <div class="mb-4" id="fotos-imovel">
                                    <h5 class="text-primary mb-3"><i class="fas fa-camera me-2"></i>Fotos do Imóvel</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="fotos_imovel" class="form-label">Fotos do Imóvel</label>
                                                <input type="file"
                                                    class="form-control @error('fotos_imovel') is-invalid @enderror"
                                                    id="fotos" name="fotos_imovel[]" multiple accept="image/*">

                                                @error('fotos_imovel')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div id="preview" class="mt-3 row">
                                                @foreach ($imovel->fotos as $foto)
                                                    <div class="col-md-4 mb-3">
                                                        <div class="card h-100">
                                                            <img src="{{ asset('storage/' . $foto->caminho) }}" class="card-img-top img-thumbnail" alt="Foto do Imóvel">
                                                            <div class="card-body">
                                                                <input type="text" name="descricoes_fotos[]" class="form-control mt-2" placeholder="Descrição da foto" value="{{ $foto->descricao }}">
                                                                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removerFoto(this, {{ $foto->id }})">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botões de Ação -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Salvar
                                    </button>
                                    <a href="{{ route('imoveis.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Cancelar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>

    <script>
        function toggleSections() {
            const tipo = document.getElementById('tipo').value || "{{ old('tipo', $imovel->tipo) }}";
            const enderecoImovel = document.getElementById('endereco-imovel');
            const dadosTerreno = document.getElementById('dados-terreno');
            const dadosConstrucao = document.getElementById('dados-construcao');
            const dadosEconomicos = document.getElementById('dados-economicos');
            const fonteInformacao = document.getElementById('fonte-informacao');
            const fotosImovel = document.getElementById('fotos-imovel');
            const apartamentoCampos = document.getElementById('apartamento-campos');

            if (tipo === 'terreno') {
                dadosConstrucao.style.display = 'none';
                dadosTerreno.style.display = 'block';
                apartamentoCampos.style.display = 'none';
            } else if (tipo === 'apartamento') {
                dadosConstrucao.style.display = 'block';
                dadosTerreno.style.display = 'none';
                apartamentoCampos.style.display = 'block';
            } else if (tipo === 'imovel_urbano' || tipo === 'galpao') {
                dadosConstrucao.style.display = 'block';
                dadosTerreno.style.display = 'block';
                apartamentoCampos.style.display = 'none';
            }

            // Todas as seções principais sempre visíveis
            enderecoImovel.style.display = 'block';
            dadosEconomicos.style.display = 'block';
            fonteInformacao.style.display = 'block';
            fotosImovel.style.display = 'block';
        }

        // Inicializar a visibilidade das seções ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            toggleSections();
        });
    </script>

    <script>
        let map;
        let marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644}, // Coordenadas padrão
                zoom: 8
            });

            // Adiciona um listener para quando o usuário digitar a latitude e longitude
            document.getElementById('latitude').addEventListener('input', updateMap);
            document.getElementById('longitude').addEventListener('input', updateMap);
        }

        function updateMap() {
            const latitude = parseFloat(document.getElementById('latitude').value);
            const longitude = parseFloat(document.getElementById('longitude').value);

            if (!isNaN(latitude) && !isNaN(longitude)) {
                const newPos = new google.maps.LatLng(latitude, longitude);

                if (marker) {
                    marker.setPosition(newPos);
                } else {
                    marker = new google.maps.Marker({
                        position: newPos,
                        map: map
                    });
                }

                map.setCenter(newPos);
                map.setZoom(15); // Ajuste o zoom conforme necessário
            }
        }

        window.initMap = initMap;
    </script>

    <script>
        document.getElementById('fotos').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            preview.innerHTML = '';

            const files = event.target.files;

            if (files.length > 10) {
                alert('Você só pode enviar até 10 fotos.');
                event.target.value = '';
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.classList.add('col-md-4', 'mb-3'); // Ajuste o tamanho da coluna conforme necessário

                    const card = document.createElement('div');
                    card.classList.add('card', 'h-100');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('card-img-top', 'img-thumbnail');

                    const cardBody = document.createElement('div');
                    cardBody.classList.add('card-body');

                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = 'descricoes_fotos[]';
                    input.placeholder = 'Descrição da foto';
                    input.classList.add('form-control', 'mt-2');

                    const removeButton = document.createElement('button');
                    removeButton.innerHTML = '<i class="fa-solid fa-trash"></i>'; // Ícone de lixeira
                    removeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'mt-2');
                    removeButton.onclick = function() {
                        preview.removeChild(col);
                    };

                    cardBody.appendChild(input);
                    cardBody.appendChild(removeButton);
                    card.appendChild(img);
                    card.appendChild(cardBody);
                    col.appendChild(card);
                    preview.appendChild(col);
                };

                reader.readAsDataURL(file);
            }
        });

        function removerFoto(button, fotoId) {
            if (confirm('Tem certeza que deseja remover esta foto?')) {
                fetch(`/fotos/${fotoId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.ok) {
                        button.closest('.col-md-4').remove();
                    }
                });
            }
        }
    </script>

    <script>
        // Defina a URL da rota nomeada em uma variável JavaScript
        const bairroDataUrl = "{{ route('getBairroData', ['id' => ':id']) }}";
        $(document).ready(function() {
            $('#bairro_id').change(function() {

                var bairroId = $(this).val();

                if (bairroId) {
                    const url = bairroDataUrl.replace(':id', bairroId);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(data) {
                            // Atualiza o campo Zona (select)
                            $('#zona').val(data.zona_id);

                            // Atualiza o campo PGM (input)
                            $('#pgm').val(data.pgm);
                        },
                        error: function() {
                            alert('Erro ao carregar os dados do bairro.');
                        }
                    });
                } else {
                    // Limpa os campos se nenhum bairro for selecionado
                    $('#zona').val('');
                    $('#pgm').val('');
                }
            });
        });
    </script>
@endsection