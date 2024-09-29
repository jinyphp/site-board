# 계시판

## prefix
url에서 계시판에 접속을 하기 위해서는 라우터에서 지정된 경로로 이동을 해야 합니다. 
계시판은 보통 `board` 라는 prefix 코드를 가지고 있습니다. 이후에 계시물에 대한 `코드`를 추가합니다.

```php
Route::get('board/{code?}', [
    \Jiny\Site\Board\Http\Controllers\Site\SiteBoardTable::class,
    "index"]);
```

이 방식이 아닌 특정 페이지가 지정된 코드의 계시판으로 동작하기 위해서는 새로운 컨트롤러를 생성하고, 라우트를 지정해 주어야 합니다. 이때 `SiteBoardTable` 컨트롤러를 상속하여 재제작 하시면 편리합니다.

## Actions 설정을 통한 계시판 지정
`지니Site`는 모든 url에 대한 동작 처리를 지정하는 `actions` 정보가 존재합니다.
