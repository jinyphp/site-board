<div>
    <x-loading-indicator/>

    @includeIf($actions['view']['form'])

    <button class="btn btn-primary" wire:click="submit">저장</button>

</div>
