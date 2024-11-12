<div class="row">
    @forelse($rows as $item)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="/board/{{$code}}/{{$item->id}}" class="text-decoration-none text-dark">
                        {{$item->title}}
                    </a>
                </h5>
                <p class="card-text">
                    <small class="text-muted">
                        @if($item->name)
                            {{$item->name}} |
                        @endif
                        {{date('Y-m-d', strtotime($item->created_at))}}
                    </small>
                </p>
                <div class="d-flex justify-content-between">
                    <span>ID: {{$item->id}}</span>
                    <span>조회수: {{$item->click}}</span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-4">
        연관 게시글이 없습니다.
    </div>
    @endforelse
</div>
