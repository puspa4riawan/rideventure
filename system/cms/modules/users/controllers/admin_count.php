<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the users module
 *
 * @author		 MaxCMS Dev Team
 * @package	 MaxCMS\Core\Modules\Users\Controllers
 */
class Admin_count extends Admin_Controller
{

	protected $section = 'count';

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->model(array('profile_m'));
	}

	/**
	 * List all users
	 */
	public function index()
	{
		$base_where = array();

		/*if($this->input->post('f_kids')){
			$base_where['kids'] = $this->input->post('f_kids');
		}

		if($this->input->post('f_kidsage')){
			$base_where['kidsage'] = $this->input->post('f_kidsage');
		}*/

		if($this->input->post('f_from')){
			$base_where['from'] = $this->input->post('f_from');
		}

		if($this->input->post('f_to')){
			$base_where['to'] = $this->input->post('f_to');
		}

		//one kid 0-2year
		$base_where['kids'] = 1;
		$base_where['kidsage'] = 1;
		$total_onekid_02year = $this->profile_m->get_count($base_where)->num_rows();

		//one kid 3-4year
		$base_where['kids'] = 1;
		$base_where['kidsage'] = 2;
		$total_onekid_34year = $this->profile_m->get_count($base_where)->num_rows();

		//one kid 5-6year
		$base_where['kids'] = 1;
		$base_where['kidsage'] = 3;
		$total_onekid_56year = $this->profile_m->get_count($base_where)->num_rows();

		//two kids 0-2year
		$base_where['kids'] = 2;
		$base_where['kidsage'] = 1;
		$total_twokids_02year = $this->profile_m->get_count($base_where)->num_rows();

		//two kids 3-4year
		$base_where['kids'] = 2;
		$base_where['kidsage'] = 2;
		$total_twokids_34year = $this->profile_m->get_count($base_where)->num_rows();

		//two kids 5-6year
		$base_where['kids'] = 2;
		$base_where['kidsage'] = 3;
		$total_twokids_56year = $this->profile_m->get_count($base_where)->num_rows();

		//three kids 0-2year
		$base_where['kids'] = 3;
		$base_where['kidsage'] = 1;
		$total_threekids_02year = $this->profile_m->get_count($base_where)->num_rows();

		//three kids 3-4year
		$base_where['kids'] = 3;
		$base_where['kidsage'] = 2;
		$total_threekids_34year = $this->profile_m->get_count($base_where)->num_rows();

		//three kids 5-6year
		$base_where['kids'] = 3;
		$base_where['kidsage'] = 3;
		$total_threekids_56year = $this->profile_m->get_count($base_where)->num_rows();

		$nokid = $this->profile_m->nokid_count($base_where)->num_rows();
		$pregnant = $this->profile_m->pregnant_count($base_where)->row('count');

		// Unset the layout if we have an ajax request
		if ($this->input->is_ajax_request()){
			$this->template->set_layout(false);
		}

		// Render the view
		$this->template
			->title($this->module_details['name'])
			->set('total_onekid_02year', $total_onekid_02year)
			->set('total_onekid_34year', $total_onekid_34year)
			->set('total_onekid_56year', $total_onekid_56year)
			->set('total_twokids_02year', $total_twokids_02year)
			->set('total_twokids_34year', $total_twokids_34year)
			->set('total_twokids_56year', $total_twokids_56year)
			->set('total_threekids_02year', $total_threekids_02year)
			->set('total_threekids_34year', $total_threekids_34year)
			->set('total_threekids_56year', $total_threekids_56year)
			->set('nokid', $nokid)
			->set('pregnant', $pregnant)
			->set_partial('filters', 'admin_count/partials/filters')
			->append_js('admin/filter.js');

		$this->input->is_ajax_request() ? $this->template->build('admin_count/tables/table') : $this->template->build('admin_count/index');
	}
}