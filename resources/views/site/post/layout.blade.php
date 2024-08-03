<x-www-layout>
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="home-electronics.html">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Blog</li>
        </ol>
    </nav>

    <main class="content-wrapper">
        {{-- post에서 5개를 읽어 전달합니다. --}}
        @partials('blog1',['rows'=>getPosts(4)])

        <hr class="my-0 my-md-2 my-lg-4">

        @partials('blog_with_sidebar')
    </main>





    {{-- @partials('video_reviews') --}}

    <section class="container pb-5 mb-1 mb-sm-3 mb-lg-4 mb-xl-5">
        @livewire('setActionRule', [
            'actions'=>$actions
        ])
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('refeshTable', (event) => {
                    console.log("refeshTable");
                    window.location.reload();
                });
            });
        </script>
    </section>


</x-www-layout>

