<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/*
// 컨텐츠 페이지 ctntpage
$route['C/(:any)/(:any)'] = "cms/C/$1/$2";    //   /C/P0014/인사말
$route['C/(:any)/(:any)/(:any)'] = "cms/C/$1/$2/$3";
$route['C/(:any)/(:any)/(:any)/(:any)'] = "cms/C/$1/$2/$3/$4";


// HTML 페이지 htmlpage
$route['H/(:any)/(:any)'] = "cms/H/$1/$2";   //   /H/P0028/소개페이지-하나
$route['H/(:any)/(:any)/(:any)'] = "cms/H/$1/$2/$3";
$route['H/(:any)/(:any)/(:any)/(:any)'] = "cms/H/$1/$2/$3/$4";


// 랜딩 페이지 landpage
$route['L/(:any)/(:any)'] = "cms/L/$1/$2";
$route['L/(:any)/(:any)/(:any)'] = "cms/L/$1/$2/$3";
$route['L/(:any)/(:any)/(:any)/(:any)'] = "cms/L/$1/$2/$3/$4";


// 게시판
$route['B/(:any)'] = "boardcms/$1";
$route['B/(:any)/(:any)'] = "boardcms/$1/$2";
$route['B/(:any)/(:any)/(:any)'] = "boardcms/$1/$2/$3";
$route['B/(:any)/(:any)/(:any)/(:any)'] = "boardcms/$1/$2/$3/$4";
$route['B/(:any)/(:any)/(:any)/(:any)/(:any)'] = "boardcms/$1/$2/$3/$4/$5";
$route['B/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = "boardcms/$1/$2/$3/$4/$5/$6/$7/$8";
$route['B/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = "boardcms/$1/$2/$3/$4/$5/$6/$7/$8";
$route['B/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = "boardcms/$1/$2/$3/$4/$5/$6/$7/$8";
*/



$route['sell'] = 'sell_landing/index';
$route['sell/pickup'] = 'sell_landing/pickup';
$route['sell/save-devices'] = 'sell_landing/save_devices';
$route['sell/submit'] = 'sell_landing/submit';

$route['mypage'] = 'buyback_mypage/index';
$route['mypage/main'] = 'buyback_mypage/main';
$route['mypage/buyback'] = 'buyback_mypage/buyback/lists';
$route['mypage/buyback/(:any)'] = 'buyback_mypage/buyback/$1';
$route['mypage/buyback/(:any)/(:num)'] = 'buyback_mypage/buyback/$1/$2';
$route['mypage/user'] = 'buyback_mypage/user/edit';
$route['mypage/user/edit'] = 'buyback_mypage/user/edit';
$route['mypage/donation'] = 'buyback_mypage/donation';
$route['mypage/donation/(:any)'] = 'buyback_mypage/donation/$1';
$route['mypage/donation/(:any)/(:any)'] = 'buyback_mypage/donation/$1/$2';
$route['mypage/donation/(:any)/(:any)/(:any)'] = 'buyback_mypage/donation/$1/$2/$3';
$route['mypage/campaign'] = 'buyback_mypage/campaign';
$route['mypage/campaign/(:any)'] = 'buyback_mypage/campaign/$1';
$route['mypage/campaign/(:any)/(:any)'] = 'buyback_mypage/campaign/$1/$2';
$route['mypage/campaign/(:any)/(:any)/(:any)'] = 'buyback_mypage/campaign/$1/$2/$3';

$route['partner'] = 'main/index';
$route['partner/([a-z0-9-]+)'] = 'partner/partner_sell/index/$1';
$route['partner/([a-z0-9-]+)/sell'] = 'partner/partner_sell/index/$1';
$route['partner/([a-z0-9-]+)/sell/pickup'] = 'partner/partner_sell/pickup/$1';
$route['partner/([a-z0-9-]+)/sell/save-devices'] = 'partner/partner_sell/save_devices/$1';
$route['partner/([a-z0-9-]+)/sell/submit'] = 'partner/partner_sell/submit/$1';

$route['partner/([a-z0-9-]+)/login'] = 'partner/member_auth/login/$1';
$route['partner/([a-z0-9-]+)/login/(:any)'] = 'partner/member_auth/login/$1/$2';
$route['partner/([a-z0-9-]+)/logout'] = 'partner/member_auth/logout/$1';

$route['partner/([a-z0-9-]+)/admin/login'] = 'partner/admin/partner_auth/login/$1';
$route['partner/([a-z0-9-]+)/admin/login/(:any)'] = 'partner/admin/partner_auth/login/$1/$2';
$route['partner/([a-z0-9-]+)/admin/logout'] = 'partner/admin/partner_auth/logout/$1';
$route['partner/([a-z0-9-]+)/admin'] = 'partner/admin/partner_buyback/index/$1';
$route['partner/([a-z0-9-]+)/admin/buyback'] = 'partner/admin/partner_buyback/index/$1';
$route['partner/([a-z0-9-]+)/admin/buyback/view/(:num)'] = 'partner/admin/partner_buyback/view/$1/$2';
$route['partner/([a-z0-9-]+)/admin/buyback/send/(:num)'] = 'partner/admin/partner_buyback/send/$1/$2';
$route['partner/([a-z0-9-]+)/admin/buyback/delete/(:num)'] = 'partner/admin/partner_buyback/delete/$1/$2';

$route['admin/buyback'] = 'admin/buyback/index';
$route['admin/buyback/delete/(:num)'] = 'admin/buyback/delete/$1';
