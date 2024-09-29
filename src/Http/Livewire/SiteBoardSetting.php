<?php
namespace Jiny\Site\Board\Http\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class SiteBoardSetting extends Component
{
    public $uri;
    public $code;

    public $forms = [];


    ## Hotkey 디자인 모드
    use \Jiny\Widgets\Http\Trait\DesignMode;

    public function mount()
    {
        $this->uri = Request::path();
        //($this->uri);
    }

    public function render()
    {
        $this->viewFile = "jiny-site-board::site.board.setting";

        return view($this->viewFile,[

        ]);
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
                $board = DB::table('site_board')->where('id',$id)->first();
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
