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
 * 블로그 글을 수정합니다.
 */
use Jiny\Site\Http\Controllers\SiteController;
class SiteBlogEdit extends SiteController
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


    public function edit(Request $request)
    {
        $id = $request->id;

        $row = DB::table("site_blogs")
            ->where('id',$id)
            ->first();
        if(($row && $row->email == Auth::user()->email) || isAdmin()) {
            $viewLayout = "jiny-site-board::site.blogs.edit.layout";
            $this->actions['view']['form'] = "jiny-site-board::site.blogs.edit.form";

            return view($viewLayout,[
                'actions' => $this->actions,
                'row' => $row
            ]);
        }

        $viewFile = "jiny-site-board::site.blogs.edit.error";
        return view($viewFile,[
        ]);

    }

    /**
     * 블로그 글 수정
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $forms = $request->forms;

        // 2. 시간정보 생성
        $forms['updated_at'] = date("Y-m-d H:i:s");

        // 이미지 업로드 처리
        if ($request->hasFile('forms.image')) {
            $image = $request->file('forms.image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path("images/blogs/{$id}");

            // 디렉토리가 없으면 생성
            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0755, true);
            }

            $image->move($imagePath, $imageName);

            // 이미지 경로를 $forms 배열에 추가
            $forms['image'] = "/images/blogs/{$id}/" . $imageName;
        }

        DB::table("site_blogs")
            ->where('id',$id)
            ->update($forms);

        return response()->json([
            'forms' => $forms,
            'message' => 'Form submitted successfully!',
        ]);
    }


}
