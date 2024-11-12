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
 * 블로그 글을 삭제합니다.
 */
use Jiny\Site\Http\Controllers\SiteController;
class SiteBlogDelete extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_blogs";

        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['layout'] = "jiny-site-board::site.blogs.view.layout";

        $this->actions['view']['confirm'] = "jiny-site-board::site.board_code.confirm";
    }


    public function confirm(Request $request)
    {
        $id = $request->id;
        $row = DB::table("site_blogs")
            ->where('id',$id)
            ->first();

        return view($this->actions['view']['confirm'],[
            'actions' => $this->actions,
            'row' => $row
        ]);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        // 게시물 정보 가져오기
        $post = DB::table("site_blogs")
            ->where('id', $id)
            ->first();

        // 사용자 권한 확인
        if (Auth::user()->email === $post->email || isAdmin()) {
            // 이미지 파일 및 폴더 삭제
            if ($post->image) {
                $uploadPath = public_path('images/blogs/' . $post->id);
                if (is_dir($uploadPath)) {
                    $this->deleteDirectory($uploadPath);
                }
            }

            $forms = $request->forms;
            DB::table("site_blogs")
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
