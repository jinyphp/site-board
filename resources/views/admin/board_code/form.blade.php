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
            <x-form-label>제목</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.title")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>



        <x-form-hor>
            <x-form-label>내용</x-form-label>
            <x-form-item>
                {!! xTextarea()
                    ->setWire('model.defer',"forms.content")
                !!}
            </x-form-item>
        </x-form-hor>

    </x-navtab-item>

    <!-- formTab -->
    <x-navtab-item class="">
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">작성자</span>
        </x-navtab-link>


    </x-navtab-item>

    <!-- formTab -->
    <x-navtab-item class="">
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">관리</span>
        </x-navtab-link>


    </x-navtab-item>

</x-navtab>

