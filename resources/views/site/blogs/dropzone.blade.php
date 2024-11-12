<div>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropzone = document.getElementById('dropzone');
            var progressArea = dropzone.querySelector(".progress-area");
            let token = dropzone.querySelector('input[name=_token]').value;

            dropzone.addEventListener('drop', function(e){
                e.preventDefault();

                let target = e.target;
                while(!target.classList.contains("dropzone")) {
                    target = target.parentElement;
                }
                target.classList.remove("dragover");

                var files = e.dataTransfer.files;
                for(let i=0; i < e.dataTransfer.files.length; i++) {
                    console.log(e.dataTransfer.files[i]);
                    uploadFile(e.dataTransfer.files[i]);
                }
            });

            dropzone.addEventListener('dragover', function(e){
                e.preventDefault();
                if(dragStart) return;
                let target = e.target;
                while(!target.classList.contains("dropzone")) {
                    target = target.parentElement;
                }
                target.classList.add("dragover");

                console.log("drag over...");
            });

            dropzone.addEventListener('dragleave', function(e){
                e.preventDefault();
                let target = e.target;
                while(!target.classList.contains("dropzone")) {
                    target = target.parentElement;
                }
                target.classList.remove("dragover");
            });

            // 파일 업로드
            function uploadFile(file) {
                var name = file.name;

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "/api/upload/images");


                let data = new FormData();
                data.append('file[]', file);
                data.append('_token', token);

                // dropzone의 path 값을 _uri로 설정
                const dropzonePath = document.getElementById('dropzone').getAttribute('path');
                if (dropzonePath) {
                    data.append('path', dropzonePath);
                }


                xhr.upload.addEventListener("progress", ({loaded, total}) =>{
                    let fileLoaded = Math.floor((loaded / total) * 100);
                    let fileTotal = Math.floor(total / 1000);
                    let fileSize;
                    (fileTotal < 1024) ? fileSize = fileTotal + " KB" : fileSize = (loaded / (1024*1024)).toFixed(2) + " MB";

                    console.log(name + "=" + fileSize);


                    let progressHTML = `<div class="details">
                            <span class="name">` + name + `</span>
                            <span class="percent">` +  " : " +fileLoaded + `%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="width: `+fileLoaded +`%"></div>
                        </div>`;
                    progressArea.innerHTML = progressHTML;
                });

                xhr.onload = function() {
                    var data = JSON.parse(this.responseText);
                    console.log(data);

                    // 페이지 갱신
                    //location.reload();
                }

                xhr.send(data);
            }

        });
    </script>

</div>
