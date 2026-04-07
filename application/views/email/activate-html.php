<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title><?php echo $site_name; ?> - 회원 가입이 완료되었습니다.</title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">

<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;"><?php echo $site_name; ?></h2>
<h3>회원 가입이 완료되었습니다.</h3>

<hr />

<h3>가입정보</h3>
<?php if (strlen($username) > 0) { ?>아이디: <?php echo $username; ?><br /><?php } ?>
이메일: <?php echo $email; ?><br />

<hr />

<h3>회원 가입 인증하기</h3>
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/auth/activate/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;">회원가입 인증 완료하기</a></b></big><br /><br />
<br />
만약 위 링크를 클릭해도 아무 반응이 없다면 아래 링크를 복사하여 주소창에 붙여넣어주세요.
<nobr><a href="<?php echo site_url('/auth/activate/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;"><?php echo site_url('/auth/activate/'.$user_id.'/'.$new_email_key); ?></a></nobr><br />
<br />
<?php echo $activation_period; ?>시간 이내에 인증을 완료해주세요. 그렇지 않으면 가입이 완료되지 않으며, 등록하셨던 이메일 계정은 사용불가처리 되므로 새로운 이메일 주소로 다시 가입하셔야 합니다..
<hr />

본 메일은 발신 전용입니다. 
</div>
</body>
</html>