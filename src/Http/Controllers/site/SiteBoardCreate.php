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
 * 계시물을 작성합니다.
 */
use Jiny\Site\Http\Controllers\SiteController;
class SiteBoardCreate extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_board_";



        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['create'] = "jiny-site-board::site.board.create.layout";

        $this->actions['view']['form'] = "jiny-site-board::site.board.create.form";

    }

    public function index(Request $request)
    {
        $code = $request->code;
        $this->actions['code'] = $code;

        // Slug로 코드 변경
        $board = DB::table('site_board')->where('slug',$code)->first();
        if($board) {
            $this->actions['table'] .= $board->code; // 테이블명을 변경함
        } else {
            $this->actions['table'] .= $code; // 테이블명을 변경함
            $board = DB::table('site_board')->where('code',$code)->first();
        }

        ## actions 보드 정보들 추가합니다.
        $this->actions['board'] = []; //초기화
        foreach($board as $key => $value) {
            $this->actions['board'][$key] = $value;
        }

        // 계시판 지정 레이아웃
        if($board->view_create) {
            $this->actions['view']['create'] = $board->view_create;
        }

        if($board->view_form) {
            $this->actions['view']['form'] = $board->view_form;
        }

        // view에게 전달할 메개변수를 설정합니다.
        // $this->params['board'] = $board;
        // $this->params['code'] = $code;

        return view($this->actions['view']['create'],[
            'actions' => $this->actions,
            'code' => $code,
            'board' => $board
        ]);
    }

    ## 신규 데이터 DB 삽입전에 호출됩니다.
    public function hookStoring($wire,$form)
    {
        return $form; // 사전 처리한 데이터를 반환합니다.
    }

    ## 라우트 post
    ## ajax요청으로 들어온 내용을 저장합니다.
    public function store(Request $request)
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

        $request->validate([
            'forms.title' => 'required|string|max:255',
            'forms.content' => 'required|string',
            'forms.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 이미지 필드를 nullable로 변경
        ]);

        $forms = $request->forms;

        // 2. 시간정보 생성
        $forms['created_at'] = date("Y-m-d H:i:s");
        $forms['updated_at'] = date("Y-m-d H:i:s");

        // 로그인한 사용자 정보 가져오기
        $user = Auth::user();
        if ($user) {
            $forms['name'] = $user->name;
            $forms['email'] = $user->email;
        } else {
            // 로그인하지 않은 경우 처리
            $forms['name'] = null;
            $forms['email'] = null;
        }

        // 데이터를 삽입합니다.
        $id = DB::table($this->actions['table'])->insertGetId($forms);

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

                // 이미지 경로를 데이터베이스에 저장
                DB::table($this->actions['table'])
                    ->where('id', $id)
                    ->update(['image' => "images/board/{$code}/{$id}/" . $imageName]);

        }

        return response()->json([
            'forms' => $forms,
            'success' => true,
            'message' => '게시물이 성공적으로 등록되었습니다!',
        ]);
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
