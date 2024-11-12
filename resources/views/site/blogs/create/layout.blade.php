<x-www-app>
    <x-www-layout>
        <x-www-main>

            {{-- 입력폼 --}}
            <form action="{{ route('blog.store') }}" id="ajaxForm" method="POST">
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


            {{-- 이미지 관리 --}}
            {{-- @livewire('site-blog-image', ['path' => '/images/blogs/_']) --}}

        </x-www-main>
    </x-www-layout>
</x-www-app>

