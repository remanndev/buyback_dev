<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Website details
|
| These details are used in emails sent by authentication library.
|--------------------------------------------------------------------------
*/
$website_name = '리맨 중고 매입';
$website_description = '빠르고 안전한 리맨 매입 서비스를 통해 최적의 가격을 확인하세요.';



// 추가
$config['website_name'] = $website_name;

// [2023-11-28] 네이버 SMTP 메일 설정에 등록한 이메일만 사용 가능합니다.
$config['webmaster_email'] = 'replus_digitalgive@naver.com';


$config['website_domain'] = 'buyback.remann.co.kr';
$config['website_logo_src'] = IMG_DIR.'/layout/remann_buyback_logo.png'; // 로고 이미지 경로
$config['website_logo_img'] = '<img src="'. IMG_DIR .'/layout/remann_buyback_logo.png" alt="리맨 바이백 로고" />'; // 로고 이미지 경로

$config['website_meta_title'      ] = $website_name;
$config['website_meta_keywords'   ] = '컴퓨터,중고,매입'; 
$config['website_meta_description'] = $website_description;

$config['website_meta_og_type'       ] = 'website';
$config['website_meta_og_title'      ] = $website_name;
$config['website_meta_og_url'        ] = '';
$config['website_meta_og_description'] = $website_description;
$config['website_meta_og_site_name'  ] =  $website_name;
$config['website_meta_og_image'      ] = '';




// SNS etc..
$config['website_naver-site-verification'] = '';
$config['website_facebook_sn'] = '';
$config['website_kakao_sn'] = '';

// 캘린더 설정
$config['cf_calendar_arr']		= "일정:calendar"; // 캘린더 메뉴[이름:code]













/*
|--------------------------------------------------------------------------
| Security settings
|
| The library uses PasswordHash library for operating with hashed passwords.
| 'phpass_hash_portable' = Can passwords be dumped and exported to another server. If set to FALSE then you won't be able to use this database on another server.
| 'phpass_hash_strength' = Password hash strength.
|--------------------------------------------------------------------------
*/
$config['phpass_hash_portable'] = FALSE;
$config['phpass_hash_strength'] = 8;

/*
|--------------------------------------------------------------------------
| Registration settings
|
| 'allow_registration' = Registration is enabled or not
| 'captcha_registration' = Registration uses CAPTCHA
| 'email_activation' = Requires user to activate their account using email after registration.
| 'email_activation_expire' = Time before users who don't activate their account getting deleted from database. Default is 48 hours (60*60*24*2).
| 'email_account_details' = Email with account details is sent after registration (only when 'email_activation' is FALSE).
| 'use_username' = Username is required or not.
|
| 'username_min_length' = Min length of user's username.
| 'username_max_length' = Max length of user's username.
| 'password_min_length' = Min length of user's password.
| 'password_max_length' = Max length of user's password.
|--------------------------------------------------------------------------
*/
$config['allow_registration'] = TRUE;
$config['captcha_registration'] = TRUE;
$config['email_activation'] = FALSE;
$config['email_activation_expire'] = 60*60*24*2;
$config['email_account_details'] = TRUE;
$config['use_username'] = FALSE;
$config['use_nickname'] = TRUE;

$config['username_min_length'] = 4;
$config['username_max_length'] = 20;
$config['nickname_min_length'] = 2;
$config['nickname_max_length'] = 20;
$config['password_min_length'] = 6;
$config['password_max_length'] = 20;

/*
|--------------------------------------------------------------------------
| Login settings
|
| 'login_by_username' = Username can be used to login.
| 'login_by_email' = Email can be used to login.
| You have to set at least one of 2 settings above to TRUE.
| 'login_by_username' makes sense only when 'use_username' is TRUE.
|
| 'login_record_ip' = Save in database user IP address on user login.
| 'login_record_time' = Save in database current time on user login.
|
| 'login_count_attempts' = Count failed login attempts.
| 'login_max_attempts' = Number of failed login attempts before CAPTCHA will be shown.
| 'login_attempt_expire' = Time to live for every attempt to login. Default is 24 hours (60*60*24).
|--------------------------------------------------------------------------
*/
$config['login_by_username'] = FALSE;
$config['login_by_email'] = TRUE;
$config['login_record_ip'] = TRUE;
$config['login_record_time'] = TRUE;
$config['login_count_attempts'] = TRUE;
$config['login_max_attempts'] = 10;
$config['login_attempt_expire'] = 60*60*24;

