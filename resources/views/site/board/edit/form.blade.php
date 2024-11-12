<div>
    <!-- 대표 이미지-->
    @if(isset($row->image))
    <div class="mb-3">
        <img src="{{$row->image}}" class="img-fluid" alt="대표 이미지">
    </div>
    @else
    {{-- <div class="mb-3">
        <div class="bg-gray-200 p-4 text-center">
            대표 이미지가 없습니다
        </div>
    </div> --}}
    @endif
    <div class="mb-3">
        <label for="image-input" class="form-label">대표 이미지</label>
        <input type="file" class="form-control" id="image-input" name="forms[image]" accept="image/*">
    </div>

    <!-- Text input -->
    <div class="mb-3">
        <label for="text-input" class="form-label">제목</label>
        <input type="text" class="form-control" id="text-input"
            name="forms[title]"
            @if(isset($row->title))
            value="{{$row->title}}"
            @endif
            >
    </div>

    <!-- Textarea -->
    <div class="mb-3">
        <label for="textarea-input" class="form-label">내용</label>
        <textarea class="form-control" id="textarea-input" rows="20" name="forms[content]">@if(isset($row->content)){{$row->content}}@endif</textarea>
    </div>

    <!-- Tags -->
    <div class="mb-3">
        <label for="text-input" class="form-label">테그</label>
        <input type="text" class="form-control" id="text-input"
            name="forms[tags]"
            @if(isset($row->tags)) value="{{$row->tags}}" @endif>
    </div>



</div>
