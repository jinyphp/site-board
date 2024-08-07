<?php
use Illuminate\Support\Facades\DB;

/**
 * 포스트에서 카테고리를 그룹화하여 목록을 반환합니다.
 */
if(!function_exists("getPostGroupBy")) {
    function getPostGroupBy($key='categories') {
        $rows = DB::table('site_posts')
                ->select($key, DB::raw('count(*) as count'))
                ->groupBy($key)
                ->get();

        return $rows;
    }
}

/**
 * 포스트 목록을 반환합니다.
 */
if(!function_exists("getPosts")) {
    function getPosts($limit=5, $code=null) {
        $db = DB::table('site_posts')->orderBy('id', 'desc');

        if($code) {
            if(is_array($code)) {
                foreach($code as $key => $value) {
                    $db->where($key,$value);
                }
            } else {
                $db->where('code',$code);
            }
        }

        if(is_array($limit)) {
            $db->offset($limit[0]-1)  // Skip the first 9 records
            ->limit($limit[1]);   // Fetch the next 8 records (10th to 17th)
        } else {
            $db->limit($limit);
        }

        return $db->get();
    }
}


/**
 * 계시판 목록을 반환합니다.
 */
if(!function_exists("getBoards")) {
    function getBoards($limit=5, $code=null) {
        $db = DB::table('site_board')->orderBy('id', 'desc');

        if($code) {
            if(is_array($code)) {
                foreach($code as $key => $value) {
                    $db->where($key,$value);
                }
            } else {
                $db->where('code',$code);
            }
        }

        if(is_array($limit)) {
            $db->offset($limit[0]-1)  // Skip the first 9 records
            ->limit($limit[1]);   // Fetch the next 8 records (10th to 17th)
        } else {
            $db->limit($limit);
        }

        return $db->get();
    }
}

