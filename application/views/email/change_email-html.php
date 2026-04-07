<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>[<?php echo $site_name; ?>] 이메일 재설정 안내 메일입니다.</title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">[<?php echo $site_name; ?>] 이메일 재설정 안내 메일</h2>

회원님께서는 [<?php echo $site_name; ?>]에서 이메일 주소 변경을 신청하셨습니다.<br />
아래 링크를 클릭하시면 이메일 주소 변경이 완료됩니다.
<br />
<br />
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/auth/reset_email/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;">이메일 주소 변경 완료</a></b></big><br />
<br />
위 링크가 비활성화되었거나 클릭이 되지 않나요? <br />
아래 링크 주소를 복사하여 브라우저 주소칸에 붙여넣으세요.:<br />
<br />
<nobr><a href="<?php echo site_url('/auth/reset_email/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;"><?php echo site_url('/auth/reset_email/'.$user_id.'/'.$new_email_key); ?></a></nobr><br />
<br />
<br />
변경하고자 하신 이메일 주소: <?php echo $new_email; ?><br />
<br />
<br />
이 메일은 <a href="<?php echo site_url(''); ?>" style="color: #3366cc;"><?php echo $site_name; ?></a>에서 요청하신 메일입니다.<br />
만약 실수로 받게 된 이메일이라면, 절대로 위 링크를 클릭하지 마시고 바로 삭제해주세요. <br />
변경요청내용은 잠시 후에 시스템에서 제거될 것입니다.
<br />
<br />
<br />
<?php echo $site_name; ?>
</td>
</tr>
</table>
</div>
</body>
</html>