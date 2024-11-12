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
        <label for="simpleinput" class="form-label">사진</label>
        <input type="file" class="form-control"
                    wire:model="forms.image">
        @if(isset($forms['image']))
        <div class="p-2">파일명: /{{$forms['image']}}</div>
        <img src="/{{$forms['image']}}" width="300px" alt="">
        @endif
    </div>



</div>
