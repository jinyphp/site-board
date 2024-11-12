<?php
namespace Jiny\Site\Board\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SiteBoardRelated extends Component
{
    public $board = [];
    public $viewFile;
    public $code;
    public $post_id;

    public $related_id;

    ## Hotkey 디자인 모드
    use \Jiny\Widgets\Http\Trait\DesignMode;

    public function mount()
    {
        if(!$this->viewFile) {
            $this->viewFile = "jiny-site-board::site.related.layout";
        }

        //dd($this->board);

        // $board = DB::table('site_board')
        //         ->where('', $this->code)
        //         ->first();
        // dd($board);
        // foreach($board as $key => $value) {
        //     $this->board[$key] = $value;
        // }



    }

    public function render()
    {
        $rows = [];
        if($this->code) {

            $db = DB::table('site_board_related')
                ->where('code', $this->code);
            if($this->post_id) {
                $db->where('post_id', $this->post_id);
            }
            $related = $db->limit(6) // 최대 6개
                ->get();


            $ids = [];
            foreach($related as $item) {
                $ids[] = $item->related_id;
            }

            //dd($this->board->code);
            $rows = DB::table('site_board_'.$this->board->code)
                ->whereIn('id', $ids)
                ->get();


        }


        return view($this->viewFile,[
            'rows' => $rows
        ]);
    }

    public function add()
    {
        DB::table('site_board_related')->insert([
            'code' => $this->code,
            'post_id' => $this->post_id,
            'related_id' => $this->related_id,
        ]);

        $this->related_id = '';
    }
}
