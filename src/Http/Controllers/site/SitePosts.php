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
class SitePosts extends WireTablePopupForms
{
    public $code;

    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table']['name'] = "site_board_";

        $this->actions['view']['list'] = "jiny-site-board::site.forum.code.list";
        $this->actions['view']['form'] = "jiny-site-board::site.Forum.code.form";

        $this->actions['title'] = "계시글";
        $this->actions['subtitle'] = "작성된 계시글을 관리합니다.";



        // 테이블을 커스텀 변경합니다.
        //$this->actions['view']['table'] = "jiny-site-board::site.forum.table";
    }




    public function index(Request $request)
    {
        if(isset($request->code)) {
            $this->code = $request->code;
            $this->actions['code'] = $request->code;
        } else {
            if(isset($this->actions['code'])) {
                $this->code = $this->actions['code'];
            }
        }

        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['layout'] = "jiny-site-board::site.post.layout";

        // view에게 전달할 메개변수를 설정합니다.
        $this->params['code'] = $this->code;

        return parent::index($request);
    }


    ## 신규 데이터 DB 삽입전에 호출됩니다.
    public function hookStoring($wire,$form)
    {


        return $form; // 사전 처리한 데이터를 반환합니다.
    }




}
