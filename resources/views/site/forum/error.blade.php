<x-www-app>
    <x-www-layout>
        <div class="container">
            @livewire('site-board-setting')
            {{-- <div class="alert alert-danger">
                계시판이 존재하지 않습니다. 코드를 설정해 주세요
            </div> --}}

        </div>
    </x-www-layout>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('page-realod', (event) => {
                console.log("page-realod");
                location.reload();
            });
        });
    </script>

</x-www-app>


