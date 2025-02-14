<x-navtab class="mb-3 nav-bordered">

    <!-- formTab -->
    <x-navtab-item class="show active" >

        <x-navtab-link class="rounded-0 active">
            <span class="d-none d-md-block">기본정보</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>활성화</x-form-label>
            <x-form-item>
                {!! xCheckbox()
                    ->setWire('model.defer',"forms.enable")
                !!}
            </x-form-item>
        </x-form-hor>

        {{-- <x-form-hor>
            <x-form-label>코드</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.code")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor> --}}

        {{-- <x-form-hor>
            <x-form-label>slug</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.slug")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor> --}}

        <x-form-hor>
            <x-form-label>Slug</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.slug")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>제목</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.title")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>


        <x-form-hor>
            <x-form-label>이미지</x-form-label>
            <x-form-item>
                <div wire:loading wire:target="forms.image"
                    class="inline-flex items-center ml-2">
                    <div class="spinner-border spinner-border-sm text-primary"
                        role="status">
                        <span class="visually-hidden">업로드 중...</span>
                    </div>
                    <span class="text-primary ms-2">파일 업로드 중...</span>
                </div>
                <input type="file" class="form-control" id="imageUpload"
                    wire:model.live="forms.image"
                    accept="image/*"
                    wire:loading.attr="disabled">
                @if(isset($forms['image']))
                    <div class="">
                        {{ $forms['image'] }}
                    </div>
                @endif

            </x-form-item>
        </x-form-hor>


        <x-form-hor>
            <x-form-label>부제목</x-form-label>
            <x-form-item>
                {!! xTextarea()
                    ->setWire('model.defer',"forms.subtitle")
                !!}
            </x-form-item>
        </x-form-hor>



    </x-navtab-item>

    <!-- 목록 -->
    <x-navtab-item class="">
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">계시물목록</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>글쓰기 허용</x-form-label>
            <x-form-item>
                <input type="checkbox" wire:model.defer="forms.permit_create"
                    {{ isset($forms['permit_create']) && $forms['permit_create'] == 1 ? 'checked' : '' }}>
                <p>글쓰기 기능을 허용합니다.</p>
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>테이블 Blade</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view_table")
                    ->setWidth("standard")
                !!}
                <p>계시물의 테이블 목록을 수정합니다.</p>
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>리스트 Blade</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view_list")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>필터  Blade</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view_filter")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

    </x-navtab-item>

    <!-- formTab -->
    <x-navtab-item class="">
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">화면</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>레이아웃</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view_layout")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>



        <x-form-hor>
            <x-form-label>글작성</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view_create")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>글보기</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view_detail")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>수정</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view_edit")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>폼양식</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view_form")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>Header</x-form-label>
            <x-form-item>
                {!! xTextarea()
                    ->setWire('model.defer',"forms.header")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>Footer</x-form-label>
            <x-form-item>
                {!! xTextarea()
                    ->setWire('model.defer',"forms.footer")
                !!}
            </x-form-item>
        </x-form-hor>

    </x-navtab-item>

    <!-- formTab -->
    <x-navtab-item class="">
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">관리</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>담당자</x-form-label>
            <x-form-item>
                {!! xSelect()
                    ->table('site_manager','user_name')
                    ->setWire('model.defer',"forms.manager")
                    ->setWidth("standard")
                !!}


            </x-form-item>
        </x-form-hor>

    </x-navtab-item>

    <!-- formTab -->
    <x-navtab-item class="">
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">메모</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>설명</x-form-label>
            <x-form-item>
                {!! xTextarea()
                    ->setWire('model.defer',"forms.description")
                !!}
            </x-form-item>
        </x-form-hor>

    </x-navtab-item>

</x-navtab>

