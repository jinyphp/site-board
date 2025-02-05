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
 * 블로그 보기를 처리합니다.
 */
use Jiny\Site\Http\Controllers\SiteController;
class SiteBlogView extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table']['name'] = "site_blogs";



        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['layout'] = "jiny-site-board::site.blogs.view.layout";

        $this->actions['view']['confirm'] = "jiny-site-board::site.board_code.confirm";
    }


    public function index(Request $request)
    {
        // 글번호 id
        $id = $request->id;

        // view에게 전달할 메개변수를 설정합니다.
        $this->params['_id'] = $id;
        $row = DB::table("site_blogs")->where('id',$id)->first();
        if($row) {

            // 세션을 사용하여 조회수 중복 증가 방지
            $viewKey = 'viewed_post_' . $id;
            if (!$request->session()->has($viewKey)) {
                DB::table("site_blogs")->where('id', $id)->increment('click');
                $request->session()->put($viewKey, true);
            }

            $this->params['row'] = $row;
            return parent::index($request);
        }

        return view("jiny-site-board::site.blogs.view.error",[
            'message' => "지정한 글이 존재하지 않습니다."
        ]);

    }





}
