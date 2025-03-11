<div class="pagination">
    @if ($paginator->onFirstPage())
        <span class="disabled">&laquo;</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="disabled">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
    @else
        <span class="disabled">&raquo;</span>
    @endif
</div>
<style>
    .pagination {
        display: flex;
        gap: 0.5rem;
    }
    .pagination span,
    .pagination a {
        padding: 0.25rem 0.5rem;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
    }
    .pagination a {
        text-decoration: none;
        color: #0d6efd;
    }
    .pagination .active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    .pagination .disabled {
        color: #6c757d;
    }
</style>