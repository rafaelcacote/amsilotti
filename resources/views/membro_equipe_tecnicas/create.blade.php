@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-users me-2"></i>Novo Membro da Equipe Técnica</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('membro-equipe-tecnicas.store') }}" method="POST"
                                class="row g-3 needs-validation" novalidate>
                                @csrf
                                <div class="col-md-12 mb-3">
                                    <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                        id="nome" name="nome" value="{{ old('nome') }}" required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control phone @error('telefone') is-invalid @enderror"
                                        id="telefone" name="telefone" value="{{ old('telefone') }}">
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="cargo" class="form-label">Cargo <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('cargo') is-invalid @enderror" id="cargo"
                                        name="cargo" required>
                                        <option value="">Selecione um cargo</option>
                                        <option value="Assistente Técnica"
                                            {{ old('cargo') == 'Assistente Técnica' ? 'selected' : '' }}>Assistente Técnica
                                        </option>
                                        <option value="estagiario de arquitetura"
                                            {{ old('cargo') == 'estagiario de arquitetura' ? 'selected' : '' }}>Estagiário de Arquitetura
                                        </option>
                                         <option value="Engenheiro civil"
                                            {{ old('cargo') == 'Engenheiro civil' ? 'selected' : '' }}>Engenheiro civil
                                        </option>
                                        <option value="Perita Judicial"
                                            {{ old('cargo') == 'Perita Judicial' ? 'selected' : '' }}>Perita Judicial
                                        </option>
                                    </select>
                                    @error('cargo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="cargo" class="form-label">
                                        Usuário <strong><span class="login-warning">(opção disponível apenas para membros
                                                com login no sistema)</span></strong>
                                    </label>
                                    <select class="form-select @error('cargo') is-invalid @enderror" id="user_id"
                                        name="user_id" required>
                                        <option value="">Selecionar</option>
                                        @foreach ($usuarios as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('user_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cargo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary me-md-2">
                                            <i class="fa-solid fa-floppy-disk me-1"></i> Salvar
                                        </button>
                                        <a href="{{ route('membro-equipe-tecnicas.index') }}"
                                            class="btn btn-outline-secondary">
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

    <style>
        .login-warning {
            color: red;
            /* Cor vermelha */
            font-size: 0.6em;
            /* Tamanho da fonte menor */
            font-weight: normal;
            /* Remove o negrito, se necessário */
        }
    </style>
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
