<?php
namespace Jiny\Site\Board\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * 계시판의 글 보기
 */
class SiteBoardView extends Component
{
    public $actions = [];

    public $viewFile;
    public $code;
    public $_id;

    public $tablename;
    public $board = [];

    public $editable = false;
    public $forms = [];


    public function mount()
    {
        if(!$this->viewFile) {
            $this->viewFile = "jiny-site-board::site.board.view";
        }

        $current_url = Request::url();
        $urls = array_reverse(explode('/',$current_url));

        // uri에서 계시물 번호 추출
        if(isset($urls[0]) && is_numeric($urls[0])) {
            $id = $urls[0];
            $this->_id = $urls[0];
        }

        // 계시판 코드 추출
        if(isset($urls[1]) && is_string($urls[1])) {
            $code = $urls[1];
            $this->code = $urls[1];
        }

        $this->boardInfo($code);

        // 계시물 조회수를 증가합니다.
        DB::table($this->tablename)
            ->where('id',$this->_id)
            ->increment('click');
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
        $row = DB::table($this->tablename)->where('id',$this->_id)->first();
        if($row) {
            if($this->editable) {
                $this->forms = [];
                foreach($row as $key => $value) {
                    $this->forms[$key] = $value;
                }

                //dd($this->forms);

                return view("jiny-site-board::site.board.edit");
            } else {
                return view($this->viewFile,[
                    'row' => $row
                ]);
            }

        }

        return view("jiny-site-board::site.board.error",[
            'message' => "존재하지 않는 계시물 입니다."
        ]);

    }

    public function edit()
    {
        $this->editable = true;
    }

    public function update()
    {
        DB::table($this->tablename)
            ->where('id',$this->_id)
            ->update($this->forms);

        $this->editable = false;

    }

    public function delete()
    {
        $this->editable = false;
    }
}
