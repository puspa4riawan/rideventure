<?php  defined('BASEPATH') or exit('No direct script access allowed');

// admin
$route['article/admin/admin_article(/:any)?']		= 'admin_article$1';
$route['article/admin/admin_categories(/:any)?']	= 'admin_categories$1';
$route['article/admin(/:any)?'] 					= 'admin_article$1';


