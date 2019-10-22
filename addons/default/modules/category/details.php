<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Article Module
 *
 * @author  yudiantara.gde@gmail.com
 * @package MaxCMS\Core\Modules\Article
 */

class Module_category extends Module {

	public $version = '1.0.0';
	protected $upload_folder = array('default/files/category');

	public function info() {

		$info = array(

			'name' => array(
				'en' => 'Category',
				'id' => 'Kategori'
			),

			'description' => array(
				'en' => 'Category Module for post list',
				'id' => 'Kategori untuk menampilkan list post'
			),

			'frontend' 	=> true,
			'backend'  	=> true,
			'skip_xss' 	=> true,
			'menu' 		=> 'content',

			'roles' => array(
				'put_live', 'edit_live', 'delete_live'
			),

			'sections' => array(
				'category'		=> array(
					'name'		=> 'category:title',
					'uri'		=> ADMIN_URL.'/category/admin_category',
					'shortcuts'	=> array(
						array(
							'name'	=> 'category:add',
							'uri'	=> ADMIN_URL.'/category/admin_category/create',
							'class'	=> 'add',
						)
					)
				)
			)
		);

		return $info;
	}

	public function install()
	{
		$category_fields = array(
        	'id'	          	=> array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
        	'name' 			=> array('type' => 'VARCHAR', 'constraint' => 255, 'unique' => true, 'null' => true),
            'slug'          	=> array('type' => 'VARCHAR', 'constraint' => 255, 'unique' => true, 'null' => true),
            'description'   	=> array('type' => 'TEXT', 'null' => true),
            'filename'      	=> array('type' => 'TEXT', 'null' => true),
            'filename_mobile' 	=> array('type' => 'TEXT', 'null' => true),
            'path'          	=> array('type' => 'TEXT', 'null' => true),
            'full_path'    	 	=> array('type' => 'TEXT', 'null' => true),
        	'status' 			=> array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
			'created' 	 		=> array('type' => 'DATETIME', 'null' => true),
            'created_by'    	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
            'updated'       	=> array('type' => 'DATETIME', 'null' => true),
            'updated_by'    	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true)
        );

        

        return $this->install_tables(

        	array(
        		'category'	=> $category_fields
            )
        		
		);
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('category');
        

        $this->remove_upload_dir($this->upload_folder);

		$this->load->helper("file");

		

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
