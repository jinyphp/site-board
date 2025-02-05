{{-- 모바일용 카드 뷰 --}}
<div class="d-block d-md-none">
    <div class="row row-cols-1 g-4">
        @if(!empty($rows))
            @foreach ($rows as $item)
            <div class="col">
                <div class="card hover-effect">
                    <div class="row g-0">
                        {{-- 체크박스 --}}
                        @if(isset($widget['delete']['check']) && $widget['delete']['check'])
                        <div class="position-absolute top-0 end-0 m-2 z-1">
                            <input type='checkbox' name='ids' value="{{$item->id}}"
                            class="form-check-input" wire:model.live="selected">
                        </div>
                        @endif

                        {{-- 썸네일 --}}
                        <div class="col-4">
                            <div class="card-img-wrapper h-100" wire:click="view({{$item->id}})">
                                @if($item->image)
                                    <img src="{{$item->image}}" class="img-fluid h-100" alt="{{$item->title}}">
                                @else
                                    <div class="bg-gray-200 h-100 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- 컨텐츠 --}}
                        <div class="col-8">
                            <div class="card-body">
                                <div class="small mb-1">
                                    <span>{{$item->status}}</span>
                                    <span class="text-muted ms-2">{{date('Y-m-d', strtotime($item->created_at))}}</span>
                                </div>
                                <h6 class="card-title">
                                    <x-click wire:click="view({{$item->id}})">
                                        {{$item->title}}
                                    </x-click>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

{{-- 데스크톱용 테이블 뷰 --}}
<div class="d-none d-md-block">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    @if(isset($widget['delete']['check']) && $widget['delete']['check'])
                    <th width="50px"></th>
                    @endif
                    <th width="100px">이미지</th>
                    <th>제목</th>

                    <th width="120px">작성일</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($rows))
                    @foreach ($rows as $item)
                    <tr>
                        @if(isset($widget['delete']['check']) && $widget['delete']['check'])
                        <td>
                            <input type='checkbox' name='ids' value="{{$item->id}}"
                            class="form-check-input" wire:model.live="selected">
                        </td>
                        @endif
                        <td>
                            <div class="card-img-wrapper" wire:click="view({{$item->id}})">
                                @if($item->image)
                                    <img src="{{$item->image}}" class="img-thumbnail" alt="{{$item->title}}" style="width:80px; height:60px; object-fit:cover;">
                                @else
                                    <div class="bg-gray-200 d-flex align-items-center justify-content-center" style="width:80px; height:60px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-2 align-items-center">
                                <x-click wire:click="view({{$item->id}})">
                                    {{$item->title}}
                                </x-click>

                                <span class="badge bg-secondary">{{$item->status}}</span>
                            </div>
                        </td>

                        <td>{{date('Y-m-d', strtotime($item->created_at))}}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

{{-- 새 글쓰기 버튼 --}}
<div class="text-end mt-3">
    <button class="btn btn-primary" wire:click="create()">
        <i class="bi bi-plus-circle me-1"></i>새 글쓰기
    </button>
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
</style>
