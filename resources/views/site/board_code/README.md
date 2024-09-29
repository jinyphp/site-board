# 계시판

## 목록
`/board/코드` 형식으로 uri를 입력하면, 라이브와이어를 통하여 목록이 출력됩니다.

## 글작성
`/board/코드/create` 로 접속하시면 새로운 글을 작성할 수 있습니다.
자바스크립트를 통하여 ajax로 서버에 새로운 글을 삽입합니다.

## 글보기
`/board/코드/글번호` 형식으로 입력하면, 작성한 글을 볼 수 있습니다.

라우트 컨트롤러 설정은 다음과 같습니다.
```php
Route::get('board/{code}/{id}', [
        \Jiny\Site\Board\Http\Controllers\Site\SiteBoardView::class,
        "index"])->where('id', '[0-9]+');
```


