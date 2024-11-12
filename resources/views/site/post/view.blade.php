<x-wire-dialog-modal wire:model="popupForm" :maxWidth="$popupWindowWidth">
    <x-slot name="title">
        <h2 class="h3 mb-4">
            {{$forms['title']}}
        </h2>

        <!-- Post meta -->
        <div class="nav align-items-center gap-2 border-bottom pb-4 mt-n1 mb-4">
            <a class="nav-link text-body fs-xs text-uppercase p-0" href="#!">
                {{$forms['name']}} {{$forms['email']}}
            </a>
            <hr class="vr my-1 mx-1">
            <span class="text-body-tertiary fs-xs">{{$forms['created_at']}}</span>
        </div>
    </x-slot>

    <x-slot name="content">
        @if(isset($forms['image']) && $forms['image'])
        <div class="text-center mb-4">
            <img src="{{$forms['image']}}" alt="이미지" class="img-fluid">
        </div>
        @endif

        <p>
            {{$forms['content']}}
        </p>




        <div class="d-sm-flex align-items-center justify-content-between py-4 py-md-5 mt-n2 mt-md-n3 mb-2 mb-sm-3 mb-md-0">
            {{-- Tags --}}
            <div class="d-flex flex-wrap gap-2 mb-4 mb-sm-0 me-sm-4">
                @if($forms['tags'])
            <div class="d-flex mt-4 gap-2">
                <div>
                    @foreach(explode(',',$forms['tags']) as $tag)
                        <span class="badge bg-secondary">{{ trim($tag) }}</span>
                    @endforeach
                </div>
            </div>
        @endif
            </div>

            {{-- Sharing --}}
            <div class="d-flex align-items-center gap-2">
                @includeIf("jiny-site-board::site.post.share")
            </div>
        </div>

    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-between">
            <div>
                {{-- @if(isset($widget['edit']['enable']) && $widget['edit']['enable'])
                <button class="btn btn-info"
                    wire:click="edit('{{$forms['id']}}')">Edit</button>
                @endif --}}

                @if (Auth::check() && Auth::user()->email === $forms['email'])
                <button class="btn btn-info"
                    wire:click="edit('{{$forms['id']}}')">수정</button>
                @else
                    @if(isAdmin())
                    <button class="btn btn-info"
                    wire:click="edit('{{$forms['id']}}')">수정(Admin)</button>
                    @endif
                @endif

            </div>
            <div>
                <button class="btn btn-success" wire:click="createCancel()">닫기</button>
            </div>
        </div>
    </x-slot>
</x-wire-dialog-modal>
