@extends('layouts.app')

@section('content')
<div class="container">
    <h2>🔐 Teste de Permissões</h2>
    
    <div class="alert alert-info">
        <strong>Usuário Logado:</strong> {{ auth()->user()->name ?? 'Não logado' }}<br>
        <strong>Email:</strong> {{ auth()->user()->email ?? 'N/A' }}
    </div>

    <h4>🎭 Roles do Usuário:</h4>
    @if(auth()->user())
        <div class="mb-3">
            @forelse(auth()->user()->roles as $role)
                <span class="badge bg-primary me-1">{{ $role->name }}</span>
            @empty
                <span class="text-muted">Nenhuma role atribuída</span>
            @endforelse
        </div>
    @endif

    <h4>🔑 Teste de Permissões:</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Permissões de Usuários</h5>
                </div>
                <div class="card-body">
                    @can('view users')
                        <p class="text-success">✅ Pode ver usuários</p>
                    @else
                        <p class="text-danger">❌ NÃO pode ver usuários</p>
                    @endcan

                    @can('create users')
                        <p class="text-success">✅ Pode criar usuários</p>
                    @else
                        <p class="text-danger">❌ NÃO pode criar usuários</p>
                    @endcan

                    @can('manage settings')
                        <p class="text-success">✅ Pode gerenciar configurações</p>
                    @else
                        <p class="text-danger">❌ NÃO pode gerenciar configurações</p>
                    @endcan
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Teste de Roles</h5>
                </div>
                <div class="card-body">
                    @role('administrador')
                        <p class="text-success">✅ É ADMINISTRADOR</p>
                    @else
                        <p class="text-warning">⚠️ NÃO é administrador</p>
                    @endrole

                    @hasanyrole('administrador|supervisor')
                        <p class="text-success">✅ É administrador OU supervisor</p>
                    @else
                        <p class="text-warning">⚠️ NÃO é admin nem supervisor</p>
                    @endhasanyrole
                </div>
            </div>
        </div>
    </div>

    <h4>🔗 Links de Teste:</h4>
    <div class="d-flex gap-2 flex-wrap">
        @can('view users')
            <a href="{{ route('users.index') }}" class="btn btn-primary">👥 Usuários</a>
        @endcan

        @can('manage settings')
            <a href="{{ route('roles.index') }}" class="btn btn-success">🎭 Perfis</a>
            <a href="{{ route('permissions.index') }}" class="btn btn-warning">🔑 Permissões</a>
            <a href="{{ route('user-permissions.index') }}" class="btn btn-info">👤 Usuários & Permissões</a>
        @endcan
    </div>

    @if(auth()->user())
        <div class="mt-4">
            <h5>📋 Todas as Permissões do Usuário:</h5>
            <div class="d-flex flex-wrap gap-1">
                @foreach(auth()->user()->getAllPermissions() as $permission)
                    <span class="badge bg-secondary">{{ $permission->name }}</span>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
