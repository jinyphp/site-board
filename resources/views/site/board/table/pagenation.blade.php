{{-- 전체 게시물 정보 --}}
<div class="text-muted">
    전체 게시물: {{ $rows->total() }} |
    현재 페이지: {{ $rows->currentPage() }} / {{ $rows->lastPage() }}
</div>

{{-- 페이지 네비게이션 --}}
@if ($rows->hasPages())
    <nav aria-label="페이지 네비게이션">
        <ul class="pagination mb-0">
            {{-- 이전 페이지 링크 --}}
            @if ($rows->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">이전</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $rows->previousPageUrl() }}" rel="prev">이전</a>
                </li>
            @endif

            {{-- 페이지 번호 --}}
            @foreach ($rows->getUrlRange(1, $rows->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $rows->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            {{-- 다음 페이지 링크 --}}
            @if ($rows->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $rows->nextPageUrl() }}" rel="next">다음</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">다음</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
