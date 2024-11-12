<?php
namespace Jiny\Site\Board\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteBoardDashboard extends Controller
{
    public function index(Request $request)
    {
        $viewFile = "jiny-site-board::site.board.dashboard";
        return view($viewFile);
    }
}
