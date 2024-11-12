<div>
    {{$slot}}

    @livewire('site-board-snippet', [
        'code' => $code,
    ])
</div>
