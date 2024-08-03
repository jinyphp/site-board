<?php
namespace Jiny\Site\Board\Http\Livewire;

use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\Route;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;

use Livewire\WithFileUploads;

class SitePostCreate extends Component
{
    use WithFileUploads;
    use \Jiny\WireTable\Http\Trait\Upload;

    use WithPagination;
    use \Jiny\WireTable\Http\Trait\Hook;
    use \Jiny\WireTable\Http\Trait\Permit;
    use \Jiny\WireTable\Http\Trait\CheckDelete;
    use \Jiny\WireTable\Http\Trait\DataFetch;


    public $admin_prefix;
    public $actions;
    public $paging = 10;

    ## 선택 데이터
    public $_id;
    public $data=[];
    public $table_columns=[];


    ## 렌더링 동작모드
    public $mode;
    public $message;

    ## 화면뷰
    public $viewTableFile;  // 테이블 레이아웃
    public $viewListFile;   // 테이블 표
    public $viewCreateFile;
    public $viewViewFile;
    public $viewEditFile;
    public $viewFormFile;
    public $viewDeleteFile;

    ## 계시판 데이터
    public $code;
    public $board = [];

    public $confirm = false;
    public $forms=[];
    public $forms_old=[];
    public $last_id;

    public function mount()
    {
        // admin 접속경로 prefix
        if(function_exists('admin_prefix')) {
            $this->admin_prefix = admin_prefix();
        } else {
            $this->admin_prefix = "admin";
        }

        // 권환체크
        $this->permitCheck();

        $this->create(); //생성동작
        $this->setViewCreate();

    }

    ## 생성폼 준비작업
    public function create($value=null)
    {

        // 후킹:: 컨트롤러 메서드 호출
        if ($controller = $this->isHook("hookCreating")) {
            $form = $this->controller->hookCreating($this, $value);
            if($form) {
                $this->forms = $form;
            }
        }

        // 폼입력 팝업창 활성화
        $this->created = true;
        $this->mode = "create";
    }


    public function render()
    {
        // 삽입 권한이 있는지 확인
        if($this->permit['create']) {

            ## 모드별로 동작화면을 달리 처리합니다.
            if($this->mode == "creating") {
                return view("jiny-site-board::site.board_wire.creating",[
                    'message' => "계시물을 생성하고 있는 중입니다. 잠시만 기다려 주세요"
                ]);
            }

            return view($this->viewCreateFile);

        } else {
            // 권한 없음 팝업을 활성화 합니다.
            $this->popupPermitOpen();
        }
    }


    public function setViewCreate()
    {
        $this->setViewForm();

        if(!$this->viewCreateFile) {
            if(isset($this->actions['view']['create'])) {
                $this->viewCreateFile = $this->actions['view']['create'];
            }
            $this->viewCreateFile = "jiny-site-board"."::site.post_create.create";
        }
    }

    public function setViewForm()
    {
        if(!$this->viewFormFile) {
            if(isset($this->actions['view']['form'])) {
                $this->viewFormFile = $this->actions['view']['form'];
            }
            $this->viewFormFile = "jiny-site-board"."::site.post_create.form";
        }
    }



    private function toData($rows)
    {
        $this->data = [];
        foreach($rows as $i => $item) {
            $id = $item->id;
            foreach($item as $key => $value) {
                $this->data[$id][$key] = $value;
            }
        }

        return $this;
    }

    public function getRow($id=null)
    {
        if($id) {
            return $this->data[$id];
        }

        return $this->data;
    }

    private function formInitField()
    {
        $this->forms = [];
        return $this;
    }

    public function back()
    {
        $this->mode = null;
    }

    /**
     * 입력 데이터 취소 및 초기화
     */
    public function cancel()
    {
        $this->forms = [];
        //$this->forms_old = [];
        $this->popupForm = false;
        $this->popupDelete = false;
        $this->confirm = false;
    }


    public function store()
    {
        if($this->permit['create']) {

            // 1.유효성 검사
            if (isset($this->actions['validate'])) {
                $validator = Validator::make($this->forms, $this->actions['validate'])
                    ->validate();
            }

            // 2. 시간정보 생성
            $this->forms['created_at'] = date("Y-m-d H:i:s");
            $this->forms['updated_at'] = date("Y-m-d H:i:s");


            // 3. 파일 업로드 체크 Trait
            $this->fileUpload();

            ## 4. 신규 데이터 DB 삽입전에 호출되는 Hook
            ## 컨트롤러 메서드 호출
            if ($controller = $this->isHook("hookStoring")) {
                $_form = $this->controller->hookStoring($this, $this->forms);
                if(is_array($_form)) {
                    $forms = $_form;
                } else {
                    // 훅 처리시 오류가 발생됨.
                    // $this->message = $_form;
                    return null;
                }
            } else {
                $forms = $this->forms;
            }

            // 5. 데이터 삽입
            if($forms) {
                $id = DB::table($this->actions['table'])->insertGetId($forms);
                $forms['id'] = $id;
                $this->last_id = $id;

                // 6. 컨트롤러 메서드 호출
                if ($controller = $this->isHook("hookStored")) {
                    $controller->hookStored($this, $forms);
                }
            }

            $this->message = "포스트가 작성되었습니다.";

            // 입력데이터 초기화
            // $this->cancel();

            // 팝업창 닫기
            //$this->popupFormClose();
            $this->created = false;
            $this->mode = null;

            $this->dispatch('post-created');

        } else {
            $this->popupPermitOpen();
        }
    }

    /**
     * 생성폼을 취소합니다.
     */
    public function createCancel()
    {
        $this->mode = "creating";
        $this->dispatch('post-created'); // history.back 호출
    }


    // Object를 Array로 변경합니다.
    private function setForm($row)
    {
        foreach ($row as $key => $value) {
            $this->forms[$key] = $value;
            // 데이터 변경여부를 체크하기 위해서 old 값 지정
            $this->forms_old[$key] = $value;
        }
    }

    public function resetForm($name=null)
    {
        if($name) {
            $this->forms[$name] = null;
        }
    }

    public function getOld($key=null)
    {
        if ($key) {
            return $this->forms_old[$key];
        }
        return $this->forms_old;
    }



    /**
     * 컨트롤러에서 선안한 메소드를 호출
     */
    public function hook($method, ...$args) { $this->call($method, $args); }
    public function call($method, ...$args)
    {
        if($controller = $this->isHook($method)) {
            if(method_exists($controller, $method)) {
                return $controller->$method($this, $args[0]);
            }
        }
    }


    public function columnHidden($col_id)
    {
        $row = DB::table('table_columns')->where('id',$col_id)->first();
        if($row->display) {
            DB::table('table_columns')->where('id',$col_id)->update(['display'=>""]);
        } else {
            DB::table('table_columns')->where('id',$col_id)->update(['display'=>"true"]);
        }
    }


    //
    public function request($key=null)
    {
        if($key) {
            if(isset($this->actions['request'][$key])) {
                return $this->actions['request'][$key];
            }

            return null;
        }

        return $this->actions['request'];
    }


}
