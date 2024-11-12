<div>
    <form action="{{ route('board.search', ['code' => $code]) }}" method="GET" class="d-flex">
        <input type="text" name="query" class="form-control me-2" placeholder="검색어를 입력하세요">
        <button type="submit" class="btn btn-outline-secondary">검색</button>
    </form>
</div>
