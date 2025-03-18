@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                        <h3 class="mb-0 text-primary"><i class="fa-solid fa-users me-2"></i>Membros da Equipe Técnica</h3>
                        <div class="d-flex gap-2">
                            <a href="{{ route('membro-equipe-tecnicas.create') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2" style="transition: all 0.2s ease;">
                                <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                <span>Novo Membro</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                        <!-- Filtros -->
                        <form action="{{ route('membro-equipe-tecnicas.index') }}" method="GET" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Buscar por nome..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-4">
                                    <select name="cargo" class="form-select">
                                        <option value="">Filtrar por cargo</option>
                                        <option value="Assistente Técnica" {{ request('cargo') == 'Assistente Técnica' ? 'selected' : '' }}>Assistente Técnica</option>
                                        <option value="Perita Judicial" {{ request('cargo') == 'Perita Judicial' ? 'selected' : '' }}>Perita Judicial</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                    <a href="{{ route('membro-equipe-tecnicas.index') }}" class="btn btn-outline-secondary">Limpar Filtros</a>
                                </div>
                            </div>
                        </form>

                        <!-- Tabela de Membros -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 border-bottom-0">#</th>
                                        <th class="px-4 py-3 border-bottom-0">Nome</th>
                                        <th class="px-4 py-3 border-bottom-0">Telefone</th>
                                        <th class="px-4 py-3 border-bottom-0">Cargo</th>
                                        <th class="px-4 py-3 border-bottom-0">Usuário</th>
                                        <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($membros->count() > 0)
                                        @foreach ($membros as $membro)
                                            <tr class="border-bottom border-light">
                                                <td class="px-4 fw-medium text-muted">
                                                    <strong>#{{ $membro->id }}</strong>
                                                </td>
                                                <td class="px-4">{{ $membro->nome }}</td>
                                                <td class="px-4">{{ $membro->telefone }}</td>
                                                <td class="px-4">
                                                    <span class="badge {{ $membro->cargo == 'Perita Judicial' ? 'bg-primary' : 'bg-info' }}">
                                                        {{ $membro->cargo }}
                                                    </span>
                                                </td>
                                                <td class="px-4">{{ $membro->usuario->name ?? '-' }}</td>
                                                <td class="px-4">
                                                    <div class="d-flex gap-2">
                                                        <a class="btn btn-light"
                                                            href="{{ route('membro-equipe-tecnicas.show', $membro->id) }}">
                                                            <i class="fa-solid fa-magnifying-glass text-info"></i>
                                                        </a>
                                                        <a class="btn btn-light"
                                                            href="{{ route('membro-equipe-tecnicas.edit', $membro->id) }}">
                                                            <i class="fa-solid fa-pen-to-square text-warning"></i>
                                                        </a>
                                                        <x-delete-modal
                                                            :id="$membro->id"
                                                            title="Confirmar Exclusão"
                                                            message="Tem certeza que deseja excluir o membro da equipe {{ $membro->nome }}?"
                                                            :route="route('membro-equipe-tecnicas.destroy', $membro->id)"
                                                            buttonLabel="Excluir"
                                                        />
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $membro->id }}">
                                                            <i class="fa-solid fa-trash-can text-danger"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <p class="text-muted mb-0">Nenhum membro encontrado.</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $membros->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection