<!-- 삭제  -->
<div class="d-flex justify-content-center">
    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
        data-bs-target="#deleteConfirmModal">삭제</button>
</div>
<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1"
    aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">게시물 삭제 확인</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                정말로 이 게시물을 삭제하시겠습니까?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-danger" onclick="deletePost()">삭제</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('ajaxForm');
        const editButton = document.getElementById('editButton');

        // 삭제 함수
        window.deletePost = function() {
            const form = document.getElementById('ajaxForm');
            const formData = new FormData(form);
            formData.set('_method', 'DELETE');

            fetch('{{ route('blog.destroy', $row->id) }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    console.log("게시물이 성공적으로 삭제되었습니다.");
                    window.location.href = '/blog';
                } else {
                    console.error('게시물 삭제 중 오류가 발생했습니다:', result.message);
                    alert('게시물 삭제에 실패했습니다. 다시 시도해 주세요.');
                }
            })
            .catch(error => {
                console.error('오류 발생:', error.message);
            });

            // 모달 닫기
            var modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
            modal.hide();
        }
    });
</script>


