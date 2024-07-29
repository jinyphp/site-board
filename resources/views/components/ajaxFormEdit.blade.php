<form {{$attributes}} id="ajaxForm" method="POST">
    @csrf
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="PUT">

    {{$slot}}

    <div class="d-flex justify-content-between">
        <div>
            <a href="delete" class="btn btn-danger">삭제</a>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">수정</button>
        </div>
    </div>
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
                window.history.back(); //go(-2);

            } else {
                document.getElementById('responseMessage').innerText
                = 'Error: ' + result.message;
            }

        } catch (error) {
                document.getElementById('responseMessage').innerText = 'Error: ' + error.message;
        }
    });

    /*
    const ajaxDelete = document.getElementById('ajaxDelete');
    form.addEventListener('click', async function(event) {
        event.preventDefault(); // Prevent the default form submission
        console.log("delete");

        let method = form.querySelector('input[name="_method"]');
        method.value='DELETE';
        console.log(method);
        const formData = new FormData(form);
        console.log(form);
        console.log(formData);

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
                window.history.go(-2);

            } else {
                document.getElementById('responseMessage').innerText
                = 'Error: ' + result.message;
            }

        } catch (error) {
                document.getElementById('responseMessage').innerText = 'Error: ' + error.message;
        }

    });
    */
});
</script>
