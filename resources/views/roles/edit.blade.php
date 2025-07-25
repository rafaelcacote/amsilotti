@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Editar Perfil: {{ ucfirst($role->name) }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('roles.update', $role) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Perfil</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $role->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Permissões</label>
                            <div class="row">
                                @foreach($permissions as $module => $modulePermissions)
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="card">
                                            <div class="card-header py-2">
                                                <h6 class="mb-0">{{ ucfirst($module) }}</h6>
                                                <small>
                                                    <input type="checkbox" class="form-check-input me-1" 
                                                           onchange="toggleModule(this, '{{ $module }}')"
                                                           {{ $modulePermissions->every(fn($p) => in_array($p->name, $rolePermissions)) ? 'checked' : '' }}>
                                                    Selecionar todos
                                                </small>
                                            </div>
                                            <div class="card-body py-2">
                                                @foreach($modulePermissions as $permission)
                                                    <div class="form-check">
                                                        <input class="form-check-input module-{{ $module }}" 
                                                               type="checkbox" 
                                                               name="permissions[]" 
                                                               value="{{ $permission->name }}" 
                                                               id="permission_{{ $permission->id }}"
                                                               {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleModule(checkbox, module) {
    const moduleCheckboxes = document.querySelectorAll('.module-' + module);
    moduleCheckboxes.forEach(cb => {
        cb.checked = checkbox.checked;
    });
}
</script>
@endsection
