<div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @foreach($blogs as $blog)
            <div class="bg-white rounded-lg shadow-md p-4">
                <h2 class="text-xl font-bold">{{ $blog->title }}</h2>
            </div>
        @endforeach
        <div class="col-span-full flex justify-end">
            <a href="/blog/create"
                class="btn btn-primary">
                블로그 작성
            </a>
        </div>
    </div>

    <div class="mt-4">
        {{ $blogs->links() }}
    </div>
</div>
