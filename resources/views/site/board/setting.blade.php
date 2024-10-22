<div>
    <!-- 팝업 계시판 설정 -->
    @if($design && $popupSetting)

        <x-dialog-modal wire:model="popupSetting" maxWidth="2xl">
            <x-slot name="title">
                걔시판 설정
            </x-slot>
            <x-slot name="content">
                @includeIf("jiny-site-board::admin.board.form")
            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-between">
                    <div>
                    </div>
                    <div>
                        <x-button secondary wire:click="popupClose">취소</x-button>
                        <x-button primary wire:click="update">수정</x-button>
                    </div>
                </div>
            </x-slot>
        </x-dialog-modal>

    @endif
</div>
