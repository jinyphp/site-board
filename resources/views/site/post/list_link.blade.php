{{-- bootstrap Cartzilla --}}
<!-- Table with hoverable rows -->
<div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>

          <th scope="col">타이틀</th>

          <th width="150" scope="col">작성일자</th>
        </tr>
      </thead>
      <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
                <tr>

                    <td>
                        @if(isset($board['slug']) && $board['slug'])
                        <a href="/post/{{$item->id}}">
                            {{$item->title}}
                        </a>
                        @else
                        <a href="/post/{{$item->id}}">
                            {{$item->title}}
                        </a>
                        @endif
                    </td>
                    <td width="150" class="text-nowrap">{{$item->created_at}}</td>
                </tr>
            @endforeach
        @endif

      </tbody>
    </table>
</div>
