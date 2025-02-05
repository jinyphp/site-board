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

class SitePostView
 extends Component
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

    public $countable; // 카운트 중복 방지

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


        $current_url = Request::url();
        $urls = array_reverse(explode('/',$current_url));

        // uri에서 계시물 번호 추출
        if(isset($urls[0]) && is_numeric($urls[0])) {
            $id = $urls[0];
            $this->_id = $urls[0];
        }

        // 계시판 코드 추출
        /*
        if(isset($urls[1]) && is_string($urls[1])) {
            $code = $urls[1];
            $this->code = $urls[1];
        }
        */

        // 계시판 Slug로 코드 변경
        /*
        $code = $this->code;
        $board = DB::table('site_board')->where('slug',$code)->first();
        if($board) {
            $this->actions['table']['name'] = "site_board_".$board->code; // 테이블명을 변경함
        } else {
            $this->actions['table']['name'] = "site_board_".$code; // 테이블명을 변경함
            $board = DB::table('site_board')->where('code',$code)->first();
        }

        foreach($board as $key => $value) {
            $this->board[$key] = $value;
        }
        */

    }


    public function render()
    {
        ## 모드별로 동작화면을 달리 처리합니다.
        if($this->mode == "edit") {
            $this->setViewEdit();
            return view($this->viewEditFile);
        } else
        if($this->mode == "delete") {
            $this->setViewDelete();
            return view($this->viewDeleteFile);
        }

        // 계시물 조회수를 증가합니다.
        if($this->countable != $this->_id) {
            DB::table($this->actions['table']['name'])
                ->where('id',$this->_id)
                ->increment('click');

            $this->countable = $this->_id;
            // note: 계시물을 서로 엇갈려서 클릭하면, 갯수가 증가됨.
        }

        $this->setViewView();
        if($this->view($this->_id)) {
            return view($this->viewViewFile);
        }

        return view("jiny-site-board::site.board_wire.error",[
            'message' => "존재하지 않는 계시물 입니다."
        ]);
    }


    public function setViewView()
    {
        if(!$this->viewViewFile) {
            if(isset($this->actions['view']['view'])) {
                $this->viewViewFile = $this->actions['view']['view'];
            }
            $this->viewViewFile = "jiny-site-board"."::site.post_view.view";
        }
    }

    public function setViewEdit()
    {
        $this->setViewForm();
        if(!$this->viewEditFile) {
            if(isset($this->actions['view']['edit'])) {
                $this->viewEditFile = $this->actions['view']['edit'];
            }
            $this->viewEditFile = "jiny-site-board"."::site.post_view.edit";
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

    public function setViewDelete()
    {
        if(!$this->viewDeleteFile) {
            if(isset($this->actions['view']['delete'])) {
                $this->viewDeleteFile = $this->actions['view']['delete'];
            }
            $this->viewDeleteFile = "jiny-site-board"."::site.post_view.delete";
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
    public $forms_old=[];




    private function formInitField()
    {
        $this->forms = [];
        return $this;
    }

    public function back()
    {
        $this->mode = null;

        // 뒤로가기 javascript 이벤트 호출
        $this->dispatch('post-deleted');
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




    ## 계시물 보기
    public function view($id)
    {
        $this->mode = "view";

        $row = DB::table($this->actions['table']['name'])
            ->find($id);

        if($row) {
            $this->setForm($row);
            return true;
        }

        return false;
    }


    ## 계시물 수정
    public function edit($id)
    {

        // 수정기능이 비활성화 되어 있는지 확인
        /*
        if(!isset($this->actions['edit']['enable'])) {
            return false;
        } else {
            if(!$this->actions['edit']['enable']) {
                return false;
            }
        }
        */

        $this->message = null;

        if($this->permit['update']) {
            //$this->popupFormOpen();
            $this->mode = "edit";

            if($id) {
                $this->actions['id'] = $id;
            }

            // 1. 컨트롤러 메서드 호출
            if ($controller = $this->isHook("hookEditing")) {
                $this->forms = $this->controller->hookEditing($this, $this->forms);
            }

            if (isset($this->actions['id'])) {
                $row = DB::table($this->actions['table']['name'])->find($this->actions['id']);
                $this->setForm($row);
            }

            // 2. 수정 데이터를 읽어온후, 값을 처리해야 되는 경우
            if ($controller = $this->isHook("hookEdited")) {
                $this->forms = $this->controller->hookEdited($this, $this->forms, $this->forms);
            }

        } else {
            $this->popupPermitOpen();
        }
    }

    public function editCancel($id)
    {
        // 수정폼을 취소하는 경우, 다시 보기 모드로 이동
        $this->view($id);
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

    public function update()
    {
        if($this->permit['update']) {
            // step1. 수정전, 원본 데이터 읽기
            $origin = DB::table($this->actions['table']['name'])->find($this->actions['id']);
            foreach ($origin as $key => $value) {
                $this->forms_old[$key] = $value;
            }

            // step2. 유효성 검사
            if (isset($this->actions['validate'])) {
                $validator = Validator::make($this->forms, $this->actions['validate'])->validate();
            }

            // step3. 컨트롤러 메서드 호출
            if ($controller = $this->isHook("hookUpdating")) {
                $_form = $this->controller->hookUpdating($this, $this->forms, $this->forms_old);
                if(is_array($_form)) {
                    $this->forms = $_form;
                } else {
                    // Hook에서 오류가 반환 되었습니다.
                    return null;
                }
            }


            // step4. 파일 업로드 체크 Trait
            $this->fileUpload();


            // uploadfile 필드 조회
            /*
            $fields = DB::table('uploadfile')->where('table', $this->actions['table']['name'])->get();
            foreach($fields as $item) {
                $key = $item->field; // 업로드 필드명
                if($origin->$key != $this->forms[$key]) {
                    ## 이미지를 수정하는 경우, 기존 이미지는 삭제합니다.
                    Storage::delete($origin->$key);
                }
            }
            */


            // step5. 데이터 수정
            if($this->forms) {
                //dd($this->forms);
                $this->forms['updated_at'] = date("Y-m-d H:i:s");

                DB::table($this->actions['table']['name'])
                    ->where('id', $this->actions['id'])
                    ->update($this->forms);
            }

            // step6. 컨트롤러 메서드 호출
            if ($controller = $this->isHook("hookUpdated")) {
                $this->forms = $this->controller->hookUpdated($this, $this->forms, $this->forms_old);
            }

            // 입력데이터 초기화
            //$this->cancel();

            // 팝업창 닫기
            // $this->popupFormClose();
            // edit->view 모드로 변경
            $this->mode = "view";

        } else {

            $this->popupPermitOpen();
        }
    }

    /** ----- ----- ----- ----- -----
     *  데이터 삭제
     *  삭제는 2단계로 동작합니다. 삭제 버튼을 클릭하면, 실제 동작 버튼이 활성화 됩니다.
     */
    ## 삭제 화면으로 전환합니다.
    public function delete($id=null)
    {
        if($this->permit['delete']) {
            //$this->popupDelete = true;
            $this->mode = "delete";
        }
    }

    ## 삭제 취소
    public function deleteCancel()
    {
        //$this->popupDelete = false;
        // 다시 보기 모드로 이동합니다.
        $this->mode = "view";
    }

    public function deleteConfirm()
    {
        //$this->popupDelete = false;
        $this->mode = null;

        if($this->permit['delete']) {
            $row = DB::table($this->actions['table']['name'])->find($this->actions['id']);
            $form = [];
            foreach($row as $key => $value) {
                $form[$key] = $value;
            }

            // 컨트롤러 메서드 호출
            if ($controller = $this->isHook("hookDeleting")) {
                $row = $this->controller->hookDeleting($this, $form);
            }

            // uploadfile 필드 조회
            /*
            $fields = DB::table('uploadfile')->where('table', $this->actions['table']['name'])->get();
            foreach($fields as $item) {
                $key = $item->field; // 업로드 필드명
                if (isset($row->$key)) {
                    Storage::delete($row->$key);
                }
            }
            */

            // 데이터 삭제
            DB::table($this->actions['table']['name'])
                ->where('id', $this->actions['id'])
                ->delete();

            // 컨트롤러 메서드 호출
            if ($controller = $this->isHook("hookDeleted")) {
                $row = $this->controller->hookDeleted($this, $form);
            }

            // 입력데이터 초기화
            $this->cancel();

            // 팝업창 닫기
            //$this->popupFormClose();
            //$this->popupDelete = false;
            // 삭제한 후에는, 테이블 모드로 이동합니다.
            $this->mode = null;

            // 뒤로가기 javascript 이벤트 호출
            $this->dispatch('post-deleted');

        } else {
            //$this->popupFormClose();
            $this->mode = null;
            $this->popupPermitOpen();
        }

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
