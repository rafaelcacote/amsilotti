{{-- Exemplos de uso das diretivas Blade do Spatie Permission --}}

{{-- Verificar se o usuário tem uma role específica --}}
@role('administrador')
    <div class="admin-panel">
        <h3>Painel Administrativo</h3>
        <p>Você tem acesso total ao sistema.</p>
    </div>
@endrole

{{-- Verificar se o usuário tem qualquer uma das roles --}}
@hasanyrole('administrador|supervisor')
    <div class="management-tools">
        <a href="{{ route('permissions.index') }}" class="btn btn-primary">
            Gerenciar Permissões
        </a>
    </div>
@endhasanyrole

{{-- Verificar se o usuário tem todas as roles --}}
@hasallroles('administrador|tecnico')
    <p>Você tem ambas as roles: administrador e técnico.</p>
@endhasallroles

{{-- Verificar se o usuário tem uma permissão específica --}}
@can('create clientes')
    <a href="{{ route('clientes.create') }}" class="btn btn-success">
        Criar Novo Cliente
    </a>
@endcan

{{-- Verificar se o usuário pode executar múltiplas ações --}}
@canany(['edit clientes', 'delete clientes'])
    <div class="cliente-actions">
        @can('edit clientes')
            <button class="btn btn-warning">Editar</button>
        @endcan
        
        @can('delete clientes')
            <button class="btn btn-danger">Excluir</button>
        @endcan
    </div>
@endcanany

{{-- Verificar se o usuário NÃO tem uma permissão --}}
@cannot('delete users')
    <p class="text-muted">Você não tem permissão para excluir usuários.</p>
@endcannot

{{-- Exemplo prático: Menu de navegação --}}
<nav class="navbar navbar-expand-lg">
    <div class="navbar-nav">
        {{-- Todos podem ver o dashboard --}}
        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        
        {{-- Apenas quem pode ver clientes --}}
        @can('view clientes')
            <a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a>
        @endcan
        
        {{-- Apenas quem pode ver imóveis --}}
        @can('view imoveis')
            <a class="nav-link" href="{{ route('imoveis.index') }}">Imóveis</a>
        @endcan
        
        {{-- Apenas quem pode ver vistorias --}}
        @can('view vistorias')
            <a class="nav-link" href="{{ route('vistorias.index') }}">Vistorias</a>
        @endcan
        
        {{-- Apenas administradores e supervisores --}}
        @hasanyrole('administrador|supervisor')
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    Relatórios
                </a>
                <ul class="dropdown-menu">
                    @can('view relatorios')
                        <li><a class="dropdown-item" href="{{ route('relatorios.index') }}">Ver Relatórios</a></li>
                    @endcan
                    @can('export relatorios')
                        <li><a class="dropdown-item" href="{{ route('relatorios.export') }}">Exportar</a></li>
                    @endcan
                </ul>
            </div>
        @endhasanyrole
        
        {{-- Apenas administradores --}}
        @role('administrador')
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    Administração
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('permissions.index') }}">Permissões</a></li>
                    <li><a class="dropdown-item" href="{{ route('users.index') }}">Usuários</a></li>
                    <li><a class="dropdown-item" href="{{ route('settings.index') }}">Configurações</a></li>
                </ul>
            </div>
        @endrole
    </div>
</nav>

{{-- Exemplo em uma tabela com ações condicionais --}}
<table class="table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            @canany(['edit users', 'delete users'])
                <th>Ações</th>
            @endcanany
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                @canany(['edit users', 'delete users'])
                    <td>
                        @can('edit users')
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                Editar
                            </a>
                        @endcan
                        
                        @can('delete users')
                            <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Tem certeza?')">
                                    Excluir
                                </button>
                            </form>
                        @endcan
                    </td>
                @endcanany
            </tr>
        @endforeach
    </tbody>
</table>

{{-- Exemplo com verificação usando Auth::user() --}}
@if(Auth::user()->hasRole('administrador'))
    <div class="alert alert-info">
        <strong>Modo Administrador Ativo</strong>
        <p>Você tem acesso completo ao sistema.</p>
    </div>
@endif

{{-- Exemplo com verificação múltipla --}}
@php
    $currentUser = Auth::user();
    $canManageClientes = $currentUser->can('create clientes') || $currentUser->can('edit clientes');
@endphp

@if($canManageClientes)
    <div class="cliente-management">
        <h4>Gestão de Clientes</h4>
        @can('create clientes')
            <a href="{{ route('clientes.create') }}" class="btn btn-success">Novo Cliente</a>
        @endcan
    </div>
@endif
