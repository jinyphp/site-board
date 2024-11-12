<?php
namespace Jiny\Site\Board\Http\Livewire;

use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\Route;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\On;

/**
 * Widget 계시판
 */
class SiteForumWidget extends Component
{
    public $uri;
    public $widget = [];
    public $widget_id;

    use WithFileUploads;
    use WithPagination;
    use \Jiny\WireTable\Http\Trait\Hook;
    use \Jiny\WireTable\Http\Trait\Permit;
    use \Jiny\WireTable\Http\Trait\CheckDelete;
    use \Jiny\WireTable\Http\Trait\DataFetch;
    use \Jiny\WireTable\Http\Trait\Upload;

    ## Hotkey 디자인 모드
    use \Jiny\Widgets\Http\Trait\DesignMode;


    public $admin_prefix;
    public $actions = [];
    public $action_path;


    public $paging = 10;

    ## 선택 데이터
    public $_id;
    public $data=[];
    public $table_columns=[];


    ## 렌더링 동작모드
    public $mode;
    public $message;

    ## 화면뷰
    public $viewLayoutFile;
    public $viewTableFile;  // 테이블 레이아웃
    public $viewListFile;   // 테이블 표
    public $viewCreateFile;
    public $viewViewFile;
    public $viewEditFile;
    public $viewFormFile;
    public $viewDeleteFile;

    public $popupForm = false;
    public $popupWindowWidth = "4xl";
    public $popupDelete = false;


    ## 계시판 데이터
    public $code;
    public $board = [];

    public $countable; // 카운트 중복 방지


    public $slot;
    public $path;
    public $file;

    /**
     * 팝업창 관리
     */
    public $confirm = false;
    public $forms=[];
    public $forms_old=[];
    public $last_id;


    public $search_keyword;

    public function mount()
    {
        $this->uri = Request::path();

        // widget 정보 읽기
        $path = $this->widgetJsonPath();
        $this->widget = json_file_decode($path);

        if(!$this->code) {
            $id = _getKey($this->widget['board']);
            $board = DB::table('site_board')->where('id',$id)->first();

            //dd($board);

            if($board) {
                $actions['code'] = $board->code;
                $this->code = $board->code;
            }
        }


        // actions 파일 경로 체크
        $this->action_path = resource_path('actions');
        $this->action_path .= DIRECTORY_SEPARATOR;
        $this->action_path .= str_replace('/', DIRECTORY_SEPARATOR, $this->uri);
        $this->action_path .= ".json";


        // admin 접속경로 prefix
        if(function_exists('admin_prefix')) {
            $this->admin_prefix = admin_prefix();
        } else {
            $this->admin_prefix = "admin";
        }

        // 권환체크
        $this->permitCheck();

        // 페이징 단위
        // 외부 설정값이 있는 경우, 초기화
        if(isset($this->actions['paging'])) {
            $this->paging = $this->actions['paging'];
        }


        // 외부에서 board정볼르 전달하지 않은 경우
        // 계시판 정보 읽기
        if(!$this->board) {
            $this->boardInfo($this->code);
        }


        // 화면 레이아웃 초기화
        $this->initView();

    }

    private function boardInfo($code)
    {
        // 계시판 Slug로 코드 변경
        $board = DB::table('site_board')
            ->where('slug',$code)->first();

        $table_prefix = "site_board";
        if($board) {
            $this->actions['table'] = $table_prefix."_".$board->code; // 테이블명을 변경함
        } else {
            $this->actions['table'] = $table_prefix."_".$code; // 테이블명을 변경함

            // 코드번호로 다시읽기
            $board = DB::table('site_board')->where('code',$code)->first();
        }

        // 배열 변환
        foreach($board as $key => $value) {
            $this->board[$key] = $value;
        }

        //dd($this->board);
    }

