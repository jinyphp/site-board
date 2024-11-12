<div class="card h-100">
    <div class="card-header">
        <x-flex-between>
            <div>
                <h5 class="card-title">
                    <a href="/admin/site/posts">
                        포스트
                    </a>

                    <span>
                        ( {{table_count("site_posts")}} )
                    </span>


                </h5>
                <h6 class="card-subtitle text-muted">
                    블로그 포스트를 관리합니다.
                </h6>
            </div>
            <div>
                {{-- @icon("info-circle.svg") --}}
            </div>
        </x-flex-between>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>제목</th>
                <th width="100px">작성일자</th>
            </tr>
        </thead>
        <tbody>
            @foreach (getPosts(5) as $item)
            <tr>
                <td>{{$item->title}}</td>
                <td width="100px">{{substr($item->created_at,0,10)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
