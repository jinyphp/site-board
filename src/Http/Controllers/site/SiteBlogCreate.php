<?php
namespace Jiny\Site\Board\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * 블로글를 작성합니다.
 */
use Jiny\Site\Http\Controllers\SiteController;
class SiteBlogCreate extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table']['name'] = "site_blogs";

        // 레이아웃을 커스텀 변경합니다.
        $this->actions['view']['create'] = "jiny-site-board::site.blogs.create.layout";

        $this->actions['view']['form'] = "jiny-site-board::site.blogs.create.form";

    }

    public function index(Request $request)
    {
        return view($this->actions['view']['create'],[
            'actions' => $this->actions        ]);
    }


    ## 라우트 post
    ## ajax요청으로 들어온 내용을 저장합니다.
    public function store(Request $request)
    {
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
        $id = DB::table("site_blogs")->insertGetId($forms);

        // $src = public_path("images/blogs/_");
        // if (is_dir($src)) {
        //     rename($src, public_path("images/blogs/{$id}"));
        // }


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

                // 이미지 경로를 데이터베이스에 저장
                DB::table("site_blogs")
                    ->where('id', $id)
                    ->update(['image' => "/images/blogs/{$id}/" . $imageName]);

        }



        return response()->json([
            'forms' => $forms,
            'success' => true,
            'message' => 'post가 성공적으로 등록되었습니다!',
        ]);
    }


}
