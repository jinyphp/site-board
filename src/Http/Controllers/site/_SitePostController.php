<?php
namespace Jiny\Site\Board\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SitePostController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        return view("jiny-site-board::site.post.index");
    }

    public function view(Request $request)
    {
        return view("jiny-site-board::site.post.view", ['id'=> $request->id]);
    }



    public function list()
    {
        return view("jiny-site-board::site.post.layout");

    }




}
