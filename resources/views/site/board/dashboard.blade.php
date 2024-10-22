<x-www-app>
    <x-www-layout>
        <x-www-main>
            <h1>계시판</h1>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach(siteBoards() as $board)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ $board->slug ? '/board/'.$board->slug : '/board/'.$board->code }}">
                                        {{ $board->title }}
                                    </a>
                                    {{-- <span class="badge bg-primary">{{ $board->posts }}</span> --}}
                                </h5>
                                <p class="card-text text-muted small">{{ $board->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </x-www-main>
    </x-www-layout>
</x-www-app>
