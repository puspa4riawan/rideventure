<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Article Module
 *
 * @author  yudiantara.gde@gmail.com
 * @package MaxCMS\Core\Modules\Article
 */

class Module_companymember extends Module {

	public $version = '1.0.0';
	protected $upload_folder = array('default/files/companymember');


	public function info() {

		$info = array(
			'name' => array(
				'en' => 'Company member',
				'id' => 'Company member'
			),

			'description' => array(
				'en' => 'Company member Module for post list',
				'id' => 'Modul Company member untuk menampilkan list post'
			),

			'frontend' 	=> true,
			'backend'  	=> true,
			'skip_xss' 	=> true,
			'menu' 		=> 'content',

			'roles' => array(
				'put_live', 'edit_live', 'delete_live'
			),

			'sections' => array(
				'companymember'	=> array(
					'name'		=> 'companymember:title',
					'uri'		=> ADMIN_URL.'/companymember',
					'shortcuts'	=> array(
						array(
							'name'	=> 'companymember:add',
							'uri'	=> ADMIN_URL.'/companymember/create',
							'class'	=> 'add',
						),
					),
				),
			),
		);

		return $info;
	}

	public function install()
	{
		$companymember_fields = array(
        	'id'			=> array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
        	'name' 			=> array('type' => 'VARCHAR', 'constraint' => 255, 'unique' => true, 'null' => true),
        	'position'		=> array('type' => 'VARCHAR', 'constraint' => 255, 'unique' => true, 'null' => true),
        	'address'		=> array('type' => 'TEXT', 'null' => true),
        	'phone'			=> array('type' => 'VARCHAR', 'constraint' => 50, 'unique' => true, 'null' => true),
        	'email'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'unique' => true, 'null' => true),
        	'self_desc'		=> array('type' => 'TEXT', 'null' => true),
        	'filename'		=> array('type' => 'TEXT', 'null' => true),
        	'path'			=> array('type' => 'TEXT', 'null' => true),
        	'full_path'		=> array('type' => 'TEXT', 'null' => true),
        	'status' 		=> array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
        	'created' 	 	=> array('type' => 'DATETIME', 'null' => true),
        	'updated' 	 	=> array('type' => 'DATETIME', 'null' => true),
        );

       

        return $this->install_tables(

        	array(
        		'companymember'	=> $companymember_fields,
			)
		);
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('companymember');
        

        $this->remove_upload_dir($this->upload_folder);
		$this->load->helper("file");

		//delete category folder and files
		/*if (is_dir('uploads/article_categories')) {
			$categories_files = glob('./uploads/article_categories/*');
			if(count($categories_files) > 0) {
				foreach($categories_files as $file){
					if(is_file($file))
				 	unlink($file);
				}

				delete_files('./uploads/article_categories/', true);
			}
			rmdir('./uploads/article_categories');
		}*/

		return true;
	}

	public function upgrade($old_version)
	{
		return true;
	}

	// RMDIR in uploads folder
	private function remove_upload_dir($foldernames = array()){
		// load the helper
		$this->load->helper("file");

		if($foldernames){
			foreach($foldernames as $foldername){
				//delete folder and files
				if (is_dir('uploads/'.$foldername)) {
					$files = glob('./uploads/'.$foldername.'/*');
					if(count($files) > 0) {
						foreach($files as $file){
							if(is_file($file))
						 	unlink($file);
						}

						delete_files('./uploads/'.$foldername.'/', true);
					}
					rmdir('./uploads/'.$foldername);
				}
			}
		}
	}
}
