<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Article Module
 *
 * @author  yudiantara.gde@gmail.com
 * @package MaxCMS\Core\Modules\Article
 */

class Module_webcontent extends Module {

	public $version = '1.0.0';
	protected $upload_folder = array('default/files/webcontent');


	public function info() {

		$info = array(
			'name' => array(
				'en' => 'Web Content',
				'id' => 'Web Content'
			),

			'description' => array(
				'en' => 'Web Content Module for post list',
				'id' => 'Modul Web Content untuk menampilkan list post'
			),

			'frontend' 	=> true,
			'backend'  	=> true,
			'skip_xss' 	=> true,
			'menu' 		=> 'content',

			'roles' => array(
				'put_live', 'edit_live', 'delete_live'
			),

			'sections' => array(
				'webcontent'	=> array(
					'name'		=> 'webcontent:title',
					'uri'		=> ADMIN_URL.'/webcontent',
					'shortcuts'	=> array(
						array(
							'name'	=> 'webcontent:add',
							'uri'	=> ADMIN_URL.'/webcontent/create',
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
		$webcontent_fields = array(
        	'id'			=> array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
        	'title' 		=> array('type' => 'VARCHAR', 'constraint' => 255, 'unique' => true, 'null' => true),
        	'slug'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
        	'content'		=> array('type' => 'TEXT', 'null' => true),
        	'filename'		=> array('type' => 'TEXT', 'null' => true),
        	'path'			=> array('type' => 'TEXT', 'null' => true),
        	'full_path'		=> array('type' => 'TEXT', 'null' => true),
        	'status' 		=> array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
        	'created' 	 	=> array('type' => 'DATETIME', 'null' => true),
        	'updated' 	 	=> array('type' => 'DATETIME', 'null' => true),
        );

       

        return $this->install_tables(

        	array(
        		'webcontent'	=> $webcontent_fields,
			)
		);
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('product');
        

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
