<div>
    <!-- Text input -->
    <div class="mb-3">
        <label for="text-input" class="form-label">제목</label>
        <input type="text" class="form-control" id="text-input"
            name="forms[title]">
    </div>

    <!-- Textarea -->
    <div class="mb-3">
        <label for="quill-editor" class="form-label">내용</label>
        <div id="quill-editor" style="height: 300px;"></div>
        <input type="hidden" name="forms[content]" id="quill-content">

        <!-- Quill 스크립트와 스타일 추가 -->
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <style>
            .ql-container.ql-snow {
                border: 1px solid #ccc;
            }
            .ql-toolbar.ql-snow {
                border: 1px solid #ccc;
                border-bottom: none;
            }
            .ql-container.ql-snow:focus-within,
            .ql-toolbar.ql-snow:focus-within,
            .ql-container.ql-snow:focus,
            .ql-toolbar.ql-snow:focus {
                outline: none !important;
                box-shadow: none !important;
                border-color: #ccc !important;
            }
            .ql-editor:focus {
                outline: none !important;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var quill = new Quill('#quill-editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            [{ 'script': 'sub'}, { 'script': 'super' }],
                            [{ 'indent': '-1'}, { 'indent': '+1' }],
                            [{ 'direction': 'rtl' }],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'font': [] }],
                            [{ 'align': [] }],
                            ['clean'],
                            ['link', 'image', 'video']
                        ]
                    }
                });
            });
        </script>
    </div>

</div>
