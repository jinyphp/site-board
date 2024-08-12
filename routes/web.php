<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/**
 * Board Route
 */
Route::middleware(['web'])->group(function(){
    Route::get('board/{code?}', [
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
    Route::get('board/{code}/{id}/delete', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardView::class,
        "confirm"])->where('id', '[0-9]+');
    Route::delete('board/{code}/{id}', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardView::class,
        "destroy"])->where('id', '[0-9]+');
    Route::delete('board/{code}/{id}/delete', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardView::class,
            "destroy"])->where('id', '[0-9]+');

});


/**
 * Post Route
 */
Route::middleware(['web'])
    ->name('post')
    ->prefix("/post")->group(function () {
        // 포스트 목록
        Route::get('/', [
            \Jiny\Site\Board\Http\Controllers\Site\SitePostTable::class,
            "index"]);

        // 포스트 작성
        Route::get('/create', [
            \Jiny\Site\Board\Http\Controllers\Site\SitePostCreate::class,
            "index"]);
        Route::post('/create', [
            \Jiny\Site\Board\Http\Controllers\Site\SitePostCreate::class,
            "store"]);

        /*
        // 포스트 목록을 출력
        Route::get('/', [
            \Jiny\Site\Board\Http\Controllers\Site\SitePostController::class,
            "index"])->middleware(['web']);
        */

        // 포스트 상세 보기
        Route::get('/{id}', [
            \Jiny\Site\Board\Http\Controllers\Site\SitePostView::class,
            "index"])
            ->where('id', '[0-9]+')
            ->middleware(['web']);
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

        Route::get('board/related', [
            \Jiny\Site\Board\Http\Controllers\Admin\AdminBoardRelated::class,
            "index"]);

        Route::get('board/trend', [
            \Jiny\Site\Board\Http\Controllers\Admin\AdminBoardTrend::class,
            "index"]);


        //
        Route::get('/posts', [
            \Jiny\Site\Board\Http\Controllers\Admin\AdminPost::class,
            "index"]);


    });
}
