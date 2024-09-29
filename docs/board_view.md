# 계시판 글 보기
작성된 계시물을 확인할 수 있는 페이지 있습니다.

## 컨트롤러
글보기 동작은 `SiteBoardView` 컨트롤로에 의해서 처리됩니다. 컨트롤러는 입력되는 url을 분석하여 컨트롤러에 전달됩니다. 라우터에 다음과 같이 설정되어 있습니다.

```php
Route::get('board/{code}/{id}', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardView::class,
        "index"])->where('id', '[0-9]+');
```

계시판을 글으 보기 위해서는 url에 계시판 `코드`와 `글번호`를 같이 입력해 주어야 합니다.
`http://localhost:8000/board/87f0f7c/3`와 같이 접속하면 글을 확인할 수 있습니다.


url로 입력된 `code`와 `id`는 Request로 컨트롤러에 전달되며, DB를 조회하게 됩니다.

### 레이아웃 변경
글보기 화면의 레이아웃을 변경하기 위해서는 컨트롤러에서 `$actions['view']['layout']`을 설정해 주어야 합니다.

```php
$this->actions['view']['layout'] = "jiny-site-board::site.board_code.view";
```

## 컴포넌트
계시판의 글을 보기 위한 컴포넌트 입니다. 컴포넌트를 직절하게 사용하게 되면, url 주소와 별개로 직접 계시판의 글을 읽고, 수정등의 처리를 할 수 있습니다.


```php
{{-- 계시판 글 보기 --}}
@livewire("site-board-view",[
    'actions' => $actions
])
```
