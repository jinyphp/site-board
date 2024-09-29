<x-www-app>
    <x-www-layout>
        <main class="content-wrapper">

            {{-- Title --}}
            {{-- @if(isset($actions['view']['title']))
            @includeIf($actions['view']['title'])
            @else
            @includeIf("jiny-wire-table::table_popup_forms.title")
            @endif --}}

            {{-- 테이블 --}}
            <section class="container">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2>{{$board->title}}</h2>
                    </div>
                    <div>
                        <a href="/board/{{$code}}/create"
                            class="btn btn-primary">
                            작성
                        </a>
                    </div>
                </div>
            </section>

            <section class="container pb-5 mb-1 mb-sm-3 mb-lg-4 mb-xl-5">
                {{-- 라이브와이어를 통하여 테이블을 출력합니다. --}}
                @livewire('WireTable', [
                    'actions'=>$actions
                ])
            </section>

        </main>
    </x-www-layout>
</x-www-app>


