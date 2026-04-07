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



$route['sell'] = 'sell/index';
$route['sell/pickup'] = 'sell/pickup';
$route['sell/save-devices'] = 'sell/save_devices';
$route['sell/submit'] = 'sell/submit';

$route['admin/buyback'] = 'admin/buyback/index';
$route['admin/buyback/delete/(:num)'] = 'admin/buyback/delete/$1';
