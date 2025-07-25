@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                        <h3 class="mb-0 text-primary">
                            <i class="fas fa-shield-alt me-2"></i>Gerenciamento de Permissões
                        </h3>
                        <div class="ms-auto d-flex gap-2">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#createModuleModal">
                                <i class="fas fa-plus-circle me-1"></i> Criar Módulo
                            </button>
                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i> Nova Permissão
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs mb-4" id="permissionTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="permissions-tab" data-bs-toggle="tab" 
                                    data-bs-target="#permissions" type="button" role="tab" aria-controls="permissions" aria-selected="true">
                                    <i class="fas fa-key me-1"></i> Permissões por Grupo
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="roles-tab" data-bs-toggle="tab" 
                                    data-bs-target="#roles" type="button" role="tab" aria-controls="roles" aria-selected="false">
                                    <i class="fas fa-users me-1"></i> Permissões por Role
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="permissionTabsContent">
                            <!-- Permissões por Grupo -->
                            <div class="tab-pane fade show active" id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
                                <div class="accordion" id="permissionsAccordion">
                                    @foreach($groupedPermissions as $groupName => $permissions)
                                    <div class="accordion-item mb-3">
                                        <h2 class="accordion-header" id="heading{{ Str::slug($groupName) }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                data-bs-target="#collapse{{ Str::slug($groupName) }}" aria-expanded="false" 
                                                aria-controls="collapse{{ Str::slug($groupName) }}">
                                                <i class="fas fa-folder me-2"></i>{{ $groupName }}
                                                <span class="badge bg-primary ms-2">{{ count($permissions) }} permissões</span>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ Str::slug($groupName) }}" class="accordion-collapse collapse" 
                                            aria-labelledby="heading{{ Str::slug($groupName) }}" data-bs-parent="#permissionsAccordion">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    @foreach($permissions as $permission)
                                                    <div class="col-md-6 col-lg-4 mb-2">
                                                        <div class="d-flex justify-content-between align-items-center p-2 border rounded">
                                                            <span>
                                                                <i class="fas fa-key text-muted me-2"></i>
                                                                {{ $permission->name }}
                                                            </span>
                                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                                data-bs-toggle="modal" data-bs-target="#deletePermissionModal"
                                                                data-permission-id="{{ $permission->id }}"
                                                                data-permission-name="{{ $permission->name }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Permissões por Role -->
                            <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">
                                @foreach($roles as $role)
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-user-tag me-2"></i>{{ ucfirst($role->name) }}
                                            <span class="badge bg-success ms-2">{{ $role->permissions->count() }} permissões</span>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('admin.permissions.assign-role') }}">
                                            @csrf
                                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                                            
                                            <div class="accordion" id="rolePermissionsAccordion{{ $role->id }}">
                                                @foreach($groupedPermissions as $groupName => $groupPermissions)
                                                <div class="accordion-item mb-2">
                                                    <h2 class="accordion-header" id="roleHeading{{ $role->id }}{{ Str::slug($groupName) }}">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                            data-bs-target="#roleCollapse{{ $role->id }}{{ Str::slug($groupName) }}" aria-expanded="false" 
                                                            aria-controls="roleCollapse{{ $role->id }}{{ Str::slug($groupName) }}">
                                                            <i class="fas fa-folder me-2"></i>{{ $groupName }}
                                                            <span class="badge bg-secondary ms-2">{{ count($groupPermissions) }} permissões</span>
                                                        </button>
                                                    </h2>
                                                    <div id="roleCollapse{{ $role->id }}{{ Str::slug($groupName) }}" class="accordion-collapse collapse" 
                                                        aria-labelledby="roleHeading{{ $role->id }}{{ Str::slug($groupName) }}" 
                                                        data-bs-parent="#rolePermissionsAccordion{{ $role->id }}">
                                                        <div class="accordion-body">
                                                            @foreach($groupPermissions as $permission)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" 
                                                                    name="permissions[]" value="{{ $permission->id }}"
                                                                    id="permission_{{ $role->id }}_{{ $permission->id }}"
                                                                    {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}>
                                                                <label class="form-check-label small" for="permission_{{ $role->id }}_{{ $permission->id }}">
                                                                    <i class="fas fa-key text-muted me-1"></i>{{ $permission->name }}
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            
                                            <div class="mt-3">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i> Salvar Permissões para {{ ucfirst($role->name) }}
                                                </button>
                                            </div>
                                        </form>
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

