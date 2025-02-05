<x-www-app>
    <x-www-layout>
        <x-www-main>
            <nav class="pt-3 my-3 my-md-4" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="home-electronics.html">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Todo</li>
                </ol>
            </nav>

            <div class="mb-4">
                @livewire('site-post', [
                    'tablename' => 'site_todo',
                    'viewListFile' => 'jiny-site-board::site.todo.list',
                    'viewFormFile' => "jiny-site-board"."::site.todo.form"
                ])
            </div>

        </x-www-main>


    </x-www-layout>
</x-www-app>

