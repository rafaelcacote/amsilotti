@props([
    'showRoute',
    'editRoute',
    'destroyRoute',
    'duplicateRoute' => null,
    'itemId',
    'title' => 'Confirmar exclusão',
    'message' => 'Tem certeza que deseja excluir este item?',
    'duplicateTitle' => 'Confirmar duplicação',
    'duplicateMessage' => 'Deseja duplicar esta tarefa?',
    'showButton' => true,
    'editButton' => true,
    'deleteButton' => true,
    'duplicateButton' => true,
])

<div class="d-flex justify-content-center gap-2">
    @can('view tarefas')
        @if ($showButton)
            <a href="{{ route($showRoute, $itemId) }}" class="btn btn-light" title="Visualizar">
                <i class="fa-solid fa-magnifying-glass text-info"></i>
            </a>
        @endif
    @endcan

    @can('edit tarefas')
        @if ($editButton)
            <a href="{{ route($editRoute, $itemId) }}" class="btn btn-light" title="Editar">
                <i class="fa-solid fa-pen-to-square text-warning"></i>
            </a>
        @endif
    @endcan

    @can('duplicate tarefas')
        @if ($duplicateButton && $duplicateRoute)
            <button type="button" class="btn btn-light" data-coreui-toggle="modal"
                data-coreui-target="#duplicateModal-{{ $itemId }}" title="Duplicar">
                <i class="fa-solid fa-copy text-primary"></i>
            </button>
        @endif
    @endcan

    @can('delete tarefas')
        @if ($deleteButton)
            <button type="button" class="btn btn-light" data-coreui-toggle="modal"
                data-coreui-target="#deleteModal-{{ $itemId }}" title="Excluir">
                <i class="fa-solid fa-trash-can text-danger"></i>
            </button>
        @endif
    @endcan
</div>

@can('duplicate tarefas')
    @if ($duplicateButton && $duplicateRoute)
        <!-- Modal de Confirmação de Duplicação -->
        <div class="modal fade" id="duplicateModal-{{ $itemId }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $duplicateTitle }}</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ $duplicateMessage }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cancelar</button>
                        <form method="POST" action="{{ route($duplicateRoute, $itemId) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">Duplicar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endcan

@can('delete tarefas')
    @if ($deleteButton)
        <!-- Modal de Confirmação de Exclusão -->
        <div class="modal fade" id="deleteModal-{{ $itemId }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $title }}</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ $message }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cancelar</button>
                        <form method="POST" action="{{ route($destroyRoute, $itemId) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endcan
