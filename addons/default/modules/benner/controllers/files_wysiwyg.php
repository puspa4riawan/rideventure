<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Manages files selection and insertion for WYSIWYG editors
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\WYSIWYG\Controllers
 */
class Files_wysiwyg extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		// Not logged in or not an admin and don't have permission to see files
		if ( ! $this->current_user OR
			($this->current_user->group !== 'admin' AND 
			( ! isset($this->permissions['files']) OR
			  ! isset($this->permissions['files']['wysiwyg']))))
		{
			$this->load->language('files/files');
			show_error(lang('files:no_permissions'));
		}

		ci()->admin_theme = $this->theme_m->get_admin();

		// Using a bad slug? Weak
		if (empty($this->admin_theme->slug))
		{
			show_error('This site has been set to use an admin theme that does not exist.');
		}

		// Make a constant as this is used in a lot of places
		defined('ADMIN_THEME') or define('ADMIN_THEME', $this->admin_theme->slug);

		// Set the location of assets
		Asset::add_path('module', ADDONPATH.'modules/menu/');
		Asset::add_path('module_admin', APPPATH.'modules/wysiwyg/');
		Asset::add_path('theme', $this->admin_theme->web_path.'/');
		Asset::set_path('theme');

		$this->load->library('files/files');
		$this->lang->load('files/files');
		$this->lang->load('wysiwyg');
		$this->lang->load('buttons');

		$this->template
			->set_theme(ADMIN_THEME)
			->set_layout('wysiwyg', 'admin')
			->enable_parser(FALSE)
			->append_css('module_admin::wysiwyg.css')
			->append_css('jquery/ui-lightness/jquery-ui.css')
			->append_js('jquery/jquery.js')
			->append_js('jquery/jquery-ui.min.js')
			->append_js('plugins.js')
			->append_js('module::upload_image.js');	
	}

	public function index($id = 0)
	{
		$data->folders			= $this->file_folders_m->get_folders();
		$data->subfolders		= array();
		$data->current_folder	= $id && isset($data->folders[$id])
								? $data->folders[$id]
								: ($data->folders ? current($data->folders) : array());

		if ($data->current_folder)
		{
			$data->current_folder->items = $this->file_m
				->select('files.*, file_folders.location')
				->join('file_folders', 'file_folders.id = files.folder_id')
				->order_by('files.date_added', 'DESC')
				->get_many_by('files.folder_id', $data->current_folder->id);

			$subfolders = $this->file_folders_m->folder_tree($data->current_folder->id);

			foreach ($subfolders as $subfolder)
			{
				$data->subfolders[$subfolder->id] = repeater('&raquo; ', $subfolder->depth) . $subfolder->name;
			}

			// Set a default label
			$data->subfolders = $data->subfolders
				? array($data->current_folder->id => lang('files:root')) + $data->subfolders
				: array($data->current_folder->id => lang('files:no_subfolders'));
		}

		// Array for select
		$data->folders_tree = array();
		foreach ($data->folders as $folder)
		{
			$data->folders_tree[$folder->id] = repeater('&raquo; ', $folder->depth) . $folder->name;
		}

		$this->template
			->title('Files')
			->build('files/index', $data);
	}

	public function ajax_get_file()
	{
		$file = $this->file_m->get($this->input->post('file_id'));

		$folders = array();
		if ($folder_id = $this->input->post('folder_id'))
		{
			$folders = $this->file_folders_m->get_folder_path($folder_id);
		}

		$this->load->view('files/ajax_current', array(
			'file'		=> $file,
			'folders'	=> $folders
		));
	}
}