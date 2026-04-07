<?php

// Errors
//$lang['auth_incorrect_password'] = '비밀번호가 틀립니다.';
$lang['auth_incorrect_password'] = '비밀번호를 정확하게 입력해주세요.';
//$lang['auth_incorrect_login'] = '아이디가 틀립니다.';
//$lang['auth_incorrect_login'] = '아이디를 정확하게 입력해주세요.';
$lang['auth_incorrect_login'] = '로그인 정보가 정확하지 않습니다.';
$lang['auth_incorrect_email_or_userid'] = '회원 이메일 또는 아이디가 존재하지 않습니다.';
$lang['auth_incorrect_email_or_username'] = '회원 이메일 또는 아이디가 존재하지 않습니다.';
$lang['auth_email_in_use'] = '중복된 이메일이 있습니다. 다른 이메일을 입력하세요.';
$lang['auth_nickname_in_use'] = '중복된 닉네임이 있습니다. 다른 닉네임을 입력하세요.';
$lang['auth_userid_in_use'] = '중복된 아이디가 있습니다. 다른 아이디를 입력하세요.';
$lang['auth_username_in_use'] = '중복된 이름이 있습니다. 다른 이름을 입력하세요.';
//$lang['auth_current_email'] = 'This is your current email';
$lang['auth_current_email'] = '현재 사용하고 계신 이메일입니다.';
$lang['auth_incorrect_captcha'] = '인증코드가 이미지와 일치하지 않습니다..';
$lang['auth_captcha_expired'] = '인증코드 유효기간이 만료되었습니다.';

//$lang['auth_incorrect_g_recaptcha'] = 'Incorrect Recaptcha! Please try again!';
$lang['auth_incorrect_g_recaptcha'] = '인증이 올바르지 않습니다! 다시 시도해주세요!';

// Notifications
$lang['auth_message_logged_out'] = '로그아웃 되었습니다.';
$lang['auth_message_registration_disabled'] = '회원가입을 잠시 보류중입니다..';
//$lang['auth_message_registration_completed_1'] = 'You have successfully registered. Check your email address to activate your account.';
$lang['auth_message_registration_completed_1'] = '회원 가입이 완료되었습니다.<br /><br />회원가입완료를 위해 등록해주신 이메일 주소로 인증코드를 발송해드렸습니다. 반드시 메일 내용을 확인하시고 인증 후 로그인해주세요.<br /><br />간혹, 메일이 스팸함에 있는 경우가 있습니다. 인증메일이 확인되지 않으실 경우, 스팸함을 확인해보세요.';
//$lang['auth_message_registration_completed_2'] = 'You have successfully registered.';
$lang['auth_message_registration_completed_2'] = '회원등록이 완료되었습니다.';
//$lang['auth_message_activation_email_sent'] = 'A new activation email has been sent to %s. Follow the instructions in the email to activate your account.';
$lang['auth_message_activation_email_sent'] = '%s 이메일 계정으로 인증 메일이 발송되었습니다. 이메일 내용을 확인해주세요.';
//$lang['auth_message_activation_completed'] = 'Your account has been successfully activated.';
$lang['auth_message_activation_completed'] = '회원가입이 완료되었습니다. 감사합니다.';
//$lang['auth_message_activation_failed'] = 'The activation code you entered is incorrect or expired.';
$lang['auth_message_activation_failed'] = '이미 인증을 완료하셨거나 또는 인증기한이 만료되었습니다.';
//$lang['auth_message_password_changed'] = 'Your password has been successfully changed.';
$lang['auth_message_password_changed'] = '비밀번호 변경이 완료되었습니다.';
//$lang['auth_message_new_password_sent'] = 'An email with instructions for creating a new password has been sent to you.';
$lang['auth_message_new_password_sent'] = '비밀번호 변경 안내 이메일이 발송되었습니다. <br />이메일 내용을 확인해주세요.';
//$lang['auth_message_new_password_activated'] = 'You have successfully reset your password';
$lang['auth_message_new_password_activated'] = '비밀번호가 재설정되었습니다.';

$lang['auth_message_email_sent_username'] = '아이디 안내 이메일이 발송되었습니다. <br />이메일 내용을 확인해주세요.';

//$lang['auth_message_new_password_failed'] = 'Your activation key is incorrect or expired. Please check your email again and follow the instructions.';
$lang['auth_message_new_password_failed'] = '인증코드가 틀렸거나 기한이 만료되었습니다. 이메일 내용을 다시 한 번 확인해주세요.';

//$lang['auth_message_new_email_sent'] = 'A confirmation email has been sent to %s. Follow the instructions in the email to complete this change of email address.';
$lang['auth_message_new_email_sent'] = '이메일 변경 안내 메일이 다음의 주소로 발송되었습니다. <br /><br />%s<br /><br />발송된 내용을 통해 이메일주소를 변경해 주세요.';

//$lang['auth_message_new_email_activated'] = 'You have successfully changed your email';
$lang['auth_message_new_email_activated'] = '회원님의 이메일 주소가 변경되었습니다.';

//$lang['auth_message_new_email_failed'] = 'Your activation key is incorrect or expired. Please check your email again and follow the instructions.';
$lang['auth_message_new_email_failed'] = '인증코드가 틀렸거나 기한이 만료되었습니다. 이메일 내용을 다시 한 번 확인해주세요.';

//$lang['auth_message_banned'] = 'You are banned.';
$lang['auth_message_banned'] = '회원님의 계정은 차단된 상태입니다.<br /> [사유] ';
//$lang['auth_message_unregistered'] = 'Your account has been deleted...';
// $lang['auth_message_unregistered'] = '회원님의 계정은 삭제되었습니다...';
$lang['auth_message_unregistered'] = '회원님의 계정 탈퇴가 완료되었습니다.';

// Email subjects
/*
$lang['auth_subject_welcome'] = 'Welcome to %s!';
$lang['auth_subject_activate'] = 'Welcome to %s!';
$lang['auth_subject_forgot_password'] = 'Forgot your password on %s?';
$lang['auth_subject_reset_password'] = 'Your new password on %s';
$lang['auth_subject_change_email'] = 'Your new email address on %s';
*/
$lang['auth_subject_welcome'] = '%s 에 오신 것을 환영합니다!';
$lang['auth_subject_activate'] = '%s 에 오신 것을 환영합니다!';
$lang['auth_subject_forgot_password'] = '[%s] 비밀번호를 잊어버리셨나요?';
$lang['auth_subject_forgot_id'] = '[%s] 아이디 안내 메일입니다.';
$lang['auth_subject_reset_password'] = '[%s] 비밀번호 재설정 안내 메일입니다.';
$lang['auth_subject_change_email'] = '[%s] 이메일 재설정 안내 메일입니다.';


// $lang['auth_message_admin_page'] = 'You must login as an admin to access this area.';
$lang['auth_message_admin_page'] = '관리자 로그인이 필요한 페이지입니다.';

/* End of file tank_auth_lang.php */
/* Location: ./application/language/korean/tank_auth_lang.php */