<x-www-app>
    <x-www-layout>
        <x-www-main>

            {{-- <h1>계시판</h1> --}}

            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach(siteBoards() as $board)
                    <div class="col">
                        <div class="card h-100">
                            @if($board->image)
                                <img src="{{ $board->image }}" class="card-img-top" alt="{{ $board->title }}">
                            @else
                                <div style="height:100px; background-color:#e9ecef;"
                                    class="card-img-top">

                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ $board->slug ? '/board/'.$board->slug : '/board/'.$board->code }}">
                                        {{ $board->title }}
                                    </a>
                                    {{-- @if($board->created_at >= now()->subDays(7))
                                        <span class="badge bg-danger">New</span>
                                    @endif --}}
                                </h5>
                                <p class="card-text text-muted small">
                                    {{ $board->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </x-www-main>
    </x-www-layout>
</x-www-app>
