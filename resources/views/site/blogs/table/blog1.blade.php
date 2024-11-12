<div class="row">

    <!-- Article -->
    <article class="col-md-6 col-lg-7">
        @if (isset($rows[0]))
            <a class="d-flex hover-effect-scale rounded-4 overflow-hidden" href="{{ route('blog.view', $rows[0]->id) }}"
                style="aspect-ratio: 1.54">

                <img src="{{$rows[0]->image}}" class="hover-effect-target" alt="Image">
            </a>
            <div class="pt-4">
                <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">
                    <a class="nav-link text-body fs-xs text-uppercase p-0" href="#!">Gadget reviews</a>
                    <hr class="vr my-1 mx-1">
                    <span class="text-body-tertiary fs-xs">October 13, 2024</span>
                </div>
                <h3 class="h5 mb-0">
                    <a class="hover-effect-underline" href="{{ route('blog.view', $rows[0]->id) }}">
                        {{ $rows[0]->title }}
                    </a>
                </h3>
            </div>
        @endif
    </article>

    <!-- Side list -->
    <div class="col-md-6 col-lg-5 d-flex flex-column align-content-between gap-4">
        {{-- 첫번째 항목은 이미 사용을 한 경우라서, 첫데이터를 skip 합니다. --}}
        @foreach ($rows->skip(1) as $item)
            <!-- Article -->
            <article class="hover-effect-scale position-relative d-flex align-items-center ps-xl-4 mb-xl-1">
                <div class="w-100 pe-3 pe-sm-4 pe-lg-3 pe-xl-4">
                    <div class="text-body-tertiary fs-xs pb-2 mb-1">
                        {{ date('F d, Y', strtotime($item->created_at)) }}
                    </div>
                    <h3 class="h6 mb-2">
                        <a class="hover-effect-underline stretched-link" href="{{ route('blog.view', $item->id) }}">
                            {{ $item->title }}
                        </a>
                    </h3>
                </div>
                <div class="ratio w-100 rounded overflow-hidden"
                    style="max-width: 196px; --cz-aspect-ratio: calc(140 / 196 * 100%)">
                    <img src="{{ $item->image }}"
                      class="hover-effect-target" alt="Image">
                </div>
            </article>
        @endforeach

    </div>

</div>

<x-ui-divider>Blogs</x-ui-divider>
