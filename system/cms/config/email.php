<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* -- Hear ye, hear ye --

The email settings are now taking place in
libraries/My_Email.php Most (or all) of the ones you
need to worry about are editable from the
settings page of the admin panel.

This public service announcement was sponsored in
part by www.unruhdesigns.com  :)
*/

$config['mail_host'] 				= Settings::get('mail_host') ? Settings::get('mail_host') : 'smtp.mandrillapp.com';
$config['mail_port'] 				= (Settings::get('mail_port')) ? Settings::get('mail_port') : '587';
$config['mail_from_address'] 		= (Settings::get('mail_from_address')) ? Settings::get('mail_from_address') : 'donotreply@parentingclub.id';
$config['mail_from_name'] 			= (Settings::get('mail_from_name')) ? Settings::get('mail_from_name') : 'Parenting Club';
$config['mail_username'] 			= (Settings::get('mail_username')) ? Settings::get('mail_username') : 'Ogilvy Wyeth Parenting Club';
$config['mail_password'] 			= (Settings::get('mail_password')) ? Settings::get('mail_password') : 'sFrTM1WvtL8Jli2cYdIblQ';
$config['mail_encryption'] 			= (Settings::get('mail_encryption')) ? Settings::get('mail_encryption') : 'tls';
$config['mail_verify_peer'] 		= false;
$config['mail_verify_peer_name'] 	= false;
$config['mail_allow_self_signed'] 	= true;