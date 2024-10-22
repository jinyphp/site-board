<x-www-app>
    <x-www-layout>
        <x-www-main>
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    {{-- <h2>{{ $board->title }}</h2>
                    <p class="text-muted">{{ $board->description }}</p> --}}
                    <h3>{{ $row->title }}</h3>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">작성일: {{ $row->created_at}}</span>
                    </div>

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
                        @if (Auth::check() && Auth::user()->email === $row->email)
                            <a href="/board/{{ $code }}/{{ $row->id }}/edit" class="btn btn-info ms-2">
                                수정
                            </a>
                        @endif

                        @if(isAdmin())
                        <a href="/board/{{ $code }}/{{ $row->id }}/edit" class="btn btn-primary ms-2">
                            Admin
                        </a>
                        @endif
                    </div>
                </div>
            </div>


            <hr>

            {!! nl2br($row->content) !!}



            {{-- 계시판 글 보기 --}}
            {{-- @livewire("site-board-view",[
                'actions' => $actions
            ]) --}}

            <!-- Subscription CTA -->
            {{-- @livewire('site-subscription') --}}


            <!-- Related articles -->
            {{-- @livewire('SiteBoard-related') --}}


        </x-www-main>



    </x-www-layout>
</x-www-app>



