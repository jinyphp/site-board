<x-navtab class="mb-3 nav-bordered">

    <x-navtab-item class="show active" >
        <x-navtab-link class="rounded-0 active">
            <span class="d-none d-md-block">기본정보</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>계시판</x-form-label>
            <x-form-item>
                {!! xSelect()
                    ->table('site_board','title')
                    ->setWire('model.defer',"forms.board")
                    ->setWidth("medium")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>페이징</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.paging")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>선택삭제</x-form-label>
            <x-form-item>
                {!! xCheckbox()
                    ->setWire('model.defer',"forms.delete.check")
                !!}
            </x-form-item>
        </x-form-hor>


    </x-navtab-item>


    <x-navtab-item>
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">목록</span>
        </x-navtab-link>



        <x-form-hor>
            <x-form-label>테이블</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view.table")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>


        <x-form-hor>
            <x-form-label>리스트</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view.list")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

    </x-navtab-item>

    <x-navtab-item>
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">생성/수정</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>입력폼</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view.form")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>글쓰기 허용</x-form-label>
            <x-form-item>
                {!! xCheckbox()
                    ->setWire('model.defer',"forms.create.enable")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>글쓰기 버튼이름</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.create.title")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>생성화면</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view.create")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>


        <x-form-hor>
            <x-form-label>글수정 허용</x-form-label>
            <x-form-item>
                {!! xCheckbox()
                    ->setWire('model.defer',"forms.edit.enable")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>수정화면</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view.edit")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

    </x-navtab-item>

    <x-navtab-item>
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">글보기</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>보기화면</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.view.view")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

    </x-navtab-item>
</x-navtab>
