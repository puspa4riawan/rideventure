<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @author  yudiantara.gde@gmail.com
 * @package MaxCMS\Core\Modules\Article\Controllers\Admin_article
 */
class Admin_article extends Admin_Controller {

	var $u_admin 		= 'admin_article';
	protected $section 	= 'article';

	protected $forms_validation = array(
    	'title'	=> array(
    		'field'	=> 'title',
    		'label'	=> 'lang:articles:title',
    		'rules'	=> 'trim|required|xss_clean|callback__check_title'
    	),

    	'slug'	=> array(
    		'field'	=> 'slug',
    		'label'	=> 'lang:articles:slug',
    		'rules'	=> 'trim|required|xss_clean|callback__check_slug'
    	),

    	'status' => array(
			'field' => 'status',
			'label' => 'lang:general:status_label',
			'rules' => 'trim|alpha'
		),

		'desc' => array(
			'field'	=> 'description',
			'label'	=> 'lang:general:desc_label',
			'rules'	=> 'trim'
		),

		'meta_title' => array(
			'field'	=> 'meta_title',
			'label'	=> 'Meta Title',
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

		'intro' => array(
			'field'	=> 'intro',
			'label'	=> 'lang:general:intro',
			'rules'	=> 'trim|xss_clean'
		),

		'categories_id' => array(
			'field'	=> 'categories_id',
			'label'	=> 'lang:categories:title',
			'rules'	=> ''
		),

		'campaign' => array(
			'field'	=> 'campaign',
			'label'	=> 'campaign',
			'rules'	=> ''
		),

    );

    public function __construct() {

		parent::__construct();

		$sect 			= $this->uri->segment(3);

		$this->load->model(array('article_m'));
		$this->lang->load(array('general', 'article','categories'));
		$this->load->libraries(array('upload'));

		// $categories = $this->article_m->get_all_data('article_kidsage');
		$category 	= $this->article_m->get_all_data('category');


		$_template = array(
			'no-image'			=>'Article without image',
			'thumb' 			=>'Article with thumbnail',
			'2-tile' 			=>'Article with merge tile',
			'gallery' 			=>'Article with gallery',
			// 'downloadable' 		=>'Article with downloadable item',
		);

		$_content_formats = array(
			'none'     => 'Select Format',
			'carousel' => 'Image Carousel',
			'banner'   => 'Banner',
			'youtube'  => 'Youtube Video URL',
			'video'    => 'Video'
		);

		$_bg_color = array(
			'red'			=>'Red',
			'yellow'		=>'Yellow',
		);

		$campaign = array(
			'milo' 		=> 'Milo',
			'koko'		=> 'Koko',
			'dancow'	=> 'Dancow'
		);

		

	   

		$this->template
			 ->append_css('module::main.css')
			 // ->set('opt_categories', $categories)
			 ->set('category', $category)
			 // ->set('opt_authors', $author)
			 ->set('u_admin', $this->u_admin)
			 ->set('bg_color', $_bg_color)
			 ->set('a_template', $_template)
			 ->set('campaign', $campaign)
			 ->set('_content_formats', $_content_formats);

	}

	public function index() {
		$base_where = array('status' => 'all');

		if ($this->input->post('f_status')) {
			$base_where['status'] = $this->input->post('f_status');
		}
		
		if ($this->input->post('f_filter')) {
			$base_where['filter'] = $this->input->post('f_filter');
		}

		if ($this->input->post('f_keywords')) {
			$base_where['keywords'] = $this->input->post('f_keywords');
		}

		// if ($this->input->post('f_authors')) {

		// 	$base_where['authors'] = $this->input->post('f_authors');
		// }

		if ($this->input->post('f_categories')) {
			$base_where['categories'] = $this->input->post('f_categories');
		}


		$total_rows = $this->article_m->count_articles($base_where);
		$pagination = create_pagination(ADMIN_URL.'/article/'.$this->u_admin.'/index', $total_rows, Settings::get('records_per_page'),5);
		$data_ 		= $this->article_m
						   ->limit($pagination['limit'], $pagination['offset'])
						   ->order_by('article_id', 'DESC')
						   ->get_many_articles($base_where);
		
		

		$this->input->is_ajax_request() and $this->template->set_layout(false);

		$this->template
			->title($this->module_details['name'])
			->append_js('admin/filter.js')
			->set_partial('filters', 'admin/article/partials/filters')
			->append_js('module::admin-article.js')
			->set('pagination', $pagination)
			->set('data_', $data_);

			$this->input->is_ajax_request()
			? $this->template->build('admin/article/tables/table')
			: $this->template->build('admin/article/index');
	}


	public function create() {
		date_default_timezone_set('Asia/Jakarta');
		$rules 	= array_merge($this->forms_validation);

		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run()) {
			if ($this->input->post('status') == 'live') {
				role_or_die('article/admin_article', 'put_live');
				$hash = "";
			}

			$created 		= date('Y-m-d H:i:s');
			$created_on 	= strtotime($created);
			$featured_kecil_hebat = 0;
			if($this->input->post('featured_kecil_hebat')){
				$featureds = array('yes'=>1,'no'=>0);
				$featured_kecil_hebat = isset($featureds[$this->input->post('featured_kecil_hebat')]) 
					? $featureds[$this->input->post('featured_kecil_hebat')] : '';
			}
			$extra = array(
				'title'			=> $this->input->post('title'),
				'slug'			=> $this->input->post('slug'),
				'status'        => $this->input->post('status'),
				'categories_id'	=> implode(',',$this->input->post('categories_id')),
				'description'	=> $this->input->post('description'),
				'meta_title'	=> $this->input->post('meta_title'),
				'meta_keyword'	=> $this->input->post('meta_keyword'),
				'meta_desc'		=> $this->input->post('meta_desc'),
				'featured'		=> 0,
				'altr_url'		=> $this->input->post('altr_url'),
				'campaign'		=> implode(',',$this->input->post('campaign')),
				'created'		=> $created,
				'created_on'	=> $created_on,
			);			

			$fname 			 	= $this->input->post('fname');
			$as_background 		= $this->input->post('as_background');

			if ($id = $this->article_m->insert_data('article', $extra)) {
				if($_FILES['thumb']['name']!=''){
					$this->upload->initialize($this->set_upload_options($_FILES['thumb'], $id));
					if($this->upload->do_upload('thumb')){
						$data = $this->upload->data();
						$new_data = array(
	                		'filename' 	=> $data['file_name'],
	                		'path'		=> 'uploads/default/files/article/'.$id.'/',
	                		'full_path'	=> 'uploads/default/files/article/'.$id.'/'.$data['file_name'],
	                	);

	                	$this->article_m->update_data('article', $new_data, 'article_id', $id);

					}else{
						$errors = $this->upload->display_errors();
						$this->session->set_flashdata('error', $errors);
					}
				}

				if ($_FILES['thumb_mobile']['name'] != '') {
					$this->upload->initialize($this->set_upload_options($_FILES['thumb_mobile'], $id));
					if ($this->upload->do_upload('thumb_mobile')) {
						$data = $this->upload->data();
						$new_data = array('filename_mobile' => $data['file_name']);
	                	$this->article_m->update_data('article', $new_data, 'article_id', $id);
					} else {
						$errors = $this->upload->display_errors();
						$this->session->set_flashdata('error', $errors);
					}
				}

				$files = $_FILES;
                

                $this->session->set_flashdata(array('success' => sprintf(lang('general:add_success'), $this->input->post('title'))));
                $this->session->unset_userdata('upload');

      		} else {
				$this->session->set_flashdata('error', lang('general:post_add_error'));
			}

			($this->input->post('btnAction') == 'save_exit') ? redirect(ADMIN_URL.'/article/'.$this->u_admin) : redirect(ADMIN_URL.'/article/'.$this->u_admin.'/edit/'.$id);

		}else {

			$data_ = array();
			foreach ($this->forms_validation as $key => $field) {
				$data_[$field['field']] = set_value($field['field']);
			}

			$data_['full_path'] = '';
			$data_['filename_mobile'] = '';
			$data_ = (object)$data_;
		}			

       	$this->template
			->title($this->module_details['name'], lang('articles:title'))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->append_css('module::selectize.default.css')
			->append_js('module::dago_gallery_form.js')
			->append_js('module::admin-article.js')
			->append_js('module::selectize.min.js')
			->append_js('jquery/jquery.tagsinput.js')
			->append_css('jquery/jquery.tagsinput.css')
			->set('data_', $data_)
			// ->set('sections', $this->sections())
			->set('featureds', array(''=>'Select Options','yes'=>'YES','no'=>'NO'))
            ->build('admin/article/form');
	}

