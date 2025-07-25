@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Gestão de Usuários e Permissões</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Usuário</th>
                                    <th>Email</th>
                                    <th>Perfis (Roles)</th>
                                    <th>Permissões Diretas</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @forelse($user->roles as $role)
                                            <span class="badge bg-primary me-1">{{ ucfirst($role->name) }}</span>
                                        @empty
                                            <span class="text-muted">Nenhum perfil</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        @forelse($user->permissions as $permission)
                                            <span class="badge bg-secondary me-1">{{ $permission->name }}</span>
                                        @empty
                                            <span class="text-muted">Nenhuma permissão direta</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('user-permissions.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <button class="btn btn-sm btn-outline-info" onclick="viewUserPermissions({{ $user->id }})">
                                                <i class="fas fa-eye"></i> Ver Todas
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Nenhum usuário encontrado.</td>
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

<!-- Modal para Ver Permissões -->
<div class="modal fade" id="viewPermissionsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Todas as Permissões do Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="userPermissionsContent">
                    <!-- Conteúdo carregado via AJAX -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function viewUserPermissions(userId) {
    fetch(`/user-permissions/user/${userId}/data`)
        .then(response => response.json())
        .then(data => {
            let content = `
                <h6><strong>Usuário:</strong> ${data.user.name}</h6>
                <hr>
                
                <div class="mb-3">
                    <h6>Perfis (Roles):</h6>
                    <div class="d-flex flex-wrap gap-1">
            `;
            
            if (data.roles.length > 0) {
                data.roles.forEach(role => {
                    content += `<span class="badge bg-primary">${role}</span>`;
                });
            } else {
                content += '<span class="text-muted">Nenhum perfil atribuído</span>';
            }
            
            content += `
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6>Permissões Diretas:</h6>
                    <div class="d-flex flex-wrap gap-1">
            `;
            
            if (data.direct_permissions.length > 0) {
                data.direct_permissions.forEach(permission => {
                    content += `<span class="badge bg-secondary">${permission}</span>`;
                });
            } else {
                content += '<span class="text-muted">Nenhuma permissão direta</span>';
            }
            
            content += `
                    </div>
                </div>
                
                <div>
                    <h6>Todas as Permissões (via Perfis + Diretas):</h6>
                    <div class="d-flex flex-wrap gap-1">
            `;
            
            if (data.permissions.length > 0) {
                data.permissions.forEach(permission => {
                    content += `<span class="badge bg-info">${permission}</span>`;
                });
            } else {
                content += '<span class="text-muted">Nenhuma permissão</span>';
            }
            
            content += '</div></div>';
            
            document.getElementById('userPermissionsContent').innerHTML = content;
            new bootstrap.Modal(document.getElementById('viewPermissionsModal')).show();
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao carregar permissões do usuário');
        });
}
</script>
@endsection
