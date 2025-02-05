<?php
namespace Jiny\Site\Board\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

use Livewire\Attributes\On;

class SitePostSetting extends Component
{
    public $uri;
    public $code;

    public $forms = [];

    public $popupSetting = false;
    public $design;

    #[On('design-mode')]
    public function designMode($mode=null)
    {
        if($this->design) {
            $this->design = false;
            $this->popupSetting = false;
        } else {
            $this->design = true;
            $this->popupSetting = true;
        }
    }

    public function mount()
    {
        $this->uri = Request::path();
        //($this->uri);
    }

    public function render()
    {
        if($this->popupSetting) {
            // slug 코드로 찾기
            $row = DB::table('site_post_setting')->where('slug',$this->code)->first();
            if(!$row) {
                // code 코드로 찾기
                $row = DB::table('site_post_setting')->where('code',$this->code)->first();
            }

            if($row) {
                foreach($row as $key => $value) {
                    $this->forms[$key] = $value;
                }
            }

            //dd($row);

        }

        $this->viewFile = "jiny-site-board::site.board.setting";
        return view($this->viewFile,[

        ]);
    }

    public function popupClose()
    {
        $this->popupSetting = false;
        $this->design = false;
    }

    public function update()
    {
        $id = $this->forms['id'];
        unset($this->forms['id']);

        DB::table('site_post_setting')->where('id',$id)->update($this->forms);
        $this->popupSetting = false;
        $this->design = false;
    }



    public function applyBoard()
    {
        //dd($this->forms);
        if(isset($this->forms['board'])) {

            $path = resource_path("actions");
            $url = DIRECTORY_SEPARATOR.str_replace("/",DIRECTORY_SEPARATOR,$this->uri);
            if(file_exists($path.$url.".json")) {
                $actions = json_file_decode($path.$url.".json");

                $id = _getKey($this->forms['board']);
                $board = DB::table('site_post_setting')->where('id',$id)->first();
                if($board) {
                    $actions['code'] = $board->code;
                    $this->code = $board->code;
                    json_file_encode($path.$url.".json", $actions);

                    // 페이지 리로드 이벤트 발생
                    // 현재 목록을 삭제하였기 때문에, 페이지 전체 리로드가 필요함
                    $this->dispatch('page-realod');
                }


            }
        }
    }
}
