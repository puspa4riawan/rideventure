<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * @author		Maxsolution.id
 * @package		MaxCMS\Core\Modules\Article\Controllers\Article
 */
class Article extends Public_Controller {

	protected $forms_validation = array(
 		array(
			'field' => 'arid',
			'label' => 'Article',
			'rules' => 'trim|required|xss_clean'
		),

		array(
			'field' => 'parent',
			'label' => 'Parent',
			'rules' => 'trim|required|xss_clean'
		),

		array(
			'field' => 'coment_input',
			'label' => 'Comments',
			'rules' => 'trim|required|xss_clean|callback__check_str_post'
		),

	);

	//validation forms
	protected $search = array(
 		array(

			'field' => 'search',
			'label' => 'search',
			'rules' => 'trim|xss_clean|callback__check_str_search'
		),
	);

	public function __construct() {

		parent::__construct();
        $this->template->set_layout('article.html');
		$this->load->model('article_m');
		$this->lang->load(array('categories', 'general', 'kidsage', 'comments', 'article'));
        $this->load->helper(array('text','download', 'article'));
        $this->load->library('bitly');
        $this->load->library('milestone');
        $this->config->load('article/config');
        $this->template->set('method', $this->method);
	}

	// public function index() {

	// 	//data backup
	// 	// $data_ = $this->article_m
	// 	// 			  ->where(array('article.status' => 'live'))
	// 	// 			  ->order_by('article.article_id', 'DESC')
	// 	// 			  ->limit(12, 0)
	// 	// 			  ->get_all_articles();

	// 	//set data where user status login
	// 	$ages = $this->article_m
	// 				  ->where(array('status' => 'live'))
	// 				  ->order_by('sort_no','ASC')
	// 				  ->get_all_data('article_categories');

	// 	$cats = $this->article_m
	// 				  ->where(array('status' => 'live'))
	// 				  ->order_by('sort_by','ASC')
	// 				  ->get_all_data('article_kidsage');
	// 	$id_ages = array();
	// 	$id_cats = array();


	// 	if($this->current_user) {

	// 		$data_ages 	=  $this->article_m
	// 							->where(array('user_id' => $this->current_user->id))
	// 							->get_all_data('user_ages');

	// 		$data_cats 	=  $this->article_m
	// 							->where(array('user_id' => $this->current_user->id))
	// 							->get_all_data('user_category');

	// 		if(count($data_ages) > 0) {


	// 			foreach ($data_ages as $keys => $value_ages) {

	// 				$id_ages[] = $value_ages->ages_id;
	// 				$this->article_m
	// 		 		 	 ->or_like('article.categories_id', ','.$value_ages->ages_id.',');
	// 			}

	// 		}

	// 		if(count($data_cats) > 0) {


	// 			foreach ($data_cats as $value_cats) {
	// 				$id_cats[] = $value_cats->kidsage_id;
	// 				$this->article_m
	// 		 		 	 ->or_like('article.kidsage_id', ','.$value_cats->kidsage_id.',');
	// 			}
	// 		}

	// 		$data_ 		=  $this->article_m
	// 					  		->where(array('article.status' => 'live'))
	// 					  		->order_by('article.article_id', 'DESC')
	// 							->limit(12)
	// 							->get_all_articles();


	// 	}else {
	// 		$data_ 		=  $this->article_m
	// 							->where(array('article.status' => 'live'))
	// 							->order_by('article.article_id', 'DESC')
	// 							->limit(12)
	// 							->get_all_articles();
	// 		$data_ages = '';
	// 		$data_cats = '';
	// 	}

	// 	$data_usr='';
	// 	$is_liked=array();
	// 	if($this->current_user){
	// 		$usr=$this->current_user->id;
	// 		$data_usr=true;
	// 		foreach ($data_ as $value) {
	// 			$is_liked[$value->article_id] = $this->article_m
	// 					 		->where(array('like_by'=>$usr, 'article_id'=>$value->article_id))
	// 					 		->count_data('article_likes');
	// 		}
	// 	}

	// 	foreach ($data_ as $value) {
	// 		$comments_count[$value->article_id] = $this->article_m
	// 					 	   										->where(array('status' => 'live', 'article_id' => $value->article_id))
	// 					 	   										->count_data('article_comments');
	// 		$likes_count[$value->article_id] = $this->article_m
	// 					 	   										->where('article_id', $value->article_id)
	// 					 	   										->count_data('article_likes');
	// 	}

	// 	$ages = $this->article_m
	// 				  ->where(array('status' => 'live'))
	// 				  ->order_by('sort_no','ASC')
	// 				  ->get_all_data('article_categories');

	// 	$cats = $this->article_m
	// 				  ->where(array('status' => 'live'))
	// 				  ->order_by('sort_by','ASC')
	// 				  ->get_all_data('article_kidsage');

	// 	$page 				= $this->maxcache->model('page_m', 'get_by_uri', array('tips-and-tools', true));
	// 	$meta_title 		= ($page->meta_title ? $page->meta_title : $page->layout->meta_title);
	// 	$meta_description 	= ($page->meta_description ? $page->meta_description : $page->layout->meta_description);
	// 	$meta_keywords 		= '';

	// 	if ($page->meta_keywords or $page->layout->meta_keywords) {

	// 		$meta_keywords = $page->meta_keywords ?
	// 							Keywords::get_string($page->meta_keywords) :
	// 							Keywords::get_string($page->layout->meta_keywords);
	// 	}

	// 	$meta_robots  = $page->meta_robots_no_index ? 'noindex' : 'index';
	// 	$meta_robots .= $page->meta_robots_no_follow ? ',nofollow' : ',follow';

	// 	if ( ! $meta_title) {

	// 		$meta_title = $page->is_home ? $this->settings->site_slogan : $page->title;
	// 	}


	// 	$this->template
	// 		 ->title('News')
	// 		 ->set_metadata('og:title', 'Tips and Tools', 'og')
	// 		 ->set_metadata('og:type', 'Tips and Tools', 'og')
	// 		 ->set_metadata('og:url', site_url().'news', 'og')
	// 		 ->set_metadata('og:description', $this->parser->parse_string($meta_description, $page, true), 'og')
	// 		 ->set_metadata('og:image', $page->images_share['image'], 'og')
	// 		 ->set_metadata('keywords', $this->parser->parse_string($meta_keywords, $page, true))
	// 		 ->set_metadata('robots', $meta_robots)
	// 		 ->set_metadata('description', $this->parser->parse_string($meta_description, $page, true))
	// 		 ->set('data_usr', $data_usr)
	// 		 ->set('is_liked', $is_liked)
	// 		 ->set('data_', $data_)
	// 		 ->set('likes_count', $likes_count)
	// 		 ->set('comments_count', $comments_count)
	// 		 ->set('ages', $ages)
	// 		 ->set('cats', $cats)
	// 		 ->set('id_cats', $id_cats)
	// 		 ->set('id_ages', $id_ages)
	// 		 ->build('index');
	// }

	// public function do_like(){
	// 	if($this->current_user){
	// 		if($this->input->is_ajax_request()) {
	// 			$user_id = $this->current_user->id;
	// 			$article_id = $this->input->post('article_id');

	// 			$already_like = $this->article_m->where(array('like_by'=>$user_id,'article_id'=>$article_id,))->count_data('article_likes');

	// 			if($already_like==0){
	// 				$this->like($user_id,$article_id);
	// 			}else{
	// 				$this->unlike($user_id,$article_id);
	// 			}
	// 		}else{
	// 			redirect();
	// 		}
	// 	}
	// }

	// private function like($user_id, $article_id){
	// 	$data=array('like_by'=>$user_id,'article_id'=>$article_id);

	// 	if($id=$this->article_m->insert_data('article_likes',$data)){
	// 		$ret['likes_count']=$this->count_like($article_id);
	// 		$ret['status']='liked';
	// 		echo json_encode($ret);
	// 	}
	// }

	// private function unlike($like_by,$article_id){
	// 	if($id=$this->article_m->del_data('article_likes',array('like_by'=>$like_by,'article_id'=>$article_id))){
	// 		$ret['likes_count']=$this->count_like($article_id);
	// 		$ret['status']='unliked';
	// 		echo json_encode($ret);
	// 	}
	// }

	// private function count_like($article_id){
	// 	return $this->article_m->where('article_id',$article_id)->count_data('article_likes');
	// }

	// public function send_comments() {

	// 	date_default_timezone_set('Asia/Jakarta');
	// 	$today 			= date("Y-m-d");
	// 	$tgl 			= date("j");
	// 	$bln 			= date("n");
	// 	$thn 			= date("Y");
	// 	$ret['status'] 	= false;
	// 	$er 		   	= array();

	// 	if($this->input->is_ajax_request()) {

 //            $data_sample = new stdClass;

	// 		$rules 	= array_merge($this->forms_validation);
	// 		$this->form_validation->set_rules($rules);

	// 		if($this->form_validation->run()) {

	// 			$extra = array(

	// 				'name'			=> $this->input->post('name'),
	// 				'email'			=> $this->input->post('email'),
	// 				'comments'      => $data = $this->security->xss_clean($this->input->post('comments')),
	// 				'article_id'	=> $this->input->post('article_id'),
	// 				'status'		=> 'draft',
	// 				'tgl'			=> $tgl,
	// 				'bulan'			=> $bln,
	// 				'tahun'			=> $thn,
	// 			);

	// 			if ($id = $this->article_m->insert_data('article_comments', $extra)) {

	// 				$ret['message'] = 'Comments successfully sent ';
	// 				$ret['status']  = true;
	// 			}else {

	// 				$ret['message'] = 'Cannot Send Comments at The Moment, please try again later.';
	// 				$ret['status']  = false;
	// 			}
	// 		}else {

	// 			$ret['status']      = false;
	// 			foreach( $rules as $field) {

	// 				if($field['field'] == 'name'){
	// 					$er[$field['field']] = '<p style="padding: 10px 0; color: red;">* Your Name [required]</p>';
	// 				}
	// 				else if($field['field'] == 'email'){
	// 					$er[$field['field']] = '<p style="padding: 10px 0; color: red;">* Your Email [required]</p>';
	// 				}
	// 				else if($field['field'] == 'comments'){
	// 					$er[$field['field']] = '<p style="padding: 10px 0; color: red;">* Your Comment [required]</p>';
	// 				}
	// 				// else if($field['field'] == 'g-recaptcha-response'){
	// 				// 	$er[$field['field']] = '<p style="padding: 10px 0; color: red;">* Capcha wrong</p>';
	// 				// }
	// 			}

	// 			$ret['error'] = $er;
	// 		}
 //            $data_sample = $ret;
 //            echo json_encode($ret);

 //        }else {

 //        	redirect();
 //        }
	// }

	// /*public function article_by($slug) {

	// 	$data_ = $this->article_m
	// 				  ->where(array('article.status' => 'live')
	// 				  ->order_by('article.article_id', 'DESC')
	// 				  //->limit($pagination['limit'], $pagination['offset'])
	// 				  ->limit(8)
	// 				  ->get_all_articles();

	// 	$data_usr='';
	// 	$is_liked=array();
	// 	if($this->current_user){
	// 		$usr=$this->current_user->id;
	// 		$data_usr=true;
	// 		foreach ($data_ as $value) {
	// 			$is_liked[$value->article_id] = $this->article_m
	// 					 		->where(array('like_by'=>$usr, 'article_id'=>$value->article_id))
	// 					 		->count_data('article_likes');
	// 		}
	// 	}

	// 	foreach ($data_ as $value) {
	// 		$comments_count[$value->article_id] = $this->article_m
	// 					 	   										->where(array('status' => 'live', 'article_id' => $value->article_id))
	// 					 	   										->count_data('article_comments');
	// 		$likes_count[$value->article_id] = $this->article_m
	// 					 	   										->where('article_id', $value->article_id)
	// 					 	   										->count_data('article_likes');
	// 	}

	// 	$page 				= $this->maxcache->model('page_m', 'get_by_uri', array('tips-and-tools', true));
	// 	$meta_title 		= ($page->meta_title ? $page->meta_title : $page->layout->meta_title);
	// 	$meta_description 	= ($page->meta_description ? $page->meta_description : $page->layout->meta_description);
	// 	$meta_keywords 		= '';

	// 	if ($page->meta_keywords or $page->layout->meta_keywords) {

	// 		$meta_keywords = $page->meta_keywords ?
	// 							Keywords::get_string($page->meta_keywords) :
	// 							Keywords::get_string($page->layout->meta_keywords);
	// 	}

	// 	$meta_robots  = $page->meta_robots_no_index ? 'noindex' : 'index';
	// 	$meta_robots .= $page->meta_robots_no_follow ? ',nofollow' : ',follow';

	// 	if ( ! $meta_title) {

	// 		$meta_title = $page->is_home ? $this->settings->site_slogan : $page->title;
	// 	}


	// 	$this->template
	// 		 ->title('Tips and Tools')
	// 		 ->set_metadata('og:title', 'Tips and Tools', 'og')
	// 		 ->set_metadata('og:type', 'Tips and Tools', 'og')
	// 		 ->set_metadata('og:url', site_url().'/tips-and-tools-by/'.$slug, 'og')
	// 		 ->set_metadata('og:description', $this->parser->parse_string($meta_description, $page, true), 'og')
	// 		 ->set_metadata('og:image', $page->images_share['image'], 'og')
	// 		 ->set_metadata('keywords', $this->parser->parse_string($meta_keywords, $page, true))
	// 		 ->set_metadata('robots', $meta_robots)
	// 		 ->set_metadata('description', $this->parser->parse_string($meta_description, $page, true))
	// 		 ->set('data_', $data_)
	// 		 ->set('data_usr', $data_usr)
	// 		 ->set('is_liked', $is_liked)
	// 		 ->set('likes_count', $likes_count)
	// 		 ->set('comments_count', $comments_count)
	// 		 //->set('pagination', $pagination)
	// 		 ->build('index');
	// }*/

	// public function article_by_ages($slug) {

	// 	$data_ = $this->article_m
	// 				  ->where(array('article.status' => 'live'))
	// 				  ->like('article.categories_id', ','.$slug.',')
	// 				  ->order_by('article.article_id', 'DESC')
	// 				  //->limit($pagination['limit'], $pagination['offset'])
	// 				  ->limit(8)
	// 				  ->get_all_articles();

	// 	$data_usr='';
	// 	$is_liked=array();
	// 	if($this->current_user){
	// 		$usr=$this->current_user->id;
	// 		$data_usr=true;
	// 		foreach ($data_ as $value) {
	// 			$is_liked[$value->article_id] = $this->article_m
	// 					 		->where(array('like_by'=>$usr, 'article_id'=>$value->article_id))
	// 					 		->count_data('article_likes');
	// 		}
	// 	}

	// 	foreach ($data_ as $value) {
	// 		$comments_count[$value->article_id] = $this->article_m
	// 					 	   										->where(array('status' => 'live', 'article_id' => $value->article_id))
	// 					 	   										->count_data('article_comments');
	// 		$likes_count[$value->article_id] = $this->article_m
	// 					 	   										->where('article_id', $value->article_id)
	// 					 	   										->count_data('article_likes');
	// 	}

	// 	$page 				= $this->maxcache->model('page_m', 'get_by_uri', array('tips-and-tools', true));
	// 	$meta_title 		= ($page->meta_title ? $page->meta_title : $page->layout->meta_title);
	// 	$meta_description 	= ($page->meta_description ? $page->meta_description : $page->layout->meta_description);
	// 	$meta_keywords 		= '';

	// 	if ($page->meta_keywords or $page->layout->meta_keywords) {

	// 		$meta_keywords = $page->meta_keywords ?
	// 							Keywords::get_string($page->meta_keywords) :
	// 							Keywords::get_string($page->layout->meta_keywords);
	// 	}

	// 	$meta_robots  = $page->meta_robots_no_index ? 'noindex' : 'index';
	// 	$meta_robots .= $page->meta_robots_no_follow ? ',nofollow' : ',follow';

	// 	if ( ! $meta_title) {

	// 		$meta_title = $page->is_home ? $this->settings->site_slogan : $page->title;
	// 	}


	// 	$this->template
	// 		 ->title('Tips and Tools')
	// 		 ->set_metadata('og:title', 'Tips and Tools', 'og')
	// 		 ->set_metadata('og:type', 'Tips and Tools', 'og')
	// 		 ->set_metadata('og:url', site_url().'/tips-and-tools-by-ages/'.$slug.'', 'og')
	// 		 ->set_metadata('og:description', $this->parser->parse_string($meta_description, $page, true), 'og')
	// 		 ->set_metadata('og:image', $page->images_share['image'], 'og')
	// 		 ->set_metadata('keywords', $this->parser->parse_string($meta_keywords, $page, true))
	// 		 ->set_metadata('robots', $meta_robots)
	// 		 ->set_metadata('description', $this->parser->parse_string($meta_description, $page, true))
	// 		 ->set('data_', $data_)
	// 		 ->set('data_usr', $data_usr)
	// 		 ->set('is_liked', $is_liked)
	// 		 ->set('likes_count', $likes_count)
	// 		 ->set('comments_count', $comments_count)
	// 		 //->set('pagination', $pagination)
	// 		 ->build('index');
	// }

	// public function article_by_cat($slug) {

	// 	$data_ = $this->article_m
	// 				  ->where(array('article.status' => 'live'))
	// 				  ->like('article.kidsage_id', ','.$slug.',')
	// 				  ->order_by('article.article_id', 'DESC')
	// 				  //->limit($pagination['limit'], $pagination['offset'])
	// 				  ->limit(8)
	// 				  ->get_all_articles();

	// 	$data_usr='';
	// 	$is_liked=array();
	// 	if($this->current_user){
	// 		$usr=$this->current_user->id;
	// 		$data_usr=true;
	// 		foreach ($data_ as $value) {
	// 			$is_liked[$value->article_id] = $this->article_m
	// 					 		->where(array('like_by'=>$usr, 'article_id'=>$value->article_id))
	// 					 		->count_data('article_likes');
	// 		}
	// 	}

	// 	foreach ($data_ as $value) {
	// 		$comments_count[$value->article_id] = $this->article_m
	// 					 	   										->where(array('status' => 'live', 'article_id' => $value->article_id))
	// 					 	   										->count_data('article_comments');
	// 		$likes_count[$value->article_id] = $this->article_m
	// 					 	   										->where('article_id', $value->article_id)
	// 					 	   										->count_data('article_likes');
	// 	}

	// 	$page 				= $this->maxcache->model('page_m', 'get_by_uri', array('tips-and-tools', true));
	// 	$meta_title 		= ($page->meta_title ? $page->meta_title : $page->layout->meta_title);
	// 	$meta_description 	= ($page->meta_description ? $page->meta_description : $page->layout->meta_description);
	// 	$meta_keywords 		= '';

	// 	if ($page->meta_keywords or $page->layout->meta_keywords) {

	// 		$meta_keywords = $page->meta_keywords ?
	// 							Keywords::get_string($page->meta_keywords) :
	// 							Keywords::get_string($page->layout->meta_keywords);
	// 	}

	// 	$meta_robots  = $page->meta_robots_no_index ? 'noindex' : 'index';
	// 	$meta_robots .= $page->meta_robots_no_follow ? ',nofollow' : ',follow';

	// 	if ( ! $meta_title) {

	// 		$meta_title = $page->is_home ? $this->settings->site_slogan : $page->title;
	// 	}


	// 	$this->template
	// 		 ->title('Tips and Tools')
	// 		 ->set_metadata('og:title', 'Tips and Tools', 'og')
	// 		 ->set_metadata('og:type', 'Tips and Tools', 'og')
	// 		 ->set_metadata('og:url', site_url().'/tips-and-tools-by-cat/'.$slug.'', 'og')
	// 		 ->set_metadata('og:description', $this->parser->parse_string($meta_description, $page, true), 'og')
	// 		 ->set_metadata('og:image', $page->images_share['image'], 'og')
	// 		 ->set_metadata('keywords', $this->parser->parse_string($meta_keywords, $page, true))
	// 		 ->set_metadata('robots', $meta_robots)
	// 		 ->set_metadata('description', $this->parser->parse_string($meta_description, $page, true))
	// 		 ->set('data_', $data_)
	// 		 ->set('data_usr', $data_usr)
	// 		 ->set('is_liked', $is_liked)
	// 		 ->set('likes_count', $likes_count)
	// 		 ->set('comments_count', $comments_count)
	// 		 //->set('pagination', $pagination)
	// 		 ->build('index');
	// }

	// public function load_more_click() {
	// 	/* set val ages */
	// 	$a = $this->input->post('data');
	// 	$cat = array();

	// 	if($a) {
	// 		foreach ($a as $key => $value) {


	// 			$b = $value['id'];
	// 			$c = $value['checked'];

	// 			if($c == 'true') {

	// 				$cat[] = $b;
	// 			}
	// 		}

	// 		if(count($cat)) {

	// 			$i = 0;
	// 			foreach ($cat as $value) {
	// 				if($i++ == 0) {

	// 			    	$this->article_m
	// 				 		 ->like('article.categories_id', ','.$value.',');
	// 			    }else {

	// 					$this->article_m
	// 				 		 ->or_like('article.categories_id', ','.$value.',');
	// 				}
	// 			}

	// 			// $this->article_m
	// 			// 	 ->join('(select*from default_article where default_article.categories_id like \'%,'.implode(',',$cat).'%\') as umur', 'umur.article_id = article.article_id');
	// 		}
	// 	}

	// 	/*set val kidsage or categori */
	// 	if($this->input->post('data_cat')) {
	// 		$v = $this->input->post('data_cat');
	// 		$tag = array();

	// 		foreach ($v as $keys => $values) {


	// 			$w = $values['id'];
	// 			$x = $values['checked'];

	// 			if($x == 'true') {

	// 				$tag[] = $w;
	// 			}
	// 		}

	// 		if(count($tag)) {

	// 			foreach ($tag as $value) {
	// 				$this->article_m
	// 				 ->like('article.kidsage_id', ','.$value.',');
	// 			}

	// 			// $this->article_m
	// 			// 	 ->like('article.kidsage_id', ','.implode(',',$tag).',');
	// 		}
	// 	}

	// 	$data_ = $this->article_m
	// 				  ->where(array('article.status' => 'live'))
	// 				  // ->order_by('article.article_id', 'DESC')
	// 				  //->limit($pagination['limit'], $pagination['offset'])
	// 				  ->limit(12, $this->input->post('last_id'))
	// 				  ->get_all_articles();

	// 	$do_like='do-login';
	// 	$liked='';
	// 	if($this->current_user){
	// 		$usr=$this->current_user->id;
	// 		$do_like='do-like';
	// 		foreach ($data_ as $value) {
	// 			$is_liked[$value->article_id] = $this->article_m
	// 					 		->where(array('like_by'=>$usr, 'article_id'=>$value->article_id))
	// 					 		->count_data('article_likes');
	// 		}
	// 	}

	// 	foreach ($data_ as $value) {
	// 		$comments_count[$value->article_id] = $this->article_m
	// 					 	   										->where(array('status' => 'live', 'article_id' => $value->article_id))
	// 					 	   										->count_data('article_comments');
	// 		$likes_count[$value->article_id] = $this->article_m
	// 					 	   										->where('article_id', $value->article_id)
	// 					 	   										->count_data('article_likes');
	// 	}

	// 	foreach ($data_ as $val) {
	// 	$src = SITE_URL('uploads/dummy.png');
 //        if($val->full_path !=''){
 //            $path = getcwd().'/'.$val->full_path;
 //            if(file_exists($path)){
 //                $src = base_url($val->full_path);
 //            }
 //        }
 //        if(isset($is_liked[$val->article_id]) && $is_liked[$val->article_id]==1){
 //        	$liked=' liked';
 //        }else{
 //        	$liked='';
 //        }
	// 	echo '
	// 		<li>
 //                <div class="article-list-wrap">
 //                    <div class="picture">';
 //                        echo '<img class="article-pict" src="'.$src.'" alt="'.$val->slug.'" title="'.$val->slug.'">';
 //                        echo '<img class="gelombang" src="'.SITE_URL('addons/default/themes/wyeth/img/gelombang.png').'">
 //                        <img class="gelombang-mobile" src="'.SITE_URL('addons/default/themes/wyeth/img/gelombang-mobile.png').'">
 //                        <div class="more-wrapper">
 //                            <div class="btn-read">
 //                                <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">read more</a>
 //                            </div>
 //                            <div class="comment-like">
 //                                <div class="comment-wrap">
 //                                    <div class="article-comment">
 //                                        <div class="total">
 //                                            <p><span>'.$comments_count[$val->article_id].'</span> comment</p>
 //                                        </div>
 //                                        <i class="ico-comment"></i>
 //                                    </div>
 //                                </div>
 //                                <div class="like-wrap">
 //                                    <div class="article-like">
 //                                        <a href=""><i class="ico-like '.$do_like.$liked.'" id="'.$val->article_id.'"></i></a>
 //                                        <div class="total">
 //                                            <p><span>'.$likes_count[$val->article_id].'</span> like</p>
 //                                        </div>
 //                                    </div>
 //                                </div>
 //                                <div class="clear"></div>
 //                            </div>';
 //                        echo '</div>
 //                    </div>
 //                    <div class="article-info">
 //                        <div class="article-info-wrap">
 //                            <h4 class="title">
 //                                <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">'.word_limiter(($val->title), 6).'</a>
 //                            </h4>
 //                            <p>
 //                                '.word_limiter(($val->intro), 9).'
 //                            </p>
 //                            <div class="detail">
 //                                <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">read more</a>
 //                            </div>
 //                        </div>
 //                    </div>
 //                    <a class="click-wholebox" href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'"></a>
 //                </div>
 //            </li>
 //            ';
	// 	}
	// }

	// public function load_more_search() {
	// 	/* set val ages */
	// 	$a = $this->input->post('data');
	// 	$cat = array();

	// 	if($a) {
	// 		foreach ($a as $key => $value) {


	// 			$b = $value['id'];
	// 			$c = $value['checked'];

	// 			if($c == 'true') {

	// 				$cat[] = $b;
	// 			}
	// 		}

	// 		if(count($cat)) {
	// 			$i 		= 0;
	// 			$quer 	= '';
	// 			foreach ($cat as $value) {

	// 				if($i == 0) {

	// 					$quer .= 'FIND_IN_SET(\''.$value.'\', default_article.categories_id) <> 0 ';
	// 				}else {

	// 					$quer .= 'OR FIND_IN_SET(\''.$value.'\', default_article.categories_id) <> 0 ';					}
	// 				$i++;

	// 				// if($value == 1) {
	// 				// 	$this->article_m
	// 			 // 	 		 ->join('(select*from default_article where default_article.categories_id like \'%,'.$value.'%\') as umur', 'umur.article_id = article.article_id', 'left');
	// 				// }

	// 				// if($value == 2) {
	// 				// 	$this->article_m
	// 			 // 	 		 ->join('(select*from default_article where default_article.categories_id like \'%,'.$value.'%\') as umur1', 'umur1.article_id = article.article_id', 'left');
	// 				// }

	// 				// if($value == 3) {
	// 				// 	$this->article_m
	// 			 // 	 		 ->join('(select*from default_article where default_article.categories_id like \'%,'.$value.'%\') as umur3', 'umur3.article_id = article.article_id', 'left');
	// 				// }
	// 				// if($i++ == 0) {

	// 			 //    	$this->article_m
	// 				//  		 ->like('article.categories_id', ','.$value.',');
	// 			 //    }else {

	// 					// $this->article_m
	// 			 	//  		 ->join('(select*from default_article where default_article.categories_id like \'%,'.$value.'%\') as umur', 'umur.article_id = article.article_id');
	// 				//}
	// 			}
	// 			// $this->article_m
	// 			// 	 ->join('(select*from default_article where default_article.categories_id like \'%,'.implode(',',$cat).'%\') as umur', 'umur.article_id = article.article_id');
	// 			$a = '('.$quer.')';
	// 			$this->db->where($a);
	// 		}
	// 	}

	// 	/*set val kidsage or categori */
	// 	if($this->input->post('data_cat')) {
	// 		$v = $this->input->post('data_cat');
	// 		$tag = array();

	// 		foreach ($v as $keys => $values) {


	// 			$w = $values['id'];
	// 			$x = $values['checked'];

	// 			if($x == 'true') {

	// 				$tag[] = $w;
	// 			}
	// 		}

	// 		if(count($tag)) {
	// 			$xx = 0;
	// 			//$string_builder = 'WHERE';
	// 			$string_builder = '';
	// 			foreach ($tag as $vals) {

	// 				if($xx == 0) {

	// 					//$string_builder .= 'default_article.kidsage_id LIKE \'%,' .$vals. ',%\'';
	// 					$string_builder .= 'FIND_IN_SET(\''.$vals.'\', default_article.kidsage_id) != 0 ';
	// 				}else {

	// 					//$string_builder .= 'OR default_article.kidsage_id LIKE \'%,' .$vals. ',%\'';
	// 					$string_builder .= 'OR FIND_IN_SET(\''.$vals.'\', default_article.kidsage_id) != 0 ';					}
	// 				$xx++;
	// 			}

	// 			$s = '('.$string_builder.')';
	// 			$this->db->where($s);
	// 			// $this->article_m
	// 			// 	->join('(SELECT * FROM default_article '.$string_builder.' ) AS kidsage', 'kidsage.article_id = article.article_id');
	// 		}
	// 	}

	// 	if($this->input->post('search') != '') {

	// 		$data_ = $this->article_m
	// 					  //->where(array('article.status' => 'live'))
	// 					  ->like('article.title', $this->input->post('search'))
	// 					  ->or_like(
	// 					  		array(
	// 					  			'article.intro' => $this->input->post('search'),
	// 					  			'article.meta_keyword' => $this->input->post('search'),
	// 					  			'article.description' => $this->input->post('search')
	// 					  		)
	// 					  	)
	// 					  ->limit(12, $this->input->post('last_id'))
	// 					  ->order_by('article.article_id', 'DESC')
	// 					  // ->limit(8)
	// 					  ->get_all_articles_live();


	// 	}else {
	// 		$data_ = $this->article_m
	// 					  //->where(array('article.status' => 'live'))
	// 					  ->order_by('article.article_id', 'DESC')
	// 					  ->limit(12, $this->input->post('last_id'))
	// 					  ->get_all_articles_live();
	// 	}

	// 	$do_like='do-login';
	// 		$liked='';
	// 		if($this->current_user){
	// 			$usr=$this->current_user->id;
	// 			$do_like='do-like';
	// 			foreach ($data_ as $value) {
	// 				$is_liked[$value->article_id] = $this->article_m
	// 						 		->where(array('like_by'=>$usr, 'article_id'=>$value->article_id))
	// 						 		->count_data('article_likes');
	// 			}
	// 		}


	// 	foreach ($data_ as $value) {
	// 		$comments_count[$value->article_id] = $this->article_m
	// 					 	   										->where(array('status' => 'live', 'article_id' => $value->article_id))
	// 					 	   										->count_data('article_comments');
	// 		$likes_count[$value->article_id] = $this->article_m
	// 					 	   										->where('article_id', $value->article_id)
	// 					 	   										->count_data('article_likes');
	// 	}

	// 	// $data_ = $this->article_m
	// 	// 			  ->where(array('article.status' => 'live'))
	// 	// 			  ->order_by('article.article_id', 'DESC')
	// 	// 			  //->limit($pagination['limit'], $pagination['offset'])
	// 	// 			  ->limit(12, $this->input->post('last_id'))
	// 	// 			  ->get_all_articles();

	// 	foreach ($data_ as $val) {
	// 	$src = SITE_URL('uploads/dummy.png');
 //        if($val->full_path !=''){
 //            $path = getcwd().'/'.$val->full_path;
 //            if(file_exists($path)){
 //                $src = base_url($val->full_path);
 //            }
 //        }
 //        if(isset($is_liked[$val->article_id]) && $is_liked[$val->article_id]==1){
 //        	$liked=' liked';
 //        }else{
 //        	$liked='';
 //        }
	// 	echo '
	// 		<li>
 //                <div class="article-list-wrap">
 //                    <div class="picture">';
 //                        echo '<img class="article-pict" src="'.$src.'" alt="'.$val->slug.'" title="'.$val->slug.'">';
 //                        echo '<img class="gelombang" src="'.SITE_URL('addons/default/themes/wyeth/img/gelombang.png').'">
 //                        <img class="gelombang-mobile" src="'.SITE_URL('addons/default/themes/wyeth/img/gelombang-mobile.png').'">
 //                        <div class="more-wrapper">
 //                            <div class="btn-read">
 //                                <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">read more</a>
 //                            </div>
 //                            <div class="comment-like">
 //                                <div class="comment-wrap">
 //                                    <div class="article-comment">
 //                                        <div class="total">
 //                                            <p><span>'.$comments_count[$val->article_id].'</span> comment</p>
 //                                        </div>
 //                                        <i class="ico-comment"></i>
 //                                    </div>
 //                                </div>
 //                                <div class="like-wrap">
 //                                    <div class="article-like">
 //                                        <a href=""><i class="ico-like '.$do_like.$liked.'" id="'.$val->article_id.'"></i></a>
 //                                        <div class="total">
 //                                            <p><span>'.$likes_count[$val->article_id].'</span> like</p>
 //                                        </div>
 //                                    </div>
 //                                </div>
 //                                <div class="clear"></div>
 //                            </div>';
 //                        echo '</div>
 //                    </div>
 //                    <div class="article-info">
 //                        <div class="article-info-wrap">
 //                            <h4 class="title">
 //                                <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">'.word_limiter(($val->title), 6).'</a>
 //                            </h4>
 //                            <p>
 //                                '.word_limiter(($val->intro), 9).'
 //                            </p>
 //                            <div class="detail">
 //                                <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">read more</a>
 //                            </div>
 //                        </div>
 //                    </div>
 //                    <a class="click-wholebox" href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'"></a>
 //                </div>
 //            </li>
 //            ';
	// 	}
	// }

	// public function show_click() {
	// 	if($this->input->is_ajax_request()) {
	// 		/* set val ages */
	// 		$a = $this->input->post('data');
	// 		$cat = array();

	// 		if($a) {
	// 			foreach ($a as $key => $value) {


	// 				$b = $value['id'];
	// 				$c = $value['checked'];

	// 				if($c == 'true') {

	// 					$cat[] = $b;
	// 				}
	// 			}

	// 			if(count($cat)) {
	// 				$i 		= 0;
	// 				$quer 	= '';
	// 				foreach ($cat as $value) {

	// 					if($i == 0) {

	// 						$quer .= 'FIND_IN_SET(\''.$value.'\', default_article.categories_id) <> 0 ';
	// 					}else {

	// 						$quer .= 'OR FIND_IN_SET(\''.$value.'\', default_article.categories_id) <> 0 ';					}
	// 					$i++;

	// 					// if($value == 1) {
	// 					// 	$this->article_m
	// 				 // 	 		 ->join('(select*from default_article where default_article.categories_id like \'%,'.$value.'%\') as umur', 'umur.article_id = article.article_id', 'left');
	// 					// }

	// 					// if($value == 2) {
	// 					// 	$this->article_m
	// 				 // 	 		 ->join('(select*from default_article where default_article.categories_id like \'%,'.$value.'%\') as umur1', 'umur1.article_id = article.article_id', 'left');
	// 					// }

	// 					// if($value == 3) {
	// 					// 	$this->article_m
	// 				 // 	 		 ->join('(select*from default_article where default_article.categories_id like \'%,'.$value.'%\') as umur3', 'umur3.article_id = article.article_id', 'left');
	// 					// }
	// 					// if($i++ == 0) {

	// 				 //    	$this->article_m
	// 					//  		 ->like('article.categories_id', ','.$value.',');
	// 				 //    }else {

	// 						// $this->article_m
	// 				 	//  		 ->join('(select*from default_article where default_article.categories_id like \'%,'.$value.'%\') as umur', 'umur.article_id = article.article_id');
	// 					//}
	// 				}
	// 				// $this->article_m
	// 				// 	 ->join('(select*from default_article where default_article.categories_id like \'%,'.implode(',',$cat).'%\') as umur', 'umur.article_id = article.article_id');
	// 				$a = '('.$quer.')';
	// 				$this->db->where($a);
	// 			}
	// 		}

	// 		/*set val kidsage or categori */
	// 		if($this->input->post('data_cat')) {
	// 			$v = $this->input->post('data_cat');
	// 			$tag = array();

	// 			foreach ($v as $keys => $values) {


	// 				$w = $values['id'];
	// 				$x = $values['checked'];

	// 				if($x == 'true') {

	// 					$tag[] = $w;
	// 				}
	// 			}

	// 			if(count($tag)) {
	// 				$xx = 0;
	// 				//$string_builder = 'WHERE';
	// 				$string_builder = '';
	// 				foreach ($tag as $vals) {

	// 					if($xx == 0) {

	// 						//$string_builder .= 'default_article.kidsage_id LIKE \'%,' .$vals. ',%\'';
	// 						$string_builder .= 'FIND_IN_SET(\''.$vals.'\', default_article.kidsage_id) != 0 ';
	// 					}else {

	// 						//$string_builder .= 'OR default_article.kidsage_id LIKE \'%,' .$vals. ',%\'';
	// 						$string_builder .= 'OR FIND_IN_SET(\''.$vals.'\', default_article.kidsage_id) != 0 ';					}
	// 					$xx++;
	// 				}

	// 				$s = '('.$string_builder.')';
	// 				$this->db->where($s);
	// 				// $this->article_m
	// 				// 	->join('(SELECT * FROM default_article '.$string_builder.' ) AS kidsage', 'kidsage.article_id = article.article_id');
	// 			}
	// 		}

	// 		$data_ = $this->article_m
	// 						  //->where(array('article.status' => 'live'))
	// 						  ->order_by('article.article_id', 'DESC')
	// 						  ->limit(12, $this->input->post('last_id'))
	// 						  ->get_all_articles_live();

	// 		foreach ($data_ as $value) {
	// 			$comments_count[$value->article_id] = $this->article_m
	// 						 	   										->where(array('status' => 'live', 'article_id' => $value->article_id))
	// 						 	   										->count_data('article_comments');
	// 			$likes_count[$value->article_id] = $this->article_m
	// 						 	   										->where('article_id', $value->article_id)
	// 						 	   										->count_data('article_likes');
	// 		}
	// 		foreach ($data_ as $val) {
	// 		$src = SITE_URL('uploads/dummy.png');
	//         if($val->full_path !=''){
	//             $path = getcwd().'/'.$val->full_path;
	//             if(file_exists($path)){
	//                 $src = base_url($val->full_path);
	//             }
	//         }
	// 		echo '
	// 			<li>
	// 		        <div class="article-list-wrap">
	// 		            <div class="picture">';
	// 		                echo '<img class="article-pict" src="'.$src.'" alt="'.$val->slug.'" title="'.$val->slug.'">';
	// 		                echo '<img class="gelombang" src="'.SITE_URL('addons/default/themes/wyeth/img/gelombang.png').'">
	// 		                <img class="gelombang-mobile" src="'.SITE_URL('addons/default/themes/wyeth/img/gelombang-mobile.png').'">
	// 		                <div class="more-wrapper">
	// 		                    <div class="btn-read">
	// 		                        <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">read more</a>
	// 		                    </div>
	// 		                    <div class="comment-like">
	// 		                        <div class="comment-wrap">
	// 		                            <div class="article-comment">
	// 		                                <div class="total">
	// 		                                    <p><span>'.$comments_count[$val->article_id].'</span> comment</p>
	// 		                                </div>
	// 		                                <i class="ico-comment"></i>
	// 		                            </div>
	// 		                        </div>
	// 		                        <div class="like-wrap">
	// 		                            <div class="article-like">
	// 		                                <i class="ico-like"></i>
	// 		                                <div class="total">
	// 		                                    <p><span>'.$likes_count[$val->article_id].'</span> like</p>
	// 		                                </div>
	// 		                            </div>
	// 		                        </div>
	// 		                        <div class="clear"></div>
	// 		                    </div>';
	// 		                echo '</div>
	// 		            </div>
	// 		            <div class="article-info">
	// 		                <div class="article-info-wrap">
	// 		                    <h4 class="title">
	// 		                        <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">'.word_limiter(($val->title), 6).'</a>
	// 		                    </h4>
	// 		                    <p>
	// 		                        '.word_limiter(($val->intro), 9).'
	// 		                    </p>
	// 		                    <div class="detail">
	// 		                        <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">read more</a>
	// 		                    </div>
	// 		                </div>
	// 		            </div>
	// 		            <a class="click-wholebox" href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'"></a>
	// 		        </div>
	// 		    </li>
	// 		';
	// 		}
	// 	}else {redirect('tips-and-tools');}
	// }

	// public function show_landing() {
	// 	/* set val ages */
	// 	if($this->input->is_ajax_request()) {
	// 		$a = $this->input->post('data');
	// 		$cat = array();

	// 		if($a) {
	// 			foreach ($a as $key => $value) {


	// 				$b = $value['id'];
	// 				$c = $value['checked'];

	// 				if($c == 'true') {

	// 					$cat[] = $b;
	// 				}
	// 			}

	// 			if(count($cat)) {
	// 				$i 		= 0;
	// 				$quer 	= '';
	// 				foreach ($cat as $value) {
	// 					// if($i++ == 0) {

