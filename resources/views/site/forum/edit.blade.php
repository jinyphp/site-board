<x-wire-dialog-modal wire:model="popupForm" :maxWidth="$popupWindowWidth">
    <x-slot name="title">
        {{ __('글 수정') }}
    </x-slot>

    <x-slot name="content">

        @includeIf($viewFormFile)

    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-between">
            <div>
                @if(!$popupDelete)
                <button class="btn btn-danger" wire:click="delete('{{$forms['id']}}')">삭제</button>
                @else
                <button type="button" class="btn btn-danger btn-sm" wire:click="deleteConfirm">예, 삭제 합니다.</button>
                @endif

            </div>
            <div>
                <button class="btn btn-secondary" wire:click="editCancel('{{$forms['id']}}')">
                    취소
                </button>

                {{-- @if(isset($widget['edit']['enable']) && $widget['edit']['enable'])
                <button class="btn btn-info" wire:click="update">수정</button>
                @endif --}}

                <button class="btn btn-info" wire:click="update">수정</button>
            </div>
        </div>
    </x-slot>
</x-wire-dialog-modal>
