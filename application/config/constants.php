<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code






/*
|--------------------------------------------------------------------------
| 사용장 정의 기본 상수
|--------------------------------------------------------------------------
|
| [유용하지만 잘 사용되지 않는 CI 상수들]
|
| EXT: PHP 확장자
| FCPATH: index.php가 위치한 realpath
| SELF: 현제 실행중인 PHP 파일명 (CI는 무조건 index.php)
| BASEPATH: CI system이 위치한 realpath
| APPPATH: CI application이 위치한 realpath
|--------------------------------------------------------------------------
|
*/



/** 도메인 */
define('HTTP_HOST', $_SERVER['HTTP_HOST']);
define('BASEURL', ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http")."://".HTTP_HOST);
define('REQUEST_URI', $_SERVER['REQUEST_URI']);
define('PHP_SELF', $_SERVER['PHP_SELF']);
define('SEG_STRING', str_replace('/index.php','',PHP_SELF));
define('QUERY_STRING', $_SERVER['QUERY_STRING']);

/*
- - - - - - - - - - - - - - - - - - - - - - - - - - - 
[http://basic.openuri.net/welcome?i=123]
- - - - - - - - - - - - - - - - - - - - - - - - - - - 
- - - - - - - - - - - - - - - - - - - - - - - - - - - 
[HTTP_HOST] basic.openuri.net
- - - - - - - - - - - - - - - - - - - - - - - - - - - 
[BASEURL] http://basic.openuri.net
- - - - - - - - - - - - - - - - - - - - - - - - - - - 
[REQUEST_URI] /welcome?i=123
- - - - - - - - - - - - - - - - - - - - - - - - - - - 
[PHP_SELF] /index.php/welcome
- - - - - - - - - - - - - - - - - - - - - - - - - - - 
[SEG_STRING] /welcome
- - - - - - - - - - - - - - - - - - - - - - - - - - - 
[QUERY_STRING] i=123
- - - - - - - - - - - - - - - - - - - - - - - - - - - 
*/

/* 이전 경로값 */
//define('HTTP_REFERER', $_SERVER['HTTP_REFERER']);





/** 절대경로 */
define('RT_PATH'    , realpath(FCPATH));
define('DATA_PATH'  , RT_PATH.'/data');
define('ASSETS_PATH', RT_PATH.'/assets');
define('CSS_PATH'   , ASSETS_PATH.'/css');
define('JS_PATH'    , ASSETS_PATH.'/js');
define('IMG_PATH'   , ASSETS_PATH.'/images');
define('LIB_PATH'   , ASSETS_PATH.'/lib');


/** 상대경로 */
define('RT_DIR'     , '');
define('DATA_DIR'   , RT_DIR.'/data');
define('ASSETS_DIR' , RT_DIR.'/assets');
define('CSS_DIR'    , ASSETS_DIR.'/css');
define('JS_DIR'     , ASSETS_DIR.'/js');
define('IMG_DIR'    , ASSETS_DIR.'/images');
define('LIB_DIR'    , ASSETS_DIR.'/lib');


/** 시간 */
define('TIME_STAMP', time());
define('TIME_YMD', date('Y-m-d', TIME_STAMP));
define('TIME_HIS', date('H:i:s', TIME_STAMP));
define('TIME_YMDHIS', date('Y-m-d H:i:s', TIME_STAMP));


/** REMOTE_ADDR */
if ( function_exists( 'apache_request_headers' ) ) :
	$headers = apache_request_headers();
else :
	$headers = $_SERVER;
endif;

//Get the forwarded IP if it exists
if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) :
	$the_ip = $headers['X-Forwarded-For'];
elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) :
	$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
else :
	$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
endif;

define('REMOTE_ADDR', $the_ip);

/** 게시판 pre */
define('BBS_PRE', 'bbs_');

