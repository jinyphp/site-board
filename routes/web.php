<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/**
 * 계시판 (멀티테이블)
 * ajax 형태로 crud 계시물을 처리합니다.
 */
Route::middleware(['web'])->group(function(){

    // 계시판 코드가 없는 경우에는
    // 목록 데시보드를 출력합니다.
    Route::get('board', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardDashboard::class,
        "index"]);

    // 계시판 코드가 있는 경우에는
    // 목록을 출력합니다.
    Route::get('board/{code}', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardTable::class,
        "index"])->name('board.list');


    // 계시물 검색
    Route::get('board/{code}/search', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardTable::class,
        "search"])->name('board.search');

    // 계시판 글 작성
    Route::get('board/{code}/create', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardCreate::class,
        "index"])->name('board.create');
    Route::post('board/{code}/create', [
            \Jiny\Site\Board\Http\Controllers\Site\SiteBoardCreate::class,
            "store"])->name('board.store');

    // 계시판 코드가 있는 경우에는
    // 상세 뷰를 출력합니다.
    Route::get('board/{code}/{id}', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardView::class,
        "index"])->where('id', '[0-9]+')->name('board.view');


    // 계시판 수정
    Route::get('board/{code}/{id}/edit', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardEdit::class,
        "edit"])->where('id', '[0-9]+');
    Route::put('board/{code}/{id}/edit', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardEdit::class,
        "update"])->where('id', '[0-9]+');



    // 리소스 삭제
    Route::delete('board/{code}/{id}', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardDelete::class,
        "destroy"])->where('id', '[0-9]+');

    Route::delete('board/{code}/{id}/delete', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardDelete::class,
            "destroy"])->where('id', '[0-9]+');
    Route::get('board/{code}/{id}/delete', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardDelete::class,
        "confirm"])->where('id', '[0-9]+');




});


/**
 * forum (멀티테이블)
 * 라이브와이어를 통하여 popup 형태로 출력합니다.
 */
Route::middleware(['web'])
    ->name('forum')->prefix("/forum")->group(function () {
    Route::get('{code}', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteForum::class,
        "index"]);
});

/**
 * Blog Route
 */
Route::middleware(['web'])->group(function(){
    // 계시판 코드가 있는 경우에는 상세 뷰를 출력합니다.
    Route::get('blog/{id}', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBlogView::class,
        "index"])->where('id', '[0-9]+')->name('blog.view');

    // 계시판 코드가 없는 경우에는 목록 데시보드를 출력합니다.
    Route::get('blog', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBlogTable::class,
        "index"])->name('blog.index');

    // 계시물 검색
    Route::get('blog/search', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBlogTable::class,
        "search"])->name('blog.search');


    // 계시판 글 작성
    Route::get('blog/create', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBlogCreate::class,
        "index"])->name('blog.create');
    Route::post('blog/create', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBlogCreate::class,
        "store"])->name('blog.store');


    // 계시판 수정
    Route::get('blog/{id}/edit', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBlogEdit::class,
        "edit"])->where('id', '[0-9]+')->name('blog.edit');
    Route::put('blog/{id}/edit', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBlogEdit::class,
        "update"])->where('id', '[0-9]+')->name('blog.update');

    // // 이미지 업로드
    // Route::post('blog/images/{id}', [
    //     \Jiny\Site\Board\Http\Controllers\Site\SiteBlogImage::class,
    //     "store"])->where('id', '[0-9]+')->name('blog.images.store');

    // // 이미지 목록
    // Route::get('blog/images/{id}', [
    //     \Jiny\Site\Board\Http\Controllers\Site\SiteBlogImage::class,
    //     "index"])->where('id', '[0-9]+')->name('blog.images.index');

    // 리소스 삭제
    Route::delete('blog/{id}', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBlogDelete::class,
        "destroy"])->where('id', '[0-9]+')->name('blog.destroy');
    Route::delete('blog/{id}/delete', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBlogDelete::class,
        "destroy"])->where('id', '[0-9]+')->name('blog.delete');
    Route::get('blog/{id}/delete', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBlogDelete::class,
        "confirm"])->where('id', '[0-9]+')->name('blog.delete.confirm');

});


Route::middleware(['web'])
    ->name('post')->prefix("/post")->group(function () {
    Route::get('{code?}', [
        \Jiny\Site\Board\Http\Controllers\Site\SitePosts::class,
        "index"]);
});

/**
 * todo post
 */
Route::middleware(['web'])->group(function(){
    Route::get('/home/todo', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteTodo::class,
    "index"]);
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


        // 포스트
        Route::get('/posts', [
            \Jiny\Site\Board\Http\Controllers\Admin\AdminPost::class,
            "index"]);


    });
}
