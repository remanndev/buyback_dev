<!doctype html>
<html>
<head><meta charset="utf-8"><title>매입요청 목록</title></head>
<body>
<h1><?= html_escape($partner['name']); ?> 매입요청 목록</h1>
<table border="1" cellpadding="6">
    <thead>
    <tr><th>ID</th><th>회원ID</th><th>이름</th><th>상태</th><th>상세</th></tr>
    </thead>
    <tbody>
    <?php foreach ($requests as $row): ?>
        <tr>
            <td><?= (int) $row['id']; ?></td>
            <td><?= (int) $row['member_user_id']; ?></td>
            <td><?= html_escape($row['customer_name']); ?></td>
            <td><?= html_escape($row['status']); ?></td>
            <td><a href="/partner/<?= rawurlencode($partner['slug']); ?>/admin/buyback/view/<?= (int) $row['id']; ?>">보기</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
