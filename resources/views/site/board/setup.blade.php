<div>
    @if($design)
    계시판 선택
    {!! xSelect()
        ->table('site_board','title')
        ->setWire('model.defer',"forms.board")
        ->setWidth("medium")
    !!}
    <button class="btn btn-primary" wire:click="applyBoard()">선택</button>
    @else
    <div class="alert alert-danger">
        계시판이 존재하지 않습니다. 코드를 설정해 주세요
    </div>
    @endif


</div>
