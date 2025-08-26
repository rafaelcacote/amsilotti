@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-user-plus me-2"></i>Criar Novo Usuário</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('users.store') }}" method="POST" class="row g-3 needs-validation"
                                novalidate>
                                @csrf
                                <div class="col-md-12">
                                    <label class="form-label" for="name">Nome</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="cpf">CPF</label>
                                    <input type="text" class="form-control @error('cpf') is-invalid @enderror"
                                        id="cpf" name="cpf" value="{{ old('cpf') }}" maxlength="11"
                                        pattern="[0-9]*" inputmode="numeric" placeholder="Somente números (11 dígitos)">
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="password">Senha</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="password_confirmation">Confirmar Senha</label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" name="password_confirmation" required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @can('manage settings')
                                    <div class="col-md-12">
                                        <label class="form-label">Perfis de Acesso</label>
                                        <div class="row">
                                            @foreach ($roles as $role)
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="roles[]"
                                                            value="{{ $role->name }}" id="role_{{ $role->id }}"
                                                            {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                                            {{ ucfirst($role->name) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('roles')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endcan

                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary me-md-2"><i
                                                class="fa-solid fa-floppy-disk"></i> Salvar</button>
                                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary"><i
                                                class="fa-solid fa-arrow-left"></i> Cancelar</a>
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
        // Máscara para CPF - somente números, máximo 11 dígitos
        document.getElementById('cpf').addEventListener('input', function(e) {
            // Remove tudo que não for número
            let value = e.target.value.replace(/\D/g, '');

            // Limita a 11 dígitos
            if (value.length > 11) {
                value = value.substring(0, 11);
            }

            e.target.value = value;
        });

        // Impede a digitação de caracteres não numéricos
        document.getElementById('cpf').addEventListener('keypress', function(e) {
            // Permite apenas números (0-9), backspace, delete, tab, escape, enter
            if (!/[0-9]/.test(e.key) && !['Backspace', 'Delete', 'Tab', 'Escape', 'Enter', 'ArrowLeft',
                    'ArrowRight', 'ArrowUp', 'ArrowDown'
                ].includes(e.key)) {
                e.preventDefault();
            }
        });
    </script>
@endpush
