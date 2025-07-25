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
    // Novas props para controle de permissões
    'viewPermission' => null,
    'editPermission' => null,
    'deletePermission' => null,
    'duplicatePermission' => null,
])

<div class="d-flex justify-content-center gap-2">
    @if ($showButton && ($viewPermission ? auth()->user()->can($viewPermission) : true))
        <a href="{{ route($showRoute, $itemId) }}" class="btn btn-light" title="Visualizar">
            <i class="fa-solid fa-magnifying-glass text-info"></i>
        </a>
    @endif

    @if ($editButton && ($editPermission ? auth()->user()->can($editPermission) : true))
        <a href="{{ route($editRoute, $itemId) }}" class="btn btn-light" title="Editar">
            <i class="fa-solid fa-pen-to-square text-warning"></i>
        </a>
    @endif

    @if ($duplicateButton && $duplicateRoute && ($duplicatePermission ? auth()->user()->can($duplicatePermission) : true))
        <button type="button" class="btn btn-light" data-coreui-toggle="modal"
            data-coreui-target="#duplicateModal-{{ $itemId }}" title="Duplicar">
            <i class="fa-solid fa-copy text-primary"></i>
        </button>
    @endif

    @if ($deleteButton && ($deletePermission ? auth()->user()->can($deletePermission) : true))
        <button type="button" class="btn btn-light" data-coreui-toggle="modal"
            data-coreui-target="#deleteModal-{{ $itemId }}" title="Excluir">
            <i class="fa-solid fa-trash-can text-danger"></i>
        </button>
    @endif
</div>

@if ($duplicateButton && $duplicateRoute)
    <!-- Modal de Confirmação de Duplicação -->
    <div class="modal fade" id="duplicateModal-{{ $itemId }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $duplicateTitle }}</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{ $duplicateMessage }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cancelar</button>
                    <a href="{{ route($duplicateRoute, $itemId) }}" class="btn btn-primary">Duplicar</a>
                </div>
            </div>
        </div>
    </div>
@endif

@if ($deleteButton && ($deletePermission ? auth()->user()->can($deletePermission) : true))
    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="deleteModal-{{ $itemId }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{ $message }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cancelar</button>
                    <form action="{{ route($destroyRoute, $itemId) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif