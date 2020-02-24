<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @author  maxsolution.id
 * @package MaxCMS\Core\Modules\Article\Controllers\Admin_tags
 */
class Admin_categories extends Admin_Controller {

	protected $u_admin 		= 'admin_categories';
	protected $section 	= 'categories';

	protected $forms_validation = array(
    	'title'	=> array(
    		'field'	=> 'title',
    		'label'	=> 'lang:categories:title',
    		'rules'	=> 'trim|required|xss_clean|callback__check_title'
    	),

    	'slug'	=> array(
    		'field'	=> 'slug',
    		'label'	=> 'lang:categories:slug',
    		'rules'	=> 'trim|required|xss_clean|callback__check_slug'
    	),

    	'status' => array(
			'field' => 'status',
			'label' => 'lang:general:status_label',
			'rules' => 'trim|alpha'
		),

		'filename' => array(
			'field' => 'filename',
			'label' => 'lang:categories:icon',
			'rules' => 'trim|xss_clean'
		),

		'path' => array(
			'field'	=> 'path',
			'label'	=> 'lang:categories:path_label',
			'rules'	=> 'trim|xss_clean'
		),

		'full_path' => array(
			'field'	=> 'full_path',
			'label'	=> 'lang:categories:full_path_label',
			'rules'	=> 'trim|xss_clean'
		),

		'meta_keyword' => array(
			'field'	=> 'meta_keyword',
			'label'	=> 'lang:general:meta_keyword',
			'rules'	=> 'trim|xss_clean'
		),

		'meta_desc' => array(
			'field'	=> 'meta_desc',
			'label'	=> 'lang:general:meta_desc',
			'rules'	=> 'trim|xss_clean'
		),
		'order'	=> array(
			'field'	=> 'order',
			'label'	=> 'lang:kidsage:order',
			'rules'	=> 'trim|integer|xss_clean'
		),
    );

    public function __construct() {

		parent::__construct();

		$sect 			= $this->uri->segment(3);

		$this->load->model(array('article_m'));
		$this->lang->load(array('categories', 'general', 'kidsage', 'comments', 'article','livetv', 'ads', 'subscribe', 'banner', 'ikutserta'));
		$this->load->library('upload');

		$list_kidsage = array();

		foreach ($this->article_m->get_many_kidsage(array('status'=>'live')) as $key => $row) {
			$list_kidsage[$key] = array(
				'id' => $row->kidsage_id,
				'title' => $row->title,
			);
	   	}

		$this->template
			 ->set('list_kidsage', $list_kidsage)
			 ->set('u_admin', $this->u_admin);

	}

	public function index() {

		$base_where = array('status' => 'all');

		if ($this->input->post('f_status')) {

			$base_where['status'] = $this->input->post('f_status');
		}

		if ($this->input->post('f_keywords')) {

			$base_where['keywords'] = $this->input->post('f_keywords');
		}

		$total_rows = $this->article_m->count_category($base_where);
		$pagination = create_pagination(ADMIN_URL.'/article/'.$this->u_admin.'/index', $total_rows, Settings::get('records_per_page'),5);
		$data_ 		= $this->article_m
						   ->limit($pagination['limit'], $pagination['offset'])
						   ->get_many_category($base_where);

		$this->input->is_ajax_request() and $this->template->set_layout(false);

		$this->template
			->title($this->module_details['name'])
			->append_js('admin/filter.js')
			->set_partial('filters', 'admin/category/partials/filters')
			->set('pagination', $pagination)
			->set('data_', $data_);

			$this->input->is_ajax_request()
			? $this->template->build('admin/category/tables/table')
			: $this->template->build('admin/category/index');
	}

	public function create() {
		$rules 	= array_merge($this->forms_validation);
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run()) {
			if ($this->input->post('status') == 'live') {
				role_or_die('article_categories', 'put_live');
				$hash = "";
			}

			$extra = array(
				'title'			=> $this->input->post('title'),
				'slug'			=> $this->input->post('slug'),
				'status'        => $this->input->post('status'),
				'meta_keyword'	=> $this->input->post('meta_keyword'),
				'meta_desc'		=> $this->input->post('meta_desc'),
				'order'			=> ($this->input->post('order')) ? $this->input->post('order') : null,
				'kidsage_id'	=> implode(',',$this->input->post('kidsage_id')),
			);

			if ($id = $this->article_m->insert_data('article_categories', $extra)) {

				if($_FILES['icon']['name']!=''){
					$this->upload->initialize($this->set_upload_options($_FILES['icon'], $id));
					if($this->upload->do_upload('icon')){
						$data = $this->upload->data();
						$new_data = array(
	                		'filename' 	=> $data['file_name'],
	                		'path'		=> 'uploads/default/files/article_categories/'.$id.'/',
	                		'full_path'	=> 'uploads/default/files/article_categories/'.$id.'/'.$data['file_name'],
	                	);

	                	$this->article_m->update_data('article_categories', $new_data, 'categories_id', $id);

					}else{
						$errors = $this->upload->display_errors();
						$this->session->set_flashdata('error', $errors);
					}
				}

                $this->session->set_flashdata(array('success' => sprintf(lang('general:add_success'), $this->input->post('title'))));

      		}else {

				$this->session->set_flashdata('error', lang('general:post_add_error'));
			}
			($this->input->post('btnAction') == 'save_exit') ? redirect(ADMIN_URL.'/article/'.$this->u_admin) : redirect(ADMIN_URL.'/article/'.$this->u_admin.'/edit/'.$id);

		}else {
			$data_ = array();
			foreach ($this->forms_validation as $key => $field) {
				$data_[$field['field']] = set_value($field['field']);
			}
			$data_ = (object)$data_;
		}

       $this->template
			->title($this->module_details['name'], lang('kidsage:title'))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->append_js('module::dago_gallery_form.js')
			->append_js('jquery/jquery.tagsinput.js')
			->append_css('jquery/jquery.tagsinput.css')
			->set('data_', $data_)
            ->build('admin/category/form');
	}

	public function edit($id = 0) {
		$id or redirect(ADMIN_URL.'/article/'.$this->u_admin);
		$data_ = $this->article_m->get_single_data('categories_id', $id, 'article_categories');

		if(! ($data_)) {
			redirect(ADMIN_URL.'/article/'.$this->u_admin);
		}

		$article_validation = array_merge($this->forms_validation, array(
			'title'	=> array(
	    		'field'	=> 'title',
	    		'label'	=> 'lang:article:title',
	    		'rules'	=> 'trim|required|xss_clean|callback__check_title['.$id.']'
	    	),

	    	'slug'	=> array(
	    		'field'	=> 'slug',
	    		'label'	=> 'lang:article:slug',
	    		'rules'	=> 'trim|required|xss_clean|callback__check_slug['.$id.']'
	    	),
		));

		$rules 	= array_merge($this->forms_validation, $article_validation);
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run()) {
			$extra = array(
				'title'			=> $this->input->post('title'),
				'slug'			=> $this->input->post('slug'),
				'status'        => $this->input->post('status'),
				'meta_keyword'	=> $this->input->post('meta_keyword'),
				'meta_desc'		=> $this->input->post('meta_desc'),
				'order'			=> ($this->input->post('order')) ? $this->input->post('order') : null,
				'kidsage_id'	=> implode(',',$this->input->post('kidsage_id')),
			);

			if ($this->article_m->update_data('article_categories', $extra, 'categories_id', $id)) {

				if($_FILES['icon']['name']!=''){
					$this->upload->initialize($this->set_upload_options($_FILES['icon'], $id));
					if($this->upload->do_upload('icon')){
						$data = $this->upload->data();
						$new_data = array(
	                		'filename' 	=> $data['file_name'],
	                		'path'		=> 'uploads/default/files/article_categories/'.$id.'/',
	                		'full_path'	=> 'uploads/default/files/article_categories/'.$id.'/'.$data['file_name'],
	                	);

	                	$this->article_m->update_data('article_categories', $new_data, 'categories_id', $id);

					}else{
						$errors = $this->upload->display_errors();
						$this->session->set_flashdata('error', $errors);
					}
				}

				$this->session->set_flashdata(array('success' => sprintf(lang('general:edit_success'), $this->input->post('title'))));
                $this->session->unset_userdata('upload');
			}
			else
			{
				$this->session->set_flashdata('error', lang('general:edit_error'));
			}

			($this->input->post('btnAction') == 'save_exit') ? redirect(ADMIN_URL.'/article/'.$this->u_admin) : redirect(ADMIN_URL.'/article/'.$this->u_admin.'/edit/'.$id);
		}

		foreach ($this->form_validation->set_rules($rules) as $key => $field) {
			if (isset($_POST[$field['field']])) {
				$data_->$field['field'] = set_value($field['field']);
			}
		}

		$this->template
			->title($this->module_details['name'], lang('kidsage:title'))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->append_js('module::dago_gallery_form.js')
			->append_js('jquery/jquery.tagsinput.js')
			->append_css('jquery/jquery.tagsinput.css')
			->set('data_', $data_)
            ->build('admin/category/form');
	}

	public function action() {
		switch ($this->input->post('btnAction')) {
			case 'publish':
				$this->publish();
				break;
			case 'delete':
				$this->delete();
				break;
			default:
				redirect(ADMIN_URL.'/article/'.$this->u_admin);
				break;
		}
	}

	public function delete($id = 0) {
		role_or_die('article_m', 'delete_live');
		$ids = ($id = $this->input->post('id')) ? array($id) : $this->input->post('action_to');
		$post_titles = array();
		$deleted_ids = array();

        if ( ! empty($ids)) {
			foreach ($ids as $id) {
				if ($post = $this->article_m->get_single_data('categories_id', $id, 'article_categories')) {
                    $this->article_m->delete_data('article_categories', 'categories_id', $id);
                    $this->maxcache->delete('article_m');
					$post_titles[] = $post->title;
					$deleted_ids[] = $id;

				}
			}

			Events::trigger('post_deleted', $deleted_ids);
		}

		if ( ! empty($post_titles)) {
			if (count($post_titles) == 1) {
				$this->session->set_flashdata('success', sprintf($this->lang->line('general:delete_success'), $post_titles[0]));
			}else {
				$this->session->set_flashdata('success', sprintf($this->lang->line('general:mass_delete_success'), implode('", "', $post_titles)));
			}
		}else {
			$this->session->set_flashdata('error', lang('general:delete_error'));
		}

		redirect(ADMIN_URL.'/article/'.$this->u_admin);
	}

	public function publish($id = 0) {
		role_or_die('article_m', 'put_live');
		$ids = ($id) ? array($id) : $this->input->post('action_to');
		$post_titles = array();

		if ( ! empty($ids)) {
			foreach ($ids as $id) {
				if ($post = $this->article_m->get_single_data('categories_id', $id, 'article_categories')) {
					$this->article_m->publish_data('article_categories', 'categories_id', $id);
					$this->maxcache->delete('article_m');
					$post_titles[] = $post->title;
				}
			}
		}

		if ( ! empty($post_titles)) {
			if (count($post_titles) == 1) {
				$this->session->set_flashdata('success', sprintf($this->lang->line('general:publish_success'), $post_titles[0]));
			} else {
				$this->session->set_flashdata('success', sprintf($this->lang->line('general:mass_publish_success'), implode('", "', $post_titles)));
			}
		} else {
			$this->session->set_flashdata('error', $this->lang->line('general:publish_error'));
		}

		redirect(ADMIN_URL.'/article/'.$this->u_admin);
	}

	private function set_upload_options($file, $id) {
		$new_path = '/uploads/default/files/article_categories/'.$id.'/';
		if(!is_dir(getcwd().$new_path)) {
			mkdir(getcwd().$new_path,0775,true);
		}

	    $judul = $this->img_slug($this->input->post('title',TRUE));
		$config = array(
            'allowed_types' 	=> 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG',
            'max_size'			=> '60000',
            'max_width'			=> '2000',
            'max_height'		=> '2000',
            'upload_path' 		=> getcwd().$new_path,
            'overwrite'			=> TRUE,
            'file_name'			=> $judul.'_'.$id.'_'.$file['name'],
        );

	    return $config;
	}

	private function img_slug($str) {
		$str = preg_replace('~[^\pL\d]+~u', '-', $str);
		$str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
		$str = preg_replace('~[^-\w]+~', '', $str);
		$str = trim($str, '-');
		$str = preg_replace('~-+~', '-', $str);
		$str = strtolower($str);

		if (empty($str)) {
			return 'n-a';
		}

		return $str;
    }

    public function _check_title($title, $id=0) {
		$this->form_validation->set_message('_check_title', sprintf(lang('categories:already_exist_error'), lang('global:title')));

		return $this->article_m->check_exists('article_categories', array('title'=>$title, 'categories_id'=>$id));
	}

	public function _check_slug($slug, $id=0) {
		$this->form_validation->set_message('_check_slug', sprintf(lang('categories:already_exist_error'), lang('global:slug')));

		return $this->article_m->check_exists('article_categories', array('slug'=>$slug, 'categories_id'=>$id));
	}
}
