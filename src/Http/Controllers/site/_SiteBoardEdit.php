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
class SiteBoardCreate extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_board_";

        //$this->actions['view']['list'] = "jiny-site-cms::site.board_code.list";
        $this->actions['view']['form'] = "jiny-site-board::site.board_code.form";

        //$this->actions['title'] = "계시글";
        //$this->actions['subtitle'] = "작성된 계시글을 관리합니다.";

        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['layout'] = "jiny-site-board::site.board_code.create";


    }

    public function index(Request $request)
    {
        $code = $request->code;
        $this->actions['table'] .= $code; // 테이블명을 변경함

        $id = $request->id;
        $row = DB::table($this->actions['table'])->where('id',$id)->first();

        return view("jiny-site-board::site.board_code.create",[
            'actions' => $this->actions,
            'code' => $code
        ]);
    }


    ## 신규 데이터 DB 삽입전에 호출됩니다.
    public function hookStoring($wire,$form)
    {
        return $form; // 사전 처리한 데이터를 반환합니다.
    }

    ## 라우트 post
    ## ajax요청으로 들어온 내용을 저장합니다.
    public function store(Request $request)
    {
        $code = $request->code;
        $this->actions['table'] .= $code; // 테이블명을 변경함

        $request->validate([
            'forms.title' => 'required|string|max:255',
            'forms.content' => 'required|string',
        ]);

        $forms = $request->forms;

        // 데이터를 삽입합니다.
        DB::table($this->actions['table'])->insert($forms);

        return response()->json([
            'forms' => $forms,
            'message' => 'Form submitted successfully!',
        ]);
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
