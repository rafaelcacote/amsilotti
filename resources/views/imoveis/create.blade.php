@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-map-marked-alt me-2"></i>Novo Imóvel</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('imoveis.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Seção: Tipo do Imóvel -->
                                <div class="mb-6">
                                    <h5 class="text-primary mb-3"><i class="fas fa-house me-2"></i>Tipo do Imóvel</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="tipo" class="form-label">Tipo</label>
                                                <select class="form-select @error('tipo') is-invalid @enderror"
                                                    id="tipo" name="tipo" onchange="toggleSections()">
                                                    <option value="">Selecione o Tipo</option>
                                                    <option value="apartamento"
                                                        {{ old('tipo', $imovel->tipo ?? '') == 'apartamento' ? 'selected' : '' }}>
                                                        Apartamento</option>
                                                    <option value="imovel_urbano"
                                                        {{ old('tipo', $imovel->tipo ?? '') == 'imovel_urbano' ? 'selected' : '' }}>
                                                        Imóvel Urbano</option>
                                                    <option value="galpao"
                                                        {{ old('tipo', $imovel->tipo ?? '') == 'galpao' ? 'selected' : '' }}>
                                                        Galpão</option>
                                                    <option value="sala_comercial"
                                                        {{ old('tipo', $imovel->tipo ?? '') == 'sala_comercial' ? 'selected' : '' }}>
                                                        Sala Comercial</option>
                                                    <option value="terreno"
                                                        {{ old('tipo', $imovel->tipo ?? '') == 'terreno' ? 'selected' : '' }}>
                                                        Terreno</option>
                                                </select>
                                                @error('tipo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="fator_fundamentacao" class="form-label">Fator de
                                                    Fundamentação</label>
                                                <select
                                                    class="form-select @error('fator_fundamentacao') is-invalid @enderror"
                                                    id="fator_fundamentacao" name="fator_fundamentacao">
                                                    <option value="">Selecione o Fator</option>
                                                    <option value="Grau I"
                                                        {{ old('fator_fundamentacao', $imovel->fator_fundamentacao ?? '') == 'Grau I' ? 'selected' : '' }}>
                                                        Grau I</option>
                                                    <option value="Grau II"
                                                        {{ old('fator_fundamentacao', $imovel->fator_fundamentacao ?? '') == 'Grau II' ? 'selected' : '' }}>
                                                        Grau II</option>
                                                    <option value="Grau III"
                                                        {{ old('fator_fundamentacao', $imovel->fator_fundamentacao ?? '') == 'Grau III' ? 'selected' : '' }}>
                                                        Grau III</option>
                                                </select>
                                                @error('fator_fundamentacao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Seção: Endereço do Imóvel -->
                                <div class="mb-4" id="endereco-imovel">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>Endereço do Imóvel
                                    </h5>

                                    <div class="row g-3">
                                        <!-- Endereço (ocupa 8 colunas) -->
                                        <div class="col-12 col-md-8">
                                            <label for="endereco" class="form-label">Endereço</label>
                                            <input type="text"
                                                class="form-control @error('endereco') is-invalid @enderror" id="endereco"
                                                name="endereco" value="{{ old('endereco') }}">
                                            @error('endereco')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Número (ocupa 4 colunas) -->
                                        <div class="col-12 col-md-4">
                                            <label for="numero" class="form-label">Número</label>
                                            <input type="text" class="form-control @error('numero') is-invalid @enderror"
                                                id="numero" name="numero" value="{{ old('numero') }}">
                                            @error('numero')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Bairro -->
                                        <div class="col-12 col-md-2">
                                            <label for="bairro_id" class="form-label">Bairro</label>
                                            <select
                                                class="form-select js-example-basic-single @error('bairro_id') is-invalid @enderror"
                                                id="bairro_id" name="bairro_id">
                                                <option value="">Selecione o Bairro</option>
                                                @foreach ($bairros as $bairro)
                                                    <option value="{{ $bairro->id }}"
                                                        {{ old('bairro_id') == $bairro->id ? 'selected' : '' }}>
                                                        {{ $bairro->nome }}</option>
                                                @endforeach
                                            </select>
                                            @error('bairro_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Zona -->
                                        <div class="col-12 col-md-2">
                                            <label for="zona" class="form-label">Zona</label>
                                            <select class="form-select @error('zona_id') is-invalid @enderror"
                                                id="zona" name="zona_id">
                                                <option value="">Selecione a Zona</option>
                                                @foreach ($zonas as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('zona_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nome }}</option>
                                                @endforeach
                                            </select>
                                            @error('zona_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Via Específica Checkbox -->
                                        <div class="col-12 col-md-2 d-flex align-items-center pt-4">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="via_especifica_checkbox">
                                                <label class="form-check-label" for="via_especifica_checkbox">Via
                                                    Específica</label>
                                            </div>
                                        </div>

                                        <!-- Campo Via Específica -->
                                        <div class="col-12 col-md-3" id="via_especifica_field" style="display: none;">
                                            <label for="via_especifica" class="form-label">Via Específica</label>
                                            <input type="text" class="form-control" id="via_especifica">
                                            <input type="hidden" id="via_especifica_id" name="via_especifica_id">
                                        </div>

                                        <!-- Campo PGM -->
                                        <div class="col-12 col-md-1">
                                            <label for="pgm" class="form-label">PGM</label>
                                            <input type="text" class="form-control @error('pgm') is-invalid @enderror"
                                                id="pgm" name="pgm" value="{{ old('pgm') }}">
                                            @error('pgm')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <!-- Botão -->
                                            <div class="col-auto d-flex align-items-end">
                                                <button type="button" id="verNoMapaBtn" class="btn btn-primary"
                                                    style="height: 38px;">
                                                    <i class="fas fa-map-marked-alt"></i>
                                                </button>
                                            </div>

                                            <!-- Latitude -->
                                            <div class="col-12 col-md-5">
                                                <label for="latitude" class="form-label">Latitude</label>
                                                <input type="text"
                                                    class="form-control @error('latitude') is-invalid @enderror"
                                                    id="latitude" name="latitude" value="{{ old('latitude') }}">
                                                @error('latitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Longitude -->
                                            <div class="col-12 col-md-5">
                                                <label for="longitude" class="form-label">Longitude</label>
                                                <input type="text"
                                                    class="form-control @error('longitude') is-invalid @enderror"
                                                    id="longitude" name="longitude" value="{{ old('longitude') }}">
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
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="area_total" class="form-label">Área Total</label>
                                                <input type="text"
                                                    class="form-control area @error('area_total') is-invalid @enderror"
                                                    id="area_total" name="area_total" value="{{ old('area_total') }}">
                                                @error('area_total')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="benfeitoria_terreno" class="form-label">Benfeitoria</label>
                                                <select class="form-select @error('benfeitoria') is-invalid @enderror"
                                                    id="benfeitoria_terreno" name="benfeitoria">
                                                    <option value="">Selecione</option>
                                                    <option value="Possui"
                                                        {{ old('benfeitoria') == 'Possui' ? 'selected' : '' }}>
                                                        Possui</option>
                                                    <option value="Não Possui"
                                                        {{ old('benfeitoria') == 'Não Possui' ? 'selected' : '' }}>
                                                        Não Possui</option>
                                                </select>
                                                @error('benfeitoria')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="posicao_na_quadra" class="form-label">Posição na
                                                    Quadra</label>
                                                <select
                                                    class="form-select @error('posicao_na_quadra') is-invalid @enderror"
                                                    id="posicao_na_quadra" name="posicao_na_quadra">
                                                    <option value="">Selecione</option>
                                                    <option value="Esquina"
                                                        {{ old('posicao_na_quadra') == 'Esquina' ? 'selected' : '' }}>
                                                        Esquina</option>
                                                    <option value="Meio Quadra"
                                                        {{ old('posicao_na_quadra') == 'Meio Quadra' ? 'selected' : '' }}>
                                                        Meio Quadra</option>
                                                </select>
                                                @error('acessibilidade')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="topologia" class="form-label">Topologia</label>
                                                <select class="form-select @error('topologia') is-invalid @enderror"
                                                    id="topologia" name="topologia">
                                                    <option value="">Selecione</option>
                                                    <option value="Plano"
                                                        {{ old('topologia') == 'Plano' ? 'selected' : '' }}>
                                                        Plano</option>
                                                    <option value="Semi Plano"
                                                        {{ old('topologia') == 'Semi Plano' ? 'selected' : '' }}>
                                                        Semi Plano</option>

                                                </select>
                                                @error('topologia')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="frente" class="form-label">Frente</label>
                                                <input type="text"
                                                    class="form-control @error('frente') is-invalid @enderror"
                                                    id="frente" name="frente" value="{{ old('frente') }}">
                                                @error('frente')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label for="profundidade_equiv" class="form-label">Prof. Equiv</label>
                                                <input type="text"
                                                    class="form-control @error('profundidade_equiv') is-invalid @enderror"
                                                    id="profundidade_equiv" name="profundidade_equiv"
                                                    value="{{ old('profundidade_equiv') }}">
                                                @error('profundidade_equiv')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Seção: Dados da Construção (aparece para todos exceto terreno) -->
                                <div class="mb-4" id="dados-construcao">
                                    <h5 class="text-primary mb-3"><i class="fas fa-building me-2"></i>Dados da Construção
                                    </h5>
                                    <div class="row">
                                        <!-- Área (Construída/Útil) -->
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="area_construida" class="form-label" id="label-area">Área
                                                    Construída</label>
                                                <input type="text"
                                                    class="form-control area @error('area_construida') is-invalid @enderror"
                                                    id="area_construida" name="area_construida"
                                                    value="{{ old('area_construida') }}">
                                                @error('area_construida')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Benfeitoria/Mobiliado -->
                                        <div class="col-md-2">
                                            <div class="mb-3" id="benfeitoria-container">
                                                <label for="benfeitoria" class="form-label">Benfeitoria</label>
                                                <select class="form-select @error('benfeitoria') is-invalid @enderror"
                                                    id="benfeitoria" name="benfeitoria">
                                                    <option value="">Selecione</option>
                                                    <option value="possui"
                                                        {{ old('benfeitoria') == 'possui' ? 'selected' : '' }}>Possui
                                                    </option>
                                                    <option value="nao possui"
                                                        {{ old('benfeitoria') == 'nao possui' ? 'selected' : '' }}>Não
                                                        Possui</option>
                                                </select>
                                                @error('benfeitoria')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3" id="mobiliado-container" style="display: none;">
                                                <label for="mobiliado" class="form-label">Mobiliado</label>
                                                <select class="form-select @error('mobiliado') is-invalid @enderror"
                                                    id="mobiliado" name="mobiliado">
                                                    <option value="">Selecione</option>
                                                    <option value="sim"
                                                        {{ old('mobiliado') == 'sim' ? 'selected' : '' }}>Sim</option>
                                                    <option value="nao"
                                                        {{ old('mobiliado') == 'nao' ? 'selected' : '' }}>Não</option>
                                                    <option value="semi mobiliado"
                                                        {{ old('mobiliado') == 'semi mobiliado' ? 'selected' : '' }}>Semi
                                                        Mobiliado</option>
                                                </select>
                                                @error('mobiliado')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Posição na Quadra/Banheiros -->
                                        <div class="col-md-2">
                                            <div class="mb-3" id="posicao-quadra-container">
                                                <label for="posicao_na_quadra" class="form-label">Posição na
                                                    Quadra</label>
                                                <select
                                                    class="form-select @error('posicao_na_quadra') is-invalid @enderror"
                                                    id="posicao_na_quadra" name="posicao_na_quadra">
                                                    <option value="">Selecione</option>
                                                    <option value="esquina"
                                                        {{ old('posicao_na_quadra') == 'esquina' ? 'selected' : '' }}>
                                                        Esquina</option>
                                                    <option value="meio quadra"
                                                        {{ old('posicao_na_quadra') == 'meio quadra' ? 'selected' : '' }}>
                                                        Meio Quadra</option>
                                                </select>
                                                @error('posicao_na_quadra')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3" id="banheiros-container" style="display: none;">
                                                <label for="banheiros" class="form-label">Banheiros</label>
                                                <input type="number"
                                                    class="form-control @error('banheiros') is-invalid @enderror"
                                                    id="banheiros" name="banheiros" value="{{ old('banheiros') }}">
                                                @error('banheiros')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Topologia -->
                                        <div class="col-md-2">
                                            <div class="mb-3" id="topologia-container">
                                                <label for="topologia" class="form-label">Topologia</label>
                                                <select class="form-select @error('topologia') is-invalid @enderror"
                                                    id="topologia" name="topologia">
                                                    <option value="">Selecione</option>
                                                    <option value="Plano"
                                                        {{ old('topologia') == 'Plano' ? 'selected' : '' }}>Plano</option>
                                                    <option value="Semi Plano"
                                                        {{ old('topologia') == 'Semi Plano' ? 'selected' : '' }}>Semi Plano
                                                    </option>
                                                </select>
                                                @error('topologia')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3" id="gerador-container" style="display: none;">
                                                <label for="gerador" class="form-label">Gerador Energia</label>
                                                <select class="form-select @error('gerador') is-invalid @enderror"
                                                    id="gerador" name="gerador">
                                                    <option value="">Selecione</option>
                                                    <option value="sim"
                                                        {{ old('gerador') == 'sim' ? 'selected' : '' }}>Sim</option>
                                                    <option value="não"
                                                        {{ old('gerador') == 'não' ? 'selected' : '' }}>Não</option>
                                                </select>
                                                @error('gerador')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Padrão Construtivo -->
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="padrao" class="form-label">Padrão Construtivo</label>
                                                <select class="form-select @error('padrao') is-invalid @enderror"
                                                    id="padrao" name="padrao">
                                                    <option value="">Selecione o Padrão</option>
                                                    <option value="simples"
                                                        {{ old('padrao') == 'simples' ? 'selected' : '' }}>Simples</option>
                                                    <option value="medio"
                                                        {{ old('padrao') == 'medio' ? 'selected' : '' }}>Médio</option>
                                                    <option value="fino"
                                                        {{ old('padrao') == 'fino' ? 'selected' : '' }}>Fino</option>
                                                </select>
                                                @error('padrao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Estado de Conservação -->
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="estado_conservacao" class="form-label">Estado de
                                                    Conservação</label>
                                                <select
                                                    class="form-select @error('estado_conservacao') is-invalid @enderror"
                                                    id="estado_conservacao" name="estado_conservacao">
                                                    <option value="">Selecione</option>
                                                    <option value="bom"
                                                        {{ old('estado_conservacao') == 'bom' ? 'selected' : '' }}>Bom –
                                                        0,00</option>
                                                    <option value="muito_bom"
                                                        {{ old('estado_conservacao') == 'muito_bom' ? 'selected' : '' }}>
                                                        Muito Bom – 0,32</option>
                                                    <option value="otimo"
                                                        {{ old('estado_conservacao') == 'otimo' ? 'selected' : '' }}>Ótimo
                                                        – 2,52</option>
                                                    <option value="intermediario"
                                                        {{ old('estado_conservacao') == 'intermediario' ? 'selected' : '' }}>
                                                        Intermediário – 8,09</option>
                                                    <option value="regular"
                                                        {{ old('estado_conservacao') == 'regular' ? 'selected' : '' }}>
                                                        Regular – 18,10</option>
                                                    <option value="deficiente"
                                                        {{ old('estado_conservacao') == 'deficiente' ? 'selected' : '' }}>
                                                        Deficiente – 33,20</option>
                                                    <option value="mau"
                                                        {{ old('estado_conservacao') == 'mau' ? 'selected' : '' }}>Mau –
                                                        52,60</option>
                                                    <option value="muito_mau"
                                                        {{ old('estado_conservacao') == 'muito_mau' ? 'selected' : '' }}>
                                                        Muito Mau – 75,20</option>
                                                    <option value="demolicao"
                                                        {{ old('estado_conservacao') == 'demolicao' ? 'selected' : '' }}>
                                                        Demolição – 100,00</option>
                                                </select>
                                                @error('estado_conservacao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Campos específicos para Apartamento -->
                                    <div id="apartamento-campos" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="andar" class="form-label">Andar</label>
                                                    <input type="number"
                                                        class="form-control @error('andar') is-invalid @enderror"
                                                        id="andar" name="andar" value="{{ old('andar') }}">
                                                    @error('andar')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="idade_predio" class="form-label">Idade do Prédio</label>
                                                    <input type="number"
                                                        class="form-control @error('idade_predio') is-invalid @enderror"
                                                        id="idade_predio" name="idade_predio"
                                                        value="{{ old('idade_predio') }}">
                                                    @error('idade_predio')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="quantidade_suites" class="form-label">Quantidade de
                                                        Suítes</label>
                                                    <input type="number"
                                                        class="form-control @error('quantidade_suites') is-invalid @enderror"
                                                        id="quantidade_suites" name="quantidade_suites"
                                                        value="{{ old('quantidade_suites') }}">
                                                    @error('quantidade_suites')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="vagas_garagem_apartamento" class="form-label">Vagas de
                                                        Garagem</label>
                                                    <input type="number" class="form-control"
                                                        id="vagas_garagem_apartamento" name="vagas_garagem_apartamento">
                                                    @error('vagas_garagem_apartamento')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label d-block">Área de Lazer</label>
                                                    <div class="form-check form-check-inline">
                                                        <input
                                                            class="form-check-input @error('area_lazer') is-invalid @enderror"
                                                            type="radio" name="area_lazer" id="area_lazer_sim"
                                                            value="Sim"
                                                            {{ old('area_lazer') == 'Sim' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="area_lazer_sim">Sim</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input
                                                            class="form-check-input @error('area_lazer') is-invalid @enderror"
                                                            type="radio" name="area_lazer" id="area_lazer_nao"
                                                            value="Não"
                                                            {{ old('area_lazer') == 'Não' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="area_lazer_nao">Não</label>
                                                    </div>
                                                    @error('area_lazer')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Campos específicos para Sala Comercial -->
                                    <div id="sala-comercial-campos" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="vagas_garagem_sala" class="form-label">Vagas de
                                                        Garagem</label>
                                                    <input type="number" class="form-control" id="vagas_garagem_sala"
                                                        name="vagas_garagem_sala">
                                                    @error('vagas_garagem')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="descricao-container" style="display: none;">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="descricao_imovel" class="form-label">Descrição do
                                                    Imóvel</label>
                                                <textarea class="form-control @error('descricao_imovel') is-invalid @enderror" id="descricao_imovel"
                                                    name="descricao_imovel">{{ old('descricao_imovel') }}</textarea>
                                                @error('descricao_imovel')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Dados do Terreno (aparece apenas para terreno) -->
                                <div class="mb-4" id="dados-terreno" style="display: none;">
                                    <h5 class="text-primary mb-3"><i class="fas fa-map me-2"></i>Dados do Terreno</h5>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="area_total" class="form-label">Área Total</label>
                                                <input type="text"
                                                    class="form-control area @error('area_total') is-invalid @enderror"
                                                    id="area_total" name="area_total" value="{{ old('area_total') }}">
                                                @error('area_total')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="benfeitoria_terreno" class="form-label">Benfeitoria</label>
                                                <select
                                                    class="form-select @error('benfeitoria_terreno') is-invalid @enderror"
                                                    id="benfeitoria_terreno" name="benfeitoria_terreno">
                                                    <option value="">Selecione</option>
                                                    <option value="possui"
                                                        {{ old('benfeitoria_terreno') == 'possui' ? 'selected' : '' }}>
                                                        Possui</option>
                                                    <option value="nao possui"
                                                        {{ old('benfeitoria_terreno') == 'nao possui' ? 'selected' : '' }}>
                                                        Não Possui</option>
                                                </select>
                                                @error('benfeitoria_terreno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="posicao_na_quadra_terreno" class="form-label">Posição na
                                                    Quadra</label>
                                                <select
                                                    class="form-select @error('posicao_na_quadra_terreno') is-invalid @enderror"
                                                    id="posicao_na_quadra_terreno" name="posicao_na_quadra_terreno">
                                                    <option value="">Selecione</option>
                                                    <option value="esquina"
                                                        {{ old('posicao_na_quadra_terreno') == 'esquina' ? 'selected' : '' }}>
                                                        Esquina</option>
                                                    <option value="meio quadra"
                                                        {{ old('posicao_na_quadra_terreno') == 'meio quadra' ? 'selected' : '' }}>
                                                        Meio Quadra</option>
                                                </select>
                                                @error('posicao_na_quadra_terreno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="topologia_terreno" class="form-label">Topologia</label>
                                                <select
                                                    class="form-select @error('topologia_terreno') is-invalid @enderror"
                                                    id="topologia_terreno" name="topologia_terreno">
                                                    <option value="">Selecione</option>
                                                    <option value="Plano"
                                                        {{ old('topologia_terreno') == 'Plano' ? 'selected' : '' }}>Plano
                                                    </option>
                                                    <option value="Semi Plano"
                                                        {{ old('topologia_terreno') == 'Semi Plano' ? 'selected' : '' }}>
                                                        Semi Plano</option>
                                                </select>
                                                @error('topologia_terreno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="frente" class="form-label">Frente</label>
                                                <input type="text"
                                                    class="form-control @error('frente') is-invalid @enderror"
                                                    id="frente" name="frente" value="{{ old('frente') }}">
                                                @error('frente')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="profundidade_equivalente" class="form-label">Prof.
                                                    Equiv.</label>
                                                <input type="text"
                                                    class="form-control @error('profundidade_equivalente') is-invalid @enderror"
                                                    id="profundidade_equivalente" name="profundidade_equivalente"
                                                    value="{{ old('profundidade_equivalente') }}">
                                                @error('profundidade_equivalente')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
                                                <label for="valor_total_imovel" class="form-label">Valor Total do
                                                    Imóvel</label>
                                                <input type="text"
                                                    class="form-control money @error('valor_total_imovel') is-invalid @enderror"
                                                    id="valor_total_imovel" name="valor_total_imovel"
                                                    value="{{ old('valor_total_imovel') }}">
                                                @error('valor_total_imovel')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="fator_oferta" class="form-label">Fator de Oferta</label>
                                                <input type="text"
                                                    class="form-control money @error('fator_oferta') is-invalid @enderror"
                                                    id="fator_oferta" name="fator_oferta" value="0,90" readonly>
                                                @error('fator_oferta')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="preco_unitario1" class="form-label">Preço Unitário</label>
                                                <input type="text"
                                                    class="form-control money @error('preco_unitario1') is-invalid @enderror"
                                                    id="preco_unitario1" name="preco_unitario1"
                                                    value="{{ old('preco_unitario1') }}">
                                                @error('preco_unitario1')
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
                                                    value="{{ old('fonte_informacao') }}">
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
                                                    id="contato" name="contato" value="{{ old('contato') }}">
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
                                                    id="link" name="link" value="{{ old('link') }}">
                                                @error('link')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-images me-2"></i>Upload de Imagens (Mínimo 3)
                                    <small id="contador-imagens" class="text-muted">(Faltam 3 imagens)</small>
                                </h5>
                                <!-- Seção: Upload de imagens -->

                                <div class="mb-4" id="upload-imagens">
                                    {{-- <h5 class="text-primary mb-3"><i class="fas fa-images me-2"></i>Upload de Imagens
                                        (Mínimo 3)</h5> --}}

                                    <div class="row" id="imagens-container">
                                        <!-- As miniaturas das imagens serão adicionadas aqui -->
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="imagem_upload" class="form-label">Adicionar Imagem</label>
                                                <input type="file" class="form-control" id="imagem_upload"
                                                    accept="image/*">
                                                <small class="text-muted">Selecione imagens para upload (JPEG, PNG,
                                                    etc.)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="imagens_data" name="imagens_data">
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

    <!-- Modal para seleção de localização no mapa -->
    <div class="modal fade" id="mapaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Selecione a Localização do Imóvel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle me-2"></i> Clique no mapa para selecionar a localização do imóvel
                    </div>
                    <div id="mapPreview" style="height: 400px; width: 100%; background-color: #f8f9fa;"></div>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="modalLatitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="modalLatitude" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="modalLongitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="modalLongitude" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmarLocalizacaoBtn">
                        <i class="fas fa-check me-1"></i> Confirmar Localização
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para visualização do mapa capturado -->
    {{-- <div class="modal fade" id="mapaCapturadoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Visualização do Mapa Capturado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="mapaCapturadoPreview" style="height: 400px; width: 100%;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="usarComoFotoBtn">
                        <i class="fas fa-camera me-1"></i> Usar esta visualização como foto
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div> --}}

    <style>
        #mapPreview {
            min-height: 400px;
            background-color: #f8f9fa;
        }

        .pac-container {
            z-index: 1051 !important;
            /* Para aparecer acima do modal */
        }

        .modal {
            backdrop-filter: none !important;
        }

        #mapaSuccessAlert {
            position: absolute;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 90%;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        #imagens-container .card {
            transition: all 0.3s ease;
        }

        #imagens-container .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        #imagem_upload {
            cursor: pointer;
        }

        #imagem_upload::-webkit-file-upload-button {
            visibility: hidden;
        }

        #imagem_upload::before {
            content: 'Selecionar Imagens';
            display: inline-block;
            background: #0d6efd;
            color: white;
            padding: 8px 12px;
            outline: none;
            white-space: nowrap;
            -webkit-user-select: none;
            cursor: pointer;
            border-radius: 4px;
        }

        #imagem_upload:hover::before {
            background: #0b5ed7;
        }

        #benfeitoria-container,
        #mobiliado-container,
        #posicao-quadra-container,
        #banheiros-container,
        #topologia-container,
        #gerador-energia-container,
        #vagas-garagem-container {
            transition: all 0.3s ease;
        }
    </style>

    {{-- controle de campos dependendo do tipo do imovel  --}}
    <script>
        function toggleSections() {
            const tipo = document.getElementById('tipo').value;
            const dadosTerreno = document.getElementById('dados-terreno');
            const dadosConstrucao = document.getElementById('dados-construcao');
            const apartamentoCampos = document.getElementById('apartamento-campos');
            const salaComercialCampos = document.getElementById('sala-comercial-campos');
            const areaLabel = document.getElementById('label-area');

            // Campos alternados
            const benfeitoriaContainer = document.getElementById('benfeitoria-container');
            const mobiliadoContainer = document.getElementById('mobiliado-container');
            const posicaoQuadraContainer = document.getElementById('posicao-quadra-container');
            const banheirosContainer = document.getElementById('banheiros-container');
            const topologiaContainer = document.getElementById('topologia-container');
            const geradorContainer = document.getElementById('gerador-container');
            const descricaoContainer = document.getElementById('descricao-container');

            // Controle das seções principais
            if (tipo === 'terreno') {
                dadosTerreno.style.display = 'block';
                dadosConstrucao.style.display = 'none';
                apartamentoCampos.style.display = 'none';
                salaComercialCampos.style.display = 'none';
                descricaoContainer.style.display = 'block';
            } else {
                dadosTerreno.style.display = 'none';
                dadosConstrucao.style.display = 'block';

                if (tipo === 'apartamento') {
                    apartamentoCampos.style.display = 'block';
                    salaComercialCampos.style.display = 'none';
                } else if (tipo === 'sala_comercial') {
                    apartamentoCampos.style.display = 'none';
                    salaComercialCampos.style.display = 'block';
                } else {
                    apartamentoCampos.style.display = 'none';
                    salaComercialCampos.style.display = 'none';
                }
            }

            // Controle dos campos comuns
            switch (tipo) {
                case 'apartamento':
                    // Área
                    areaLabel.textContent = 'Área Útil';

                    // Campos alternados
                    benfeitoriaContainer.style.display = 'none';
                    mobiliadoContainer.style.display = 'block';
                    posicaoQuadraContainer.style.display = 'none';
                    banheirosContainer.style.display = 'block';
                    topologiaContainer.style.display = 'none';
                    geradorContainer.style.display = 'block';
                    descricaoContainer.style.display = 'block';
                    break;

                case 'sala_comercial':
                    // Área
                    areaLabel.textContent = 'Área Útil';

                    // Campos alternados
                    benfeitoriaContainer.style.display = 'none';
                    mobiliadoContainer.style.display = 'block';
                    posicaoQuadraContainer.style.display = 'none';
                    banheirosContainer.style.display = 'block';
                    topologiaContainer.style.display = 'none';
                    geradorContainer.style.display = 'block';
                    descricaoContainer.style.display = 'block';
                    break;

                case 'imovel_urbano':
                case 'galpao':
                    // Área
                    areaLabel.textContent = 'Área Construída';

                    // Campos alternados
                    benfeitoriaContainer.style.display = 'block';
                    mobiliadoContainer.style.display = 'none';
                    posicaoQuadraContainer.style.display = 'block';
                    banheirosContainer.style.display = 'none';
                    topologiaContainer.style.display = 'block';
                    geradorContainer.style.display = 'none';
                    descricaoContainer.style.display = 'block';
                    break;

                case 'terreno':
                    // Nada a fazer aqui, os campos do terreno são independentes
                    break;
            }
        }
        // Inicializar ao carregar a página
        document.addEventListener('DOMContentLoaded', toggleSections);
    </script>

    {{-- bairro - zona - pgm --}}
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
                            console.log(data);
                            // Atualiza o campo Zona (select)
                            $('#zona').val(data.zona_id);

                            // Remove qualquer formatação existente e mantém o valor original
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

    {{-- via especifica --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('via_especifica_checkbox');
            const viaEspecificaField = document.getElementById('via_especifica_field');
            const viaEspecificaInput = document.getElementById('via_especifica');
            const viaEspecificaInputId = document.getElementById('via_especifica_id');
            const bairroSelect = document.getElementById('bairro_id');
            const zonaSelect = document.getElementById('zona');
            const pgm = document.getElementById('pgm');

            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    // Exibe o campo Via Específica
                    viaEspecificaField.style.display = 'block';
                    // Limpa o campo PGM
                    pgm.value = '';
                } else {
                    // Oculta o campo Via Específica
                    viaEspecificaField.style.display = 'none';
                    // Limpa os campos de Via Específica
                    viaEspecificaInput.value = '';
                    viaEspecificaInputId.value = '';
                    bairroSelect.value = '';
                    zonaSelect.value = '';

                    pgm.value = '';
                }
            });

            // Autocomplete para Via Específica
            $(document).ready(function() {
                $('#via_especifica').autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('searchViasEspecificas') }}",
                            dataType: 'json',
                            data: {
                                term: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    select: function(event, ui) {
                        $('#via_especifica_id').val(ui.item
                            .via_especifica_id
                        ); // Preenche o campo Via Específica com a descrição
                        $('#pgm').val(ui.item
                            .valor); // Preenche o campo PGM com o valor da via específica
                    }
                });
            });
        });
    </script>

    {{-- Remove a máscara antes de enviar o formulário --}}
    <script>
        $('form').on('submit', function() {
            $('.money').each(function() {
                // Remove pontos de milhares e substitui vírgula por ponto
                var value = $(this).val().replace(/\./g, '').replace(',', '.');
                $(this).val(value);
            });
            $('.area').each(function() {
                var value = $(this).val().replace(/\./g, '').replace(',', '.');
                $(this).val(value);
            });
        });
    </script>

    {{-- pressionar o enter e passar para o proximo campos --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Seleciona todos os campos de entrada no formulário
            const inputs = document.querySelectorAll('input, select, textarea');

            inputs.forEach((input, index) => {
                input.addEventListener('keydown', function(event) {
                    // Verifica se a tecla pressionada foi "Enter"
                    if (event.key === 'Enter') {
                        // Previne o comportamento padrão (submit do formulário)
                        event.preventDefault();

                        // Move o foco para o próximo campo
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    }
                });
            });
        });
    </script>
    <!-- calcula o preço unitario -->
    <script>
        function calcularPrecoUnitario() {
            const tipo = document.getElementById('tipo').value;
            const valorTotalInput = document.getElementById('valor_total_imovel');
            const areaTotalInput = document.getElementById('area_total');
            const areaConstruidaInput = document.getElementById('area_construida');

            // Verificar se todos os campos necessários estão preenchidos
            if (!valorTotalInput.value ||
                (tipo === 'terreno' && !areaTotalInput.value) ||
                ((tipo === 'apartamento' || tipo === 'galpao' || tipo === 'sala_comercial' || tipo === 'imovel_urbano') && !
                    areaConstruidaInput.value)) {
                return; // Não calcular se campos essenciais estiverem vazios
            }

            const valorTotalImovel = parseFloat(valorTotalInput.value.replace(/[^0-9,]/g, '').replace(',', '.'));
            const areaTotal = parseFloat(areaTotalInput.value.replace(/[^0-9,]/g, '').replace(',', '.'));
            const areaConstruida = parseFloat(areaConstruidaInput.value.replace(/[^0-9,]/g, '').replace(',', '.'));
            const fatorOferta = 0.90;

            let precoUnitario = 0;

            if (tipo === 'terreno') {
                if (areaTotal > 0) {
                    precoUnitario = (valorTotalImovel / areaTotal) * fatorOferta;
                }
            } else if (tipo === 'apartamento' || tipo === 'galpao' || tipo === 'sala_comercial' || tipo ===
                'imovel_urbano') {
                if (areaConstruida > 0) {
                    precoUnitario = (valorTotalImovel / areaConstruida) * fatorOferta;
                }
            }

            // Atualizar o campo preco_unitario1 apenas se o cálculo for válido
            if (precoUnitario > 0) {
                document.getElementById('preco_unitario1').value = precoUnitario.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        }

        // Adicionar eventos de blur (quando o campo perde o foco) para os campos relevantes
        document.getElementById('valor_total_imovel').addEventListener('blur', calcularPrecoUnitario);
        document.getElementById('area_total').addEventListener('blur', calcularPrecoUnitario);
        document.getElementById('area_construida').addEventListener('blur', calcularPrecoUnitario);

        // Também recalcular quando o tipo for alterado
        document.getElementById('tipo').addEventListener('change', calcularPrecoUnitario);
    </script>

    <!-- aciona o toast quando o usuario digitar um valor fora do padrão -->
    <script>
        $(document).ready(function() {
            // Monitora os campos específicos de apartamento
            $('#andar, #idade_predio, #quantidade_suites').on('change', function() {
                const field = $(this);
                const value = parseInt(field.val());
                let message = '';

                if (isNaN(value)) return;

                // Verifica cada campo
                if (field.attr('id') === 'andar' && value > 10) {
                    message =
                        'O valor digitado para andar parece ser maior que o comum em prédios. Por favor, verifique.';
                } else if (field.attr('id') === 'idade_predio' && value > 100) {
                    message = 'A idade do prédio parece estar muito alta. Por favor, confira o valor.';
                } else if (field.attr('id') === 'quantidade_suites' && value > 10) {
                    message =
                        'A quantidade de suítes parece estar acima do padrão. Verifique se está correto.';
                }

                // Exibe o toast se houver mensagem
                if (message) {
                    showValidationToast(message);
                }
            });

            function showValidationToast(message) {
                // Implementação do toast - você pode usar Bootstrap Toast ou outra biblioteca
                // Exemplo com Bootstrap:
                const toastHtml = `
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-warning text-dark">
                            <strong class="me-auto">Verificação recomendada</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            ${message}
                        </div>
                    </div>
                </div>`;

                // Adiciona o toast ao corpo do documento
                $('body').append(toastHtml);

                // Remove o toast após 5 segundos
                setTimeout(() => {
                    $('.toast').remove();
                }, 5000);
            }
        });
    </script>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlG0ouFD-X3AknpUDzwpfpzE6tw5LU8ws&callback=initMap" async
        defer></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variáveis globais
            var mapPreview;
            var marker;
            var selectedLocation = null;
            var mapaModal = new bootstrap.Modal(document.getElementById('mapaModal'));
            var verNoMapaBtn = document.getElementById('verNoMapaBtn');
            var latitudeInput = document.getElementById('latitude');
            var longitudeInput = document.getElementById('longitude');
            var modalLatitude = document.getElementById('modalLatitude');
            var modalLongitude = document.getElementById('modalLongitude');
            var confirmarLocalizacaoBtn = document.getElementById('confirmarLocalizacaoBtn');
            var imagemUploadInput = document.getElementById('imagem_upload');
            var imagensContainer = document.getElementById('imagens-container');
            var imagensData = document.getElementById('imagens_data');
            var contadorImagens = document.getElementById('contador-imagens');

            // Array para armazenar as imagens
            var imagens = [];
            const MAX_IMAGENS = 10; // Limite máximo de imagens

            // Inicialização
            init();

            function init() {
                // Habilitar o botão "Ver no Mapa" sempre
                verNoMapaBtn.disabled = false;
                verNoMapaBtn.title = "Selecionar localização no mapa";

                // Configurar eventos
                setupEventListeners();
                atualizarContador();
            }

            function setupEventListeners() {
                // Evento do botão "Ver no Mapa"
                verNoMapaBtn.addEventListener('click', handleVerNoMapaClick);

                // Evento do botão "Confirmar Localização"
                confirmarLocalizacaoBtn.addEventListener('click', handleConfirmarLocalizacaoClick);

                // Evento para upload de imagens
                imagemUploadInput.addEventListener('change', handleImageUpload);
            }

            function handleVerNoMapaClick() {
                if (typeof google === 'undefined' || !google.maps) {
                    alert('A API do Google Maps ainda não foi carregada. Por favor, aguarde e tente novamente.');
                    return;
                }

                let initialLat = -3.0664299592078397;
                let initialLng = -60.00824011052206;
                let initialZoom = 12;

                if (latitudeInput.value && longitudeInput.value) {
                    initialLat = parseFloat(latitudeInput.value.replace(',', '.'));
                    initialLng = parseFloat(longitudeInput.value.replace(',', '.'));
                    initialZoom = 17;
                }

                showMapModal(initialLat, initialLng, initialZoom);
            }

            function handleConfirmarLocalizacaoClick() {
                if (selectedLocation) {
                    showProcessingOverlay();

                    // Atualizar campos no formulário principal
                    latitudeInput.value = selectedLocation.lat().toFixed(6).replace('.', ',');
                    longitudeInput.value = selectedLocation.lng().toFixed(6).replace('.', ',');

                    // Fechar o modal
                    mapaModal.hide();

                    // Capturar o mapa como imagem
                    capturarMapaComoFoto(selectedLocation)
                        .finally(() => {
                            hideProcessingOverlay();
                            resetConfirmarLocalizacaoBtn();
                        });
                }
            }

            function handleImageUpload(e) {
                const files = e.target.files;

                if (files.length > 0) {
                    // Verificar se não excede o limite
                    if (imagens.length + files.length > MAX_IMAGENS) {
                        alert(`Você pode adicionar no máximo ${MAX_IMAGENS} imagens no total.`);
                        return;
                    }

                    // Processar cada arquivo
                    Array.from(files).forEach(file => {
                        if (!file.type.match('image.*')) {
                            alert(`O arquivo ${file.name} não é uma imagem válida.`);
                            return;
                        }

                        const reader = new FileReader();

                        reader.onload = function(e) {
                            // Adicionar a nova imagem ao array
                            imagens.push({
                                data: e.target.result,
                                descricao: file.name.split('.')[0] || 'Imagem ' + (imagens
                                    .length + 1),
                                isMapa: false
                            });

                            // Atualizar a exibição
                            exibirMiniaturas();
                            atualizarImagensData();
                            atualizarContador();
                        };

                        reader.onerror = function() {
                            alert(`Erro ao ler o arquivo ${file.name}.`);
                        };

                        reader.readAsDataURL(file);
                    });

                    // Limpar o input para permitir nova seleção
                    imagemUploadInput.value = '';
                }
            }

            function showProcessingOverlay() {
                const processingOverlay = document.createElement('div');
                processingOverlay.id = 'processing-overlay';
                processingOverlay.style.position = 'fixed';
                processingOverlay.style.top = '0';
                processingOverlay.style.left = '0';
                processingOverlay.style.width = '100%';
                processingOverlay.style.height = '100%';
                processingOverlay.style.backgroundColor = 'rgba(0,0,0,0.7)';
                processingOverlay.style.zIndex = '99998';
                processingOverlay.style.display = 'flex';
                processingOverlay.style.justifyContent = 'center';
                processingOverlay.style.alignItems = 'center';
                processingOverlay.style.flexDirection = 'column';

                processingOverlay.innerHTML = `
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
                <div class="text-white mt-3 fs-5">Processando captura do mapa...</div>
            `;

                document.body.appendChild(processingOverlay);
                confirmarLocalizacaoBtn.disabled = true;
                confirmarLocalizacaoBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processando...';
            }

            function hideProcessingOverlay() {
                const overlay = document.getElementById('processing-overlay');
                if (overlay && overlay.parentNode) {
                    overlay.parentNode.removeChild(overlay);
                }
            }

            function resetConfirmarLocalizacaoBtn() {
                confirmarLocalizacaoBtn.innerHTML = '<i class="fas fa-check me-1"></i> Confirmar Localização';
                confirmarLocalizacaoBtn.disabled = false;
            }

            // Função para mostrar o modal do mapa
            function showMapModal(lat, lng, zoom = 12) {
                var mapOptions = {
                    center: new google.maps.LatLng(lat, lng),
                    zoom: zoom,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: false,
                    styles: [{
                        featureType: "poi",
                        elementType: "labels",
                        stylers: [{
                            visibility: "off"
                        }]
                    }]
                };

                mapPreview = new google.maps.Map(document.getElementById('mapPreview'), mapOptions);

                if (latitudeInput.value && longitudeInput.value) {
                    selectedLocation = new google.maps.LatLng(
                        parseFloat(latitudeInput.value.replace(',', '.')),
                        parseFloat(longitudeInput.value.replace(',', '.'))
                    );

                    marker = new google.maps.Marker({
                        position: selectedLocation,
                        map: mapPreview,
                        title: 'Localização do imóvel',
                        draggable: true
                    });

                    modalLatitude.value = latitudeInput.value;
                    modalLongitude.value = longitudeInput.value;

                    mapPreview.setCenter(selectedLocation);
                    mapPreview.setZoom(17);
                }

                google.maps.event.addListener(mapPreview, 'click', function(event) {
                    if (marker) {
                        marker.setMap(null);
                    }

                    marker = new google.maps.Marker({
                        position: event.latLng,
                        map: mapPreview,
                        title: 'Localização selecionada',
                        draggable: true
                    });

                    selectedLocation = event.latLng;
                    modalLatitude.value = event.latLng.lat().toFixed(6).replace('.', ',');
                    modalLongitude.value = event.latLng.lng().toFixed(6).replace('.', ',');
                    confirmarLocalizacaoBtn.disabled = false;
                });

                if (marker) {
                    google.maps.event.addListener(marker, 'dragend', function(event) {
                        selectedLocation = event.latLng;
                        modalLatitude.value = event.latLng.lat().toFixed(6).replace('.', ',');
                        modalLongitude.value = event.latLng.lng().toFixed(6).replace('.', ',');
                    });
                }

                mapaModal.show();
            }

            // Modificar a função capturarMapaComoFoto para retornar uma Promise
            function capturarMapaComoFoto(location) {
                return new Promise((resolve, reject) => {
                    // Verificar se já existe uma imagem do mapa
                    const mapaIndex = imagens.findIndex(img => img.isMapa);

                    // Criar elemento temporário para o mapa
                    var mapElement = document.createElement('div');
                    mapElement.id = 'temp-map-container';
                    mapElement.style.width = '800px';
                    mapElement.style.height = '600px';
                    mapElement.style.position = 'fixed';
                    mapElement.style.top = '0';
                    mapElement.style.left = '0';
                    mapElement.style.zIndex = '99999';
                    mapElement.style.visibility = 'hidden';
                    document.body.appendChild(mapElement);

                    // Configurações do mapa
                    var mapOptions = {
                        center: location,
                        zoom: 17,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        disableDefaultUI: true,
                        styles: [{
                                featureType: "all",
                                elementType: "labels",
                                stylers: [{
                                    visibility: "on"
                                }]
                            },
                            {
                                featureType: "poi",
                                elementType: "labels",
                                stylers: [{
                                    visibility: "off"
                                }]
                            }
                        ]
                    };

                    // Criar mapa
                    var captureMap = new google.maps.Map(mapElement, mapOptions);

                    // Adicionar marcador
                    new google.maps.Marker({
                        position: location,
                        map: captureMap,
                        title: 'Localização do imóvel'
                    });

                    // Mostrar o elemento antes de capturar
                    mapElement.style.visibility = 'visible';

                    // Esperar para garantir renderização
                    setTimeout(function() {
                        html2canvas(mapElement, {
                            useCORS: true,
                            allowTaint: true,
                            scale: 1,
                            backgroundColor: null
                        }).then(function(canvas) {
                            // Remover elemento temporário
                            document.body.removeChild(mapElement);

                            // Adicionar a imagem automaticamente
                            const imageData = canvas.toDataURL('image/png');

                            if (mapaIndex >= 0) {
                                // Atualizar a imagem do mapa existente
                                imagens[mapaIndex] = {
                                    data: imageData,
                                    descricao: 'Localização do Imóvel',
                                    isMapa: true
                                };
                            } else {
                                // Adicionar como nova imagem do mapa
                                imagens.unshift({
                                    data: imageData,
                                    descricao: 'Localização do Imóvel',
                                    isMapa: true
                                });
                            }

                            exibirMiniaturas();
                            atualizarImagensData();
                            atualizarContador();
                            mostrarMensagemSucesso();
                            resolve();
                        }).catch(function(error) {
                            console.error('Erro ao capturar mapa:', error);
                            document.body.removeChild(mapElement);
                            reject(error);
                        });
                    }, 2000);
                });
            }

            function mostrarMensagemSucesso() {
                // Criar um container mais robusto para o toast
                const toastContainer = document.createElement('div');
                toastContainer.id = 'map-toast-container';
                toastContainer.style.position = 'fixed';
                toastContainer.style.bottom = '20px';
                toastContainer.style.right = '20px';
                toastContainer.style.zIndex = '9999';

                // Conteúdo do toast
                toastContainer.innerHTML = `
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" style="opacity: 1">
                    <div class="toast-header bg-success text-white">
                        <strong class="me-auto">Sucesso</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i> Foto da localização adicionada com sucesso!
                    </div>
                </div>
            `;

                // Adicionar ao body
                document.body.appendChild(toastContainer);

                // Configurar timeout para remoção
                setTimeout(() => {
                    toastContainer.classList.add('fade');
                    setTimeout(() => {
                        if (toastContainer.parentNode) {
                            toastContainer.parentNode.removeChild(toastContainer);
                        }
                    }, 500);
                }, 3000);
            }

            function exibirMiniaturas() {
                imagensContainer.innerHTML = '';

                imagens.forEach((imagem, index) => {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-md-4 mb-3';

                    const cardDiv = document.createElement('div');
                    cardDiv.className = 'card h-100';

                    const img = document.createElement('img');
                    img.src = imagem.data;
                    img.className = 'card-img-top';
                    img.style.height = '200px';
                    img.style.objectFit = 'cover';
                    img.alt = imagem.descricao;

                    const cardBody = document.createElement('div');
                    cardBody.className = 'card-body';

                    const descricaoInput = document.createElement('input');
                    descricaoInput.type = 'text';
                    descricaoInput.className = 'form-control mb-2';
                    descricaoInput.placeholder = 'Descrição da imagem';
                    descricaoInput.value = imagem.descricao || '';
                    descricaoInput.addEventListener('change', (e) => {
                        imagens[index].descricao = e.target.value;
                        atualizarImagensData();
                    });

                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'btn btn-danger btn-sm w-100';
                    removeBtn.innerHTML = '<i class="fas fa-trash me-1"></i> Remover';
                    removeBtn.addEventListener('click', () => {
                        // Não permitir remover a imagem do mapa se for a única imagem
                        if (imagem.isMapa && imagens.filter(img => img.isMapa).length <= 1) {
                            alert('Você precisa manter pelo menos uma imagem do mapa.');
                            return;
                        }

                        imagens.splice(index, 1);
                        exibirMiniaturas();
                        atualizarImagensData();
                        atualizarContador();
                    });

                    cardBody.appendChild(descricaoInput);
                    cardBody.appendChild(removeBtn);

                    cardDiv.appendChild(img);
                    cardDiv.appendChild(cardBody);
                    colDiv.appendChild(cardDiv);

                    imagensContainer.appendChild(colDiv);
                });

                atualizarContador();
            }

            function atualizarImagensData() {
                imagensData.value = JSON.stringify(imagens);
            }

            function atualizarContador() {
                const count = imagens.length;
                const faltam = Math.max(0, 3 - count);

                if (count >= 3) {
                    contadorImagens.textContent = '(Mínimo atingido)';
                    contadorImagens.className = 'text-success';
                } else {
                    contadorImagens.textContent = `(Faltam ${faltam} imagens)`;
                    contadorImagens.className = 'text-danger';
                }
            }
        });
    </script>
@endsection
