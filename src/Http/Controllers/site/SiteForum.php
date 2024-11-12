<?php
namespace Jiny\Site\Board\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Livewire를 이용한 싱글 popup
 */
use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class SiteForum extends WireTablePopupForms
{
    public $code;

    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_board_";

        $this->actions['view']['list'] = "jiny-site-board::site.forum.code.list";
        $this->actions['view']['form'] = "jiny-site-board::site.Forum.code.form";

        $this->actions['title'] = "계시글";
        $this->actions['subtitle'] = "작성된 계시글을 관리합니다.";

        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['layout'] = "jiny-site-board::site.forum.layout";

        // 테이블을 커스텀 변경합니다.
        //$this->actions['view']['table'] = "jiny-site-board::site.forum.table";
    }

    /**
     * 계시판 정보 읽기
     */
    private function boardInfo($code)
    {
        $tablename = 'site_board';

        // Slug로 코드 변경
        $board = DB::table($tablename)->where('slug',$code)->first();
        if($board) {
            $this->actions['table'] .= $board->code; // 테이블명을 변경함
        } else {
            $this->actions['table'] .= $code; // 테이블명을 변경함
            $board = DB::table($tablename)->where('code',$code)->first();
        }

        return $board;
    }


    public function index(Request $request)
    {
        // 계시판 코드
        if(isset($request->code)) {
            $this->code = $request->code;
            $this->actions['code'] = $request->code;
        } else {
            if(isset($this->actions['code'])) {
                $this->code = $this->actions['code'];
            }
        }

        if(!$this->code) {
            return view("jiny-site-board::site.board2.error",[
                'message' => "지정한 계시판이 존재하지 않습니다."
            ]);
        }


        // DB에서 계시판 정보 읽기
        $board = $this->boardInfo($this->code);

        ## actions 보드 정보들 추가합니다.
        //$this->actions['board'] = []; //초기화
        if($board) {
            // 계시판 테이블 정보
            // foreach($board as $key => $value) {
            //     $this->actions['board'][$key] = $value;
            // }
            // //$this->params['board'] = $this->actions['board'];
            // $this->params['board'] = $board;

            // 계시판 지정 레이아웃
            if($board->view_layout) {
                $this->actions['view']['layout'] = $board->view_layout;
            }

            // 계시판 지정 테이블
            if($board->view_table) {
                $this->actions['view']['table'] = $board->view_table;
            }

            // 계시판 지정 리스트(테이블)
            if($board->view_list) {
                $this->actions['view']['list'] = $board->view_list;
            }

        } else {
            // 계시판이 존재하지 않습니다.
            //$this->actions['view']['layout'] = "jiny-site-board::error";
            return view("jiny-site-board::error",[
                'message' => "지정한 계시판이 존재하지 않습니다."
            ]);
        }


        // view에게 전달할 메개변수를 설정합니다.
        $this->params['board'] = $board;
        $this->params['code'] = $this->code;

        return parent::index($request);
    }


    ## 신규 데이터 DB 삽입전에 호출됩니다.
    public function hookStoring($wire,$form)
    {


        return $form; // 사전 처리한 데이터를 반환합니다.
    }






    ## 데이터를 수정하기전에 호출됩니다.
    public function hookUpdating($wire, $form, $old)
    {


        return $form;
    }

    ## delete 동직이 실행된후 호출됩니다.
    public function hookDeleted($wire, $row)
    {

        return $row;
    }

    ## 선택해서 삭제하는 경우 호출됩니다.
    public function hookCheckDeleting($selected)
    {


    }
}
