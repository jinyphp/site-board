<div>
    <form action="{{ route('blog.search') }}" method="GET" class="d-flex position-relative">
        <input type="text" name="query" class="form-control me-2"
            value="{{ request('query') }}"
            placeholder="검색어를 입력하세요">
        @if(request('query'))
            <a href="{{ route('blog.index') }}" class="position-absolute"
               style="right: 80px; top: 50%; transform: translateY(-50%); text-decoration: none;">
                <i class="bi bi-x-circle"></i>
            </a>
        @endif
        <button type="submit" class="btn btn-outline-secondary">검색</button>
    </form>
</div>
