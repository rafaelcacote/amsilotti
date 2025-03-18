@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-home me-2"></i>Imóveis</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('imoveis.create') }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                    <span>Novo Imóvel</span>
                                </a>
                                <button id="printSelected"
                                    class="btn btn-sm btn-outline-info d-flex align-items-center gap-2 px-3 py-2"
                                    style="display: none; transition: all 0.2s ease;">
                                    <i class="fas fa-print" style="font-size: 0.9rem;"></i>
                                    <span>Imprimir Selecionados</span>
                                </button>

                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Filtro -->
                            <form action="{{ route('imoveis.index') }}" method="GET">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label" for="bairro">Bairro</label>
                                        <select class="form-select" id="multiple-select-field" data-placeholder="Escolha o Bairro" name="bairro[]" multiple>
                                            <option value="">Todos</option>
                                            @foreach ($bairros as $bairro)
                                                <option value="{{ $bairro->id }}"
                                                    {{ in_array($bairro->id, (array)request('bairro')) ? 'selected' : '' }}>
                                                    {{ $bairro->nome }}
                                                </option>
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
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="area_min">Área Mínima (m²)</label>
                                        <input type="number" class="form-control" id="area_min" name="area_min"
                                            placeholder="Área Mínima" value="{{ request('area_min') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="area_max">Área Máxima (m²)</label>
                                        <input type="number" class="form-control" id="area_max" name="area_max"
                                            placeholder="Área Máxima" value="{{ request('area_max') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search me-2"></i>Pesquisar</button>
                                            <a href="{{ route('imoveis.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times me-2"></i>Limpar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                                            <th class="bg-body-secondary">#ID</th>
                                            <th class="bg-body-secondary">Tipo</th>
                                            <th class="bg-body-secondary">Bairro</th>
                                            <th class="bg-body-secondary">Area</th>
                                            <th class="bg-body-secondary text-center" style="width: 160px;">Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($imoveis->count() > 0)
                                            @foreach ($imoveis as $imovel)
                                                <tr class="border-bottom border-light">
                                                    <td>
                                                        <input type="checkbox" class="form-check-input imovel-checkbox"
                                                               value="{{ $imovel->id }}">
                                                    </td>
                                                    <td><strong>{{ $imovel->id }}</strong></td>
                                                    @if ($imovel->tipo == 'terreno')
                                                    <td class="px-4">Terreno</td>
                                                    @elseif ($imovel->tipo == 'apartamento')
                                                    <td class="px-4">Apartamento</td>
                                                    @elseif ($imovel->tipo == 'imovel_urbano')
                                                    <td class="px-4">Imóvel Urbano</td>
                                                    @elseif ($imovel->tipo == 'galpao')
                                                    <td class="px-4">Galpão</td>

                                                    @endif

                                                    <td class="px-4">{{ $imovel->bairro->nome }}</td>
                                                    <td class="px-4">
                                                        @if ($imovel->tipo == 'terreno')
                                                            <div class="fw-semibold text-nowrap">Área Terreno </div>
                                                            <div class="small text-body-secondary">{{ $imovel->area_total }} m²</div>
                                                        @elseif ($imovel->tipo == 'apartamento')
                                                        <div class="fw-semibold text-nowrap">Área Construída </div>
                                                        <div class="small text-body-secondary">{{ $imovel->area_construida }} m²</div>
                                                        @elseif ($imovel->tipo == 'imovel_urbano' || $imovel->tipo == 'galpao')
                                                            <div class="d-flex gap-3">
                                                                <div>
                                                                    <div class="fw-semibold text-nowrap">Área Construída</div>
                                                                    <div class="small text-body-secondary">{{ $imovel->area_construida }} m²</div>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-semibold text-nowrap">Área Terreno</div>
                                                                    <div class="small text-body-secondary">{{ $imovel->area_total }} m²</div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td class="px-4">
                                                        <div class="d-flex gap-2">
                                                            <a class="btn btn-light"
                                                                href="{{ route('imoveis.show', $imovel->id) }}"
                                                                data-coreui-toggle="tooltip"
                                                                data-coreui-placement="top"
                                                                title="Visualizar Amostra">
                                                                <i class="fa-solid fa-magnifying-glass text-info"></i>
                                                            </a>
                                                            <a class="btn btn-light"
                                                                href="{{ route('imoveis.edit', $imovel->id) }}"
                                                                data-coreui-toggle="tooltip"
                                                                data-coreui-placement="top"
                                                                title="Editar Amostra">
                                                                <i class="fa-solid fa-pen-to-square text-warning"></i>
                                                            </a>
                                                            <a class="btn btn-light"
                                                            href="{{ route('gerar.pdf', $imovel->id) }}"
                                                            target="_blank"
                                                            data-coreui-toggle="tooltip"
                                                            data-coreui-placement="top"
                                                            title="Imprimir Amostra">
                                                            <i class="fa-solid fa-print text-info"></i>
                                                        </a>
                                                            <x-delete-modal :id="$imovel->id" title="Confirmar Exclusão"
                                                                message="Tem certeza que deseja excluir este imóvel?"
                                                                :route="route('imoveis.destroy', $imovel->id)" buttonLabel="Excluir" />
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $imovel->id }}"
                                                                data-coreui-toggle="tooltip"
                                                                data-coreui-placement="top"
                                                                title="Excluir Amostra">
                                                                <i class="fa-solid fa-trash-can text-danger"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
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
                            <div class="d-flex justify-content-end mt-3">
                                {{ $imoveis->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.imovel-checkbox');
            const printButton = document.getElementById('printSelected');

            // Selecionar todos
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                togglePrintButton();
            });

            // Atualizar botão de impressão
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', togglePrintButton);
            });

            function togglePrintButton() {
                const checked = document.querySelectorAll('.imovel-checkbox:checked');
                printButton.style.display = checked.length > 0 ? 'flex' : 'none';
            }

            // Ação do botão de impressão
            printButton.addEventListener('click', function() {
                const selectedIds = Array.from(document.querySelectorAll('.imovel-checkbox:checked'))
                                        .map(checkbox => checkbox.value)
                                        .join(',');

                if(selectedIds) {
                    window.open('/imoveis/print-selected?ids=' + selectedIds, '_blank');
                }
            });
        });
        </script>
@endsection
