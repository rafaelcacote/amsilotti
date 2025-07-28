@extends('layouts.app')

@section('title', 'Consulta de Imóveis')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="row mb-3">
            <div class="col">
                <div class="d-flex align-items-center">
                    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-search me-2"></i>Consulta de Imóveis</h1>
                </div>
                <p class="text-muted mt-2">Bem-vindo ao sistema de consulta do Amsillote. Explore nosso banco de dados de
                    imóveis.</p>
            </div>
        </div>

        <!-- Filtros de Pesquisa -->
        <div class="row mb-4">
            <div class="col-sm-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros de Pesquisa</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('consulta.cliente.index') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label" for="bairro_id">Bairro</label>
                                    <select class="form-select" id="bairro_id" name="bairro_id">
                                        <option value="">Todos os bairros</option>
                                        @foreach ($bairros as $bairro)
                                            <option value="{{ $bairro->id }}"
                                                {{ request('bairro_id') == $bairro->id ? 'selected' : '' }}>
                                                {{ $bairro->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="tipo">Tipo de Imóvel</label>
                                    <select class="form-select" id="tipo" name="tipo">
                                        <option value="">Todos os tipos</option>
                                        <option value="terreno" {{ request('tipo') == 'terreno' ? 'selected' : '' }}>
                                            Terreno</option>
                                        <option value="galpao" {{ request('tipo') == 'galpao' ? 'selected' : '' }}>
                                            Galpão</option>
                                        <option value="apartamento"
                                            {{ request('tipo') == 'apartamento' ? 'selected' : '' }}>Apartamento
                                        </option>
                                        <option value="imovel_urbano"
                                            {{ request('tipo') == 'imovel_urbano' ? 'selected' : '' }}>Imóvel Urbano
                                        </option>
                                        <option value="sala_comercial"
                                            {{ request('tipo') == 'sala_comercial' ? 'selected' : '' }}>Sala Comercial
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label" for="area_min">Área Mínima (m²)</label>
                                    <input type="text" class="form-control" id="area_min" name="area_min"
                                        placeholder="Ex: 100" value="{{ request('area_min') }}">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label" for="area_max">Área Máxima (m²)</label>
                                    <input type="text" class="form-control" id="area_max" name="area_max"
                                        placeholder="Ex: 500" value="{{ request('area_max') }}">
                                </div>

                                <div class="col-md-2">
                                    <div class="d-flex gap-2 align-items-end" style="height: 100%;">
                                        <button type="submit" class="btn btn-primary flex-fill">
                                            <i class="fas fa-search me-2"></i>Pesquisar
                                        </button>
                                        <a href="{{ route('consulta.cliente.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>Limpar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resultados -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-home me-2"></i>Imóveis Encontrados</h5>
                        <span class="badge bg-primary">{{ $imoveis->total() }} resultado(s)</span>
                    </div>
                    <div class="card-body">
                        @if ($imoveis->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Código</th>
                                            <th>Tipo</th>
                                            <th>Bairro</th>
                                            <th>Valor</th>
                                            <th>Área</th>
                                            <th>Preço de Venda (Amostra)</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($imoveis as $imovel)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-light text-dark fs-6">#{{ $imovel->id }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-medium">
                                                        {{ $imovel->tipo == 'terreno'
                                                            ? 'Terreno'
                                                            : ($imovel->tipo == 'apartamento'
                                                                ? 'Apartamento'
                                                                : ($imovel->tipo == 'imovel_urbano'
                                                                    ? 'Imóvel Urbano'
                                                                    : ($imovel->tipo == 'sala_comercial'
                                                                        ? 'Sala Comercial'
                                                                        : 'Galpão'))) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                                    {{ $imovel->bairro->nome ?? 'Não informado' }}
                                                </td>
                                                <td>
                                                    @if ($imovel->valor_total_imovel)
                                                        <span class="text-success fw-bold">
                                                            R$
                                                            {{ number_format($imovel->valor_total_imovel, 2, ',', '.') }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">Não informado</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($imovel->tipo == 'terreno')
                                                        <span class="text-info">
                                                            {{ number_format($imovel->area_total, 2, ',', '.') }} m²
                                                        </span>
                                                    @elseif (in_array($imovel->tipo, ['apartamento', 'imovel_urbano', 'galpao', 'sala_comercial']))
                                                        <span class="text-info">
                                                            {{ $imovel->area_construida !== null ? number_format($imovel->area_construida, 2, ',', '.') : '0,00' }}
                                                            m²
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($imovel->preco_venda_amostra)
                                                        <span class="text-success fw-bold">
                                                            R$
                                                            {{ number_format($imovel->preco_venda_amostra, 2, ',', '.') }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">Não informado</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a class="btn btn-outline-primary btn-sm"
                                                            href="{{ route('consulta.cliente.show', $imovel->id) }}"
                                                            data-bs-toggle="tooltip" title="Ver detalhes">
                                                            <i class="fa-solid fa-magnifying-glass"></i>
                                                        </a>
                                                        @if (!empty($imovel->latitude) && !empty($imovel->longitude))
                                                            <button class="btn btn-outline-success btn-sm view-location"
                                                                data-bs-toggle="tooltip" title="Ver no mapa"
                                                                data-latitude="{{ str_replace(',', '.', $imovel->latitude) }}"
                                                                data-longitude="{{ str_replace(',', '.', $imovel->longitude) }}"
                                                                data-id="{{ $imovel->id }}"
                                                                data-tipo="{{ $imovel->tipo == 'terreno' ? 'Terreno' : ($imovel->tipo == 'apartamento' ? 'Apartamento' : ($imovel->tipo == 'imovel_urbano' ? 'Imóvel Urbano' : ($imovel->tipo == 'sala_comercial' ? 'Sala Comercial' : 'Galpão'))) }}"
                                                                data-bairro="{{ $imovel->bairro->nome ?? '' }}"
                                                                data-area="{{ $imovel->tipo == 'terreno' ? $imovel->area_total : $imovel->area_construida }}">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                            </button>
                                                        @endif
                                                        @if ($imovel->preco_venda_amostra && $imovel->preco_venda_amostra > 0)
                                                            @if (isset($itensNoCarrinho) && $itensNoCarrinho->contains($imovel->id))
                                                                <button class="btn btn-success btn-sm" disabled
                                                                    data-bs-toggle="tooltip"
                                                                    title="Já adicionado ao carrinho">
                                                                    <i class="fa-solid fa-check"></i> Adicionado
                                                                </button>
                                                            @else
                                                                <button class="btn btn-primary btn-sm btn-add-carrinho"
                                                                    data-amostra-id="{{ $imovel->id }}"
                                                                    data-bs-toggle="tooltip" title="Comprar Amostra">
                                                                    <i class="fa-solid fa-cart-plus"></i> Comprar Amostra
                                                                </button>
                                                            @endif
                                                        @else
                                                            <button class="btn btn-secondary btn-sm" disabled
                                                                data-bs-toggle="tooltip" title="Amostra não disponível">
                                                                <i class="fa-solid fa-times"></i> Indisponível
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginação -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="text-muted">
                                    Mostrando <strong>{{ $imoveis->firstItem() ?? 0 }}</strong> a
                                    <strong>{{ $imoveis->lastItem() ?? 0 }}</strong> de
                                    <strong>{{ $imoveis->total() }}</strong> resultados
                                </div>
                                <div>
                                    {{ $imoveis->appends(request()->query())->links('vendor.pagination.simple-coreui') }}
                                </div>
                            </div>
                        @else
                            <!-- Nenhum resultado encontrado -->
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-search fa-4x text-muted"></i>
                                </div>
                                <h4 class="text-muted mb-3">Nenhum imóvel encontrado</h4>
                                <p class="text-muted mb-4">
                                    Não encontramos imóveis com os critérios de pesquisa utilizados.<br>
                                    Tente ajustar os filtros ou limpar a pesquisa.
                                </p>
                                <a href="{{ route('consulta.cliente.index') }}" class="btn btn-primary">
                                    <i class="fas fa-refresh me-2"></i>Nova Pesquisa
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Visualização Única de Localização -->
    <div class="modal fade" id="singleLocationModal" tabindex="-1" aria-labelledby="singleLocationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="singleLocationModalLabel">Localização do Imóvel #<span
                            id="imovelIdTitle"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="googleMapsIframe" width="100%" height="400" frameborder="0" style="border:0"
                        allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
            <span id="carrinho-contador"
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                style="font-size: 0.75rem;">
                0
            </span>
        </a>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar se o elemento carrinho-indicador existe
            const carrinhoIndicador = document.getElementById('carrinho-indicador');
            const carrinhoContador = document.getElementById('carrinho-contador');

            if (!carrinhoIndicador) {
                console.error('Elemento carrinho-indicador não encontrado no DOM');
            } else {
                console.log('Elemento carrinho-indicador encontrado');
            }

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

            document.querySelectorAll('.view-location').forEach(button => {
                button.addEventListener('click', function() {
                    const latitude = parseFloat(this.dataset.latitude);
                    const longitude = parseFloat(this.dataset.longitude);
                    const codigo = this.dataset.id;

                    document.getElementById('imovelIdTitle').textContent = codigo;

                    // Monta a URL do Google Maps Embed
                    const mapsUrl =
                        `https://www.google.com/maps?q=${latitude},${longitude}&hl=pt-BR&z=17&output=embed`;
                    document.getElementById('googleMapsIframe').src = mapsUrl;

                    const modal = new bootstrap.Modal(document.getElementById(
                        'singleLocationModal'));
                    modal.show();
                });
            });

            // Funcionalidade do carrinho
            document.querySelectorAll('.btn-add-carrinho').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    var amostraId = this.dataset.amostraId;
                    var btnElement = this;

                    console.log('Iniciando adição ao carrinho para amostra:', amostraId);
                    console.log('CSRF Token:', '{{ csrf_token() }}');
                    console.log('URL da requisição:', "{{ route('carrinho.adicionar') }}");

                    // Desabilita o botão durante a requisição
                    btnElement.disabled = true;
                    btnElement.innerHTML =
                        '<i class="fa-solid fa-spinner fa-spin"></i> Adicionando...';

                    fetch("{{ route('carrinho.adicionar') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                amostra_id: amostraId
                            })
                        })
                        .then(response => {
                            console.log('Response status:', response.status);
                            console.log('Response headers:', response.headers);

                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.text().then(text => {
                                console.log('Response text:', text);
                                try {
                                    return JSON.parse(text);
                                } catch (e) {
                                    console.error('Erro ao fazer parse do JSON:', e);
                                    console.error('Resposta recebida:', text);
                                    throw new Error('Resposta não é um JSON válido');
                                }
                            });
                        })
                        .then(data => {
                            console.log('Response data:', data);
                            if (data.success) {
                                // Atualiza o contador do carrinho
                                if (carrinhoContador && data.total_itens) {
                                    carrinhoContador.textContent = data.total_itens;
                                }

                                // Mostra o indicador do carrinho
                                const carrinhoIndicador = document.getElementById(
                                    'carrinho-indicador');
                                if (carrinhoIndicador) {
                                    carrinhoIndicador.classList.remove('d-none');
                                    console.log('Carrinho indicador mostrado com sucesso');
                                } else {
                                    console.error('Elemento carrinho-indicador não encontrado');
                                }

                                // Deixa o botão permanentemente como "Adicionado" e desabilitado
                                btnElement.disabled = true;
                                btnElement.classList.remove('btn-primary');
                                btnElement.classList.add('btn-success');
                                btnElement.innerHTML =
                                    '<i class="fa-solid fa-check"></i> Adicionado';
                                btnElement.setAttribute('data-bs-original-title',
                                    'Item já adicionado ao carrinho');

                                // Atualiza o tooltip se existir
                                var tooltip = bootstrap.Tooltip.getInstance(btnElement);
                                if (tooltip) {
                                    tooltip.dispose();
                                    new bootstrap.Tooltip(btnElement);
                                }
                            } else {
                                console.error('Erro na resposta:', data.message ||
                                    'Erro desconhecido');
                                btnElement.disabled = false;
                                btnElement.innerHTML =
                                    '<i class="fa-solid fa-cart-shopping"></i> Comprar Amostra';
                                alert('Erro ao adicionar ao carrinho: ' + (data.message ||
                                    'Erro desconhecido'));
                            }
                        })
                        .catch(error => {
                            console.error('Erro na requisição:', error);
                            btnElement.disabled = false;
                            btnElement.innerHTML =
                                '<i class="fa-solid fa-cart-shopping"></i> Comprar Amostra';
                            alert('Erro ao adicionar ao carrinho. Verifique o console para mais detalhes. Erro: ' +
                                error.message);
                        });
                });
            });

            // Inicializar tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
