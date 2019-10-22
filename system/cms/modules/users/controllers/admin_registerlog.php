<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the users module
 *
 * @author		 MaxCMS Dev Team
 * @package	 MaxCMS\Core\Modules\Users\Controllers
 */
class Admin_registerlog extends Admin_Controller
{

	protected $section = 'register_log';

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->model('profile_m');
	}

	/**
	 * List all users
	 */
	public function index()
	{
		$base_where = array();

		if($this->input->post('f_keywords')){
			$base_where['keywords'] = $this->input->post('f_keywords');
		}

		if($this->input->post('f_from')){
			$base_where['from'] = (int)$this->input->post('f_from');
		}

		if($this->input->post('f_to')){
			$base_where['to'] = $this->input->post('f_to');
		}

		// Create pagination links
		$total_rows = $this->profile_m->get_log('register', $base_where)->num_rows();
		$pagination = create_pagination(ADMIN_URL.'/users/register_log/index', $total_rows, Settings::get('records_per_page'), 5);

		// Using this data, get the relevant results
		$this->db->limit($pagination['limit'], $pagination['offset']);
		$log = $this->profile_m->get_log('register', $base_where)->result();

		// Unset the layout if we have an ajax request
		if ($this->input->is_ajax_request()){
			$this->template->set_layout(false);
		}

		// Render the view
		$this->template
			->title($this->module_details['name'])
			->set('pagination', $pagination)
			->set('data_', $log)
			->set('total_rows', $total_rows)
			->set_partial('filters', 'admin_registerlog/partials/filters')
			->append_js('admin/filter.js');

		$this->input->is_ajax_request() ? $this->template->build('admin_registerlog/tables/table') : $this->template->build('admin_registerlog/index');
	}

	public function resolve(){
		if($this->input->is_ajax_request()){
			$id = $this->input->post('id');

			$data = $this->profile_m->get_single_log('register_log', array('register_log.id'=>$id));
			if($data){
				switch ($data->reason) {
					case 'Email already exists':
						$message = 'This email is registered, please try to login.';
						break;

					case 'Phone Number already exists':
						$message = 'This Phone Number ('.$data->phone.'), already registered with email '.$data->email_reg;
						break;

					default:
						$message = "Can't Resolve!";
						break;
				}

				echo json_encode(array('message'=>$message));
			}
		}
	}
}