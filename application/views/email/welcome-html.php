<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title><?php echo $site_name; ?>에 오신 것을 환영합니다!</title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;"><?php echo $site_name; ?>에 오신 것을 환영합니다!</h2>
<br />
<?php echo $site_name; ?>에 가입해주셔서 감사합니다.<br />
지금 바로 <?php echo $site_name; ?>에 방문해보세요.<br />
<br />
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/auth/login/'); ?>" style="color: #3366cc;"><?php echo $site_name; ?>  바로 가기!</a></b></big><br />
<br />
클릭했는데도 아무런 변화가 없나요?<br />
아래 주소를 복사해서 브라우저 주소창에 붙여보세요.<br />
<nobr><a href="<?php echo site_url('/auth/login/'); ?>" style="color: #3366cc;"><?php echo site_url('/auth/login/'); ?></a></nobr><br />
<br />
<br />
<?php if (strlen($username) > 0) { ?>아이디: <?php echo $username; ?><br /><?php } ?>
이메일: <?php echo $email; ?><br />
<?php /* Your password: <?php echo $password; ?><br /> */ ?>
<br />
<br />
언제나 즐거움이 가득하시길!<br />
<?php echo $site_name; ?> 드림.
</td>
</tr>
</table>
</div>
</body>
</html>