@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-calendar me-2"></i>Vigências PGM</h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('vigencia_pgm.create') }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2">
                                    <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                    <span>Nova Vigência</span>
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
                                            <th>Descrição</th>
                                            <th>Data Início</th>
                                            <th>Data Fim</th>
                                            <th>Status</th>
                                            <th width="120">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($vigencias as $vigencia)
                                            <tr>
                                                <td>{{ $vigencia->id }}</td>
                                                <td>{{ $vigencia->descricao }}</td>
                                                <td>{{ \Carbon\Carbon::parse($vigencia->data_inicio)->format('d/m/Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($vigencia->data_fim)->format('d/m/Y') }}</td>
                                                <td>
                                                    @if ($vigencia->ativo)
                                                        <span class="badge bg-success">Ativo</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inativo</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('vigencia_pgm.edit', $vigencia) }}"
                                                            class="btn btn-outline-warning btn-sm" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('valores_pgm.index', ['vigencia_id' => $vigencia->id]) }}"
                                                            class="btn btn-outline-info btn-sm" title="Ver Valores">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <form action="{{ route('vigencia_pgm.destroy', $vigencia) }}"
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
                                                    Nenhuma vigência cadastrada
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
