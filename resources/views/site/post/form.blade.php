<div>
    <!-- Text input -->
    <div class="mb-3">
        <label for="text-input" class="form-label">제목</label>
        <input type="text" class="form-control" id="text-input"
            wire:model="forms.title">
    </div>

    <!-- Textarea -->
    <div class="mb-3">
        <label for="textarea-input" class="form-label">내용</label>
        <textarea class="form-control" id="textarea-input" rows="20"
        wire:model="forms.content">
        </textarea>
    </div>

    <!-- Text input -->
    <div class="mb-3">
      <label for="text-input" class="form-label">테그</label>
      <input type="text" class="form-control" id="text-input"
          wire:model="forms.tag">
    </div>

    <div class="mb-3">
        <label class="form-label">이미지</label>
        <input class="form-control" type="file" wire:model.defer="forms.image">
        <x-form-text>
            @if(isset($forms['image']))
            {{$forms['image']}}
            @endif
        </x-form-text>
    </div>

</div>
