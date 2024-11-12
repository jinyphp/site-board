<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th width="100" scope="col" class="text-center">번호</th>
                <th scope="col">제목</th>
                <th width="100" scope="col" class="text-center">조회수</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $item)
            <tr onclick="location.href='{{ route('board.view', ['code'=>$code, 'id'=>$item->id]) }}'"
                style="cursor:pointer">
                <td width="100" class="text-center">
                    {{$item->id}}
                </td>
                <td>
                    <div>{{ \Illuminate\Support\Str::limit($item->title, 50, '...') }}</div>
                    <small class="text-muted">
                        @if($item->name){{$item->name}} |@endif
                        {{date('Y-m-d', strtotime($item->created_at))}}
                    </small>
                </td>
                <td width="100" class="text-center">
                    <div>{{$item->click}}</div>
                    {{-- <div>{{$item->like}}</div> --}}
                    {{-- <div>{{$item->rank}}</div> --}}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center py-4">게시글이 없습니다.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
