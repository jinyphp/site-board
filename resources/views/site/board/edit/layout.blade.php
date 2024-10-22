<x-www-app>
    <x-www-layout>
        <x-www-main>

            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2>{{ $board->title }}</h2>
                    <p class="text-muted">{{ $board->description }}</p>
                </div>
                <div>
                    <!-- Breadcrumb -->
                    <nav class="pt-3 mb-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/board/{{$code}}">Board</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{$code}}
                            </li>
                        </ol>
                    </nav>

                    <div class="d-flex justify-content-end">
                        <button id="editButton" class="btn btn-info">수정</button>
                    </div>
                </div>
            </div>



            <section class="pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
                <form action="/board/{{ $code }}/{{ $row->id }}/edit" id="ajaxForm" method="POST">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">

                    @includeIf($actions['view']['form'])

                </form>

                @includeIf("jiny-site-board::site.board.edit.delete")


                <div id="responseMessage"></div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const form = document.getElementById('ajaxForm');
                        const editButton = document.getElementById('editButton');

                        editButton.addEventListener('click', function(event) {
                            event.preventDefault();
                            submitForm();
                        });

                        function submitForm() {
                            const formData = new FormData(form);

                            fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(result => {
                                if (result.message === 'Form submitted successfully!') {
                                    console.log("게시물이 성공적으로 수정되었습니다.");
                                    document.getElementById('responseMessage').innerText = '게시물이 성공적으로 수정되었습니다.';
                                    window.history.back();
                                } else {
                                    console.error('게시물 수정 중 오류가 발생했습니다:', result.message);
                                    document.getElementById('responseMessage').innerText = '오류: ' + result.message;
                                }
                            })
                            .catch(error => {
                                console.error('오류 발생:', error.message);
                                document.getElementById('responseMessage').innerText = '오류: ' + error.message;
                            });
                        }


                    });
                </script>
            </section>

        </x-www-main>
    </x-www-layout>
</x-www-app>