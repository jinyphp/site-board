<?php
namespace Jiny\Site\Board\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiteBoardComment extends Component
{
    public $actions = [];

    public $post_id;
    public $rows = [];
    //public $rowdata = [];
    public $last_id;

    public $forms=[];
    public $post_comment = false;

    public $code;
    public $viewFile;

    public function mount()
    {
        $this->reply_id = 0;

        // $post_id = $this->post_id;
        // $post = DB::table("posts")
        //     ->where('id',$post_id)
        //     ->first();
        // if($post) {
        //     $this->post_comment = true;
        // }
    }

    public function render()
    {
        $rows = DB::table("site_board_comments")
                ->where('code',$this->code)
                ->where('post_id',$this->post_id)
                ->orderBy('level',"desc")
                ->get();

        $this->rows = [];
        foreach($rows as $item) {
            $id = $item->id;
            // 객체를 배열로 변환
            $this->rows[$id] = get_object_vars($item);
        }

        $this->tree();

        $this->viewFile = 'jiny-site-board::site.comments.comment';
        return view($this->viewFile);



        // $post_id = $this->post_id;
        // $this->forms['post_id'] = $post_id;


        //     //$this->rowdata = [];

        //     //dd($this->rows);

        //     // 기본값



        // // 댓글 존재 여부
        // if($this->post_comment) {

        // }

        // return view("jiny-posts::blog.blank");

    }


    private function tree()
    {
        foreach($this->rows as &$item) {
            $id = $item['id'];
            if($item['ref']) {
                $ref = $item['ref'];
                if(!isset($this->rows[$ref]['items'])) {
                    $this->rows[$ref]['items'] = [];
                }
                $this->rows[$ref]['items'] []= $item;

                unset($this->rows[$id]);
            }
        }
    }

    /**
     * 댓글 저장
     */
    public function store()
    {
        if($this->reply_id) {
            $this->forms['ref'] = $this->reply_id;

            $id = $this->reply_id;
            //$level = $this->rowdata[$id]['level'];
            $this->forms['level'] = $this->level + 1;
        } else {
            $this->forms['ref'] = 0;
            $this->forms['level'] = 1;
        }

        // 2. 시간정보 생성
        $this->forms['created_at'] = date("Y-m-d H:i:s");
        $this->forms['updated_at'] = date("Y-m-d H:i:s");

        $this->forms['post_id'] = $this->post_id;
        $this->forms['code'] = $this->code;
        $this->forms['user_id'] = Auth::user()->id;
        $this->forms['name'] = Auth::user()->name;
        $this->forms['email'] = Auth::user()->email;

        $form = $this->forms;

        $id = DB::table("site_board_comments")->insertGetId($form);
        $form['id'] = $id;
        $this->last_id = $id;

        $this->forms = []; // 초기화
        $this->reply_id = null;
        $this->level = null;
    }

    public $reply_id;
    public $level;
    public function reply($id, $level)
    {
        $this->reply_id = $id;
        $this->level = $level;
    }

    /**
     * 댓글 삭제
     */
    public function delete($id)
    {
        $node = $this->findNode($this->rows, $id);
        if($node['user_id'] == Auth::user()->id) {
            $this->deleteNode($node);
        }
    }

    /**
     * 댓글 탐색
     */
    private function findNode($items, $id)
    {
        foreach($items as $item) {

            if($item['id'] == $id) {
                return $item;
            }

            // 서브트리가 있는 경우, 재귀탐색
            if(isset($item['items'])) {
                $result = $this->findNode($item['items'], $id);
                if($result) { //탐색한 결과가 있으면
                    // 탐색결과를 확인
                    if($result['id'] == $id) return $result;
                }
            }

        }

        return false;
    }

    /**
     * 노드 삭제
     */
    private function deleteNode($items)
    {
        if(isset($items['items'])) {

            foreach($items['items'] as $i => $leaf) {
                if(isset($leaf['items'])) {
                    $this->deleteNode($leaf['items']);
                }

                $id = $leaf['id'];
                $this->dbDeleteRow($id);
            }
        }

        if(isset($items['id'])) {
            $id = $items['id'];
            $this->dbDeleteRow($id);
        } else {
            if(isset($items[0]['id'])) {
                $id = $items[0]['id'];
                $this->dbDeleteRow($id);
            }
        }
    }

    private function dbDeleteRow($id)
    {
        DB::table("site_board_comments")
            ->where('id',$id)
            ->delete();
    }


    /**
     * 댓글 수정
     */
    public $editmode=null;
    public function edit($id)
    {
        $node = $this->findNode($this->rows, $id);
        if($node['user_id'] == Auth::user()->id) {
            $this->forms['content'] = $node['content'];

            $this->editmode = "edit";
            $this->reply_id = $id;
        }
    }

    public function update()
    {
        DB::table("site_board_comments")
            ->where('id',$this->reply_id)
            ->update($this->forms);

        $this->forms = [];
        $this->editmode = null;
        $this->reply_id = null;
    }

    public function cencel()
    {
        $this->forms = [];
        $this->editmode = null;
        $this->reply_id = null;
    }






}
