@if ($paginator->hasPages())
<nav>
    <ul class="pagination justify-content-center pagination-lg">
        {{-- Previous Page Link --}}@cannot('update', Model::class)

        @endcannot
        @if ($paginator->onFirstPage())
        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
            <span class="page-link" aria-hidden="true">&laquo;</span>
        </li>
        @else
        @php
        $buff = 'onclick="_page(\'' . ($paginator->currentPage() - 1) . '\')"';
        @endphp
        <li class="page-item">
            <a class="page-link text-success" href="javascript:void(0)" {!! $buff !!} rel="prev" aria-label="@lang('pagination.previous')">&laquo;</a>
        </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="page-item active" aria-current="page"><span class="page-link bg-success border-success">{{ $page }}</span></li>
        @else
        @php
        $buff = 'onclick="_page(\'' . $page . '\')"';
        @endphp
        <li class="page-item"><a class="page-link text-success" href="javascript:void(0)" {!! $buff !!}>{{ $page }}</a></li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        @php
        $buff = 'onclick="_page(\'' . ($paginator->currentPage() + 1) . '\')"';
        @endphp
        <li class="page-item">
            <a class="page-link text-success" href="javascript:void(0)" {!! $buff !!} rel="next" aria-label="@lang('pagination.next')">&raquo;</a>
        </li>
        @else
        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
            <span class="page-link" aria-hidden="true">&raquo;</span>
        </li>
        @endif
    </ul>
</nav>
@endif