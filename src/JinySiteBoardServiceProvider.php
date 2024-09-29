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


        Blade::component($this->package.'::components.'.'ajaxFormCreate', 'ajax-form-create');
        Blade::component($this->package.'::components.'.'ajaxFormEdit', 'ajax-form-edit');
        Blade::component($this->package.'::components.'.'ajaxFormDelete', 'ajax-form-delete');

    }

    public function register()
    {
        /* 라이브와이어 컴포넌트 등록 */
        $this->app->afterResolving(BladeCompiler::class, function () {
            Livewire::component('site-board-setting',
                \Jiny\Site\Board\Http\Livewire\SiteBoardSetting::class);

            // 계시판 방법1. Site Board popup with Livewire
            Livewire::component('site-widget-board',
                \Jiny\Site\Board\Http\Livewire\WidgetBoard::class);
            Livewire::component('site-board-flip',
                \Jiny\Site\Board\Http\Livewire\SiteBoardFlip::class);


            // 계시판 방법2. Livewire and Ajax
            Livewire::component('SiteBoard-table',
                \Jiny\Site\Board\Http\Livewire\SiteBoardTable::class);

            Livewire::component('SiteBoard-create',
                \Jiny\Site\Board\Http\Livewire\SiteBoardCreate::class);

            Livewire::component('site-board-view',
                \Jiny\Site\Board\Http\Livewire\SiteBoardView::class);


            Livewire::component('SiteBoard-cate',
                \Jiny\Site\Board\Http\Livewire\BoardCate::class);
            Livewire::component('SiteBoard-list',
                \Jiny\Site\Board\Http\Livewire\BoardCate::class);


            ## 연관 계시글
            Livewire::component('SiteBoard-related',
                \Jiny\Site\Board\Http\Livewire\BoardRelated::class);
            Livewire::component('SiteBoard-trend',
                \Jiny\Site\Board\Http\Livewire\BoardTrend::class);


            ## Post
            Livewire::component('SitePost-list',
                \Jiny\Site\Board\Http\Livewire\SitePostList::class);

            Livewire::component('SitePost-create',
                \Jiny\Site\Board\Http\Livewire\SitePostCreate::class);

            Livewire::component('SitePost-view',
                \Jiny\Site\Board\Http\Livewire\SitePostView::class);

        });
    }
}
