<div>
    <x-loading-indicator/>

    

    {{-- 위젯 설정버튼 --}}
    {{-- @if($design)
    <div class="d-flex justify-content-between">
        <div></div>
        <div>
            <button class="btn btn-sm btn-outline-secondary"
                wire:click="widgetSetting()">
                설정
            </span>
        </div>
    </div>
    @endif --}}

    {{-- 계시판 목록 화면 --}}
    @includeIf($viewTableFile)


    <!-- 팝업창 -->
    @if ($popupForm)
        @switch($mode)
            @case('setting')
                @includeIf("jiny-site-board::site.forum.setting")
                @break
            @case('create')
                @includeIf($viewCreateFile)
                @break
            @case('edit')
                @includeIf($viewEditFile)
                @break
            @default
                @includeIf($viewViewFile)
        @endswitch

    @endif


    {{-- 퍼미션 알람--}}
    @if ($popupPermit)
        @include("jiny-wire-table::table_popup_forms.permit")
    @endif

</div>
