<div>
    <!-- Text input -->
    <div class="mb-3">
        <label for="text-input" class="form-label">제목</label>
        <input type="text" class="form-control" id="text-input" wire:model="forms.title">
    </div>

    <!-- Textarea -->
    <div class="mb-3">
        <label for="textarea-input" class="form-label">내용</label>
        <textarea class="form-control" id="textarea-input" rows="20" wire:model="forms.content">
        </textarea>
    </div>

    <!-- Text input -->
    <div class="mb-3">
        <label for="text-input" class="form-label">테그</label>
        <input type="text" class="form-control" id="text-input"
            wire:model="forms.tags">
    </div>

    <!-- Text input -->
    <div class="mb-3">
        <label for="text-input" class="form-label">이미지</label>
        <input type="file" class="form-control" id="imageUpload"
            wire:model.live="forms.image" accept="image/*"
            wire:loading.attr="disabled">

        <div wire:loading wire:target="forms.image"
            class="inline-flex items-center ml-2">
            <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">업로드 중...</span>
            </div>
            <span class="text-primary ms-2">파일 업로드 중...</span>
        </div>

        @if(isset($forms['image']) && $forms['image'])
        <small class="text-muted">
            {{$forms['image']}}
        </small>
        @endif
    </div>

</div>
