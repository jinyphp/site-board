<x-wire-table>
    {{-- 테이블 제목 --}}
    <x-wire-thead>
        <th>타이틀</th>
        <th width='200'>작성자</th>
        <th width='200'>등록일자</th>
    </x-wire-thead>
    <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
            {{-- 테이블 리스트 --}}
            <x-wire-tbody-item :selected="$selected" :item="$item">

                <td>
                    <x-click wire:click="edit({{$item->id}})">
                        {{$item->title}}
                    </x-click>

                </td>
                <td width='200'></td>
                <td width='200'>{{$item->created_at}}</td>
            </x-wire-tbody-item>
            @endforeach
        @endif
    </tbody>
</x-wire-table>
