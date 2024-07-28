<?php
namespace Jiny\Site\Board\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class BoardList extends Component
{
    public $viewFile = "jiny-site-board::site.board_list.live";

    public function render()
    {
        $rows = DB::table('site_board')->get();

        return view($this->viewFile,[
            'rows' => $rows
        ]);
    }
}
