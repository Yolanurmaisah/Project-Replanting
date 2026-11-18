@if ($paginator->hasPages())
    <nav class="pager no-print" aria-label="Navigasi halaman">
        <span class="mu">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>
        <span class="acts">
            <a class="btn sec sm {{ $paginator->onFirstPage() ? 'off' : '' }}" href="{{ $paginator->previousPageUrl() ?? '#' }}">&larr; Sebelumnya</a>
            <a class="btn sec sm {{ $paginator->hasMorePages() ? '' : 'off' }}" href="{{ $paginator->nextPageUrl() ?? '#' }}">Berikutnya &rarr;</a>
        </span>
    </nav>
@endif
