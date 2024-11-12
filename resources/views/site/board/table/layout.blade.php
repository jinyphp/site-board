<x-www-app>
    <x-www-layout>
        <x-www-main>
            {{-- 계시판 타이틀 --}}
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2>{{ $board->title }}</h2>
                    <p class="text-muted">{{ $board->subtitle }}</p>
                </div>
                <div>
                    <!-- Breadcrumb -->
                    <nav class="pt-3 mb-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('board.list', ['code' => $code]) }}">Board</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{$code}}
                            </li>
                        </ol>
                    </nav>

                    <div class="d-flex justify-content-end">
                        @if ($board->permit_create)
                            <a href="{{ route('board.create', ['code' => $code]) }}"
                                class="btn btn-primary">
                                작성
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 계시판 목록 --}}
            @includeIf('jiny-site-board::site.board.table.table')

            <div class="d-flex justify-content-between align-items-center mt-4">
                {{-- 페이지 네비게이션 --}}
                @includeIf('jiny-site-board::site.board.table.pagenation')

                {{-- 검색 기능 --}}
                @includeIf('jiny-site-board::site.board.table.search')
            </div>

        </x-www-main>
    </x-www-layout>

    {{-- 계시판 설정 --}}
    @livewire('site-board-setting', [
        'code' => $code,
    ])

</x-www-app>