	// 				 //    	$this->article_m
	// 					//  		 ->like('article.categories_id', ','.$value.',');
	// 				 //    }else {

	// 					// 	$this->article_m
	// 					//  		 ->or_like('article.categories_id', ','.$value.',');
	// 					// }

	// 					if($i == 0) {

	// 						$quer .= 'FIND_IN_SET(\''.$value.'\', default_article.categories_id) <> 0 ';
	// 					}else {

	// 						$quer .= 'OR FIND_IN_SET(\''.$value.'\', default_article.categories_id) <> 0 ';					}
	// 					$i++;

	// 					$a = '('.$quer.')';
	// 					$this->db->where($a);
	// 				}
	// 				// $this->article_m
	// 				// 	 ->join('(select*from default_article where default_article.categories_id like \'%,'.implode(',',$cat).'%\') as umur', 'umur.article_id = article.article_id');
	// 			}
	// 		}

	// 		/*set val kidsage or categori */
	// 		if($this->input->post('data_cat')) {
	// 			$v = $this->input->post('data_cat');
	// 			$tag = array();

	// 			foreach ($v as $keys => $values) {


	// 				$w = $values['id'];
	// 				$x = $values['checked'];

	// 				if($x == 'true') {

	// 					$tag[] = $w;
	// 				}
	// 			}

	// 			if(count($tag)) {

	// 				$xx = 0;
	// 				$string_builder = '';

	// 				// foreach ($tag as $value) {
	// 				// 	$this->article_m
	// 				// 	 ->like('article.kidsage_id', ','.$value.',');
	// 				// }

	// 				// $this->article_m
	// 				// 	 ->like('article.kidsage_id', ','.implode(',',$tag).',');

	// 				foreach ($tag as $vals) {

	// 					if($xx == 0) {

	// 						//$string_builder .= 'default_article.kidsage_id LIKE \'%,' .$vals. ',%\'';
	// 						$string_builder .= 'FIND_IN_SET(\''.$vals.'\', default_article.kidsage_id) != 0 ';
	// 					}else {

	// 						//$string_builder .= 'OR default_article.kidsage_id LIKE \'%,' .$vals. ',%\'';
	// 						$string_builder .= 'OR FIND_IN_SET(\''.$vals.'\', default_article.kidsage_id) != 0 ';					}
	// 					$xx++;
	// 				}

	// 				$s = '('.$string_builder.')';
	// 				$this->db->where($s);
	// 			}
	// 		}

	// 		$data_ = $this->article_m
	// 						  //->where(array('article.status' => 'live'))
	// 						  ->order_by('article.article_id', 'DESC')
	// 						  ->limit(12, $this->input->post('last_id'))
	// 						  ->get_all_articles_live();

	// 		$do_like='do-login';
	// 		$liked='';
	// 		if($this->current_user){
	// 			$usr=$this->current_user->id;
	// 			$do_like='do-like';
	// 			foreach ($data_ as $value) {
	// 				$is_liked[$value->article_id] = $this->article_m
	// 						 		->where(array('like_by'=>$usr, 'article_id'=>$value->article_id))
	// 						 		->count_data('article_likes');
	// 			}
	// 		}

	// 		foreach ($data_ as $value) {
	// 			$comments_count[$value->article_id] = $this->article_m
	// 						 	   										->where(array('status' => 'live', 'article_id' => $value->article_id))
	// 						 	   										->count_data('article_comments');
	// 			$likes_count[$value->article_id] = $this->article_m
	// 						 	   										->where('article_id', $value->article_id)
	// 						 	   										->count_data('article_likes');
	// 		}

	// 		foreach ($data_ as $val) {
	// 			$src = SITE_URL('uploads/dummy.png');
	// 	        if($val->full_path !=''){
	// 	            $path = getcwd().'/'.$val->full_path;
	// 	            if(file_exists($path)){
	// 	                $src = base_url($val->full_path);
	// 	            }
	// 	        }
	// 	        if(isset($is_liked[$val->article_id]) && $is_liked[$val->article_id]==1){
	//             	$liked=' liked';
	//             }else{
	// 	        	$liked='';
	// 	        }
	// 		echo '
	// 			<li>
	// 		        <div class="article-list-wrap">
	// 		            <div class="picture">';
	// 		                echo '<img class="article-pict" src="'.$src.'" alt="'.$val->slug.'" title="'.$val->slug.'">';
	// 		                echo '<img class="gelombang" src="'.SITE_URL('addons/default/themes/wyeth/img/gelombang.png').'">
	// 		                <img class="gelombang-mobile" src="'.SITE_URL('addons/default/themes/wyeth/img/gelombang-mobile.png').'">
	// 		                <div class="more-wrapper">
	// 		                    <div class="btn-read">
	// 		                        <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">read more</a>
	// 		                    </div>
	// 		                    <div class="comment-like">
	// 		                        <div class="comment-wrap">
	// 		                            <div class="article-comment">
	// 		                                <div class="total">
	// 		                                    <p><span>'.$comments_count[$val->article_id].'</span> comment</p>
	// 		                                </div>
	// 		                                <i class="ico-comment"></i>
	// 		                            </div>
	// 		                        </div>
	// 		                        <div class="like-wrap">
	// 		                            <div class="article-like">
	// 		                                <a href=""><i class="ico-like '.$do_like.$liked.'" id="'.$val->article_id.'"></i></a>
	// 		                                <div class="total">
	// 		                                    <p><span>'.$likes_count[$val->article_id].'</span> like</p>
	// 		                                </div>
	// 		                            </div>
	// 		                        </div>
	// 		                        <div class="clear"></div>
	// 		                    </div>';
	// 		                echo '</div>
	// 		            </div>
	// 		            <div class="article-info">
	// 		                <div class="article-info-wrap">
	// 		                    <h4 class="title">
	// 		                        <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">'.word_limiter(($val->title), 6).'</a>
	// 		                    </h4>
	// 		                    <p>
	// 		                        '.word_limiter(($val->intro), 9).'
	// 		                    </p>
	// 		                    <div class="detail">
	// 		                        <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">read more</a>
	// 		                    </div>
	// 		                </div>
	// 		            </div>
	// 		            <a class="click-wholebox" href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'"></a>
	// 		        </div>
	// 		    </li>
	// 		';
	// 		}
	// 	}else {
	// 		redirect('tips-and-tools');
	// 	}
	// }

	// public function search() {

	// 	$comments_count = '';
	// 	$likes_count = '';
	// 	$data_ = '';

	// 	//$data_sample = new stdClass;
	// 	$rules 	= array_merge($this->search);
	// 	$this->form_validation->set_rules($rules);

	// 	if($this->input->post('search') != '') {

	// 		if($this->form_validation->run()) {

	// 			$data_ = $this->article_m
	// 						  ->where(array('article.status' => 'live'))
	// 						  ->like('article.title', $this->input->post('search'))
	// 						  ->or_like(
	// 						  		array(
	// 						  			'article.intro' => $this->input->post('search'),
	// 						  			'article.meta_keyword' => $this->input->post('search'),
	// 						  			'article.description' => $this->input->post('search')
	// 						  		)
	// 						  	)
	// 						  ->limit(12, 0)
	// 						  ->order_by('article.article_id', 'DESC')
	// 						  // ->limit(8)
	// 						  ->get_all_articles();

	// 		}
	// 	}else {
	// 		$data_ = $this->article_m
	// 					  ->where(array('article.status' => 'live'))
	// 					  ->order_by('article.article_id', 'DESC')
	// 					  ->limit(12, 0)
	// 					  ->get_all_articles();
	// 	}

	// 	$data_usr = '';
	// 	$is_liked = '';
	// 	if($data_ != '') {

	// 		$is_liked=array();
	// 		if($this->current_user){
	// 			$usr=$this->current_user->id;
	// 			$data_usr=true;
	// 			foreach ($data_ as $value) {
	// 				$is_liked[$value->article_id] = $this->article_m
	// 						 		->where(array('like_by'=>$usr, 'article_id'=>$value->article_id))
	// 						 		->count_data('article_likes');
	// 			}
	// 		}

	// 		foreach ($data_ as $value) {
	// 			$comments_count[$value->article_id] = $this->article_m
	// 						 	   										->where(array('status' => 'live', 'article_id' => $value->article_id))
	// 						 	   										->count_data('article_comments');
	// 			$likes_count[$value->article_id] = $this->article_m
	// 						 	   										->where('article_id', $value->article_id)
	// 						 	   										->count_data('article_likes');
	// 		}
	// 	}

	// 	$page 				= $this->maxcache->model('page_m', 'get_by_uri', array('tips-and-tools', true));
	// 	$meta_title 		= ($page->meta_title ? $page->meta_title : $page->layout->meta_title);
	// 	$meta_description 	= ($page->meta_description ? $page->meta_description : $page->layout->meta_description);
	// 	$meta_keywords 		= '';

	// 	if ($page->meta_keywords or $page->layout->meta_keywords) {

	// 		$meta_keywords = $page->meta_keywords ?
	// 							Keywords::get_string($page->meta_keywords) :
	// 							Keywords::get_string($page->layout->meta_keywords);
	// 	}

	// 	$meta_robots  = $page->meta_robots_no_index ? 'noindex' : 'index';
	// 	$meta_robots .= $page->meta_robots_no_follow ? ',nofollow' : ',follow';

	// 	if ( ! $meta_title) {

	// 		$meta_title = $page->is_home ? $this->settings->site_slogan : $page->title;
	// 	}

	// 	// $data_ = $this->article_m
	// 	// 			  ->where(array('article.status' => 'live'))
	// 	// 			  ->order_by('article.article_id', 'DESC')
	// 	// 			  ->limit(12, 0)
	// 	// 			  ->get_all_articles();

	// 	$ages = $this->article_m
	// 				  ->where(array('status' => 'live'))
	// 				  ->order_by('sort_no','ASC')
	// 				  ->get_all_data('article_categories');

	// 	$cats = $this->article_m
	// 				  ->where(array('status' => 'live'))
	// 				  ->order_by('sort_by','ASC')
	// 				  ->get_all_data('article_kidsage');

	// 	$this->template
	// 		 ->title('News')
	// 		 ->set_metadata('og:title', 'Search', 'og')
	// 		 ->set_metadata('og:type', 'Search', 'og')
	// 		 ->set_metadata('og:url', site_url().'search', 'og')
	// 		 ->set_metadata('og:description', $this->parser->parse_string($meta_description, $page, true), 'og')
	// 		 ->set_metadata('og:image', $page->images_share['image'], 'og')
	// 		 ->set_metadata('keywords', $this->parser->parse_string($meta_keywords, $page, true))
	// 		 ->set_metadata('robots', $meta_robots)
	// 		 ->set_metadata('description', $this->parser->parse_string($meta_description, $page, true))
	// 		 ->set('likes_count', $likes_count)
	// 		 ->set('data_usr', $data_usr)
	// 		 ->set('is_liked', $is_liked)
	// 		 ->set('comments_count', $comments_count)
	// 		 ->set('data_', $data_)
	// 		 ->set('kata', $this->input->post('search'))
	// 		 ->set('ages', $ages)
	// 		 ->set('cats', $cats)
	// 		 //->set('pagination', $pagination)
	// 		 ->build('index');
	// }

	// public function show_more() {
	// 	/* set val ages */
	// 	$a = $this->input->post('data');
	// 	$cat = array();

	// 	if($a) {
	// 		foreach ($a as $key => $value) {


	// 			$b = $value['id'];
	// 			$c = $value['checked'];

	// 			if($c == 'true') {

	// 				$cat[] = $b;
	// 			}
	// 		}

	// 		if(count($cat)) {
	// 			$i 		= 0;
	// 			$quer 	= '';
	// 			foreach ($cat as $value) {

	// 				if($i == 0) {

	// 					$quer .= 'FIND_IN_SET(\''.$value.'\', default_article.categories_id) <> 0 ';
	// 				}else {

	// 					$quer .= 'OR FIND_IN_SET(\''.$value.'\', default_article.categories_id) <> 0 ';					}
	// 				$i++;

	// 				// if($value == 1) {
	// 				// 	$this->article_m
	// 			 // 	 		 ->join('(select*from default_article where default_article.categories_id like \'%,'.$value.'%\') as umur', 'umur.article_id = article.article_id', 'left');
	// 				// }

	// 				// if($value == 2) {
	// 				// 	$this->article_m
	// 			 // 	 		 ->join('(select*from default_article where default_article.categories_id like \'%,'.$value.'%\') as umur1', 'umur1.article_id = article.article_id', 'left');
	// 				// }

	// 				// if($value == 3) {
	// 				// 	$this->article_m
	// 			 // 	 		 ->join('(select*from default_article where default_article.categories_id like \'%,'.$value.'%\') as umur3', 'umur3.article_id = article.article_id', 'left');
	// 				// }
	// 				// if($i++ == 0) {

	// 			 //    	$this->article_m
	// 				//  		 ->like('article.categories_id', ','.$value.',');
	// 			 //    }else {

	// 					// $this->article_m
	// 			 	//  		 ->join('(select*from default_article where default_article.categories_id like \'%,'.$value.'%\') as umur', 'umur.article_id = article.article_id');
	// 				//}
	// 			}
	// 			// $this->article_m
	// 			// 	 ->join('(select*from default_article where default_article.categories_id like \'%,'.implode(',',$cat).'%\') as umur', 'umur.article_id = article.article_id');
	// 			$a = '('.$quer.')';
	// 			$this->db->where($a);
	// 		}
	// 	}

	// 	/*set val kidsage or categori */
	// 	if($this->input->post('data_cat')) {
	// 		$v = $this->input->post('data_cat');
	// 		$tag = array();

	// 		foreach ($v as $keys => $values) {


	// 			$w = $values['id'];
	// 			$x = $values['checked'];

	// 			if($x == 'true') {

	// 				$tag[] = $w;
	// 			}
	// 		}

	// 		if(count($tag)) {
	// 			$xx = 0;
	// 			//$string_builder = 'WHERE';
	// 			$string_builder = '';
	// 			foreach ($tag as $vals) {

	// 				if($xx == 0) {

	// 					//$string_builder .= 'default_article.kidsage_id LIKE \'%,' .$vals. ',%\'';
	// 					$string_builder .= 'FIND_IN_SET(\''.$vals.'\', default_article.kidsage_id) != 0 ';
	// 				}else {

	// 					//$string_builder .= 'OR default_article.kidsage_id LIKE \'%,' .$vals. ',%\'';
	// 					$string_builder .= 'OR FIND_IN_SET(\''.$vals.'\', default_article.kidsage_id) != 0 ';					}
	// 				$xx++;
	// 			}

	// 			$s = '('.$string_builder.')';
	// 			$this->db->where($s);
	// 			// $this->article_m
	// 			// 	->join('(SELECT * FROM default_article '.$string_builder.' ) AS kidsage', 'kidsage.article_id = article.article_id');
	// 		}
	// 	}

	// 	$data_ = $this->article_m
	// 					  //->where(array('article.status' => 'live'))
	// 					  ->order_by('article.article_id', 'DESC')
	// 					  ->limit(12, $this->input->post('last_id'))
	// 					  ->get_all_articles_live();

	// 	$data_usr='';
	// 	$is_liked=array();
	// 	if($this->current_user){
	// 		$usr=$this->current_user->id;
	// 		$data_usr=true;
	// 		foreach ($data_ as $value) {
	// 			$is_liked[$value->article_id] = $this->article_m
	// 					 		->where(array('like_by'=>$usr, 'article_id'=>$value->article_id))
	// 					 		->count_data('article_likes');
	// 		}
	// 	}

	// 	foreach ($data_ as $value) {
	// 		$comments_count[$value->article_id] = $this->article_m
	// 					 	   										->where(array('status' => 'live', 'article_id' => $value->article_id))
	// 					 	   										->count_data('article_comments');
	// 		$likes_count[$value->article_id] = $this->article_m
	// 					 	   										->where('article_id', $value->article_id)
	// 					 	   										->count_data('article_likes');
	// 	}

	// 	foreach ($data_ as $val) {
	// 			$src = SITE_URL('uploads/dummy.png');
	// 	        if($val->full_path !=''){
	// 	            $path = getcwd().'/'.$val->full_path;
	// 	            if(file_exists($path)){
	// 	                $src = base_url($val->full_path);
	// 	            }
	// 	        }
	// 	        if(isset($is_liked[$val->article_id]) && $is_liked[$val->article_id]==1){
	//             	$liked=' liked';
	//             }else{
	// 	        	$liked='';
	// 	        }
	// 		echo '
	// 			<li>
	// 		        <div class="article-list-wrap">
	// 		            <div class="picture">';
	// 		                echo '<img class="article-pict" src="'.$src.'" alt="'.$val->slug.'" title="'.$val->slug.'">';
	// 		                echo '<img class="gelombang" src="'.SITE_URL('addons/default/themes/wyeth/img/gelombang.png').'">
	// 		                <img class="gelombang-mobile" src="'.SITE_URL('addons/default/themes/wyeth/img/gelombang-mobile.png').'">
	// 		                <div class="more-wrapper">
	// 		                    <div class="btn-read">
	// 		                        <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">read more</a>
	// 		                    </div>
	// 		                    <div class="comment-like">
	// 		                        <div class="comment-wrap">
	// 		                            <div class="article-comment">
	// 		                                <div class="total">
	// 		                                    <p><span>'.$comments_count[$val->article_id].'</span> comment</p>
	// 		                                </div>
	// 		                                <i class="ico-comment"></i>
	// 		                            </div>
	// 		                        </div>
	// 		                        <div class="like-wrap">
	// 		                            <div class="article-like">
	// 		                                <a href=""><i class="ico-like '.$do_like.$liked.'" id="'.$val->article_id.'"></i></a>
	// 		                                <div class="total">
	// 		                                    <p><span>'.$likes_count[$val->article_id].'</span> like</p>
	// 		                                </div>
	// 		                            </div>
	// 		                        </div>
	// 		                        <div class="clear"></div>
	// 		                    </div>';
	// 		                echo '</div>
	// 		            </div>
	// 		            <div class="article-info">
	// 		                <div class="article-info-wrap">
	// 		                    <h4 class="title">
	// 		                        <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">'.word_limiter(($val->title), 6).'</a>
	// 		                    </h4>
	// 		                    <p>
	// 		                        '.word_limiter(($val->intro), 9).'
	// 		                    </p>
	// 		                    <div class="detail">
	// 		                        <a href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'">read more</a>
	// 		                    </div>
	// 		                </div>
	// 		            </div>
	// 		            <a class="click-wholebox" href="'.SITE_URL().'tips-and-tools-detail/'.$val->slug.'"></a>
	// 		        </div>
	// 		    </li>
	// 		';
	// 		}
	// }

	// public function live_chat() {

	// 	$page 				= $this->maxcache->model('page_m', 'get_by_uri', array('ask-the-expert', true));
	// 	$meta_title 		= ($page->meta_title ? $page->meta_title : $page->layout->meta_title);
	// 	$meta_description 	= ($page->meta_description ? $page->meta_description : $page->layout->meta_description);
	// 	$meta_keywords 		= '';

	// 	if ($page->meta_keywords or $page->layout->meta_keywords) {

	// 		$meta_keywords = $page->meta_keywords ?
	// 							Keywords::get_string($page->meta_keywords) :
	// 							Keywords::get_string($page->layout->meta_keywords);
	// 	}

	// 	$meta_robots  = $page->meta_robots_no_index ? 'noindex' : 'index';
	// 	$meta_robots .= $page->meta_robots_no_follow ? ',nofollow' : ',follow';

	// 	if ( ! $meta_title) {

	// 		$meta_title = $page->is_home ? $this->settings->site_slogan : $page->title;
	// 	}


	// 	$this->template
	// 		 ->title('News')
	// 		 ->set_metadata('og:title', 'Ask The Expert', 'og')
	// 		 ->set_metadata('og:type', 'ask-the-expert', 'og')
	// 		 ->set_metadata('og:url', site_url().'ask-the-expert/live-chat', 'og')
	// 		 ->set_metadata('og:description', $this->parser->parse_string($meta_description, $page, true), 'og')
	// 		 ->set_metadata('og:image', $page->images_share['image'], 'og')
	// 		 ->set_metadata('keywords', $this->parser->parse_string($meta_keywords, $page, true))
	// 		 ->set_metadata('robots', $meta_robots)
	// 		 ->set_metadata('description', $this->parser->parse_string($meta_description, $page, true))
	// 		 ->build('index');
	// }

	// public function get_article_static() {

	// 	$page 				= $this->maxcache->model('page_m', 'get_by_uri', array('news-and-event', true));
	// 	$meta_title 		= ($page->meta_title ? $page->meta_title : $page->layout->meta_title);
	// 	$meta_description 	= ($page->meta_description ? $page->meta_description : $page->layout->meta_description);
	// 	$meta_keywords 		= '';

