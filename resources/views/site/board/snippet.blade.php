<div>
    <h5>{{ $board['title'] }}</h5>

    @foreach($rows as $row)
    <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid rgb(229, 231, 235);">
        <div>
            <a class="text-decoration-none text-dark"
            href="/board/{{$code}}/{{$row['id']}}">
            {{ $row['title'] }}
        </a>
        </div>
        <div class="text-muted small">
            {{$row['click']}}
        </div>
    </div>
    @endforeach
    <div class="py-2 d-flex justify-content-end">
        <a href="/board/{{$code}}" class="text-decoration-none text-dark small">
            <span>전체보기</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708"/>
                <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708"/>
            </svg>
        </a>
    </div>
</div>
