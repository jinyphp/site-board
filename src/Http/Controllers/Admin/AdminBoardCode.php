<?php
namespace Jiny\Site\Board\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminBoardCode extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_board_";

        $this->actions['view']['list'] = "jiny-site-board::admin.board_code.list";
        $this->actions['view']['form'] = "jiny-site-board::admin.board_code.form";

        $this->actions['title'] = "계시글";
        $this->actions['subtitle'] = "작성된 계시글을 관리합니다.";
    }

    public function index(Request $request)
    {
        $code = $request->code;
        $this->actions['table'] .= $code; // 테이블명을 변경함

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
