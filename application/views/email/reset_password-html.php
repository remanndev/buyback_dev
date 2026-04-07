<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title><?php echo $site_name; ?> 비밀번호 변경 완료</title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">[<?php echo $site_name; ?>] 비밀번호 변경 완료 안내</h2>
<br />
안녕하세요. <br />
회원님의 [<?php echo $site_name; ?>] 로그인 비밀번호가 변경되었습니다.<br />
변경하신 비밀번호를 꼭 기억해주세요.<br />
<br />
<?php if (strlen($username) > 0) { ?>회원 아이디: <?php echo $username; ?><br /><?php } ?>
회원 이메일: <?php echo $email; ?><br />
<?php /* Your new password: <?php echo $new_password; ?><br /> */ ?>
<br />
<br />
<?php echo $site_name; ?>
</td>
</tr>
</table>
</div>
</body>
</html>