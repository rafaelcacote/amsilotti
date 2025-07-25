@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-user-tie me-2"></i>Detalhes do Cliente</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit me-2"></i>Editar
                                </a>
                                <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">Informações Básicas</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Nome</h6>
                                <p class="mb-0 fw-bold">{{ $cliente->nome }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Empresa</h6>
                                <p class="mb-0 fw-bold">{{ $cliente->empresa }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Nome do Responsável</h6>
                                <p class="mb-0 fw-bold">{{ $cliente->nome_responsavel }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">Informações Adicionais</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Profissão</h6>
                                <p class="mb-0 fw-bold">{{ $cliente->profissao }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Email</h6>
                                <p class="mb-0 fw-bold">{{ $cliente->email }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Telefone</h6>
                                <p class="mb-0 fw-bold">{{ $cliente->telefone }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Tipo</h6>
                                <p class="mb-0 fw-bold">{{ $cliente->tipo }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0">Ações</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit me-2"></i>Editar
                                </a>
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                        <i class="fas fa-trash me-2"></i>Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
