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

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class SiteBoardTable extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_board_";

        $this->actions['view']['list'] = "jiny-site-board::site.board_code.list";
        $this->actions['view']['form'] = "jiny-site-board::site.board_code.form";

        $this->actions['title'] = "계시글";
        $this->actions['subtitle'] = "작성된 계시글을 관리합니다.";

        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['layout'] = "jiny-site-board::site.board_code.layout";

        // 테이블을 커스텀 변경합니다.
        $this->actions['view']['table'] = "jiny-site-board::site.board_code.table";
    }

    public function index(Request $request)
    {
        $code = $request->code;
        $this->actions['code'] = $code;

        // Slug로 코드 변경
        $board = DB::table('site_board')->where('slug',$code)->first();
        if($board) {
            $this->actions['table'] .= $board->code; // 테이블명을 변경함
        } else {
            $this->actions['table'] .= $code; // 테이블명을 변경함
            $board = DB::table('site_board')->where('code',$code)->first();
        }

        ## actions 보드 정보들 추가합니다.
        $this->actions['board'] = []; //초기화
        foreach($board as $key => $value) {
            $this->actions['board'][$key] = $value;
        }

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
