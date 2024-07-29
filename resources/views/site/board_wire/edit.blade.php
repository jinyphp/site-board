<div>
    <x-loading-indicator/>

    @includeIf($viewFormFile)

    <div class="d-flex justify-content-between">
        <div>
            <button class="btn btn-danger" wire:click="delete('{{$forms['id']}}')">삭제</button>
        </div>
        <div>
            <button class="btn btn-success" wire:click="editCancel('{{$forms['id']}}')">취소</button>
            <button class="btn btn-info" wire:click="update">수정</button>
        </div>
    </div>


</div>
