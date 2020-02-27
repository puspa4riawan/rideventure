<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @author  yudiantara.gde@gmail.com
 * @package MaxCMS\Core\Modules\Article\Controllers\Admin_article
 */
class Admin_product extends Admin_Controller {

	var $u_admin 		= 'admin_product';
	protected $section 	= 'product';
	protected $module_url = 'product';
	protected $active_table = 'product';
	protected $current_model = 'product_m';


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

		

    );

    public function __construct() {

		parent::__construct();

		$sect 			= $this->uri->segment(3);

		$this->load->model(array($this->current_model));
		$this->lang->load(array('general', $this->section));
		$this->load->libraries(array('upload'));

		$this->load->model($this->current_model,'current_m');

		// $categories = $this->article_m->get_all_data('article_kidsage');
		// $category 	= $this->article_m->get_all_data('category');


		$_template = array(
			'no-image'			=>'Product without image',
			'thumb' 			=>'Product with thumbnail',
			'2-tile' 			=>'Product with merge tile',
			'gallery' 			=>'Product with gallery',
			// 'downloadable' 		=>'Article with downloadable item',
		);

		$_content_formats = array(
			'none'     => 'Select Format',
			'carousel' => 'Image Carousel',
			'banner'   => 'Product',
			'youtube'  => 'Youtube Video URL',
			'video'    => 'Video'
		);

		$_bg_color = array(
			'red'			=>'Red',
			'yellow'		=>'Yellow',
		);

		
		$this->template
			 ->append_css('module::main.css')
			 // ->set('opt_authors', $author)
			 ->set('u_admin', $this->u_admin)
			 ->set('bg_color', $_bg_color)
			 ->set('a_template', $_template)
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


		$total_rows = $this->current_m->count_data_table($base_where,$this->active_table);
		$pagination = create_pagination(ADMIN_URL.'/'.$this->module_url.'/'.$this->u_admin.'/index', $total_rows, Settings::get('records_per_page'),5);
		$data_ 		= $this->current_m
						   ->limit($pagination['limit'], $pagination['offset'])
						   ->order_by('id', 'DESC')
						   ->get_many_datatable($base_where,$this->active_table);
		
		

		$this->input->is_ajax_request() and $this->template->set_layout(false);

		$this->template
			->title($this->module_details['name'])
			->append_js('admin/filter.js')
			->set_partial('filters', 'admin/'.$this->section.'/partials/filters')
			->append_js('module::admin-article.js')
			->set('pagination', $pagination)
			->set('module_url', $this->module_url)
			->set('section',$this->section)
			->set('data_', $data_);

			$this->input->is_ajax_request()
			? $this->template->build('admin/'.$this->section.'/tables/table')
			: $this->template->build('admin/'.$this->section.'/index');
	}


	public function create() {
		date_default_timezone_set('Asia/Jakarta');
		$rules 	= array_merge($this->forms_validation);

		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run()) {
			if ($this->input->post('status') == 'live') {
				role_or_die('destinations/admin_destinations', 'put_live');
				$hash = "";
			}

			$created 		= date('Y-m-d H:i:s');
			$created_on 	= strtotime($created);
			
			$extra = array(
				'title'			=> $this->input->post('title'),
				'slug'			=> $this->input->post('slug'),
				'price'			=> $this->input->post('price'),
				'description'	=> $this->input->post('description'),
				'status'        => $this->input->post('status'),
				'meta_title'	=> $this->input->post('meta_title'),
				'meta_keyword'	=> $this->input->post('meta_keyword'),
				'meta_desc'		=> $this->input->post('meta_desc'),
				'created'		=> $created,
			);			

			if ($id = $this->current_m->insert_data($this->active_table, $extra)) {
				if($_FILES['thumb']['name']!=''){
					$this->upload->initialize($this->set_upload_options($_FILES['thumb'], $id));
					if($this->upload->do_upload('thumb')){
						$data = $this->upload->data();
						$new_data = array(
	                		'filename' 	=> $data['file_name'],
	                		'path'		=> 'uploads/default/files/'.$this->section.'/'.$id.'/',
	                		'full_path'	=> 'uploads/default/files/'.$this->section.'/'.$id.'/'.$data['file_name'],
	                	);

	                	$this->current_m->update_data($this->active_table, $new_data, 'id', $id);

					}else{
						$errors = $this->upload->display_errors();
						$this->session->set_flashdata('error', $errors);
					}
				}

				
                

                $this->session->set_flashdata(array('success' => sprintf(lang('general:add_success'), $this->input->post('title'))));
                $this->session->unset_userdata('upload');

      		} else {
				$this->session->set_flashdata('error', lang('general:post_add_error'));
			}

			($this->input->post('btnAction') == 'save_exit') ? redirect(ADMIN_URL.'/'.$this->module_url) : redirect(ADMIN_URL.'/'.$this->module_url.'/edit/'.$id);

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
			->title($this->module_details['name'], lang($this->section.':title'))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->append_css('module::selectize.default.css')
			->append_js('module::dago_gallery_form.js')
			->append_js('module::admin-article.js')
			->append_js('module::selectize.min.js')
			->append_js('jquery/jquery.tagsinput.js')
			->append_css('jquery/jquery.tagsinput.css')
			->set('data_', $data_)
			->set('section', $this->section)
			->set('featureds', array(''=>'Select Options','yes'=>'YES','no'=>'NO'))
            ->build('admin/'.$this->section.'/form');
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
		$id or redirect(ADMIN_URL.'/'.$this->module_url.'/'.$this->u_admin);
		$data_ = $this->current_m->get_single_data('id', $id, $this->active_table);
		// $data_usr = $this->ion_auth->get_user($data_->authors_id);

		if(! ($data_)) {
			redirect(ADMIN_URL.'/'.$this->module_url.'/'.$this->u_admin);
		}

		$module_validation = array_merge($this->forms_validation, array(
			'title'	=> array(
	    		'field'	=> 'title',
	    		'label'	=> 'lang:'.$this->section.':title',
	    		'rules'	=> 'trim|required|xss_clean|callback__check_title['.$id.']'
	    	),

	    	'slug'	=> array(
	    		'field'	=> 'slug',
	    		'label'	=> 'lang:'.$this->section.':slug',
	    		'rules'	=> 'trim|required|xss_clean|callback__check_slug['.$id.']'
	    	),
		));

		$rules 	= array_merge($this->forms_validation, $module_validation);

		
		$this->form_validation->set_rules($rules);
		$hash = $this->input->post('preview_hash');

		if ($this->form_validation->run()) {
			
			/*if($data_usr->group_id==1) {*/
				$extra = array(
					'title'			=> $this->input->post('title'),
					'slug'			=> $this->input->post('slug'),
					'price'			=> $this->input->post('price'),
					'description'	=> $this->input->post('description'),
					'status'        => $this->input->post('status'),
					'meta_title'	=> $this->input->post('meta_title'),
					'meta_keyword'	=> $this->input->post('meta_keyword'),
					'meta_desc'		=> $this->input->post('meta_desc'),
					'updated'		=> date('Y-m-d H:i:s')
					
				);						

			if ($this->current_m->update_data($this->active_table, $extra, 'id', $id)) {
				if($_FILES['thumb']['name']!=''){
					$this->upload->initialize($this->set_upload_options($_FILES['thumb'], $id));
					if($this->upload->do_upload('thumb')){
						$data = $this->upload->data();
						$new_data = array(
	                		'filename' 	=> $data['file_name'],
	                		'path'		=> 'uploads/default/files/'.$this->section.'/'.$id.'/',
	                		'full_path'	=> 'uploads/default/files/'.$this->section.'/'.$id.'/'.$data['file_name'],
	                	);

	                	$this->current_m->update_data($this->active_table, $new_data, 'id', $id);

					}else{
						$errors = $this->upload->display_errors();
						$this->session->set_flashdata('error', $errors);
					}
				}

				
				$files = $_FILES;

				$this->session->set_flashdata(array('success' => sprintf(lang('general:edit_success'), $this->input->post('title'))));
                $this->session->unset_userdata('upload');
			}
			else
			{
				$this->session->set_flashdata('error', lang('general:edit_error'));
			}

			($this->input->post('btnAction') == 'save_exit') ? redirect(ADMIN_URL.'/'.$this->module_url.'/') : redirect(ADMIN_URL.'/'.$this->module_url.'/edit/'.$id);
		}

		foreach ($this->form_validation->set_rules($rules) as $key => $field) {
			if (isset($_POST[$field['field']])) {
				$data_->$field['field'] = set_value($field['field']);
			}
		}
		
		$this->template
			->title($this->module_details['name'], lang($this->section.':title'))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->append_css('module::selectize.default.css')
			// ->append_js('module::dago_gallery_form.js')
			->append_js('module::admin-article.js')
			->append_js('module::selectize.min.js')
			->append_js('jquery/jquery.tagsinput.js')
			->append_css('jquery/jquery.tagsinput.css')
			->set('data_', $data_)
			->set('article_id', $id)
			->set('section', $this->section)
			->set('featureds', array(''=>'Select Options','yes'=>'YES','no'=>'NO'))
            ->build('admin/'.$this->section.'/form');
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

	

	public function action() {
		switch ($this->input->post('btnAction')) {
			case 'publish':
				$this->publish();
				break;

			case 'delete':
				$this->delete();
				break;

			default:
				redirect(ADMIN_URL.'/'.$this->module_url.'/'.$this->u_admin);
				break;
		}
	}

	public function delete($id = 0) {
		role_or_die($this->section.'_m', 'delete_live');
		$ids = ($id = $this->input->post('id')) ? array($id) : $this->input->post('action_to');
		$post_titles = array();
		$deleted_ids = array();

        if ( ! empty($ids)) {
			foreach ($ids as $id) {
				if ($post = $this->current_m->get_single_data('id', $id, $this->active_table)) {
					$this->current_m->delete_data($this->active_table, 'id', $id);
                    $this->maxcache->delete($this->section.'_m');
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

		redirect(ADMIN_URL.'/'.$this->module_url.'/'.$this->u_admin);
	}

	public function publish($id = 0) {
		role_or_die($this->section.'_m', 'put_live');
		$ids = ($id) ? array($id) : $this->input->post('action_to');
		$post_titles = array();

		if ( ! empty($ids)) {
			foreach ($ids as $id) {
				if ($post = $this->current_m->get_single_data('id', $id, $this->active_table)) {
					$this->current_m->publish_data($this->active_table, 'id', $id);
					$this->maxcache->delete($this->section.'_m');
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

		redirect(ADMIN_URL.'/'.$this->module_url.'/'.$this->u_admin);
	}

	public function _check_title($title, $id=0) {
		$this->form_validation->set_message('_check_title', sprintf(lang('destinations:already_exist_error'), lang('global:title')));

		return $this->current_m->check_exists($this->active_table, array('title'=>$title, 'id'=>$id));
	}

	public function _check_slug($slug, $id=0) {
		$this->form_validation->set_message('_check_slug', sprintf(lang('destinations:already_exist_error'), lang('global:slug')));

		return $this->current_m->check_exists($this->active_table, array('slug'=>$slug, 'id'=>$id));
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

	

	private function set_upload_options($file, $id) {
		$new_path = '/uploads/default/files/'.$this->section.'/'.$id.'/';
		if(!is_dir(getcwd().$new_path)) {
			mkdir(getcwd().$new_path,0775,true);
		}

	    $judul = $this->img_slug($this->input->post('title',TRUE));
		$config = array(
            'allowed_types' 	=> 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf',
            'max_size'			=> '60000',
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

	
	/**
	 * because iframe is set to DENY
	 */
	
}
