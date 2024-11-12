<x-www-app>
    <x-www-layout>
        <x-www-main>

            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2>{{ $board->title }}</h2>
                    <p class="text-muted">{{ $board->description }}</p>
                </div>
                <div>
                    <!-- Breadcrumb -->
                    <nav class="pt-3 mb-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/board/{{$code}}">Board</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{$code}}
                            </li>
                        </ol>
                    </nav>

                    <div class="d-flex justify-content-end">
                        @if ($board->permit_create)
                            <a href="/board/{{ $code }}/create" class="btn btn-primary">
                                작성
                            </a>
                        @endif
                    </div>

                </div>

            </div>




            {{-- <section class="container pb-5 mb-1 mb-sm-3 mb-lg-4 mb-xl-5">
                @livewire('WireTable', [
                    'actions'=>$actions
                ])
            </section> --}}
            {{-- 테이블을 그리드로 변경 --}}
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @forelse($rows as $item)
                <div class="col">
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
                            <p class="card-text text-end">
                                <small class="text-muted">조회수: {{$item->click}}</small>
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-center py-4">게시글이 없습니다.</p>
                </div>
                @endforelse
            </div>

            {{-- 페이지 네비게이션 --}}
            <div class="d-flex justify-content-center mt-4">
                @if ($rows->hasPages())
                    <nav aria-label="페이지 네비게이션">
                        <ul class="pagination">
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
            </div>
        </x-www-main>
    </x-www-layout>

    @livewire('site-board-setting', [
        'code' => $code,
    ])

</x-www-app>
