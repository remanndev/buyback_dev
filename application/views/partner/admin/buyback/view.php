<!doctype html>
<html>
<head><meta charset="utf-8"><title>매입요청 상세</title></head>
<body>
<h1>매입요청 #<?= (int) $request['id']; ?></h1>
<p>회원ID: <?= (int) $request['member_user_id']; ?></p>
<p>이름: <?= html_escape($request['customer_name']); ?></p>
<p>연락처: <?= html_escape($request['customer_phone']); ?></p>
<p>주소: <?= html_escape($request['pickup_address']); ?></p>
<p>상태: <?= html_escape($request['status']); ?></p>

<h2>디바이스</h2>
<ul>
    <?php foreach ($request['devices'] as $device): ?>
        <li><?= html_escape($device['brand']); ?> / <?= html_escape($device['model']); ?> / <?= html_escape($device['condition_grade']); ?></li>
    <?php endforeach; ?>
</ul>

<button id="apiSendBtn" type="button">API 전송</button>
<pre id="apiResult"></pre>

<script>
document.getElementById('apiSendBtn').addEventListener('click', function () {
    var btn = this;
    btn.disabled = true;

    fetch('/partner/<?= rawurlencode($partner['slug']); ?>/admin/buyback/api-send/<?= (int) $request['id']; ?>', {
        method: 'POST'
    })
    .then(function (res) { return res.json(); })
    .then(function (json) {
        document.getElementById('apiResult').textContent = JSON.stringify(json, null, 2);
    })
    .catch(function () {
        document.getElementById('apiResult').textContent = '요청 처리 중 오류가 발생했습니다.';
    })
    .finally(function () {
        btn.disabled = false;
    });
});
</script>
</body>
</html>