	// 	if ($page->meta_keywords or $page->layout->meta_keywords) {

	// 		$meta_keywords = $page->meta_keywords ?
	// 							Keywords::get_string($page->meta_keywords) :
	// 							Keywords::get_string($page->layout->meta_keywords);
	// 	}

	// 	$meta_robots  = $page->meta_robots_no_index ? 'noindex' : 'index';
	// 	$meta_robots .= $page->meta_robots_no_follow ? ',nofollow' : ',follow';

	// 	if ( ! $meta_title) {

	// 		$meta_title = $page->is_home ? $this->settings->site_slogan : $page->title;
	// 	}

	// 	$this->template
	// 		 ->title('Disneyland Hongkong Winners Announcement')
	// 		 ->set_metadata('og:title', 'Disneyland Hongkong Winners Announcement', 'og')
	// 		 ->set_metadata('og:type', 'disneyland-hongkong-winners-announcement', 'og')
	// 		 ->set_metadata('og:url', site_url().'disneyland-hongkong-winners-announcement', 'og')
	// 		 ->set_metadata('og:description', $this->parser->parse_string($meta_description, $page, true), 'og')
	// 		 ->set_metadata('og:image', $page->images_share['image'], 'og')
	// 		 ->set_metadata('keywords', $this->parser->parse_string($meta_keywords, $page, true))
	// 		 ->set_metadata('robots', $meta_robots)
	// 		 ->set_metadata('description', $this->parser->parse_string($meta_description, $page, true))
	// 		 ->build('index');
	// }

	// public function get_article_ask() {

	// 	$page 				= $this->maxcache->model('page_m', 'get_by_uri', array('ask-the-expert', true));
	// 	$meta_title 		= ($page->meta_title ? $page->meta_title : $page->layout->meta_title);
	// 	$meta_description 	= ($page->meta_description ? $page->meta_description : $page->layout->meta_description);
	// 	$meta_keywords 		= '';

	// 	if ($page->meta_keywords or $page->layout->meta_keywords) {

	// 		$meta_keywords = $page->meta_keywords ?
	// 							Keywords::get_string($page->meta_keywords) :
	// 							Keywords::get_string($page->layout->meta_keywords);
	// 	}

	// 	$meta_robots  = $page->meta_robots_no_index ? 'noindex' : 'index';
	// 	$meta_robots .= $page->meta_robots_no_follow ? ',nofollow' : ',follow';

	// 	if ( ! $meta_title) {

	// 		$meta_title = $page->is_home ? $this->settings->site_slogan : $page->title;
	// 	}

	// 	$this->template
	// 		 ->title('saatnya bertanya dengan tim ahli kami')
	// 		 ->set_metadata('og:title', 'saatnya bertanya dengan tim ahli kami', 'og')
	// 		 ->set_metadata('og:type', 'saatnya-bertanya-dengan-tim-ahli-kami', 'og')
	// 		 ->set_metadata('og:url', site_url().'ask-the-expert/saatnya-bertanya-dengan-tim-ahli-kami', 'og')
	// 		 ->set_metadata('og:description', $this->parser->parse_string($meta_description, $page, true), 'og')
	// 		 ->set_metadata('og:image', $page->images_share['image'], 'og')
	// 		 ->set_metadata('keywords', $this->parser->parse_string($meta_keywords, $page, true))
	// 		 ->set_metadata('robots', $meta_robots)
	// 		 ->set_metadata('description', $this->parser->parse_string($meta_description, $page, true))
	// 		 ->build('index');
	// }

	// public function get_article_reward_november() {

	// 	$page 				= $this->maxcache->model('page_m', 'get_by_uri', array('ask-the-expert', true));
	// 	$meta_title 		= ($page->meta_title ? $page->meta_title : $page->layout->meta_title);
	// 	$meta_description 	= ($page->meta_description ? $page->meta_description : $page->layout->meta_description);
	// 	$meta_keywords 		= '';

	// 	if ($page->meta_keywords or $page->layout->meta_keywords) {

	// 		$meta_keywords = $page->meta_keywords ?
	// 							Keywords::get_string($page->meta_keywords) :
	// 							Keywords::get_string($page->layout->meta_keywords);
	// 	}

	// 	$meta_robots  = $page->meta_robots_no_index ? 'noindex' : 'index';
	// 	$meta_robots .= $page->meta_robots_no_follow ? ',nofollow' : ',follow';

	// 	if ( ! $meta_title) {

	// 		$meta_title = $page->is_home ? $this->settings->site_slogan : $page->title;
	// 	}

	// 	$this->template
	// 		 ->title('Tukarkan Poin GOLD Rewards Program Mam Sekarang!')
	// 		 ->set_metadata('og:title', 'Tukarkan Poin GOLD Rewards Program Mam Sekarang! ', 'og')
	// 		 ->set_metadata('og:type', 'tukarkan-poin-gold-rewards-program-mam-sekarang', 'og')
	// 		 ->set_metadata('og:url', site_url().'tukarkan-poin-gold-rewards-program-mam-sekarang', 'og')
	// 		 ->set_metadata('og:description', $this->parser->parse_string($meta_description, $page, true), 'og')
	// 		 ->set_metadata('og:image', $page->images_share['image'], 'og')
	// 		 ->set_metadata('keywords', $this->parser->parse_string($meta_keywords, $page, true))
	// 		 ->set_metadata('robots', $meta_robots)
	// 		 ->set_metadata('description', $this->parser->parse_string($meta_description, $page, true))
	// 		 ->build('index');
	// }

	// public function get_article_news_events_2() {

	// 	$page 				= $this->maxcache->model('page_m', 'get_by_uri', array('ask-the-expert', true));
	// 	$meta_title 		= ($page->meta_title ? $page->meta_title : $page->layout->meta_title);
	// 	$meta_description 	= ($page->meta_description ? $page->meta_description : $page->layout->meta_description);
	// 	$meta_keywords 		= '';

	// 	if ($page->meta_keywords or $page->layout->meta_keywords) {

	// 		$meta_keywords = $page->meta_keywords ?
	// 							Keywords::get_string($page->meta_keywords) :
	// 							Keywords::get_string($page->layout->meta_keywords);
	// 	}

	// 	$meta_robots  = $page->meta_robots_no_index ? 'noindex' : 'index';
	// 	$meta_robots .= $page->meta_robots_no_follow ? ',nofollow' : ',follow';

	// 	if ( ! $meta_title) {

	// 		$meta_title = $page->is_home ? $this->settings->site_slogan : $page->title;
	// 	}

	// 	$this->template
	// 		 ->title('Beda Anak Beda Pintar: Kenali 8 Jenis Kepintaran Si Kecil')
	// 		 ->set_metadata('og:title', 'Beda Anak Beda Pintar: Kenali 8 Jenis Kepintaran Si Kecil ', 'og')
	// 		 ->set_metadata('og:type', 'beda-anak-beda-pintar-kenali-8-jenis-kepintaran-si-kecil', 'og')
	// 		 ->set_metadata('og:url', site_url().'beda-anak-beda-pintar-kenali-8-jenis-kepintaran-si-kecil', 'og')
	// 		 ->set_metadata('og:description', $this->parser->parse_string($meta_description, $page, true), 'og')
	// 		 ->set_metadata('og:image', $page->images_share['image'], 'og')
	// 		 ->set_metadata('keywords', $this->parser->parse_string($meta_keywords, $page, true))
	// 		 ->set_metadata('robots', $meta_robots)
	// 		 ->set_metadata('description', $this->parser->parse_string($meta_description, $page, true))
	// 		 ->build('index');
	// }

	// public function comments_user() {

	// 	$today 			= date("Y-m-d");
	// 	$tgl 			= date("j");
	// 	$bln 			= date("n");
	// 	$thn 			= date("Y");
	// 	$er 		   	= array();

	// 	$ret['status'] 	= false;

	// 	if(!$this->input->is_ajax_request()) {

	// 		redirect(site_url());
	// 	}

	// 	if(!$this->current_user) {

	// 		$ret['status'] = 'not login';
	// 	}else {

	// 		$validation = array(

	// 			array(
	// 				'field' => 'name',
	// 				'label' => 'Nama',
	// 				'rules' => 'trim|xss_clean',
	// 			),
	// 			array(
	// 				'field' => 'email',
	// 				'label' => 'Email',
	// 				'rules' => 'trim|required|valid_email',
	// 			),
	// 			array(
	// 				'field' => 'comments',
	// 				'label' => 'comments',
	// 				'rules' => 'trim|xss_clean|callback__check_str_post',
	// 			),
	// 		);

	// 		$rules = $validation;
	// 		$this->form_validation->set_rules($rules);

	// 		if ($this->form_validation->run()){

	// 			$extra = array(

	// 				'name'			=> $this->input->post('name'),
	// 				'email'			=> $this->input->post('email'),
	// 				'comments'      => $this->input->post('comments'),
	// 				'article_id'	=> $this->input->post('article_id'),
	// 				'status'		=> 'draft',
	// 				'tgl'			=> $tgl,
	// 				'bulan'			=> $bln,
	// 				'tahun'			=> $thn,
	// 			);

	// 			if($id = $this->article_m->insert_data('article_comments', $extra)) {

	// 				$ret['judul_pop']	= 'Sukses!';
	// 				$ret['isi_pop'] 	= 'Selamat komentar Mam berhasil disubmit.';
	// 				$ret['status']  	= true;
	// 			}

	// 		}else{

	// 			$ret['status']	= false;
	// 			$ret['message'] = $this->form_validation->error_string();
	// 		}
	// 	}

	// 	echo json_encode($ret);
	// }

	// public function _check_str_title()
	// {
	// 	$str_not_allowed = '~`!@#$%^&*()-_=+{}[]|;:<>/';
	// 	$str_post 		 = $this->input->post('name');

	// 	if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>]/', $str_post) > 0)
	// 	{

	// 		$this->form_validation->set_message('_check_str_title', 'sory caracter in title not allowed');
	// 		return false;
	// 	}

	// 	return true;
	// }

	public function _check_str_post()
	{
		$str_not_allowed = '~`!@#$%^&*()-_=+{}[]|;:<>/';
		$str_post 		 = $this->input->post('comments');

		if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>]/', $str_post) > 0)
		{

			$this->form_validation->set_message('_check_str_post', 'sory caracter in comments not allowed');
			return false;
		}

