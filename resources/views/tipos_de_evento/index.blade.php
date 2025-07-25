@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-palette me-2"></i>Tipos de Evento</h3>
                            <div class="ms-auto">
                                <a href="{{ route('agenda.index') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Voltar para Agenda
                                </a>
                                @can('create agenda tipos-evento')
                                <a href="{{ route('tipos-de-evento.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Novo Tipo de Evento
                                </a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">ID</th>
                                            <th>Nome</th>
                                            <th>Código</th>
                                            <th width="90">Cor</th>
                                            <th width="100">Status</th>
                                            <th width="150">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tipos as $tipo)
                                            <tr>
                                                <td>{{ $tipo->id }}</td>
                                                <td>{{ $tipo->nome }}</td>
                                                <td><code>{{ $tipo->codigo }}</code></td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge d-block" 
                                                            style="background-color: {{ $tipo->cor }}; width: 25px; height: 25px;"></span>
                                                        <small>{{ $tipo->cor }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $tipo->ativo ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $tipo->ativo ? 'Ativo' : 'Inativo' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @can('edit agenda tipos-evento')
                                                    <a href="{{ route('tipos-de-evento.edit', $tipo) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @endcan
                                                    @can('delete agenda tipos-evento')
                                                    <form id="form-excluir-{{ $tipo->id }}"
                                                        action="{{ route('tipos-de-evento.destroy', $tipo) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm btn-excluir-tipo"
                                                            data-id="{{ $tipo->id }}"
                                                            data-nome="{{ $tipo->nome }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Nenhum tipo de evento encontrado.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $tipos->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar Exclusão -->
    <div class="modal fade" id="modalConfirmarExclusao" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir o tipo de evento <strong id="tipo-exclusao"></strong>?</p>
                    <p class="mb-0 text-danger"><small>Esta ação não poderá ser desfeita.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarExclusao">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Exclusão customizada
            $(document).on('click', '.btn-excluir-tipo', function(e) {
                e.preventDefault();
                var tipoId = $(this).data('id');
                var nome = $(this).data('nome');
                $('#tipo-exclusao').text(nome);
                $('#btnConfirmarExclusao').data('id', tipoId);
                var modal = new bootstrap.Modal(document.getElementById('modalConfirmarExclusao'));
                modal.show();
            });

            $('#btnConfirmarExclusao').on('click', function() {
                var id = $(this).data('id');
                if (id) {
                    var form = $('#form-excluir-' + id);
                    if (form.length) {
                        form.submit();
                    }
                }
            });
        });
    </script>
@endsection
