@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Gestão de Perfis (Roles)</h4>
                    <a href="{{ route('roles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Novo Perfil
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome do Perfil</th>
                                    <th>Permissões</th>
                                    <th>Usuários</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                <tr>
                                    <td>
                                        <strong>{{ ucfirst($role->name) }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($role->permissions->take(5) as $permission)
                                                <span class="badge bg-info">{{ $permission->name }}</span>
                                            @endforeach
                                            @if($role->permissions->count() > 5)
                                                <span class="badge bg-secondary">+{{ $role->permissions->count() - 5 }} mais</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $role->users->count() }} usuário(s)</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($role->users->count() == 0)
                                                <form method="POST" action="{{ route('roles.destroy', $role) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                            onclick="return confirm('Tem certeza que deseja excluir este perfil?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-outline-danger" disabled title="Não é possível excluir um perfil com usuários vinculados">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Nenhum perfil encontrado.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
