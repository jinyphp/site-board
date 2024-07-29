<div>
    <x-loading-indicator/>

    {{$actions['view']['form']}}
    @includeIf($actions['view']['form'])

    <div class="d-flex justify-content-between">
        <div>
            <button class="btn btn-danger" wire:click="delete">삭제</button>
        </div>
        <div>
            <button class="btn btn-primary" wire:click="update">수정</button>
        </div>
    </div>
</div>
