# 프론트엔드

> [!DANGER] 🚧 이 문서는 초안을 작성중이며, 주요 기능이 변경될 수 있습니다.

이 플러그인의 UI 및 주요 기능은 [AlpineJS](https://alpinejs.dev)를 사용하여 만들어졌습니다.

## window.daReaction

`window.daReaction` 객체는 이 플러그인의 기능의 동작에 필요한 데이터를 설정하는데 주료 사용됩니다.

## AlpineJS

| 이름                | 타입               | 설명                                                            |
| ------------------- | ------------------ | --------------------------------------------------------------- |
| `reactionData`      | Alpine.store()     | 이모티콘, 리액션 등의 데이터를 담아 공유하는 저장소             |
| `daReaction`        | Alpine.data()      | 리액션 목록을 출력하거나 상호작용을 위한 개별 컨테이너의 데이터 |
| `da-reaction-print` | Alpine.directive() | 리액션 목록을 출력하는 컨테이너에 사용하는 디렉티브             |
| `daReactionButton`  | Alpine.bind()      | 리액션 추가 버튼에 사용하는 바인딩                              |
| `daReactionPopover` | Alpine.data()      | 리액션 이모티콘 목록을 표시하는 컨텐이너의 데이터               |
