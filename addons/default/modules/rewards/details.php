<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Article Module
 *
 * @author  yudiantara.gde@gmail.com
 * @package MaxCMS\Core\Modules\Article
 */

class Module_rewards extends Module {

	public $version = '1.0.0';
	protected $upload_folder = array('default/files/rewards');

	public function info() {

		$info = array(

			'name' => array(
				'en' => 'Rewards',
				'id' => 'Hadiah'
			),

			'description' => array(
				'en' => 'Rewards Module for post list',
				'id' => 'Hadiah Artikel untuk menampilkan list post'
			),

			'frontend' 	=> true,
			'backend'  	=> true,
			'skip_xss' 	=> true,
			'menu' 		=> 'content',

			'roles' => array(
				'put_live', 'edit_live', 'delete_live'
			),

			'sections' => array(
				'rewards'		=> array(
					'name'		=> 'rewards:title',
					'uri'		=> ADMIN_URL.'/rewards/admin_rewards',
					'shortcuts'	=> array(
						array(
							'name'	=> 'rewards:add',
							'uri'	=> ADMIN_URL.'/rewards/admin_rewards/create',
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
		$rewards_fields = array(
        	'id'	          	=> array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
        	'title' 			=> array('type' => 'VARCHAR', 'constraint' => 255, 'unique' => true, 'null' => true),
            'slug'          	=> array('type' => 'VARCHAR', 'constraint' => 255, 'unique' => true, 'null' => true),
            'description'   	=> array('type' => 'TEXT', 'null' => true),
            'filename'      	=> array('type' => 'TEXT', 'null' => true),
            'filename_mobile' 	=> array('type' => 'TEXT', 'null' => true),
            'path'          	=> array('type' => 'TEXT', 'null' => true),
            'full_path'    	 	=> array('type' => 'TEXT', 'null' => true),
            'show_percentage'   => array('type' => 'INT', 'constraint' => 11),
        	'status' 			=> array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
			'created' 	 		=> array('type' => 'DATETIME', 'null' => true),
            'created_by'    	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
            'updated'       	=> array('type' => 'DATETIME', 'null' => true),
            'updated_by'    	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true)
        );

        

        return $this->install_tables(

        	array(
        		'rewards'	=> $rewards_fields
            )
        		
		);
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('rewards');
        

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
