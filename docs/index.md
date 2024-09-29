# 사이트 계시판
지니사이트에서 계시판을 처리할 수 있는 패키지 입니다.

사이트보드는 여러개의 계시판별 테이블을 자체적으로 생성하고, 독립된 계시물을 관리합니다.


## 설치
컴포저로 패키지를 설치한 후에 DB 마이그레이션을 실행합니다.
```bash
composer require jiny/site-board
php artisan migrate
```

## 관리자
`/admin/site/board` 관리자 페이지에서 계시판을 관리할 수 있습니다.

## 방법1: Board With Livewire
라이브와이어를 이용한 통합 CRUD 계시판을 손쉽게 삽입할 수 있습니다.

`Blade`화면에서 다음과 같이 라이브와이어 컴포넌트를 삽입하면, 
`Table`-`View`-`Edit`-`Delete` 기능를 싱글페이지 형태로 구현할 수 있습니다.

```php
@livewire('SiteBoard',['code'=>"news"])
```

사용자 커스텀 화면이 필요한 경우에는 추가 인자로 blade 파일을 주입할 수 있습니다.
* viewTableFile
* viewListFile 
* viewCreateFile
* viewViewFile
* viewEditFile
* viewFormFile
* viewDeleteFile

> 사용자 화면 미정의시 `jiny-site-board::site.board_wire.*` 화면으로 처리됩니다.

## 방법2: 커스텀 Livewire
통합 Livewire 계시판과 달리 uri를 기준으로 동작을 수행할 수 있습니다.

### site-board-view
라이브와이어로 구성된 싱글페이지가 페이지의 리로드가 없어 UI개선이 있지만, 특정 계시물을 외부로 노출하기에는 쉽지 않습니다.  

예를 들어 `/board/news/3`과 같이 계시물 번호 `3`을 추가하는 경우에는 이를 표현할 수 없습니다.
이런 경우 `site-board-view` 컴포넌트를 사용할 수 있습니다.

```php
{{-- 계시판 글 보기 --}}
@livewire("site-board-view",[
'actions' => $actions,
'viewFile'=>"www::shop_fashion-v1.board.detail_view2"
])

<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('board-deleted', (event) => {
        console.log("board-deleted");
        window.history.go(-1);
    });
});
</script>
```

`site-board-view`는 외부의 컨트롤러 도움이 없어도 현재 url의 정보를 분석하여 계시물을 출력합니다.

### SiteBoard-create
지정한 계시판에 직접 글을 쓸 수 있는 uri를 생성할 수 있습니다.

```php
@livewire('SiteBoard-create',[
    'actions' => $actions
])

<script>
    document.addEventListener('livewire:init', () => {
    Livewire.on('board-created', (event) => {
        console.log("board-created");
        window.history.go(-1);
    });
    });
</script>
```

### SiteBoard-table

```php
```

## 방법3: AJAX
서버와 ajax 통하여 CRUD를 처리합니다.

### create
`<x-ajax-form-create>` 컴포넌트는 form 요소와 서버와 ajax를 통신하기 위한 javascript가 같이 패키징되어 있습니다.

```php
<x-ajax-form-create action="/board/{{$code}}/create">
    @includeIf($actions['view']['form'])
</x-ajax-form-create>
```

`action`에 설정된 `uri`주소로 form을 post로 전달합니다.

### edit

```php
<x-ajax-form-edit action="/board/{{$code}}/{{$row->id}}/edit">
    @includeIf($actions['view']['form'])
</x-ajax-form-edit>
```

### delete

```php
<x-ajax-form-delete action="/board/{{$code}}/{{$row->id}}/delete">
    <div class="alert alert-danger">
        정말로 삭제를 하시겠습니까? 
    </div>
</x-ajax-form-delete>
```
