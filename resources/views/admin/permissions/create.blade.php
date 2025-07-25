@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                        <h3 class="mb-0 text-primary">
                            <i class="fas fa-key me-2"></i>Nova Permissão
                        </h3>
                        <div class="ms-auto">
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.permissions.store') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome da Permissão</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" value="{{ old('name') }}" 
                                    placeholder="Ex: view relatorios, create configuracoes" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Use o formato: <strong>ação módulo</strong> (ex: view clientes, create tarefas, edit agenda)
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="group" class="form-label">Grupo/Módulo</label>
                                <input type="text" class="form-control @error('group') is-invalid @enderror" 
                                    id="group" name="group" value="{{ old('group') }}" 
                                    placeholder="Ex: clientes, tarefas, agenda" list="existingGroups" required>
                                @error('group')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <datalist id="existingGroups">
                                    @foreach($existingGroups as $group)
                                        <option value="{{ $group }}">
                                    @endforeach
                                </datalist>
                                <div class="form-text">
                                    Escolha um grupo existente ou crie um novo
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição (Opcional)</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                    id="description" name="description" rows="3" 
                                    placeholder="Descrição detalhada da permissão">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Dica:</strong> Após criar a permissão, você poderá atribuí-la aos roles na tela de gerenciamento.
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary me-md-2">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Criar Permissão
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Card de Ajuda -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-question-circle me-2"></i>Como criar permissões?
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6>Padrões de nomenclatura:</h6>
                        <ul>
                            <li><code>view [módulo]</code> - Para visualizar dados</li>
                            <li><code>create [módulo]</code> - Para criar novos registros</li>
                            <li><code>edit [módulo]</code> - Para editar registros</li>
                            <li><code>delete [módulo]</code> - Para excluir registros</li>
                            <li><code>export [módulo]</code> - Para exportar dados</li>
                            <li><code>print [módulo]</code> - Para imprimir relatórios</li>
                        </ul>
                        
                        <h6 class="mt-3">Exemplos:</h6>
                        <ul>
                            <li><code>view financeiro</code></li>
                            <li><code>create fornecedores</code></li>
                            <li><code>edit configuracoes</code></li>
                            <li><code>delete backup</code></li>
                            <li><code>export relatorios-financeiros</code></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const groupInput = document.getElementById('group');
    
    // Auto-preenchimento do grupo baseado no nome
    nameInput.addEventListener('input', function() {
        const name = this.value;
        const parts = name.split(' ');
        
        if (parts.length > 1) {
            const action = parts[0];
            const module = parts.slice(1).join(' ');
            
            if (module && !groupInput.value) {
                groupInput.value = module;
            }
        }
    });
});
</script>
@endsection
