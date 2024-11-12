<div>
    <h6 class="pt-5 mb-0">Trending posts</h4>
    @if(count($rows)>0)
        @foreach($rows as $item)
        <article class="hover-effect-scale position-relative d-flex align-items-center border-bottom py-4">
            <div class="w-100 pe-3">
            <h3 class="h6 lh-base fs-sm mb-0">
                <a class="hover-effect-underline stretched-link" href="#!">
                    {{$item->title}}
                </a>
            </h3>
            </div>
            <div class="ratio w-100" style="max-width: 86px; --cz-aspect-ratio: calc(64 / 86 * 100%)">
            <img src="{{$item->image}}" class="rounded-2" alt="Image">
            </div>
        </article>
        @endforeach
    @endif
</div>
