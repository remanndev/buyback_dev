<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

/**
 * pre_controller 컨트롤러가 호출되기 직전입니다. 모든 기반클래스(base classes), 라우팅 그리고 보안점검이 완료된 상태입니다.
 */
$hook['pre_controller '] = array(
	'class'    => '_Common',
	'function' => 'pre',
	'filename' => 'Common.php',
	'filepath' => 'hooks'
);


/**
 * post_controller_constructor 컨트롤러가 인스턴스화 된 직후입니다.즉 사용준비가 완료된 상태가 되겠죠. 하지만, 인스턴스화 된 후 메소드들이 호출되기 직전입니다.
 */
$hook['post_controller_constructor'] = array(
	'class'    => '_Common',
	'function' => 'post',
	'filename' => 'Common.php',
	'filepath' => 'hooks'
);
