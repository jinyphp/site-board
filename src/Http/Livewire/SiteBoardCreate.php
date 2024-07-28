<?php
namespace Jiny\Site\Board\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * 계시판의 글 작성
 */
class SiteBoardCreate extends Component
{
    public $actions = [];

    public $viewFile;
    public $code;
    public $_id;

    public $tablename;
    public $board = [];
    public $forms = [];


    public function mount()
    {
        if(!$this->viewFile) {
            $this->viewFile = "jiny-site-board::site.board.create";
        }

        $current_url = Request::url();
        $urls = array_reverse(explode('/',$current_url));

        // 계시판 코드 추출
        if(isset($urls[1]) && is_string($urls[1])) {
            $code = $urls[1];
            $this->code = $urls[1];
        }

        $this->boardInfo($code);
    }

    private function boardInfo($code)
    {
        foreach($this->actions['board'] as $key => $value) {
            $this->board[$key] = $value;
        }

        $this->tablename = 'site_board_'.$this->actions['board']['code'];
    }


    public function render()
    {
        return view($this->viewFile,[

        ]);
    }


    public function submit()
    {
        // 2. 시간정보 생성
        $this->forms['created_at'] = date("Y-m-d H:i:s");
        $this->forms['updated_at'] = date("Y-m-d H:i:s");

        // 데이터를 삽입합니다.
        DB::table($this->tablename)->insert($this->forms);

        $this->dispatch('board-created');
    }
}
