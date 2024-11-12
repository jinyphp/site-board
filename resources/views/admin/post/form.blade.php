<x-navtab class="mb-3 nav-bordered">

    <!-- formTab -->
    <x-navtab-item class="show active" >

        <x-navtab-link class="rounded-0 active">
            <span class="d-none d-md-block">기본정보</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>활성화</x-form-label>
            <x-form-item>
                <input type="checkbox" class="form-check-input"
                    wire:model.defer="forms.enable"
                    {{ isset($forms['enable']) && $forms['enable'] == 1 ? 'checked' : '' }}>
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>code</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.code")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>slug</x-form-label>
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

    </x-navtab-item>

    <!-- formTab -->
    <x-navtab-item class="" >
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">내용</span>
        </x-navtab-link>

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
            <x-form-label>Tags</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.tags")
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
    <x-navtab-item class="" >
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">작성자</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>이름</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.name")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

        <x-form-hor>
            <x-form-label>이메일</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.email")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>

    </x-navtab-item>

    <!-- formTab -->
    <x-navtab-item class="" >
        <x-navtab-link class="rounded-0">
            <span class="d-none d-md-block">분류</span>
        </x-navtab-link>

        <x-form-hor>
            <x-form-label>카테고리</x-form-label>
            <x-form-item>
                {!! xInputText()
                    ->setWire('model.defer',"forms.categories")
                    ->setWidth("standard")
                !!}
            </x-form-item>
        </x-form-hor>



    </x-navtab-item>

</x-navtab>