/*
|--------------------------------------------------------------------------
| Auto login settings
|
| 'autologin_cookie_name' = Auto login cookie name.
| 'autologin_cookie_life' = Auto login cookie life before expired. Default is 2 months (60*60*24*31*2).
|--------------------------------------------------------------------------
*/
$config['autologin_cookie_name'] = 'autologin';
$config['autologin_cookie_life'] = 60*60*24*31*2;

/*
|--------------------------------------------------------------------------
| Forgot password settings
|
| 'forgot_password_expire' = Time before forgot password key become invalid. Default is 15 minutes (60*15).
|--------------------------------------------------------------------------
*/
$config['forgot_password_expire'] = 60*15;

/*
|--------------------------------------------------------------------------
| Captcha
|
| You can set captcha that created by Auth library in here.
| 'captcha_path' = Directory where the catpcha will be created.
| 'captcha_fonts_path' = Font in this directory will be used when creating captcha.
| 'captcha_font_size' = Font size when writing text to captcha. Leave blank for random font size.
| 'captcha_grid' = Show grid in created captcha.
| 'captcha_expire' = Life time of created captcha before expired, default is 3 minutes (180 seconds).
| 'captcha_case_sensitive' = Captcha case sensitive or not.
|--------------------------------------------------------------------------
*/
$config['captcha_path'] = 'assets/captcha/';
$config['captcha_fonts_path'] = FCPATH.'assets/captcha/fonts/3.ttf';
$config['captcha_width'] = 150;
$config['captcha_height'] = 38;
$config['captcha_font_size'] = 18;
$config['captcha_grid'] = FALSE;
$config['captcha_expire'] = 180;
$config['captcha_case_sensitive'] = TRUE;

$config['captcha_word_length'] = 5;
$config['captcha_pool'] = '0123456789';

/*
|--------------------------------------------------------------------------
| reCAPTCHA
|
| 'use_recaptcha' = Use reCAPTCHA instead of common captcha
| You can get reCAPTCHA keys by registering at http://recaptcha.net
|--------------------------------------------------------------------------
*/
$config['use_ssl'] = FALSE;
$config['use_recaptcha'] = FALSE;
$config['recaptcha_public_key'] = '';
$config['recaptcha_private_key'] = '';

/*
|--------------------------------------------------------------------------
| Database settings
|
| 'db_table_prefix' = Table prefix that will be prepended to every table name used by the library
| (except 'ci_sessions' table).
|--------------------------------------------------------------------------
*/
$config['db_table_prefix'] = '';













/*
|--------------------------------------------------------------------------
| 가치
|
|--------------------------------------------------------------------------
*/
$arr_worth_tbl = array('데스크탑','노트북','태블릿','스마트폰','기타');
$arr_worth_tbl['데스크탑'] = new stdClass();
$arr_worth_tbl['데스크탑']->A = 9200;
$arr_worth_tbl['데스크탑']->B = 4200;
$arr_worth_tbl['데스크탑']->C = 4200;
$arr_worth_tbl['데스크탑']->D = 2000;

$arr_worth_tbl['노트북'] = new stdClass();
$arr_worth_tbl['노트북']->A = 23200;
$arr_worth_tbl['노트북']->B = 13200;
$arr_worth_tbl['노트북']->C = 13200;
$arr_worth_tbl['노트북']->D = 2000;

$arr_worth_tbl['태블릿'] = new stdClass();
$arr_worth_tbl['태블릿']->A = 19200;
$arr_worth_tbl['태블릿']->B = 11200;
$arr_worth_tbl['태블릿']->C = 11200;
$arr_worth_tbl['태블릿']->D = 1000;

$arr_worth_tbl['스마트폰'] = new stdClass();
$arr_worth_tbl['스마트폰']->A = 33200;
$arr_worth_tbl['스마트폰']->B = 20200;
$arr_worth_tbl['스마트폰']->C = 20200;
$arr_worth_tbl['스마트폰']->D = 1000;

$arr_worth_tbl['기타'] = new stdClass();
$arr_worth_tbl['기타']->A = 0;
$arr_worth_tbl['기타']->B = 0;
$arr_worth_tbl['기타']->C = 0;
$arr_worth_tbl['기타']->D = 0;

$config['arr_worth_tbl'] = $arr_worth_tbl;














/* End of file tank_auth.php */
/* Location: ./application/config/tank_auth.php */