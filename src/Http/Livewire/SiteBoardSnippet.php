<?php
namespace Jiny\Site\Board\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * 계시판 Sinppet
 */
class SiteBoardSnippet extends Component
{
    public $code;
    public $board;
    public $tablename;
    public $limit = 5;
    public $rows;

    public function mount($code)
    {
        $this->code = $code;

        $board = $this->getBoard($this->code);
        foreach($board as $key => $value) {
            $this->board[$key] = $value;
        }

        $this->getRows($board);

    }

    /**
     * 계시판 정보 조회
     */
    public function getBoard($code)
    {
        return DB::table('site_board')->where('slug', $code)->first();
    }

    /**
     * 페이징 단위 설정
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * 계시판 데이터 조회
     */
    public function getRows($board)
    {
        // 테이블명 설정
        $this->tablename = "site_board_".$board->code;
        $rows = DB::table($this->tablename)
            ->orderBy('id','desc')
        ->limit($this->limit)
        ->get();
        foreach($rows as $row) {
            $temp = [];
            foreach($row as $key => $value) {
                $temp[$key] = $value;
            }
            $this->rows[] = $temp;
        }
    }

    /**
     * 렌더링
     */
    public function render()
    {
        $viewFile = 'jiny-site-board::site.board.snippet';
        return view($viewFile, [

        ]);
    }
}
