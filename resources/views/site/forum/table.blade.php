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
        </div>
        <div class="d-flex gap-2">
            <div class="position-relative">
                <input type="text" name="query"
                    wire:model="search_keyword"
                    wire:keydown.enter="search"
                    class="form-control me-2"
                    placeholder="검색어를 입력하세요">
                @if($search_keyword)
                <button type="button"
                    wire:click="$set('search_keyword', '')"
                    class="btn-close position-absolute top-50 end-0 translate-middle-y me-3"
                    aria-label="Close">
                </button>
                @endif
            </div>
            <button wire:click="search"
                class="btn btn-outline-secondary">
                검색
            </button>
        </div>
    </div>

</div>