    /**
     * 출력화면을 초기화 합니다.
     */
    private function initView()
    {
        if(!$this->viewLayoutFile) {
            $this->viewLayoutFile = "jiny-site-board"."::site.forum.widget";;
        }

        // 입력폼
        if(!$this->viewFormFile) { // 라이브와이어 외부 입력정보 최우선 처리
            if(isset($this->widget['view']['form'])) {
                $this->viewFormFile = $this->widget['view']['form'];
            } else {
                // 기본값
                $this->viewFormFile = "jiny-site-board"."::site.forum.form";
            }
        }


        if(!$this->viewCreateFile) {
            if(isset($this->widget['view']['create'])) {
                $this->viewCreateFile = $this->widget['view']['create'];
            } else {
                // 기본값
                $this->viewCreateFile = "jiny-site-board"."::site.forum.create";
            }
        }

        if(!$this->viewViewFile) {
            if(isset($this->widget['view']['view'])) {
                $this->viewViewFile = $this->widget['view']['view'];
            } else {
                // 기본값
                $this->viewViewFile = "jiny-site-board"."::site.forum.view";
            }
        }

        if(!$this->viewEditFile) {
            if(isset($this->widget['view']['edit'])) {
                $this->viewEditFile = $this->widget['view']['edit'];
            } else {
                // 기본값
                $this->viewEditFile = "jiny-site-board"."::site.forum.edit";
            }

        }

        if(!$this->viewListFile) {
            if(isset($this->widget['view']['list'])) {
                $this->viewListFile = $this->widget['view']['list'];
            } else
            {
                // 기본값
                $this->viewListFile = "jiny-site-board"."::site.forum.list";
            }
        }


        if(!$this->viewTableFile) {
            if(isset($this->widget['view']['table'])) {
                $this->viewTableFile = $this->widget['view']['table'];
            } else
            {
                // 기본값
                $this->viewTableFile = "jiny-site-board"."::site.forum.table";
            }

        }

    }


    public function render()
    {
        ## 계시판 목록을 출력합니다.
        $this->setTable($this->actions['table']);

        // 2. 후킹_before :: 컨트롤러 메서드 호출
        // DB 데이터를 조회하는 방법들을 변경하려고 할때 유용합니다.
        if ($controller = $this->isHook("HookIndexing")) {
            $result = $this->controller->hookIndexing($this);
            if($result) {
                // 반환값이 있는 경우, 출력하고 이후동작을 중단함.
                return view("jiny-wire-table::errors.message",[
                    'message' => $result
                ]);
            }
        }


        // 3. DB에서 데이터를 읽어 옵니다.
        //$rows = $this->dataFetch($this->actions);
        $db = DB::table($this->actions['table']);
        if($this->search_keyword) {
            $db->where('title', 'like', '%'.$this->search_keyword.'%');
        }
        $rows = $db->orderBy('id', 'desc')->paginate($this->paging);


        $totalPages = $rows->lastPage();
        $currentPage = $rows->currentPage();


        // 4. 후킹_after :: 읽어온 데이터를 별도로
        // 추가 조작이 필요한 경우 동작 합니다. (단, 데이터 읽기가 성공한 경우)
        if($rows) {
            if ($controller = $this->isHook("HookIndexed")) {
                $rows = $this->controller->hookIndexed($this, $rows);
                if(is_array($rows) || is_object($rows)) {
                    // 반환되는 Hook 값은, 배열 또는 객체값 이어야 합니다.
                    // 만일 오류를 발생하고자 한다면, 다른 문자열 값을 출력합니다.
                } else {
                    return view("jiny-wire-table::error.message",[
                        'message'=>"HookIndexed() 호출 반환값이 없습니다."
                    ]);
                }
            }
        }

        $this->toData($rows); // rows를 data 배열에 복사해 둡니다.

        // 6. 출력 레이아아웃
        return view($this->viewLayoutFile,[
            'rows'=>$rows,
            'totalPages'=>$totalPages,
            'currentPage'=>$currentPage
        ]);
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



    protected $listeners = ['refeshTable'];
    public function refeshTable()
    {
        // 페이지를 재갱신 합니다.
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

    /**
     * 신규 글 작성
     */
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
            $this->popupForm=true;
            $this->created = true;
            $this->mode = "create";

        } else {
            // 권한 없음 팝업을 활성화 합니다.
            //dd("create 권환이 없습니다.");
            $this->popupPermitOpen();
        }
    }



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
            $this->popupForm = false;
            $this->created = false;
            $this->mode = null;

            // Livewire Table을 갱신을 호출합니다.
            // $this->emit('refeshTable');

