<div class="pagination ml-auto mr-auto d-inline-block">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <a href="javascript:void(0);" class="prevposts-link disabled"><i class="fa fa-caret-left"></i></a>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="prevposts-link"><i class="fa fa-caret-left"></i></a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <a href="javascript:void(0);">{{ $element }}</a>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <a href="javascript:void(0);" class="current-page">{{ $page }}</a>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="nextposts-link"><i class="fa fa-caret-right"></i></a>
    @else
        <a href="javascript:void(0);" class="nextposts-link disabled"><i class="fa fa-caret-right"></i></a>
    @endif
</div>
