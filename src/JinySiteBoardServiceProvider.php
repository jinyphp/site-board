<?php
namespace Jiny\Site\Board;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;

class JinySiteBoardServiceProvider extends ServiceProvider
{
    private $package = "jiny-site-board";
    public function boot()
    {
        // 모듈: 라우트 설정
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->package);

        // 데이터베이스
        $this->loadMigrationsFrom(__DIR__.'/../databases/migrations');

    }

    public function register()
    {
        /* 라이브와이어 컴포넌트 등록 */
        $this->app->afterResolving(BladeCompiler::class, function () {
            Livewire::component('SiteBoard-create',
                \Jiny\Site\Board\Http\Livewire\SiteBoardCreate::class);

            Livewire::component('SiteBoard-view',
                \Jiny\Site\Board\Http\Livewire\SiteBoardView::class);

            Livewire::component('SiteBoard-list',
                \Jiny\Site\Board\Http\Livewire\BoardList::class);

            Livewire::component('SiteBoard-related',
                \Jiny\Site\Board\Http\Livewire\BoardRelated::class);

        });
    }
}
