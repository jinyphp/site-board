<section>

    @includeIf("jiny-site-board::site.related.grid",[
        'rows' => $rows
    ])

    @if($design)
        <!-- Text input -->
        <div class="mb-3 d-flex flex-column flex-sm-row align-items-sm-center">
            <label for="text-input" class="form-label me-sm-3 mb-2 mb-sm-0 flex-shrink-0">연관 계시물</label>
            <input type="text" class="form-control mb-2 mb-sm-0 me-sm-2" id="text-input" wire:model="related_id">
            <button class="btn btn-primary" wire:click="add">추가</button>
        </div>
    @endif

    {{--
    @foreach($rows as $item)
    <div>{{$item->title}}</div>
    @endforeach
    --}}

    <div class="pt-5 mt-2 mt-md-3 mt-lg-4 mt-xl-5">

        {{-- @if(count($rows)>0)
        <h2 class="h3 pb-2 pb-sm-3">Related articles</h2>

        <div class="d-flex flex-column gap-4 mt-n3">
            @foreach($rows as $item)
            <!-- Article -->
            <article class="row align-items-start align-items-md-center gx-0 gy-4 pt-3">
                <div class="col-sm-5 pe-sm-4">
                <a class="ratio d-flex hover-effect-scale rounded overflow-hidden flex-md-shrink-0" href="#!" style="--cz-aspect-ratio: calc(226 / 306 * 100%)">
                    <img src="/assets/img/blog/list/06.jpg" class="hover-effect-target" alt="Image">
                </a>
                </div>
                <div class="col-sm-7">
                <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">
                    <a class="nav-link text-body fs-xs text-uppercase p-0" href="#!">IoT</a>
                    <hr class="vr my-1 mx-1">
                    <span class="text-body-tertiary fs-xs">{{$item->created_at}}</span>
                </div>
                <h3 class="h5 mb-2 mb-md-3">
                    <a class="hover-effect-underline" href="#!">
                        {{$item->title}}
                    </a>
                </h3>
                <p class="mb-0">
                    In the ever-evolving landscape of technology,
                    the Internet of Things (IoT) stands out as a transformative force reshaping...
                </p>
                </div>
            </article>
            @endforeach
        </div>
        @endif --}}


        {{--





            <!-- Article -->
            <article class="row align-items-start align-items-md-center gx-0 gy-4 pt-3">
                <div class="col-sm-5 pe-sm-4">
                <a class="ratio d-flex hover-effect-scale rounded overflow-hidden flex-md-shrink-0" href="#!" style="--cz-aspect-ratio: calc(226 / 306 * 100%)">
                    <img src="assets/img/blog/list/07.jpg" class="hover-effect-target" alt="Image">
                </a>
                </div>
                <div class="col-sm-7">
                <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">
                    <a class="nav-link text-body fs-xs text-uppercase p-0" href="#!">Buying guides</a>
                    <hr class="vr my-1 mx-1">
                    <span class="text-body-tertiary fs-xs">August 18, 2024</span>
                </div>
                <h3 class="h5 mb-2 mb-md-3">
                    <a class="hover-effect-underline" href="#!">How to find the best deals and make secure transactions online</a>
                </h3>
                <p class="mb-0">This blog post will guide you through the dual objectives of snagging great bargains and protecting your financial...</p>
                </div>
            </article>

            <!-- Article -->
            <article class="row align-items-start align-items-md-center gx-0 gy-4 pt-3">
                <div class="col-sm-5 pe-sm-4">
                <a class="ratio d-flex hover-effect-scale rounded overflow-hidden flex-md-shrink-0" href="#!" style="--cz-aspect-ratio: calc(226 / 306 * 100%)">
                    <img src="assets/img/blog/list/09.jpg" class="hover-effect-target" alt="Image">
                </a>
                </div>
                <div class="col-sm-7">
                <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">
                    <a class="nav-link text-body fs-xs text-uppercase p-0" href="#!">Gaming</a>
                    <hr class="vr my-1 mx-1">
                    <span class="text-body-tertiary fs-xs">July 27, 2024</span>
                </div>
                <h3 class="h5 mb-2 mb-md-3">
                    <a class="hover-effect-underline" href="#!">Immersive worlds: A dive into the latest VR gear and experiences</a>
                </h3>
                <p class="mb-0">Immersive worlds have always captured the imagination, but now, with the advent of advanced VR gear, they are becoming...</p>
                </div>
            </article>

            <!-- View all button -->
            <div class="nav">
                <a class="nav-link animate-underline px-0 py-2" href="#!">
                <span class="animate-target">View all</span>
                <i class="ci-chevron-right fs-base ms-1"></i>
                </a>
            </div>
        </div> --}}
    </div>
</section>

