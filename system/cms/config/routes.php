<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller']                = 'landing/home';
$route['404_override']                      = 'landing/home/page_404';

if(ADMIN_URL !='admin')
{
	$route['admin(/:any)?'] ='404';
}

//api routes
$route['api/([a-zA-Z0-9_-]+)/(:any)'] = '$1/api/$2';

$route[ADMIN_URL.'(/)?'] = 'admin/index';
$route[ADMIN_URL.'/(login|logout|remove_installer_directory|index)']			    = 'admin/$1';
$route[ADMIN_URL.'/help/([a-zA-Z0-9_-]+)']       	= 'admin/help/$1';
$route[ADMIN_URL.'/([a-zA-Z0-9_-]+)/(:any)']	    = '$1/admin/$2';
$route[ADMIN_URL.'/([a-zA-Z0-9_-]+)']            	= '$1/admin/index';

$route['loginsoo'] = 'users/login_register_sso';
$route['redirect'] = 'users/callback';

$route['campaign(/:any)?']				= 'landing/home/index$1';
$route['campaign/subscriber']			= 'landing/home/subscriber';