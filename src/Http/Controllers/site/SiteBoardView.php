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
 * 계시판 글보기를 처리합니다.
 */
use Jiny\Site\Http\Controllers\SiteController;
class SiteBoardView extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_board_";

        $this->actions['view']['form'] = "jiny-site-board::site.board_code.form";

        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['layout'] = "jiny-site-board::site.board_code.view";

        $this->actions['view']['confirm'] = "jiny-site-board::site.board_code.confirm";
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
            $this->actions['table'] .= $board->code; // 테이블명을 변경함
        } else {
            $this->actions['table'] .= $code; // 테이블명을 변경함
            $board = DB::table($tablename)->where('code',$code)->first();
        }

        return $board;
    }

    public function index(Request $request)
    {
        // 계시판 코드
        $code = $request->code;
        if($code) {
            $this->actions['code'] = $code;
        }

        if(!$code) {
            return view("jiny-site-board::error",[
                'message' => "지정한 계시판이 존재하지 않습니다."
            ]);
        }

        // DB에서 계시판 정보 읽기
        $board = $this->boardInfo($code);

        // 글번호 id
        $id = $request->id;



        ## actions 보드 정보들 추가합니다.
        $this->actions['board'] = []; //초기화
        foreach($board as $key => $value) {
            $this->actions['board'][$key] = $value;
        }

        // 계시판 지정 레이아웃
        if($board->view_detail) {
            $this->actions['view']['layout'] = $board->view_detail;
        }

        if($board->view_form) {
            $this->actions['view']['form'] = $board->view_form;
        }

        // view에게 전달할 메개변수를 설정합니다.
        $this->params['board'] = $board;
        $this->params['code'] = $code;
        $this->params['_id'] = $id;

        return parent::index($request);

        // return view($this->actions['view']['layout'],[
        //     'actions' => $this->actions,
        //     'board' => $board,
        //     'code' => $code,
        //     '_id' => $id
        // ]);

    }

    public function edit(Request $request)
    {
        $code = $request->code;
        $this->actions['code'] = $code;

        $id = $request->id;

        // Slug로 코드 변경
        $board = DB::table('site_board')->where('slug',$code)->first();
        if($board) {
            $this->actions['table'] .= $board->code; // 테이블명을 변경함
        } else {
            $this->actions['table'] .= $code; // 테이블명을 변경함
            $board = DB::table('site_board')->where('code',$code)->first();
        }

        //dd($board);

        ## actions 보드 정보들 추가합니다.
        $this->actions['board'] = []; //초기화
        foreach($board as $key => $value) {
            $this->actions['board'][$key] = $value;
        }

        // 계시판 지정 레이아웃
        if($board->view_edit) {
            $this->actions['view']['detail'] = $board->view_edit;
        }

        if($board->view_form) {
            $this->actions['view']['form'] = $board->view_form;
        }




        $row = DB::table($this->actions['table'])->where('id',$id)->first();

        return view($this->actions['view']['detail'],[
            'actions' => $this->actions,
            'code' => $code,
            'row' => $row
        ]);
    }

    public function update(Request $request)
    {
        $code = $request->code;

        // Slug로 코드 변경
        $board = DB::table('site_board')->where('slug',$code)->first();
        if($board) {
            $this->actions['table'] .= $board->code; // 테이블명을 변경함
        } else {
            $this->actions['table'] .= $code; // 테이블명을 변경함
        }
        //$this->actions['table'] .= $code; // 테이블명을 변경함

        $id = $request->id;

        $forms = $request->forms;
        // 2. 시간정보 생성
        $forms['updated_at'] = date("Y-m-d H:i:s");

        DB::table($this->actions['table'])
            ->where('id',$id)
            ->update($forms);

        return response()->json([
            'forms' => $forms,
            'message' => 'Form submitted successfully!',
        ]);
    }


    public function confirm(Request $request)
    {
        $code = $request->code;
        $this->actions['code'] = $code;

        $id = $request->id;


        // Slug로 코드 변경
        $board = DB::table('site_board')->where('slug',$code)->first();
        if($board) {
            $this->actions['table'] .= $board->code; // 테이블명을 변경함
        } else {
            $this->actions['table'] .= $code; // 테이블명을 변경함
            $board = DB::table('site_board')->where('code',$code)->first();
        }

        //dd($board);

        ## actions 보드 정보들 추가합니다.
        $this->actions['board'] = []; //초기화
        foreach($board as $key => $value) {
            $this->actions['board'][$key] = $value;
        }

        $row = DB::table($this->actions['table'])->where('id',$id)->first();

        return view($this->actions['view']['confirm'],[
            'actions' => $this->actions,
            'code' => $code,
            'row' => $row
        ]);
    }

    public function destroy(Request $request)
    {
        $code = $request->code;

        // Slug로 코드 변경
        $board = DB::table('site_board')->where('slug',$code)->first();
        if($board) {
            $this->actions['table'] .= $board->code; // 테이블명을 변경함
        } else {
            $this->actions['table'] .= $code; // 테이블명을 변경함
        }
        //$this->actions['table'] .= $code; // 테이블명을 변경함

        $id = $request->id;

        $forms = $request->forms;
        DB::table($this->actions['table'])
            ->where('id',$id)
            ->delete();

        return response()->json([
            'forms' => $forms,
            'message' => 'Form submitted successfully!',
        ]);
    }



}
