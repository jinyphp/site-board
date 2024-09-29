<x-www-app>
    <x-www-layout>
        <!-- Page content -->
        <main class="content-wrapper">

            <!-- Breadcrumb -->
            <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
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

            <section class="container pb-5 mb-1 mb-sm-3 mb-lg-4 mb-xl-5">
                {{-- 입력폼 --}}
                <form action="/board/{{$code}}/create" id="ajaxForm" method="POST">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    @includeIf($actions['view']['form'])

                    <button type="submit" class="btn btn-primary">Submit</button>
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
                        console.log(result);
                        document.getElementById('responseMessage').innerText
                            = 'Form submitted successfully!';
                        // 이전 페이지로 이동
                        window.history.back(); //go(-2);

                    } else {
                        document.getElementById('responseMessage').innerText
                        = 'Error: ' + result.message;
                    }

                } catch (error) {
                        document.getElementById('responseMessage').innerText = 'Error: ' + error.message;
                }
            });
        });
    </script>

            </section>
        </main>

    </x-www-layout>
</x-www-app>

