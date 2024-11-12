<div>
    <x-loading-indicator/>

    {{-- 포룸 타이틀 --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2>{{ $board['title'] }}</h2>
            <p class="text-muted">{{ $board['description'] }}</p>
        </div>
        <div>
            <!-- Breadcrumb -->
            <nav class="pt-3 mb-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/forum/{{$code}}">Forum</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{$code}}
                    </li>
                </ol>
            </nav>

            <div class="d-flex justify-content-end">
                @if ($board['permit_create'])
                    <a href="javascript:void(0)"
                        class="btn btn-info"
                        wire:click="create()">
                        작성
                    </a>
                @endif
            </div>
        </div>
    </div>


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
