<x-wire-table>
    {{-- 테이블 제목 --}}
    <x-wire-thead>
        <th width='200'>code/slug</th>

        <th>타이틀</th>
        <th width='100'>조회수</th>
        <th width='200'>작성자</th>
        <th width='200'>등록일자</th>
    </x-wire-thead>
    <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
            {{-- 테이블 리스트 --}}
            <x-wire-tbody-item :selected="$selected" :item="$item">
                <td width='200'>
                    {{$item->code}}
                    @if($item->slug)
                        ({{$item->slug}})
                    @endif
                    <a href="/post/{{$item->id}}" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 1 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
                            <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
                        </svg>
                    </a>
                </td>

                <td>
                    <x-click wire:click="edit({{$item->id}})">
                        @if($item->enable != 1)
                            <span class="text-decoration-line-through">
                                {{$item->title}}
                            </span>
                        @else
                            {{$item->title}}
                        @endif
                    </x-click>


                </td>
                <td width='100'>
                    {{$item->click}}
                </td>

                <td width='200'>
                    <div>{{$item->name}}</div>
                    <div>{{$item->email}}</div>
                </td>
                <td width='200'>
                    {{$item->created_at}}
                </td>
            </x-wire-tbody-item>
            @endforeach
        @endif
    </tbody>
</x-wire-table>
