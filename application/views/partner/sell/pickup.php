<!doctype html>
<html>
<head><meta charset="utf-8"><title>픽업 안내</title></head>
<body>
<h1><?= html_escape($partner['name']); ?> 픽업 안내</h1>
<p>픽업 정책 및 시간 안내 페이지입니다.</p>
<a href="/partner/<?= rawurlencode($partner['slug']); ?>/sell">신청 페이지로 이동</a>
</body>
</html>
