@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                        <h3 class="mb-0 text-primary"><i class="fas fa-users me-2"></i>Editar Membro da Equipe Técnica</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('membro-equipe-tecnicas.update', $membroEquipeTecnica->id) }}" method="POST" class="row g-3 needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="col-md-12 mb-3">
                                <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $membroEquipeTecnica->nome) }}" required>
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" class="form-control telefone-mask @error('telefone') is-invalid @enderror" id="telefone" name="telefone" value="{{ old('telefone', $membroEquipeTecnica->telefone) }}">
                                @error('telefone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cargo" class="form-label">Cargo <span class="text-danger">*</span></label>
                                <select class="form-select @error('cargo') is-invalid @enderror" id="cargo" name="cargo" required>
                                    <option value="">Selecione um cargo</option>
                                    <option value="Assistente Técnica" {{ (old('cargo', $membroEquipeTecnica->cargo) == 'Assistente Técnica') ? 'selected' : '' }}>Assistente Técnica</option>
                                    <option value="Perita Judicial" {{ (old('cargo', $membroEquipeTecnica->cargo) == 'Perita Judicial') ? 'selected' : '' }}>Perita Judicial</option>
                                </select>
                                @error('cargo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary me-md-2">
                                        <i class="fa-solid fa-floppy-disk me-1"></i> Salvar Alterações
                                    </button>
                                    <a href="{{ route('membro-equipe-tecnicas.index') }}" class="btn btn-outline-secondary">
                                        <i class="fa-solid fa-arrow-left me-1"></i> Cancelar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Telefone mask
        const telefoneInputs = document.querySelectorAll('.telefone-mask');
        telefoneInputs.forEach(function(input) {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) {
                    value = value.substring(0, 11);
                }

                let formattedValue = '';
                if (value.length > 0) {
                    formattedValue = '(' + value.substring(0, 2);
                    if (value.length > 2) {
                        formattedValue += ') ' + value.substring(2, 7);
                        if (value.length > 7) {
                            formattedValue += '-' + value.substring(7, 11);
                        }
                    }
                }

                e.target.value = formattedValue;
            });
        });
    });
</script>
@endpush
@endsection