<!-- Modal para Criar Módulo -->
<div class="modal fade" id="createModuleModal" tabindex="-1" aria-labelledby="createModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createModuleModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Criar Novo Módulo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.permissions.create-module') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="module_name" class="form-label">
                            <i class="fas fa-cube me-1"></i>Nome do Módulo
                        </label>
                        <input type="text" class="form-control form-control-lg" id="module_name" name="module_name" 
                            placeholder="Ex: relatorios, configuracoes" required>
                        <div class="form-text">Use apenas letras minúsculas, números e hífens</div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-key me-1"></i>Permissões do Módulo
                        </label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary">Permissões Básicas</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="view" id="perm_view" checked>
                                            <label class="form-check-label" for="perm_view">
                                                <i class="fas fa-eye text-info me-1"></i>Visualizar (view)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="create" id="perm_create">
                                            <label class="form-check-label" for="perm_create">
                                                <i class="fas fa-plus text-success me-1"></i>Criar (create)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="edit" id="perm_edit">
                                            <label class="form-check-label" for="perm_edit">
                                                <i class="fas fa-edit text-warning me-1"></i>Editar (edit)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary">Permissões Avançadas</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="delete" id="perm_delete">
                                            <label class="form-check-label" for="perm_delete">
                                                <i class="fas fa-trash text-danger me-1"></i>Excluir (delete)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="export" id="perm_export">
                                            <label class="form-check-label" for="perm_export">
                                                <i class="fas fa-download text-primary me-1"></i>Exportar (export)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="print" id="perm_print">
                                            <label class="form-check-label" for="perm_print">
                                                <i class="fas fa-print text-secondary me-1"></i>Imprimir (print)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-users me-1"></i>Atribuir aos Roles
                        </label>
                        <div class="row">
                            @foreach($roles as $role)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}">
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        <i class="fas fa-user-tag me-1"></i>{{ ucfirst($role->name) }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>Criar Módulo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Confirmação de Exclusão de Permissão -->
<div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-labelledby="deletePermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deletePermissionModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                </div>
                <h5 class="mb-3">Tem certeza que deseja excluir esta permissão?</h5>
                <div class="alert alert-light border border-danger">
                    <strong>Permissão:</strong> <span id="permissionNameToDelete" class="text-primary"></span>
                </div>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Atenção!</strong> Esta ação não pode ser desfeita e pode afetar o funcionamento do sistema.
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancelar
                </button>
                <form id="deletePermissionForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash me-1"></i> Sim, Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Sucesso</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">{{ session('success') }}</div>
    </div>
</div>
@endif

@if(session('error'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong class="me-auto">Erro</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">{{ session('error') }}</div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide toasts
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach(toast => {
        setTimeout(() => {
            const bsToast = new bootstrap.Toast(toast);
            bsToast.hide();
        }, 5000);
    });

    // Controle do Modal de Exclusão de Permissão
    const deletePermissionModal = document.getElementById('deletePermissionModal');
    const deletePermissionForm = document.getElementById('deletePermissionForm');
    const permissionNameToDelete = document.getElementById('permissionNameToDelete');

    deletePermissionModal.addEventListener('show.bs.modal', function (event) {
        // Botão que abriu o modal
        const button = event.relatedTarget;
        
        // Extrair dados do botão
        const permissionId = button.getAttribute('data-permission-id');
        const permissionName = button.getAttribute('data-permission-name');
        
        // Atualizar o conteúdo do modal
        permissionNameToDelete.textContent = permissionName;
        
        // Atualizar a action do formulário
        const actionUrl = `{{ route('admin.permissions.destroy', ':id') }}`.replace(':id', permissionId);
        deletePermissionForm.setAttribute('action', actionUrl);
    });
});
</script>

<style>
/* Estilização customizada para os modais */
.modal-content {
    border-radius: 15px;
    overflow: hidden;
}

.modal-header {
    border-radius: 15px 15px 0 0;
    padding: 1.5rem;
}

.modal-body {
    padding: 2rem;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
    padding: 1.5rem;
}

/* Animação para o ícone de exclusão */
.modal .fas.fa-trash-alt {
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 20%, 40%, 60%, 80%, 100% {
        transform: translateX(0);
    }
    10%, 30%, 50%, 70%, 90% {
        transform: translateX(-5px);
    }
}

/* Cards das permissões no modal */
.modal .card {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.modal .card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Botões customizados */
.btn {
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Form checks customizados */
.form-check {
    margin-bottom: 0.75rem;
}

.form-check-label {
    cursor: pointer;
    display: flex;
    align-items: center;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

/* Estilização para os accordions */
.accordion-item {
    border: 1px solid #dee2e6;
    border-radius: 8px !important;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.accordion-button {
    background-color: #f8f9fa;
    color: #495057;
    font-weight: 500;
    padding: 1rem 1.25rem;
    border: none;
}

.accordion-button:not(.collapsed) {
    background-color: #e3f2fd;
    color: #1976d2;
    box-shadow: none;
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.accordion-button::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23495057'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

.accordion-button:not(.collapsed)::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%231976d2'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    transform: rotate(-180deg);
}

.accordion-body {
    padding: 1.25rem;
    background-color: #ffffff;
}

/* Animação suave para o collapse */
.accordion-collapse {
    transition: all 0.3s ease;
}

/* Badge customizado no accordion */
.accordion-button .badge {
    font-size: 0.75rem;
}
</style>
@endsection
