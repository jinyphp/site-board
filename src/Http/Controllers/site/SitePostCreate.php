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

        //$this->actions['view']['form'] = "jiny-site-board::site.post.form";

        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['layout'] = "jiny-site-board::site.post_create.layout";

        // 이미지 파일을 업로드할 서브경로
        $this->actions['upload']['path'] = "/posts";
        $this->actions['upload']['move'] = "/images"; // www/images로 이미지를 이동합니다.

    }


    ## 라우트 post
    ## ajax요청으로 들어온 내용을 저장합니다.
    public function store(Request $request)
    {

        $request->validate([
            'forms.title' => 'required|string|max:255',
            'forms.content' => 'required|string',
        ]);

        $forms = $request->forms;

        // 2. 시간정보 생성
        $forms['created_at'] = date("Y-m-d H:i:s");
        $forms['updated_at'] = date("Y-m-d H:i:s");

        // 데이터를 삽입합니다.
        DB::table($this->actions['table'])->insert($forms);

        return response()->json([
            'forms' => $forms,
            'message' => 'Form submitted successfully!',
        ]);
    }

}
