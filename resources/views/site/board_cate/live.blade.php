<div>
    <h4 class="h6 mb-4">Blog categories</h4>

    <div class="d-flex flex-wrap gap-3">
        @foreach($rows as $item)
        <a class="btn btn-outline-secondary px-3" href="#!">
            {{$item->title}}
        </a>
        @endforeach
        {{-- <a class="btn btn-outline-secondary px-3" href="#!">Gadget reviews</a>
        <a class="btn btn-outline-secondary px-3" href="#!">Tech news</a>
        <a class="btn btn-outline-secondary px-3" href="#!">Industry trends</a>
        <a class="btn btn-outline-secondary px-3" href="#!">Buying guides</a>
        <a class="btn btn-outline-secondary px-3" href="#!">Tech tips</a>
        <a class="btn btn-outline-secondary px-3" href="#!">Gaming</a>
        <a class="btn btn-outline-secondary px-3" href="#!">IoT</a> --}}
    </div>

</div>
