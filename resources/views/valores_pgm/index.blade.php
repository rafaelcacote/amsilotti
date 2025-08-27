@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-dollar-sign me-2"></i>Valores PGM</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('valores_pgm.upload') }}"
                                    class="btn btn-sm btn-outline-success d-flex align-items-center gap-2 px-3 py-2">
                                    <i class="fas fa-upload" style="font-size: 0.9rem;"></i>
                                    <span>Upload em Massa</span>
                                </a>
                                <a href="{{ route('valores_pgm.create') }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2">
                                    <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                    <span>Novo Valor</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-hover table-striped bg-white rounded shadow-sm">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Bairro</th>
                                            <th>Zona</th>
                                            <th>Vigência</th>
                                            <th>Valor</th>
                                            <th width="120">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($valores as $valor)
                                            <tr>
                                                <td>{{ $valor->id }}</td>
                                                <td>{{ $valor->bairro->nome }}</td>
                                                <td>{{ $valor->bairro->zona->nome }}</td>
                                                <td>{{ $valor->vigencia->descricao }}</td>
                                                <td>R$ {{ number_format($valor->valor, 2, ',', '.') }}</td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('valores_pgm.edit', $valor) }}"
                                                            class="btn btn-outline-warning btn-sm" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('valores_pgm.destroy', $valor) }}"
                                                            method="POST" style="display:inline;"
                                                            onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                                title="Excluir">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    <i class="fas fa-inbox fa-2x mb-3"></i><br>
                                                    Nenhum valor PGM cadastrado
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
