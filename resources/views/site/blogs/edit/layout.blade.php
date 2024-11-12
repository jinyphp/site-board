<x-www-app>
    <x-www-layout>
        <x-www-main>

            <section class="pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
                <form action="{{ route('blog.update', $row->id) }}" id="ajaxForm" method="POST">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">

                    @includeIf($actions['view']['form'])

                </form>

                <div class="d-flex justify-content-center gap-4">
                    @includeIf("jiny-site-board::site.blogs.edit.delete")
                    <button id="editButton" class="btn btn-info">수정</button>
                </div>

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


            {{-- 이미지 관리 --}}
            @livewire('site-upload-image', [
                'path' => '/images/blogs/'.$row->id
                ])


        </x-www-main>


    </x-www-layout>
</x-www-app>
