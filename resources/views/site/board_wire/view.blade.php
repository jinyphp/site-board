<div>
    <!-- Post title -->
    <div class="d-flex justify-content-between">
        <div class="d-flex gap-2">
            <span wire:click="back()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                </svg>
            </span>
            <h1 class="h3 mb-4">
                {{$forms['title']}}
            </h1>
        </div>
        <div>
          <button class="btn btn-info"
            wire:click="edit('{{$forms['id']}}')">Edit</button>
        </div>
    </div>

    <!-- Post meta -->
    <div class="nav align-items-center gap-2 border-bottom pb-4 mt-n1 mb-4">
        <a class="nav-link text-body fs-xs text-uppercase p-0" href="#!">
            {{$forms['name']}} {{$forms['email']}}
        </a>
        <hr class="vr my-1 mx-1">
        <span class="text-body-tertiary fs-xs">{{$forms['created_at']}}</span>
    </div>

    <p>
        {{$forms['content']}}
    </p>

    <!-- Tags + Sharing -->
    <div class="d-sm-flex align-items-center justify-content-between py-4 py-md-5 mt-n2 mt-md-n3 mb-2 mb-sm-3 mb-md-0">
        <div class="d-flex flex-wrap gap-2 mb-4 mb-sm-0 me-sm-4">
            @foreach(explode(',',$forms['tags']) as $item)
                <a class="btn btn-outline-secondary px-3 mt-1 me-1"
                    href="#!">{{$item}}</a>
            @endforeach
        </div>
        <div class="d-flex align-items-center gap-2">
        <div class="text-body-emphasis fs-sm fw-medium">Share:</div>
            <a class="btn btn-icon fs-base btn-outline-secondary border-0"
                href="#!"
                data-bs-toggle="tooltip"
                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>' title="X (Twitter)" aria-label="Follow us on X">
                <i class="ci-x"></i>
            </a>
            <a class="btn btn-icon fs-base btn-outline-secondary border-0"
                href="#!"
                data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>' title="Facebook" aria-label="Follow us on Facebook">
                <i class="ci-facebook"></i>
            </a>
            <a class="btn btn-icon fs-base btn-outline-secondary border-0"
                href="#!"
                data-bs-toggle="tooltip"
                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>' title="Telegram" aria-label="Follow us on Telegram">
                <i class="ci-telegram"></i>
            </a>
        </div>
    </div>

</div>
