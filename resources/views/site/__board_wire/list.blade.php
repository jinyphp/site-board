{{-- bootstrap Cartzilla --}}
<!-- Table with hoverable rows -->
<div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th width="50" scope="col">
            <input type='checkbox'
                class="form-check-input"
                wire:model.live="selectedall">
          </th>

          <th scope="col">타이틀</th>
          <th width="100" scope="col">조회수</th>

        </tr>
      </thead>
      <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
                <tr>
                    <th width="50" scope="row">
                        <input type='checkbox' name='ids' value="{{$item->id}}"
                        class="form-check-input" wire:model.live="selected">
                    </th>

                    <td>
                        <x-click wire:click="view({{$item->id}})">
                            {{$item->title}}
                        </x-click>
                        <div style="font-size: 0.7rem">
                            {{$item->created_at}}
                        </div>
                    </td>
                    <td width="100" class="text-nowrap">{{$item->click}}</td>
                </tr>
            @endforeach
        @endif

      </tbody>
    </table>
</div>
