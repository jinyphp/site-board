<x-wire-table>
    {{-- 테이블 제목 --}}
    <x-wire-thead>
        <th width='200'>코드</th>
        <th width='100'>포스트</th>
        <th>타이틀</th>
        <th width='200'>디자인</th>
        <th width='200'>담당자</th>
        <th width='200'>등록일자</th>
    </x-wire-thead>
    <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
            {{-- 테이블 리스트 --}}
            <x-wire-tbody-item :selected="$selected" :item="$item">
                <td width='200'>
                    <div class="d-flex gap-2">
                        <div>
                            <div>{{$item->slug}}</div>
                            <a href="/admin/site/board/hash/{{$item->code}}">
                                {{$item->code}}
                            </a>
                        </div>
                        <a href="/board/{{$item->code}}" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-right-square" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5.854 8.803a.5.5 0 1 1-.708-.707L9.243 6H6.475a.5.5 0 1 1 0-1h3.975a.5.5 0 0 1 .5.5v3.975a.5.5 0 1 1-1 0V6.707z"/>
                            </svg>
                        </a>
                    </div>
                </td>
                <td width='100'>
                    <a href="/board/{{$item->code}}" target="_blank">
                        {{$item->post}}
                    </a>
                </td>
                <td>
                    <x-click wire:click="edit({{$item->id}})">
                        {{$item->title}}
                    </x-click>
                    <div>
                        {{$item->subtitle}}
                    </div>
                </td>
                <td width='200'>

                </td>
                <td width='200'>{{$item->manager}}</td>
                <td width='200'>{{$item->created_at}}</td>
            </x-wire-tbody-item>
            @endforeach
        @endif
    </tbody>
</x-wire-table>
