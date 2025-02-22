# 버튼 커스텀하기

기본 리액션 버튼을 앞으로 옮기거나 대체할 수 있고, 앞/뒤 위치 뿐만 아니라 원하는 위치에 버튼을 추가할 수 있습니다.

- 리액션 버튼을 리액션 목록 앞으로 옮기기
- 리액션 버튼을 감추고 직접 꾸민 버튼으로 대체하기
- 원하는 위치에 리액션 버튼 추가하기


```html {4}
<div
    class="da-reaction"
    x-reaction-print
    x-data="daReaction('대상ID', { options })"
>
</div>
```

## 기본 리액션 버튼

리액션 버튼은 리액션 목록 뒤에 표시됩니다. 이 위치를 변경하거나, 버튼을 표시하지 않도록 설정할 수 있습니다.

리액션 버튼을 목록 앞으로 옮기는 예시:
```html {4}
<div
    class="da-reaction"
    x-reaction-print
    x-data="daReaction('대상ID', { button: 'start' })"
>
</div>
```

<table>
  <thead>
    <tr>
      <th>옵션명</th>
      <th>타입</th>
      <th>기본값</th>
      <th>설명</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>button</code></td>
      <td><code>string|boolean</code></td>
      <td><code>'end'</code></td>
      <td>
        리액션 추가 버튼의 위치 및 비활성<br>
        - <code>'start'</code>: 리액션 목록 앞에 버튼을 추가합니다.<br>
        - <code>'end'</code>: 리액션 목록 뒤에 버튼을 추가합니다.<br>
        - <code>false</code>: 버튼을 표시하지 않습니다.<br>
      </td>
    </tr>
  </tbody>
</table>

## 버튼 대체하기

기본 리액션 버튼을 대체하거나, 원하는 위치에 버튼을 추가할 수 있습니다.

`button: false` 옵션으로 기본 버튼을 감추고, 추가하려는 버튼에 `x-bind="daReactionButton"` 속성을 사용하여 원하는 위치에 추가할 수 있습니다.

`button` 옵션의 `start`, `end`처럼 커스텀 버튼의 위치를 지정할 때는 `placement` 옵션을 사용합니다.

커스텀 버튼의 뒷쪽으로 리액션 목록을 출력하는 예시:
```html {4,6}
<div
    class="da-reaction"
    x-reaction-print
    x-data="daReaction('대상ID', { button: false, placement: 'append' })"
>
    <button x-bind="daReactionButton">+ 반응</button>
</div>
```

<table>
  <thead>
    <tr>
      <th>옵션명</th>
      <th>타입</th>
      <th>기본값</th>
      <th>설명</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>placement</code></td>
      <td><code>string</code></td>
      <td><code>'prepend'</code></td>
      <td>
        커스텀 버튼 사용 시 리액션 목록이 추가될 위치<br>
        - <code>'prepend'</code>: 커스텀 버튼의 앞에 출력<br>
        - <code>'append'</code>: 커스텀 버튼의 뒤에 출력<br>
      </td>
    </tr>
  </tbody>
</table>

리액션 영역 외부에도 버튼을 추가할 수 있습니다.
영역 외부에 있는 버튼에는 `x-bind="daReactionButton('대상ID')"`처럼 대상 ID를 지정해야 합니다.

## 리액션 버튼 커스텀하기

기본 리액션 버튼 또는 커스텀 버튼은 리액션 목록의 끝에 표시되는 것이 기본 설정입니다.

기본으로 표시되는 버튼 대신에 커스텀 버튼을 추가하거나, 영역 밖에 있는 버튼을 사용할 수 있습니다.

```html{4,6}
<div
    class="da-reaction"
    x-reaction-print
    x-data="daReaction('대상ID', { button: false })"
>
    <button x-bind="daReactionButton">+ 반응</button>
</div>
```

## 옵션

리액션 기능의 옵션을 `x-data` HTML 속성에서 설정할 수 있습니다.

```html {4}
<div
    class="da-reaction"
    x-da-reaction
    x-data="daReaction('대상ID', { options })"
></div>
```

<table>
  <thead>
    <tr>
      <th>옵션명</th>
      <th>타입</th>
      <th>기본값</th>
      <th>설명</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>button</code></td>
      <td><code>string|boolean</code></td>
      <td><code>'end'</code></td>
      <td>
        리액션 추가 버튼의 위치 및 비활성<br>
        - <code>'start'</code>: 리액션 목록 앞에 버튼을 추가합니다.<br>
        - <code>'end'</code>: 리액션 목록 뒤에 버튼을 추가합니다.<br>
        - <code>false</code>: 버튼을 표시하지 않습니다.<br>
      </td>
    </tr>
    <tr>
      <td><code>placement</code></td>
      <td><code>string</code></td>
      <td><code>'prepend'</code></td>
      <td>
        커스텀 버튼 사용 시 리액션 목록이 추가될 위치<br>
        - <code>'prepend'</code>: 커스텀 버튼 앞에 출력<br>
        - <code>'append'</code>: 커스텀 버튼 뒤에 출력<br>
      </td>
    </tr>
  </tbody>
</table>

## 버튼 위치 변경하기

`button` 옵션을 변경하여 리액션 버튼의 위치를 변경할 수 있습니다.

```html {5}
<!-- 기본 버튼을 리액션 목록 앞에 표시하도록 변경하는 예시 -->
<div
    class="da-reaction"
    x-da-reaction
    x-data="daReaction('대상ID', { button: 'start' })"
></div>
```

## 커스텀 버튼의 위치

커스텀 버튼을 사용할 때 리액션 목록을 이 버튼의 앞/뒤에 표시할지를 설정할 수 있습니다. `placement` 옵션의 기본 값은 `prepend` 입니다.

```html {5}
<!-- 커스텀 버튼 뒤에 리액션 목록을 표시하도록 변경하는 예시 -->
<div
    class="da-reaction"
    x-da-reaction
    x-data="daReaction('대상ID', { placement: 'append' })"
>
    <button x-bind="daReactionButton">+ 반응</button>
</div>
```

## 영역 밖에 리액션 버튼을 사용하기

영역 밖의 버튼을 사용할 때는 `x-init`, `x-bind` 속성을 사용해야하며, `x-bind="daReactionButton('대상ID')"` 처럼 대상 ID를 지정해야합니다.

```html {5,9-10}
<!-- 기본 버튼을 감추고 `.da-reaction` 영역 밖의 버튼을 사용하는 예시 -->
<div
    class="da-reaction"
    x-da-reaction
    x-data="daReaction('대상ID', { button: false })"
></div>

<button
    x-init
    x-bind="daReactionButton('대상ID')"
>+ 반응</button>
```
