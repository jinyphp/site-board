<form {{$attributes}} id="ajaxForm" method="POST">
    @csrf
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="DELETE">

    {{$slot}}

    <button type="submit" class="btn btn-danger">삭제</button>
</form>

<div id="responseMessage"></div>

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
                window.history.go(-3);

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
