<x-www-app>
    <x-www-layout>
        <x-www-main>
            <nav class="pt-3 my-3 my-md-4" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="home-electronics.html">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Post</li>
                </ol>
            </nav>

            <div class="mb-4">
                @livewire('site-post', [
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

        {{-- post 설정 --}}
        {{-- @livewire('site-post-setting', [
            'code' => 'post',
        ]) --}}

    </x-www-layout>
</x-www-app>

