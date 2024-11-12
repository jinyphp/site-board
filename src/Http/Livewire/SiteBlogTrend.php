<?php
namespace Jiny\Site\Board\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SiteBlogTrend extends Component
{
    public $viewFile;
    //public $code;
    //public $post_id;

    public function mount()
    {
        if(!$this->viewFile) {
            $this->viewFile = "jiny-site-board::site.blogs.trend";
        }
    }

    public function render()
    {
        $rows = [];
        $db = DB::table('site_blogs');
        //$db = $db->where('trading', true);
        $db = $db->orderBy('hits', 'desc'); // 조회수 내림차순 정렬
        $rows = $db->limit(5) // 최대 5개
                ->get();

        return view($this->viewFile,[
            'rows' => $rows
        ]);
    }
}
