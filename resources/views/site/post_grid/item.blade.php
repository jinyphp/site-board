{{-- bootstrap Cartzilla --}}
@foreach($rows as $item)
    <!-- Article -->
    <article class="col">
        <a class="ratio d-flex hover-effect-scale rounded overflow-hidden"
            href="/post/{{$item->id}}"
            style="--cz-aspect-ratio: calc(305 / 416 * 100%)">
            <img src="{{$item->image}}" class="hover-effect-target" alt="Image">
        </a>
        <div class="pt-4">
            <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">
                <a class="nav-link text-body fs-xs text-uppercase p-0" href="#!">Tech tips</a>
                <hr class="vr my-1 mx-1">
                <span class="text-body-tertiary fs-xs">September 11, 2024</span>
            </div>
            <h3 class="h5 mb-0">
                <a class="hover-effect-underline" href="/post/{{$item->id}}">
                {{$item->title}}
                </a>
            </h3>
        </div>
    </article>
@endforeach
