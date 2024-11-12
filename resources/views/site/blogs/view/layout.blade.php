<x-www-app>
    <x-www-layout>
        <x-www-main>
            <div class="d-flex justify-content-between align-items-start">
                <div>

                    <h3 class="d-flex">
                        <span class="d-flex align-items-center" onclick="window.history.back()" style="cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                            </svg>
                        </span>
                        <span class="ms-2">
                            {{ $row->title }}
                        </span>
                    </h3>


                    {{-- <small><a href="/blog" class="text-muted text-decoration-none">목록으로 돌아가기</a></small>
                    <h3>{{ $row->title }}</h3> --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">
                            @if($row->name)
                                작성자: {{ $row->name }} |
                            @endif
                            작성일: {{ $row->created_at}} |
                            조회수: {{ $row->click }}
                        </span>
                    </div>

                </div>
                <div>

                    <div class="d-flex justify-content-end">
                        @if (Auth::check() && Auth::user()->email === $row->email)
                            <a href="/blog/{{ $row->id }}/edit" class="btn btn-info ms-2">
                                수정
                            </a>
                        @endif

                        @if(isAdmin())
                        <a href="/blog/{{ $row->id }}/edit" class="btn btn-primary ms-2">
                            Admin
                        </a>
                        @endif
                    </div>
                </div>
            </div>


            <hr>

            @if($row->image && file_exists(public_path($row->image)))
                <div class="mb-4">
                    <img src="{{ asset($row->image) }}" alt="게시물 이미지" class="img-fluid">
                </div>
            @endif

            <div class="mb-4">
                {!! nl2br($row->content) !!}
            </div>


            {{-- <hr> --}}

            @if($row->tags)
                <div class="d-flex mt-4 gap-2">
                    <h5 class="mb-2">태그:</h5>
                    <div>
                        @foreach(explode(',', $row->tags) as $tag)
                            <span class="badge bg-secondary">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="social-share mt-4">
                <div class="d-flex justify-content-end gap-3">
                    <!-- 페이스북 공유 버튼 -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                        </svg>
                    </a>

                    <!-- 트위터 공유 버튼 -->
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($row->title) }}" target="_blank" class="text-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                            <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                        </svg>
                    </a>

                    <!-- 링크드인 공유 버튼 -->
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($row->title) }}" target="_blank" class="text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                            <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 댓글 -->
            {{-- <x-ui-divider>댓글</x-ui-divider>
            @livewire('site-board-comment',[
                'code' => $code,
                'post_id' => $row->id
            ]) --}}

            <!-- 연관 계시글 -->
            {{-- <x-ui-divider>연관 계시글</x-ui-divider>
            @livewire('site-board-related',[
                'board' => $board,
                'code' => $code,
                'post_id' => $row->id
            ]) --}}


        </x-www-main>
    </x-www-layout>
</x-www-app>



