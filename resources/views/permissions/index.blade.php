@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Gestão de Permissões e Roles</h1>

            <!-- Navegação por Tabs -->
            <ul class="nav nav-tabs" id="permissionTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">
                        Usuários
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles" type="button" role="tab">
                        Roles
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions" type="button" role="tab">
                        Permissões
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="permissionTabsContent">
                <!-- Tab Usuários -->
                <div class="tab-pane fade show active" id="users" role="tabpanel">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Usuários e suas Roles/Permissões</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Roles</th>
                                            <th>Permissões Diretas</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @foreach($user->roles as $role)
                                                    <span class="badge bg-primary me-1">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($user->permissions as $permission)
                                                    <span class="badge bg-secondary me-1">{{ $permission->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" onclick="editUserPermissions({{ $user->id }})">
                                                    Editar
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Roles -->
                <div class="tab-pane fade" id="roles" role="tabpanel">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Roles e suas Permissões</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Role</th>
                                            <th>Permissões</th>
                                            <th>Usuários com esta Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $role)
                                        <tr>
                                            <td><strong>{{ $role->name }}</strong></td>
                                            <td>
                                                @foreach($role->permissions as $permission)
                                                    <span class="badge bg-info me-1">{{ $permission->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @php
                                                    $usersWithRole = $users->filter(function($user) use ($role) {
                                                        return $user->hasRole($role->name);
                                                    });
                                                @endphp
                                                {{ $usersWithRole->count() }} usuário(s)
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Permissões -->
                <div class="tab-pane fade" id="permissions" role="tabpanel">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Todas as Permissões</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-md-4 mb-2">
                                        <div class="card">
                                            <div class="card-body py-2">
                                                <small>{{ $permission->name }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Permissões do Usuário -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Permissões do Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId" name="user_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Usuário:</label>
                        <p id="editUserName" class="fw-bold"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Roles:</label>
                        <div id="rolesCheckboxes">
                            @foreach($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}">
                                <label class="form-check-label" for="role_{{ $role->id }}">
                                    {{ $role->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveUserPermissions()">Salvar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function editUserPermissions(userId) {
    // Buscar dados do usuário
    fetch(`/permissions/user/${userId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editUserId').value = userId;
            document.getElementById('editUserName').textContent = data.user.name;
            
            // Limpar checkboxes
            document.querySelectorAll('input[name="roles[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Marcar roles atuais
            data.roles.forEach(role => {
                const checkbox = document.querySelector(`input[value="${role}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
            
            // Abrir modal
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao carregar dados do usuário');
        });
}

function saveUserPermissions() {
    const formData = new FormData(document.getElementById('editUserForm'));
    
    fetch('/permissions/sync-roles', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao salvar permissões');
    });
}
</script>
@endsection
