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
class SitePostTable extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);


        ## actions 기본설정 동작처리
        ## 테이블 정보
        $actions['table'] = "site_posts";

        $actions['title'] = "포스트";
        $actions['subtitle'] = "작성된 포스트를 관리합니다.";


        $actions['view']['form'] = "jiny-site-board::site.post.form";

        // 레이아웃을 커스텀 변경합니다.
        $actions['view']['layout'] = "jiny-site-board::site.post.layout";

        // 테이블을 커스텀 변경합니다.
        $actions['view']['table'] = "jiny-site-board::site.post_grid.grid";
        $actions['view']['list'] = "jiny-site-board::site.post_grid.item";

        $this->setReflectActions($actions);

    }





    public function index(Request $request)
    {
        dd("aa");
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
