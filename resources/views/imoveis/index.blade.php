@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary">
                                <i class="fas fa-home me-2"></i>Imóveis
                                <span id="totalSelectionBadge" class="badge bg-success ms-2" style="display: none;">
                                    <span id="totalSelectionCount">0</span> selecionado(s)
                                </span>
                            </h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('imoveis.create') }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                    <span>Novo Imóvel</span>
                                </a>
                                @can('imprimir imoveis')
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-sm btn-outline-info d-flex align-items-center gap-2 px-3 py-2 dropdown-toggle"
                                            type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-print" style="font-size: 0.9rem;"></i>
                                            Imprimir
                                        </button>
                                        {{-- <div id="printSelectedBtn">
                                        <a href="#" class="btn btn-primary" id="printSelectedButton">Imprimir
                                            Selecionados</a>
                                    </div> --}}
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" id="printSelectedButton">
                                                    <span>Tabela Analítica</span>
                                                    <span id="selectionCounter" class="badge bg-primary ms-2"
                                                        style="display: none;">0</span>
                                                </a></li>
                                            <li><a class="dropdown-item" href="#" id="printSelectedButtonResumido">
                                                    <span>Tabela Sintética</span>
                                                    <span class="badge bg-primary ms-2" style="display: none;"
                                                        id="selectionCounterResumido">0</span>
                                                </a>
                                            </li>
                                            <li><a class="dropdown-item" href="#" id="printMapButton">
                                                    <span>Imprimir Mapa</span>
                                                    <span id="selectionCounterMapa" class="badge bg-primary ms-2"
                                                        style="display: none;">0</span>
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item text-danger" href="#"
                                                    onclick="clearAllSelections()">
                                                    <i class="fas fa-times me-2"></i>Limpar Seleções
                                                </a></li>
                                        </ul>
                                    </div>
                                @endcan
                                {{-- <a href="#" id="generateMapButton"
                                    class="btn btn-sm btn-outline-success d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>Gerar Mapa</span>
                                </a> --}}

                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Filtro -->
                            <div class="accordion mb-3" id="filtrosAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFiltros">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiltros" aria-expanded="false" aria-controls="collapseFiltros" style="background: linear-gradient(90deg, #e0e7ff 0%, #f0fdfa 100%); color: #2563eb; font-weight: 600;">
                                            <i class="fas fa-filter me-2"></i>Filtros de Pesquisa
                                        </button>
                                    </h2>
                                    <div id="collapseFiltros" class="accordion-collapse collapse{{ (request()->except('_token') && count(request()->except('_token')) > 0) ? ' show' : '' }}" aria-labelledby="headingFiltros" data-bs-parent="#filtrosAccordion">
                                        <div class="accordion-body">
                                            <form action="{{ route('imoveis.index') }}" method="GET">
                                                @csrf
                                                <div class="row mb-2">
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="id">Cód(s) Imóvel <small class="text-muted">(separar por vírgula)</small></label>
                                                        <input type="text" class="form-control" id="id" name="id" placeholder="Ex: 80,81,85,90,98" value="{{ request('id') }}" title="Digite um ou mais códigos separados por vírgula">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="bairro">Bairro</label>
                                                        <select class="form-select" id="multiple-select-field" data-placeholder="Escolha o Bairro" name="bairro[]" multiple>
                                                            <option value="">Todos</option>
                                                            @foreach ($bairros as $bairro)
                                                                <option value="{{ $bairro->id }}" {{ in_array($bairro->id, (array) request('bairro')) ? 'selected' : '' }}>{{ $bairro->nome }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="tipo">Tipo</label>
                                                        <select class="form-select" id="tipo" name="tipo">
                                                            <option value="">Todos</option>
                                                            <option value="terreno" {{ request('tipo') == 'terreno' ? 'selected' : '' }}>Terreno</option>
                                                            <option value="galpao" {{ request('tipo') == 'galpao' ? 'selected' : '' }}>Galpão</option>
                                                            <option value="apartamento" {{ request('tipo') == 'apartamento' ? 'selected' : '' }}>Apartamento</option>
                                                            <option value="imovel_urbano" {{ request('tipo') == 'imovel_urbano' ? 'selected' : '' }}>Imóvel Urbano</option>
                                                            <option value="sala_comercial" {{ request('tipo') == 'sala_comercial' ? 'selected' : '' }}>Sala Comercial</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="transacao">Transação</label>
                                                        <select class="form-select" id="transacao" name="transacao">
                                                            <option value="">Todos</option>
                                                            <option value="a venda" {{ request('transacao') == 'a venda' ? 'selected' : '' }}>A venda</option>
                                                            <option value="vendido" {{ request('transacao') == 'vendido' ? 'selected' : '' }}>Vendido</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="marina">Marina</label>
                                                        <select class="form-select" id="marina" name="marina">
                                                            <option value="">Todos</option>
                                                            <option value="1" {{ request('marina') === '1' ? 'selected' : '' }}>Sim</option>
                                                            <option value="0" {{ request('marina') === '0' ? 'selected' : '' }}>Não</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="area_min">Área Mínima (m²)</label>
                                                        <input type="text" class="form-control" id="area_min" name="area_min" placeholder="Área Mínima" value="{{ request('area_min') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="area_max">Área Máxima (m²)</label>
                                                        <input type="text" class="form-control" id="area_max" name="area_max" placeholder="Área Máxima" value="{{ request('area_max') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="preco_unitario_min">Preço Unitário Mínimo (R$/m²)</label>
                                                        <input type="text" class="form-control money-mask" id="preco_unitario_min" name="preco_unitario_min" placeholder="Mínimo" value="{{ request('preco_unitario_min') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="preco_unitario_max">Preço Unitário Máximo (R$/m²)</label>
                                                        <input type="text" class="form-control money-mask" id="preco_unitario_max" name="preco_unitario_max" placeholder="Máximo" value="{{ request('preco_unitario_max') }}">
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center mt-3">
                                                    <div class="col-md-3 d-flex justify-content-center gap-2">
                                                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Pesquisar</button>
                                                        <a href="{{ route('imoveis.index') }}" class="btn btn-outline-secondary w-100" onclick="clearAllSelections()"><i class="fas fa-times me-2"></i>Limpar</a>
                                                    </div>
                                                </div>
                                            </form>
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
                                            <script>
                                                $(document).ready(function(){
                                                    $('.money-mask').mask('000.000.000,00', {reverse: true});
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border mb-0 table-striped table-hover">
                                    <thead class="fw-semibold text-nowrap">
                                        <tr class="table-light">
                                            <th class="bg-body-secondary" style="width: 40px;">
                                                <input type="checkbox" class="form-check-input" id="selectAll">
                                            </th>
                                            <th class="bg-body-secondary text-center">#Cód.</th>
                                                                                        <th class="bg-body-secondary text-center">Tipo</th>
                                                                                        <th class="bg-body-secondary text-center">Bairro</th>
                                                                                        <th class="bg-body-secondary text-center">Valor (R$)</th>
                                                                                        <th class="bg-body-secondary text-center">Área Total</th>
                                                                                         <th class="bg-body-secondary text-center">R$/m²</th>
                                                                                        <th class="bg-body-secondary text-center">Marina</th>
                                                                                        <th class="bg-body-secondary text-center">Transação</th>
                                                                                        <th class="bg-body-secondary text-center">Cadastrado em</th>
                                                                                        <th class="bg-body-secondary text-center">Link</th>
                                                                                        <th class="bg-body-secondary text-center" style="width: 160px;">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($imoveis->count() > 0)
                                            @foreach ($imoveis as $imovel)
                                                <tr class="border-bottom border-light">
                                                    <td>
                                                        <input type="checkbox" class="form-check-input imovel-checkbox"
                                                            value="{{ $imovel->id }}"
                                                            data-latitude="{{ $imovel->latitude }}"
                                                            data-longitude="{{ $imovel->longitude }}">
                                                    </td>
                                                    <td><strong>{{ $imovel->id }}</strong></td>
                                                    <td>
                                                        {{ $imovel->tipo == 'terreno'
                                                            ? 'Terreno'
                                                            : ($imovel->tipo == 'apartamento'
                                                                ? 'Apartamento'
                                                                : ($imovel->tipo == 'imovel_urbano'
                                                                    ? 'Imóvel Urbano'
                                                                    : ($imovel->tipo == 'sala_comercial'
                                                                        ? 'Sala Comercial'
                                                                        : 'Galpão'))) }}
                                                    </td>
                                                    <td class="px-4">{{ $imovel->bairro->nome ?? '' }}</td>
                                                    <td class="px-4">
                                                        @if ($imovel->valor_total_imovel)
                                                            R$
                                                            {{ number_format($imovel->valor_total_imovel, 2, ',', '.') }}
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    @if ($imovel->tipo == 'terreno')
                                                        <td class="px-4">
                                                            {{ number_format($imovel->area_total, 2, ',', '.') }} m²</td>
                                                    @elseif (
                                                        $imovel->tipo == 'apartamento' ||
                                                            $imovel->tipo == 'imovel_urbano' ||
                                                            $imovel->tipo == 'galpao' ||
                                                            $imovel->tipo == 'sala_comercial')
                                                        <td class="px-4">
                                                            {{ $imovel->area_construida !== null ? number_format($imovel->area_construida, 2, ',', '.') : '' }}
                                                            m² </td>
                                                    @endif

                                                        <td class="px-4 text-center">
                                                            @if (!is_null($imovel->preco_unitario1))
                                                                R$ {{ number_format($imovel->preco_unitario1, 2, ',', '.') }}
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                            
                                                        </td>

                                                    <td class="px-4">
                                                        @if(isset($imovel->marina))
                                                            @if($imovel->marina == 1 || $imovel->marina === true || $imovel->marina === '1')
                                                                <span class="badge bg-info text-dark">Sim</span>
                                                            @elseif($imovel->marina == 0 || $imovel->marina === false || $imovel->marina === '0')
                                                                <span class="badge bg-secondary">Não</span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4">
                                                        @if ($imovel->transacao == 'A venda')
                                                            <span class="badge bg-success">À venda</span>
                                                        @elseif ($imovel->transacao == 'Vendido')
                                                            <span class="badge bg-danger">Vendido</span>
                                                        @else
                                                            <span class="badge bg-secondary">Não informado</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4">{{ $imovel->created_at->format('d/m/Y H:i') }}</td>
                                                    <td class="px-4">
                                                        @php
                                                            $rawLink = $imovel->link ?? '';
                                                            $hasLink = filled($rawLink);
                                                            if ($hasLink && !preg_match('/^https?:\/\//i', $rawLink)) {
                                                                $rawLink = 'http://' . $rawLink;
                                                            }
                                                        @endphp
                                                        @if ($hasLink)
                                                            <a href="{{ $rawLink }}" target="_blank"
                                                                rel="noopener noreferrer" class="text-decoration-none">
                                                                Abrir
                                                                <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                                            </a>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4">
                                                        <div class="dropdown">
                                                            <button class="btn btn-light btn-sm dropdown-toggle"
                                                                type="button" data-coreui-toggle="dropdown"
                                                                aria-expanded="false">
                                                                Ações
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                @can('imprimir imoveis')
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                                            href="{{ route('gerar.pdf', $imovel->id) }}"
                                                                            target="_blank" rel="noopener noreferrer">
                                                                            <i class="fa-solid fa-print text-info"></i>
                                                                            <span>Imprimir amostra</span>
                                                                        </a>
                                                                    </li>
                                                                @endcan
                                                                @can('view imoveis')
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                                            href="{{ route('imoveis.show', $imovel->id) }}">
                                                                            <i
                                                                                class="fa-solid fa-magnifying-glass text-primary"></i>
                                                                            <span>Visualizar</span>
                                                                        </a>
                                                                    </li>
                                                                @endcan
                                                                @can('edit imoveis')
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                                            href="{{ route('imoveis.edit', $imovel->id) }}">
                                                                            <i class="fas fa-edit text-warning"></i>
                                                                            <span>Editar</span>
                                                                        </a>
                                                                    </li>
                                                                @endcan
                                                                @can('delete imoveis')
                                                                    <li>
                                                                        <form method="POST"
                                                                            action="{{ route('imoveis.destroy', $imovel->id) }}"
                                                                            onsubmit="return confirm('Tem certeza que deseja excluir este imóvel?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                                                                <i class="fas fa-trash"></i>
                                                                                <span>Excluir</span>
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                @endcan
                                                                @can('view_localizacao imoveis')
                                                                    <li>
                                                                        @if (!empty($imovel->latitude) && !empty($imovel->longitude))
                                                                            <button type="button"
                                                                                class="dropdown-item d-flex align-items-center gap-2 view-location"
                                                                                data-latitude="{{ str_replace(',', '.', $imovel->latitude) }}"
                                                                                data-longitude="{{ str_replace(',', '.', $imovel->longitude) }}"
                                                                                data-id="{{ $imovel->id }}"
                                                                                data-tipo="{{ $imovel->tipo == 'terreno' ? 'Terreno' : ($imovel->tipo == 'apartamento' ? 'Apartamento' : ($imovel->tipo == 'imovel_urbano' ? 'Imóvel Urbano' : 'Galpão')) }}"
                                                                                data-bairro="{{ $imovel->bairro->nome ?? '' }}"
                                                                                data-area="{{ $imovel->tipo == 'terreno' ? $imovel->area_total : $imovel->area_construida }}">
                                                                                <i
                                                                                    class="fa-solid fa-location-dot text-success"></i>
                                                                                <span>Ver localização</span>
                                                                            </button>
                                                                        @else
                                                                            <span
                                                                                class="dropdown-item d-flex align-items-center gap-2 disabled">
                                                                                <i
                                                                                    class="fa-solid fa-location-dot text-danger"></i>
                                                                                <span>Sem localização</span>
                                                                            </span>
                                                                        @endif
                                                                    </li>
                                                                @endcan
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" class="text-center py-7">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                                        <h5 class="text-muted">Nenhum registro encontrado</h5>
                                                        <p class="text-muted">Tente ajustar os filtros de pesquisa</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="text-muted">
                                    Mostrando <strong>{{ $imoveis->count() }}</strong> imóvel(s) de
                                    <strong>{{ $imoveis->total() }}</strong> no total
                                </div>
                                <div>
                                    {{ $imoveis->links('vendor.pagination.simple-coreui') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para o Mapa -->
        <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mapModalLabel">Localização dos Imóveis Selecionados</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div id="map" style="height: 500px; width: 100%;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="printMapModalButton">
                            <i class="fas fa-print me-2"></i>Imprimir Mapa
                        </button>
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal de Aviso -->
    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="warningModalLabel">Aviso</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="warningMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Fechar</button>
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
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="singleLocationMap" style="height: 500px; width: 100%;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    {{-- seleciona as impressoes  --}}
    <script>
        // Verificação de dependências
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Verificando dependências...');
            console.log('Google Maps carregado:', typeof google !== 'undefined' && google.maps);
            console.log('html2canvas carregado:', typeof html2canvas !== 'undefined');
            console.log('coreui carregado:', typeof coreui !== 'undefined');
        });

        // Array global para armazenar IDs selecionados entre páginas
        let selectedImovelIds = JSON.parse(localStorage.getItem('selectedImovelIds') || '[]');

        // Função para salvar seleções no localStorage
        function saveSelectedIds() {
            localStorage.setItem('selectedImovelIds', JSON.stringify(selectedImovelIds));
            updateSelectionCounter();
        }

        // Função para atualizar contador de seleções
        function updateSelectionCounter() {
            const counter = document.getElementById('selectionCounter');
            const counterResumido = document.getElementById('selectionCounterResumido');
            const counterMapa = document.getElementById('selectionCounterMapa');
            const totalBadge = document.getElementById('totalSelectionBadge');
            const totalCount = document.getElementById('totalSelectionCount');

            if (counter) {
                counter.textContent = selectedImovelIds.length;
                counter.style.display = selectedImovelIds.length > 0 ? 'inline' : 'none';
            }

            if (counterResumido) {
                counterResumido.textContent = selectedImovelIds.length;
                counterResumido.style.display = selectedImovelIds.length > 0 ? 'inline' : 'none';
            }

            if (counterMapa) {
                counterMapa.textContent = selectedImovelIds.length;
                counterMapa.style.display = selectedImovelIds.length > 0 ? 'inline' : 'none';
            }

            if (totalBadge && totalCount) {
                totalCount.textContent = selectedImovelIds.length;
                totalBadge.style.display = selectedImovelIds.length > 0 ? 'inline' : 'none';
            }
        }

        // Inicializar página - marcar checkboxes baseado nas seleções salvas
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.imovel-checkbox');
            checkboxes.forEach(function(checkbox) {
                if (selectedImovelIds.includes(checkbox.value)) {
                    checkbox.checked = true;
                }

                // Adicionar event listener para cada checkbox
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        if (!selectedImovelIds.includes(this.value)) {
                            selectedImovelIds.push(this.value);
                        }
                    } else {
                        selectedImovelIds = selectedImovelIds.filter(id => id !== this.value);
                    }
                    saveSelectedIds();
                    updateSelectAllState();
                });
            });

            updateSelectionCounter();
            updateSelectAllState();
        });

        // Função para atualizar estado do "Selecionar Tudo"
        function updateSelectAllState() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const currentPageCheckboxes = document.querySelectorAll('.imovel-checkbox');
            const currentPageIds = Array.from(currentPageCheckboxes).map(cb => cb.value);
            const currentPageSelectedIds = currentPageIds.filter(id => selectedImovelIds.includes(id));

            if (currentPageSelectedIds.length === 0) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = false;
            } else if (currentPageSelectedIds.length === currentPageIds.length) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.indeterminate = true;
                selectAllCheckbox.checked = false;
            }
        }

        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.imovel-checkbox');
            const currentPageIds = Array.from(checkboxes).map(cb => cb.value);

            if (this.checked) {
                // Adicionar todos os IDs da página atual
                currentPageIds.forEach(id => {
                    if (!selectedImovelIds.includes(id)) {
                        selectedImovelIds.push(id);
                    }
                });
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = true;
                });
            } else {
                // Remover todos os IDs da página atual
                selectedImovelIds = selectedImovelIds.filter(id => !currentPageIds.includes(id));
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            }
            saveSelectedIds();
        });

        document.getElementById('printSelectedButton').addEventListener('click', function() {
            if (selectedImovelIds.length === 0) {
                const modal = new coreui.Modal(document.getElementById('warningModal'));
                document.getElementById('warningMessage').textContent =
                    'Nenhum imóvel selecionado para impressão. Por favor, selecione pelo menos um imóvel.';
                modal.show();
                return;
            }

            var url = '{{ route('gerar.multiple.pdf', ['ids' => '__ids__']) }}'.replace('__ids__',
                selectedImovelIds.join(','));
            window.open(url, '_blank');
        });

        // Script para o botão de impressão resumida
        document.getElementById('printSelectedButtonResumido').addEventListener('click', function() {
            if (selectedImovelIds.length === 0) {
                // Mostrar modal de aviso
                const modal = new coreui.Modal(document.getElementById('warningModal'));
                document.getElementById('warningMessage').textContent =
                    'Nenhum imóvel selecionado para impressão. Por favor, selecione pelo menos um imóvel.';
                modal.show();
                return;
            }

            const url = '{{ route('gerar.multiple.pdf.resumido', ['ids' => '__ids__']) }}'
                .replace('__ids__', selectedImovelIds.join(','));

            window.open(url, '_blank');
        });

        // Script para o botão de impressão do mapa
        document.getElementById('printMapButton').addEventListener('click', function() {
            console.log('Botão Imprimir Mapa clicado');

            if (selectedImovelIds.length === 0) {
                console.log('Nenhum imóvel selecionado');
                const modal = new coreui.Modal(document.getElementById('warningModal'));
                document.getElementById('warningMessage').textContent =
                    'Nenhum imóvel selecionado para impressão do mapa. Por favor, selecione pelo menos um imóvel.';
                modal.show();
                return;
            }

            console.log('Imóveis selecionados:', selectedImovelIds.length);

            // Verifica dependências primeiro
            if (typeof google === 'undefined' || !google.maps) {
                console.error('Google Maps não carregado');
                alert('Google Maps não está carregado. Recarregue a página e tente novamente.');
                return;
            }

            if (typeof html2canvas === 'undefined') {
                console.error('html2canvas não carregado');
                alert('Biblioteca de captura não está carregada. Recarregue a página e tente novamente.');
                return;
            }

            // Busca os dados dos imóveis selecionados via AJAX
            fetchSelectedImoveisAndPrintMap();
        });

        // Função para limpar todas as seleções
        function clearAllSelections() {
            selectedImovelIds = [];
            localStorage.removeItem('selectedImovelIds');
            document.querySelectorAll('.imovel-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            updateSelectionCounter();
            updateSelectAllState();
        }

        // Função para buscar dados dos imóveis selecionados via AJAX e imprimir mapa
        function fetchSelectedImoveisAndPrintMap() {
            console.log('Iniciando busca dos dados dos imóveis...');
            console.log('IDs selecionados:', selectedImovelIds);

            // Mostra indicador de carregamento
            const printMapBtn = document.getElementById('printMapButton');
            const originalText = printMapBtn.innerHTML;
            printMapBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Carregando...';
            printMapBtn.style.pointerEvents = 'none';

            // Método alternativo: envia direto para o backend gerar o mapa
            try {
                console.log('Tentando método direto...');

                // Cria formulário para enviar IDs diretamente
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('imoveis.printMapDirect') }}';
                form.target = '_blank';
                form.style.display = 'none';

                // CSRF Token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // IDs dos imóveis
                const idsInput = document.createElement('input');
                idsInput.type = 'hidden';
                idsInput.name = 'imovel_ids';
                idsInput.value = JSON.stringify(selectedImovelIds);
                form.appendChild(idsInput);

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);

                console.log('Formulário enviado com sucesso');

                // Restaura o botão
                printMapBtn.innerHTML = originalText;
                printMapBtn.style.pointerEvents = 'auto';

                return;

            } catch (error) {
                console.error('Erro no método direto:', error);
            }

            // Método original como fallback
            console.log('Tentando método original...');

            // Faz requisição AJAX para buscar os dados dos imóveis
            fetch('{{ route('imoveis.getSelectedData') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        ids: selectedImovelIds
                    })
                })
                .then(response => {
                    console.log('Resposta recebida:', response);
                    return response.json();
                })
                .then(data => {
                    console.log('Dados retornados:', data);

                    if (data.success && data.imoveis.length > 0) {
                        // Filtra apenas imóveis com coordenadas válidas
                        const imoveisComCoordenadas = data.imoveis.filter(imovel => {
                            const lat = parseFloat(imovel.latitude?.toString().replace(',', '.'));
                            const lng = parseFloat(imovel.longitude?.toString().replace(',', '.'));
                            return imovel.latitude && imovel.longitude && !isNaN(lat) && !isNaN(lng);
                        });

                        console.log('Imóveis com coordenadas válidas:', imoveisComCoordenadas.length);

                        if (imoveisComCoordenadas.length === 0) {
                            const modal = new coreui.Modal(document.getElementById('warningModal'));
                            document.getElementById('warningMessage').textContent =
                                'Nenhum dos imóveis selecionados possui coordenadas válidas para gerar o mapa.';
                            modal.show();
                            return;
                        }

                        // Gera o mapa e imprime diretamente
                        generateAndPrintMap(imoveisComCoordenadas);
                    } else {
                        console.error('Erro nos dados:', data);
                        const modal = new coreui.Modal(document.getElementById('warningModal'));
                        document.getElementById('warningMessage').textContent =
                            'Erro ao carregar dados dos imóveis selecionados.';
                        modal.show();
                    }
                })
                .catch(error => {
                    console.error('Erro na requisição:', error);
                    const modal = new coreui.Modal(document.getElementById('warningModal'));
                    document.getElementById('warningMessage').textContent =
                        'Erro ao carregar dados dos imóveis. Tente novamente.';
                    modal.show();
                })
                .finally(() => {
                    // Restaura o botão
                    printMapBtn.innerHTML = originalText;
                    printMapBtn.style.pointerEvents = 'auto';
                });
        }

        // Função para gerar e imprimir o mapa diretamente
        function generateAndPrintMap(imoveis) {
            console.log('Iniciando geração do mapa para impressão...');
            console.log('Imóveis recebidos:', imoveis);

            try {
                // Verifica se o Google Maps está carregado
                if (typeof google === 'undefined' || !google.maps) {
                    console.error('Google Maps não está carregado');
                    alert('Erro: Google Maps não está carregado. Tente recarregar a página.');
                    return;
                }

                // Cria um container temporário para o mapa
                const tempMapContainer = document.createElement('div');
                tempMapContainer.id = 'tempMapForPrint';
                tempMapContainer.style.width = '800px';
                tempMapContainer.style.height = '600px';
                tempMapContainer.style.position = 'absolute';
                tempMapContainer.style.left = '-9999px';
                tempMapContainer.style.top = '-9999px';
                document.body.appendChild(tempMapContainer);

                console.log('Container temporário criado');

                // Configurações do mapa
                const firstImovel = imoveis[0];
                const lat = parseFloat(firstImovel.latitude.toString().replace(',', '.'));
                const lng = parseFloat(firstImovel.longitude.toString().replace(',', '.'));

                console.log('Primeiro imóvel - Lat:', lat, 'Lng:', lng);

                const mapOptions = {
                    zoom: 13,
                    center: new google.maps.LatLng(lat, lng),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    streetViewControl: false,
                    fullscreenControl: false,
                    mapTypeControl: false,
                    zoomControl: true,
                    styles: [{
                        "featureType": "poi",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    }]
                };

                // Cria o mapa temporário
                const tempMap = new google.maps.Map(tempMapContainer, mapOptions);
                console.log('Mapa temporário criado');

                // Cria bounds para ajustar o zoom
                const bounds = new google.maps.LatLngBounds();
                const tempMarkers = [];

                // Adiciona marcadores
                imoveis.forEach(function(imovel, index) {
                    try {
                        const lat = parseFloat(imovel.latitude.toString().replace(',', '.'));
                        const lng = parseFloat(imovel.longitude.toString().replace(',', '.'));

                        console.log(`Marcador ${index + 1} - ID: ${imovel.id}, Lat: ${lat}, Lng: ${lng}`);

                        const position = new google.maps.LatLng(lat, lng);
                        bounds.extend(position);

                        const marker = new google.maps.Marker({
                            position: position,
                            map: tempMap,
                            title: 'Imóvel #' + imovel.id,
                            icon: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
                        });

                        tempMarkers.push(marker);
                    } catch (error) {
                        console.error(`Erro ao criar marcador para imóvel ${imovel.id}:`, error);
                    }
                });

                console.log(`${tempMarkers.length} marcadores criados`);

                // Ajusta o zoom para todos os marcadores
                if (imoveis.length > 1) {
                    tempMap.fitBounds(bounds);
                    console.log('Bounds ajustados para múltiplos marcadores');
                }

                // Aguarda o mapa carregar e captura a imagem
                google.maps.event.addListenerOnce(tempMap, 'idle', function() {
                    console.log('Mapa carregado, aguardando para capturar...');

                    setTimeout(() => {
                        console.log('Iniciando captura com html2canvas...');

                        // Verifica se html2canvas está disponível
                        if (typeof html2canvas === 'undefined') {
                            console.error('html2canvas não está carregado');
                            alert(
                                'Erro: Biblioteca de captura não está carregada. Tente recarregar a página.'
                            );
                            document.body.removeChild(tempMapContainer);
                            return;
                        }

                        html2canvas(tempMapContainer, {
                            useCORS: true,
                            allowTaint: true,
                            scale: 2,
                            logging: true
                        }).then(function(canvas) {
                            console.log('Captura realizada com sucesso');

                            const mapImage = canvas.toDataURL('image/png');
                            console.log('Imagem convertida para base64, tamanho:', mapImage.length);

                            // Cria um formulário para enviar os dados
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route('print.map') }}';
                            form.target = '_blank';
                            form.style.display = 'none';

                            // CSRF Token
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';
                            form.appendChild(csrfToken);

                            // Imagem do mapa
                            const mapImageInput = document.createElement('input');
                            mapImageInput.type = 'hidden';
                            mapImageInput.name = 'map_image';
                            mapImageInput.value = mapImage;
                            form.appendChild(mapImageInput);

                            // Dados dos imóveis
                            const imoveisInput = document.createElement('input');
                            imoveisInput.type = 'hidden';
                            imoveisInput.name = 'imoveis_data';
                            imoveisInput.value = JSON.stringify(imoveis);
                            form.appendChild(imoveisInput);

                            console.log('Formulário criado, enviando...');

                            document.body.appendChild(form);
                            form.submit();
                            document.body.removeChild(form);

                            console.log('Formulário enviado com sucesso');

                            // Remove o container temporário
                            document.body.removeChild(tempMapContainer);
                        }).catch(function(error) {
                            console.error('Erro ao capturar o mapa:', error);
                            alert('Erro ao capturar a imagem do mapa: ' + error.message);

                            // Remove o container temporário
                            document.body.removeChild(tempMapContainer);
                        });
                    }, 2000); // Aumentei o tempo de espera para 2 segundos
                });

            } catch (error) {
                console.error('Erro geral na função generateAndPrintMap:', error);
                alert('Erro ao gerar o mapa: ' + error.message);
            }
        }
    </script>



    <!-- Adicione isso no cabeçalho do seu layout ou antes do script -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlG0ouFD-X3AknpUDzwpfpzE6tw5LU8ws&callback=initMap" async
        defer></script>

    <script>
        // Variáveis globais
        var map;
        var markers = [];
        var selectedImoveis = [];

        // Função para gerar mapa com imóveis selecionados
        document.getElementById('generateMapButton').addEventListener('click', function() {
            if (selectedImovelIds.length === 0) {
                const modal = new coreui.Modal(document.getElementById('warningModal'));
                document.getElementById('warningMessage').textContent =
                    'Nenhum imóvel selecionado. Por favor, selecione pelo menos um imóvel.';
                modal.show();
                return;
            }

            // Se há seleções mas não temos dados completos, fazemos uma requisição AJAX
            // Por enquanto, usamos apenas os dados visíveis na página atual
            selectedImoveis = [];

            selectedImovelIds.forEach(function(selectedId) {
                const checkbox = document.querySelector(`.imovel-checkbox[value="${selectedId}"]`);

                if (checkbox) {
                    const latitude = parseFloat(checkbox.dataset.latitude.toString().replace(',', '.'));
                    const longitude = parseFloat(checkbox.dataset.longitude.toString().replace(',', '.'));

                    if (!isNaN(latitude) && !isNaN(longitude)) {
                        var row = checkbox.closest('tr');
                        selectedImoveis.push({
                            id: selectedId,
                            tipo: row.cells[2].textContent.trim(),
                            bairro: row.cells[3].textContent.trim(),
                            valor: row.cells[4].textContent.trim(),
                            area: row.cells[5].textContent.trim(),
                            latitude: latitude,
                            longitude: longitude
                        });
                    }
                }
            });

            if (selectedImoveis.length === 0) {
                const modal = new coreui.Modal(document.getElementById('warningModal'));
                document.getElementById('warningMessage').textContent =
                    `Você tem ${selectedImovelIds.length} imóvel(s) selecionado(s), mas para gerar o mapa é necessário que pelo menos um dos imóveis selecionados esteja visível na página atual e possua coordenadas válidas.`;
                modal.show();
                return;
            }

            // Mostra o modal
            var mapModal = new coreui.Modal(document.getElementById('mapModal'));
            mapModal.show();
        });

        // Inicializa o mapa quando o modal é aberto
        document.getElementById('mapModal').addEventListener('shown.coreui.modal', function() {
            initSelectedMap();
        });

        // Função para inicializar o mapa com os imóveis selecionados
        function initSelectedMap() {
            // Limpa marcadores anteriores
            clearMarkers();

            // Configurações do mapa
            var mapOptions = {
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: false,
                fullscreenControl: true,
                mapTypeControl: true,
                styles: [{
                    "featureType": "poi",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }]
            };

            // Centraliza no primeiro imóvel
            var firstLocation = new google.maps.LatLng(
                selectedImoveis[0].latitude,
                selectedImoveis[0].longitude
            );
            mapOptions.center = firstLocation;

            // Cria o mapa
            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            // Cria bounds para ajustar o zoom
            var bounds = new google.maps.LatLngBounds();

            // Adiciona marcadores
            selectedImoveis.forEach(function(imovel) {
                var position = new google.maps.LatLng(imovel.latitude, imovel.longitude);
                bounds.extend(position);

                var marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: 'Imóvel #' + imovel.id,
                    icon: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
                });

                // Cria conteúdo do info window
                var contentString = `
            <div style="min-width: 150px;">
                <h5 style="margin: 5px 0; color: #333;">Imóvel #${imovel.id}</h5>
                <p style="margin: 3px 0; font-size: 13px;"><strong>Tipo:</strong> ${imovel.tipo}</p>
                <p style="margin: 3px 0; font-size: 13px;"><strong>Bairro:</strong> ${imovel.bairro}</p>
                <p style="margin: 3px 0; font-size: 13px;"><strong>Valor:</strong> ${imovel.valor}</p>
                <p style="margin: 3px 0; font-size: 13px;"><strong>Área:</strong> ${imovel.area}</p>
                <a href="/amsilotti/public/imoveis/${imovel.id}" target="_blank"
                   style="display: inline-block; margin-top: 5px; color: #1a73e8; font-size: 13px;">
                    Ver detalhes
                </a>
            </div>
        `;

                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });

                markers.push(marker);
            });

            // Ajusta o zoom para todos os marcadores
            if (selectedImoveis.length > 1) {
                map.fitBounds(bounds);

                // Limita o zoom máximo
                google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
                    if (this.getZoom() > 16) {
                        this.setZoom(16);
                    }
                });
            }
        }

        // Função para limpar marcadores
        function clearMarkers() {
            markers.forEach(marker => marker.setMap(null));
            markers = [];
        }
    </script>

    <!-- <script>
        // Variável global para o mapa
        var map;
        var markers = [];

        // Gerar Mapa com os imóveis selecionados
        document.getElementById('generateMapButton').addEventListener('click', function() {
            var selectedImoveis = [];
            document.querySelectorAll('.imovel-checkbox:checked').forEach(function(checkbox) {
                var row = checkbox.closest('tr');
                var imovelId = checkbox.value;
                var tipo = row.cells[2].textContent.trim();
                var bairro = row.cells[3].textContent.trim();
                var area = row.cells[4].textContent.trim();

                // Verifica se tem ícone de localização (coordenadas)
                var hasLocation = row.querySelector('.fa-location-dot.text-success') !== null;

                if (hasLocation) {
                    var latitude = parseFloat(checkbox.dataset.latitude);
                    var longitude = parseFloat(checkbox.dataset.longitude);

                    selectedImoveis.push({
                        id: imovelId,
                        tipo: tipo,
                        bairro: bairro,
                        area: area,
                        latitude: latitude,
                        longitude: longitude
                    });
                }
            });

            if (selectedImoveis.length === 0) {
                alert('Nenhum imóvel com localização válida foi selecionado.');
                return;
            }

            // Mostra o modal
            var mapModal = new coreui.Modal(document.getElementById('mapModal'));
            mapModal.show();

            // Inicializa o mapa depois que o modal é mostrado
            document.getElementById('mapModal').addEventListener('shown.coreui.modal', function() {
                initMap(selectedImoveis);
            });
        });

        function initMap(imoveis) {
            // Limpa marcadores anteriores
            clearMarkers();

            // Se não houver imóveis, não faz nada
            if (!imoveis || imoveis.length === 0) return;

            // Configurações iniciais do mapa
            var mapOptions = {
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: false,
                fullscreenControl: true,
                mapTypeControl: true,
                styles: [{
                    "featureType": "poi",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }]
            };

            // Cria o mapa centrado no primeiro imóvel
            var firstLocation = new google.maps.LatLng(imoveis[0].latitude, imoveis[0].longitude);
            mapOptions.center = firstLocation;

            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            // Cria uma matriz para armazenar as localizações para o bounds
            var bounds = new google.maps.LatLngBounds();

            // Adiciona marcadores para cada imóvel
            imoveis.forEach(function(imovel) {
                var position = new google.maps.LatLng(imovel.latitude, imovel.longitude);

                // Cria o marcador
                var marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: 'Imóvel #' + imovel.id,
                    icon: {
                        url: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
                    }
                });

                // Adiciona ao array de marcadores
                markers.push(marker);

                // Adiciona a posição ao bounds
                bounds.extend(position);

                // Cria o conteúdo do info window
                var contentString = `
                <div style="min-width: 150px;">
                    <h5 style="margin: 5px 0; color: #333;">Imóvel #${imovel.id}</h5>
                    <p style="margin: 3px 0; font-size: 13px;"><strong>Tipo:</strong> ${imovel.tipo}</p>
                    <p style="margin: 3px 0; font-size: 13px;"><strong>Bairro:</strong> ${imovel.bairro}</p>
                    <p style="margin: 3px 0; font-size: 13px;"><strong>Área:</strong> ${imovel.area}</p>
                    <a href="/amsilotti/public/imoveis/${imovelId}" target="_blank" style="display: inline-block; margin-top: 5px; color: #1a73e8; font-size: 13px;">Ver detalhes</a>
                </div>
            `;

                // Cria o info window
                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                // Adiciona o evento de clique no marcador
                marker.addListener('click', function() {
                    // Fecha todos os outros info windows
                    markers.forEach(function(m) {
                        if (m.infowindow) m.infowindow.close();
                    });

                    // Abre o info window para este marcador
                    infowindow.open(map, marker);
                    marker.infowindow = infowindow;
                });
            });

            // Ajusta o zoom para mostrar todos os marcadores
            if (imoveis.length > 1) {
                map.fitBounds(bounds);

                // Se o zoom for muito alto (quando os pontos estão muito próximos), define um zoom mínimo
                google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
                    if (this.getZoom() > 16) {
                        this.setZoom(16);
                    }
                });
            }
        }

        // Função para limpar todos os marcadores
        function clearMarkers() {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        }
    </script> -->

    <script>
        // Variável global para o mapa único
        var singleMap;
        var singleMarker;

        // Evento para visualização única de localização
        document.querySelectorAll('.view-location').forEach(button => {
            button.addEventListener('click', function() {
                const latitude = parseFloat(this.dataset.latitude.toString().replace(',', '.'));
                const longitude = parseFloat(this.dataset.longitude.toString().replace(',', '.'));
                const imovelId = this.dataset.id;
                const tipo = this.dataset.tipo;
                const bairro = this.dataset.bairro;
                const area = this.dataset.area;

                // Atualiza o título do modal
                document.getElementById('imovelIdTitle').textContent = imovelId;

                // Mostra o modal
                const modal = new coreui.Modal(document.getElementById('singleLocationModal'));
                modal.show();

                // Inicializa o mapa depois que o modal é mostrado
                document.getElementById('singleLocationModal').addEventListener('shown.coreui.modal',
                    function() {
                        initSingleMap(latitude, longitude, imovelId, tipo, bairro, area);
                    });
            });
        });

        function initSingleMap(latitude, longitude, imovelId, tipo, bairro, area) {
            // Limpa o marcador anterior se existir
            if (singleMarker) {
                singleMarker.setMap(null);
            }

            // Configurações do mapa
            const mapOptions = {
                zoom: 16,
                center: new google.maps.LatLng(latitude, longitude),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: true,
                fullscreenControl: true,
                mapTypeControl: true,
                styles: [{
                    "featureType": "poi",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }]
            };

            // Cria o mapa
            singleMap = new google.maps.Map(document.getElementById('singleLocationMap'), mapOptions);

            // Cria o marcador
            singleMarker = new google.maps.Marker({
                position: new google.maps.LatLng(latitude, longitude),
                map: singleMap,
                title: 'Imóvel #' + imovelId,
                icon: {
                    url: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
                }
            });

            // Cria o conteúdo do info window
            const contentString = `
            <div style="min-width: 150px;">
                <h5 style="margin: 5px 0; color: #333;">Imóvel #${imovelId}</h5>
                <p style="margin: 3px 0; font-size: 13px;"><strong>Tipo:</strong> ${tipo}</p>
                <p style="margin: 3px 0; font-size: 13px;"><strong>Bairro:</strong> ${bairro}</p>
                <p style="margin: 3px 0; font-size: 13px;"><strong>Área:</strong> ${area}</p>
                <a href="/amsilotti/public/imoveis/${imovelId}" target="_blank" style="display: inline-block; margin-top: 5px; color: #1a73e8; font-size: 13px;">Ver detalhes</a>
            </div>
        `;

            // Cria o info window
            const infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            // Abre o info window automaticamente
            infowindow.open(singleMap, singleMarker);

            // Adiciona o evento de clique no marcador
            singleMarker.addListener('click', function() {
                infowindow.open(singleMap, singleMarker);
            });
        }
    </script>

    <!-- impressao mapa  -->
    <script>
        // Adicionar evento para o botão de imprimir mapa (do modal existente)
        document.getElementById('printMapModalButton').addEventListener('click', function() {
            if (!map || selectedImoveis.length === 0) {
                alert('Mapa não está carregado ou não há imóveis selecionados.');
                return;
            }

            // Captura a imagem do mapa
            html2canvas(document.getElementById('map'), {
                useCORS: true,
                allowTaint: true,
                scale: 2
            }).then(function(canvas) {
                const mapImage = canvas.toDataURL('image/png');

                // Cria um formulário para enviar os dados
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('print.map') }}';
                form.target = '_blank'; // Adiciona target para nova aba
                form.style.display = 'none';

                // CSRF Token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Imagem do mapa
                const mapImageInput = document.createElement('input');
                mapImageInput.type = 'hidden';
                mapImageInput.name = 'map_image';
                mapImageInput.value = mapImage;
                form.appendChild(mapImageInput);

                // Dados dos imóveis
                const imoveisInput = document.createElement('input');
                imoveisInput.type = 'hidden';
                imoveisInput.name = 'imoveis_data';
                imoveisInput.value = JSON.stringify(selectedImoveis);
                form.appendChild(imoveisInput);

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }).catch(function(error) {
                console.error('Erro ao capturar o mapa:', error);
                alert('Erro ao capturar a imagem do mapa. Tente novamente.');
            });
        });
    </script>



    <!-- Adicionar biblioteca html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        $(document).ready(function() {
            // Máscara para área mínima e máxima
            $('#area_min, #area_max').mask('000.000.000,00', {
                reverse: true
            });

            // Validação do campo de códigos de imóveis
            $('#id').on('input', function() {
                var value = $(this).val();
                var isValid = true;
                var errorMessage = '';

                if (value.trim() !== '') {
                    // Verifica se contém apenas números, vírgulas e espaços
                    if (!/^[\d,\s]+$/.test(value)) {
                        isValid = false;
                        errorMessage = 'Digite apenas números separados por vírgula (ex: 80,81,85)';
                    } else {
                        // Verifica se há números válidos
                        var codes = value.split(',').map(function(code) {
                            return code.trim();
                        }).filter(function(code) {
                            return code !== '' && !isNaN(code) && parseInt(code) > 0;
                        });

                        if (codes.length === 0) {
                            isValid = false;
                            errorMessage = 'Digite códigos válidos (números maiores que 0)';
                        }
                    }
                }

                // Remove classes anteriores
                $(this).removeClass('is-valid is-invalid');
                $('.invalid-feedback').remove();

                if (value.trim() !== '') {
                    if (isValid) {
                        $(this).addClass('is-valid');

                        // Mostra quantos códigos foram detectados
                        if (value.includes(',')) {
                            var validCodes = value.split(',').map(function(code) {
                                return code.trim();
                            }).filter(function(code) {
                                return code !== '' && !isNaN(code) && parseInt(code) > 0;
                            });

                            $('<div class="valid-feedback">✓ ' + validCodes.length +
                                    ' código(s) detectado(s)</div>')
                                .insertAfter($(this));
                        }
                    } else {
                        $(this).addClass('is-invalid');
                        $('<div class="invalid-feedback">' + errorMessage + '</div>')
                            .insertAfter($(this));
                    }
                }
            });

            // Formatação automática (adiciona espaço após vírgulas)
            $('#id').on('blur', function() {
                var value = $(this).val();
                if (value.includes(',')) {
                    // Remove espaços extras e adiciona espaço após vírgulas
                    var formatted = value.split(',').map(function(code) {
                        return code.trim();
                    }).filter(function(code) {
                        return code !== '';
                    }).join(', ');
                    $(this).val(formatted);
                }
            });

            // Ao submeter o formulário, converter para formato numérico padrão
            $('form[action="{{ route('imoveis.index') }}"]').on('submit', function() {
                function toFloatBRL(val) {
                    if (!val) return '';
                    return val.replace(/\./g, '').replace(',', '.');
                }
                var min = $('#area_min').val();
                var max = $('#area_max').val();
                $('#area_min').val(toFloatBRL(min));
                $('#area_max').val(toFloatBRL(max));
            });
        });
    </script>

@endsection
