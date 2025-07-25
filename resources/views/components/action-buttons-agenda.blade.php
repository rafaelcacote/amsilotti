@props([
    'showRoute',
    'editRoute', 
    'destroyRoute',
    'printRoute' => null,
    'itemId',
    'title' => 'Confirmar exclusão',
    'message' => 'Tem certeza que deseja excluir este item?',
    'showButton' => true,
    'editButton' => true,
    'deleteButton' => true,
    'printButton' => true,
])

<div class="d-flex justify-content-center gap-2">
    @can('view agenda')
        @if ($showButton)
            <a href="{{ route($showRoute, $itemId) }}" class="btn btn-light" title="Visualizar">
                <i class="fa-solid fa-magnifying-glass text-info"></i>
            </a>
        @endif
    @endcan

    @can('edit agenda')
        @if ($editButton)
            <a href="{{ route($editRoute, $itemId) }}" class="btn btn-light" title="Editar">
                <i class="fa-solid fa-pen-to-square text-warning"></i>
            </a>
        @endif
    @endcan

    @can('print agenda')
        @if ($printButton && $printRoute)
            <a href="{{ route($printRoute, $itemId) }}" class="btn btn-light" title="Imprimir" target="_blank">
                <i class="fa-solid fa-print text-success"></i>
            </a>
        @endif
    @endcan

    @can('delete agenda')
        @if ($deleteButton)
            <button type="button" class="btn btn-light" data-coreui-toggle="modal"
                data-coreui-target="#deleteModal-{{ $itemId }}" title="Excluir">
                <i class="fa-solid fa-trash-can text-danger"></i>
            </button>
        @endif
    @endcan
</div>

@can('delete agenda')
    @if ($deleteButton)
        <!-- Modal de Confirmação de Exclusão -->
        <div class="modal fade" id="deleteModal-{{ $itemId }}" tabindex="-1"
            aria-labelledby="deleteModalLabel-{{ $itemId }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel-{{ $itemId }}">{{ $title }}</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ $message }}</p>
                        <p class="text-warning"><i class="fas fa-exclamation-triangle"></i> Esta ação não pode ser desfeita!</p>
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
