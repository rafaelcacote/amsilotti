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
                            <form action="{{ route('imoveis.store') }}" method="POST">
                                @csrf

                                <!-- Seção: Endereço do Imóvel -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Endereço do
                                        Imóvel</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="endereco" class="form-label">Endereço</label>
                                                <input type="text"
                                                    class="form-control @error('endereco') is-invalid @enderror"
                                                    id="endereco" name="endereco" value="{{ old('endereco') }}" required>
                                                @error('endereco')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="bairro_id" class="form-label">Bairro</label>
                                                <select class="form-select @error('bairro_id') is-invalid @enderror"
                                                    id="bairro_id" name="bairro_id">
                                                    <option value="">Selecione o Bairro</option>
                                                    <!-- Opções do bairro aqui -->
                                                </select>
                                                @error('bairro_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="zona" class="form-label">Zona</label>
                                                <select class="form-select @error('zona') is-invalid @enderror"
                                                    id="zona" name="zona">
                                                    <option value="">Selecione a Zona</option>
                                                    <!-- Opções da zona aqui -->
                                                </select>
                                                @error('zona')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="tipo" class="form-label">Tipo</label>
                                                <select class="form-select @error('tipo') is-invalid @enderror"
                                                    id="tipo" name="tipo">
                                                    <option value="">Selecione o Tipo</option>
                                                    <option value="terreno">Terreno</option>
                                                    <option value="imovel_urbano">Imóvel Urbano</option>
                                                    <option value="galpao">Galpão</option>
                                                </select>
                                                @error('tipo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="pgm" class="form-label">PGM</label>
                                                <input type="text"
                                                    class="form-control @error('pgm') is-invalid @enderror" id="pgm"
                                                    name="pgm" value="{{ old('pgm') }}">
                                                @error('pgm')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="via_especifica_id" class="form-label">Via Específica</label>
                                                <select class="form-select @error('via_especifica_id') is-invalid @enderror"
                                                    id="via_especifica_id" name="via_especifica_id">
                                                    <option value="">Selecione a Via Específica</option>
                                                    <!-- Opções da via específica aqui -->
                                                </select>
                                                @error('via_especifica_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="latitude" class="form-label">Latitude</label>
                                                <input type="text"
                                                    class="form-control @error('latitude') is-invalid @enderror"
                                                    id="latitude" name="latitude" value="{{ old('latitude') }}">
                                                @error('latitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
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
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-landmark me-2"></i>Dados do Terreno
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="area_total" class="form-label">Área Total</label>
                                                <input type="text"
                                                    class="form-control @error('area_total') is-invalid @enderror"
                                                    id="area_total" name="area_total" value="{{ old('area_total') }}">
                                                @error('area_total')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="formato" class="form-label">Formato</label>
                                                <input type="text"
                                                    class="form-control @error('formato') is-invalid @enderror"
                                                    id="formato" name="formato" value="{{ old('formato') }}">
                                                @error('formato')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="topografia" class="form-label">Topografia</label>
                                                <select class="form-select @error('topografia') is-invalid @enderror"
                                                    id="topografia" name="topografia">
                                                    <option value="">Selecione a Topografia</option>
                                                    <option value="caido_fundo_5">Caído para Fundo de 5%</option>
                                                    <option value="caido_fundo_10">Caído para Fundo de 10%</option>
                                                    <option value="aclive_10">Em Aclive 10%</option>
                                                    <option value="aclive_20">Em Aclive 20%</option>
                                                    <option value="abaixo_nivel_1m">Abaixo do Nível da Rua 1M</option>
                                                    <option value="abaixo_nivel_1_2_5m">Abaixo do Nível da Rua 1 à 2.50M
                                                    </option>
                                                    <option value="acima_nivel_2m">Acima do Nível da Rua até 2M</option>
                                                    <option value="acima_nivel_2_4m">Acima do Nível da Rua 2M até 4M
                                                    </option>
                                                </select>
                                                @error('topografia')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="posicao_na_quadra" class="form-label">Posição na
                                                    Quadra</label>
                                                <input type="text"
                                                    class="form-control @error('posicao_na_quadra') is-invalid @enderror"
                                                    id="posicao_na_quadra" name="posicao_na_quadra"
                                                    value="{{ old('posicao_na_quadra') }}">
                                                @error('posicao_na_quadra')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="topologia" class="form-label">Topologia</label>
                                                <select class="form-select @error('topologia') is-invalid @enderror"
                                                    id="topologia" name="topologia">
                                                    <option value="">Selecione a Topologia</option>
                                                    <option value="superficie_seca">Superfície Seca</option>
                                                    <option value="superficie_alagada">Superfície Permanentemente Alagada
                                                    </option>
                                                    <option value="superficie_brejosa">Superfície Brejosa</option>
                                                </select>
                                                @error('topologia')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Dados da Construção -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-building me-2"></i>Dados da Construção
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="padrao" class="form-label">Padrão</label>
                                                <select class="form-select @error('padrao') is-invalid @enderror"
                                                    id="padrao" name="padrao">
                                                    <option value="">Selecione o Padrão</option>
                                                    <option value="simples">Simples</option>
                                                    <option value="medio">Médio</option>
                                                    <option value="fino">Fino</option>
                                                </select>
                                                @error('padrao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="area_construida" class="form-label">Área Construída</label>
                                                <input type="text"
                                                    class="form-control @error('area_construida') is-invalid @enderror"
                                                    id="area_construida" name="area_construida"
                                                    value="{{ old('area_construida') }}">
                                                @error('area_construida')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="benfeitoria" class="form-label">Benfeitoria</label>
                                                <textarea class="form-control @error('benfeitoria') is-invalid @enderror" id="benfeitoria" name="benfeitoria">{{ old('benfeitoria') }}</textarea>
                                                @error('benfeitoria')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="estado_conservacao" class="form-label">Estado de
                                                    Conservação</label>
                                                <select
                                                    class="form-select @error('estado_conservacao') is-invalid @enderror"
                                                    id="estado_conservacao" name="estado_conservacao">
                                                    <option value="">Selecione o Estado de Conservação</option>
                                                    <option value="bom">Bom – 0,00</option>
                                                    <option value="muito_bom">Muito Bom – 0,32</option>
                                                    <option value="otimo">Ótimo – 2,52</option>
                                                    <option value="intermediario">Intermediário – 8,09</option>
                                                    <option value="regular">Regular – 18,10</option>
                                                    <option value="deficiente">Deficiente – 33,20</option>
                                                    <option value="mau">Mau – 52,60</option>
                                                    <option value="muito_mau">Muito Mau – 75,20</option>
                                                    <option value="demolicao">Demolição – 100,00</option>
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
                                                <label for="acessibilidade" class="form-label">Acessibilidade</label>
                                                <select class="form-select @error('acessibilidade') is-invalid @enderror"
                                                    id="acessibilidade" name="acessibilidade">
                                                    <option value="">Selecione a Acessibilidade</option>
                                                    <option value="conducao_direta">Condução Direta</option>
                                                    <option value="conducao_menos_1000m">Condução a Menos de 1.000M
                                                    </option>
                                                </select>
                                                @error('acessibilidade')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Dados Econômicos -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-coins me-2"></i>Dados Econômicos</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="modalidade" class="form-label">Modalidade</label>
                                                <input type="text"
                                                    class="form-control @error('modalidade') is-invalid @enderror"
                                                    id="modalidade" name="modalidade" value="{{ old('modalidade') }}">
                                                @error('modalidade')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="valor_total_imovel" class="form-label">Valor Total do
                                                    Imóvel</label>
                                                <input type="text"
                                                    class="form-control @error('valor_total_imovel') is-invalid @enderror"
                                                    id="valor_total_imovel" name="valor_total_imovel"
                                                    value="{{ old('valor_total_imovel') }}">
                                                @error('valor_total_imovel')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="valor_construcao" class="form-label">Valor da
                                                    Construção</label>
                                                <input type="text"
                                                    class="form-control @error('valor_construcao') is-invalid @enderror"
                                                    id="valor_construcao" name="valor_construcao"
                                                    value="{{ old('valor_construcao') }}">
                                                @error('valor_construcao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="valor_terreno" class="form-label">Valor do Terreno</label>
                                                <input type="text"
                                                    class="form-control @error('valor_terreno') is-invalid @enderror"
                                                    id="valor_terreno" name="valor_terreno"
                                                    value="{{ old('valor_terreno') }}">
                                                @error('valor_terreno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="fator_oferta" class="form-label">Fator de Oferta</label>
                                                <input type="text"
                                                    class="form-control @error('fator_oferta') is-invalid @enderror"
                                                    id="fator_oferta" name="fator_oferta"
                                                    value="{{ old('fator_oferta') }}">
                                                @error('fator_oferta')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="preco_unitario" class="form-label">Preço Unitário</label>
                                                <input type="text"
                                                    class="form-control @error('preco_unitario') is-invalid @enderror"
                                                    id="preco_unitario" name="preco_unitario"
                                                    value="{{ old('preco_unitario') }}">
                                                @error('preco_unitario')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Fonte de Informação -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Fonte de
                                        Informação</h5>
                                    <div class="row">
                                        <div class="col-md-6">
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
                                    </div>
                                </div>

                                <!-- Seção: Fotos do Imóvel -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-camera me-2"></i>Fotos do Imóvel</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="fotos_imovel" class="form-label">Fotos do Imóvel</label>
                                                <input type="file"
                                                    class="form-control @error('fotos_imovel') is-invalid @enderror"
                                                    id="fotos_imovel" name="fotos_imovel[]" multiple>
                                                @error('fotos_imovel')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
@endsection
