@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-bottom py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-key me-2"></i>Alterar Senha</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('users.update-password') }}" method="POST"
                                class="row g-3 needs-validation" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="col-12">
                                    <label class="form-label" for="password">Nova Senha</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="password_confirmation">Confirmar Nova Senha</label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" name="password_confirmation" required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>
                                        Salvar</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary"><i
                                            class="fa-solid fa-arrow-left"></i> Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
