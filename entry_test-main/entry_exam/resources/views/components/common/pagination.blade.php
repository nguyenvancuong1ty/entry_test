@props([
    'paginator',
    'perPageOptions' => null,
    'perPageName' => 'per_page',
    'onEachSide' => null,
])

@if ($paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $paginator->total() > 0)
    @php
        $perPageOptions ??= config('pagination.options', [10, 20, 30, 50, 100]);
        $onEachSide     ??= (int) config('pagination.on_each_side', 2);

        $current  = $paginator->currentPage();
        $last     = $paginator->lastPage();
        $pageName = $paginator->getPageName();
        $perPage  = $paginator->perPage();

        // Fixed sliding window (default 5 pages)
        $window = $onEachSide * 2 + 1;
        $start  = max(1, min($current - $onEachSide, $last - $window + 1));
        $end    = min($last, $start + $window - 1);

        // Ensure options list always includes the active perPage value
        $options = collect($perPageOptions)->push($perPage)->unique()->sort()->values();

        $before = [
            ['«', $paginator->onFirstPage() ? null : $paginator->url(1), 'first', '最初のページ'],
            ['‹', $paginator->previousPageUrl(), 'prev', '前のページ'],
        ];
        $after = [
            ['›', $paginator->nextPageUrl(), 'next', '次のページ'],
            ['»', $paginator->hasMorePages() ? $paginator->url($last) : null, 'last', '最後のページ'],
        ];
    @endphp

    <div class="common-pagination-container">
        <div class="pagination-info-wrapper">
            <span class="pagination-count-text">
                全 <strong>{{ $paginator->total() }}</strong> 件中
                <strong>{{ $paginator->firstItem() }}</strong> 〜 <strong>{{ $paginator->lastItem() }}</strong> 件を表示
            </span>

            <div class="pagination-per-page-wrapper">
                <label for="per_page_{{ $pageName }}" class="per-page-label">表示件数:</label>
                <select id="per_page_{{ $pageName }}"
                        class="per-page-select"
                        data-per-page-select
                        data-per-page-param="{{ $perPageName }}"
                        data-page-param="{{ $pageName }}">
                    @foreach ($options as $option)
                        <option value="{{ $option }}" @selected($perPage === (int) $option)>{{ $option }} 件</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if ($paginator->hasPages())
            <nav class="pagination-nav" role="navigation" aria-label="ページネーション">
                <ul class="pagination-list">
                    @foreach ($before as [$label, $url, $rel, $aria])
                        @include('components.partials.page-nav-item')
                    @endforeach

                    @if ($start > 1)
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
                        @if ($start > 2)
                            <li class="page-item disabled" aria-hidden="true"><span class="page-link ellipsis">…</span></li>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page === $current)
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $paginator->url($page) }}" aria-label="{{ $page }}ページ目">{{ $page }}</a></li>
                        @endif
                    @endfor

                    @if ($end < $last)
                        @if ($end < $last - 1)
                            <li class="page-item disabled" aria-hidden="true"><span class="page-link ellipsis">…</span></li>
                        @endif
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url($last) }}">{{ $last }}</a></li>
                    @endif

                    @foreach ($after as [$label, $url, $rel, $aria])
                        @include('components.partials.page-nav-item')
                    @endforeach
                </ul>
            </nav>
        @endif
    </div>

    @once
        @push('scripts')
            <script>
                document.addEventListener('change', (e) => {
                    const select = e.target.closest('[data-per-page-select]');
                    if (!select) return;

                    const url = new URL(window.location.href);
                    url.searchParams.set(select.dataset.perPageParam, select.value);
                    url.searchParams.set(select.dataset.pageParam, '1');
                    window.location.assign(url);
                });
            </script>
        @endpush
    @endonce
@endif