            // 계시물 추가 갯수를 증가합니다.
            DB::table('site_board')
                ->where('code',$this->board['code'] )
                ->increment('post');

        } else {
            $this->popupPermitOpen();
        }
    }

    public function createCancel()
    {
        $this->mode = null;
        $this->popupForm=false;
    }

    ## 계시물 보기
    public function view($id)
    {
        $this->popupForm = true;
        $this->mode = "view";

        $row = DB::table($this->actions['table'])
            ->find($id);
        $this->setForm($row);

        // 계시물 조회수를 증가합니다.
        if($this->countable != $id) {
            DB::table($this->actions['table'])
                ->where('id',$id)
                ->increment('click');

            $this->countable = $id;
            // note: 계시물을 서로 엇갈려서 클릭하면, 갯수가 증가됨.
        }

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

        $this->popupForm = true;
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
                $row = DB::table($this->actions['table'])->find($this->actions['id']);
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
        $this->popupDelete = false;
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
            $origin = DB::table($this->actions['table'])->find($this->actions['id']);
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
            $fields = DB::table('uploadfile')->where('table', $this->actions['table'])->get();
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

                DB::table($this->actions['table'])
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
    public function delete($id=null)
    {
        if($this->permit['delete']) {
            $this->popupDelete = true;
            //$this->mode = "delete";
        }
    }

    ## 삭제 취소
    public function deleteCancel()
    {
        $this->popupDelete = false;
        // 다시 보기 모드로 이동합니다.
        //$this->mode = "view";
    }

    public function deleteConfirm()
    {

        $this->popupDelete = false;
        $this->mode = null;

        if($this->permit['delete']) {
            $row = DB::table($this->actions['table'])->find($this->actions['id']);
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
            $fields = DB::table('uploadfile')->where('table', $this->actions['table'])->get();
            foreach($fields as $item) {
                $key = $item->field; // 업로드 필드명
                if (isset($row->$key)) {
                    Storage::delete($row->$key);
                }
            }
            */

            // 데이터 삭제
            DB::table($this->actions['table'])
                ->where('id', $this->actions['id'])
                ->delete();

            // 컨트롤러 메서드 호출
            if ($controller = $this->isHook("hookDeleted")) {
                $row = $this->controller->hookDeleted($this, $form);
            }

            // 입력데이터 초기화
            $this->cancel();

            // 팝업창 닫기
            $this->popupForm = false;
            $this->popupDelete = false;
            // 삭제한 후에는, 테이블 모드로 이동합니다.
            $this->mode = null;

            // 계시물 추가 갯수를 감소합니다.
            DB::table('site_board')
                ->where('code',$this->board['code'] )
                ->decrement('post');

        } else {
            $this->popupForm = false;
            $this->mode = null;
            $this->popupPermitOpen();
        }

    }


    public function search()
    {

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


    /**
     * Widgetetting
     */
    public function widgetSetting()
    {
        $this->popupForm = true;
        $this->mode = "setting";

        // widget 정보 읽기
        $path = $this->widgetJsonPath();
        $this->forms = json_file_decode($path);
    }

    public function widgetApply()
    {
        $path = $this->widgetJsonPath();
        json_file_encode($path, $this->forms);

        // 수정한 widget 정보 반영
        $this->widget = $this->forms;

        $this->popupForm = false;
        $this->mode = null;
        $this->forms = [];
    }

    private function widgetJsonPath()
    {
        // widget 파일 경로 체크
        $path = resource_path('widgets');
        $path .= DIRECTORY_SEPARATOR;

        // 디렉터리 생성
        //$dir = substr($this->uri, 0, strrpos($this->uri, '/'));
        //$dir = str_replace('/', DIRECTORY_SEPARATOR, $dir);
        $dir = str_replace('/', DIRECTORY_SEPARATOR, $this->uri);
        if(!is_dir($path.$dir)) {
            mkdir($path.$dir, 0777, true);
        }

        $path = $path.str_replace('/', DIRECTORY_SEPARATOR, $this->uri);
        if($this->widget_id) {
            $path .= DIRECTORY_SEPARATOR.$this->widget_id.".json";
        } else {
            $path .= ".json";
        }


        return $path;
    }

    // 계시판 변경
    // public function applyBoard()
    // {
    //     //dd($this->forms);
    //     if(isset($this->forms['board'])) {

    //         $path = resource_path("actions");
    //         $url = DIRECTORY_SEPARATOR.str_replace("/",DIRECTORY_SEPARATOR,$this->uri);
    //         if(file_exists($path.$url.".json")) {
    //             $actions = json_file_decode($path.$url.".json");

    //             $id = _getKey($this->forms['board']);
    //             $board = DB::table('site_board')->where('id',$id)->first();
    //             if($board) {
    //                 $actions['code'] = $board->code;
    //                 $this->code = $board->code;
    //                 json_file_encode($path.$url.".json", $actions);

    //                 // 페이지 리로드 이벤트 발생
    //                 // 현재 목록을 삭제하였기 때문에, 페이지 전체 리로드가 필요함
    //                 $this->dispatch('page-realod');
    //             }


    //         }
    //     }
    // }


}