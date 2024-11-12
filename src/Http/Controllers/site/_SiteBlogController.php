<?php
namespace Jiny\Site\Board\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 블로그 페이지
 */
use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class SiteBlogController extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

    }

    public function index(Request $request)
    {
        $this->viewFileLayout = "jiny-site-board::blog.layout";

        //$path = $request->path;
        $this->params['path'] = $request->path;
        return parent::index($request);
    }


}
