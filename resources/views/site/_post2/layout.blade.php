<x-www-app>
    <x-www-layout>
        <x-www-main>
            <!-- Breadcrumb -->
            <nav class="pt-3 my-3 my-md-4" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home-electronics.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blog</li>
                </ol>
            </nav>

            @livewire('site-post', [

            ])
            {{-- @livewire('SitePost-list', [
                                'actions' => $actions,
            ]) --}}
        </x-www-main>



        <main class="content-wrapper">
            {{-- post에서 5개를 읽어 전달합니다. --}}
            {{-- @partials('blog1', ['rows' => getPosts(4)]) --}}

            {{-- <hr class="my-0 my-md-2 my-lg-4"> --}}

            {{-- @partials('blog_with_sidebar') --}}
            <!-- Posts grid + Sidebar -->
            <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
                <div class="row">
                    <!-- Posts grid -->
                    <div class="col-lg-8">

                        {{-- @partials('blog_post_slider', ['rows' => getPosts(4)]) --}}

                        {{-- <hr> --}}

                        <div class="row gy-5"> {{-- row-cols-1 row-cols-sm-2  --}}

                        </div>

                    </div>

                    <!-- Sticky sidebar that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
                    <aside class="col-lg-4 col-xl-3 offset-xl-1" style="margin-top: -115px">
                        {{-- @partials('blog_sidebar') --}}
                    </aside>
                </div>
            </section>

        </main>


        {{-- @partials('video_reviews') --}}


    </x-www-layout>
</x-www-app>
