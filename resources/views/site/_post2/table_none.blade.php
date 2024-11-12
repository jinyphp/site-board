<div>
    <x-loading-indicator/>

    {{-- <div class="d-flex justify-content-between">
        <div></div>
        <div>
            <a href="/post/create"
                class="btn btn-primary">
                포스트작성
            </a>
        </div>
    </div> --}}

    {{-- 외부에서 지정한 목록 테이블을 출력합니다. --}}
    @if($viewListFile)
        @includeIf($viewListFile)
    @endif

    @if(empty($rows))
    <div class="text-center">
        검색된 데이터 목록이 없습니다.
    </div>
    @endif

    <div class="d-flex justify-content-between">
        <div class="py-2">
            전체 {{count($ids)}} 개가 검색되었습니다.
        </div>
        <div>
            @if (isset($rows) && is_object($rows))
                @if(method_exists($rows, "links"))
                <div>{{ $rows->links() }}</div>
                @else

                @endif
            @else

            @endif
        </div>
    </div>





    {{-- 퍼미션 알람--}}
    @if ($popupPermit)
        @include("jiny-wire-table::table_popup_forms.permit")
    @endif

</div>
