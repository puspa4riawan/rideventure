<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Article Plugin
 *
 *
 * @author   yudiantara.gde@gmail.com
 * @package  MaxCMS\Core\Modules\Article\Plugins
 */
class Plugin_article extends Plugin
{

	public $version = '1.0.0';

	public $name = array(

		'en' => 'Article Plugin',
		'id' => 'Plugin Artikel'
	);

	public $description = array(

		'en' => 'Plugin for Display Post',
		'id' => 'Plugin untuk Menampilkan Pos'
	);

	public function list_article_home() {

		$this->load->model('article_m');

		$data_ = $this->article_m
					  ->where(array('article.status' => 'live'))
					  ->order_by('article.article_id','DESC')
					  ->limit(4)
					  ->get_all_articles();

		return $this->load->view('article/plugin/list-article',array('data_' => $data_), true);
	}

	public function get_ages() {

		$this->load->model('article_m');

		$data_ = $this->article_m
					  ->where(array('status' => 'live'))
					  ->order_by('sort_no','ASC')
					  ->get_all_data('article_categories');

		return $this->load->view('article/plugin/list-ages',array('data_' => $data_), true);
	}

	public function get_categories() {

		$this->load->model('article_m');

		$data_ = $this->article_m
					  ->where(array('status' => 'live'))
					  ->order_by('sort_by','ASC')
					  ->get_all_data('article_kidsage');

		return $this->load->view('article/plugin/list-kidsage',array('data_' => $data_), true);
	}

	public function get_all_click() {

		$this->load->model('article_m');

		$ages = $this->article_m
					  ->where(array('status' => 'live'))
					  ->order_by('sort_no','ASC')
					  ->get_all_data('article_categories');

		$cats = $this->article_m
					  ->where(array('status' => 'live'))
					  ->order_by('sort_by','ASC')
					  ->get_all_data('article_kidsage');

		return $this->load->view('article/plugin/list-all-click',array('ages' => $ages, 'cats' => $cats), true);
	}

	public function get_all_landing() {

		$this->load->model('article_m');

		$ages = $this->article_m
					  ->where(array('status' => 'live'))
					  ->order_by('sort_no','ASC')
					  ->get_all_data('article_categories');

		$cats = $this->article_m
					  ->where(array('status' => 'live'))
					  ->order_by('sort_by','ASC')
					  ->get_all_data('article_kidsage');

		return $this->load->view('article/plugin/list-landing',array('ages' => $ages, 'cats' => $cats), true);
	}

	public function get_home() {
		$this->load->model('article_m');

		$ages = $this->article_m
					  ->where(array('status' => 'live'))
					  ->order_by('sort_no','ASC')
					  ->get_all_data('article_categories');

		$cats = $this->article_m
					  ->where(array('status' => 'live'))
					  ->order_by('sort_by','ASC')
					  ->get_all_data('article_kidsage');

		$id_ages = array();
		$id_cats = array();
		$data_usr = false;

		$pagination = array("limit"=>4, "offset"=>0);
		if($this->current_user){
			$params = array(
				"order_by" => array('article_id', 'DESC'),
				"status" => 'live',
			);

			$data_ages 	=  $this->article_m
								->where(array('user_id' => $this->current_user->id))
								->get_all_data('user_ages');
			$id_ages =  array_map(function ($entry) {
	                        return $entry->ages_id;
	                  	}, $data_ages);

			$data_cats 	=  $this->article_m
								->where(array('user_id' => $this->current_user->id))
								->get_all_data('user_category');
			$id_cats =  array_map(function ($entry) {
	                        return $entry->kidsage_id;
	                  	}, $data_cats);

			$data_ = $this->article_m->getDataArticleByUser($this->current_user->id, $params, $pagination)->result();
			$data_usr = true;
		}else{
			$params = array(
				"order_by" => array('a.article_id', 'DESC'),
				"status" => 'live',
			);

			$data_ = $this->article_m->getDataArticle($params, $pagination)->result();
		}

		return $this->load->view('article/plugin/article-home',array('ages' => $ages, 'cats' => $cats, 'data_' => $data_, 'data_usr' => $data_usr, 'id_cats' => $id_cats, 'id_ages' => $id_ages), true);
	}

	public function tools_section_on_homepage()
	{
		$this->load->model('article_m');

		$tools_parameter = array(
    		'status'     => 'live',
			'order_by'   => array('order', 'ASC'),
			// 'milestone'  => (int) $milestone_id,
			'user_login' => $this->current_user ? true : false,
			'section'    => 'home'
    	);

    	$tools = $this->article_m->get_tools_banner_list($tools_parameter);

		return $this->load->view('article/plugin/tools_banner_homepage', array('tools' => $tools), true);
	}

	public function tools_section_on_landing()
	{
		$this->load->model('article_m');

		$milestone = $this->attribute('milestone');
		$tools_parameter = array(
    		'status'     => 'live',
			'order_by'   => array('order', 'ASC'),
			'milestone'  => explode(',', $milestone),
			'user_login' => $this->current_user ? true : false,
			'section'    => 'home'
    	);

		$tools = $this->article_m->get_tools_banner_list($tools_parameter);

		return $this->load->view('article/plugin/tools_banner_landing', array('tools' => $tools), true);
	}

	public function tools_section_on_detail()
	{
		$this->load->model('article_m');

		$id = $this->attribute('tool_id') ? $this->attribute('tool_id') : '';
		$title = $this->attribute('tool_title') ? $this->attribute('tool_title') : '';
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