<x-wire-dialog-modal wire:model="popupForm" :maxWidth="$popupWindowWidth">
    <x-slot name="title">
        {{ __('글 작성') }}
    </x-slot>

    <x-slot name="content">

        @includeIf($viewFormFile)

    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-between">
            <div>

            </div>
            <div>
                <button class="btn btn-secondary" wire:click="createCancel()">취소</button>
                <button class="btn btn-primary" wire:click="store">저장</button>
            </div>
        </div>
    </x-slot>
</x-wire-dialog-modal>

