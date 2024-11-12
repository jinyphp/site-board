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

class SiteBlogCreate extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $viewFile;
    public $path;

    public function mount()
    {
        if(!$this->viewFile) {
            $this->viewFile = "jiny-site-board::blog.create";
        }
    }

    public function render()
    {

        return view($this->viewFile);
    }

}
