<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";

/*
$config['protocol']    = 'smtp';
$config['smtp_host']    = 'smtp.gmail.com';
$config['smtp_port']    = '587';
$config['smtp_crypto']    = 'tls';
$config['smtp_user']    = 'incoreain@gmail.com';
$config['smtp_pass']    = 'kyqouyjoogjbnwel';
$config['charset']    = 'utf-8';
$config['newline']    = "\r\n";
$config['mailtype'] = 'html'; // or text
$config['validation'] = TRUE; // bool whether to validate email or not      
*/


/*
// [샘플] 지메일
$config['protocol']    = 'smtp';
$config['smtp_host']    = 'smtp.gmail.com';
$config['smtp_port']    = '25';
$config['smtp_crypto']    = 'tls';
$config['smtp_user']    = 'ipmiracle1@gmail.com';
$config['smtp_pass']    = 'fapo flob hisn ymml';
*/

// [2023-11-28] 네이버 메일
$config['protocol']    = 'smtp';
$config['smtp_host']    = 'smtp.naver.com';
$config['smtp_port']    = '587';
$config['smtp_crypto']    = 'tls';
$config['smtp_user']    = 'replus_digitalgive';
//$config['smtp_pass']    = 'remann7297!!';
$config['smtp_pass']    = 'TXGQLD84E8X9'; // 2단계 인증 기기 설정 후, 애플리케이션 비밀번호를 생성해야 함.g



/* End of file email.php */
/* Location: ./application/config/email.php */