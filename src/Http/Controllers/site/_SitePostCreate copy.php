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

use Jiny\Site\Http\Controllers\SiteController;
class SitePostCreate extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_posts";

        $this->actions['view']['form'] = "jiny-site-board::site.post.form";

        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['create'] = "jiny-site-board::site.post.create";

    }

    public function index(Request $request)
    {
        /*
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
            */

        ## actions 보드 정보들 추가합니다.
        /*
        $this->actions['board'] = []; //초기화
        foreach($board as $key => $value) {
            $this->actions['board'][$key] = $value;
        }
        */

        // 계시판 지정 레이아웃
        /*
        if($board->view_create) {
            $this->actions['view']['create'] = $board->view_create;
        }

        if($board->view_form) {
            $this->actions['view']['form'] = $board->view_form;
        }
        */

        return view($this->actions['view']['create'],[
            'actions' => $this->actions
        ]);
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
