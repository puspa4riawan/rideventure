<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Landing Module
 *
 * @package MaxCMS\Core\Modules\Landing
 */

class Module_landing extends Module {

	public $version = '1.0.0';

	public function info() {

		$info = array(
			'name' => array(
				'en' => 'Landing',
				'id' => 'Landing'
			),

			'description' => array(
				'en' => 'Landing Module',
				'id' => 'Landing Module'
			),

			'frontend' 	=> true,
			'backend'  	=> true,
			'skip_xss' 	=> true,
			'menu' 		=> 'content',

			'roles' => array(
				'put_live', 'edit_live', 'delete_live'
			),

			'sections' => array(
			)
		);

		return $info;
	}

	public function install()
	{
		return true;
	}

	public function uninstall()
	{
		return true;
	}

	public function upgrade($old_version)
	{
		return true;
	}
}
