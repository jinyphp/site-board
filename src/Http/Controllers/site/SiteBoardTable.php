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
 * 계시판의 목록을 출력합니다.
 */
use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class SiteBoardTable extends WireTablePopupForms
{
    public $code;

    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table']['name'] = "site_board_";


        $this->actions['view']['form'] = "jiny-site-board::site.board_code.form";

        $this->actions['title'] = "계시글";
        $this->actions['subtitle'] = "작성된 계시글을 관리합니다.";


        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['layout'] = "jiny-site-board::site.board.table.layout";

        // 테이블을 커스텀 변경합니다.
        $this->actions['view']['table'] = "jiny-site-board::site.board.table.table";
        $this->actions['view']['list'] = "jiny-site-board::site.board.table.list";


    }

    /**
     * 계시판 정보 읽기
     */
    private function boardInfo($code)
    {

        $tablename = 'site_board';

        // Slug로 코드 변경
        $board = DB::table($tablename)->where('slug',$code)->first();
        if($board) {
            $this->actions['table']['name'] .= $board->code; // 테이블명을 변경함
        } else {
            $this->actions['table']['name'] .= $code; // 테이블명을 변경함
            $board = DB::table($tablename)->where('code',$code)->first();
        }

        return $board;
    }

    /**
     * 계시판 목록 출력
     */
    public function index(Request $request)
    {
        // url로 계시판 코드 지정
        if(isset($request->code)) {
            $this->code = $request->code;
            $this->actions['code'] = $request->code;
        } else {
            // actions에서 계시판 코드 지정
            if(isset($this->actions['code'])) {
                $this->code = $this->actions['code'];
            }
        }

        // 계시판 코드가 없으면 에러 페이지 출력
        if(!$this->code) {
            // return view("jiny-site-board::error",[
            //     'message' => "지정한 계시판이 존재하지 않습니다."
            // ]);

            // 계시판 데시보드 출력
            return view("jiny-site-board::site.board.dashboard");
        }


        // DB에서 계시판 정보 읽기
        $board = $this->boardInfo($this->code);
        if($board) {
            // 계시판마다 디자인을 변경할 수 있습니다.

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

        } else {
            // 계시판이 존재하지 않습니다.
            return view("jiny-site-board::error",[
                'message' => "지정한 계시판이 존재하지 않습니다."
            ]);
        }


        // view에게 전달할 메개변수를 설정합니다.
        $this->params['board'] = $board;
        $this->params['code'] = $this->code;

        // 계시판조회
        $rows = DB::table("site_board_".$board->code)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $this->params['rows'] = $rows;
        //dd($this->params);

        //dd($this->actions);

        return parent::index($request);
    }

    public function search(Request $request)
    {
        // url로 계시판 코드 지정
        if(isset($request->code)) {
            $this->code = $request->code;
            $this->actions['code'] = $request->code;
        } else {
            // actions에서 계시판 코드 지정
            if(isset($this->actions['code'])) {
                $this->code = $this->actions['code'];
            }
        }

        // 계시판 코드가 없으면 에러 페이지 출력
        if(!$this->code) {
            // return view("jiny-site-board::error",[
            //     'message' => "지정한 계시판이 존재하지 않습니다."
            // ]);

            // 계시판 데시보드 출력
            return view("jiny-site-board::site.board.dashboard");
        }


        // DB에서 계시판 정보 읽기
        $board = $this->boardInfo($this->code);
        if($board) {
            // 계시판마다 디자인을 변경할 수 있습니다.

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

        } else {
            // 계시판이 존재하지 않습니다.
            return view("jiny-site-board::error",[
                'message' => "지정한 계시판이 존재하지 않습니다."
            ]);
        }


        // view에게 전달할 메개변수를 설정합니다.
        $this->params['board'] = $board;
        $this->params['code'] = $this->code;

        // 계시판조회
        $query = DB::table("site_board_".$board->code);

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
        //dd($this->params);

        return parent::index($request);
    }

    /**
     * auto 라우트
     * 계시물 조회
     */
    public function table($board)
    {
        // 계시물 조회
        $rows = DB::table("site_board_".$board->code)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view($this->actions['view']['layout'],[
            'code' => $board->code,
            'board' => $board,
            'rows' => $rows
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
