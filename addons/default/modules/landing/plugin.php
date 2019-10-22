<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Landing Plugin
 *
 *
 * @package  MaxCMS\Core\Modules\Landing\Plugins
 */
class Plugin_landing extends Plugin
{

	public $version = '1.0.0';

	public $name = array(

		'en' => 'Landing Plugin',
		'id' => 'Plugin Landing'
	);

	public $description = array(

		'en' => 'Plugin landing page',
		'id' => 'Plugin landing page'
	);

	// public function list_article_home() {

	// 	$this->load->model('article_m');

	// 	$data_ = $this->article_m
	// 				  ->where(array('article.status' => 'live'))
	// 				  ->order_by('article.article_id','DESC')
	// 				  ->limit(4)
	// 				  ->get_all_articles();

	// 	return $this->load->view('article/plugin/list-article',array('data_' => $data_), true);
	// }
}