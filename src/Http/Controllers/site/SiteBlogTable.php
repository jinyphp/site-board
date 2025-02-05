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
 * 블로그 목록을 출력합니다.
 */
use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class SiteBlogTable extends WireTablePopupForms
{
    public $code;

    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table']['name'] = "site_blogs";


        $this->actions['view']['form'] = "jiny-site-board::site.board_code.form";

        $this->actions['title'] = "계시글";
        $this->actions['subtitle'] = "작성된 계시글을 관리합니다.";


        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['layout'] = "jiny-site-board::site.blogs.table.layout";

        // 테이블을 커스텀 변경합니다.
        $this->actions['view']['table'] = "jiny-site-board::site.blogs.table.table";
        $this->actions['view']['list'] = "jiny-site-board::site.blogs.table.list";


    }


    /**
     * 블로그 목록 출력
     */
    public function index(Request $request)
    {
        // 계시판조회
        $rows = DB::table("site_blogs")
            ->orderBy('created_at', 'desc')
            ->paginate(16);
        $this->params['rows'] = $rows;

        return parent::index($request);
    }


    public function search(Request $request)
    {
        // 계시판조회
        $query = DB::table("site_blogs");

        // 검색 키워드가 있는 경우
        if ($request->has('query')) {
            $searchTerm = $request->query('query');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%'.$searchTerm.'%')
                  ->orWhere('content', 'like', '%'.$searchTerm.'%')
                  ->orWhere('tags', 'like', '%'.$searchTerm.'%');
            });
        }

        $rows = $query->orderBy('created_at', 'desc')
                      ->paginate(10);
        $this->params['rows'] = $rows;

        return parent::index($request);
    }


}
