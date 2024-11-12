<x-www-app>
    <x-www-layout>
        <x-www-main>

            @includeIf('jiny-site-board::site.blogs.table.title')

            {{-- 최근 게시물 출력 --}}
            @includeIf('jiny-site-board::site.blogs.table.blog1', [
                'rows' => $rows->take(4),
            ])

            <div class="row gx-5">
                <div class="col-12 col-md-9">
                    <!-- 메인 컨텐츠 영역 -->
                    @includeIf('jiny-site-board::site.blogs.table.table', [
                        'rows' => $rows->skip(4),
                    ])

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        {{-- 페이지 네비게이션 --}}
                        @includeIf('jiny-site-board::site.blogs.table.pagenation')

                        {{-- 검색 기능 --}}
                        @includeIf('jiny-site-board::site.blogs.table.search')
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <!-- 사이드바 영역 -->
                    @livewire('site-blog-cate')


                    @livewire('site-blog-trend')

                    <h4 class="h6 pt-4">Follow us</h4>

                    <div class="d-flex gap-2 pb-2">
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!"
                            data-bs-toggle="tooltip"
                            data-bs-template="<div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-transparent text-body p-0&quot;></div></div>"
                            aria-label="Follow us on Instagram" data-bs-original-title="Instagram">
                            <i class="ci-instagram"></i>
                        </a>
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!"
                            data-bs-toggle="tooltip"
                            data-bs-template="<div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-transparent text-body p-0&quot;></div></div>"
                            aria-label="Follow us on X" data-bs-original-title="X (Twitter)">
                            <i class="ci-x"></i>
                        </a>
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!"
                            data-bs-toggle="tooltip"
                            data-bs-template="<div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-transparent text-body p-0&quot;></div></div>"
                            aria-label="Follow us on Facebook" data-bs-original-title="Facebook">
                            <i class="ci-facebook"></i>
                        </a>
                        <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!"
                            data-bs-toggle="tooltip"
                            data-bs-template="<div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-transparent text-body p-0&quot;></div></div>"
                            aria-label="Follow us on Telegram" data-bs-original-title="Telegram">
                            <i class="ci-telegram"></i>
                        </a>
                    </div>
                </div>
            </div>


        </x-www-main>
    </x-www-layout>
</x-www-app>
