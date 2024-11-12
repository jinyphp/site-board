<div>



    {{-- 목록 --}}
    @includeIf($viewListFile)

    @if(empty($rows))
    <div class="text-center">
        검색된 데이터 목록이 없습니다.
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mt-4">
        {{-- 페이지 네비게이션 --}}
        @includeIf('jiny-site-board::site.post.pagenation')

        {{-- 검색 기능 --}}
        {{-- @includeIf('jiny-site-board::site.board.table.search') --}}
    </div>

    {{-- <div class="d-flex mt-4">
        <div>
            <button class="btn btn-primary btn-sm" wire:click="create()">
                작성
            </button>
        </div>
    </div> --}}

</div>
