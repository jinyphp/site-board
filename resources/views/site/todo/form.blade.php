<div>
    <div class="row">
        <div class="col-md-3">
            <!-- Text input -->
            <div class="mb-3">
                <label for="text-input" class="form-label">상태</label>
                <select class="form-select" id="text-input" wire:model="forms.status">
                    <option value="new">신규</option>
                    <option value="progress">진행중</option>
                    <option value="resolved">해결됨</option>
                    <option value="pending">보류</option>
                    <option value="closed">종료</option>
                </select>
            </div>
        </div>
        <div class="col-md-9">
            <!-- Text input -->
            <div class="mb-3">
                <label for="text-input" class="form-label">제목</label>
                <input type="text" class="form-control" id="text-input" wire:model="forms.title">
            </div>
        </div>
    </div>



    <!-- Textarea -->
    <div class="mb-3">
        <label for="textarea-input" class="form-label">내용</label>
        <textarea class="form-control" id="textarea-input" rows="20" wire:model="forms.content">
        </textarea>
    </div>

    <!-- Text input -->
    {{-- <div class="mb-3">
        <label for="text-input" class="form-label">테그</label>
        <input type="text" class="form-control" id="text-input" wire:model="forms.tags">
    </div> --}}

    <!-- Text input -->
    {{-- <div class="mb-3">
        <label for="text-input" class="form-label">이미지</label>
        <input type="file" class="form-control" id="imageUpload" wire:model.live="forms.image" accept="image/*"
            wire:loading.attr="disabled">

        <div wire:loading wire:target="forms.image" class="inline-flex items-center ml-2">
            <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">업로드 중...</span>
            </div>
            <span class="text-primary ms-2">파일 업로드 중...</span>
        </div>

        @if (isset($forms['image']) && $forms['image'])
            <small class="text-muted">
                {{ $forms['image'] }}
            </small>
        @endif
    </div> --}}

</div>
