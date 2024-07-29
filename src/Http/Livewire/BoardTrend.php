<?php
namespace Jiny\Site\Board\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class BoardTrend extends Component
{
    public $viewFile;
    public $code;
    public $post_id;

    public function mount()
    {
        if(!$this->viewFile) {
            $this->viewFile = "jiny-site-board::site.board_trend.live";
        }
    }

    public function render()
    {
        $rows = [];
        if($this->code) {
            $db = DB::table('site_board_trend')
                ->where('code', $this->code);

            if($this->post_id) {
                $db->where('post_id', $this->post_id);
            }

            $rows = $db->limit(5) // 최대 5개
                ->get();
        }

        return view($this->viewFile,[
            'rows' => $rows
        ]);
    }
}
