{{-- bootstrap Cartzilla Grid Layout --}}
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @if(!empty($rows))
        @foreach ($rows as $item)
        <div class="col">
            <div class="card h-100 hover-effect">
                {{-- 체크박스 --}}
                @if(isset($widget['delete']['check']) && $widget['delete']['check'])
                <div class="position-absolute top-0 end-0 m-2 z-1">
                    <input type='checkbox' name='ids' value="{{$item->id}}"
                    class="form-check-input" wire:model.live="selected">
                </div>
                @endif

                {{-- 이미지 영역 --}}
                <div class="card-img-wrapper" wire:click="view({{$item->id}})">
                    @if($item->image)
                        <img src="{{$item->image}}" class="card-img-top" alt="{{$item->title}}">
                    @else
                        <div class="bg-gray-200 card-img-top d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    {{-- 카테고리 태그 --}}
                    <div class="mb-2">
                        <span>{{$item->categories }} |</span>
                        <small class="text-muted ms-2">{{date('F d, Y', strtotime($item->created_at))}}</small>
                    </div>

                    {{-- 제목 --}}
                    <h5 class="card-title">
                        <x-click wire:click="view({{$item->id}})">
                            {{$item->title}}
                        </x-click>
                    </h5>
                </div>
            </div>
        </div>
        @endforeach
    @endif

    {{-- 새 글쓰기 카드 --}}
    <div class="col">
        <div class="card h-100 hover-effect">
            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                <i class="bi bi-plus-circle mb-2" style="font-size: 2rem;"></i>
                새로운 post를 작성합니다.
                <button class="btn btn-primary btn-sm mt-2" wire:click="create()">
                    작성
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.card-img-wrapper {
    cursor: pointer;
    overflow: hidden;
}

.card-img-wrapper img,
.card-img-wrapper .bg-gray-200 {
    transition: transform 0.3s ease;
}

.card-img-wrapper:hover img,
.card-img-wrapper:hover .bg-gray-200 {
    transform: scale(1.05);
}

.card-img-top {
    height: 200px;
    object-fit: cover;
}
</style>
