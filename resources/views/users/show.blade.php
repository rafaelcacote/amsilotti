@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-user me-2"></i>Detalhes do Usuário</h3>
                            <div class="d-flex gap-2">
                                @can('edit users')
                                    <a href="{{ route('users.edit', $user->id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit me-2"></i>Editar
                                    </a>
                                @endcan
                                <a href="{{ route('users.index') }}" 
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Voltar
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Nome</label>
                                        <p class="form-control-plaintext">{{ $user->name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Email</label>
                                        <p class="form-control-plaintext">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">CPF</label>
                                        <p class="form-control-plaintext">{{ $user->cpf ?? 'Não informado' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Data de Criação</label>
                                        <p class="form-control-plaintext">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Perfis de Acesso</label>
                                        <div>
                                            @forelse($user->roles as $role)
                                                <span class="badge bg-primary me-2 mb-1">{{ ucfirst($role->name) }}</span>
                                            @empty
                                                <span class="text-muted">Nenhum perfil atribuído</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                @if($user->permissions->count() > 0)
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Permissões Diretas</label>
                                            <div>
                                                @foreach($user->permissions as $permission)
                                                    <span class="badge bg-success me-1 mb-1">{{ $permission->name }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
