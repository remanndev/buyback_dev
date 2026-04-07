<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title><?php echo $site_name; ?> - 비밀번호 찾기</title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">비밀번호 찾기</h2>
비밀번호를 잊어버리셨나요?<br />
아래 링크를 클릭하여 새로운 비밀번호를 설정하세요.<br />
<br />
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/auth/reset_password/'.$user_id.'/'.$new_pass_key); ?>" style="color: #3366cc;">새 비밀번호 설정하기</a></b></big><br />
<br />
만약 위 링크가 작동하지 않는다면, 아래 링크를 복사하여 주소창에 붙여 넣어주세요.<br />
<nobr><a href="<?php echo site_url('/auth/reset_password/'.$user_id.'/'.$new_pass_key); ?>" style="color: #3366cc;"><?php echo site_url('/auth/reset_password/'.$user_id.'/'.$new_pass_key); ?></a></nobr><br />
<br />
<br />
웹사이트 <a href="<?php echo site_url(''); ?>" style="color: #3366cc;"><?php echo $site_name; ?></a>의 회원님이 맞으신가요?<br />
이 메일은 새로운 비밀번호를 설정하기 위해 발송된 안내 메일입니다.<br />
만약 비밀번호 찾기를 신청하신 적이 없으시다면 이 메일은 무시하셔도 되며<br />
기존 비밀번호는 그대로 유지됩니다.

<br />
<br />
감사합니다.
</div>
</body>
</html>