<x-www-layout>
    <!-- Page content -->
    <main class="content-wrapper">

        <!-- Breadcrumb -->
        <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Post
                </li>
            </ol>
        </nav>

        <section class="container pb-5 mb-1 mb-sm-3 mb-lg-4 mb-xl-5">

            {{--
            <!-- ajax 통신방식 -->
            <x-ajax-form-create action="/post/create">
                @includeIf($actions['view']['form'])
            </x-ajax-form-create>
            --}}

            {{-- 라이브와이어를 통한 create, 동작후 event 발생으로 이전화면 될아가기--}}
            @livewire('SitePost-create',[
                'actions' => $actions
            ])

            <script>
                document.addEventListener('livewire:init', () => {
                    Livewire.on('post-created', (event) => {
                        console.log("post-created");
                        window.history.go(-1);
                    });
                });
            </script>
        </section>

    </main>

</x-www-layout>

