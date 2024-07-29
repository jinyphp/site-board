<div>
    <x-loading-indicator/>

    @includeIf($viewFormFile)

    <div class="d-flex justify-content-between">
        <div>

        </div>
        <div>
            <button class="btn btn-success" wire:click="createCancel()">취소</button>
            <button class="btn btn-primary" wire:click="store">저장</button>
        </div>
    </div>


</div>
