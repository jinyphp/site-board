<x-www-app>
    <x-www-layout>
        <x-www-main>
            <div class="mb-4">
                @livewire('site-forum', [
                    'actions' => $actions,
                    'code' => $code
                ])
            </div>

            <div class="mb-4">
                <!-- Subscription CTA -->
                {{-- @livewire('site-subscription',[
                    'widget_id' => 2
                ]) --}}
            </div>

            <div  class="mb-4">
                <!-- Related articles -->
                {{-- @livewire('site-board-related') --}}
            </div>
        </x-www-main>
    </x-www-layout>

    {{-- 계시판 설정 --}}
    @livewire('site-board-setting', [
        'code' => $code,
    ])

</x-www-app>

