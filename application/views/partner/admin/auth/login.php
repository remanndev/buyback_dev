<!doctype html>
<html>
<head><meta charset="utf-8"><title>파트너 관리자 로그인</title></head>
<body>
<h1><?= html_escape($partner['name']); ?> 관리자 로그인</h1>
<?php if (!empty($error_message)): ?>
<p style="color:red;"><?= html_escape($error_message); ?></p>
<?php endif; ?>
<form method="post">
    <label>이메일 <input type="email" name="email" required></label><br>
    <label>비밀번호 <input type="password" name="password" required></label><br>
    <button type="submit">로그인</button>
</form>
</body>
</html>
