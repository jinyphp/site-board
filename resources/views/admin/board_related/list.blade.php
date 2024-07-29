<x-wire-table>
    {{-- 테이블 제목 --}}
    <x-wire-thead>
        <th width='200'>계시판</th>
        <th width='100'>글번호</th>
        <th></th>
        <th width='200'>연관</th>
        <th width='200'>연관글</th>
        <th width='200'>등록일자</th>
    </x-wire-thead>
    <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
            {{-- 테이블 리스트 --}}
            <x-wire-tbody-item :selected="$selected" :item="$item">
                <td width='200'>
                    {{$item->code}}
                </td>
                <td width='100'>
                    {{$item->post_id}}
                </td>
                <td>

                </td>
                <td width='200'>
                    {{$item->related}}
                </td>
                <td width='200'>{{$item->related_id}}</td>
                <td width='200'>{{$item->created_at}}</td>
            </x-wire-tbody-item>
            @endforeach
        @endif
    </tbody>
</x-wire-table>
