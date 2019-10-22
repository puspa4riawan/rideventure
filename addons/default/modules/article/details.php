<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Article Module
 *
 * @author  yudiantara.gde@gmail.com
 * @package MaxCMS\Core\Modules\Article
 */

class Module_article extends Module {

	public $version = '1.0.0';
	protected $upload_folder = array('default/files/article','default/files/article_categories');

	public function info() {

		$info = array(
			'name' => array(
				'en' => 'Article',
				'id' => 'Artikel'
			),

			'description' => array(
				'en' => 'Article Module for post list',
				'id' => 'Modul Artikel untuk menampilkan list post'
			),

			'frontend' 	=> true,
			'backend'  	=> true,
			'skip_xss' 	=> true,
			'menu' 		=> 'content',

			'roles' => array(
				'put_live', 'edit_live', 'delete_live'
			),

			'sections' => array(
				'article'		=> array(
					'name'		=> 'articles:title',
					'uri'		=> ADMIN_URL.'/article/admin_article',
					'shortcuts'	=> array(
						array(
							'name'	=> 'articles:add',
							'uri'	=> ADMIN_URL.'/article/admin_article/create',
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
		$article_fields = array(
        	'article_id'	=> array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
        	'title' 		=> array('type' => 'VARCHAR', 'constraint' => 255, 'unique' => true, 'null' => true),
        	'slug'			=> array('type' => 'VARCHAR', 'constraint' => 255, 'unique' => true, 'null' => true),
        	'status' 		=> array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
        	'filename'		  => array('type' => 'TEXT', 'null' => true),
        	'filename_mobile' => array('type' => 'TEXT', 'null' => true),
        	'path'			=> array('type' => 'TEXT', 'null' => true),
        	'full_path'		=> array('type' => 'TEXT', 'null' => true),
        	'intro'			=> array('type' => 'TEXT', 'null' => true),
        	'description'	=> array('type' => 'TEXT', 'null' => true),
        	'categories_id'	=> array('type' => 'VARCHAR', 'constraint' => 200, 'null' => true),
        	'meta_title'	=> array('type' => 'TEXT', 'null' => true),
        	'meta_keyword'	=> array('type' => 'TEXT', 'null' => true),
        	'meta_desc'		=> array('type' => 'TEXT', 'null' => true),
        	'featured' 	 	=> array('type' => 'INT', 'constraint' => 1,'default' => '0'),
        	'created' 	 	=> array('type' => 'DATETIME', 'null' => true),
        	'updated' 	 	=> array('type' => 'DATETIME', 'null' => true),
			'created_on' 	=> array('type' => 'INT', 'null' => true),
			'altr_url'		=> array('type' => 'TEXT', 'null' => true),
			'campaign'		=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
        );

       

        return $this->install_tables(

        	array(
        		'article'				=> $article_fields,
			)
		);
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('article');
        

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
