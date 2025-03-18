@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-user-tie me-2"></i>Clientes</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('clientes.create') }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                    <span>Novo Cliente</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Filtro -->
                            <form action="{{ route('clientes.index') }}" method="GET">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label" for="search">Buscar</label>
                                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Buscar por nome, empresa ou email..."
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search me-2"></i>Pesquisar</button>
                                            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times me-2"></i>Limpar</a>
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
                                            <th class="px-4 py-3 border-bottom-0">Nome</th>
                                            <th class="px-4 py-3 border-bottom-0">Empresa</th>
                                            <th class="px-4 py-3 border-bottom-0">Email</th>
                                            <th class="px-4 py-3 border-bottom-0">Telefone</th>
                                            <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($clientes->count() > 0)
                                            @foreach($clientes as $cliente)
                                                <tr class="border-bottom border-light">
                                                    <td class="px-4">{{ $cliente->nome }}</td>
                                                    <td class="px-4">{{ $cliente->empresa }}</td>
                                                    <td class="px-4">{{ $cliente->email }}</td>
                                                    <td class="px-4">{{ $cliente->telefone }}</td>
                                                    <td class="px-4">
                                                        <div class="d-flex gap-2">
                                                            <a class="btn btn-light" href="{{ route('clientes.show', $cliente) }}">
                                                                <i class="fa-solid fa-magnifying-glass text-info"></i>
                                                            </a>
                                                            <a class="btn btn-light" href="{{ route('clientes.edit', $cliente) }}">
                                                                <i class="fa-solid fa-pen-to-square text-warning"></i>
                                                            </a>
                                                            <x-delete-modal
                                                                :id="$cliente->id"
                                                                title="Confirmar Exclusão"
                                                                message="Tem certeza que deseja excluir este cliente?"
                                                                :route="route('clientes.destroy', $cliente)"
                                                                buttonLabel="Excluir"
                                                            />
                                                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $cliente->id }}">
                                                                <i class="fa-solid fa-trash-can text-danger"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
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
                                {{ $clientes->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection