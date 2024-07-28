<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


/**
 * 사이트 접속
 */
Route::middleware(['web'])->group(function(){
    Route::get('board/{code}', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardTable::class,
        "index"]);

    Route::get('board/{code}/{id}', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardView::class,
        "index"])->where('id', '[0-9]+');

    Route::get('board/{code}/create', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardCreate::class,
        "index"]);
    Route::post('board/{code}/create', [
            \Jiny\Site\Board\Http\Controllers\Site\SiteBoardCreate::class,
            "store"]);

    // 리소스 수정
    Route::get('board/{code}/{id}/edit', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardView::class,
        "edit"])->where('id', '[0-9]+');
    Route::put('board/{code}/{id}/edit', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardView::class,
        "update"])->where('id', '[0-9]+');

    // 리소스 삭제
    Route::delete('board/{code}/{id}', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardView::class,
        "destroy"])->where('id', '[0-9]+');
    Route::delete('board/{code}/{id}/edit', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardView::class,
            "destroy"])->where('id', '[0-9]+');

});




/**
 * Admin Site Router
 */
if(function_exists('admin_prefix')) {
    $prefix = admin_prefix();

    Route::middleware(['web','auth', 'admin'])
    ->name('admin.site.board')
    ->prefix($prefix.'/site')->group(function () {
        // 보드 데쉬보드
        Route::get('/board', [
            \Jiny\Site\Board\Http\Controllers\Admin\AdminSiteBoardDashboard::class,
            "index"]);

        ## 계시판 목록
        Route::get('board/code', [
            \Jiny\Site\Board\Http\Controllers\Admin\AdminBoard::class,
            "index"]);

        ## 계시판 글
        Route::get('board/hash/{code}', [
            \Jiny\Site\Board\Http\Controllers\Admin\AdminBoardCode::class,
            "index"]);


    });
}
