# 리액션 버튼 추가하기

리액션 목록 및 버튼은 게시판의 글과 댓글의 하단에 자동으로 추가됩니다.
게시판 스킨에 따라 위치나 모양새가 적절하지 않다면 원하는 위치에 직접 추가할 수 있습니다.

리액션 추가 버튼과 리액션 목록을 나타내기위해 게시판 스킨에서 사용할 수 있는 템플릿 코드를 제공합니다.

```html
<!-- 리액션 버튼 -->
<div
    class="da-reaction"
    x-da-reaction-print
    x-data="daReaction('대상ID')"
></div>
```

이와 같이 '대상ID'를 지정하여 리액션 버튼을 추가할 수 있습니다.

> [!TIP]
> 직접 추가한 템플릿이 있다면 리액션 목록 및 버튼을 자동으로 추가하지 않습니다.

## 글과 댓글에 리액션 버튼 추가하기

리액션 대상을 구분하기위해 템플릿 코드에 '대상ID'를 지정해야합니다.  
`ReactionHelper` 클래스를 '대상ID'를 손쉽게 생성하는데 사용합니다.

### 글에 추가하기

적용하려는 게시판 스킨의 글 보기 템플릿 파일에 다음과 같이 추가합니다.

:::tabs key:template-version
== v2 템플릿

```blade {2,6-10}
{-- 템플릿 파일 맨 앞에 추가 --}
@use('Rhymix\Modules\Da_reaction\Src\ReactionHelper', 'ReactionHelper')

{-- 출력할 위치에 추가 --}
{-- 글 리액션 --}
<div
    class="da-reaction"
    x-da-reaction-print
    x-data="daReaction('{{ ReactionHelper::generateIdByItem($oDocument) }}')"
></div>
```

== v1 템플릿

```html
<!--// 글 리액션 -->
<div
    class="da-reaction"
    x-da-reaction-print
    x-data="daReaction('{\Rhymix\Modules\Da_reaction\Src\ReactionHelper::generateIdByItem($oDocument)}')"
></div>
```

:::

> [!NOTE]
> 라이믹스 내장 게시판의 스킨 기준으로 `_read.html` 파일이며, 스킨에 따라 파일명이 다를 수 있습니다.

### 댓글에 추가하기

적용하려는 게시판 스킨의 댓글 보기 템플릿 파일에 다음과 같이 추가합니다.

:::tabs key:template-version
== v2 템플릿

```blade {2,6-10}
{-- 템플릿 파일 맨 앞에 추가 --}
@use('Rhymix\Modules\Da_reaction\Src\ReactionHelper', 'ReactionHelper')

{-- 출력할 위치에 추가 --}
{-- 댓글 리액션 --}
<div
    class="da-reaction"
    x-da-reaction-print
    x-data="daReaction('{{ ReactionHelper::generateIdByItem($comment) }}')"
></div>
```

== v1 템플릿

```html
<!--// 댓글 리액션 -->
<div
    class="da-reaction"
    x-da-reaction-print
    x-data="daReaction('{\Rhymix\Modules\Da_reaction\Src\ReactionHelper::generateIdByItem($comment)}')"
></div>
```

:::

> [!NOTE]
> 라이믹스 내장 게시판의 스킨 기준으로 `_comment.html` 파일이며, 스킨에 따라 파일명이 다를 수 있습니다.

## 버튼 커스텀하기

> [!TIP]
> 기본으로 표시되는 리액션 추가하기 버튼의 위치를 변경하거나, 커스텀 버튼을 추가할 수 있습니다.
>
> -> [버튼 커스텀하기](../advanced/customize-button)
