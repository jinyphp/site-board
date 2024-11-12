<x-www-app>
    <x-www-layout>
        <x-www-main>


            @if($path == 'create')
            <h1>블로그 작성</h1>
                @livewire('site-blog-create')
            @else
            <h1>블로그</h1>
                @livewire('site-blog', ['path' => $path])
            @endif
        </x-www-main>
    </x-www-layout>
</x-www-app>

