<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @author  yudiantara.gde@gmail.com
 * @package MaxCMS\Core\Modules\Article\Controllers\Admin_article
 */
class Admin_companymember extends Admin_Controller {

	var $u_admin 		= 'admin_companymember';
	protected $section 	= 'companymember';
	protected $module_url = 'companymember';
	protected $active_table = 'companymember';
	protected $current_model = 'companymember_m';


	protected $forms_validation = array(
    	'full_name'	=> array(
    		'field'	=> 'full_name',
    		'label'	=> 'Full Name',
    		'rules'	=> 'trim|required|xss_clean'
    	),

    	'position'	=> array(
    		'field'	=> 'position',
    		'label'	=> 'Job Position',
    		'rules'	=> 'trim|required|xss_clean'
    	),

    	'address'	=> array(
    		'field'	=> 'address',
    		'label'	=> 'Address',
    		'rules'	=> 'trim|required'
    	),
    	'email'	=> array(
    		'field'	=> 'email',
    		'label'	=> 'Email',
    		'rules'	=> 'trim|required|valid_email|xss_clean'
    	),

    	'status' => array(
			'field' => 'status',
			'label' => 'lang:general:status_label',
			'rules' => 'trim|alpha'
		),

		

    );

    public function __construct() {

		parent::__construct();

		$sect 			= $this->uri->segment(3);

		$this->load->model(array($this->current_model));
		$this->lang->load(array('general', $this->section));
		$this->load->libraries(array('upload'));
		$this->load->helper('email');

		$this->load->model($this->current_model,'current_m');

		// $categories = $this->article_m->get_all_data('article_kidsage');
		// $category 	= $this->article_m->get_all_data('category');


		$_template = array(
			'no-image'			=>'Destinations without image',
			'thumb' 			=>'Destinations with thumbnail',
			'2-tile' 			=>'Destinations with merge tile',
			'gallery' 			=>'Destinations with gallery',
			// 'downloadable' 		=>'Article with downloadable item',
		);

		$_content_formats = array(
			'none'     => 'Select Format',
			'carousel' => 'Image Carousel',
			'banner'   => 'Destinations',
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
				role_or_die('companymember/admin_companymember', 'put_live');
				$hash = "";
			}

			$created 		= date('Y-m-d H:i:s');
			$created_on 	= strtotime($created);
			
			$extra = array(
				'full_name'		=> $this->input->post('full_name'),
				'position'		=> $this->input->post('position'),
				'address'		=> $this->input->post('address'),
				'phone'			=> $this->input->post('phone'),
				'email'			=> $this->input->post('email'),
				'self_desc'		=> $this->input->post('self_desc'),
				'status'        => $this->input->post('status'),
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

			($this->input->post('btnAction') == 'save_exit') ? redirect(ADMIN_URL.'/'.$this->module_url.'/'.$this->u_admin) : redirect(ADMIN_URL.'/'.$this->module_url.'/'.$this->u_admin.'/edit/'.$id);

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

		$article_validation = $this->forms_validation;

		$rules 	= array_merge($this->forms_validation, $article_validation);

		
		$this->form_validation->set_rules($rules);
		$hash = $this->input->post('preview_hash');

		if ($this->form_validation->run()) {
			
			/*if($data_usr->group_id==1) {*/
				$extra = array(
					'full_name'		=> $this->input->post('full_name'),
					'position'		=> $this->input->post('position'),
					'address'		=> $this->input->post('address'),
					'phone'			=> $this->input->post('phone'),
					'email'			=> $this->input->post('email'),
					'self_desc'		=> $this->input->post('self_desc'),
					'status'        => $this->input->post('status'),
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
					$post_titles[] = $post->full_name;
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
					$post_titles[] = $post->full_name;
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

	public function _valid_phone_number_or_empty($value)
	{
	    $value = trim($value);

	    if ($value == '') {
	            return TRUE;
	    }
	    else
	    {
	            if (preg_match('^011(999|998|997|996|995|994|993|992|991|990|979|978|977|976|975|974|973|972|971|970| 969|968|967|966|965|964|963|962|961|960|899|898|897|896|895|894|893|892|891|890|889|888| 887|886|885|884|883|882|881|880|879|878|877|876|875|874|873|872|871|870|859|858|857|856| 855|854|853|852|851|850|839|838|837|836|835|834|833|832|831|830|809|808|807|806|805|804| 803|802|801|800|699|698|697|696|695|694|693|692|691|690|689|688|687|686|685|684|683|682| 681|680|679|678|677|676|675|674|673|672|671|670|599|598|597|596|595|594|593|592|591|590| 509|508|507|506|505|504|503|502|501|500|429|428|427|426|425|424|423|422|421|420|389|388| 387|386|385|384|383|382|381|380|379|378|377|376|375|374|373|372|371|370|359|358|357|356| 355|354|353|352|351|350|299|298|297|296|295|294|293|292|291|290|289|288|287|286|285|284| 283|282|281|280|269|268|267|266|265|264|263|262|261|260|259|258|257|256|255|254|253|252| 251|250|249|248|247|246|245|244|243|242|241|240|239|238|237|236|235|234|233|232|231|230| 229|228|227|226|225|224|223|222|221|220|219|218|217|216|215|214|213|212|211|210|98|95|94| 93|92|91|90|86|84|82|81|66|65|64|63|62|61|60|58|57|56|55|54|53|52|51|49|48|47|46|45|44|43| 41|40|39|36|34|33|32|31|30|27|20|7|1)[0-9]{0, 14}$', $value))
	            {
	                    return preg_replace('^011(999|998|997|996|995|994|993|992|991|990|979|978|977|976|975|974|973|972|971|970|969|968|967|966|965|964|963|962|961|960|899|898|897|896|895|894|893|892|891|890|889|888| 887|886|885|884|883|882|881|880|879|878|877|876|875|874|873|872|871|870|859|858|857|856|855|854|853|852|851|850|839|838|837|836|835|834|833|832|831|830|809|808|807|806|805|804|803|802|801|800|699|698|697|696|695|694|693|692|691|690|689|688|687|686|685|684|683|682|681|680|679|678|677|676|675|674|673|672|671|670|599|598|597|596|595|594|593|592|591|590|509|508|507|506|505|504|503|502|501|500|429|428|427|426|425|424|423|422|421|420|389|388|387|386|385|384|383|382|381|380|379|378|377| 376|375|374|373|372|371|370|359|358|357|356|355|354|353|352|351|350|299|298|297|296|295|294|293|292|291|290|289|288|287|286|285|284|283|282|281|280|269|268|267|266|265|264|263|262|261|260|259|258|257|256|255|254|253|252|251|250|249|248|247|246|245|244|243|242|241|240|239|238|237|236|235|234|233|232|231|230|229|228|227|226|225|224|223|222|221|220|219|218|217|216|215|214|213|212|211|210|98|95|94|93|92|91|90|86|84|82|81|66|65|64|63|62|61|60|58|57|56|55|54|53|52|51|49|48|47|46|45|44|43| 41|40|39|36|34|33|32|31|30|27|20|7|1)[0-9]{0, 14}$', '($1) $2-$3', $value);
	            }
	            else
	            {
	                    return FALSE;
	            }
	    }
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
