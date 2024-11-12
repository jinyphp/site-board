<div class="row row-cols-1 row-cols-md-2 g-2">
    @forelse($rows as $item)
        <div class="col">
            <div class="card h-100">
                <a href="{{ route('blog.view', $item->id) }}" class="text-decoration-none">
                    @if($item->image)
                        <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary card-img-top" style="height: 200px;"></div>
                    @endif
                </a>

                <div class="card-body">
                    <a href="{{ route('blog.view', $item->id) }}" class="text-decoration-none text-dark">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <div class="card-text">
                            <small class="text-muted d-flex justify-content-between">
                                <span>
                                    @if ($item->name)
                                        {{ $item->name }}
                                    @endif
                                </span>
                                <span>{{ date('Y-m-d', strtotime($item->created_at)) }}</span>
                                <span>조회수: {{ $item->click }}</span>
                            </small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-4">
            포스트가 없습니다.
        </div>
    @endforelse

    <div class="col">
        <div class="card h-100">
            <div class="card-body d-flex justify-content-center align-items-center">
                <a href="{{ route('blog.create') }}" class="btn btn-primary">작성</a>
            </div>
        </div>
    </div>
</div>
