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
|	https://codeigniter.com/userguide3/general/routing.html
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

$route['apisettingsstatus/(:any)'] = 'Apisettingsstatus/index
/$1';

$route['editusers/(:any)'] = "Editusers/index/$1";

$route['kycapprove/(:any)'] = "Kycapprove/index/$1";

$route['download/(:any)/(:any)'] = "Download/index/$1/f";

$route['download/(:any)/(:any)'] = "Download/index/$1/b";

$route['download/(:any)/(:any)'] = "Download/index/$1/p";

$route['download/(:any)/(:any)'] = "Download/index/$1/ph";

$route['download/(:any)/(:any)'] = "Download/index/$1/pb";

$route['adduserstype/(:any)'] = "Adduserstype/index/$1";

$route['adduserstype/(:any)/(:any)'] = "Adduserstype/index/$1/del";

$route['addplans/(:any)'] = "Addplans/index/$1";

$route['addplans/(:any)/(:any)'] = "Addplans/index/del/$1";

$route['addservices/(:any)'] = "Addservices/index/$1";

$route['addservices/(:any)/(:any)'] = "Addservices/index/del/$1";

$route['default_controller'] = 'Userlogin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



//role route

// $route['role'] = "Role/index";
