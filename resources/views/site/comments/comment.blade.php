<section>
    <!-- Root Comment form-->
    @if (!$reply_id)
        {{-- 응답글을 작성할때에는 잠시 숨김 --}}
        <div class="mb-2">
            <textarea class="form-control" rows="3"
                placeholder="토론에 참여하고 댓글을 남겨주세요1!"
                wire:model.defer="forms.content">
            </textarea>
            <x-flex-between class="mt-2">
                <div>

                </div>
                <div>
                    <button class="btn btn-primary btn-sm" wire:click="store">작성</button>
                </div>
            </x-flex-between>
        </div>
    @endif

    <!-- 중첩된 댓글이 있는 댓글 -->
    @foreach ($rows as $item)
        <div class="d-flex mb-4">
            <div class="flex-shrink-0">
                <!-- 아바타 이미지-->
                @if(isset($item['user_id']))
                <img src="/home/avatas/{{$item['user_id']}}"
                    alt="사용자 아바타"
                    class="rounded-circle"
                    style="width: 50px; height: 50px;" />
                @else
                <img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." />
                @endif
            </div>
            <div class="ms-3 flex-grow-1">
                @if ($editmode != 'edit')
                    <div class="fw-bold">
                        {{ $item['name'] }}
                    </div>

                    <div class="mb-2">
                        {{ $item['content'] }}
                    </div>

                    <x-flex class="gap-3">
                        @if($item['user_id'] == Auth::user()->id)
                            <span wire:click="delete({{ $item['id'] }})">삭제</span>
                            <span wire:click="edit({{ $item['id'] }})">수정</span>
                        @endif
                        <span wire:click="reply({{ $item['id'] }}, {{ $item['level'] }})">댓글달기</span>
                    </x-flex>
                @endif

                {{-- 댓글 수정 폼 --}}
                @if ($item['id'] == $reply_id)
                    <div class="mt-2">
                        <textarea class="form-control" rows="3"
                            placeholder="토론에 참여하고 댓글을 남겨주세요2!"
                            wire:model.defer="forms.content">
                        </textarea>
                        <x-flex-between class="mt-2">
                            <div></div>
                            <div>
                                @if ($editmode == 'edit')
                                    <button class="btn btn-secondary btn-sm" wire:click="cencel()">취소</button>
                                    <button class="btn btn-info btn-sm" wire:click="update()">수정</button>
                                @else
                                    <button class="btn btn-primary btn-sm" wire:click="store()">작성</button>
                                @endif

                            </div>
                        </x-flex-between>
                    </div>
                @endif

                @if (isset($item['items']))
                    @include('jiny-site-board::site.comments.reply', [
                        'items' => $item['items']
                    ])
                @endif
            </div>
        </div>
    @endforeach
</section>
