<div>
    <x-loading-indicator/>

    <div class="alert alert-danger">
        정말로 삭제하시겠습니까?
    </div>

    <x-flex-between>
        <div>
            <button type="button" class="btn btn-success btn-sm" wire:click="deleteCancel">취소</button>
        </div>
        <div>
            <span class="text-red-600">정말로 삭제를 진행할까요?</span>
            <button type="button" class="btn btn-danger btn-sm" wire:click="deleteConfirm">삭제</button>
        </div>
    </x-flex-between>
</div>
