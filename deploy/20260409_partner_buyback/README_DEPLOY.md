# 2026-04-09 Partner Buyback 배포 패키지

이 폴더는 `partner 기반 buyback` 1차 운영 반영용으로 필요한 파일만 따로 추린 배포 패키지입니다.

## 폴더 구성

- `code/`
  - 운영 서버에 반영할 실제 코드 파일
- `sql/`
  - 운영 DB에 순서대로 반영할 SQL
- `review_before_apply/`
  - 운영에 바로 덮어쓰기 전에 값 확인이 필요한 파일

## SQL 반영 순서

운영 DB 백업 후 아래 순서대로 반영합니다.

1. `sql/20260408_users_admin_type.sql`
2. `sql/20260408_partner_buyback.sql`
3. `sql/20260408_users_admin_level_policy.sql`

### 선택 반영

- `sql/20260408_partner_seed_template.sql`
  - 테스트용/초기 회원사 생성용 템플릿입니다.
  - 운영 반영 필수는 아닙니다.
  - 운영에서 회원사를 관리자 화면으로 직접 등록할 계획이면 실행하지 않아도 됩니다.

## 코드 반영 순서

1. 운영 코드 백업
2. 위 SQL 1~3 실행
3. `code/` 아래 파일을 운영 서버의 같은 경로에 덮어쓰기
4. 주요 URL 점검

## 우선 점검 URL

- `/admin/partner/lists`
- `/admin/partner/write`
- `/partner/{slug}`
- `/partner/{slug}/sell`
- `/partner/{slug}/admin/login`
- `/partner/{slug}/admin/buyback`

## review_before_apply 설명

### `application/controllers/Sns.php`

이 파일은 로컬 카카오 로그인 이슈를 해결하면서 같이 수정된 파일입니다.

운영 반영 전 반드시 확인할 것:

- 카카오 앱 키/시크릿이 운영값과 맞는지
- 네이버 로그인 키가 운영값과 맞는지
- 운영 서버에 PHP `curl` 확장이 활성화되어 있는지

운영 사이트에서 현재 SNS 로그인이 이미 안정적으로 동작 중이라면, 이 파일은 바로 반영하지 말고 별도 검토 후 적용하는 것을 권장합니다.

## 이번 패키지에 의도적으로 넣지 않은 것

- `application/libraries/Tank_auth.php`
  - 현재 기능 차이 없이 개행만 변경된 상태라서 제외
- `tmp_kor_default.php`
- `tmp_lint_test.php`
- `tmp_lint_test2.php`
- 예전 partner 초안 파일들
  - 현재 routes 기준으로 직접 사용되지 않는 파일은 제외
- `.gitignore`
  - 운영 반영 무관

## 이번 패키지의 핵심 반영 내용

- `/sell`을 안내 전용으로 분리
- `/partner/{slug}` 기반 공개/관리자 buyback 흐름 추가
- 회원사 관리 메뉴/화면 추가
- `users_admin.type` 기반 `SITE / PARTNER / BOTH` 구조 추가
- `PARTNER level=80`, `SITE/BOTH level=90` 정책 반영
- partner 미완성 URL(`/partner`, `/partner/{slug}`, `/partner/{slug}/admin`) 보정
- ROS API 설정을 partner별이 아닌 전역 설정으로 단순화
- 관리자 화면의 로컬/엄격 SQL 모드 호환성 보정
  - `디자인 관리`의 `GROUP BY` 쿼리 보정
  - `캠페인 관리`의 `DATETIME` 비교 쿼리 보정

## 비고

- `partner` 테이블의 `ros_api_url`, `ros_api_key` 컬럼은 현재 **미사용 상태로 유지**합니다.
- 실제 ROS API 테스트는 아직 미완료 상태입니다.
- 운영 반영 후에는 먼저 신청/관리 흐름만 확인하고, ROS 연동은 별도 검증하는 것이 안전합니다.
- 운영 DB가 MariaDB여도 이번 `디자인 관리`, `캠페인 관리` 보정은 반영하는 것을 권장합니다.
  - 현재 운영에서 에러가 없더라도, 향후 SQL 모드나 버전 변화 시 같은 문제가 다시 드러날 수 있습니다.
