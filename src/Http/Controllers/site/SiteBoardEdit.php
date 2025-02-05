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
 * 계시판 글을 수정합니다.
 */
use Jiny\Site\Http\Controllers\SiteController;
class SiteBoardEdit extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table']['name'] = "site_board_";



        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['layout'] = "jiny-site-board::site.board.view.layout";

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
            $this->actions['table']['name'] .= $board->code; // 테이블명을 변경함
        } else {
            $this->actions['table']['name'] .= $code; // 테이블명을 변경함
            $board = DB::table($tablename)->where('code',$code)->first();
        }

        return $board;
    }



    public function edit(Request $request)
    {
        $code = $request->code;
        $this->actions['code'] = $code;

        $id = $request->id;

        // Slug로 코드 변경
        $board = DB::table('site_board')->where('slug',$code)->first();
        if($board) {
            $this->actions['table']['name'] .= $board->code; // 테이블명을 변경함
        } else {
            $this->actions['table']['name'] .= $code; // 테이블명을 변경함
            $board = DB::table('site_board')->where('code',$code)->first();
        }

        //dd($board);

        ## actions 보드 정보들 추가합니다.
        $this->actions['board'] = []; //초기화
        foreach($board as $key => $value) {
            $this->actions['board'][$key] = $value;
        }

        // 계시판 지정 레이아웃
        // if($board->view_edit) {
        //     $this->actions['view']['detail'] = $board->view_edit;
        // }

        // if($board->view_form) {
        //     $this->actions['view']['form'] = $board->view_form;
        // }


        $row = DB::table("site_board_".$board->code)->where('id',$id)->first();
        if(($row && $row->email == Auth::user()->email) || isAdmin()) {
            $viewLayout = "jiny-site-board::site.board.edit.layout";
            $this->actions['view']['form'] = "jiny-site-board::site.board.edit.form";

            return view($viewLayout,[
                'actions' => $this->actions,
                'code' => $code,
                'board' => $board,
                'row' => $row
            ]);
        }

        return view("jiny-site-board::site.board.edit.error",[
            'actions' => $this->actions,
            'code' => $code,
            'board' => $board
        ]);

    }

    public function update(Request $request)
    {
        $code = $request->code;

        // Slug로 코드 변경
        $board = DB::table('site_board')->where('slug',$code)->first();
        if($board) {
            $this->actions['table']['name'] .= $board->code; // 테이블명을 변경함
        } else {
            $this->actions['table']['name'] .= $code; // 테이블명을 변경함
        }
        //$this->actions['table']['name'] .= $code; // 테이블명을 변경함

        $id = $request->id;

        $forms = $request->forms;
        // 2. 시간정보 생성
        $forms['updated_at'] = date("Y-m-d H:i:s");

        // 이미지 업로드 처리
        if ($request->hasFile('forms.image')) {
            $image = $request->file('forms.image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path("images/board/{$code}/{$id}");

            // 디렉토리가 없으면 생성
            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0755, true);
            }

            $image->move($imagePath, $imageName);

            // 이미지 경로를 $forms 배열에 추가
            $forms['image'] = "images/board/{$code}/{$id}/" . $imageName;
        }

        DB::table("site_board_".$board->code)
            ->where('id',$id)
            ->update($forms);

        return response()->json([
            'forms' => $forms,
            'message' => 'Form submitted successfully!',
        ]);
    }





}