		return true;
	}

	// public function _check_str_search()
	// {
	// 	$str_not_allowed = '~`!@#$%^&*()-_=+{}[]|;:<>/';
	// 	$str_post 		 = $this->input->post('search');

	// 	if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>]/', $str_post) > 0)
	// 	{

	// 		$this->form_validation->set_message('_check_str_search', 'sory caracter in title not allowed');
	// 		return false;
	// 	}

	// 	return true;
	// }


	// ==================== new parentingclub ========================
	public function load_more_home() {
		$post 				= $this->input->post();
		$page 				= (int)$this->input->post('page',true);
		$pagemobile 		= (int)$this->input->post('pagemobile',true);
		$category 			= $this->input->post('category',true);
		$kidsage 			= $this->input->post('kidsage',true);
		$order 				= $this->input->post('order',true);
		$json 				= array();

		// data deskstop
		$cat_var 	= '';
		$cat_query 	= '';
		if (!empty($category)) {
			foreach($category as $keyc=>$cat) {
				if($cat_var == 0) {
					$cat_query .= 'FIND_IN_SET(\''.$cat.'\', default_article.categories_id) <> 0 ';
				} else {
					$cat_query .= 'OR FIND_IN_SET(\''.$cat.'\', default_article.categories_id) <> 0 ';
				}

				$qcat = '('.$cat_query.')';
				$cat_var++;

			}

			if ($cat_query){
				$this->db->where($qcat);
			}
		}

		$kids_var 	= '';
		$kids_query = '';
		if (!empty($kidsage)) {
			foreach($kidsage as $keyk=>$kids) {
				if($kids_var == 0) {
					$kids_query .= 'FIND_IN_SET(\''.$kids.'\', default_article.kidsage_id) <> 0 ';
				} else {
					$kids_query .= 'OR FIND_IN_SET(\''.$kids.'\', default_article.kidsage_id) <> 0 ';
				}

				$qkids = '('.$kids_query.')';
				$kids_var++;
			}

			if ($kids_query) {
				$this->db->where($qkids);
			}
		}

		if (!empty($order)) {
			if ($order=='terbaru') {
				$this->db->order_by('article.article_id', 'DESC');
			} elseif ($order=='terpopuler') {
				/*$this->db->join('article_comments', 'article.article_id = article_comments.article_id', 'right');
				$this->db->where('default_article_comments.created BETWEEN NOW() - INTERVAL 30 DAY AND NOW()');
				$this->db->order_by('COUNT(default_article_comments.article_id)', 'DESC');
				$this->db->group_by('article_comments.article_id');*/
				$this->db->order_by('default_article.click', 'DESC');
			}
		} else {
			$this->db->order_by('article.article_id', 'DESC');
		}

		$limit_desktop = 12 ;

		$data_ 	= $this->article_m
					  ->where(array('article.status' => 'live'))
					  // ->order_by('article.article_id', 'DESC')
					  ->limit($limit_desktop, $page*$limit_desktop)
					  ->get_all_articles();

		foreach ($data_ as $key => $article) {
			$article->gallery = new stdClass;
			$article->gallery_asbg = array();
			$data_imgs = $this->article_m->where(array('article_id' => $article->article_id,'ftype'=>'img'))->get_all_data('article_files');
			if ($article->template == 'gallery' or $article->template == '2-tile') {
				foreach($data_imgs as $img) {
					if ($img->as_background=='1') {
						$article->gallery_asbg = $img->full_path;
					}
				}
				$article->gallery = $data_imgs;
			}
		}

		// data mobile
		$cat_var 	= '';
		$cat_query 	= '';
		if (!empty($category)) {
			foreach($category as $keyc=>$cat) {
				if($cat_var == 0) {
					$cat_query .= 'FIND_IN_SET(\''.$cat.'\', default_article.categories_id) <> 0 ';
				} else {
					$cat_query .= 'OR FIND_IN_SET(\''.$cat.'\', default_article.categories_id) <> 0 ';
				}

				$qcat = '('.$cat_query.')';
				$cat_var++;

			}

			if ($cat_query){
				$this->db->where($qcat);
			}
		}

		$kids_var 	= '';
		$kids_query = '';
		if (!empty($kidsage)) {
			foreach($kidsage as $keyk=>$kids) {
				if($kids_var == 0) {
					$kids_query .= 'FIND_IN_SET(\''.$kids.'\', default_article.kidsage_id) <> 0 ';
				} else {
					$kids_query .= 'OR FIND_IN_SET(\''.$kids.'\', default_article.kidsage_id) <> 0 ';
				}

				$qkids = '('.$kids_query.')';
				$kids_var++;
			}

			if ($kids_query) {
				$this->db->where($qkids);
			}
		}

		if (!empty($order)) {
			if ($order=='terbaru') {
				$this->db->order_by('article.article_id', 'DESC');
			} elseif ($order=='terpopuler') {
				/*$this->db->join('article_comments', 'article.article_id = article_comments.article_id', 'right');
				$this->db->where('default_article_comments.created BETWEEN NOW() - INTERVAL 30 DAY AND NOW()');
				$this->db->order_by('COUNT(default_article_comments.article_id)', 'DESC');
				$this->db->group_by('article_comments.article_id');*/
				$this->db->order_by('default_article.click', 'DESC');
			}
		} else {
			$this->db->order_by('article.article_id', 'DESC');
		}

		$limit_mobile = 4 ;
		$data_mobile_ 	= $this->article_m
					  ->where(array('article.status' => 'live'))
					  // ->order_by('article.article_id', 'DESC')
					  ->limit($limit_mobile, $pagemobile*$limit_mobile)
					  ->get_all_articles();

		foreach ($data_mobile_ as $key => $article) {
			$article->gallery = new stdClass;
			$article->gallery_asbg = array();
			$data_imgs = $this->article_m->where(array('article_id' => $article->article_id,'ftype'=>'img'))->get_all_data('article_files');
			if ($article->template == 'gallery' or $article->template == '2-tile') {
				foreach($data_imgs as $img) {
					if ($img->as_background=='1') {
						$article->gallery_asbg = $img->full_path;
					}
				}
				$article->gallery = $data_imgs;
			}
		}

		$idr=$page*$limit_desktop;
		$idr_mobile=$page*$limit_mobile;
		$html = '';
		$html_mobile = '';

		// render deskstop
		if (!empty($data_) and is_array($data_)) {
			foreach ($data_ as $key=>$article) {
				$bg = ($article->bg_color=='yellow') ? 'bg-yellow"' : 'bg-red';
				$img = ($article->full_path) ? base_url($article->full_path): base_url('uploads/default/files/no-available-image.png');
				$uri = base_url('smart-stories/'.$article->categories_slug.'/'.$article->slug);
				if ($article->template == 'no-image' or $article->template=='downloadable') {
					$html .= '<div class="gi gi-1 post-noimage '.$bg.'" id="article'.$idr.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<img src="https://placehold.it/300x300" alt="" class="img-fluid">'.
							'<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} else if ($article->template=='thumb') {
					$html .= '<div class="gi gi-1 post '.$bg.'" id="article'.$idr.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<img src="'.$img.'" alt="" class="img-fluid">'.
							'<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} else if ($article->template == '2-tile') {
					$html .= '<div class="gi gi-2 post '.$bg.'" id="article'.$idr.'">'.
						'<div class="gic fix-ratio" ratio="2:1">'.
							'<img src="'.$img.'" alt="" class="img-fluid">'.
							'<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>						'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} else if ($article->template == 'gallery') {
					$html .= '<div class="gi gi-2 post-slide '.$bg.'" id="article'.$idr.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<div class="swiper-container swiper-post fix-ratio" ratio="1:1">'.
								'<div class="swiper-wrapper">';
									if ($article->gallery) {
										foreach ($article->gallery as $key => $gallery) {
											$html .='<div class="swiper-slide">'.
												'<a href="'.$uri.'"><img src="'.base_url($gallery->full_path).'" alt=""></a>'.
											'</div>';
										}
									}
								$html .='</div>'.
								'<div class="swiper-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i><span class="sr-only">Prev</span></div>'.
								'<div class="swiper-next"><i class="fa fa-chevron-right" aria-hidden="true"></i><span class="sr-only">Next</span></div>'.
							'</div>'.
							'<div class="post-txt">'.
								'<div>'.
									'<p>'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<p><span class="author">'.$article->first_name.' '.$article->last_name.'</span><span class="date">'.$article->created.'</span></p>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				}
				$idr++;
			}

			$json['deskstop'] =  array(
				'status'	=>true,
				'data'		=>$html,
				'page'		=>$page+1,
			);
		} else {
			$json['deskstop'] =  array(
				'status'	=>false,
				'data'		=>$html,
			);
		}

		// reder mobile
		if (!empty($data_mobile_) and is_array($data_mobile_)) {
			foreach ($data_mobile_ as $key=>$article_mobile) {
				$bg = ($article_mobile->bg_color=='yellow') ? 'bg-yellow"' : 'bg-red';
				$img = ($article_mobile->full_path) ? base_url($article_mobile->full_path): base_url('uploads/default/files/no-available-image.png');
				$uri = base_url('smart-stories/'.$article_mobile->categories_slug.'/'.$article_mobile->slug);
				if ($article_mobile->template == 'no-image' or $article_mobile->template=='downloadable') {
					$html_mobile .= '<div class="gi gi-1 post-noimage '.$bg.'" id="article'.$idr_mobile.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<img src="https://placehold.it/300x300" alt="" class="img-fluid">'.
							'<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article_mobile->categories.'</p>'.
									'<h3 class="title">'.$article_mobile->title.'</h3>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} else if ($article_mobile->template=='thumb' or $article_mobile->template == '2-tile') {
					$html_mobile .= '<div class="gi gi-1 post '.$bg.'" id="article'.$idr_mobile.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<img src="'.$img.'" alt="" class="img-fluid">'.
							'<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article_mobile->categories.'</p>'.
									'<h3 class="title">'.$article_mobile->title.'</h3>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} elseif ($article->template == 'gallery') {
					$html .= '<div class="gi gi-1 post-slide '.$bg.'" id="article'.$idr.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<div class="swiper-container swiper-post fix-ratio" ratio="1:1">'.
								'<div class="swiper-wrapper">';
									if ($article->gallery) {
										foreach ($article->gallery as $key => $gallery) {
											$html .='<div class="swiper-slide">'.
												'<a href="'.$uri.'"><img src="'.base_url($gallery->full_path).'" alt=""></a>'.
											'</div>';
										}
									}
								$html .='</div>'.
								'<div class="swiper-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i><span class="sr-only">Prev</span></div>'.
								'<div class="swiper-next"><i class="fa fa-chevron-right" aria-hidden="true"></i><span class="sr-only">Next</span></div>'.
							'</div>'.
							'<div class="post-txt">'.
								'<div>'.
									'<p>'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<p><span class="author">'.$article->first_name.' '.$article->last_name.'</span><span class="date">'.$article->created.'</span></p>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				}
				$idr_mobile++;
			}

			$json['mobile'] =  array(
				'status'	=>true,
				'data'		=>$html_mobile,
				'page'		=>$pagemobile+1,
			);
		} else {
			$json['mobile'] =  array(
				'status'	=>false,
				'data'		=>$html_mobile,
			);
		}

		echo json_encode($json);
	}

	public function home_filter() {
		$category 	= $this->input->post('category',true);
		$kidsage 	= $this->input->post('kidsage',true);
		$order 		= $this->input->post('order',true);
		$json 		= array();

		// data deskstop
		$cat_var 	= '';
		$cat_query 	= '';
		if (!empty($category)) {
			foreach($category as $keyc=>$cat) {
				if($cat_var == 0) {
					$cat_query .= 'FIND_IN_SET(\''.$cat.'\', default_article.categories_id) <> 0 ';
				} else {
					$cat_query .= 'OR FIND_IN_SET(\''.$cat.'\', default_article.categories_id) <> 0 ';
				}

				$qcat = '('.$cat_query.')';
				$cat_var++;

			}

			if ($cat_query){
				$this->db->where($qcat);
			}
		}

		$kids_var 	= '';
		$kids_query = '';
		if (!empty($kidsage)) {
			foreach($kidsage as $keyk=>$kids) {
				if($kids_var == 0) {
					$kids_query .= 'FIND_IN_SET(\''.$kids.'\', default_article.kidsage_id) <> 0 ';
				} else {
					$kids_query .= 'OR FIND_IN_SET(\''.$kids.'\', default_article.kidsage_id) <> 0 ';
				}

				$qkids = '('.$kids_query.')';
				$kids_var++;
			}

			if ($kids_query) {
				$this->db->where($qkids);
			}
		}

		if (!empty($order)) {
			if ($order=='terbaru') {
				$this->db->order_by('article.article_id', 'DESC');
			} elseif ($order=='terpopuler') {
				/*$this->db->join('article_comments', 'article.article_id = article_comments.article_id', 'right');
				$this->db->where('default_article_comments.created BETWEEN NOW() - INTERVAL 30 DAY AND NOW()');
				$this->db->order_by('COUNT(default_article_comments.article_id)', 'DESC');
				$this->db->group_by('article_comments.article_id');*/
				$this->db->order_by('default_article.click', 'DESC');
			}
		} else {
			$this->db->order_by('article.article_id', 'DESC');
		}

		$data_ 	= $this->article_m
					  ->where(array('article.status' => 'live'))
					  // ->order_by('article.article_id', 'DESC')
					  ->limit(9, 0)
					  ->get_all_articles();

		foreach ($data_ as $key => $article) {
			$article->gallery = new stdClass;
			$article->gallery_asbg = array();
			$data_imgs = $this->article_m->where(array('article_id' => $article->article_id, 'ftype'=>'img'))->get_all_data('article_files');
			if ($article->template == 'gallery' or $article->template == '2-tile') {
				foreach($data_imgs as $img) {
					if ($img->as_background=='1') {
						$article->gallery_asbg = $img->full_path;
					}
				}
				$article->gallery = $data_imgs;
			}
		}

		// data mobile reset condition
		$cat_var 	= '';
		$cat_query 	= '';
		if (!empty($category)) {
			foreach($category as $keyc=>$cat) {
				if($cat_var == 0) {
					$cat_query .= 'FIND_IN_SET(\''.$cat.'\', default_article.categories_id) <> 0 ';
				} else {
					$cat_query .= 'OR FIND_IN_SET(\''.$cat.'\', default_article.categories_id) <> 0 ';
				}

				$qcat = '('.$cat_query.')';
				$cat_var++;

			}

			if ($cat_query){
				$this->db->where($qcat);
			}
		}

		$kids_var 	= '';
		$kids_query = '';
		if (!empty($kidsage)) {
			foreach($kidsage as $keyk=>$kids) {
				if($kids_var == 0) {
					$kids_query .= 'FIND_IN_SET(\''.$kids.'\', default_article.kidsage_id) <> 0 ';
				} else {
					$kids_query .= 'OR FIND_IN_SET(\''.$kids.'\', default_article.kidsage_id) <> 0 ';
				}

				$qkids = '('.$kids_query.')';
				$kids_var++;
			}

			if ($kids_query) {
				$this->db->where($qkids);
			}
		}

		if (!empty($order)) {
			if ($order=='terbaru') {
				$this->db->order_by('article.article_id', 'DESC');
			} elseif ($order=='terpopuler') {
				/*$this->db->join('article_comments', 'article.article_id = article_comments.article_id', 'right');
				$this->db->where('default_article_comments.created BETWEEN NOW() - INTERVAL 30 DAY AND NOW()');
				$this->db->order_by('COUNT(default_article_comments.article_id)', 'DESC');
				$this->db->group_by('article_comments.article_id');*/
				$this->db->order_by('default_article.click', 'DESC');
			}
		} else {
			$this->db->order_by('article.article_id', 'DESC');
		}

		$data_mobile_ 	= $this->article_m
					  ->where(array('article.status' => 'live'))
					  // ->order_by('article.article_id', 'DESC')
					  ->limit(4, 0)
					  ->get_all_articles();

		foreach ($data_mobile_ as $key => $article) {
			$article->gallery = new stdClass;
			$article->gallery_asbg = array();
			$data_imgs = $this->article_m->where(array('article_id' => $article->article_id,'ftype'=>'img'))->get_all_data('article_files');
			if ($article->template == 'gallery' or $article->template == '2-tile') {
				foreach($data_imgs as $img) {
					if ($img->as_background=='1') {
						$article->gallery_asbg = $img->full_path;
					}
				}
				$article->gallery = $data_imgs;
			}
		}

		$idr=0;
		$html = '';
		$idr_mobile=0;
		$html_mobile = '';

		// render dekstop
		if (!empty($data_) and is_array($data_)) {
			foreach ($data_ as $key=>$article) {
				$bg = ($article->bg_color=='yellow') ? 'bg-yellow"' : 'bg-red';
				// $img = ($article->full_path) ? base_url($article->full_path): base_url('uploads/default/files/no-available-image.png');
				$uri = base_url('smart-stories/'.$article->categories_slug.'/'.$article->slug);

				$img = base_url('uploads/default/files/no-available-image.png');
				if($article->full_path!='' && file_exists(getcwd().$article->full_path)){
					$img = base_url($article->full_path);
				}else{
					if( isset($article->gallery_asbg) ){
						$img = base_url($article->gallery_asbg);
					}
				}

				if ($article->template == 'no-image' or $article->template=='downloadable') {
					$html .= '<div class="gi gi-1 post-noimage '.$bg.'" id="article'.$idr.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<img src="https://placehold.it/300x300" alt="" class="img-fluid">'.
							'<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} else if ($article->template=='thumb') {
					$html .= '<div class="gi gi-1 post '.$bg.'" id="article'.$idr.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<img src="'.$img.'" alt="" class="img-fluid">'.
							'<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} else if ($article->template == '2-tile') {
					$html .= '<div class="gi gi-2 post '.$bg.'" id="article'.$idr.'">'.
						'<div class="gic fix-ratio" ratio="2:1">'.
							'<img src="'.$img.'" alt="" class="img-fluid">'.
							'<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} else if ($article->template == 'gallery') {
					$html .= '<div class="gi gi-2 post-slide '.$bg.'" id="article'.$idr.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<div class="swiper-container swiper-post fix-ratio" ratio="1:1">'.
								'<div class="swiper-wrapper">';
									if ($article->gallery) {
										foreach ($article->gallery as $key => $gallery) {
											$html .='<div class="swiper-slide">'.
												'<a href="'.$uri.'"><img src="'.base_url($gallery->full_path).'" alt=""></a>'.
											'</div>';
										}
									}
								$html .='</div>'.
								'<div class="swiper-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i><span class="sr-only">Prev</span></div>'.
								'<div class="swiper-next"><i class="fa fa-chevron-right" aria-hidden="true"></i><span class="sr-only">Next</span></div>'.
							'</div>'.
							'<div class="post-txt">'.
								'<div>'.
									'<p>'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<p><span class="author">'.$article->first_name.' '.$article->last_name.'</span><span class="date">'.$article->created.'</span></p>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				}
				$idr++;
			}
			$json['deskstop'] =  array(
				'status'	=>true,
				'data'		=>$html,
				'page'		=>1,
			);
		} else {
			$json['deskstop'] =  array(
				'status'	=>false,
				'data'		=>$html,
			);
		}

		// render mobile
		if (!empty($data_mobile_) and is_array($data_mobile_)) {
			foreach ($data_mobile_ as $key=>$article_mobile) {
				$bg = ($article_mobile->bg_color=='yellow') ? 'bg-yellow"' : 'bg-red';
				// $img = ($article_mobile->full_path) ? base_url($article_mobile->full_path): base_url('uploads/default/files/no-available-image.png');
				$uri = base_url('smart-stories/'.$article_mobile->categories_slug.'/'.$article_mobile->slug);

				$img = base_url('uploads/default/files/no-available-image.png');
				if($article_mobile->full_path!='' && file_exists(getcwd().$article_mobile->full_path)){
					$img = base_url($article_mobile->full_path);
				}else{
					if( isset($article_mobile->gallery_asbg) ){
						$img = base_url($article_mobile->gallery_asbg);
					}
				}

				if ($article_mobile->template == 'no-image' or $article_mobile->template=='downloadable') {
					$html_mobile .= '<div class="gi gi-1 post-noimage '.$bg.'" id="article'.$idr_mobile.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<img src="https://placehold.it/300x300" alt="" class="img-fluid">'.
							'<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article_mobile->categories.'</p>'.
									'<h3 class="title">'.$article_mobile->title.'</h3>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} else if ($article_mobile->template=='thumb' or $article_mobile->template == '2-tile') {
					$html_mobile .= '<div class="gi gi-1 post '.$bg.'" id="article'.$idr_mobile.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<img src="'.$img.'" alt="" class="img-fluid">'.
							'<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article_mobile->categories.'</p>'.
									'<h3 class="title">'.$article_mobile->title.'</h3>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} else if ($article->template == 'gallery') {
					$html .= '<div class="gi gi-1 post-slide '.$bg.'" id="article'.$idr.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<div class="swiper-container swiper-post fix-ratio" ratio="1:1">'.
								'<div class="swiper-wrapper">';
									if ($article->gallery) {
										foreach ($article->gallery as $key => $gallery) {
											$html .='<div class="swiper-slide">'.
												'<a href="'.$uri.'"><img src="'.base_url($gallery->full_path).'" alt=""></a>'.
											'</div>';
										}
									}
								$html .='</div>'.
								'<div class="swiper-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i><span class="sr-only">Prev</span></div>'.
								'<div class="swiper-next"><i class="fa fa-chevron-right" aria-hidden="true"></i><span class="sr-only">Next</span></div>'.
							'</div>'.
							'<div class="post-txt">'.
								'<div>'.
									'<p>'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<p><span class="author">'.$article->first_name.' '.$article->last_name.'</span><span class="date">'.$article->created.'</span></p>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				}
				$idr_mobile++;
			}

			$json['mobile'] =  array(
				'status'	=>true,
				'data'		=>$html_mobile,
				'page'		=>1,
			);
		} else {
			$json['mobile'] =  array(
				'status'	=>false,
				'data'		=>$html_mobile,
			);
		}

		echo json_encode($json);
	}

	public function load_more_articles() {
		$page 	= (int)$this->input->post('page',true);
		$category 	= $this->input->post('category',true);
		$kidsage 	= $this->input->post('kidsage',true);
		$order 		= $this->input->post('order',true);

		$cat_var 	= '';
		$cat_query 	= '';
		if (!empty($category)) {
			foreach($category as $keyc=>$cat) {
				if($cat_var == 0) {
					$cat_query .= 'FIND_IN_SET(\''.$cat.'\', default_article.categories_id) <> 0 ';
				} else {
					$cat_query .= 'OR FIND_IN_SET(\''.$cat.'\', default_article.categories_id) <> 0 ';
				}

				$qcat = '('.$cat_query.')';
				$cat_var++;

			}

			if ($cat_query){
				$this->db->where($qcat);
			}
		}

		$kids_var 	= '';
		$kids_query = '';
		if (!empty($kidsage)) {
			foreach($kidsage as $keyk=>$kids) {
				if($kids_var == 0) {
					$kids_query .= 'FIND_IN_SET(\''.$kids.'\', default_article.kidsage_id) <> 0 ';
				} else {
					$kids_query .= 'OR FIND_IN_SET(\''.$kids.'\', default_article.kidsage_id) <> 0 ';
				}

				$qkids = '('.$kids_query.')';
				$kids_var++;
			}

			if ($kids_query) {
				$this->db->where($qkids);
			}
		}

		if (!empty($order)) {
			if ($order=='terbaru') {
				$this->db->order_by('article.article_id', 'DESC');
			} elseif ($order=='terpopuler') {
				/*$this->db->join('article_comments', 'article.article_id = article_comments.article_id', 'right');
				$this->db->where('default_article_comments.created BETWEEN NOW() - INTERVAL 30 DAY AND NOW()');
				$this->db->order_by('COUNT(default_article_comments.article_id)', 'DESC');
				$this->db->group_by('article_comments.article_id');*/
				$this->db->order_by('default_article.click', 'DESC');
			}
		} else {
			$this->db->order_by('article.article_id', 'DESC');
		}

		$data_ 	= $this->article_m
					  ->where(array('article.status' => 'live'))
					  // ->order_by('article.article_id', 'DESC')
					  ->limit(12, $page*12)
					  ->get_all_articles();

		foreach ($data_ as $key => $article) {
			$article->created = $this->indo_date('d M Y',$article->created);
			$article->gallery = new stdClass;
			$article->gallery_asbg = array();
			$data_imgs = $this->article_m->where(array('article_id' => $article->article_id, 'ftype'=>'img'))->get_all_data('article_files');
			if ($article->template == 'gallery' or $article->template == '2-tile') {
				foreach($data_imgs as $img) {
					if ($img->as_background=='1') {
						$article->gallery_asbg = $img->full_path;
					}
				}
				$article->gallery = $data_imgs;
			}
		}

		$idr=$page*9;
		$html = '';

		if (!empty($data_) and is_array($data_)) {
			foreach ($data_ as $key=>$article) {
				$bg = ($article->bg_color=='yellow') ? 'bg-yellow"' : 'bg-red';
				$img = ($article->full_path) ? base_url($article->full_path): base_url('uploads/default/files/no-available-image.png');
				$uri = base_url('smart-stories/'.$article->categories_slug.'/'.$article->slug);
				if ($article->template == 'no-image' or $article->template=='downloadable' or $article->template=='thumb') {

					if ($article->full_path and $article->template != 'no-image') {
						$html .= '<div class="gi gi-1 post '.$bg.'" id="article'.$idr.'">';
					} else {
						$html .= '<div class="gi gi-1 post-noimage '.$bg.'" id="article'.$idr.'">';
					}

					$html .='<div class="gic fix-ratio" ratio="1:1" >';
					$html .= ($article->full_path) ? '<img src="'.base_url($article->full_path).'" alt="" class="img-fluid">' : '';
								$html .='<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<p><span class="author">'.$article->first_name.' '.$article->last_name.'</span><span class="date">'.$article->created.'</span></p>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} else if ($article->template == 'gallery') {
					$html .= '<div class="gi gi-2 post-slide '.$bg.'" id="article'.$idr.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<div class="swiper-container swiper-post fix-ratio" ratio="1:1">'.
								'<div class="swiper-wrapper">';
									if ($article->gallery) {
										foreach ($article->gallery as $key => $gallery) {
											$html .='<div class="swiper-slide">'.
												'<a href="'.$uri.'"><img src="'.base_url($gallery->full_path).'" alt=""></a>'.
											'</div>';
										}
									}
								$html .='</div>'.
								'<div class="swiper-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i><span class="sr-only">Prev</span></div>'.
								'<div class="swiper-next"><i class="fa fa-chevron-right" aria-hidden="true"></i><span class="sr-only">Next</span></div>'.
							'</div>'.
							'<div class="post-txt">'.
								'<div>'.
									'<p>'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<p><span class="author">'.$article->first_name.' '.$article->last_name.'</span><span class="date">'.$article->created.'</span></p>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} else if ($article->template == '2-tile') {
					if ($article->full_path) {
						$html .= '<div class="gi gi-2 post '.$bg.'" id="article'.$idr.'">';
					} else {
						$html .= '<div class="gi gi-2 post-noimage '.$bg.'" id="article'.$idr.'">';
					}

					$html .='<div class="gic fix-ratio" ratio="2:1" >';
					$html .= ($article->full_path) ? '<img src="'.base_url($article->full_path).'" alt="" class="img-fluid">' : '';
								$html .='<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<p><span class="author">'.$article->first_name.' '.$article->last_name.'</span><span class="date">'.$article->created.'</span></p>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				}
				$idr++;
			}
			$json =  array(
				'status'	=>true,
				'data'		=>$html,
				'page'		=>$page+1,
			);
		} else {
			$json =  array(
				'status'	=>false,
				'data'		=>$html,
			);
		}

		echo json_encode($json);
	}

	public function articles_filter() {
		$category 	= $this->input->post('category',true);
		$kidsage 	= $this->input->post('kidsage',true);
		$order 		= $this->input->post('order',true);

		$cat_var 	= '';
		$cat_query 	= '';
		if (!empty($category)) {
			foreach($category as $keyc=>$cat) {
				if($cat_var == 0) {
					$cat_query .= 'FIND_IN_SET(\''.$cat.'\', default_article.categories_id)';
				} else {
					$cat_query .= ' OR FIND_IN_SET(\''.$cat.'\', default_article.categories_id)';
				}

				$qcat = '('.$cat_query.')';
				$cat_var++;

			}

			if ($cat_query){
				$this->db->where($qcat);
			}
		}

		$kids_var 	= '';
		$kids_query = '';
		if (!empty($kidsage)) {
			foreach($kidsage as $keyk=>$kids) {
				if($kids_var == 0) {
					$kids_query .= 'FIND_IN_SET(\''.$kids.'\', default_article.kidsage_id)';
				} else {
					$kids_query .= ' OR FIND_IN_SET(\''.$kids.'\', default_article.kidsage_id)';
				}

				$qkids = '('.$kids_query.')';
				$kids_var++;
			}

			if ($kids_query) {
				$this->db->where($qkids);
			}
		}

		if (!empty($order)) {
			if ($order=='terbaru') {
				$this->db->order_by('article.article_id', 'DESC');
			} elseif ($order=='terpopuler') {
				/*$this->db->join('article_comments', 'article.article_id = article_comments.article_id', 'right');
				$this->db->or_where('default_article_comments.created BETWEEN NOW() - INTERVAL 30 DAY AND NOW()');
				$this->db->order_by('COUNT(default_article_comments.article_id)', 'DESC');
				$this->db->group_by('article_comments.article_id');*/
				$this->db->order_by('default_article.click', 'DESC');
			}
		} else {
			$this->db->order_by('article.article_id', 'DESC');
		}

		$data_ 	= $this->article_m
					  ->where(array('article.status' => 'live'))
					  // ->order_by('article.article_id', 'DESC')
					  ->limit(12, 0)
					  ->get_all_articles();

		foreach ($data_ as $key => $article) {
			$article->created = $this->indo_date('d M Y',$article->created);
			$article->gallery = new stdClass;
			$article->gallery_asbg = array();
			$data_imgs = $this->article_m->where(array('article_id' => $article->article_id,'ftype'=>'img'))->get_all_data('article_files');
			if ($article->template == 'gallery' or $article->template == '2-tile') {
				foreach($data_imgs as $img) {
					if ($img->as_background=='1') {
						$article->gallery_asbg = $img->full_path;
					}
				}
				$article->gallery = $data_imgs;
			}
		}

		$idr=0;
		$html = '';
		if (!empty($data_) and is_array($data_)) {
			foreach ($data_ as $key=>$article) {
				$bg = ($article->bg_color=='yellow') ? 'bg-yellow"' : 'bg-red';
				$img = ($article->full_path) ? base_url($article->full_path): base_url('uploads/default/files/no-available-image.png');
				$uri = base_url('smart-stories/'.$article->categories_slug.'/'.$article->slug);
				if ($article->template == 'no-image' or $article->template=='downloadable' or $article->template=='thumb') {

					if ($article->full_path and $article->template != 'no-image') {
						$html .= '<div class="gi gi-1 post '.$bg.'" id="article'.$idr.'">';
					} else {
						$html .= '<div class="gi gi-1 post-noimage '.$bg.'" id="article'.$idr.'">';
					}

					$html .='<div class="gic fix-ratio" ratio="1:1" >';
					$html .= ($article->full_path) ? '<img src="'.base_url($article->full_path).'" alt="" class="img-fluid">' : '';
								$html .='<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<p><span class="author">'.$article->first_name.' '.$article->last_name.'</span><span class="date">'.$article->created.'</span></p>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} else if ($article->template == 'gallery') {
					$html .= '<div class="gi gi-2 post-slide '.$bg.'" id="article'.$idr.'">'.
						'<div class="gic fix-ratio" ratio="1:1" >'.
							'<div class="swiper-container swiper-post fix-ratio" ratio="1:1">'.
								'<div class="swiper-wrapper">';
									if ($article->gallery) {
										foreach ($article->gallery as $key => $gallery) {
											$html .='<div class="swiper-slide">'.
												'<a href="'.$uri.'"><img src="'.base_url($gallery->full_path).'" alt=""></a>'.
											'</div>';
										}
									}
								$html .='</div>'.
								'<div class="swiper-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i><span class="sr-only">Prev</span></div>'.
								'<div class="swiper-next"><i class="fa fa-chevron-right" aria-hidden="true"></i><span class="sr-only">Next</span></div>'.
							'</div>'.
							'<div class="post-txt">'.
								'<div>'.
									'<p>'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<p><span class="author">'.$article->first_name.' '.$article->last_name.'</span><span class="date">'.$article->created.'</span></p>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				} else if ($article->template == '2-tile') {
					if ($article->full_path) {
						$html .= '<div class="gi gi-2 post '.$bg.'" id="article'.$idr.'">';
					} else {
						$html .= '<div class="gi gi-2 post-noimage '.$bg.'" id="article'.$idr.'">';
					}

					$html .='<div class="gic fix-ratio" ratio="2:1" >';
					$html .= ($article->full_path) ? '<img src="'.base_url($article->full_path).'" alt="" class="img-fluid">' : '';
								$html .='<div class="post-txt">'.
								'<div>'.
									'<p class="category">'.$article->categories.'</p>'.
									'<h3 class="title">'.$article->title.'</h3>'.
									'<p><span class="author">'.$article->first_name.' '.$article->last_name.'</span><span class="date">'.$article->created.'</span></p>'.
									'<a href="'.$uri.'" class="btn btn-secondary round">Baca selengkapnya</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
				}
				$idr++;
			}
			$json =  array(
				'status'	=>true,
				'data'		=>$html,
				'page'		=>1,
			);
		} else {
			$json =  array(
				'status'	=>false,
				'data'		=>$html,
			);
		}

		echo json_encode($json);
	}

	public function details($slug1='',$slug2='') {
		$slug1 = $this->security->xss_clean($slug1);
		$slug2 = $this->security->xss_clean($slug2);
		$detail = false;
		$cat_info = array();

		if((!empty($slug1) and empty($slug2)) or (empty($slug1) and empty($slug2))) {
			if(preg_match('/[A-Z]/', $slug1)){
				redirect(base_url('smart-stories/'.strtolower($slug1)));
			}
			$list_kidsage 	= array();
			$list_category 	= array();

			foreach ($this->article_m->get_many_kidsage(array('status'=>'live')) as $key => $row) {
				$list_kidsage[$key] = array(
					'id' => $row->kidsage_id,
					'title' => $row->title,
					'full_path' => $row->full_path,
				);
		   	}

		   	foreach ($this->article_m->get_many_category(array('status'=>'live')) as $key => $row) {
				$list_category[$key] = array(
					'id' => $row->categories_id,
					'title' => $row->title,
					'full_path' => $row->full_path,
				);
		   	}

		   	if(!empty($slug1)) {
		   		$count_slug = $this->article_m->count_category(array('slug'=>$slug1));

		   		if ($count_slug > 0) {
		   			$data_ = $data1_ = $data2_ = array();
					$data1_ = $this->article_m->get_by_article(array('category_slug'=>$slug1,'limit'=>12,'featured'=>1));
					$ct_noft = (12-count($data1_));

					$data2_ = $this->article_m->get_by_article(array('category_slug'=>$slug1,'limit'=>$ct_noft));
					$data_ = array_merge((array)$data1_, (array)$data2_);
					$cat_info = $this->article_m->get_by_category(array('slug'=>$slug1));
					Asset::js_inline('$(document).ready(function(){ jQuery("#category-articles option").filter(function(){ return $.trim($(this).val()) ==  "'.$cat_info->categories_id.'" }).prop("selected", true); $("#category-articles").selectpicker("refresh"); })');
				} else {
					$detail = true;
				}
			} else {
				$base_where = array();
			   	$base_where['status'] = 'live';
			   	//$base_where['featured'] = 1;
			   	$base_where['limit'][0] = 12;
			   	$base_where['limit'][1] = 0;
			   	$base_where['order'][0] = 'article_id';
			   	$base_where['order'][1] = 'DESC';

			   	$data_ = $this->article_m->get_many_articles($base_where);
			}

			if (!$detail) {
				// Karena /smart-stories ga ada jadi redirect ke homepage
				redirect();

				$smart_stories_title = $this->theme_m->get_option(array('slug'=>'smart_stories_title'));
				$smart_stories_description = $this->theme_m->get_option(array('slug'=>'smart_stories_description'));
				foreach ($data_ as $key => $article) {
					$article->created = $this->indo_date('d M Y',$article->created);
					$article->gallery = new stdClass;
					$article->gallery_asbg = array();
					$data_imgs = $this->article_m->where(array('article_id' => $article->article_id,'ftype'=>'img'))->get_all_data('article_files');
					if (!empty($data_imgs)) {
						foreach($data_imgs as $img) {
							if ($img->as_background=='1') {
								$article->gallery_asbg = $img->full_path;
							}
						}
						$article->gallery = $data_imgs;
					}
				}

				$meta_robots  	= 'index, follow';

				$smartstories_metatitle = $this->theme_m->get_option(array('slug'=>'smartstories_metatitle'));
				$smartstories_metakeyword = $this->theme_m->get_option(array('slug'=>'smartstories_metakeyword'));
				$smartstories_metadescription = $this->theme_m->get_option(array('slug'=>'smartstories_metadescription'));

				$meta_title 	= ($smartstories_metatitle->value) ? $smartstories_metatitle->value : 'Smart Stories';
				if ($cat_info) {
					$meta_keyword 	= ($cat_info->meta_keyword) ? $cat_info->meta_keyword : '';
					$meta_desc 		= ($cat_info->meta_desc) ? $cat_info->meta_desc : 'Dapatkan inspirasi dari para ahli dalam mengoptimalkan perkembangan kepintaran si Kecil. Yuk, dapatkan sekarang di Smart Stories via Parenting Club !';
				} else {
					$meta_keyword 	= ($smartstories_metakeyword->value) ? $smartstories_metakeyword->value : '';
					$meta_desc 		= ($smartstories_metadescription->value) ? $smartstories_metadescription->value : 'Dapatkan inspirasi dari para ahli dalam mengoptimalkan perkembangan kepintaran si Kecil. Yuk, dapatkan sekarang di Smart Stories via Parenting Club !';
				}

				$this->template->title($meta_title)
					->set_layout('default.html')
					->set_metadata('robots', $meta_robots)
					->set_metadata('keywords', $meta_keyword)
					->set_metadata('description', $meta_desc)
					->set('list_kidsage',$list_kidsage)
					->set('list_category',$list_category)
					->set('data_',$data_)
					->set('smart_stories_title',$smart_stories_title)
					->set('smart_stories_description',$smart_stories_description)
					->set('page',1)
					->build('articles_revamp');

			}
		}

		if ((!empty($slug1) and !empty($slug2)) or $detail==true) {
			if(preg_match('/[A-Z]/', $slug1) or preg_match('/[A-Z]/', $slug2)){
				redirect(base_url('smart-stories/'.strtolower($slug1).'/'.strtolower($slug2)));
			}

			if ($detail==true) {
				$slug2 = $slug1;
			}

			if(!empty($slug1) and !empty($slug2) and $detail==false) {
				$redir_permanent = base_url('smart-stories/'.strtolower($slug2));
	          	redirect($redir_permanent,'location',301);
	        }

			$data_ = $this->article_m
					  ->where(array('article.slug' => $slug2,'article.status'=>'live'))
					  ->get_single_articles();

			if ($data_) {

				// duuh, article si kecil hebat g boleh show disini
				$cats = $this->db
					->where_in('slug', array('fakta-otak','nutrisi-otak','stimulasi-otak'))
					->where_in('categories_id',explode(',',$data_->categories_id))
					->get('article_categories')
					->result();
				if($cats){
					redirect();
				}

				$this->session->unset_userdata('article_detail_selections');
			   	$this->session->unset_userdata('article_detail_selections_params');
			   	$this->session->unset_userdata('article_detail_selections_total');

				$new_click = (int)$data_->click+1;
				$new_data = array(
					'click'=>$new_click,
				);
				$this->article_m->update_data('article', $new_data, 'article_id', $data_->article_id);

				//-- SEND NOTIF IF 100x view
				if(intval($new_click)==100){
					$cur_slug = $this->uri->segment(2);
					$artikel_id = $data_->article_id;
					$artikel_url = base_url('smart-stories/'.strtolower($cur_slug));
					$tes = $this->email_notif100($artikel_id, $artikel_url);
				}

				$data_author = $this->article_m
									->join('profiles', 'users.id = profiles.user_id', 'left')
									->get_single_data('users.id', $data_->authors_id, 'users');
				if ($data_author) {
					$data_author->photo_profile = (isset($data_author->photo_profile)) ? base_url($data_author->photo_profile) : base_url('uploads/default/files/no-available-image.png');
					$data_author->tw_screen_name = (isset($data_author->tw_screen_name)) ? 'https://twitter.com/'.$data_author->tw_screen_name : $data_author->tw_screen_name;
					$data_author->tw_id = (isset($data_author->tw_id)) ? 'https://twitter.com/intent/user?user_id='.$data_author->tw_id : $data_author->tw_id;
					$data_author->fb_id = (isset($data_author->fb_id)) ? 'https://twitter.com/intent/user?user_id='.$data_author->fb_id : $data_author->fb_id;
				} else {
					$data_author = array(
						'first_name'		=> '',
						'last_name'			=> '',
						'profesi'			=> '',
						'bio'				=> '',
						'photo_profile'		=> '',
						'tw_screen_name'	=> '',
						'tw_id'				=> '',
						'fb_id'				=> '',
						'username'			=> '',
					);
					$data_author = (object)$data_author;
				}

				$data_files = $this->article_m
								 ->where(array('article_id' => $data_->article_id, 'ftype'=>'file'))
								 ->get_all_data('article_files');

				$data_imgs = $this->article_m
								 ->where(array('article_id' => $data_->article_id, 'ftype'=>'img'))
								 ->get_all_data('article_files');

			 	$data_video = $this->article_m
								 ->where(array('article_id' => $data_->article_id, 'ftype'=>'video'))
								 ->get_all_data('article_files');

			 	$data_youtube = $this->article_m
								 ->where(array('article_id' => $data_->article_id, 'ftype'=>'youtube'))
								 ->get_all_data('article_files');

				$base_where = array(
					'categories' 		=> $data_->categories_id,
					'kidsage'			=> $data_->kidsage_id,
					// 'article_id' 		=> $data_->article_id,
					'not_article_id' 	=> $data_->article_id,
					'limit' 			=> 6,
					'random'			=> true
				);

				$data_others_top = (array) $this->article_m->get_related_articles($base_where);

				unset($base_where['limit'], $base_where['random']);
        		$data_related_all = (array) $this->article_m->get_related_articles($base_where);
        		$data_related_all = array_column($data_related_all, 'article_id');

				$data_comments	= $this->article_m->get_article_comments($param=array('arid'=>$data_->article_id));
				$count_comment	= $this->article_m->count_comments(array('status'=>'live','article'=>$data_->article_id));

				$data_likes		= $this->article_m
								 	   ->where('article_id',$data_->article_id)
								 	   ->get_all_data('article_likes');

				$data_->created =$this->indo_date('D, d M Y, H:i',$data_->created);
				$date_cre = date('l, d F Y,H:i',$data_->created_on);

				if(isset($this->current_user->id)) {
					$usr 		= $this->current_user->id;
					$data_usr 	= $this->article_m
									   ->join('profiles', 'users.id = profiles.user_id', 'left')
									   ->get_single_data('users.id', $usr, 'users');
					$is_liked = $this->article_m
								 		->where(array('like_by'=>$usr, 'article_id'=>$data_->article_id))
								 		->count_data('article_likes');
					$data_usr->photo_profile = (isset($data_usr->photo_profile)) ? base_url($data_usr->photo_profile) : base_url('uploads/default/files/no-available-image.png');
				}else {
					$usr 		= '';
					$data_usr 	= '';
					$is_liked	= '';
				}

				$meta_robots  = 'index, follow';

				$list_kidsage 	= array();
				$list_category 	= array();

				$kids  = explode(',', $data_->kidsage_id);
				foreach ($this->article_m->get_many_kidsage(array('status'=>'live')) as $key => $row) {
					if (in_array($row->kidsage_id, $kids)) {
						$list_kidsage[$key] = array(
							'id' 	=> $row->kidsage_id,
							'title' => $row->title,
							'slug'	=> $row->slug,
						);
					}
			   	}

			   	$cats  = explode(',', $data_->categories_id);
			   	foreach ($this->article_m->get_many_category(array('status'=>'live')) as $key => $row) {
			   		if (in_array($row->categories_id, $cats)) {
						$list_category[$key] = array(
							'id' => $row->categories_id,
							'title' => $row->title,
							'slug'	=> $row->slug,
						);
					}
			   	}

			   	if ($detail==true) {
			   		$cat_info = $this->article_m->get_by_category(array('slug'=>$data_->categories_slug));
				   	$breadcrumbs = array(
						'0'	=> array(
							'title'		=>'Home',
							'uri'		=>base_url(),
							'active'	=>'',
						),
						'1'	=> array(
							'title'		=>'Smart Stories',
							'uri'		=>base_url('smart-stories'),
							'active'	=>'',
						),
						'2'	=> array(
							'title'		=>$cat_info->title,
							'uri'		=>base_url('smart-stories/'.$cat_info->slug),
							'active'	=>'',
						),
						'3'	=> array(
							'title'		=>$data_->title,
							'uri'		=>base_url('smart-stories/'.$cat_info->slug.'/'.$slug2),
							'active'	=>'active',
						),
					);
					$share_link = $this->create_bitly('smart-stories/'.$slug2);
			   	} else {
				   	$cat_info = $this->article_m->get_by_category(array('slug'=>$slug1));
				   	$breadcrumbs = array(
						'0'	=> array(
							'title'		=>'Home',
							'uri'		=>base_url(),
							'active'	=>'',
						),
						'1'	=> array(
							'title'		=>'Smart Stories',
							'uri'		=>base_url('smart-stories'),
							'active'	=>'',
						),
						'2'	=> array(
							'title'		=>$cat_info->title,
							'uri'		=>base_url('smart-stories/'.$cat_info->slug),
							'active'	=>'',
						),
						'3'	=> array(
							'title'		=>$data_->title,
							'uri'		=>base_url('smart-stories/'.$cat_info->slug.'/'.$slug2),
							'active'	=>'active',
						),
					);
					$share_link = $this->create_bitly('smart-stories/'.$cat_info->slug.'/'.$slug2);
			   	}

			   	$meta_title 	= ($data_->meta_title) ? $data_->meta_title : $data_->title;

			   	//----- TAMBAHAN REVAMP
			   	$base_where = array(
					'categories' 		=> $data_->categories_id,
					'kidsage'			=> $data_->kidsage_id,
					// 'article_id' 		=> $data_->article_id,
					'not_article_id' 	=> $data_->article_id,
					'limit' 			=> 1
				);

			   	$data_dua = (array) $this->article_m->get_related_articles($base_where);
			   	$data_dua_author = array();
			   	$data_dua_files = array();
			   	$data_dua_imgs = array();
			   	$data_dua_video = array();
			   	$data_dua_youtube = array();
			   	$data_others_bot = array();
			   	$selections[] = $data_->article_id;
			   	$selections_params = array(
					'categories' => $data_->categories_id,
					'kidsage'    => $data_->kidsage_id
			   	);

			   	if ($data_dua) {
					$data_dua = current($data_dua);
					$selections[] = $data_dua->article_id;

					$data_dua_author = $this->article_m
						->join('profiles', 'users.id = profiles.user_id', 'left')
						->get_single_data('users.id', $data_dua->authors_id, 'users');

					if ($data_dua_author) {
						$data_dua_author->photo_profile = (isset($data_dua_author->photo_profile)) ? base_url($data_dua_author->photo_profile) : base_url('uploads/default/files/no-available-image.png');
						$data_dua_author->tw_screen_name = (isset($data_dua_author->tw_screen_name)) ? 'https://twitter.com/'.$data_dua_author->tw_screen_name : $data_dua_author->tw_screen_name;
						$data_dua_author->tw_id = (isset($data_dua_author->tw_id)) ? 'https://twitter.com/intent/user?user_id='.$data_dua_author->tw_id : $data_dua_author->tw_id;
						$data_dua_author->fb_id = (isset($data_dua_author->fb_id)) ? 'https://twitter.com/intent/user?user_id='.$data_dua_author->fb_id : $data_dua_author->fb_id;
					} else {
						$data_dua_author = new \stdClass;
						$data_dua_author->first_name = '';
						$data_dua_author->last_name = '';
						$data_dua_author->profesi = '';
						$data_dua_author->bio = '';
						$data_dua_author->photo_profile = '';
						$data_dua_author->tw_screen_name = '';
						$data_dua_author->tw_id = '';
						$data_dua_author->fb_id = '';
						$data_dua_author->username = '';
					}

					$data_dua_files = $this->article_m
						->where(array('article_id' => $data_dua->article_id, 'ftype'=>'file'))
						->get_all_data('article_files');

					$data_dua_imgs = $this->article_m
						->where(array('article_id' => $data_dua->article_id, 'ftype'=>'img'))
						->get_all_data('article_files');

					$data_dua_video = $this->article_m
								 ->where(array('article_id' => $data_dua->article_id, 'ftype'=>'video'))
								 ->get_all_data('article_files');

			 		$data_dua_youtube = $this->article_m
								 ->where(array('article_id' => $data_dua->article_id, 'ftype'=>'youtube'))
								 ->get_all_data('article_files');

				 	$base_where = array(
						'categories' 		=> $data_dua->categories_id,
						'kidsage'			=> $data_dua->kidsage_id,
						// 'article_id' 		=> $data_->article_id,
						'not_article_id' 	=> $data_dua->article_id,
						'limit' 			=> 6,
						'random'			=> true
					);

					$data_others_bot = (array) $this->article_m->get_related_articles($base_where);
					$data_others_bot_count = count($data_others_bot);

				   	if ($data_others_bot_count < 6) {
				   		$remaining = 6 - $data_others_bot_count;
				   		$clone_counter = 0;

				   		foreach ($data_others_top as $key => $article) {
				   			if ($clone_counter < $remaining) {
				   				$data_others_bot[] = $article;
				   				$clone_counter++;
				   			}
				   		}
				   	}
			   	}
			   	//----- TAMBAHAN REVAMP

			   	$this->session->set_userdata('article_detail_selections', $selections);
			   	$this->session->set_userdata('article_detail_selections_params', $selections_params);
			   	$this->session->set_userdata('article_detail_selections_total', count($data_related_all));

				$this->template
					 ->set_layout('default.html')
					 ->title($meta_title)
					 ->set_metadata('og:title', $data_->title, 'og')
					 ->set_metadata('og:type', $slug1, 'og')
					 ->set_metadata('og:url', base_url('smart-stories/'.$slug1.'/'.$slug2), 'og')
					 ->set_metadata('og:description', $data_->meta_desc, 'og')
					 ->set_metadata('og:image', BASE_URL($data_->full_path), 'og')
					 ->set_metadata('robots', $meta_robots)
					 ->set_metadata('keywords', $data_->meta_keyword)
					 ->set_metadata('description', $data_->meta_desc)
					 ->append_css('theme::p-article.css')
					 ->set('data_', $data_)
					 ->set('data_author', $data_author)
					 ->set('data_files', $data_files)
					 ->set('data_imgs', $data_imgs)
					 ->set('data_video', $data_video)
					 ->set('data_youtube', $data_youtube)
					 ->set('usr', $usr)
					 ->set('data_usr', $data_usr)
					 ->set('list_kidsage',$list_kidsage)
					 ->set('list_category',$list_category)
					 // ->set('data_related', $data_related)
					 ->set('data_comments', $data_comments)
					 ->set('count_comment', $count_comment)
					 ->set('data_likes', $data_likes)
					 ->set('is_liked', $is_liked)
					 ->set('share_link', $share_link)
					 ->set('breadcrumbs', $breadcrumbs)
					 ->set('timezone', isset($_COOKIE['tzu']) ? $this->security->xss_clean($_COOKIE['tzu']) : '')
					 ->set('data_dua', $data_dua)
					 ->set('data_dua_author', $data_dua_author)
					 ->set('data_dua_files', $data_dua_files)
					 ->set('data_dua_imgs', $data_dua_imgs)
					 ->set('data_dua_video', $data_dua_video)
					 ->set('data_dua_youtube', $data_dua_youtube)
					 ->set('data_others_top', $data_others_top)
					 ->set('data_others_bot', $data_others_bot)
					 ->build('detail_revamp');
			} else {
				redirect('404');
			}
		}
	}

	function email_notif100($artikel_id, $artikel_url){
		$info_article = $this->article_m->get_single_data('article_id', $artikel_id, 'article');
		$author_id = $info_article->authors_id;
		$info_user = $this->article_m->get_single_data('user_id', $author_id, 'profiles');
		$data = $this->article_m->get_single_user(array('id'=>$author_id), 'users');
		$data_mail = array(
			'message' => 'Selamat, saat ini tulisan Anda sudah dibaca sebanyak 100 kali. Yuk, lihat dan bagikan agar semakin banyak Mam & Pap yang terinspirasi dalam mendukung sinergi kepintaran Akal, Fisik & Sosial si Kecil agar #PintarnyaBeda.',
			'subject' => '100 kali artikel dibaca',
			'button_text' => 'Lihat Tulisan',
			'url' => $artikel_url,
			'headline' => 'Halo '.$info_user->row('display_name')
		);

		//sent email after suksess update
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

		$val = $this->mandrill->messages->send($message, false, '', '2016-09-01');*/

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

	public function detail($slug='') {
		$slug = $this->security->xss_clean($slug);
		$data_ = $this->article_m
					  ->where(array('article.slug' => $slug))
					  ->get_single_articles();

		$data_files = $this->article_m
						 ->where(array('article_id' => $data_->article_id))
						 ->get_all_data('article_files');

		$share_link = $this->create_bitly('article/'.$data_->slug);

		$base_where = array(
			'categories' 	=> $data_->categories_id,
			'kidsage'		=> $data_->kidsage_id,
		);

		$data_related = $this->article_m
						   	 ->limit(3, 0)
						   	 ->order_by('article_id', 'DESC')
						   	 ->get_related_articles($base_where);

		$data_comments	= $this->article_m->get_article_comments($param=array('arid'=>$data_->article_id));

		$data_likes		= $this->article_m
						 	   ->where('article_id',$data_->article_id)
						 	   ->get_all_data('article_likes');

		$data_->created = $this->indo_date('D, d M Y, H:i',$data_->created);
		$date_cre = date('l, d F Y,H:i',$data_->created_on);

		if(isset($this->current_user->id)) {
			$usr 		= $this->current_user->id;
			$data_usr 	= $this->article_m
							   ->join('profiles', 'users.id = profiles.user_id', 'left')
							   ->get_single_data('users.id', $usr, 'users');
			$is_liked = $this->article_m
						 		->where(array('like_by'=>$usr, 'article_id'=>$data_->article_id))
						 		->count_data('article_likes');
			$data_usr->photo_profile = (isset($data_usr->photo_profile)) ? base_url($data_usr->photo_profile) : base_url('uploads/default/files/no-available-image.png');
		}else {
			$usr 		= '';
			$data_usr 	= '';
			$is_liked	= '';
		}

		$meta_robots  = 'index, follow';

		$list_kidsage 	= array();
		$list_category 	= array();

		$kids  = explode(',', $data_->kidsage_id);
		foreach ($this->article_m->get_many_kidsage(array('status'=>'live')) as $key => $row) {
			if (in_array($row->kidsage_id, $kids)) {
				$list_kidsage[$key] = array(
					'id' 	=> $row->kidsage_id,
					'title' => $row->title,
					'slug'	=> $row->slug,
				);
			}
	   	}

	   	$cats  = explode(',', $data_->categories_id);
	   	foreach ($this->article_m->get_many_category(array('status'=>'live')) as $key => $row) {
	   		if (in_array($row->categories_id, $cats)) {
				$list_category[$key] = array(
					'id' => $row->categories_id,
					'title' => $row->title,
					'slug'	=> $row->slug,
				);
			}
	   	}

		$this->template
			 ->title($data_->title)
			 ->set_metadata('og:title', $data_->title, 'og')
			 ->set_metadata('og:type', 'tips-and-tools-detail', 'og')
			 ->set_metadata('og:url', base_url('smart-stories/'.$data_->slug), 'og')
			 ->set_metadata('og:description', $data_->meta_desc, 'og')
			 ->set_metadata('og:image', BASE_URL($data_->full_path), 'og')
			 ->set_metadata('keywords', $data_->meta_keyword)
			 ->set_metadata('robots', $meta_robots)
			 ->set_metadata('description', $data_->meta_desc)
			 ->set('data_', $data_)
			 ->set('data_files', $data_files)
			 ->set('usr', $usr)
			 ->set('data_usr', $data_usr)
			 ->set('list_kidsage',$list_kidsage)
			 ->set('list_category',$list_category)
			 ->set('data_related', $data_related)
			 ->set('data_comments', $data_comments)
			 ->set('data_likes', $data_likes)
			 ->set('is_liked', $is_liked)
			 ->set('share_link', $share_link)
			 ->build('detail');
	}

	public function post_comment() {
		date_default_timezone_set('Asia/Jakarta');
		$json 			= array();

		$rules 	= array_merge($this->forms_validation);
		$this->form_validation->set_rules($rules);

		if (is_logged_in()) {
			if($this->form_validation->run()) {
				$created 		= date('Y-m-d H:i:s');
				$created_on 	= strtotime($created);
				$comments 		= $this->input->post('coment_input',true);
				$parent_id		= (int)$this->input->post('parent',true);
				$arid 			= $this->input->post('arid',true);
				$reply 			= $this->input->post('reply',true);
				$row 			= $this->input->post('row',true);

				$extra = array(
					'comments'			=> $comments,
					'parent_id'			=> $parent_id,
					'article_id'		=> $arid,
					'authors_id'		=> $this->current_user->id,
					'status'			=> 'draft',
					'reply_to'			=> $reply,
					'authors_read'		=> 0,
					'reply_read'		=> 0,
					'created_on'		=> $created_on,
					'created'			=> $created,
				);

				if ($id = $this->article_m->insert_data('article_comments', $extra)) {
					$data_usr 	= $this->article_m
							   ->join('profiles', 'users.id = profiles.user_id', 'left')
							   ->get_single_data('users.id', $this->current_user->id, 'users');

					$json['status'] 		= true;
					$created 				= $this->indo_date('D, d M Y, H:i',$created);
					$photo_profile 			= (isset($data_usr->photo_profile)) ? base_url($data_usr->photo_profile) : base_url('uploads/default/files/no-available-image.png');
					$html 					= '';

					if($parent_id !=0) {
						$param = array();
						$param['status']		= 'live';
						$param['parent_id']		= $parent_id;
						$param['order']			= 'DESC';
						$param['limit'][0]		= 1;
						$param['limit'][1]		= 1;
						$last_comment = $this->article_m->get_comment_data($param);

						$html .='<div class="row comment comment-sub comment-row-'.$id.'">'.
							'<div class="avatar fix-ratio" ratio="1:1">'.
								'<img src="'.$photo_profile.'" />'.
							'</div>'.
							'<div class="detail">'.
								'<div class="user">'.
									'<strong>'.$data_usr->first_name.' '.$data_usr->last_name.'</strong>'.
									'<small class="text-muted"> - '.$created.' WIB</small>'.
								'</div>'.
								'<div class="content">'.
									$comments.
								'</div>'.

								'<div class="row comment comment-form rcm-form" id="reply-form'.$id.'">'.
									'<div class="avatar fix-ratio hidden-sm-down" ratio="1:1">'.
										'<?php if (!empty($data_usr)) { ?>'.
											'<img src="'.$photo_profile.'" alt="">'.
										'<?php } ?>'.
									'</div>'.
									'<div class="detail">'.
										'<form action="" class="form-inline clearfix">'.
											'<div class="form-group comment-input">'.
												'<label for="content-input" class="sr-only">Tinggalkan pesan</label>'.
												'<textarea class="form-control round" id="content-input'.$id.'" placeholder="Tinggalkan pesan"></textarea>'.
											'</div>'.
											'<div class="form-group comment-send">'.
												'<button type="submit" class="kirim" data-row="'.$id.'" data-arid="'.$arid.'" data-parent="'.$parent_id.'">'.
													'Kirim'.
												'</button>'.
											'</div>'.
										'</form>'.
									'</div>'.
								'</div>'.
								'<div class="action"><a href="javascript:void(0);" data-row="'.$id.'" class="edit-comment">Edit</a><a href="javascript:void(0);" data-row="'.$id.'" class="reply-comment" >Reply</a><a href="javascript:void(0);" data-row="'.$id.'" class="share-comment">Share</a></div>'.
							'</div>'.
						'</div>';
						$json['el_row'] 		= (!empty($last_comment)) ? $last_comment[0]['comments_id'] : $row;
					} else {
						$html .='<div class="row comment comment-row-'.$id.'">'.
							'<div class="avatar fix-ratio" ratio="1:1">'.
								'<img src="'.$photo_profile.'" />'.
							'</div>'.
							'<div class="detail"> '.
								'<div class="user">'.
									'<strong>'.$data_usr->first_name.' '.$data_usr->last_name.'</strong>'.
									'<small class="text-muted"> - '.$created.' WIB</small>'.
								'</div>'.
								'<div class="content">'.
									$comments.
								'</div>'.

								'<div class="row comment comment-form rcm-form" id="reply-form'.$id.'">'.
									'<div class="avatar fix-ratio hidden-sm-down" ratio="1:1">'.
										'<?php if (!empty($data_usr)) { ?>'.
											'<img src="'.$photo_profile.'" alt="">'.
										'<?php } ?>'.
									'</div>'.
									'<div class="detail">'.
										'<form action="" class="form-inline clearfix">'.
											'<div class="form-group comment-input">'.
												'<label for="content-input" class="sr-only">Tinggalkan pesan</label>'.
												'<textarea class="form-control round" id="content-input'.$id.'" placeholder="Tinggalkan pesan"></textarea>'.
											'</div>'.
											'<div class="form-group comment-send">'.
												'<button type="submit" class="kirim" data-row="'.$id.'" data-arid="'.$arid.'" data-parent="'.$id.'">'.
													'Kirim'.
												'</button>'.
											'</div>'.
										'</form>'.
									'</div>'.
								'</div>'.
								'<div class="action"><a href="javascript:void(0);" data-row="'.$id.'" class="reply-comment">Reply</a><a href="javascript:void(0);" data-row="'.$id.'" class="share-comment">Share</a></div>'.
							'</div>'.
						'</div>';
					}

					$json['content'] 		= $html;
				} else {
					$json['status'] = false;
					$json['code'] = '00';
				}
			} else {
				$json['status'] = false;
				$json['code'] = '01';
			}
		} else {
			$json['status'] = false;
			$json['code'] = '99';
		}

		echo json_encode($json);
	}

	public function postedit_comment() {
		date_default_timezone_set('Asia/Jakarta');
		$json 			= array();

		if (is_logged_in()) {
			$comments 		= $this->input->post('coment_input',true);
			$cmt 			= (int)$this->input->post('cmt',true);
			$row 			= $this->input->post('row',true);

			$extra = array(
				'comments'			=> $comments,
			);

			if ($this->article_m->update_data('article_comments', $extra, 'comments_id',$cmt)) {

				$json['status'] 		= true;
				$json['comment'] 		= $comments;
				$json['cmt'] 			= $cmt;
			} else {
				$json['status'] = false;
				$json['code'] = '00';
			}
		} else {
			$json['status'] = false;
			$json['code'] = '99';
		}

		echo json_encode($json);
	}

	private function indo_date($format, $date="now", $lang="id"){
		$en=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb",
		"Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

		$id=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu",
		"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September",
		"Oktober","November","Desember");

		return str_replace($en,$$lang,date($format,strtotime($date)));
	}

	public function article_share() {
		$id = (int)$this->input->post('article_item',true);
		$data_ = $this->article_m
					  ->where(array('article.article_id' => $id))
					  ->get_single_articles();

		if ($data_) {
			$new_data = array(
				'shared'=>(int)$data_->shared+1,
			);
			$this->article_m->update_data('article', $new_data, 'article_id', $data_->article_id);
		}
	}

	public function download_arfile() {
		$path 		= $this->input->post('path',true);
		$file 		= $this->input->post('file',true);
		$split_file = explode('.', $file);
		$href 		= $this->input->post('href',true);
		$fname 		= (array_key_exists('fname', $this->input->post())) ? $this->input->post('fname',true).'.'.$split_file[1] : $file;

		$data = file_get_contents(getcwd().'/'.$path.$file);
		force_download($fname, $data);
	}

	/* ARTICLE SEARCH */
	public function article_search()
	{
		$this->form_validation->set_rules('search', 'Pencarian', 'required|trim|xss_clean|htmlspecialchars|alpha_numeric');
		$this->form_validation->set_rules('milestone', 'Milestone', 'trim|xss_clean|htmlspecialchars|alpha_numeric');
		$this->form_validation->set_error_delimiters('<p class="text-xs-center lead">', '</p>');

		$keyword = '';
		$milestone = '';
		$total_search = 0;
		$articles = array();
		$param_articles = array(
			'limit'  => 10,
			'offset' => 0
		);
		if ($this->form_validation->run()) {
			$keyword = $this->input->post('search');
			$milestone = $this->input->post('milestone');

			if ($milestone && !empty($milestone)) {
				$param_articles['milestone'] = $milestone;
			}
		} else {
			$query 		= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_URL);
			$milestone 	= filter_input(INPUT_GET, 'milestone', FILTER_SANITIZE_URL);			
			$keyword 	= htmlspecialchars(xss_clean($query));
			$milestone 	= htmlspecialchars(xss_clean($milestone));

			if ($milestone && !empty($milestone)) {
				$param_articles['milestone'] = $milestone;
			}
		}

		$articles = $this->article_m->getArticlesByKeyword($keyword, $param_articles);
		// log_message('error', 'LAST_QUERY_SEARCH: '.$this->db->last_query());
		$total_search = $this->article_m->countArticlesByKeyword($keyword, $param_articles);
		$total_search = $total_search->count;

		$article_search_sess = array(
			'keyword'   => $keyword,
			'milestone' => $milestone,
			'count'     => $total_search - count($articles)
		);
		$this->session->set_userdata('article_search_sess', $article_search_sess);

		$tags_collection = $this->get_tags_by_milestone(0);

		$this->template
			->set_layout('default.html')
			 // ->title($data_->title)
			 // ->set_metadata('og:title', $data_->title, 'og')
			 // ->set_metadata('og:type', 'tips-and-tools-detail', 'og')
			 // ->set_metadata('og:url', base_url('artilce/'.$data_->slug), 'og')
			 // ->set_metadata('og:description', $data_->meta_desc, 'og')
			 // ->set_metadata('og:image', BASE_URL($data_->full_path), 'og')
			 // ->set_metadata('keywords', $data_->meta_keyword)
			 // ->set_metadata('robots', $meta_robots)
			 // ->set_metadata('description', $data_->meta_desc)
			 ->set('keyword', $keyword)
			 ->set('keywords', explode(' ', $keyword))
			 ->set('milestone', $milestone)
			 ->set('total_search', $total_search)
			 ->set('articles', $articles)
			 ->set('tags_collection', $tags_collection)
			 ->set('param_articles', $param_articles)
			 ->build('search_revamp');
	}

	public function article_search_more()
	{
		if ($this->input->is_ajax_request()) {
			$page = $this->input->post('page');
			$sess = $this->session->userdata('article_search_sess');

			$param_articles = array(
				'limit'  => 10,
				'offset' => ($page - 1) * 10
			);

			if (isset($sess['milestone']) && !empty($sess['milestone'])) {
				$param_articles['milestone'] = $sess['milestone'];
			}

			$articles = $this->article_m->getArticlesByKeyword($sess['keyword'], $param_articles);
			$total_search = count($articles);

			$article_search_sess = array(
				'keyword'   => $sess['keyword'],
				'milestone' => $sess['milestone'],
				'count'     => $sess['count'] - $total_search
			);
			$this->session->set_userdata('article_search_sess', $article_search_sess);

			$result = array(
				'count'    => $article_search_sess['count'],
				'articles' => $articles
			);

			echo json_encode($result);
			return;
		}

		redirect();
	}

	public function article_suggestion()
	{
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('search', 'Pencarian', 'required|trim|xss_clean|htmlspecialchars|alpha_numeric');

			$result = array(
				'status'  => false,
				'message' => 'Artikel tidak ditemukan'
			);

			if ($this->form_validation->run()) {
				$keyword = $this->input->post('search');
				$param_articles = array(
					'limit'  => 10,
					'offset' => 0
				);

				$articles = $this->article_m->getArticlesByKeyword($keyword, $param_articles);
				$data = array();

				if ($articles) {
					foreach ($articles as $key => $article) {
						$data[] = array(
							'title' => $article['title'],
							'slug'  => $article['slug'],
							'url'	=> site_url('smart-stories/'.$article['slug'])
						);
					}

					$result['status'] = true;
					$result['data'] = $data;
					$result['message'] = '';
				}
			}

			echo json_encode($result);
			return;
		}

		redirect();
	}

	function create_bitly($uri_segment=''){
		if($_SERVER['HTTP_HOST'] == 'localhost'){
			$url_shortner = 'https://www.parentingclub.co.id/'.$uri_segment;
		}else{
			$url_shortner = base_url($uri_segment);
		}

		$url = $this->bitly->shorten($url_shortner);
		return $url;
	}

	/* ARTICLE SEARCH */

	/*public function article_test()
    {
        $page = 13; // (624 / 50 = 12.48)
        $limit = 50;
        $offset = ($page - 1) * $limit;

        $articles = $this->db
            ->limit($limit, $offset)
            ->get('article_old')
            ->result_array();

        foreach ($articles as $old_article) {
            $category = '';
            $categories = explode(',', $old_article['tags_id']);
            foreach ($categories as $value) {
                if ($value != '') {
                    if ($value == 5) {
                        $category .= '9,';
                    }
                    if ($value == 6) {
                        $category .= '10,';
                    }
                    if ($value == 7) {
                        $category .= '11,';
                    }
                    if ($value == 8) {
                        $category .= '14';
                    }
                    if ($value == 9) {
                        $category .= '12,';
                    }
                    if ($value == 10) {
                        $category .= '13,';
                    }
                }
            }

            $kidsage = array();
            $kidsages = explode(',', $old_article['categories_id']);
            foreach ($kidsages as $value) {
                if ($value != '') {
                    if ($value == 3) {
                        $kidsage[] = 7;
                        $kidsage[] = 6;
                    }
                    if ($value == 2) {
                        $kidsage[] = 6;
                        $kidsage[] = 5;
                    }
                    if ($value == 1) {
                        $kidsage[] = 4;
                    }
                }
            }
            $kidsage = array_unique($kidsage);
            $kidsage = implode(',', $kidsage);

            $tanggal = $old_article['tahun'].'-'.$old_article['bulan'].'-'.$old_article['tgl'];

            $new_article = array(
                'title'         => $old_article['title'],
                'slug'          => $old_article['slug'],
                'filename'      => $old_article['filename'],
                'path'          => '',
                'full_path'     => '',
                'status'        => $old_article['status'],
                'description'   => $old_article['description'],
                'intro'         => $old_article['intro'],
                'authors_id'    => 0,
                'categories_id' => trim($category, ','),
                'kidsage_id'    => trim($kidsage, ','),
                'meta_keyword'  => $old_article['meta_keyword'],
                'meta_desc'     => $old_article['meta_desc'],
                'show_comments' => $old_article['show_comments'],
                'template'      => 'no-image',
                'created'       => date('Y-m-d H:i:s', strtotime($tanggal)),
                'created_on'    => strtotime($tanggal),
                'click'         => 0,
                'likes'         => 0,
                'bg_color'      => 'red',
            );

            $this->db->insert('article', $new_article);
            $last_id = $this->db->insert_id();

            $update = array(
                'path'      => 'uploads/default/files/article/'.$last_id.'/',
                'full_path' => 'uploads/default/files/article/'.$last_id.'/'.$new_article['filename'],
            );

            $this->db->update('article', $update, 'article_id = '.$last_id);

            $images = $this->db
                ->where('article_id', $last_id)
                ->get('article_old_images')
                ->result_array();

            if ($images) {
                foreach ($images as $old_image) {
                    if ($old_image['status'] != 'deleted') {
                        $new_files = array(
                            'article_id'    => $last_id,
                            'fname'         => '',
                            'filename'      => $old_image['filename'],
                            'full_path'     => 'uploads/default/files/article/'.$last_id.'/'.$old_image['filename'],
                            'as_background' => 0,
                            'path'          => '',
                        );

                        $this->db->insert('article_files', $new_files);
                    }
                }

                $random = array('thumb', '2-tile');
                $rand_key = array_rand($random, 1);
                $template = array('template' => $random[$rand_key]); // Req dari Ajeng
                $this->db->update('article', $template, 'article_id = '.$last_id);
            }
        }

        echo 'OK '.$page;
        return;
    }*/

    /*public function copy_image()
    {
    	$source = FCPATH.'/old-article-images';
    	$target = FCPATH.'/uploads/default/files/article';

    	// (355 / 50 = 7.1) - article_images
    	// (624 / 50 = 12.48) - article_images
    	$page = 13;
        $limit = 50;
        $offset = ($page - 1) * $limit;

    	// $files = $this->db
     //        ->select('article_id, filename')
     //        ->limit($limit, $offset)
     //        ->get('article_files')
     //        ->result_array();

        // $files = $this->db
        //     ->select('article_id, filename')
        //     ->where('article_id', 27)
        //     ->get('article_files')
        //     ->result_array();

      //   $articles = $this->db
    		// ->select('article_id, filename')
      //       ->limit($limit, $offset)
      //       ->get('article')
      //       ->result_array();

    	if (is_dir($source)) {
		    if ($dh = opendir($source)) {
		        while (($file = readdir($dh)) !== false) {
		        	if ($file != '.' && $file != '..') {
		        		foreach ($files as $image) {
		        			if ($image['filename'] == $file) {
		        				if (!is_dir($target.'/'.$image['article_id'])) {
									mkdir($target.'/'.$image['article_id'], 0775, true);
								}

								copy($source.'/'.$file, $target.'/'.$image['article_id'].'/'.$file);
		        			}
		        		}

		        		foreach ($articles as $image) {
		        			if ($image['filename'] == $file) {
		        				if (!is_dir($target.'/'.$image['article_id'])) {
									mkdir($target.'/'.$image['article_id'], 0775, true);
								}

								copy($source.'/'.$file, $target.'/'.$image['article_id'].'/'.$file);
		        			}
		        		}
		            }
		        }
		        closedir($dh);
		    }
		}

		echo 'OK '.$page;
		return;
    }*/

    public function milestone_landing()
    {
    	$slug = $this->uri->segment(1);
    	$milestone_data_id = $this->milestone->get_data_id();
    	$milestone_config = $this->config->item('article_route_milestone');
    	$milestone_copy = $this->config->item('article_copy_milestone');
    	$max_count = 3;

    	$parameter = array(
			'status'    => 'live',
			'order_by'  => array('article_id', 'DESC')
		);

		$pagination = array(
			'limit'  => 25,
			'offset' => 0
		);

    	if (array_key_exists($slug, $milestone_data_id)) {
    		$parameter['milestone'] = $milestone_data_id[$slug];
			$articles = $this->article_m->getDataArticle($parameter, $pagination)->result();

			$parameter['order_by'] = array('click', 'DESC');
			$articles_popular = $this->article_m->getDataArticle($parameter, $pagination)->result();

			foreach ($articles_popular as $key => $article) {
				$article->milestone = $this->article_m->get_milestone_for_article($article->kidsage_id);
			}

			$milestone_id = explode(',', $milestone_data_id[$slug]);
			$milestone = $this->milestone->get_data()[$slug];
			$template = 'milestone_landing_parent';

			foreach ($articles as $article) {
				$mids = explode(',', $article->kidsage_id);
				$article->milestone = $this->article_m->get_milestone_for_article($mids);
			}

			$feat_articles = $articles;
    	} else {
    		$milestone = $this->article_m->get_single_data('slug', $slug, 'article_kidsage');

    		if ($milestone && $milestone->status === 'live') {
    			$articles = $this->get_articles_by_milestone($milestone->kidsage_id, array('page' => 1));
    			$articles = $articles['data'];

    			$parameter['milestone'] = $milestone->kidsage_id;
    			$parameter['order_by'] = array('click', 'DESC');
				$articles_popular = $this->article_m->getDataArticle($parameter, $pagination)->result();

				foreach ($articles_popular as $key => $article) {
					$article->milestone = $this->article_m->get_milestone_for_article($article->kidsage_id);
				}

				$parameter['featured_milestone'] = 1;
				$parameter['categories'] = (int) $milestone->kidsage_id;
				unset($parameter['milestone']);

				$feat_articles = $this->article_m->get_many_articles($parameter);
				$feat_count = 0;

				foreach ($feat_articles as $key => $article) {
					$tmp = explode(',', $article->kidsage_id);

					if (in_array($milestone->kidsage_id, $tmp) && (int) $article->featured_milestone_pos > 0) {
						if ($feat_count > 2) {
							break;
						} else {
							$feat_count++;
						}
					} else {
						unset($feat_articles[$key]);
					}
				}

				$milestone_id = array($milestone->kidsage_id);
    			$template = 'milestone_landing_children';
    		} else {
    			redirect();
    		}
    	}

    	return $this->template
    		->set_layout('default.html')
    		->append_css('theme::p-milestone.css')
    		->set('slug', $slug)
    		->set('articles', $articles)
    		->set('feat_articles', $feat_articles)
    		->set('articles_popular', $articles_popular)
    		->set('tags_collection', $this->get_tags_by_milestone($milestone_id))
    		->set('milestone_id', $milestone_id)
    		->set('milestone_data_id', $milestone_data_id)
    		->set('milestone_data', $milestone)
    		->set('milestone_config', $milestone_config)
    		->set('milestone_copy', $milestone_copy)
    		->set('timezone', isset($_COOKIE['tzu']) ? $this->security->xss_clean($_COOKIE['tzu']) : '')
    		->set('max_count', $max_count)
    		->build($template);
    }

    public function milestone_list()
    {
    	$slug = $this->uri->segment(1);
    	$milestone_data_id = $this->milestone->get_data_id();

    	if (array_key_exists($slug, $milestone_data_id)) {
    		$milestone_id = $milestone_data_id[$slug];
    		$milestone_id_data = explode(',', $milestone_id);
			$milestone_id_param = array();

			foreach ($milestone_id_data as $key => $value) {
				$milestone_id_param[] = (int) $value;
			}

    		$milestone_title = ucwords($slug);
    	} else {
    		$milestone = $this->article_m->get_single_data('slug', $slug, 'article_kidsage');

    		if ($milestone && $milestone->status === 'live') {
    			$milestone_id = (int) $milestone->kidsage_id;
    			$milestone_id_param = array($milestone_id);
    			$milestone_title = $milestone->title;
	    	} else {
	    		redirect();
	    	}
    	}

    	$articles = $this->get_articles_by_milestone($milestone_id_param, array('page' => 1));
    	$next = $this->get_articles_by_milestone($milestone_id_param, array('page' => 2));
    	$next = count((array) $next['data']);
    	$tools_banner = $this->get_tools_banner_collection($milestone_id_param);
    	$repetition_counter = count($tools_banner);

    	$params_category = array(
    		'status' => 'live',
    		// 'milestone' => $milestone_id_param
    	);
    	$categories = $this->article_m->get_many_category($params_category);

    	return $this->template
    		->set_layout('default.html')
    		->append_css('theme::p-article.css')
    		->append_js('module::milestone_article.js')
    		->set('milestone_id', $milestone_id)
    		->set('milestone_title', $milestone_title)
    		->set('articles', $articles['data'])
    		->set('pagination', $articles['pagination'])
    		->set('tools_banner', $tools_banner)
    		->set('repetition_counter', $repetition_counter)
    		->set('timezone', isset($_COOKIE['tzu']) ? $this->security->xss_clean($_COOKIE['tzu']) : '')
    		->set('categories', $categories)
    		->set('next', $next)
    		->build('milestone_list');
    }

    public function milestone_load_more()
    {
		if ($this->input->is_ajax_request()) {
			$milestone_id = $this->input->post('milestone_id');
			$milestone_id_data = explode(',', $milestone_id);
			$milestone_id_param = array();

			foreach ($milestone_id_data as $key => $value) {
				$milestone_id_param[] = (int) $value;
			}

			$category = $this->input->post('category');
			$sort = $this->input->post('sort');
			$load_type = $this->input->post('load_type');
			$params = array();

			if ($load_type == 'load-more') {
				$params['page'] = (int) $this->input->post('page') + 1;
			} elseif ($load_type == 'load-new') {
				$params['page'] = 1;
			}

			if (isset($category) && !empty($category)) {
				$params['category'] = $category;
	    	}

	    	if (isset($sort) && !empty($sort)) {
	    		$params['sort'] = $sort;
	    	}

	    	$articles = $this->get_articles_by_milestone($milestone_id_param, $params);
	    	$tools_banner = $this->get_tools_banner_collection($milestone_id_param);
	    	$repetition_counter = count($tools_banner);

	    	$params['page'] = $params['page'] + 1;
	    	$next = $this->get_articles_by_milestone($milestone_id_param, $params);
    		$next = count((array) $next['data']);

	    	$result = array(
				'milestone_id'       => $milestone_id,
				'articles'           => $articles['data'],
				'tools_banner'       => $tools_banner,
				'repetition_counter' => $repetition_counter,
				'pagination' 		 => $articles['pagination'],
				'next' 		 		 => $next
	    	);

	    	echo json_encode($result);
	    	return;
		}
    }

    private function get_tools_banner_collection($milestone_id)
    {
    	$tools_parameter = array(
    		'status'     => 'live',
			'order_by'   => array('order', 'ASC'),
			'milestone'  => $milestone_id,
			'user_login' => $this->current_user ? true : false,
			'section'    => 'home'
    	);

    	return $this->article_m->get_tools_banner_list($tools_parameter);
    }

    private function get_articles_by_milestone($milestone_id, $params = array())
    {
    	$page = isset($params['page']) ? (int) $params['page'] : 1;
		$page_limit = 8;
		$timezone = isset($_COOKIE['tzu']) ? $this->security->xss_clean($_COOKIE['tzu']) : 'Asia/Jakarta';

		$pagination = array(
			'limit'        => $page_limit,
			'offset'       => $page <= 1 ? 0 : ($page * $page_limit) - $page_limit,
			'current_page' => $page
		);

		$parameter = array(
			'status'     => 'live',
			'order'      => array('article_id', 'DESC')
    	);

    	if (isset($params['page'])) {
    		$parameter['limit'] = array($pagination['limit'], $pagination['offset']);
    	}

    	if (is_array($milestone_id)) {
    		$parameter['milestone'] = $milestone_id;
    	} elseif (is_string($milestone_id)) {
    		$parameter['categories'] = (int) $milestone_id;
    	}

    	if (isset($params['category'])) {
    		$parameter['ages'] = $params['category'];
    	}

    	if (isset($params['sort'])) {
    		if ($params['sort'] == 'popular') {
    			$parameter['order'] = array('click', 'DESC');
    		}
    	}

    	$articles = $this->article_m->get_many_articles($parameter);

    	foreach ($articles as $key => $article) {
    		$article->formatted_time = calculate_article_time($article->created, $timezone);
    	}

    	return array(
    		'data'       => $articles,
    		'pagination' => $pagination
    	);
    }

    private function get_tags_by_milestone($milestone)
    {
    	$month = date('m');
    	$year = date('Y');
    	$date_start = $year.'-'.$month.'-01 00:00:00';
    	$date_end = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    	$date_end = $year.'-'.$month.'-'.$date_end.' 23:59:59';
    	// $trending = $this->article_m->get_most_article_subscribe(0, $date_start, $date_end, array(), 10);
    	$trending = $this->article_m->get_most_article_alternate(0, $milestone, $date_start, $date_end, array(), 10);
    	$tags_collection = '';

    	foreach ($trending->result() as $article) {
    		if (!empty($article->tags)) {
	    		$tags_collection .= ','.$article->tags;
    		}
    	}

    	$tags_collection = explode(',', ltrim($tags_collection, ','));
    	$tags_collection = array_unique($tags_collection);
    	$tags_counter = count($tags_collection);
    	$tags_max_count = 7;

    	if ($tags_counter > $tags_max_count) {
    		for ($i = $tags_max_count; $i < $tags_counter; $i++) {
    			unset($tags_collection[$i]);
    		}
    	}

    	return $tags_collection;
    }

    public function details_load_more()
    {
    	if ($this->input->is_ajax_request()) {
    		$params = $this->session->userdata('article_detail_selections_params');
    		$base_where = array();

			if ($params) {
				$base_where['categories'] = $params['categories'];
				$base_where['kidsage'] = $params['kidsage'];
				$base_where['limit'] = 1;
				$base_where['random'] = true;

				$data = $this->get_article_details_tmp($base_where);

			   	if ($data) {
			   		$data_author = $this->article_m
						->join('profiles', 'users.id = profiles.user_id', 'left')
						->get_single_data('users.id', $data->authors_id, 'users');

					if ($data_author) {
						$data_author->photo_profile = (isset($data_author->photo_profile)) ? base_url($data_author->photo_profile) : base_url('uploads/default/files/no-available-image.png');
						$data_author->tw_screen_name = (isset($data_author->tw_screen_name)) ? 'https://twitter.com/'.$data_author->tw_screen_name : $data_author->tw_screen_name;
						$data_author->tw_id = (isset($data_author->tw_id)) ? 'https://twitter.com/intent/user?user_id='.$data_author->tw_id : $data_author->tw_id;
						$data_author->fb_id = (isset($data_author->fb_id)) ? 'https://twitter.com/intent/user?user_id='.$data_author->fb_id : $data_author->fb_id;
					} else {
						$data_author = new \stdClass;
						$data_author->first_name = '';
						$data_author->last_name = '';
						$data_author->profesi = '';
						$data_author->bio = '';
						$data_author->photo_profile = '';
						$data_author->tw_screen_name = '';
						$data_author->tw_id = '';
						$data_author->fb_id = '';
						$data_author->username = '';
					}

					$data_files = $this->article_m
						->where(array('article_id' => $data->article_id, 'ftype' => 'file'))
						->get_all_data('article_files');

					$data_imgs = $this->article_m
						->where(array('article_id' => $data->article_id, 'ftype' => 'img'))
						->get_all_data('article_files');

					$data_video = $this->article_m
						->where(array('article_id' => $data->article_id, 'ftype' => 'video'))
						->get_all_data('article_files');

			 		$data_youtube = $this->article_m
						->where(array('article_id' => $data->article_id, 'ftype' => 'youtube'))
						->get_all_data('article_files');

			   		$base_where['not_article_id'] = $data->article_id;
			   		$base_where['limit'] = 6;

			   		$data_others = (array) $this->article_m->get_related_articles($base_where);
			   		$timezone = isset($_COOKIE['tzu']) ? $this->security->xss_clean($_COOKIE['tzu']) : '';

			   		// ADS
					$milestone_data = explode(',', $data->kidsage_id);
					$milestone_param = array();

					foreach ($milestone_data as $key => $value) {
						$milestone_param[] = (int) $value;
					}

					$parameter = array(
						'milestone' => $milestone_param,
						'status'    => 'live',
						'limit'     => 1
					);

					$this->db->reset_query();
					$ads = $this->article_m->get_many_articles_ads($parameter);
					// ADS

					// AE
					$this->load->model('ask_expert/ask_expert_m');
					$this->load->helper('parenting');

					$milestone_title = array();
					$milestone_data_id = $this->milestone->get_data_id();

					if (count($milestone_data) == 1) {
						foreach ($milestone_data_id as $key => $value) {
							$items = explode(',', $value);

							foreach ($items as $item) {
								if ($item == $milestone_data[0]) {
									$milestone_title[] = $key;
									break;
								}
							}
						}
					} elseif (count($milestone_data > 1)) {
						foreach ($milestone_data_id as $key => $value) {
							if ($data->kidsage_id == $value) {
								$milestone_title[] = $key;
							}
						}
					}

					// $ids = array();
					$ask_params = array(
						'milestone_ids' => $milestone_param,
						'limit' => 3,
						'offset' => 0
					);
					$asks_popular = $this->ask_expert_m->get_ask($ask_params);

					// Ambil milestone pertama
					// if ($milestone_title && isset($milestone_title[0])) {
					// 	$ids = $this->config->item('sc_static_ids')[$milestone_title[0]];
					// 	$ids = explode(',', $ids);
					// }

					$milestone_title = array_unique($milestone_title);

					// foreach ($ids as $id) {
					// 	$tmp = $this->ask_expert_m->get_ask(array('ask_id' => $id));

					// 	if ($tmp && isset($tmp[0])) {
					// 		$asks_popular[] = $tmp[0];
					// 	}
					// }

					foreach ($asks_popular as $ask) {
						$ask_comments = $this->ask_expert_m->get_ask_comments(array('arid' => $ask->ask_id));

						$ask->formatted_date = calculate_article_time($ask->ask_time, $timezone);
						$ask->comment_count = count($ask_comments);
						$ask->comments = $ask_comments;
					}
					// AE

					if (!empty($data->description)) {
						$dom = new DOMDocument;
						libxml_use_internal_errors(true);
						$dom->loadHTML($data->description);
						libxml_use_internal_errors(false);
						$preview = $dom->getElementsByTagName('article_preview');
						if($preview->length!=0) {
							foreach ($preview as $key) {
								$aticleFunc =$arrTitle = $arrId = array();
								// $plugin = $preview->item(0)->textContent;
								$plugin = $key->textContent;
								// preg_match( '/article:"([^"]*)"/i', $plugin, $aticleFunc);
								preg_match( '/tool_title="([^"]*)"/i', $plugin, $arrTitle);
								preg_match( '/tool_id="([^"]*)"/i', $plugin, $arrId);

								$previewContent = $this->plugin_tools_section_on_detail($arrId[1], $arrTitle[1]);
								$previewDom = new DOMDocument;
								libxml_use_internal_errors(true);
								$previewDom->loadHTML($previewContent);

								$previewContent = $this->plugin_tools_section_on_detail($arrId[1], $arrTitle[1]);
								// $preview->item(0)->nodeValue = '';
								// $preview->item(0)->appendChild($dom->importNode($previewDom->documentElement, true));
								$key->nodeValue = '';
                                $key->appendChild($dom->importNode($previewDom->documentElement, true));
							}

							$html = $dom->saveHTML();
							preg_match("/<body[^>]*>(.*?)<\/body>/is", $html);
							$data->description = $html;
						}
					}

			   		echo $this->load->view('detail_load_more', array(
						'data'            => $data,
						'data_author'     => $data_author,
						'data_files'      => $data_files,
						'data_imgs'       => $data_imgs,
						'data_video'      => $data_video,
						'data_youtube'    => $data_youtube,
						'data_others'     => $data_others,
						'timezone'        => $timezone,
						'ads'             => (array) $ads,
						'asks_popular'    => $asks_popular,
						'milestone_title' => $milestone_title
			   		), true);
			   		return;
			   	}
			}
    	}
    }

    private function get_article_details_tmp($params)
    {
    	$selections = $this->session->userdata('article_detail_selections');
    	$total = $this->session->userdata('article_detail_selections_total');
    	$articles = (array) $this->article_m->get_related_articles($params);

    	if ($articles) {
    		$data = current($articles);

    		if (!in_array($data->article_id, $selections)) {
	   			$selections[] = $data->article_id;

	   			$this->session->set_userdata('article_detail_selections', $selections);

	   			return $data;
	   		} else {
	   			if ($total == count($selections)) {
	   				return false;
	   			} else {
	   				return $this->get_article_details_tmp($params);
	   			}
	   		}
    	}

    	return false;
    }

    private function plugin_tools_section_on_detail($id = 0, $title = '')
	{
		$tools = array();

		if (!empty($id) && !empty($title)) {
			$tools_parameter = array(
				'status'     => 'live',
				'order_by'   => array('order', 'ASC'),
				'id' 		 => $id,
				'title' 	 => $title,
				'limit'		 => 1
			);

			$this->db->reset_query();
			$tools = $this->article_m->get_tools_banner_list($tools_parameter);
			$tools = $tools ? $tools[0] : array();
		}

		return $this->load->view('article/plugin/tools_banner_detail', array('tools' => $tools), true);
	}
}
