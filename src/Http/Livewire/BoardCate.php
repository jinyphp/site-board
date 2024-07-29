<?php
namespace Jiny\Site\Board\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class BoardCate extends Component
{
    public $viewFile;

    public function mount()
    {
        if(!$this->viewFile) {
            $this->viewFile = "jiny-site-board::site.board_cate.live";
        }
    }

    public function render()
    {
        $rows = DB::table('site_board')->get();

        return view($this->viewFile,[
            'rows' => $rows
        ]);
    }
}
