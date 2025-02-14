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
 * 계시판 글을 삭제합니다.
 */
use Jiny\Site\Http\Controllers\SiteController;
class SiteBoardDelete extends SiteController
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




    public function confirm(Request $request)
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

        $row = DB::table($this->actions['table']['name'])->where('id',$id)->first();

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
            $this->actions['table']['name'] .= $board->code; // 테이블명을 변경함
        } else {
            $this->actions['table']['name'] .= $code; // 테이블명을 변경함
        }

        $id = $request->id;

        // 게시물 정보 가져오기
        $post = DB::table("site_board_".$board->code)->where('id', $id)->first();

        // 사용자 권한 확인
        if (Auth::user()->email === $post->email || isAdmin()) {
            // 이미지 파일 및 폴더 삭제
            if ($post->image) {
                $uploadPath = public_path('uploads/board/' . $post->id);
                if (is_dir($uploadPath)) {
                    $this->deleteDirectory($uploadPath);
                }
            }

            $forms = $request->forms;
            DB::table($this->actions['table']['name'])
                ->where('id', $id)
                ->delete();

            return response()->json([
                'forms' => $forms,
                'success' => true,
                'message' => '게시물, 관련 이미지 및 폴더가 성공적으로 삭제되었습니다.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => '삭제 권한이 없습니다.',
            ], 403);
        }
    }

    // 폴더와 그 내용을 재귀적으로 삭제하는 헬퍼 메서드
    private function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }
}
