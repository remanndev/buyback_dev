<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= html_escape($partner['name']); ?> 매입 신청</title>
</head>
<body>
<h1><?= html_escape($partner['name']); ?> 매입 신청</h1>
<?php if (!empty($is_kakao_member)): ?>
    <p>카카오 회원으로 확인되었습니다.</p>
<?php else: ?>
    <p>일반 회원으로 확인되었습니다.</p>
<?php endif; ?>

<form method="post" action="/partner/<?= rawurlencode($partner['slug']); ?>/sell/submit">
    <label>이름 <input type="text" name="customer_name" required></label><br>
    <label>연락처 <input type="text" name="customer_phone" required></label><br>
    <label>주소 <input type="text" name="pickup_address" required></label><br>
    <label>브랜드 <input type="text" name="brand" required></label><br>
    <label>모델 <input type="text" name="model" required></label><br>
    <label>상태등급 <input type="text" name="condition_grade" required></label><br>
    <label>메모 <textarea name="memo"></textarea></label><br>
    <button type="submit">신청하기</button>
</form>

<script>
// JS에서 HTML 문자열 조립을 피하고, 단순 이벤트 바인딩만 사용한다.
document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('form');
    form.addEventListener('submit', function () {
        form.querySelector('button[type="submit"]').disabled = true;
    });
});
</script>
</body>
</html>
