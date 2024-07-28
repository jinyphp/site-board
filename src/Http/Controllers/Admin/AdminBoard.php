<?php
namespace Jiny\Site\Board\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminBoard extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_board";

        $this->actions['view']['list'] = "jiny-site-board::admin.board.list";
        $this->actions['view']['form'] = "jiny-site-board::admin.board.form";

        $this->actions['title'] = "계시판";
        $this->actions['subtitle'] = "복수의 계시판을 관리합니다.";
    }


    ## 신규 데이터 DB 삽입전에 호출됩니다.
    public function hookStoring($wire,$form)
    {
        // 타이틀명 hash코드를 기반으로
        // 신규 테이블을 생성합니다.
        if(isset($form['title']) && $form['title']) {
            $code = md5($form['title'].date("Y-m-d_H:i:s"));
            $code = substr($code,0,7);
            $form['code'] = $code;

            // 테이블을 생성합니다.
            $this->schemaCreate("site_board_".$code);
        }

        return $form; // 사전 처리한 데이터를 반환합니다.
    }



    private function schemaCreate($schema)
    {
        Schema::create($schema, function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // 분류코드
            $table->string('code')->nullable();
            $table->string('slug')->nullable();

            // 작성자 정보
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable(); // 비회원일 경우 비밀번호 필요

            // post 정보
            $table->string('categories')->nullable();
            $table->string('keyword')->nullable();
            $table->string('tags')->nullable();

            // 제목내용
            $table->string('title')->nullable();
            $table->text('content')->nullable();

            // post 대표 이미지
            $table->string('image')->nullable();


            $table->unsignedBigInteger('click')->default(0); // 조회수
            $table->unsignedBigInteger('like')->default(0); //좋아요
            $table->unsignedBigInteger('rank')->default(0); //랭크
        });
    }




    ## 데이터를 수정하기전에 호출됩니다.
    public function hookUpdating($wire, $form, $old)
    {
        // 코드는 변경이 불가능합니다.
        // 수정이 안되도록 항목을 삭제
        unset($form['code']);

        return $form;
    }

    ## delete 동직이 실행된후 호출됩니다.
    public function hookDeleted($wire, $row)
    {
        Schema::dropIfExists("site_board_".$row['code']);
        return $row;
    }

    ## 선택해서 삭제하는 경우 호출됩니다.
    public function hookCheckDeleting($selected)
    {
        $rows = DB::table($this->actions['table'])->whereIn('id',$selected)->get();
        //dd($rows);
        foreach($rows as $item) {
            Schema::dropIfExists("site_board_".$item->code);
        }

    }
}
