<?php
namespace Jiny\Site\Board\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SiteBlogCate extends Component
{
    public $viewFile;

    public function mount()
    {
        if(!$this->viewFile) {
            $this->viewFile = "jiny-site-board::site.blogs.cate";
        }
    }

    public function render()
    {
        $rows = DB::table('site_blogs')
            ->select('categories', DB::raw('count(*) as total'))
            ->whereNotNull('categories')
            ->groupBy('categories')
            ->get();

        //dd($rows);

        return view($this->viewFile,[
            'rows' => $rows
        ]);
    }
}
