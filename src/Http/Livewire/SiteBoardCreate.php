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

class SiteBoardCreate extends Component
{
    use WithFileUploads;
    use WithPagination;
    use \Jiny\WireTable\Http\Trait\Hook;
    use \Jiny\WireTable\Http\Trait\Permit;
    use \Jiny\WireTable\Http\Trait\CheckDelete;
    use \Jiny\WireTable\Http\Trait\DataFetch;
    use \Jiny\WireTable\Http\Trait\Upload;

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

        // 인자로 code가 없는 경우, uri를 분석
        if(!$this->code) {
            $current_url = Request::url();
            $urls = array_reverse(explode('/',$current_url));

            // 계시판 코드 추출
            if(isset($urls[1]) && is_string($urls[1])) {
                $code = $urls[1];
                $this->code = $urls[1];
            }
        } else {
            $code = $this->code;
        }

        // 계시판 Slug로 코드 변경
        $code = $this->code;
        $board = DB::table('site_board')->where('slug',$code)->first();
        if($board) {
            $this->actions['table'] = "site_board_".$board->code; // 테이블명을 변경함
        } else {
            $this->actions['table'] = "site_board_".$code; // 테이블명을 변경함
            $board = DB::table('site_board')->where('code',$code)->first();
        }

        foreach($board as $key => $value) {
            $this->board[$key] = $value;
        }

    }


    public function render()
    {
        ## 모드별로 동작화면을 달리 처리합니다.
        if($this->mode == "creating") {
            return view("jiny-site-board::site.board_wire.creating",[
                'message' => "계시물을 생성하고 있는 중입니다. 잠시만 기다려 주세요"
            ]);
        }

        $this->setViewCreate();
        $this->create();
        return view($this->viewCreateFile);
    }


    public function setViewCreate()
    {
        $this->setViewForm();

        if(!$this->viewCreateFile) {
            if(isset($this->actions['view']['create'])) {
                $this->viewCreateFile = $this->actions['view']['create'];
            }
            $this->viewCreateFile = "jiny-site-board"."::site.board_wire.create";
        }
    }

    public function setViewForm()
    {
        if(!$this->viewFormFile) {
            if(isset($this->actions['view']['form'])) {
                $this->viewFormFile = $this->actions['view']['form'];
            }
            $this->viewFormFile = "jiny-site-board"."::site.board_wire.form";
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


    public $confirm = false;
    public $forms=[];
    //public $old=[];
    public $forms_old=[];


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


    public function create($value=null)
    {
        $this->message = null;

        // 신규 삽입을 위한 데이터 초기화
        $this->formInitField();

        // 삽입 권한이 있는지 확인
        if($this->permit['create']) {
            unset($this->actions['id']);

            // 후킹:: 컨트롤러 메서드 호출
            if ($controller = $this->isHook("hookCreating")) {
                $form = $this->controller->hookCreating($this, $value);
                if($form) {
                    $this->forms = $form;
                }
            }

            // 폼입력 팝업창 활성화
            //$this->popupFormOpen();
            $this->created = true;
            $this->mode = "create";

        } else {
            // 권한 없음 팝업을 활성화 합니다.
            //dd("create 권환이 없습니다.");
            $this->popupPermitOpen();
        }
    }

    public $last_id;
    public function store()
    {
        $this->message = null;

        if($this->permit['create']) {

            // 1.유효성 검사
            if (isset($this->actions['validate'])) {
                $validator = Validator::make($this->forms, $this->actions['validate'])->validate();
            }

            // 2. 시간정보 생성
            $this->forms['created_at'] = date("Y-m-d H:i:s");
            $this->forms['updated_at'] = date("Y-m-d H:i:s");

            // 3. 파일 업로드 체크 Trait
            $this->fileUpload();


            // 4. 컨트롤러 메서드 호출
            // 신규 데이터 DB 삽입전에 호출되는 Hook
            if ($controller = $this->isHook("hookStoring")) {
                $_form = $this->controller->hookStoring($this, $this->forms);
                if(is_array($_form)) {
                    $form = $_form;
                } else {
                    // 훅 처리시 오류가 발생됨.
                    // $this->message = $_form;
                    return null;
                }
            } else {
                $form = $this->forms;
            }

            // 5. 데이터 삽입
            if($form) {
                //dd($form);
                $id = DB::table($this->actions['table'])->insertGetId($form);
                $form['id'] = $id;
                $this->last_id = $id;

                // 6. 컨트롤러 메서드 호출
                if ($controller = $this->isHook("hookStored")) {
                    $controller->hookStored($this, $form);
                }
            }

            // 입력데이터 초기화
            $this->cancel();

            // 팝업창 닫기
            //$this->popupFormClose();
            $this->created = false;
            $this->mode = null;

            // 계시물 추가 갯수를 증가합니다.
            DB::table('site_board')
                ->where('code',$this->board['code'] )
                ->increment('post');

            //
            $this->dispatch('board-created');

        } else {
            $this->popupPermitOpen();
        }
    }

    public function createCancel()
    {
        $this->mode = "creating";
        $this->dispatch('board-created');
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
        //dd($method);
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
