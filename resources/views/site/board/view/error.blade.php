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



                </div>

            </div>

            <div class="d-flex flex-column justify-content-center align-items-center" style="height: 200px;">
                <h3 class="text-danger text-center" style="font-size: 1.5rem;">
                    존재하지 않는 게시물입니다.
                </h3>
                <a href="/board/{{$code}}" class="btn btn-primary mt-3">목록으로 돌아가기</a>
            </div>
        </x-www-main>
    </x-www-layout>
</x-www-app>



