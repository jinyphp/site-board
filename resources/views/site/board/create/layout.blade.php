<x-www-app>
    <x-www-layout>
        <x-www-main>

            {{-- 계시판 타이틀 --}}
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2>{{ $board->title }}</h2>
                    <p class="text-muted">{{ $board->subtitle }}</p>
                </div>
                <div>
                    <!-- Breadcrumb -->
                    <nav class="pt-3 mb-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('board.list', ['code' => $code]) }}">Board</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{$code}}
                            </li>
                        </ol>
                    </nav>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary"
                            onclick="window.history.back()">
                            취소
                        </button>
                    </div>

                </div>
            </div>


            {{-- 입력폼 --}}
            <form action="{{ route('board.store', ['code' => $code]) }}"
                id="ajaxForm"
                method="POST">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                @includeIf($actions['view']['form'])

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">작성</button>
                </div>
            </form>

            {{-- ajax 응답 메시지 --}}
            {{-- <div id="responseMessage"></div> --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('ajaxForm');

                    form.addEventListener('submit', async function(event) {
                        event.preventDefault(); // Prevent the default form submission
                        const formData = new FormData(form);

                        try {
                            const response = await fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                },
                                body: formData
                            });

                            const result = await response.json();

                            if (response.ok) {
                                //console.log(result);
                                // // 이전 페이지로 이동
                                window.history.back(); //go(-2);

                            } else {
                                // document.getElementById('responseMessage').innerText
                                // = 'Error: ' + result.message;
                            }

                        } catch (error) {
                                // document.getElementById('responseMessage').innerText
                                // = 'Error: ' + error.message;
                        }
                    });
                });
            </script>

        </x-www-main>
    </x-www-layout>

    @livewire('site-board-setting', [
        'code' => $code,
    ])

</x-www-app>

