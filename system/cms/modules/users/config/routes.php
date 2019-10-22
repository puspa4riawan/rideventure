<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// Admin Routes
$route['users/admin/login_log(/:any)?']		= 'admin_loginlog$1';
$route['users/admin/register_log(/:any)?']		= 'admin_registerlog$1';
$route['users/admin/count(/:any)?']		= 'admin_count$1';

$route['users/admin/fields(/:any)?']		= 'admin_fields$1';
$route['users/api(/:any)?']        = 'api$1';