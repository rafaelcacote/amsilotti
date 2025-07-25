@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-users me-2"></i>Usuários</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('users.create') }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                    <span>Novo Usuário</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <!-- Filtro (se necessário) -->
                            <form action="{{ route('users.index') }}" method="GET">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label" for="name">Nome</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ request('name') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            value="{{ request('email') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="cpf">CPF</label>
                                        <input type="text" class="form-control" id="cpf" name="cpf"
                                            value="{{ request('cpf') }}" placeholder="000.000.000-00">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-search me-2"></i>Pesquisar</button>
                                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary"><i
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
                                            <th class="px-4 py-3 border-bottom-0">Nome</th>
                                            <th class="px-4 py-3 border-bottom-0">Email</th>
                                            <th class="px-4 py-3 border-bottom-0">CPF</th>
                                            <th class="px-4 py-3 border-bottom-0">Perfis</th>
                                            <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($users->count() > 0)
                                            @foreach ($users as $user)
                                                <tr class="border-bottom border-light">
                                                    <td class="px-4 fw-medium text-muted">{{ $user->name }}</td>
                                                    <td class="px-4">{{ $user->email }}</td>
                                                    <td class="px-4">{{ $user->cpf ?? '-' }}</td>
                                                    <td class="px-4">
                                                        @forelse($user->roles as $role)
                                                            <span class="badge bg-primary me-1">{{ ucfirst($role->name) }}</span>
                                                        @empty
                                                            <span class="text-muted small">Sem perfil</span>
                                                        @endforelse
                                                    </td>
                                                    <td class="px-4">
                                                        <x-action-buttons showRoute="users.show" editRoute="users.edit"
                                                            destroyRoute="users.destroy" :itemId="$user->id" :showButton="true"
                                                            :deleteButton="$user->email !== 'admin@admin.com'" />
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
                                {{ $users->links('vendor.pagination.simple-coreui') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@include('components.delete-modal', [
    'title' => 'Confirmar exclusão',
    'message' => 'Tem certeza que deseja excluir este usuário?',
])
