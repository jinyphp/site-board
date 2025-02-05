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
class AdminBoardTrend extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table']['name'] = "site_board_trend";

        $this->actions['view']['list'] = "jiny-site-board::admin.board_trend.list";
        $this->actions['view']['form'] = "jiny-site-board::admin.board_trend.form";

        $this->actions['title'] = "트랜드글";
        $this->actions['subtitle'] = "계시물과 연관된 관련글을 관리합니다.";
    }


    ## 신규 데이터 DB 삽입전에 호출됩니다.
    public function hookStoring($wire,$form)
    {
        // 타이틀명 hash코드를 기반으로
        // 신규 테이블을 생성합니다.
        /*
        if(isset($form['title']) && $form['title']) {
            $code = md5($form['title'].date("Y-m-d_H:i:s"));
            $code = substr($code,0,7);
            $form['code'] = $code;

            // 테이블을 생성합니다.
            $this->schemaCreate("site_board_".$code);
        }
            */

        return $form; // 사전 처리한 데이터를 반환합니다.
    }






    ## 데이터를 수정하기전에 호출됩니다.
    public function hookUpdating($wire, $form, $old)
    {
        // 코드는 변경이 불가능합니다.
        // 수정이 안되도록 항목을 삭제
        unset($form['code']);

        return $form;
    }

    ## delete 동직이 실행된후 호출됩니다.
    public function hookDeleted($wire, $row)
    {
        //Schema::dropIfExists("site_board_".$row['code']);
        return $row;
    }

    ## 선택해서 삭제하는 경우 호출됩니다.
    public function hookCheckDeleting($selected)
    {
        $rows = DB::table($this->actions['table']['name'])->whereIn('id',$selected)->get();
        //dd($rows);
        foreach($rows as $item) {
            //Schema::dropIfExists("site_board_".$item->code);
        }

    }


}
