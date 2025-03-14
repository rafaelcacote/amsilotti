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
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Filtro -->
                            <form action="{{ route('imoveis.index') }}" method="GET">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label" for="bairro">Bairro</label>
                                        <select class="form-select" id="bairro" name="bairro">
                                            <option value="">Todos</option>
                                            @foreach ($bairros as $bairro)
                                                <option value="{{ $bairro->id }}"
                                                    {{ request('bairro') == $bairro->id ? 'selected' : '' }}>
                                                    {{ $bairro->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="valor">Valor Estimado</label>
                                        <input type="number" class="form-control" id="valor" name="valor"
                                            placeholder="Valor Estimado" value="{{ request('valor') }}">
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
                                    <div class="col-md-3">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-search me-2"></i>Pesquisar</button>
                                            <a href="{{ route('imoveis.index') }}" class="btn btn-outline-secondary"><i
                                                    class="fas fa-times me-2"></i>Limpar</a>
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
                                <table class="table table-hover table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 border-bottom-0">Endereço</th>
                                            <th class="px-4 py-3 border-bottom-0">Bairro</th>
                                            <th class="px-4 py-3 border-bottom-0">Valor Estimado</th>
                                            <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($imoveis->count() > 0)
                                            @foreach ($imoveis as $imovel)
                                                <tr class="border-bottom border-light">
                                                    <td class="px-4">{{ $imovel->endereco }}</td>
                                                    <td class="px-4">{{ $imovel->bairro->nome }}</td>
                                                    <td class="px-4">R$
                                                        {{ number_format($imovel->valor_estimado, 2, ',', '.') }}</td>
                                                    <td class="px-4">
                                                        <div class="d-flex gap-2">
                                                            <a class="btn btn-light"
                                                                href="{{ route('imovel.show', $imovel->id) }}">
                                                                <i class="fa-solid fa-magnifying-glass text-info"></i>
                                                            </a>
                                                            <a class="btn btn-light"
                                                                href="{{ route('imovel.edit', $imovel->id) }}">
                                                                <i class="fa-solid fa-pen-to-square text-warning"></i>
                                                            </a>
                                                            <x-delete-modal :id="$imovel->id" title="Confirmar Exclusão"
                                                                message="Tem certeza que deseja excluir este imóvel?"
                                                                :route="route('imovel.destroy', $imovel->id)" buttonLabel="Excluir" />
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $imovel->id }}">
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
@endsection