	private function sections(){
		$sectionArray = array();
		$sectionArray[''] = 'Select Section';
		$sections = $this->section_m->get_all();
		foreach($sections as $section){
			$sectionArray[$section->id] = $section->title;
		}
		return $sectionArray;
	}

	public function edit($id = 0) {
		$id or redirect(ADMIN_URL.'/article/'.$this->u_admin);
		$data_ = $this->article_m->get_single_data('article_id', $id, 'article');
		// $data_usr = $this->ion_auth->get_user($data_->authors_id);

		if(! ($data_)) {
			redirect(ADMIN_URL.'/article/'.$this->u_admin);
		}

		$article_validation = array_merge($this->forms_validation, array(
			'title'	=> array(
	    		'field'	=> 'title',
	    		'label'	=> 'lang:articles:title',
	    		'rules'	=> 'trim|required|xss_clean|callback__check_title['.$id.']'
	    	),

	    	'slug'	=> array(
	    		'field'	=> 'slug',
	    		'label'	=> 'lang:articles:slug',
	    		'rules'	=> 'trim|required|xss_clean|callback__check_slug['.$id.']'
	    	),
		));

		$rules 	= array_merge($this->forms_validation, $article_validation);

		
		$this->form_validation->set_rules($rules);
		$hash = $this->input->post('preview_hash');

		if ($this->form_validation->run()) {
			
			/*if($data_usr->group_id==1) {*/
				$extra = array(
					'title'			=> $this->input->post('title'),
					'slug'			=> $this->input->post('slug'),
					'status'        => $this->input->post('status'),
					'categories_id'	=> implode(',',$this->input->post('categories_id')),
					'description'	=> $this->input->post('description'),
					'meta_title'	=> $this->input->post('meta_title'),
					'meta_keyword'	=> $this->input->post('meta_keyword'),
					'meta_desc'		=> $this->input->post('meta_desc'),
					'altr_url'		=> $this->input->post('altr_url'),
					'campaign'		=> implode(',',$this->input->post('campaign')),
					'updated'		=> date('Y-m-d H:i:s')
					
				);				
			/*} else {
				$extra = array(
					// 'title'			=> $this->input->post('title'),
					// 'slug'			=> $this->input->post('slug'),
					'status'        => $this->input->post('status'),
					// 'intro'			=> $this->input->post('intro'),
					'categories_id'	=> implode(',',$this->input->post('categories_id')),
					'kidsage_id'	=> implode(',',$this->input->post('kidsage_id')),
					// 'authors_id'	=> $this->current_user->id,
					// 'description'	=> $this->input->post('description'),
					'meta_title'	=> $this->input->post('meta_title'),
					'meta_keyword'	=> $this->input->post('meta_keyword'),
					'meta_desc'		=> $this->input->post('meta_desc'),
					'show_comments'	=> $this->input->post('show_comments'),
					'bg_color'		=> $this->input->post('bg_color'),
					// 'template'		=> $this->input->post('template'),
					// 'click'			=> ($this->input->post('click')) ? $this->input->post('click') : 0,
					// 'likes'			=> ($this->input->post('likes')) ? $this->input->post('likes') : 0,
				);
			}*/

			

			if ($this->article_m->update_data('article', $extra, 'article_id', $id)) {
				if($_FILES['thumb']['name']!=''){
					$this->upload->initialize($this->set_upload_options($_FILES['thumb'], $id));
					if($this->upload->do_upload('thumb')){
						$data = $this->upload->data();
						$new_data = array(
	                		'filename' 	=> $data['file_name'],
	                		'path'		=> 'uploads/default/files/article/'.$id.'/',
	                		'full_path'	=> 'uploads/default/files/article/'.$id.'/'.$data['file_name'],
	                	);

	                	$this->article_m->update_data('article', $new_data, 'article_id', $id);

					}else{
						$errors = $this->upload->display_errors();
						$this->session->set_flashdata('error', $errors);
					}
				}

				if ($_FILES['thumb_mobile']['name'] != '') {
					$this->upload->initialize($this->set_upload_options($_FILES['thumb_mobile'], $id));
					if ($this->upload->do_upload('thumb_mobile')) {
						$data = $this->upload->data();
						$new_data = array('filename_mobile' => $data['file_name']);
	                	$this->article_m->update_data('article', $new_data, 'article_id', $id);
					} else {
						$errors = $this->upload->display_errors();
						$this->session->set_flashdata('error', $errors);
					}
				}

				$files = $_FILES;


				// if($this->input->post('status')=='live'){
				// 	$tes = $this->email_notifApproved($id);
				// }

				

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
			->title($this->module_details['name'], lang('articles:title'))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->append_css('module::selectize.default.css')
			// ->append_js('module::dago_gallery_form.js')
			->append_js('module::admin-article.js')
			->append_js('module::selectize.min.js')
			->append_js('jquery/jquery.tagsinput.js')
			->append_css('jquery/jquery.tagsinput.css')
			->set('data_', $data_)
			->set('article_id', $id)
			// ->set('sections', $this->sections())
			->set('featureds', array(''=>'Select Options','yes'=>'YES','no'=>'NO'))
            ->build('admin/article/form');
	}

	function email_notifApproved($artikel_id){
		$info_article = $this->article_m->get_single_data('article_id', $artikel_id, 'article');
		$author_id = $info_article->authors_id;
		$artikel_url = base_url('smart-stories/'.strtolower($info_article->slug));
		$info_user = $this->article_m->get_single_data('user_id', $author_id, 'profiles');
		$data = $this->article_m->get_single_user(array('id'=>$author_id), 'users');
		$data_mail = array(
			'message' => 'Terima kasih sudah mengirimkan tulisan yang menarik dan inspiratif. Saat ini tulisan Anda sudah dimuat di Parenting Club. Yuk, kunjungi Parenting Club untuk melihat dan bagikan  agar bisa menginspirasi Mam & Pap lainnya.',
			'subject' => 'Artikel sudah terpublish',
			'button_text' => 'Lihat Tulisan',
			'url' => $artikel_url,
			'headline' => 'Halo '.$info_user->display_name
		);

		//sent email after suksess update
		if($data) {
			if($data->group_id!=1) {
				/*$this->load->library('Mandrill/Mandrill');
				$message = array(
					'html' => $this->load->view('mail_notif', $data_mail, true),
					'text' => $data_mail['message'].$data_mail['url'],
					'subject' => $data_mail['subject'],
					'from_email' => 'donotreply@parentingclub.id',
					'from_name' => 'Parenting Club',
					'to' => array(
							array(
									'email' => $data->email,
									//'name' => $data->display_name,
									'type' => 'to'
							)
					),
					'headers' => array('Reply-To' => 'donotreply@parentingclub.id'),
					'track_opens' => false,
					'track_clicks' => false,
				);

				$val = $this->mandrill->messages->send($message, false);*/

				$this->load->library('Swiftmailer/Baseswiftmailer');
				$message = array(
			       	'html' => $this->load->view('mail_notif', $data_mail, true),
					'text' => $data_mail['message'].$data_mail['url'],
					'subject' => $data_mail['subject'],
					'from_email' => 'donotreply@parentingclub.id',
					'from_name' => 'Parenting Club',
					'to' => array(
						array(
								'email' => $data->email,
								//'name' => $data->display_name,
								'type' => 'to'
						)
					),
			    );
				$mailer = $this->baseswiftmailer->send($message);
				// echo json_encode(array('status'=>'success'));
			}
		}
	}

	public function preview($id = 0) {
		$post = $this->article_m->get($id);

		$this->template
			->set_layout('modal', 'admin')
			->set('post', $post)
			->build('admin/preview');
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
				if ($post = $this->article_m->get_single_data('article_id', $id, 'article')) {
					$this->article_m->delete_data('article', 'article_id', $id);
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
				if ($post = $this->article_m->get_single_data('article_id', $id, 'article')) {
					$this->article_m->publish_data('article', 'article_id', $id);
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

	public function _check_title($title, $id=0) {
		$this->form_validation->set_message('_check_title', sprintf(lang('articles:already_exist_error'), lang('global:title')));

		return $this->article_m->check_exists('article', array('title'=>$title, 'article_id'=>$id));
	}

	public function _check_slug($slug, $id=0) {
		$this->form_validation->set_message('_check_slug', sprintf(lang('articles:already_exist_error'), lang('global:slug')));

		return $this->article_m->check_exists('article', array('slug'=>$slug, 'article_id'=>$id));
	}

	public function delete_arinfo() {
		$ret 		= array();
		$id_data 	= $this->input->post('id_data');

		if ($this->article_m->delete_data('article_files', 'imges_id', (int)$id_data)) {
			$upload_folder = array('default/files/article_files/'.$id_data);
			$this->remove_upload_dir($upload_folder);
			$ret = array(
				'status'	=>true,
			);
		} else {
			$ret = array(
				'status'	=>false,
			);
		}

		echo json_encode($ret);
	}

	public function set_featured(){
		$id = (int)$this->input->post('id_data');
		$aksi = (int)$this->input->post('featured');
		$ret['status'] = false;

		$count_featured = $this->article_m->cheker_data('default_article', array('featured'=>1));

		if($aksi==1){
			// if($count_featured->num_rows() < 8) {
				$cek = $this->article_m->get_single_data('article_id', $id, 'article');
				if(count((array)$cek)>0){
					$featured = $this->article_m->update_data('article', array('featured'=>1), 'article_id', $id);
					$ret['status'] = true;
				}else{
					$ret['msg'] = "There's no data";
				}
			// } else {
			// 	$ret['msg'] = "max 8 featured items";
			// }

		} else {
			$cek = $this->article_m->get_single_data('article_id', $id, 'article');
			if(count((array)$cek)>0){
				$featured = $this->article_m->update_data('article', array('featured'=>null), 'article_id', $id);
				$ret['status'] = true;
			}else{
				$ret['msg'] = "There's no data";
			}
		}

		if ($this->input->is_ajax_request()){
			echo json_encode($ret);
			exit();
		}

		redirect(ADMIN_URL.'/'.$this->sect);
	}

	private function set_upload_options($file, $id) {
		$new_path = '/uploads/default/files/article/'.$id.'/';
		if(!is_dir(getcwd().$new_path)) {
			mkdir(getcwd().$new_path,0775,true);
		}

	    $judul = $this->img_slug($this->input->post('title',TRUE));
		$config = array(
            'allowed_types' 	=> 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf',
            'max_size'			=> '60000',
            // 'max_width'			=> '2000',
            // 'max_height'		=> '2000',
            'upload_path' 		=> getcwd().$new_path,
            'overwrite'			=> TRUE,
            'file_name'			=> $judul.'_'.$id.'_'.$file['name'],
        );

	    return $config;
	}

	private function set_upload_options_arfile($file=array(), $id='', $path='') {
		if ($path=='') {
			$new_path = '/uploads/default/files/article_files/'.$id.'/';
		} else {
			$new_path = $path;
		}

		if(!is_dir(getcwd().$new_path)) {
			mkdir(getcwd().$new_path,0775,true);
		}

	    $judul = $this->img_slug($this->input->post('title',TRUE));
		$config = array(
            'allowed_types' 	=> 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf',
            'max_size'			=> '60000',
            // 'max_width'			=> '2000',
            // 'max_height'		=> '2000',
            'upload_path' 		=> getcwd().$new_path,
            'overwrite'			=> TRUE,
            'file_name'			=> $judul.'_'.$id.'_'.$file['name'],
        );

	    return $config;
	}

	private function set_upload_options_video($file = array(), $id = '', $path = '')
	{
		$new_path = $path == '' ? '/uploads/default/files/article_files/'.$id.'/' : $path;

		if (!is_dir(getcwd().$new_path)) {
			mkdir(getcwd().$new_path, 0775, true);
		}

	    $judul = $this->img_slug($this->input->post('title', true));
		$config = array(
            'allowed_types' 	=> 'mp4|MP4', // 'mp4|ogg|webm|MP4|OGG|WEBM'
            'max_size'			=> 1024 * 5120,
            'upload_path' 		=> getcwd().$new_path,
            'overwrite'			=> true,
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

    function alter_table() {
    	$sql = array(
    		// /"DROP TABLE `default_article`, `default_article_authors`, `default_article_categories`, `default_article_comments`, `default_article_files`, `default_article_kidsage`, `default_article_likes`, `default_article_tags`",
    		// "INSERT INTO `default_groups`(`name`, `description`) VALUES ('blogger','Blogger')",
    		// "ALTER TABLE `default_article_files` ADD `fname` TEXT NOT NULL AFTER `article_id`",
			//"ALTER TABLE `default_article_categories` ADD `oreder` INT NULL AFTER `meta_desc`;",
			//"ALTER TABLE `default_article` ADD `featured_kecil_hebat` INT(11) NOT NULL DEFAULT '0' AFTER `featured_afs`;",
			"ALTER TABLE `default_article` ADD `featured_kecil_hebat_order` INT(11) NOT NULL DEFAULT '0' AFTER `featured_kecil_hebat`",
			"ALTER TABLE `default_article` ADD `kecilhebat_section_id` INT(11) NOT NULL DEFAULT '0' AFTER `featured_kecil_hebat_order`, ADD INDEX `article_section_kecilhebat` (`kecilhebat_section_id`)",
			"ALTER TABLE `default_kecilhebat_sections` ADD `image_on_section` VARCHAR(250) NULL DEFAULT NULL AFTER `title_result`",
    	);

    	foreach ($sql as $q) {
    		$qr =$this->db->query($q);
    	}
    }

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

	public function export_data($status = 0)
	{
		$this->load->library('excel');

        $nama_file = 'article_data_export';
        $date_now = date('d-m-Y');

        $this->excel->getActiveSheet()->setTitle('Parenting Club Article');

        $parameter = array();

        if ($status) {
            $parameter['status'] = $status;
        }

        $data = $this->article_m->getDataForExport($parameter);

        if (!$data) {
            redirect(ADMIN_URL.'/article');
        }

        $no = 1;
        $count = 2;
        $sheet_range = 'A1:X1';

        $this->excel->getActiveSheet()->setCellValue('A1', 'Article ID');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Title');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Slug');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Filename');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Path');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Full Path');
        $this->excel->getActiveSheet()->setCellValue('G1', 'Status');
        $this->excel->getActiveSheet()->setCellValue('H1', 'Description');
        $this->excel->getActiveSheet()->setCellValue('I1', 'Categories');
        $this->excel->getActiveSheet()->setCellValue('J1', 'Meta Title');
        $this->excel->getActiveSheet()->setCellValue('K1', 'Meta Keyword');
        $this->excel->getActiveSheet()->setCellValue('L1', 'Meta Desc');
        $this->excel->getActiveSheet()->setCellValue('M1', 'Created');
        $this->excel->getActiveSheet()->setCellValue('N1', 'Created On');

        // $this->excel->getActiveSheet()->setCellValue('O1', 'Meta Desc');
        // $this->excel->getActiveSheet()->setCellValue('P1', 'Show Comments');
        // $this->excel->getActiveSheet()->setCellValue('Q1', 'Template');
        // $this->excel->getActiveSheet()->setCellValue('R1', 'Created');
        // $this->excel->getActiveSheet()->setCellValue('S1', 'Created On');
        // $this->excel->getActiveSheet()->setCellValue('T1', 'Click');
        // $this->excel->getActiveSheet()->setCellValue('U1', 'Likes');
        // $this->excel->getActiveSheet()->setCellValue('V1', 'Featured');
        // $this->excel->getActiveSheet()->setCellValue('W1', 'Shared');
        // $this->excel->getActiveSheet()->setCellValue('X1', 'BG Color');

        $this->excel->getActiveSheet()->getStyle($sheet_range)->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle($sheet_range)->getFont()->setBold(true);

        foreach ($data as $dt) {
            $this->excel->getActiveSheet()->setCellValueExplicit('A'.$count, $dt->article_id, PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('B'.$count, $dt->title, PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('C'.$count, $dt->slug, PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('D'.$count, $dt->filename, PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('E'.$count, $dt->path, PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('F'.$count, $dt->full_path, PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('G'.$count, $dt->status, PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('H'.$count, $dt->description, PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('I'.$count, $dt->categories_id, PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('J'.$count, $dt->meta_title, PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('K'.$count, $dt->meta_keyword, PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('L'.$count, $dt->meta_desc, PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('M'.$count, $dt->created, PHPExcel_Cell_DataType::TYPE_STRING);
            $this->excel->getActiveSheet()->setCellValueExplicit('N'.$count, $dt->created_on, PHPExcel_Cell_DataType::TYPE_STRING);
            
            // $this->excel->getActiveSheet()->setCellValueExplicit('O'.$count, $dt->meta_desc, PHPExcel_Cell_DataType::TYPE_STRING);
            // $this->excel->getActiveSheet()->setCellValueExplicit('P'.$count, $dt->show_comments, PHPExcel_Cell_DataType::TYPE_STRING);
            // $this->excel->getActiveSheet()->setCellValueExplicit('Q'.$count, $dt->template, PHPExcel_Cell_DataType::TYPE_STRING);
            // $this->excel->getActiveSheet()->setCellValueExplicit('R'.$count, $dt->created, PHPExcel_Cell_DataType::TYPE_STRING);
            // $this->excel->getActiveSheet()->setCellValueExplicit('S'.$count, $dt->created_on, PHPExcel_Cell_DataType::TYPE_STRING);
            // $this->excel->getActiveSheet()->setCellValueExplicit('T'.$count, $dt->click, PHPExcel_Cell_DataType::TYPE_STRING);
            // $this->excel->getActiveSheet()->setCellValueExplicit('U'.$count, $dt->likes, PHPExcel_Cell_DataType::TYPE_STRING);
            // $this->excel->getActiveSheet()->setCellValueExplicit('V'.$count, $dt->featured, PHPExcel_Cell_DataType::TYPE_STRING);
            // $this->excel->getActiveSheet()->setCellValueExplicit('W'.$count, $dt->shared, PHPExcel_Cell_DataType::TYPE_STRING);
            // $this->excel->getActiveSheet()->setCellValueExplicit('X'.$count, $dt->bg_color, PHPExcel_Cell_DataType::TYPE_STRING);

            $count++;
            $no++;
        }

        foreach (range('A', 'X') as $columnID) {
            $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $options = array(
            'fill' => array(
                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '8FB1FF')
            )
        );

        $this->excel->getActiveSheet()->getStyle($sheet_range)->applyFromArray($options);
        $this->excel->getActiveSheet()->getStyle($sheet_range)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $filename = $nama_file.'_'.$date_now.'.csv'; // Save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); // Mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); // Tell browser what's the file name
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
	}

	public function set_featured_milestone()
	{
		if ($this->input->is_ajax_request()) {
			$id = (int) $this->input->post('id_data');
			$featured = (int) $this->input->post('featured');
			$data = array('featured_milestone' => $featured == 0 ? 1 : 0);
			$check = $this->article_m->get_single_data('article_id', $id, 'article');
			$count = $this->article_m->cheker_data('default_article', array('featured_milestone' => 1));
			$response = array(
				'status' => false,
				'msg' => 'no data available'
			);

			if (count((array) $check) > 0) {
				$this->article_m->update_data('article', $data, 'article_id', $id);
				$response['status'] = true;
				$response['msg'] = '';
			}

			echo json_encode($response);
			return;
		}

		redirect(ADMIN_URL.'/'.$this->sect);
	}

	public function set_featured_afs(){
		$id = (int)$this->input->post('id_data');
		$aksi = (int)$this->input->post('featured_afs');
		$ret['status'] = false;

		$count_featured_afs = $this->article_m->cheker_data('default_article', array('featured_afs'=>1));

		if($aksi==1){
			if($count_featured_afs->num_rows() < 4) {
				$cek = $this->article_m->get_single_data('article_id', $id, 'article');
				if(count((array)$cek)>0){
					$featured_afs = $this->article_m->update_data('article', array('featured_afs'=>1), 'article_id', $id);
					$ret['status'] = true;
				}else{
					$ret['msg'] = "There's no data";
				}
			} else {
				$ret['msg'] = "max 4 featured afs items";
			}

		} else {
			$cek = $this->article_m->get_single_data('article_id', $id, 'article');
			if(count((array)$cek)>0){
				$featured_afs = $this->article_m->update_data('article', array('featured_afs'=>null), 'article_id', $id);
				$ret['status'] = true;
			}else{
				$ret['msg'] = "There's no data";
			}
		}

		if ($this->input->is_ajax_request()){
			echo json_encode($ret);
			exit();
		}

		redirect(ADMIN_URL.'/'.$this->sect);
	}

	public function _check_yt_link()
	{
		$url = $this->input->post('yt_video');
	    $valid_schemes = array('https');
	    $valid_hosts = array('www.youtube.com', 'youtube.com', 'youtu.be');
	    $valid_paths = array('/watch');
	    $bits = parse_url($url);

	    if (is_array($bits)) {
	    	if (isset($bits['scheme']) && in_array($bits['scheme'], $valid_schemes)) {
		    	if (isset($bits['host'])) {
			    	if (in_array($bits['host'], $valid_hosts)) {
				    	if ($bits['host'] != 'youtu.be') {
					    	if (isset($bits['path']) && in_array($bits['path'], $valid_paths)) {
					    		if (isset($bits['query'])) {
					    			$id = explode('=', $bits['query']);

					    			if (isset($id[1]) && !empty($id[1])) {
					    				return true;
					    			}
					    		}
					    	}
					    } else {
					    	return true;
					    }
			    	}
			    }
		    }
	    }

	    $this->form_validation->set_message('_check_yt_link', 'Invalid Youtube URL');

	    return false;
	}

	public function extract_yt_id($url)
	{
		$valid_schemes = array('https');
	    $valid_hosts = array('www.youtube.com', 'youtube.com', 'youtu.be');
	    $valid_paths = array('/watch');
	    $bits = parse_url($url);

	    if (is_array($bits)) {
	    	if (isset($bits['scheme']) && in_array($bits['scheme'], $valid_schemes)) {
		    	if (isset($bits['host'])) {
			    	if (in_array($bits['host'], $valid_hosts)) {
				    	if ($bits['host'] != 'youtu.be') {
					    	if (isset($bits['path']) && in_array($bits['path'], $valid_paths)) {
					    		if (isset($bits['query'])) {
					    			$id = explode('=', $bits['query']);

					    			if (isset($id[1]) && !empty($id[1])) {
					    				return $id[1];
					    			}
					    		}
					    	}
					    } else {
					    	return ltrim($bits['path'], '/');
					    }
			    	}
			    }
		    }
	    }

	    return '';
	}


	/* tambahan si kecil hebat */
	public function set_featured_kecilhebat(){
		$id = (int)$this->input->post('id_data');
		$aksi = (int)$this->input->post('featured_kecilhebat');
		$ret['status'] = false;
		$ret['msg'] = "There's no data";
		
		$cek = $this->article_m->get_single_data('article_id', $id, 'article');				
		if($cek){
			$featured = null;
			if($aksi==1){
				$featured = 1;
			}			
			$update = $this->article_m->update_data('article', array('featured_kecil_hebat'=>$featured), 'article_id', $id);			
			if($update){
				$ret['status'] = true;
				$ret['msg'] = "success";
			}			
		}

		if ($this->input->is_ajax_request()){
			echo json_encode($ret);
			exit();
		}

		redirect(ADMIN_URL.'/'.$this->sect);
	}

	/**
	 * because iframe is set to DENY
	 */
	public function upload_custom(){
		if ($this->input->is_ajax_request()){
			if($this->input->post('title') && $_FILES['userfile']){
				$data = array();
				$results = array();
				$status = true;
				$message = 'success';

				$filedir  = 'uploads/contents/'.date('Ym').'/';
				if (!is_dir('./'.$filedir)) {
					mkdir('./'.$filedir, 0755, TRUE);
				}

				$config = array(
					'upload_path' => './'.$filedir,
					'allowed_types' => 'gif|jpg|jpeg|png|image/png|image/jpeg|image/jpg',
					'max_size' => '3000',
				);
				$this->load->library('upload');
				$this->upload->initialize($config);
				if ($this->upload->do_upload('userfile'))
				{				
					$uploadData = $this->upload->data();				
					$fullpath = base_url($filedir.$uploadData['file_name']);
					$title = $this->input->post('title');
					$results = array(
						'title' => $title,
						'image' => $fullpath,
						'element' => '<img src="'.base_url($filedir.$uploadData['file_name']).'" alt="'.$title.'" width="100%">',
					);	
				}else{
					$status = false;
					$message = $this->upload->display_errors();
				}

				$data = array(
					'status' => $status,
					'message' => $message,
					'result' => $results,
				);
				echo json_encode($data);
			}			
		}
	}
}
