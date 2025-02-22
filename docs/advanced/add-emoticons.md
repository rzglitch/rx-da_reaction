# 리액션 이모티콘, 카테고리 추가하기

리액션으로 선택할 수 있는 이모지(emoji) 및 이미지를 추가할 수 있습니다.

사용자가 선택할 수 있는 이모티콘 목록을 정의할 수 있으며, 원하면 새로운 카테고리를 추가하여 분류를 나눌 수 있습니다.

설정 파일(`config.php`) 파일에 기재하거나 트리거(이벤트)를 사용할 수 있습니다.

## 설정 파일을 이용하기 (PHP)

이 모듈이 설치된 폴더에서 `config.php` 파일을 생성하여 이모티콘, 카테고리 목록 배열로 추가할 수 있습니다.

`['emoticons' => [], 'categories' => [], 'alias' => []]` 형식으로 반환해야 합니다.

```php
return (function () {
    $emoticons = [
        // 이모지 추가 예시
        ['reaction' => 'emoji:1f680'], // Hex 코드 또는
        ['reaction' => '🚨'],          // 이모지 문자 사용

        // 이미지 추가 예시
        ['reaction' => 'image:0010', 'url' => 'https://.../meme-j0010.png'],
        ['reaction' => 'image:nyancat', 'url' => getUrl() . 'path/to/image/7072.gif'],
    ];
    $categories = [];
    $alias = [];

    return compact('emoticons', 'categories', 'alias');
})();
```

| 속성       | 설명                                      |
| ---------- | ----------------------------------------- |
| emoticons  | 이모티콘 목록 배열                        |
| categories | 카테고리 목록 배열                        |
| alias      | 기본 이모티콘을 대체할 이모티콘 목록 배열 |

## 프론트엔드

```js
document.addEventListener("daReaction:init", function (e) {
    const daReaction = e.detail;

    // 밈(meme) 카테고리 추가 예시
    daReaction.addCategory("meme", {
        title: "밈",
        description: "밈 이미지 모음",
        renderType: "image",
    });

    daReaction.addEmoticons([
        // 이모지 추가 예시
        { reaction: "emoji:1f60e" },
        // 추가한 밈 카테고리에 이미지 추가 예시
        { reaction: "meme:0001", url: "https://..../meme-0001.gif" },
    ]);
});
```

> [!TIP] `daReaction:init` 이벤트 사용하기
> 카테고리와 리액션을 추가할 때는 `daReaction:init` 이벤트를 받아 처리해야 합니다.  
> 앞으로의 예시 코드는 이 이벤트 리스너 안에서 작성되었다고 가정합니다.
>
> ```js
> document.addEventListener("daReaction:init", function (e) {
>     const daReaction = e.detail;
>
>     // 여기에 코드를 작성합니다.
>     // daReaction.addCategory();
>     // daReaction.addEmoticons();
> });
> ```

### 이모티콘

리액션 이모티콘으로 이모지나 이미지의 URL을 지정하여 추가할 수 있습니다.

#### 이모지 추가

이모지의 `emoji:` 접두사를 붙여서 이모지의 HEX 코드를 사용하거나, 이모지 문자를 사용하여 추가할 수 있습니다.

```js
daReaction.addEmoticons([
    { reaction: "emoji:1f680" }, // 🚀
    { reaction: "🚨" },
]);
```

이모지를 직접 입력하거나 https://unicode.org/emoji/charts/full-emoji-list.html 에서 원하는 이모지를 찾아 HEX 코드를 확인할 수 있습니다.

#### 이미지 추가

이미지 파일의 주소를 지정하여 추가할 수 있습니다.

`reaction`는 이미지를 구분하기 위한 고유한 이름을 지정하고, 이미지 파일명과 일치하지 않아도 됩니다.

```js
daReaction.addEmoticons([
    { reaction: "image:meme-0010", url: "https://..../meme-j0010.png" },
    { reaction: "image:meme-nyancat", url: "https://..../7072-nyancat.gif" },
]);
```

> [!TIP]
> 이미지는 18px 높이로 표시되며, 가로는 비율에 맞게 조정됩니다.

> [!WARNING]
> 대용량 이미지 등 과도한 움직이는 이미지 사용은 웹페이지의 성능을 저하시킬 수 있습니다.

### 카테고리

카테고리는 리액션을 고를 때 보여지는 분류를 나누는데 사용할 수 있습니다.

::: tip 기본 카테고리

-   `emoji` : 이모지
-   `image` : 이미지
-   `import-image` : `plugin/da_reaction/public/emoticon-images` 폴더에서 가져온 이미지

:::

#### 카테고리 추가

```js
daReaction.addCategory("meme", {
    title: "밈",
    description: "밈 이미지 모음",
    renderType: "image",
});
```

이모티콘ID의 접두어로 사용되며, 이모티콘을 그룹화하고 랜더링하는 방식을 합니다.

```js
// 추가한 `meme` 카테고리에 이모티콘 추가 예시
daReaction.addReactions([
    { reaction: "meme:0001", url: "https://..../meme-0001.gif" },
    { reaction: "meme:0002", url: "https://..../meme-0002.gif" },
]);
```

::: details `addCategory` 메서드
`addCategory` 메서드는 카테고리의 고유 ID와 카테고리의 정보를 받습니다.
카테고리의 ID는 고유해야하며, 이미 존재하는 카테고리 ID를 사용하면 덮어씌워집니다.

```js
/**
 * 카테고리 추가
 * @param {string} categoryId 카테고리 ID
 * @param {object} categoryInfo 카테고리 정보
 */
addCategory(categoryId, categoryInfo);
```

:::

| 속성        | 필수 | 설명                               |
| ----------- | ---- | ---------------------------------- |
| title       | 필수 | 카테고리의 제목                    |
| description | 선택 | 카테고리의 설명                    |
| renderType  | 필수 | 이 카테고리의 이모티콘 렌더링 방식 |

`renderType`은 리액션 아이콘을 표시하는 방법을 지정하며, 현재 지원하는 값은 다음과 같습니다.

-   `emoji`: 이모지
-   `image`: 이미지. `<img>` 태그로 렌더링됩니다.
