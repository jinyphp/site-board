<div>
    <h6>Categories</h6>
    @foreach($rows as $row)
    <div class="badge border border-secondary bg-white text-secondary me-1">
        {{$row->categories}}
        <span class="badge bg-secondary">
            {{$row->total}}
        </span>
    </div>
    @endforeach
</div>
