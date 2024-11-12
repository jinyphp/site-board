@if(isset($forms['tags']) && $forms['tags'])
    @if($tags = explode(',',$forms['tags']) && count($tags) >0)
    @foreach($tags as $item)
        <a class="btn btn-outline-secondary px-3 mt-1 me-1"
            href="#!">{{$item}}</a>
    @endforeach
    @endif
@endif
