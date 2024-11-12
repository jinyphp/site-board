{{-- Table with hoverable rows --}}
<div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
            {{-- 선택 체크 --}}
            @if(isset($widget['delete']['check']) && $widget['delete']['check'])
            <th width="50" scope="col">
                <input type='checkbox'
                    class="form-check-input"
                    wire:model.live="selectedall">
            </th>
            @endif

            <th width="100" scope="col" class="text-center">번호</th>
            <th scope="col">타이틀</th>
            <th width="100" scope="col" class="text-center">조회수</th>
        </tr>
      </thead>
      <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
                <tr>
                    {{-- 선택 체크 --}}
                    @if(isset($widget['delete']['check']) && $widget['delete']['check'])
                    <th width="50" scope="row">
                        <input type='checkbox' name='ids' value="{{$item->id}}"
                        class="form-check-input" wire:model.live="selected">
                    </th>
                    @endif

                    <td width="100" scope="col" class="text-center">
                        {{$item->id}}
                    </td>
                    <td>
                        <x-click wire:click="view({{$item->id}})"
                            class="text-decoration-none">
                            {{ \Illuminate\Support\Str::limit($item->title, 50, '...') }}
                        </x-click>
                        <div class="text-muted">
                            @if($item->name){{$item->name}} |@endif
                            {{date('Y-m-d', strtotime($item->created_at))}}
                        </div>
                    </td>
                    <td width="100" scope="col" class="text-center">
                        {{$item->click}}
                    </td>
                </tr>
            @endforeach
        @endif

      </tbody>
    </table>
</div>
