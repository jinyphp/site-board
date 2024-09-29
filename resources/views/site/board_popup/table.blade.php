<div>
    {{-- 목록 --}}
    @includeIf($viewListFile)

    @if(empty($rows))
    <div class="text-center">
        검색된 데이터 목록이 없습니다.
    </div>
    @endif

    {{-- 페이지네이션 --}}
    <div class="d-flex justify-content-between mb-4">
        <div class="py-2">
            <div>전체 {{count($ids)}} 개가 검색되었습니다.</div>
            {{-- 선택삭제 기능 --}}

            @if(isset($widget['delete']['check']) && $widget['delete']['check'])
                @includeIf("jiny-wire-table::wiretable.check_delete_inline")
            @endif

        </div>
        <div>
            {{-- 계시물 제어기능 ---}}
            @if (isset($rows) && is_object($rows))
                @if(method_exists($rows, "links"))
                    <div>{{ $rows->links() }}</div>
                @endif
            @endif

            {{-- 신규추가 버튼 --}}
            @if(isset($widget['create']['enable']) && $widget['create']['enable'])
                <button class="btn btn-primary btn-sm" wire:click="create()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                    </svg>

                    @if(isset($widget['create']['title']))
                    {{$widget['create']['title']}}
                    @else
                    작성
                    @endif
                </button>
            @endif
        </div>
    </div>

</div>
