# 설치하기

- 설치 경로: `modules/da_reaction`
- 설치 조건
  - 라이믹스 2.1.21 버전 이상
    - 라이믹스 관리페이지 하단에서 설치된 버전을 확인할 수 있습니다
  - PHP 7.4 버전 이상
    - MySQLi 확장 필요
    - PDO MySQL 확장 필요
  - MySQL 5.7.8 버전 이상

## 설치하기

1. 파일의 압축을 풀어 라이믹스의 `modules` 디렉토리에 설치합니다.

```sh {3-7}
.
└── modules
    └── da_reaction
        ├── conf
        ├── schemas
        ├── ...
        └── src
```

2. 라이믹스 관리페이지 대시보드에서 테이블 생성 및 설정을 해야합니다.
    - 'DB 테이블 생성' 버튼을 클릭하여 테이블을 생성합니다.
    - '설정 완료하기' 버튼이 표시된다면 클릭하여 설정을 완료합니다.

3. 완료

리액션 버튼을 커스텀하거나 원하는 위치에 추가하려면 [리액션 버튼 추가하기](./install-button.md) 문서를 참고하세요.


## 설정하기

<table>
  <thead>
    <tr>
      <th>옵션</th>
      <th>기본값</th>
      <th>설명</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>$_ENV['DA_ALPINEJS']</code></td>
      <td>없음</td>
      <td>
        <a href="https://alpinejs.dev">AlpineJS</a> 스크립트의 중복 로드 방지
      </td>
    </tr>
  </tbody>
</table>
